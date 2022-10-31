<div id="config_text" class="shadow od_tab nbdesigner_config" ng-style="{'display': pop.text}">
    <ul class="config_list">
        <li><a href="#typography"><span class="fa fa-font" aria-hidden="true"></span></a></li>
        <li><a href="#text-style"><span class="fa fa-italic" aria-hidden="true"></span></a></li>
        <li><a href="#text-decoration"><span class="fa fa-tint" aria-hidden="true"></span></a></li>
        <li><a href="#text-decoration1"><span class="fa fa-text-height" aria-hidden="true"></span></a></li>
        <li><a href="#text-dimension"><span class="fa fa-crop" aria-hidden="true"></span></a></li>
        <li><a href="#rotate-curved"><span class="fa fa-circle-thin" aria-hidden="true"></span></a></li>		
    </ul>
    <div class="list-indicator"></div>
    <div id="typography" class="content">
        <div class="nb-col-6">
            <textarea class="form-control" ng-model="editable.text" ng-change="ChangeText()"></textarea>
        </div>
        <div class="nb-col-6">
            <fieldset class="shadow" ng-click="loadFont()" data-target="#dg-fonts" data-toggle="modal">
                <legend><?php echo $this->__("Fonts:") ?></legend>
                <a>{{currentFont.name}}</a>
                <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s pull-right"></span>
            </fieldset>
        </div>
    </div>
    <div id="text-style" class="content">
        <span class="fa fa-italic shadow item-config hover-shadow" ng-click="toggleItalic()"></span>
        <span class="fa fa-bold shadow item-config hover-shadow" ng-click="toggleBold()"></span>
        <span class="fa fa-underline shadow item-config hover-shadow" ng-click="toggleTextDecoration('underline')"></span>
        <span class="fa fa-strikethrough shadow item-config hover-shadow" ng-click="toggleTextDecoration('line-through')"></span>
        <span class="fa fa-font shadow item-config hover-shadow" ng-click="toggleTextDecoration('overline')" style="text-decoration: overline;" ng-show="state == 'dev'"></span>
        <span class="fa fa-align-left shadow item-config hover-shadow" ng-click="align('left')"></span>
        <span class="fa fa-align-center shadow item-config hover-shadow" ng-click="align('center')"></span>
        <span class="fa fa-align-right shadow item-config hover-shadow" ng-click="align('right')"></span>
    </div>
    <div id="text-decoration" class="content">
        <div class="nb-col-2">
            <p class="label-config"><?php echo $this->__("Text color") ?></p>
            <input readonly="true" disabled class="jscolor shadow hover-shadow" value="{{colorOptional}}" ng-model="colorOptional" ng-change="changeColor(colorOptional)">
        </div>
        <div class="nb-col-30">
            <p class="label-config"><?php echo $this->__("Background") ?></p>
            <input readonly="true" disabled class="jscolor shadow hover-shadow" value="{{background}}" ng-model="background" ng-change="setBackground()">
            <span class="shadow hover-shadow item-config fa fa-recycle e-shadow" ng-click="setBackground('remove')" data-toggle="tooltip" data-original-title="<?php echo $this->__('Remove background') ?>"></span>
        </div>			
        <div class="nb-col-2 has-popover-option">
            <p class="label-config"><?php echo $this->__("Pattern") ?></p>
            <span class="pattern item-config hover-shadow e-shadow" data-target="#dg-pattern" data-toggle="modal" ng-click="loadPattern()"></span>
            <span class="toggle-popup-option fa fa-chevron-down hover-shadow e-shadow c-option" ng-show="editable.pattern"></span>
            <div class="popup-option">
                <div class="inner">
                    <span class="shadow hover-shadow item-config" ng-click="changePatternRepeat('repeat')" >XY</span>
                    <span class="shadow hover-shadow item-config" ng-click="changePatternRepeat('repeat-x')">X</span>
                    <span class="shadow hover-shadow item-config" ng-click="changePatternRepeat('repeat-y')">Y</span>
                    <span class="shadow hover-shadow item-config" ng-click="changePatternRepeat('no-repeat')">O</span>				
                </div>
                <div class="after"></div>
            </div>
        </div>
        <div class="nb-col-30 has-popover-option">
            <p class="label-config"><?php echo $this->__("Shadow") ?></p>
            <input readonly="true" disabled class="jscolor shadow hover-shadow" ng-model="shadow.color" ng-change="changeShadow()">
            <span class="toggle-popup-option fa fa-chevron-down hover-shadow e-shadow c-option"></span>
            <div class="popup-option">
                <div class="inner">
                    <div class="nb-col-3">
                        <p class="label-config"><?php echo $this->__("Dimension X") ?></p>
                        <div class="container-dg-slider"><div class="dg-slider" id="shadow_x"></div></div>					
                    </div>
                    <div class="nb-col-3">
                        <p class="label-config"><?php echo $this->__("Dimension Y") ?></p>
                        <div class="container-dg-slider"><div class="dg-slider" id="shadow_y"></div></div>					
                    </div>
                    <div class="nb-col-3">
                        <p class="label-config"><?php echo $this->__("Shadow blur") ?></p>
                        <div class="container-dg-slider"><div class="dg-slider" id="shadow_blur"></div></div>					
                    </div>
                    <div class="nb-col-3">
                        <p class="label-config"><?php echo $this->__("Opacity") ?></p>
                        <div class="container-dg-slider"><div class="dg-slider" id="shadow_alpha"></div></div>						
                    </div>				
                </div>
                <div class="after"></div>
            </div>			
        </div>		
    </div>
    <div id="text-decoration1" class="content">
        <div class="nb-col-2">
            <p class="label-config"><?php echo $this->__("Line height") ?></p>
            <input type="text" ng-model="lineHeight" ng-change="setLineHeight()" class="input-config shadow hover-shadow" 
                   data-toggle="tooltip" data-original-title="<?php echo $this->__('Line heightChange vertical spacing between text lines') ?>"
                   />
        </div>
        <div class="nb-col-2">
            <p class="label-config"><?php echo $this->__("Font size") ?></p>
            <input type="text" ng-model="fontSize" ng-change="setFontSize()" class="input-config shadow hover-shadow" />
        </div>		
        <div class="nb-col-30">
            <p class="label-config"><?php echo $this->__("Opacity") ?></p>
            <div class="container-dg-slider"><div class="opacity-slider dg-slider" id="opacity-text"></div></div>
        </div>
        <div class="nb-col-30 has-popover-option">
            <p class="label-config"><?php echo $this->__("Outline") ?></p>
            <input readonly="true" disabled class="jscolor shadow hover-shadow" ng-model="colorStrokeOptional" ng-change="changeStroke(colorStrokeOptional, null)">
            <span class="toggle-popup-option fa fa-chevron-down hover-shadow e-shadow c-option"></span>
            <div class="popup-option">
                <div class="inner">			
                    <div class="container-dg-slider"><div class="dg-slider" id="dg-outline-width"></div></div>
                </div>
                <div class="after"></div>
            </div>
        </div>		
    </div>	
    <div id="text-dimension" class="content">
        <div class="nb-col-4">
            <p class="label-config"><?php echo $this->__("Height") ?></p>
            <input class="input-config shadow hover-shadow" readonly disabled ng-model="editable.height">
        </div>
        <div class="nb-col-4">
            <p class="label-config"><?php echo $this->__("Width") ?></p>
            <input class="input-config shadow hover-shadow" readonly disabled ng-model="editable.width">
        </div>	
        <div class="nb-col-4">
            <p class="label-config"><?php echo $this->__("Unlock proportion") ?></p>
            <div class="switch">
                <input id="text-lock" class="cmn-toggle cmn-toggle-round" type="checkbox" ng-model="lockProportion"  ng-change="unlockProportion()">
                <label for="text-lock"></label>
            </div>  
        </div>			
    </div>
    <div id="rotate-curved" class="content">
        <div class="nb-col-30">
            <p class="label-config label-rotate"><?php echo $this->__("Rotate") ?></p>
            <div class="rotation-text"><input type="text" id="rotation-text" data-min="0" data-max="359"></div>
        </div>
        <div class="nb-col-40">
            <p class="label-config"><?php echo $this->__("Curved text") ?></p>
            <div class="container-dg-slider"><div class="dg-slider" id="text-arc"></div></div>

        </div>		
        <div class="nb-col-30 has-popover-option">
            <p class="label-config"><?php echo $this->__("Reverse") ?></p>
            <div class="switch nb-col-6">
                <input id="curve_reverse" class="cmn-toggle cmn-toggle-round" type="checkbox"  ng-click="reverseCurve()">
                <label for="curve_reverse"></label>
            </div> 	
            <span class="toggle-popup-option fa fa-chevron-down hover-shadow e-shadow c-option pull-right" ng-style="{display: editable.effect}"></span>
            <div class="popup-option">
                <div class="inner">	
                    <div class="nb-col-30">
                        <p class="label-config"><?php echo $this->__("Change spacing") ?></p>
                        <input type="text" ng-model="editable.spacing" ng-change="setSpacing()" class="input-config shadow hover-shadow" data-toggle="tooltip" data-original-title="<?php echo $this->__('Change spacing') ?>"/>		
                    </div>
                    <div class="nb-col-70">
                        <span class="shadow hover-shadow text-item" ng-click="changeEffect('arc')"><?php echo $this->__("Arc") ?></span>
                        <span class="shadow hover-shadow text-item" ng-click="changeEffect('STRAIGHT')"><?php echo $this->__("Straight") ?></span>
                        <span class="shadow hover-shadow text-item" ng-click="changeEffect('smallToLarge')"><?php echo $this->__("Small to large") ?></span>
                        <span class="shadow hover-shadow text-item" ng-click="changeEffect('largeToSmallTop')"><?php echo $this->__("Large to small top") ?></span>
                        <span class="shadow hover-shadow text-item" ng-click="changeEffect('largeToSmallBottom')"><?php echo $this->__("Large to small bottom") ?></span>
                    </div>
                </div>
                <div class="after"></div>
            </div>	
        </div>	
    </div>	
</div>