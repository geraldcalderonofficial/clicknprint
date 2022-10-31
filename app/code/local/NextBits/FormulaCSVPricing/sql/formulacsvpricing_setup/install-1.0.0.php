<?php
$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();

$groupName = "Formula Pricing Pro";

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('formulacsvpricing')};
CREATE TABLE {$this->getTable('formulacsvpricing')} (
 	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`product_id` INT(10) UNSIGNED NULL,
	`csv_price` LONGTEXT NULL,
	`option_id` INT(11),
	`file_name` VARCHAR(255) NULL,
	`f_name` VARCHAR(255) NULL,
	`store_id` INT(11),
	PRIMARY KEY (`id`),
	CONSTRAINT `FK_formulacsvpricing_catalog_product_entity` FOREIGN KEY (`product_id`) REFERENCES `{$this->getTable('catalog/product')}` (`entity_id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

$attributeSetCollection = Mage::getResourceModel('eav/entity_attribute_set_collection')->load();
foreach ($attributeSetCollection as $id=>$attributeSet) {
	$name = $attributeSet->getAttributeSetName();
	$setup->addAttributeGroup('catalog_product' , $name , $groupName , 1000);
}


$setup->addAttribute('catalog_product', 'formula_csv_enable', array(
		'group' => $groupName,
		'type' => 'int',
		'backend' => '',
		'frontend' => '',
		'label' => 'Enable Formula Pricing Pro',
		'input' => 'select',
		'default'=> 0,
		'source' => 'eav/entity_attribute_source_boolean',
		'visible' => true,
		'required' => false,
		'user_defined'  => true,
		'sort_order' => 0,
		'note' => 'Activate Formula Pricing Pro module for this product',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$setup->addAttribute('catalog_product' , 'formula_csv_final' , array(
		'group'  => $groupName ,
		'input'  => 'text' ,
		'type'  => 'varchar' ,
		'label'  => 'Final Equation for Price' ,
		'backend'  => '' ,
		'visible'  => true,
		'required'  => false,
		'user_defined'  => true,
		'sort_order' => 1,
		'note' => 'Example : {sqft}*{price}*{qty}+{fixed_surcharge}+{print_type}',
		'global'  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$setup->addAttribute('catalog_product' , 'additional_variable' , array(
		'group'  => $groupName,
		'input'  => 'textarea' ,
		'type'  => 'text' ,
		'label'  => 'Static Variables For Equation',
		'backend'  => '' ,
		'visible'  => true,
		'required'  => false,
		'user_defined'  => true,
		'sort_order' => 2,
		'note' => 'fixed_surcharge=>100;inch_per_feet=>12;',
		'global'  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$setup->addAttribute('catalog_product' , 'custom_variable_formula' , array(
		'group'  => $groupName,
		'input'  => 'textarea' ,
		'type'  => 'text' ,
		'label'  => 'Static Variables ( Formula Based ) For Equation',
		'backend'  => '' ,
		'visible'  => true,
		'required'  => false,
		'user_defined'  => true,
		'sort_order' => 3,
		'note' => 'Example : sqft=>(({width}/{inch_per_feet})*({height}/{inch_per_feet}));',
		'global'  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$setup->addAttribute('catalog_product' , 'assign_variable' , array(
		'group'  => $groupName,
		'input'  => 'textarea' ,
		'type'  => 'text' ,
		'label'  => 'Assign Variable to Custom Option Title',
		'backend'  => '' ,
		'visible'  => true,
		'required'  => false,
		'user_defined'  => true,
		'sort_order' => 4,
		'note' => 'Example : Width (Inches)=>width;Height (Inches)=>height;Print Type=>print_type;',
		'global'  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$setup->addAttribute('catalog_product' , 'option_values' , array(
		'group'  => $groupName,
		'input'  => 'textarea' ,
		'type'  => 'text' ,
		'label'  => 'Assign Variable to Custom Option Values',
		'backend'  => '' ,
		'visible'  => true,
		'required'  => false,
		'user_defined'  => true,
		'sort_order' => 5,
		'note' => 'Example : {Two Side Printing}=>10;{One Side Printing}=>5;{width_default}=>12;{height_default}=>12;{height_price}=>12;',
		'global'  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$setup->addAttribute('catalog_product' , 'extra_price_formula' , array(
		'group'  => $groupName,
		'input'  => 'textarea' ,
		'type'  => 'text' ,
		'label'  => 'Extra Price Formula ( Discount / Upcharge )',
		'backend'  => '' ,
		'visible'  => true,
		'required'  => false,
		'user_defined'  => true,
		'sort_order' => 6,
		'note' => 'Example : ({sqft}>=100 && {sqft}<=200)=>-({newprice}*0.5/100);',
		'global'  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$setup->addAttribute('catalog_product' , 'min_input_setting' , array(
		'group'  => $groupName,
		'input'  => 'textarea' ,
		'type'  => 'text' ,
		'label'  => 'Min Input Setting',
		'backend'  => '' ,
		'visible'  => true,
		'required'  => false,
		'user_defined'  => true,
		'sort_order' => 7,
		'note' => 'Example : width=>12; height=>12;',
		'global'  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$setup->addAttribute('catalog_product' , 'min_input_validation' , array(
		'group'  => $groupName ,
		'input'  => 'text' ,
		'type'  => 'varchar' ,
		'label'  => 'Min Input Validation Msg' ,
		'backend'  => '' ,
		'visible'  => true,
		'required'  => false,
		'user_defined'  => true,
		'sort_order' => 8,
		'note' => 'Example : Minimum {title} is {min} -> Minimum Width (Inches) is 100',
		'global'  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$setup->addAttribute('catalog_product' , 'max_input_setting' , array(
		'group'  => $groupName ,
		'input'  => 'textarea' ,
		'type'  => 'text' ,
		'label'  => 'Max Input Setting' ,
		'backend'  => '' ,
		'visible'  => true,
		'required'  => false,
		'user_defined'  => true,
		'sort_order' => 9,
		'note' => 'Example : width=>1200; height=>1200;',
		'global'  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$setup->addAttribute('catalog_product' , 'max_input_validation' , array(
		'group'  => $groupName ,
		'input'  => 'text' ,
		'type'  => 'varchar' ,
		'label'  => 'Max Input Validation' ,
		'backend'  => '' ,
		'visible'  => true,
		'required'  => false,
		'user_defined'  => true,
		'sort_order' => 10,
		'note' => 'Example : Maximum {title} is {max} -> Maximum Width (Inches) is 1200',
		'global'  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$setup->addAttribute('catalog_product' , 'custom_validation' , array(
		'group'  => $groupName,
		'input'  => 'textarea' ,
		'type'  => 'text' ,
		'label'  => 'Custom Validation',
		'backend'  => '' ,
		'visible'  => true,
		'required'  => false,
		'user_defined'  => true,
		'sort_order' => 11,
		'note' => 'Example : {width}>1201=>Please ask for quote.;',
		'global'  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$setup->addAttribute('catalog_product', 'enable_csv_equation', array(
		'group' => $groupName,
		'type' => 'int',
		'backend' => '',
		'frontend' => '',
		'label' => 'Enable CSV Equation',
		'input' => 'select',
		'default'=> 0,
		'source' => 'eav/entity_attribute_source_boolean',
		'visible' => true,
		'required' => false,
		'user_defined'  => true,
		'sort_order' => 12,
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$setup->addAttribute('catalog_product' , 'formula_csv_xformula' , array(
		'group'  => $groupName ,
		'input'  => 'text' ,
		'type'  => 'varchar' ,
		'label'  => 'Equation 1(Get Value from CSV row)' ,
		'backend'  => '' ,
		'visible'  => true,
		'required'  => false,
		'user_defined'  => true,
		'sort_order' => 13,
		'global'  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$setup->addAttribute('catalog_product' , 'formula_csv_yformula' , array(
		'group'  => $groupName ,
		'input'  => 'text' ,
		'type'  => 'varchar' ,
		'label'  => 'Equation 2(Get Value from CSV column)' ,
		'backend'  => '' ,
		'visible'  => true,
		'required'  => false,
		'user_defined'  => true,
		'sort_order' => 14,
		'global'  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$setup->addAttribute('catalog_product' , 'csv_min_message' , array(
		'group'  => $groupName,
		'input'  => 'text' ,
		'type'  => 'varchar' ,
		'label'  => 'CSV Min Value Error Message',
		'backend'  => '' ,
		'visible'  => true,
		'required'  => false,
		'user_defined'  => true,
		'sort_order' => 15,
		'global'  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$setup->addAttribute('catalog_product' , 'csv_max_message' , array(
		'group'  => $groupName,
		'input'  => 'text' ,
		'type'  => 'varchar' ,
		'label'  => 'CSV Max Value Error Message',
		'backend'  => '' ,
		'visible'  => true,
		'required'  => false,
		'user_defined'  => true,
		'sort_order' => 16,
		'global'  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));


$setup->addAttribute('catalog_product' , 'default_qty' , array(
		'group'  => $groupName ,
		'input'  => 'text' ,
		'type'  => 'varchar' ,
		'label'  => 'Default Qty' ,
		'backend'  => '' ,
		'visible'  => true,
		'required'  => false,
		'user_defined'  => true,
		'sort_order' => 17,
		'note' => 'Added qty will be set on Front-End as a default quantity on first load.',
		'global'  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$setup->addAttribute('catalog_product', 'show_equation', array(
		'group' => $groupName,
		'type' => 'int',
		'backend' => '',
		'frontend' => '',
		'label' => 'Show Equation in Frontend (debug)',
		'input' => 'select',
		'default'=> 0,
		'source' => 'eav/entity_attribute_source_boolean',
		'visible' => true,
		'required' => false,
		'user_defined'  => true,
		'sort_order' => 18,
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));

$installer->endSetup(); 