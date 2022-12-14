<?php
$current_theme = Mage::getSingleton('core/design_package')->getPackageName();
$img_skin_path_css = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/'.$current_theme.'/default/cmsmart/onlinedesign/css/images';
?>

<div class="modal fade" id="dg-myclipart">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>				
                <ul role="tablist" id="upload-tabs" class="nbdesigner_modal_tab">
                    <li class="active"><a href="#upload-computer" role="tab" data-toggle="tab"><i class="fa fa-cloud-upload visible-xs" aria-hidden="true"></i><span class="hidden-xs"><?php echo $this->__("Upload photo") ?></span></a></li>					
                    <li><a href="#uploaded-photo" role="tab" data-toggle="tab"><i class="fa fa-cloud visible-xs" aria-hidden="true"></i><span class="hidden-xs"><?php echo $this->__("Uploaded") ?></span></a></li>
                    <li><a href="#nbdesigner_url" role="tab" data-toggle="tab"><i class="fa fa-link visible-xs" aria-hidden="true"></i><span class="hidden-xs"><?php echo $this->__("Image Url") ?></span></a></li>
                    <li><a href="#nbdesigner_facebook" role="tab" data-toggle="tab"><i class="fa fa-facebook-square visible-xs" aria-hidden="true"></i><span class="hidden-xs"><?php echo $this->__("Facebook") ?></span></a></li>
					<li ng-if="hasGetUserMedia && !modeMobile" ng-click="initWebcam()"><a href="#nbdesigner_webcam" role="tab" data-toggle="tab"><i class="fa fa-camera visible-xs" aria-hidden="true"></i><span class="hidden-xs"><?php echo $this->__("Webcam") ?></span></a></li>
				</ul>
            </div>
            <div class="modal-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="upload-computer">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label><?php echo $this->__("Choose a file upload") ?></label>
                                    <input type="file" id="files-upload" autocomplete="off" ng-file-select="onFileSelect($files)" accept="image/*"/><br />
                                    <p>
                                        <small><?php echo $this->__("Accept file types: ") ?><strong>png, jpg, gif</strong>
                                        <br /><?php echo $this->__("Max file size: ") ?><strong><span id="nbdesigner_maxsize"></span> MB</strong></small>
                                    </p>
                                </div>
                            </div>							
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary shadow nbdesigner_upload" id="action-upload" ng-click="startUpload()"><?php echo $this->__("Upload") ?></button>
                                </div>
                            </div>                         
                        </div>
                    </div>		
					
                    <div class="tab-pane" id="uploaded-photo">
                        <div class="row" id="dag-files-images">
                            <span class="view-thumb" ng-repeat="url in uploadURL | reverse | limitTo : imgPageSize">
                                <img class="img-responsive img-thumbnail nbdesigner_upload_image shadow hover-shadow" ng-src="{{url}}" ng-click="addImage(url)"  spinner-on-load/>
                            </span>                                                    
                        </div>						
                        <div id="image-load-more" ng-show="(uploadURL.length > 10) && (uploadURL.length > imgPageSize)"><button type="button" style="margin-top: 10px;" class="btn btn-primary shadow nbdesigner_upload" ng-click="imgPageSize = imgPageSize +10"><?php echo $this->__("More") ?></button></div>
                        <div class="progress progress-bar-container" ng-show="loading">
                            <div class="progress-bar progress-bar-striped"  role="progressbar" aria-valuenow="{{progressUpload}}"
                                 aria-valuemin="0" aria-valuemax="100" ng-style="{'width': progressUpload + '%'}" >{{progressUpload}}%</div>
                        </div>                                                
                        <div class="row col-md-12">
                            <span class="help-block"><?php echo $this->__("Click image to add design.") ?></span>
                        </div>
                    </div>
					
                    <div class="tab-pane" id="nbdesigner_facebook">
                        <?php include_once 'tab_facebook_photo.php'; ?>
                        <div id="uploaded-facebook"></div>
                        <div>
                            <input type="hidden" id="nbdesigner_fb_next" value=""/>
                            <button style="margin-right: 15px; margin-top: 10px;" id="facebook-load-more" type="button" class="hidden btn btn-primary shadow nbdesigner_upload" ng-click="loadMoreFacebookPhoto()"><?php echo $this->__("More") ?></button>
                            <img id="loading_fb_upload" class="hidden" src="<?php echo $img_skin_path_css .'/ajax-loader.gif'; ?>" />
                        </div>
                    </div>
					
                    <div class="tab-pane" id="nbdesigner_url">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>{{(langs['IMAGE_URL1']) ? langs['IMAGE_URL1'] : "Image URL"}}</label>
                                    <input class="form-control hover-shadow nbdesigner_image_url" ng-model="imageFromUrl"  placeholder="{{(langs['ENTER_YOUR_IMAGE_URL']) ? langs['ENTER_YOUR_IMAGE_URL'] : 'Enter your image url'}}"/><br />
                                </div>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary shadow nbdesigner_upload"  ng-click="addImageFromUrl()">{{(langs['INSERT']) ? langs['INSERT'] : "Insert"}}</button>
                                </div>
                            </div>                            
                        </div>                        
                    </div>
					
                    <div ng-if="hasGetUserMedia && !modeMobile" class="tab-pane" id="nbdesigner_webcam">
                        <div class="row">
                            <div class="col-xs-12 con-webcam" id="my_camera" ng-show="statusWebcam"></div>    
                            <div class="col-xs-12 con-webcam off" ng-show="!statusWebcam">
                                <i class="fa fa-camera icon-camera" aria-hidden="true"></i>
                            </div>                               
                        </div>
                        <div style="margin-top: 15px;">
                            <button ng-disabled="!statusWebcam" class="btn btn-primary shadow nbdesigner_upload" ng-click="pauseWebcam()">{{(langs['PAUSE']) ? langs['PAUSE'] : "Pause"}}</button>                     
                            <button ng-disabled="!statusWebcam" class="btn btn-primary shadow nbdesigner_upload" ng-click="unPauseWebcam()">{{(langs['UNPAUSE']) ? langs['UNPAUSE'] : "Un Pause"}}</button>                     
                            <button class="btn btn-primary shadow nbdesigner_upload" ng-click="resetWebcam()">{{(langs['STOPWEBCAM']) ? langs['STOPWEBCAM'] : "Stop Webcam"}}</button> 
                            <button ng-disabled="!statusWebcam" class="btn btn-primary shadow nbdesigner_upload" ng-click="takeSnapshot()">{{(langs['CAPTURE']) ? langs['CAPTURE'] : "Capture"}}</button>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>