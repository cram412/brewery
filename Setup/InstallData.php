<?php
namespace Cram\BreweryApi\Setup;

use Magento\Catalog\Model\Product;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


/**
 * Class InstallData
 *
 * @package Cram\BreweryApi\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * InstallData constructor.
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(Product::ENTITY, 'abv', [
            'type'     => 'text',
            'label'    => 'ABV for a beer',
            'input'    => 'text',
            'visible'  => true,
            'default'  => '',
            'required' => false,
            'global'   => ScopedAttributeInterface::SCOPE_STORE,
            'group'    => 'General',
        ]);

        $setup->endSetup();
    }
}