<?php
declare(strict_types=1);

namespace Cram\BreweryApi\Model;

use Cram\BreweryApi\Api\ProductMapperInterface;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductInterfaceFactory;
use Magento\Catalog\Model\Product\Type;
use Magento\Catalog\Model\Product\Visibility;

use Magento\Store\Api\WebsiteRepositoryInterface;

/**
 * Class BeerMapper
 *
 * @package Cram\BreweryApi\Model
 */
class BeerMapper implements ProductMapperInterface
{
    protected $mappingConfig = [
        'name' => 'name',
        'description' => 'description',
        'id' => 'sku',
        'abv' => 'abv'
    ];

    const FIXED_PRICE = 5;
    const FIXED_STOCK = 100;

    /**
     * @var ProductInterfaceFactory
     */
    private $productFactory;

    /**
     * @var WebsiteRepositoryInterface
     */
    private $websiteRepository;

    /**
     * BeerMapper constructor.
     *
     * @param ProductInterfaceFactory $productFactory
     * @param WebsiteRepositoryInterface $websiteRepository
     */
    public function __construct(
        ProductInterfaceFactory $productFactory,
        WebsiteRepositoryInterface $websiteRepository
    )
    {
        $this->productFactory = $productFactory;
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * @inheritdoc
     */
    public function getMappedProduct(array $data): ProductInterface
    {
        /** @var ProductInterface $product */
        $product = $this->productFactory->create();
        foreach ($this->mappingConfig as $apiKey => $magentoKey) {
            if (isset($data[$apiKey])) {
                $product->setData($magentoKey, $data[$apiKey]);
            }
        }
        $this->addDefaultAttributes($product);
        return $product;
    }

    /**
     * @param ProductInterface $product
     */
    protected function addDefaultAttributes(ProductInterface $product)
    {
        $product->addData([
            'price' => self::FIXED_PRICE,
            'stock_data' => [
                'is_in_stock' => true,
                'qty' => self::FIXED_STOCK
            ],
            'type_id' => Type::TYPE_SIMPLE,
            'visibility' => Visibility::VISIBILITY_BOTH,
            'website_id' => $this->websiteRepository->getDefault()->getId(),
        ]);
        $product->setAttributeSetId($product->getDefaultAttributeSetId());
    }
}