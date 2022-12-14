<div id="config_image" class="shadow od_tab nbdesigner_config" ng-style="{'display': pop.art}">
    <ul class="config_list" id="image_config_list">
        <li><a href="#image_dimension"><span class="fa fa-picture-o" aria-hidden="true"></span></a></li>       
        <li><a href="#image_filter1"><span class="filter1 fa fa-filter" aria-hidden="true"></span></a></li>
        <li><a href="#image_filter2"><span class="filter2 fa fa-filter" aria-hidden="true"></span></a></li>
        <li><a href="#image_filter3"><span class="filter3 fa fa-filter" aria-hidden="true"></span></a></li>
        <li><a href="#image_filter4"><span class="filter4 fa fa-filter" aria-hidden="true"></span></a></li>	
        <li><a href="#image_general"><span class="fa fa-cog" aria-hidden="true"></span></a></li>
    </ul>    
    <div class="list-indicator"></div>
    <div id="image_dimension" class="nbdesigner_config_content content">
        <div class="nb-col-30">
            <p class="label-config"><?php echo $this->__("Unlock proportion") ?></p>
            <div class="switch">
                <input id="text-lock" class="cmn-toggle cmn-toggle-round" type="checkbox" ng-model="lockProportion"  ng-change="unlockProportion()">
                <label for="text-lock"></label>
            </div>  
        </div>	        
        <div class="nb-col-30 has-popover-option" style="padding-left: 15px;">
            <p class="label-config"><?php echo $this->__("Shadow") ?></p>
                <input readonly="true" disabled class="jscolor shadow hover-shadow" ng-model="shadow.color" ng-change="changeShadow()">
                <span class="toggle-popup-option fa fa-chevron-down hover-shadow e-shadow c-option"></span>
                <div class="popup-option">
                    <div class="inner">
                        <div class="nb-col-3">
                            <p class="label-config"><?php echo $this->__("Dimension X") ?></p>
                            <div class="container-dg-slider"><div class="dg-slider" id="image_shadow_x"></div></div>					
                        </div>
                        <div class="nb-col-3">
                            <p class="label-config"><?php echo $this->__("Dimension y") ?></p>
                            <div class="container-dg-slider"><div class="dg-slider" id="image_shadow_y"></div></div>					
                        </div>
                        <div class="nb-col-3">
                            <p class="label-config"><?php echo $this->__("Shadow blur") ?></p>
                            <div class="container-dg-slider"><div class="dg-slider" id="image_shadow_blur"></div></div>					
                        </div>
                        <div class="nb-col-3">
                            <p class="label-config"><?php echo $this->__("Opacity") ?></p>
                            <div class="container-dg-slider"><div class="dg-slider" id="image_shadow_alpha"></div></div>						
                        </div>				
                    </div>
                    <div class="after"></div>
                </div>            
        </div>
        <div class="nb-col-30">
            <p class="label-config"><?php echo $this->__("Opacity") ?></p>
            <div class="container-dg-slider"><div class="dg-slider" id="image_opacity"></div></div>						
        </div>
    </div>
    <div id="image_general" class="content">
        <div class="nb-col-4">
            <p class="label-config"><?php echo $this->__("Rotate") ?></p>
            <div class="rotation-text"><input type="text" id="rotation-image" data-min="0" data-max="359"></div>
        </div> 
        <div class="nb-col-8">
            <p class="label-config"><?php echo $this->__("General Setting") ?></p>
            <div>
                <span class="text-update btn btn-default btn-xs fa fa-crop" data-target="#dg-crop-image" data-toggle="modal" title="Choose Pattern" ng-click="initCropCanvas('crop')">&nbsp;<?php echo $this->__("Crop Image") ?></span>  
                <span class="text-update btn btn-default btn-xs fa fa-star" data-target="#dg-crop-image" data-toggle="modal" title="Shape Image" ng-click="initCropCanvas('shape')">&nbsp;<?php echo $this->__("Shape Image") ?></span>  
                <span class="text-update btn btn-default btn-xs  fa fa-eraser" data-toggle="tooltip" title="Back to original image" ng-click="resetImage()">&nbsp;<?php echo $this->__("Reset Image") ?></span>                
            </div>
