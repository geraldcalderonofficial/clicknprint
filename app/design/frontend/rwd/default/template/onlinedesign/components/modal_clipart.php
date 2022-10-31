<?php
$current_theme = Mage::getSingleton('core/design_package')->getPackageName();
$img_skin_path_css = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/'.$current_theme.'/default/cmsmart/onlinedesign/css/images';
?>
<div id="dg-cliparts" class="modal fade nbdesigner_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button style="margin-top: 0;" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>	
                <div class="nbdesigner_art_modal_header">
                    <span><?php echo $this->__("Cliparts") ?></span>
                    <input type="search" class="form-control hover-shadow" placeholder="<?php echo $this->__('Search Art') ?>" ng-model="artName"/>
                    <div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle shadow hover-shadow" type="button" data-toggle="dropdown">{{currentCatArtName}}&nbsp;<span class="caret"></span></button>
                        <ul class="dropdown-menu dropup  shadow hover-shadow">
                            <li ng-repeat="cat in artCat">
                                <a ng-click="changeArtCat(cat)">{{cat.name}}</a>
                            </li>                            
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div id="nbdesigner_art_container">
                    <span class="view-thumb nbdesigner_thumb" width="100" ng-repeat="art in arts | filterCat : curentCatArt | filter : artName| limitTo : artPageSize">
                        <img style="max-width: 100px; max-height: 100px;" class="img-responsive img-thumbnail nbdesigner_upload_image shadow hover-shadow" ng-src="{{art.url}}" ng-click="addArt(art)"  spinner-on-load/>
                    </span>
                </div>
                <div>
                    <button ng-show="(countArt > 10) && (countArt > artPageSize)" style="margin-right: 15px; margin-top: 10px;" id="art-load-more" type="button" class="btn btn-primary shadow nbdesigner_upload" ng-click="artPageSize = artPageSize +10"><?php echo $this->__("More") ?></button>
                    <img id="loading_art_upload" class="hidden" src="<?php echo $img_skin_path_css .'/ajax-loader.gif'; ?>" />
                </div>
            </div>
        </div>
    </div>
</div>