<?php //if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<div id="helpdesk" class="shadow">
    <h3><?php echo $this->__("Helpdesk") ?></h3>
    <div class="od_tabs inner-help">
        <ul>
            <li><a href="#general-help"><?php echo $this->__("General") ?></a></li>
            <li><a href="#design-help"><?php echo $this->__("Design") ?></a></li>
            <li><a href="#tool-help"><?php echo $this->__("Tool-Layer") ?></a></li>
            <li><a href="#shortcuts"><?php echo $this->__("Hot Keys") ?></a></li>
        </ul>
        <div id="general-help">
            <img src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/images/helpdesk01.jpg'; ?>" />
            <img src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/images/helpdesk02.jpg'; ?>" />
        </div>
        <div id="design-help">
            <img src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/images/helpdesk04.jpg'; ?>" />
            <img src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/images/helpdesk05.jpg'; ?>" />
        </div>	
        <div id="tool-help">           
            <img src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/images/helpdesk06.jpg'; ?>" />
            <img src="<?php echo NBDESIGNER_PLUGIN_URL .'assets/images/helpdesk03.jpg'; ?>" />
        </div>	
        <div id="shortcuts">    
            <p><span class="shortkey left"><span class="key nbd-icon-mouse"></span></span><span class="shortkey right"><?php echo $this->__("Select layer (item)") ?></span></p>
            <p><span class="shortkey left"><span class="key">&larr;</span></span><span class="shortkey right"><?php echo $this->__("Move left") ?></span></p>
            <p><span class="shortkey left"><span class="key">&rarr;</span></span><span class="shortkey right"><?php echo $this->__("Move right") ?></span></p>
            <p><span class="shortkey left"><span class="key">&uarr;</span></span><span class="shortkey right"><?php echo $this->__("Move up") ?></span></p>
            <p><span class="shortkey left"><span class="key">&darr;</span></span><span class="shortkey right"><?php echo $this->__("Move down") ?></span></p>
            <p><span class="shortkey left"><span class="key long">Delete</span></span><span class="shortkey right"><?php echo $this->__("Delete layer (item)") ?></span></p>
            <p><span class="shortkey left"><span class="key long">Shift</span><span class="key">-</span></span><span class="shortkey right"><?php echo $this->__("Zoom in item") ?></span></p>
            <p><span class="shortkey left"><span class="key long">Shift</span><span class="key">+</span></span><span class="shortkey right"><?php echo $this->__("Zoom out item") ?></span></p>
            <p><span class="shortkey left"><span class="key long">Ctrl</span><span class="key">Z</span></span><span class="shortkey right"><?php echo $this->__("Undo") ?></span></p>
            <p><span class="shortkey left"><span class="key long">Ctrl</span><span class="key">Y</span></span><span class="shortkey right"><?php echo $this->__("Redo") ?></span></p>
            <p><span class="shortkey left"><span class="key long">Shift</span><span class="key nbd-icon-mouse"></span></span><span class="shortkey right"><?php echo $this->__("Group Items (left mouse)") ?></span></p>
        </div>        
    </div>
    <span class="close-helpdesk fa fa-angle-double-right"></span>
</div>