<?php
/**
* @copyright Amasty.
*/  
$installer = $this;
//$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();
/*
$setup->addAttribute('catalog_product', 'product_type', array(
        'group'             => 'Product Options',
        'label'             => 'Product Type',
        'note'              => '',
        'type'              => 'int',    //backend_type
        'input'             => 'select', //frontend_input
        'frontend_class'    => '',
        'source'            => 'orderupload/attribute_source_type',
        'backend'           => '',
        'frontend'          => '',
        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE,
        'required'          => true,
        'visible_on_front'  => false,
        'apply_to'          => 'simple',
        'is_configurable'   => false,
        'used_in_product_listing'   => false,
        'sort_order'        => 5,
    ));
*/
$installer->endSetup(); 