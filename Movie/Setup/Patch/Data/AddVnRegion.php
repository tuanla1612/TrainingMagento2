<?php
/**
* Copyright © Magento, Inc. All rights reserved.
* See COPYING.txt for license details.
*/

namespace Magenest\Movie\Setup\Patch\Data;

use Magento\Catalog\Ui\DataProvider\Product\ProductCollectionFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Psr\Log\LoggerInterface;

/**
* Class AddPhoneAttribute
* @package Magenest\CustomerAttribute\Setup\Patch\Data
*/
class AddVnRegion implements DataPatchInterface, PatchRevertableInterface
{
   /**
    * @var ModuleDataSetupInterface
    */
   private $moduleDataSetup;
   /**
    * @var EavSetupFactory
    */
   private $eavSetupFactory;
   /**
    * @var ProductCollectionFactory
    */
   private $productCollectionFactory;
   /**
    * @var LoggerInterface
    */
   private $logger;
   /**
    * @var Config
    */
   private $eavConfig;
   /**
    * @var \Magento\Customer\Model\ResourceModel\Attribute
    */
   private $attributeResource;

   /**
    * AddPhoneAttribute constructor.
    * @param EavSetupFactory $eavSetupFactory
    * @param Config $eavConfig
    * @param LoggerInterface $logger
    * @param \Magento\Customer\Model\ResourceModel\Attribute $attributeResource
    */
   public function __construct(
       EavSetupFactory $eavSetupFactory,
       Config $eavConfig,
       LoggerInterface $logger,
       \Magento\Customer\Model\ResourceModel\Attribute $attributeResource,
       \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
   ) {
       $this->eavSetupFactory = $eavSetupFactory;
       $this->eavConfig = $eavConfig;
       $this->logger = $logger;
       $this->attributeResource = $attributeResource;
       $this->moduleDataSetup = $moduleDataSetup;
   }

   /**
    * {@inheritdoc}
    */
   public function apply()
   {
       $this->moduleDataSetup->getConnection()->startSetup();
       $this->addVnRegion();
       $this->moduleDataSetup->getConnection()->endSetup();
   }

   /**
    * @throws \Magento\Framework\Exception\AlreadyExistsException
    * @throws \Magento\Framework\Exception\LocalizedException
    * @throws \Zend_Validate_Exception
    */
   public function addVnRegion()
   {
       $eavSetup = $this->eavSetupFactory->create();


       $eavSetup->addAttribute(
           'customer_address',
           'vn_region',
           [
               'type' => 'varchar',
               'label' => 'Vn Region',
               'source' => 'Magenest\Movie\Model\Config\Source\VnRegion',
               'input' => 'select',
               'required' => false,
               'visible' => 1,
               'user_defined' => 1,
               'sort_order' => 999,
               'position' => 999,
               'system' => 0
           ]
       );

       $attributeSetId = $eavSetup->getDefaultAttributeSetId(Customer::ENTITY);
       $attributeGroupId = $eavSetup->getDefaultAttributeGroupId(Customer::ENTITY);

       $attribute = $this->eavConfig->getAttribute('customer_address', 'vn_region');
       $attribute->setData('attribute_set_id', $attributeSetId);
       $attribute->setData('attribute_group_id', $attributeGroupId);

       $attribute->setData('used_in_forms', [
        'adminhtml_customer_address',
        'adminhtml_customer',
        'customer_address_edit',
        'customer_register_address',
        'customer_address'
       ]);

       $this->attributeResource->save($attribute);
   }

   /**
    * {@inheritdoc}
    */
   public static function getDependencies()
   {
       return [];
   }

   /**
    *
    */
   public function revert()
   {
   }

   /**
    * {@inheritdoc}
    */
   public function getAliases()
   {
       return [];
   }
}