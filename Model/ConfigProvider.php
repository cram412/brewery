<?php
namespace Cram\BreweryApi\Model;

use Cram\BreweryApi\Api\ConfigProviderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 *
 * @category Youwe
 * @package Youwe_Catalog
 * @author Oleg Kraminsky <o.kraminsky@youwe.nl>
 */
class ConfigProvider implements ConfigProviderInterface
{
    /**
     * General config nodes
     */
    const XML_BREWERY_CONFIG_API_KEY = 'breweryapi/general/api_key';
    const XML_BREWERY_CONFIG_URL = 'breweryapi/general/url';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * ConfigProvider constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritdoc
     */
    public function getUrl(): string
    {
        $url = $this->scopeConfig->getValue(self::XML_BREWERY_CONFIG_URL);
        if (empty($url)) {
            throw new LocalizedException(__('There is no configuration for API'));
        }
        return $url;
    }

    /**
     * @inheritdoc
     */
    public function getApiKey(): string
    {
        $apiKey = $this->scopeConfig->getValue(self::XML_BREWERY_CONFIG_API_KEY);
        if (empty($apiKey)) {
            throw new LocalizedException(__('There is no configuration for API'));
        }
        return $apiKey;
    }
}