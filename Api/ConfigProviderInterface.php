<?php
declare(strict_types=1);

namespace Cram\BreweryApi\Api;

use Magento\Framework\Exception\LocalizedException;

/**
 * Interface ConfigProviderInterface
 *
 * @package Cram\BreweryApi\Api
 */
interface ConfigProviderInterface
{
    /**
     * @return string
     * @throws LocalizedException If api url is not set
     */
    public function getUrl(): string;

    /**
     * @return string
     * @throws LocalizedException If api key is not set
     */
    public function getApiKey(): string;
}