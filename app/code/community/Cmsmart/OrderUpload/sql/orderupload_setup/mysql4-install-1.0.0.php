<?php
/**
* @copyright Amasty.
*/  
$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();


$setup->addAttribute( Mage_Catalog_Model_Product::ENTITY, 'order_upload', array(
            'group' => 'General',
            'type' => 'int',
            'backend' => '',
            'frontend' => '',
            'label' => 'Order Upload ?',
            'input' => 'boolean',
            'source' => 'eav/entity_attribute_source_table',
            'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'default' => '',
            'searchable' => false,
            'filterable' => true,
            'comparable' => false,
            'visible_on_front' => true,
            'visible_in_advanced_search' => true,
            'used_in_product_listing' => true,
            'unique' => false,
            'apply_to' => 'simple',
        ) );


$setup->updateAttribute('catalog_product', 'order_upload', 'is_visible_on_front', 1);

$installer->endSetup(); 