<?php
declare(strict_types=1);

namespace Cram\BreweryApi\Cron;

use Cram\BreweryApi\Api\BreweryManagementInterface;

use Psr\Log\LoggerInterface;

/**
 * Class ImportBeer
 *
 * @package Cram\BreweryApi\Cron
 */
class ImportBeer
{
    /**
     * @var BreweryManagementInterface
     */
    private $breweryManagement;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ImportBeer constructor.
     *
     * @param BreweryManagementInterface $breweryManagement
     * @param LoggerInterface $logger
     */
    public function __construct(
        BreweryManagementInterface $breweryManagement,
        LoggerInterface $logger
    )
    {
        $this->breweryManagement = $breweryManagement;
        $this->logger = $logger;
    }

    /**
     * Run the import
     *
     * @return void
     */
    public function execute()
    {
        $start = time();
        $this->logger->info('Product import started at ' . date("Y-m-d H:i:s", $start));
        $this->breweryManagement->import();
        $end = time();
        $this->logger->info('Product import finished at ' . date("Y-m-d H:i:s", $end));
        $this->logger->info(sprintf('Elapsed time: %.2f minutes', ($end - $start) / 60));
    }
}