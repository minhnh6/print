<?php 
include("inc/global.php");
$id_pro = $_POST['id'];
$sqlpro="SELECT * FROM products WHERE isactive=1  and id={$id_pro} ";
$respro=mysql_query($sqlpro);
$rowpro=mysql_fetch_assoc($respro);
$return_value= array();
$return_value['id'] = $rowpro['id'];
$return_value['ptitle'] = $rowpro['ptitle'];
$return_value['main_image'] = $rowpro['main_image'];
echo json_encode($return_value);
die();
?>
<!--
<div class="bv-cv2-cleanslate bv-mbox-opened">
        <div class="bv-core-container-115">
          <div class="bv-mbox-wide bv-mbox-box">
            <div class="bv-mbox">
              <div class="bv-mbox-sidebar">
                <div class="bv-submission-sidebar">
                  <div class="bv-subject-info-section">
                    <div class="bv-subject-info"> <img class="bv-subject-image" src="<?php echo LINK_PATH;?><?php echo $rowpro['main_image'];?>" alt="<?php echo $rowpro['ptitle'];?>">
                      <h3 class="bv-subject-name-header"> Print Runner - <?php echo $rowpro['ptitle'];?> </h3>
                    </div>
                  </div>
                </div>
              </div>
              <div class="bv-mbox-content-container">
                <h2 class="bv-mbox-breadcrumb"> <span data-bv-mbox-layer-index="0" class="bv-mbox-breadcrumb-item"> <span>My Review for <?php echo $rowpro['ptitle'];?></span> </span>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </h2>
                <div class="bv-mbox-injection-container" style="height: 1060px !important;">
                  <div class="bv-mbox-injection-target bv-mbox-current">
                    <div data-bv-v="submission:1" class="bv-submission bv-submission-image">
                      <div class="bv-compat">
                        <form id="bv-submitreview-product" target="bv-submission-target" action="" accept-charset="utf-8" method="POST" class="bv-form" onsubmit="return false;">
                         <input type="hidden" name="productid" value="<?php echo $id_pro;?>" class="bv-noremember">
							
						  <div class="bv-submission-section">
                            <div class="bv-fieldsets bv-input-fieldsets">
                              <fieldset class="bv-fieldset bv-fieldset-rating bv-radio-field bv-fieldset-active">
							   
                                <span class="bv-fieldset-inner">
									<span class="bv-fieldset-label-wrapper bv-fieldset-label-text" id="bv-fieldset-label-rating"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> Overall Rating* </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation"></span> </span> <span class="bv-off-screen">Rate from 1 to 5 where 1 is poor and 5 is excellent.</span> </span>
									<span class="fieldset-rating-wrapper">
										<input type="text" id="kv-gly-star" class="rating rating-loading"  value="0" data-size="md" data-min=0 data-max=5 data-step=1 title="">
									</span>
									<span class="rating-helper"> 
										<div class="clear-rating"><i class="glyphicon glyphicon-ok"></i></div>
									</span>
								 </span> 
								
                              	
                              </fieldset>
                              <fieldset class="bv-fieldset bv-fieldset-title bv-text-field bv-nocount">
                                <div class="bv-fieldset-arrowicon"></div>
                                <div class="bv-fieldset-inner">
                                  <label for="bv-text-field-title" class="bv-fieldset-label-wrapper"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> Review Title </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation"></span> </span> <span class="bv-off-screen">Example: Great Print Quality!</span> <span class="bv-off-screen">Maximum of 50 characters.</span> </label>
                                  <span class="bv-helper">
                                  <label class="bv-helper-label"></label>
                                  <span class="bv-helper-icon" aria-hidden="true"> <span class="bv-helper-icon-positive"> ✔ </span> <span class="bv-helper-icon-negative"> ✘ </span> </span> </span>
                                  <input id="bv-text-field-title" class="bv-text bv-focusable " type="text" name="title" maxlength="50" placeholder="Example: Great Print Quality!" value="" tabindex="0">
                                </div>
                              </fieldset>
                              <fieldset class="bv-fieldset bv-focusable bv-fieldset-reviewtext bv-textarea-field bv-mincount" tabindex="0">
                                <div class="bv-fieldset-arrowicon"></div>
                                <div class="bv-fieldset-inner">
                                  <label for="bv-textarea-field-reviewtext" class="bv-fieldset-label-wrapper"> <span class="bv-fieldset-label" aria-describedby="reviewtext_validation"> <span class="bv-fieldset-label-text"> Review* </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation">0 out of a minimum 50 characters used</span> </span> <span class="bv-off-screen">Example: I ordered these business cards 2 weeks ago and I'm very happy...</span> </label>
                                  <span class="bv-helper">
                                  <label class="bv-helper-label">0 / 50</label>
                                  <span class="bv-helper-icon" aria-hidden="true"> <span class="bv-helper-icon-positive"> ✔ </span> <span class="bv-helper-icon-negative"> ✘ </span> </span> </span>
                                  <div class="bv-review-field-content-wrapper">
                                    <textarea id="bv-textarea-field-reviewtext" class="bv-focusable " name="reviewtext" maxlength="10000" placeholder="Example: I ordered these business cards 2 weeks ago and I'm very happy..." tabindex="0" style="word-wrap: break-word; overflow: hidden !important; height: 90px !important;"></textarea>
                                    <div class="bv-review-media bv-thumbnail-strip"> </div>
                                  </div>
                                </div>
                              </fieldset>
                              <fieldset class="bv-fieldset bv-fieldset-isrecommended bv-radio-field bv-nocount">
                                <span class="bv-fieldset-arrowicon"></span> <span class="bv-fieldset-inner">
                                <legend class="bv-fieldset-label-wrapper" id="bv-fieldset-label-isrecommended"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> Would you recommend this product to a friend? </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation"></span> </span> </legend>
                                <span class="bv-helper">
                                <label class="bv-helper-label"></label>
                                <span class="bv-helper-icon" aria-hidden="true"> <span class="bv-helper-icon-positive"> ✔ </span> <span class="bv-helper-icon-negative"> ✘ </span> </span> </span> <span class="bv-fieldset-isrecommended-wrapper bv-fieldset-radio-wrapper bv-focusable" role="radiogroup" aria-labelledby="bv-fieldset-label-isrecommended" tabindex="0" aria-owns="bv-radio-isrecommended-true bv-radio-isrecommended-false"> <span class="bv-fieldset-isrecommended-group bv-radio-group">
                                <ul role="presentation">
                                  <li class="bv-radio-isrecommended bv-radio-isrecommended-group-true bv-radio-container-li">
                                    <label class="bv-radio-wrapper-label" for="bv-radio-isrecommended-true" id="bv-radio-isrecommended-true-label">Yes</label>
                                    <input type="radio" id="bv-radio-isrecommended-true" name="isrecommended" class="bv-radio-input bv-isrecommended-input bv-focusable" value="true" data-label="Yes" title="Yes" aria-label="Yes" role="radio" tabindex="0">
                                  </li>
                                  <li class="bv-radio-isrecommended bv-radio-isrecommended-group-false bv-radio-container-li">
                                    <label class="bv-radio-wrapper-label" for="bv-radio-isrecommended-false" id="bv-radio-isrecommended-false-label">No</label>
                                    <input type="radio" id="bv-radio-isrecommended-false" name="isrecommended" class="bv-radio-input bv-isrecommended-input bv-focusable" value="false" data-label="No" title="No" aria-label="No" role="radio" tabindex="0">
                                  </li>
                                </ul>
                                </span> </span> </span>
                              </fieldset>
                              <fieldset class="bv-fieldset bv-fieldset-rating_Quality bv-radio-field bv-fieldset-secondary-rating">
                                <span class="bv-fieldset-arrowicon"></span> <span class="bv-fieldset-inner">
                                <legend class="bv-fieldset-label-wrapper" id="bv-fieldset-label-rating_Quality"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> How would you rate the quality of this product? </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation"></span> </span> </legend>
                                <span class="bv-helper">
                                <label class="bv-helper-label"></label>
                                <span class="bv-helper-icon" aria-hidden="true"> <span class="bv-helper-icon-positive"> ✔ </span> <span class="bv-helper-icon-negative"> ✘ </span> </span> </span> <span class="bv-fieldset-rating_Quality-wrapper bv-fieldset-radio-wrapper bv-focusable" role="radiogroup" aria-labelledby="bv-fieldset-label-rating_Quality" tabindex="0" aria-owns="bv-radio-rating_Quality-1 bv-radio-rating_Quality-2 bv-radio-rating_Quality-3 bv-radio-rating_Quality-4 bv-radio-rating_Quality-5"> <span class="bv-fieldset-rating_Quality-group bv-radio-group"> <span class="bv-submission-star-rating-control"><span class="bv-submission-star-rating bv-submission-rater-0 bv-radio-input bv-rating_Quality-input bv-rating-input bv-secondary-rating-input bv-submission-star-rating-applied bv-submission-star-rating-live"> <a class="bv-rating-link bv-focusable" id="bv-radio-rating_Quality-1" role="radio" href="javascript:void(0)" title="Poor" aria-checked="false" tabindex="0"> <span aria-hidden="true">★</span> <span class="bv-off-screen">Poor</span> </a> </span><span class="bv-submission-star-rating bv-submission-rater-0 bv-radio-input bv-rating_Quality-input bv-rating-input bv-secondary-rating-input bv-submission-star-rating-applied bv-submission-star-rating-live"> <a class="bv-rating-link bv-focusable" id="bv-radio-rating_Quality-2" role="radio" href="javascript:void(0)" title="Fair" aria-checked="false" tabindex="0"> <span aria-hidden="true">★</span> <span class="bv-off-screen">Fair</span> </a> </span><span class="bv-submission-star-rating bv-submission-rater-0 bv-radio-input bv-rating_Quality-input bv-rating-input bv-secondary-rating-input bv-submission-star-rating-applied bv-submission-star-rating-live"> <a class="bv-rating-link bv-focusable" id="bv-radio-rating_Quality-3" role="radio" href="javascript:void(0)" title="Average" aria-checked="false" tabindex="0"> <span aria-hidden="true">★</span> <span class="bv-off-screen">Average</span> </a> </span><span class="bv-submission-star-rating bv-submission-rater-0 bv-radio-input bv-rating_Quality-input bv-rating-input bv-secondary-rating-input bv-submission-star-rating-applied bv-submission-star-rating-live"> <a class="bv-rating-link bv-focusable" id="bv-radio-rating_Quality-4" role="radio" href="javascript:void(0)" title="Good" aria-checked="false" tabindex="0"> <span aria-hidden="true">★</span> <span class="bv-off-screen">Good</span> </a> </span><span class="bv-submission-star-rating bv-submission-rater-0 bv-radio-input bv-rating_Quality-input bv-rating-input bv-secondary-rating-input bv-submission-star-rating-applied bv-submission-star-rating-live"> <a class="bv-rating-link bv-focusable" id="bv-radio-rating_Quality-5" role="radio" href="javascript:void(0)" title="Excellent" aria-checked="false" tabindex="0"> <span aria-hidden="true">★</span> <span class="bv-off-screen">Excellent</span> </a> </span></span>
                                <ul role="presentation">
                                  <li class="bv-radio-rating bv-radio-rating_Quality-group-1 bv-radio-container-li">
                                    <input type="radio" name="rating_Quality" class="bv-radio-input bv-rating_Quality-input bv-rating-input bv-secondary-rating-input  bv-submission-star-rating-applied bv-hidden" value="1" title="Poor" role="presentation" aria-hidden="true" style="display: none;">
                                  </li>
                                  <li class="bv-radio-rating bv-radio-rating_Quality-group-2 bv-radio-container-li">
                                    <input type="radio" name="rating_Quality" class="bv-radio-input bv-rating_Quality-input bv-rating-input bv-secondary-rating-input  bv-submission-star-rating-applied bv-hidden" value="2" title="Fair" role="presentation" aria-hidden="true" style="display: none;">
                                  </li>
                                  <li class="bv-radio-rating bv-radio-rating_Quality-group-3 bv-radio-container-li">
                                    <input type="radio" name="rating_Quality" class="bv-radio-input bv-rating_Quality-input bv-rating-input bv-secondary-rating-input  bv-submission-star-rating-applied bv-hidden" value="3" title="Average" role="presentation" aria-hidden="true" style="display: none;">
                                  </li>
                                  <li class="bv-radio-rating bv-radio-rating_Quality-group-4 bv-radio-container-li">
                                    <input type="radio" name="rating_Quality" class="bv-radio-input bv-rating_Quality-input bv-rating-input bv-secondary-rating-input  bv-submission-star-rating-applied bv-hidden" value="4" title="Good" role="presentation" aria-hidden="true" style="display: none;">
                                  </li>
                                  <li class="bv-radio-rating bv-radio-rating_Quality-group-5 bv-radio-container-li">
                                    <input type="radio" name="rating_Quality" class="bv-radio-input bv-rating_Quality-input bv-rating-input bv-secondary-rating-input  bv-submission-star-rating-applied bv-hidden" value="5" title="Excellent" role="presentation" aria-hidden="true" style="display: none;">
                                  </li>
                                </ul>
                                </span> <span class="bv-rating_Quality-helper-1" aria-hidden="true">Click to rate!</span> </span> </span>
                              </fieldset>
                              <fieldset class="bv-fieldset bv-fieldset-rating_Value bv-radio-field bv-fieldset-secondary-rating">
                                <span class="bv-fieldset-arrowicon"></span> <span class="bv-fieldset-inner">
                                <legend class="bv-fieldset-label-wrapper" id="bv-fieldset-label-rating_Value"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> How would you rate the value of this product? </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation"></span> </span> </legend>
                                <span class="bv-helper">
                                <label class="bv-helper-label"></label>
                                <span class="bv-helper-icon" aria-hidden="true"> <span class="bv-helper-icon-positive"> ✔ </span> <span class="bv-helper-icon-negative"> ✘ </span> </span> </span> <span class="bv-fieldset-rating_Value-wrapper bv-fieldset-radio-wrapper bv-focusable" role="radiogroup" aria-labelledby="bv-fieldset-label-rating_Value" tabindex="0" aria-owns="bv-radio-rating_Value-1 bv-radio-rating_Value-2 bv-radio-rating_Value-3 bv-radio-rating_Value-4 bv-radio-rating_Value-5"> <span class="bv-fieldset-rating_Value-group bv-radio-group"> <span class="bv-submission-star-rating-control"><span class="bv-submission-star-rating bv-submission-rater-0 bv-radio-input bv-rating_Value-input bv-rating-input bv-secondary-rating-input bv-submission-star-rating-applied bv-submission-star-rating-live"> <a class="bv-rating-link bv-focusable" id="bv-radio-rating_Value-1" role="radio" href="javascript:void(0)" title="Poor" aria-checked="false" tabindex="0"> <span aria-hidden="true">★</span> <span class="bv-off-screen">Poor</span> </a> </span><span class="bv-submission-star-rating bv-submission-rater-0 bv-radio-input bv-rating_Value-input bv-rating-input bv-secondary-rating-input bv-submission-star-rating-applied bv-submission-star-rating-live"> <a class="bv-rating-link bv-focusable" id="bv-radio-rating_Value-2" role="radio" href="javascript:void(0)" title="Fair" aria-checked="false" tabindex="0"> <span aria-hidden="true">★</span> <span class="bv-off-screen">Fair</span> </a> </span><span class="bv-submission-star-rating bv-submission-rater-0 bv-radio-input bv-rating_Value-input bv-rating-input bv-secondary-rating-input bv-submission-star-rating-applied bv-submission-star-rating-live"> <a class="bv-rating-link bv-focusable" id="bv-radio-rating_Value-3" role="radio" href="javascript:void(0)" title="Average" aria-checked="false" tabindex="0"> <span aria-hidden="true">★</span> <span class="bv-off-screen">Average</span> </a> </span><span class="bv-submission-star-rating bv-submission-rater-0 bv-radio-input bv-rating_Value-input bv-rating-input bv-secondary-rating-input bv-submission-star-rating-applied bv-submission-star-rating-live"> <a class="bv-rating-link bv-focusable" id="bv-radio-rating_Value-4" role="radio" href="javascript:void(0)" title="Good" aria-checked="false" tabindex="0"> <span aria-hidden="true">★</span> <span class="bv-off-screen">Good</span> </a> </span><span class="bv-submission-star-rating bv-submission-rater-0 bv-radio-input bv-rating_Value-input bv-rating-input bv-secondary-rating-input bv-submission-star-rating-applied bv-submission-star-rating-live"> <a class="bv-rating-link bv-focusable" id="bv-radio-rating_Value-5" role="radio" href="javascript:void(0)" title="Excellent" aria-checked="false" tabindex="0"> <span aria-hidden="true">★</span> <span class="bv-off-screen">Excellent</span> </a> </span></span>
                                <ul role="presentation">
                                  <li class="bv-radio-rating bv-radio-rating_Value-group-1 bv-radio-container-li">
                                    <input type="radio" name="rating_Value" class="bv-radio-input bv-rating_Value-input bv-rating-input bv-secondary-rating-input  bv-submission-star-rating-applied bv-hidden" value="1" title="Poor" role="presentation" aria-hidden="true" style="display: none;">
                                  </li>
                                  <li class="bv-radio-rating bv-radio-rating_Value-group-2 bv-radio-container-li">
                                    <input type="radio" name="rating_Value" class="bv-radio-input bv-rating_Value-input bv-rating-input bv-secondary-rating-input  bv-submission-star-rating-applied bv-hidden" value="2" title="Fair" role="presentation" aria-hidden="true" style="display: none;">
                                  </li>
                                  <li class="bv-radio-rating bv-radio-rating_Value-group-3 bv-radio-container-li">
                                    <input type="radio" name="rating_Value" class="bv-radio-input bv-rating_Value-input bv-rating-input bv-secondary-rating-input  bv-submission-star-rating-applied bv-hidden" value="3" title="Average" role="presentation" aria-hidden="true" style="display: none;">
                                  </li>
                                  <li class="bv-radio-rating bv-radio-rating_Value-group-4 bv-radio-container-li">
                                    <input type="radio" name="rating_Value" class="bv-radio-input bv-rating_Value-input bv-rating-input bv-secondary-rating-input  bv-submission-star-rating-applied bv-hidden" value="4" title="Good" role="presentation" aria-hidden="true" style="display: none;">
                                  </li>
                                  <li class="bv-radio-rating bv-radio-rating_Value-group-5 bv-radio-container-li">
                                    <input type="radio" name="rating_Value" class="bv-radio-input bv-rating_Value-input bv-rating-input bv-secondary-rating-input  bv-submission-star-rating-applied bv-hidden" value="5" title="Excellent" role="presentation" aria-hidden="true" style="display: none;">
                                  </li>
                                </ul>
                                </span> <span class="bv-rating-helper bv-rating_Value-helper-1" aria-hidden="true">Click to rate!</span> </span> </span>
                              </fieldset>
                              <fieldset class="bv-fieldset bv-fieldset-usernickname bv-text-field bv-fieldset-small bv-mincount">
                                <div class="bv-fieldset-arrowicon"></div>
                                <div class="bv-fieldset-inner">
                                  <label for="bv-text-field-usernickname" class="bv-fieldset-label-wrapper"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> Nickname* </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation">0 out of a minimum 4 characters used</span> </span> <span class="bv-off-screen">Example: jackie27</span> <span class="bv-off-screen">Maximum of 25 characters.</span> </label>
                                  <span class="bv-helper">
                                  <label class="bv-helper-label">0 / 4</label>
                                  <span class="bv-helper-icon" aria-hidden="true"> <span class="bv-helper-icon-positive"> ✔ </span> <span class="bv-helper-icon-negative"> ✘ </span> </span> </span>
                                  <input id="bv-text-field-usernickname" class="bv-text bv-focusable " type="text" name="usernickname" maxlength="25" placeholder="Example: jackie27" value="" tabindex="0">
                                </div>
                              </fieldset>
                              <fieldset class="bv-fieldset bv-fieldset-userlocation bv-text-field bv-nocount bv-fieldset-small">
                                <div class="bv-fieldset-arrowicon"></div>
                                <div class="bv-fieldset-inner">
                                  <label for="bv-text-field-userlocation" class="bv-fieldset-label-wrapper"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> Location </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation"></span> </span> <span class="bv-off-screen">Example: New York, NY</span> <span class="bv-off-screen">Maximum of 50 characters.</span> <span class="bv-off-screen">Autocomplete available, press the down arrow to hear options</span></label>
                                  <span class="bv-helper">
                                  <label class="bv-helper-label"></label>
                                  <span class="bv-helper-icon" aria-hidden="true"> <span class="bv-helper-icon-positive"> ✔ </span> <span class="bv-helper-icon-negative"> ✘ </span> </span> </span>
                                  <input id="bv-text-field-userlocation" class="bv-text bv-focusable  bv-autocomplete-input" type="text" name="userlocation" maxlength="50" placeholder="Example: New York, NY" value="" tabindex="0" autocomplete="off">
                                </div>
                              </fieldset>
                              <fieldset class="bv-fieldset bv-fieldset-hostedauthentication_authenticationemail bv-email-field bv-nocount bv-fieldset-small-alone">
                                <div class="bv-fieldset-arrowicon"></div>
                                <div class="bv-fieldset-inner">
                                  <label for="bv-email-field-hostedauthentication_authenticationemail" class="bv-fieldset-label-wrapper"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> Email* </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation"></span> </span> <span class="bv-off-screen">Example: youremail@example.com</span> <span class="bv-off-screen">Maximum of 255 characters.</span> </label>
                                  <span class="bv-helper">
                                  <label class="bv-helper-label"></label>
                                  <span class="bv-helper-icon" aria-hidden="true"> <span class="bv-helper-icon-positive"> ✔ </span> <span class="bv-helper-icon-negative"> ✘ </span> </span> </span>
                                  <input id="bv-email-field-hostedauthentication_authenticationemail" class="bv-text bv-focusable bv-email" type="email" name="hostedauthentication_authenticationemail" maxlength="255" placeholder="Example: youremail@example.com" value="" tabindex="0">
                                </div>
                              </fieldset>
                              <fieldset class="bv-fieldset bv-fieldset-contextdatavalue_Gender bv-select-field">
                                <div class="bv-fieldset-arrowicon"></div>
                                <div class="bv-fieldset-inner">
                                  <label for="bv-select-field-contextdatavalue_Gender" class="bv-fieldset-label-wrapper"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> What is your gender? </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation"></span> </span> </label>
                                  <span class="bv-helper">
                                  <label class="bv-helper-label"></label>
                                  <span class="bv-helper-icon" aria-hidden="true"> <span class="bv-helper-icon-positive"> ✔ </span> <span class="bv-helper-icon-negative"> ✘ </span> </span> </span> <span class="bv-fieldset-select-wrapper">
                                  <select id="bv-select-field-contextdatavalue_Gender" class="bv-select-cleanslate bv-select bv-focusable bv-fastclick-ignore" name="contextdatavalue_Gender" tabindex="0">
                                    <option value="" selected="selected" class="bv-option-disabled" disabled="disabled"> Select </option>
                                    <option value="Male"> Male </option>
                                    <option value="Female"> Female </option>
                                  </select>
                                  <button type="button" class="bv-dropdown-arrow" aria-hidden="true" onclick="return false;">▼</button>
                                  </span> </div>
                              </fieldset>
                              <fieldset class="bv-fieldset bv-fieldset-contextdatavalue_CompanySize bv-select-field">
                                <div class="bv-fieldset-arrowicon"></div>
                                <div class="bv-fieldset-inner">
                                  <label for="bv-select-field-contextdatavalue_CompanySize" class="bv-fieldset-label-wrapper"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> How many employees are in your company/organization? </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation"></span> </span> </label>
                                  <span class="bv-helper">
                                  <label class="bv-helper-label"></label>
                                  <span class="bv-helper-icon" aria-hidden="true"> <span class="bv-helper-icon-positive"> ✔ </span> <span class="bv-helper-icon-negative"> ✘ </span> </span> </span> <span class="bv-fieldset-select-wrapper">
                                  <select id="bv-select-field-contextdatavalue_CompanySize" class="bv-select-cleanslate bv-select bv-focusable bv-fastclick-ignore" name="contextdatavalue_CompanySize" tabindex="0">
                                    <option value="" selected="selected" class="bv-option-disabled" disabled="disabled"> Select </option>
                                    <option value="1Person"> 1 Person </option>
                                    <option value="25People"> 2–5 People </option>
                                    <option value="69People"> 6–9 People </option>
                                    <option value="1019People"> 10-19 People </option>
                                    <option value="2049People"> 20–49 People </option>
                                    <option value="50People"> 50+ People </option>
                                    <option value="ImAnIndividualNotACompanyorganization"> I'm an individual, not a company/organization. </option>
                                  </select>
                                  <button type="button" class="bv-dropdown-arrow" aria-hidden="true" onclick="return false;">▼</button>
                                  </span> </div>
                              </fieldset>
                              <fieldset class="bv-fieldset bv-fieldset-contextdatavalue_HowDidYouHearAboutPrintrunner bv-select-field">
                                <div class="bv-fieldset-arrowicon"></div>
                                <div class="bv-fieldset-inner">
                                  <label for="bv-select-field-contextdatavalue_HowDidYouHearAboutPrintrunner" class="bv-fieldset-label-wrapper"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> How did you hear about PrintRunner? </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation"></span> </span> </label>
                                  <span class="bv-helper">
                                  <label class="bv-helper-label"></label>
                                  <span class="bv-helper-icon" aria-hidden="true"> <span class="bv-helper-icon-positive"> ✔ </span> <span class="bv-helper-icon-negative"> ✘ </span> </span> </span> <span class="bv-fieldset-select-wrapper">
                                  <select id="bv-select-field-contextdatavalue_HowDidYouHearAboutPrintrunner" class="bv-select-cleanslate bv-select bv-focusable bv-fastclick-ignore" name="contextdatavalue_HowDidYouHearAboutPrintrunner" tabindex="0">
                                    <option value="" selected="selected" class="bv-option-disabled" disabled="disabled"> Select </option>
                                    <option value="Google"> Google </option>
                                    <option value="Bing"> Bing </option>
                                    <option value="Colleague"> Colleague </option>
                                    <option value="Friend"> Friend </option>
                                    <option value="Other"> Other </option>
                                  </select>
                                  <button type="button" class="bv-dropdown-arrow" aria-hidden="true" onclick="return false;">▼</button>
                                  </span> </div>
                              </fieldset>
                            </div>
                            <div class="bv-fieldsets bv-fieldsets-actions">
                              <fieldset class="bv-form-actions bv-fieldset">
                                <div class="bv-fieldset-arrowicon"></div>
                                <div class="bv-fieldset-inner">
                                  <div class="bv-actions-container">
                                    <p id="bv-casltext-review" class="bv-fieldset-casltext">You may receive emails regarding this submission. Any emails will include the ability to opt-out of future communications.</p>
                                    <button type="button" aria-label="Post Review. You may receive emails regarding this submission. Any emails will include the ability to opt-out of future communications." class="bv-form-actions-submit bv-submit bv-focusable bv-submission-button-submit" name="bv-submit-button" tabindex="0">Post Review</button>
                                    <button type="button" class="bv-form-action bv-cancel bv-submission-button-submit" onclick="return false;">Cancel</button>
                                  </div>
                                </div>
                              </fieldset>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="/rating/js/star-rating.js" type="text/javascript"></script>
<script>
alert('dsfsd');
$('#kv-gly-star').
$('#kv-gly-star').on('rating.change', function () {
			alert('dsfsd');
             alert($('#kv-gly-star').val());
         });
    $(document).on('ready', function () {
		
    	
       
    });
</script> -->
