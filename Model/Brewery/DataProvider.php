<?php
declare(strict_types=1);

namespace Cram\BreweryApi\Model\Brewery;

use Cram\BreweryApi\Api\BreweryRepositoryInterface;
use Cram\BreweryApi\Api\DataProviderInterface;

/**
 * Class DataProvider
 *
 * @package Cram\BreweryApi\Model\Brewery
 */
class DataProvider implements DataProviderInterface
{
    const REST_BEERS_COMMAND = 'beers';

    /**
     * @var BreweryRepositoryInterface
     */
    private $breweryRepository;

    /**
     * @var int
     */
    protected $pageCount = 0;

    /**
     * @var int
     */
    protected $totalResults = 0;

    /**
     * @var array
     */
    protected $productsRegistryByPage = [];

    /**
     * DataProvider constructor.
     *
     * @param BreweryRepositoryInterface $breweryRepository
     */
    public function __construct(
        BreweryRepositoryInterface $breweryRepository
    )
    {
        $this->breweryRepository = $breweryRepository;
    }

    /**
     * @inheritdoc
     */
    public function getProducts(int $currentPage = 1): array
    {
        if (isset($this->productsRegistryByPage[$currentPage])) {
            return $this->productsRegistryByPage[$currentPage];
        }
        $data = $this->breweryRepository->get(self::REST_BEERS_COMMAND, ['availableId' => 1, 'p' => $currentPage]);
        if (isset($data['numberOfPages'])) {
            $this->pageCount = (int)$data['numberOfPages'];
        }
        if (isset($data['totalResults'])) {
            $this->totalResults = $data['totalResults'];
        }
        $this->productsRegistryByPage[$currentPage] = [];
        foreach ($data['data'] as $product) {
            $this->productsRegistryByPage[$currentPage][] = $product;
        }
        return $this->productsRegistryByPage[$currentPage];
    }

    /**
     * @inheritdoc
     */
    public function getPagesCount(): int
    {
        if ($this->pageCount < 1) {
            $this->getProducts();
        }

        return $this->pageCount;
    }
}