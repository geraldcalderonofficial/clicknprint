<div id="config_art" class="shadow od_tab nbdesigner_config" ng-style="{'display': pop.clipArt}">
    <ul class="config_list" id="art_config_list">
        <li><a href="#svg_path"><span class="fa fa-tint" aria-hidden="true"></span></a></li>
        <li><a href="#svg_config"><span class="fa fa-cog" aria-hidden="true"></span></a></li>        
    </ul>
    <div class="list-indicator"></div>
    <div id="svg_path" class="nbdesigner_config_content content">
        <span class="shadow hover-shadow text-item" ng-click="showPathConfig()" data-target="#dg-config-art" data-toggle="modal"><?php echo $this->__("Manager Path") ?></span>
    </div>
    <div id="svg_config" class="nbdesigner_config_content content" style="padding-bottom: 0;">
        <div class="nb-col-30">
            <p class="label-config label-rotate"><?php echo $this->__("Rotate") ?></p>
            <div class="rotation-text"><input type="text" id="rotation-svg" data-min="0" data-max="359"></div>
        </div>  
        <div class="nb-col-30">
            <p class="label-config"><?php echo $this->__("Opacity") ?></p>
            <div class="container-dg-slider"><div class="opacity-slider dg-slider" id="opacity_svg"></div></div>					
        </div>         
    </div>
</div>