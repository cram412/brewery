<?php
declare(strict_types=1);

namespace Cram\BreweryApi\Api;

/**
 * TODO: Implement other REST related methods
 *
 * Interface BreweryRepositoryInterface
 *
 * @package Cram\BreweryApi\Api
 */
interface BreweryRepositoryInterface
{
    /**
     * @return array
     * @throws \HttpRequestException If data could not be received
     */
    public function get($methodName, $data = []): array;
}