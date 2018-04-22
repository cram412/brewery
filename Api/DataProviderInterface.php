<?php
declare(strict_types=1);

namespace Cram\BreweryApi\Api;

/**
 * Interface DataProviderInterface
 *
 * @package Cram\BreweryApi\Api
 */
interface DataProviderInterface
{
    /**
     * Returns an array with products
     *
     * @param int $currentPage
     * @return array
     */
    public function getProducts(int $currentPage = 1): array;

    /**
     * Returns the page count
     *
     * @return int
     */
    public function getPagesCount(): int;
}