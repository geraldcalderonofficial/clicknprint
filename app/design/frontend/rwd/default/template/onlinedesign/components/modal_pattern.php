<?php
$current_theme = Mage::getSingleton('core/design_package')->getPackageName();
$img_skin_path_css = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/'.$current_theme.'/default/cmsmart/onlinedesign/css/images';
?>
<div class="modal fade" id="dg-pattern">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding-bottom: 15px;">
                <b><?php echo $this->__("Pattern") ?></b>
                <button style="margin-top: 0;" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>						
            </div>
            <div class="modal-body" style="padding: 15px;">
                <div class="list-pattern" id="pattern-boddy">
                    <img class="pattern_img shadow hover-shadow" ng-repeat="pattern in patterns | limitTo : patternPageSize" ng-src="{{ajustUrl(pattern.path)}}" spinner-on-load ng-click="changePattern(pattern.path)"/>
                </div>
                <p><button class="btn btn-primary shadow nbdesigner_upload" style="margin-right: 15px; margin-top: 10px;" ng-show="patterns.length > patternPageSize" ng-click="patternPageSize = patternPageSize + 10"><?php echo $this->__("More") ?></button>
                    <img id="loading_pattern" class="hidden" src="<?php echo $img_skin_path_css.'/ajax-loader.gif'; ?>" /></p>
            </div>
        </div>
    </div>
</div>