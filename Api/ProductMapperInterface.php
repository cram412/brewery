<?php
declare(strict_types=1);

namespace Cram\BreweryApi\Api;

use Magento\Catalog\Api\Data\ProductInterface;

/**
 * Interface ProductMapperInterface
 *
 * @package Cram\BreweryApi\Api
 */
interface ProductMapperInterface
{
    /**
     * Returns product after mapping apply
     *
     * @param array $data
     * @return ProductInterface
     */
    public function getMappedProduct(array $data): ProductInterface;
}