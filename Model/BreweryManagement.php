<?php
declare(strict_types=1);

namespace Cram\BreweryApi\Model;

use Cram\BreweryApi\Api\BreweryManagementInterface;
use Cram\BreweryApi\Api\DataProviderInterface;
use Cram\BreweryApi\Api\ProductMapperInterface;
use Magento\Catalog\Api\Data\ProductInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\State as AppState;

/**
 * Class BreweryManagement
 * @package Cram\BreweryApi\Model
 */
class BreweryManagement implements BreweryManagementInterface
{
    /**
     * @var DataProviderInterface
     */
    private $dataProvider;

    /**
     * @var ProductInterfaceFactory
     */
    private $productFactory;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ProductMapperInterface
     */
    private $productMapper;

    /**
     * @var AppState
     */
    private $appState;

    /**
     * BreweryManagement constructor.
     *
     * @param ProductInterfaceFactory $productFactory
     * @param ProductMapperInterface $productMapper
     * @param ProductRepositoryInterface $productRepository
     * @param DataProviderInterface $dataProvider
     * @param AppState $appState
     */
    public function __construct
    (
        ProductInterfaceFactory $productFactory,
        ProductMapperInterface $productMapper,
        ProductRepositoryInterface $productRepository,
        DataProviderInterface $dataProvider,
        AppState $appState
    )
    {
        $this->dataProvider = $dataProvider;
        $this->productFactory = $productFactory;
        $this->productRepository = $productRepository;
        $this->productMapper = $productMapper;
        $this->appState = $appState;
    }

    /**
     * @inheritdoc
     */
    public function import()
    {
        $currentPage = 1;
        $pages = $this->dataProvider->getPagesCount();
        do {
            $apiProducts = $this->dataProvider->getProducts($currentPage);
            foreach ($apiProducts as $apiProductData) {
                $product = $this->productMapper->getMappedProduct($apiProductData);
                $this->appState->emulateAreaCode(Area::AREA_ADMINHTML, function() use ($product) {
                    $this->productRepository->save($product);
                });
            }
            $currentPage++;
        } while ($currentPage <= $pages);
    }
}