<!--            <div class="switch">
                <input id="remove-color-filter" data-filter="Remove color" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label for="remove-color-filter"></label>                
            </div>            -->
        </div>         
    </div>
    <div id="image_filter1" class="content">
        <div class="nb-col-3">
            <p class="label-config"><?php echo $this->__("Grayscale") ?></p>
            <div class="switch">
                <input id="grayscale-filter" data-filter="Grayscale" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label for="grayscale-filter"></label>                  
            </div>
        </div>  
        <div class="nb-col-3">
            <p class="label-config"><?php echo $this->__("Invert") ?></p>
            <div class="switch">
                <input id="invert-filter" data-filter="Invert" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label for="invert-filter"></label>                
            </div>
        </div>  
        <div class="nb-col-3">
            <p class="label-config"><?php echo $this->__("Sepia") ?></p>
            <div class="switch">
                <input id="sepia-filter" data-filter="Sepia" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label for="sepia-filter"></label>                 
            </div>
        </div>  
        <div class="nb-col-3">
            <p class="label-config"><?php echo $this->__("Sepia 2") ?></p>
            <div class="switch">
                <input id="sepia2-filter" data-filter="Sepia 2" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label for="sepia2-filter"></label>                
            </div>
        </div> 
    </div>
    <div id="image_filter2" class="content">
        <div class="nb-col-3 has-popover-option">
            <p class="label-config"><?php echo $this->__("Remove white") ?></p>
            <div class="switch nb-col-6 nbdesigner_mg5">
                <input id="remove-white-filter" data-filter="Remove white" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label for="remove-white-filter"></label>             
            </div>
            <span class="toggle-popup-option fa fa-chevron-down hover-shadow e-shadow c-option" style="margin-left: 7px;"></span>
            <div class="popup-option">
                <div class="inner">
                    <div class="nb-col-4">
                        <p class="label-config"><?php echo $this->__("Threshold") ?></p>
                        <div class="filter_slider dg-slider remove-white-threshold"></div>
                        <input  type="hidden" data-parent="remove-white" data-type="threshold" id="remove-white-threshold" value="0">					
                    </div>
                    <div class="nb-col-4">
                        <p class="label-config"><?php echo $this->__("Distance") ?></p>
                        <div class="filter_slider dg-slider remove-white-distance"></div>
                        <input type="hidden" data-parent="remove-white" data-type="distance" id="remove-white-distance" value="0"> 					
                    </div>				
                </div>
                <div class="after"></div>
            </div>            
        </div> 
        <div class="nb-col-3 has-popover-option">
            <p class="label-config"><?php echo $this->__("Transparency") ?></p>
            <div class="switch nb-col-6 nbdesigner_mg5">
                <input id="gradient-transparency-filter" data-filter="Gradient Transparency" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label for="gradient-transparency-filter"></label>     
            </div>
            <span class="toggle-popup-option fa fa-chevron-down hover-shadow e-shadow c-option" style="margin-left: 7px;"></span>
            <div class="popup-option">
                <div class="inner">
                    <div class="nb-col-4">
                        <p class="label-config"><?php echo $this->__("Value") ?></p>
                        <div class="filter_slider dg-slider gradient-transparency-value"></div>
                        <input type="hidden" data-parent="gradient-transparency"  data-type="threshold" id="gradient-transparency-value" value="0">   					
                    </div>                    
                </div>
            </div>          
        </div>
        <div class="nb-col-3 has-popover-option">
            <p class="label-config"><?php echo $this->__("Tint") ?></p>
            <div class="switch nb-col-6 nbdesigner_mg5">
                <input id="tint-filter" data-filter="Tint" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label for="tint-filter"></label>                  
            </div>
            <span class="toggle-popup-option fa fa-chevron-down hover-shadow e-shadow c-option" style="margin-left: 7px;"></span>
            <div class="popup-option">
                <div class="inner">
                    <div class="nb-col-4">
                        <p class="label-config"><?php echo $this->__("Color") ?></p>
                        <div>
                            <input readonly="true" disabled class="ip_shadow jscolor" data-parent="tint" data-type="color" id="tint-color" value="F98332">
                        </div>				
                    </div>
                    <div class="nb-col-4">
                        <p class="label-config"><?php echo $this->__("Opacity") ?></p>
                        <div class="filter_slider dg-slider tint-opacity"></div>
                        <input type="hidden"  data-parent="tint" data-type="opacity" id="tint-opacity" value="0">					
                    </div>				
                </div>
                <div class="after"></div>
            </div>             
        </div>
        <div class="nb-col-3 has-popover-option">
            <p class="label-config"><?php echo $this->__("Blend") ?></p>
            <div class="switch nb-col-6 nbdesigner_mg5">
                <input id="blend-filter" data-filter="Blend" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label for="blend-filter"></label>                  
            </div>
            <span class="toggle-popup-option fa fa-chevron-down hover-shadow e-shadow c-option" style="margin-left: 7px;"></span>  
            <div class="popup-option">
                <div class="inner">
                    <div class="nb-col-3">
                        <p class="label-config"><?php echo $this->__("Color") ?></p>
                        <div>
                            <input readonly="true" disabled class="ip_shadow jscolor" data-parent="blend" data-type="color" id="blend-color" value="F98332">
                        </div>				
                    </div>   
                    <div class="nb-col-6">   
                        <div class="btn-group blend_mode_option">
                            <button class="btn btn-primary dropdown-toggle shadow hover-shadow" type="button" data-toggle="dropdown"><?php echo $this->__("Blend mode") ?>&nbsp;<span class="caret"></span></button>
                            <ul class="dropdown-menu dropup  shadow hover-shadow">
                                <li><a href="javascript:void(0);" onclick="changeBlendMode('add')"><?php echo $this->__("Add") ?></a></li>
                                <li><a href="javascript:void(0);" onclick="changeBlendMode('diff')"><?php echo $this->__("Diff") ?></a></li>
                                <li><a href="javascript:void(0);" onclick="changeBlendMode('subtract')"><?php echo $this->__("Subtract") ?></a></li>
                                <li><a href="javascript:void(0);" onclick="changeBlendMode('multiply')"><?php echo $this->__("Multiply") ?></a></li>
                                <li><a href="javascript:void(0);" onclick="changeBlendMode('screen')"><?php echo $this->__("Screen") ?></a></li>
                                <li><a href="javascript:void(0);" onclick="changeBlendMode('lighten')"><?php echo $this->__("Lighten") ?></a></li>                                        
                                <li><a href="javascript:void(0);" onclick="changeBlendMode('darken')"><?php echo $this->__("Darken") ?></a></li>                                        
                            </ul>
                        </div>                          
                    </div>				
                </div>
                <div class="after"></div>
            </div>             
        </div>
    </div>
    <div id="image_filter3" class="content">
        <div class="nb-col-3">
            <p class="label-config"><?php echo $this->__("Brightness") ?></p>
            <div class="switch">
                <input id="brightness-filter" data-filter="Brightness" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label for="brightness-filter"></label>         
            </div>
            <p class="label-config"><?php echo $this->__("Value") ?></p>
            <div class="filter_slider dg-slider brightness-value"></div>
            <input type="hidden" data-parent="brightness"  data-type="brightness" id="brightness-value" value="0">            
        </div> 
        <div class="nb-col-3">
            <p class="label-config"><?php echo $this->__("Noise") ?></p>
            <div class="switch">
                <input id="noise-filter" data-filter="Noise" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label for="noise-filter"></label>         
            </div>
            <p class="label-config"><?php echo $this->__("Value") ?></p>
            <div class="filter_slider dg-slider noise-value"></div>
            <input type="hidden"  data-parent="noise"  data-type="noise" id="noise-value" value="0">           
        </div> 
        <div class="nb-col-3">
            <p class="label-config"><?php echo $this->__("Pixelate") ?></p>
            <div class="switch">
                <input id="pixelate-filter" data-filter="Pixelate" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label for="pixelate-filter"></label>         
            </div>
            <p class="label-config"><?php echo $this->__("Value") ?></p>
            <div class="filter_slider dg-slider pixelate-value"></div>
            <input type="hidden"  data-parent="pixelate"  data-type="blocksize" id="pixelate-value" value="0">          
        </div> 
        <div class="nb-col-3">
            <p class="label-config"><?php echo $this->__("Multiply") ?></p>
            <div class="switch">
                <input id="multiply-filter" data-filter="Multiply" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label for="multiply-filter"></label>         
            </div>
            <p class="label-config"><?php echo $this->__("Color") ?></p>
            <input readonly="true" disabled class="ip_shadow jscolor" data-parent="multiply" data-type="color" id="multiply-color" value="F98332">        
        </div>        
    </div>
    <div id="image_filter4" class="content">
        <p style="color: red; font-size: 11px">
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;<?php echo $this->__("Filters bellow need more time to process! Happy wait!") ?></p>
        <div class="nb-col-3">
            <p class="label-config"><?php echo $this->__("Blur") ?></p>
            <div class="switch">
                <input id="blur-filter" data-filter="Blur" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label for="blur-filter"></label>       
            </div>            
        </div> 
        <div class="nb-col-3">
            <p class="label-config"><?php echo $this->__("Sharpen") ?></p>
            <div class="switch">
                <input id="sharpen-filter" data-filter="Sharpen" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label for="sharpen-filter"></label>      
            </div>            
        </div>         
        <div class="nb-col-3">
            <p class="label-config"><?php echo $this->__("Emboss") ?></p>
            <div class="switch">
                <input id="emboss-filter" data-filter="Emboss" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label for="emboss-filter"></label>        
            </div>            
        </div> 
        <div class="nb-col-3">
            <p class="label-config"><?php echo $this->__("Edge enhance") ?></p>
            <div class="switch">
                <input id="edge-enhance-filter" data-filter="Edge enhance" class="cmn-toggle cmn-toggle-round" type="checkbox">
                <label for="edge-enhance-filter"></label>         
            </div>            
        </div>        
    </div>
</div>