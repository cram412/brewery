<?php
declare(strict_types=1);

namespace Cram\BreweryApi\Model\ResourceModel;

use Cram\BreweryApi\Api\BreweryRepositoryInterface;
use Cram\BreweryApi\Api\ConfigProviderInterface;

use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Class BreweryRepository
 *
 * @package Cram\BreweryApi\Model\ResourceModel
 */
class BreweryRepository implements BreweryRepositoryInterface
{
    /**
     * @var ConfigProviderInterface
     */
    private $configProvider;
    /**
     * @var Curl
     */
    private $curl;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * BreweryRepository constructor.
     * @param ConfigProviderInterface $configProvider
     * @param Curl $curl
     * @param SerializerInterface $serializer
     */
    public function __construct(
        ConfigProviderInterface $configProvider,
        Curl $curl,
        SerializerInterface $serializer
    )
    {
        $this->configProvider = $configProvider;
        $this->curl = $curl;
        $this->serializer = $serializer;
    }

    /**
     * @inheritdoc
     */
    public function get($methodName, $data = []): array
    {
        $url = $this->buildUrl($methodName, $data);
        $this->curl->get($url);
        if ($this->curl->getStatus() === 200) {
            return $this->serializer->unserialize($this->curl->getBody());
        }

        throw new \HttpRequestException(__('Could not receive data from BreweryDB'));
    }

    /**
     * @return string
     */
    protected function buildUrl($methodName, $data = []): string
    {
        $data['key'] = $this->configProvider->getApiKey();
        $query = http_build_query($data);
        return $this->configProvider->getUrl() . '/' . $methodName . '?' . $query;
    }
}