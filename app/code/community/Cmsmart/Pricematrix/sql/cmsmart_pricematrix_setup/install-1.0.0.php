<?php
/**
 * @author Pham Hong Thanh
 * @email thanhpham0990@gmail.com
 * @skype thanhpham170990
 */


$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();


/**
 * Create table 'cmsmart_pricematrix/vertical'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('cmsmart_pricematrix/vertical'))
    ->addColumn('vertical_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        'auto_increment' => true
    ), 'Id')
    ->addColumn('product', Varien_Db_Ddl_Table::TYPE_TEXT, '64K', array(
    ), 'Product')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, '64K', array(
    ), 'Title')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
    ), 'Value')
    ->setComment('Vertical Table');
$installer->getConnection()->createTable($table);


/**
 * Create table 'cmsmart_pricematrix/horizontal'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('cmsmart_pricematrix/horizontal'))
    ->addColumn('horizontal_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        'auto_increment' => true
    ), 'Id')
    ->addColumn('product', Varien_Db_Ddl_Table::TYPE_TEXT, '64K', array(
    ), 'Product')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, '64K', array(
    ), 'Title')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
    ), 'Value')
    ->setComment('Horizontal Table');
$installer->getConnection()->createTable($table);


/**
 * Create table 'cmsmart_pricematrix/vertical_horizontal'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('cmsmart_pricematrix/vertical_horizontal'))
    ->addColumn('vertical_horizontal_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        'auto_increment' => true,
    ), 'Vertical Horizontal Id')
    ->addColumn('product', Varien_Db_Ddl_Table::TYPE_TEXT, '64K', array(
    ), 'Product')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, '64K', array(
    ), 'Title')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, '2M' , array(
    ), 'Value')
    ->addColumn('direct', Varien_Db_Ddl_Table::TYPE_TEXT, '64K' , array(
    ), 'Direct')
    ->setComment('Vertical Horizontal Table');
$installer->getConnection()->createTable($table);


/**
 * Create table 'cmsmart_pricematrix/vertical_horizontal'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('cmsmart_pricematrix/matrix'))
    ->addColumn('matrix_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        'auto_increment' => true,
    ), 'Matrix Id')
    ->addColumn('product', Varien_Db_Ddl_Table::TYPE_TEXT, '64K', array(
    ), 'Product')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, '2M' , array(
    ), 'Value')
    ->setComment('Matrix Table');
$installer->getConnection()->createTable($table);


$installer->endSetup();
