<?php
declare(strict_types=1);

namespace Cram\BreweryApi\Api;

/**
 * Interface BreweryManagementInterface
 *
 * @package Cram\BreweryApi\Api
 */
interface BreweryManagementInterface
{
    /**
     * Process the import
     *
     * @return void
     */
    public function import();
}