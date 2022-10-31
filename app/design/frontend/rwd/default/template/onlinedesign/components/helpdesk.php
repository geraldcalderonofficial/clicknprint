<?php
$current_theme = Mage::getSingleton('core/design_package')->getPackageName();
$img_skin_path = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/'.$current_theme.'/default/cmsmart/onlinedesign/images';
?>

<div id="helpdesk" class="shadow">
    <h3><?php echo $this->__("Helpdesk") ?></h3>
    <div class="od_tabs inner-help">
        <ul>
            <li><a href="#general-help"><?php echo $this->__("General") ?></a></li>
            <li><a href="#design-help"><?php echo $this->__("Design") ?></a></li>
            <li><a href="#tool-help"><?php echo $this->__("Tool-Layer") ?></a></li>
        </ul>
        <div id="general-help">
            <img src="<?php echo $img_skin_path .'/helpdesk01.jpg'; ?>" />
            <img src="<?php echo $img_skin_path .'/helpdesk02.jpg'; ?>" />
        </div>
        <div id="design-help">
            <img src="<?php echo $img_skin_path .'/helpdesk04.jpg'; ?>" />
            <img src="<?php echo $img_skin_path .'/helpdesk05.jpg'; ?>" />
        </div>	
        <div id="tool-help">           
            <img src="<?php echo $img_skin_path .'/helpdesk06.jpg'; ?>" />
            <img src="<?php echo $img_skin_path .'/helpdesk03.jpg'; ?>" />
        </div>	
    </div>
    <span class="close-helpdesk fa fa-angle-double-right"></span>
</div>