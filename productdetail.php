<?php
session_start();
include('inc/global.php');
$Protitle=$_GET['ptitle'];
if(strpos($Protitle,'-printing')) {
	$Protitle=substr($Protitle,0,-9);	
}
$sqlpro="SELECT * FROM products WHERE isactive=1  and REPLACE(REPLACE(ptitle,'.','_'),' ','-')='".$Protitle."'";
$respro=mysql_query($sqlpro);
$rowpro=mysql_fetch_assoc($respro);
$MetaTitle=$rowpro['metatitle'];
$MetaKeywords=$rowpro['metakeywords'];
$MetaDescriprtion=$rowpro['metadescriprtion'];
$id_pro = $rowpro['id'];
include('inc/header.php');

$sql_cat="SELECT * FROM category WHERE isactive=1 and id={$rowpro['cat_id']} ";
$rescat=mysql_query($sql_cat);
$rowcat=mysql_fetch_assoc($rescat);
$name_cat = $rowcat["prod_title"];

$menulink=strtolower($rowcat['prod_title']);
$menulink=str_replace(' ','-',$menulink);
$menulink .='-printing';
$url = LINK_PATH.$menulink.'.html';
          
 ?>
<!--/header-->
<section id="breadcrumbs-fram">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= LINK_PATH ?>">Home</a></li>
      <li class="breadcrumb-item"><a href="<?php echo $url?>"><?php echo $name_cat?></a></li>
      <li class="breadcrumb-item active"><?php echo $rowpro["ptitle"];?></li>
    </ol>
  </div>
</section>
<!--/BreadCrumb-->
<section class="add-to-cart">
  <div class="container">
    <div class="row">
      <div class="col-md-2 col-sm-2">
        <nav class="navbar navbar-default product-detail-nav" role="navigation">
          <div class="navbar-header"> <a id="menu-toggle" href="#" class="navbar-toggle"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> </div>
          <div id="sidebar-wrapper" class="sidebar-toggle">
            <h4>Most Popular</h4>
			<?php include('inc/cate-left.php'); ?>
            
            <h4>More Products</h4>
			<?php include('inc/pro-left.php'); ?>
           
          </div>
        </nav>
      </div>
    <div class="col-md-7 col-sm-7">
    	
        <div class="product-detail-inner">
          <h1><?php echo $rowpro["ptitle"];?></h1>
          <ul>
          	<?php
				//xu hien thị rating
			$sql_rating ="SELECT  * FROM v_rating WHERE id_pro='{$id_pro}' and isactive=1 ";
			$result = mysql_query($sql_rating);
			$i=$strat=0;
			if(mysql_num_rows($result) > 0){
				
				$sum_strat1 = $sum_strat2=$sum_strat3=$sum_strat4=$sum_strat5 = 0;
				while($row=mysql_fetch_assoc($result)){
					switch($row["over_rat"]){
						case 1:  
							$sum_strat1++;
							break;
						case 2:  
							$sum_strat2++;
							break;
						case 3:  
							$sum_strat3++;
							break;
						case 4:  
							$sum_strat4++;
							break;
						case 5:  
							$sum_strat5++;
							break;
					}
					
					$i++;
				}
				//echo $i; 
				$strat = ((5*$sum_strat5)+(4*$sum_strat4)+(3*$sum_strat3)+(2*$sum_strat2)+(1*$sum_strat1))/$i;
			}
			?>
            <li class="start"><input type="text" id="input-21f" class="rating rating-loading"  value="<?php echo $strat;?>" data-size="ms" data-min=0 data-max=5  title=""></li>
            <li class="coments"><a href="#"><?php echo $strat;?> </a><span>(<?php echo $i;?>)</span></li>
            <li><a href=""  onclick="modal_rating('<?php echo $id_pro;?>')" data-toggle="modal" data-target="#myModal"> Write a review </a></li>
          </ul>
        </div>
        <div class="row">
          <div class="col-md-6 col-sm-6"> <img src="<?php echo LINK_PATH;?><?php echo $rowpro['main_image'];?>" class="img-responsive"> </div>
          <div class="col-md-6 col-sm-6">
            <div class="product-detail-description">
              <?php echo $rowpro['learnmore_top'];?>
            </div>
          </div>
        </div>
        <div class="bookmarks-inner">
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Specs</a></li>
            <li><a data-toggle="tab" href="#menu1">Reviews</a></li>
            <li><a data-toggle="tab" href="#menu2">Templates</a></li>
            <li><a data-toggle="tab" href="#menu3">Overview</a></li>
          </ul>
          <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
              <?php echo $rowpro['learnmore_bottom'];?>
             </div>
            <div id="menu1" class="tab-pane fade">
              <h3>Reviews</h3>
              <a href="" onclick="modal_rating('<?php echo $id_pro;?>')" data-toggle="modal" data-target="#myModal"> Write a review </a> </div>
            <div id="menu2" class="tab-pane fade">
              <h3>Download Blank Print Templates</h3>
              <p>Set up your print file with correct trim and folding lines by downloading a blank template for your preferred design software. Learn more about setting up print files in our <a href="#">Learning Center.</a></p>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Final Dimensions</th>
                    <th>Description</th>
                    <th>Download</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>2" x 6"</td>
                    <td>Standard</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2" x 7"</td>
                    <td>Standard</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2.5" x 8.5"</td>
                    <td>Standard</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2" x 7"</td>
                    <td>Rounded Corners</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2" x 6"</td>
                    <td>Rounded Corners</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2.5" x 8.5"</td>
                    <td>Rounded Corners</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2" x 6"</td>
                    <td>Standard 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2" x 7"</td>
                    <td>Standard 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2.5" x 8.5"</td>
                    <td>Standard 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2" x 6"</td>
                    <td>Rounded Corners with 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2" x 7"</td>
                    <td>Rounded Corners with 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2.5" x 8.5"</td>
                    <td>Rounded Corners with 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2" x 6"</td>
                    <td>Standard 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2" x 7"</td>
                    <td>Standard 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2.5" x 8.5"</td>
                    <td>Standard 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                  <tr>
                    <td>2" x 6"</td>
                    <td>Rounded Corners with 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2" x 7"</td>
                    <td>Rounded Corners with 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2.5" x 8.5"</td>
                    <td>Rounded Corners with 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2" x 6"</td>
                    <td>Standard 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2" x 7"</td>
                    <td>Standard 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2.5" x 8.5"</td>
                    <td>Standard 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                  <tr>
                    <td>2" x 6"</td>
                    <td>Rounded Corners with 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2" x 7"</td>
                    <td>Rounded Corners with 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                  <tr>
                    <td>2.5" x 8.5"</td>
                    <td>Rounded Corners with 3/16" Hole on Top Left</td>
                    <td><a href="#"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div id="menu3" class="tab-pane fade">
              <h3>Custom Bookmark Printing & Design Services for Less</h3>
              <hr>
              <p> There are lots of marketing tools you may use in promoting your brand -- using bookmarks is one of them. Bookmark marketing is worth considering because it has a potential of reaching a wide market. With the correct message and the right design, bookmarks can become functional advertising pieces of cardboards.</p>
              <p> Start a practical and creative technique with bookmark marketing. PrintRunner prints from 250 pieces to 100,000. Choose from three sizes and four paper types, including option of using 100% recycled paper. Rounded corners? No problem. You may also choose to have your bookmark punched or not. Choose from 3 popular bookmark sizes: 2" x 6", 2" x 7",  2.5" x 8.5". </p>
              <p> Bookmarks are great for word of mouth and can refer more customers by getting your business out there. Be creative when designing your bookmarks, it plays an important role to get noticed. Here in PrintRunner, you can have your bookmarks printed in full color to make a long-lasting impression. </p>
              <p>Download our bookmark template and use it as guide when designing. Upload you finished design on the site and we'll check it for free. </p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-3">
      	<?php include('inc/pro-printing.php'); ?>
        
      </div>
   
   
    </div>
  </div>
</section>


<div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"> 
        <!-- content dynamically inserted --> 
      </div>
    </div>
  </div>
</div>
<!--model-->
<div class="modal fade" id="myModal" role="dialog">
  <div class="rating-dialog">
    <div class="modal-body">
      <div class="bv-cv2-cleanslate bv-mbox-opened">
        <div class="bv-core-container-115">
          <div class="bv-mbox-wide bv-mbox-box">
            <div class="bv-mbox">
              <div class="bv-mbox-sidebar">
                <div class="bv-submission-sidebar">
                  <div class="bv-subject-info-section">
                    <div class="bv-subject-info"><span class="ajxa-img"></span> 
                      <h3 class="bv-subject-name-header"> Print Runner - <span class="ptitle"></span></h3>
                    </div>
                  </div>
                </div>
              </div>
              <div class="bv-mbox-content-container">
                <h2 class="bv-mbox-breadcrumb"> <span data-bv-mbox-layer-index="0" class="bv-mbox-breadcrumb-item"> <span>My Review for <span class="ptitle"></span></span> </span>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </h2>
                <div class="bv-mbox-injection-container" style="height: 1100px !important;">
                  <div class="bv-mbox-injection-target bv-mbox-current">
                    <div data-bv-v="submission:1" class="bv-submission bv-submission-image">
                      <div class="bv-compat">
					  
                        <form id="bv-submitreview-product_Form"  action="" accept-charset="utf-8" method="POST" class="bv-form" onsubmit="return false;">
                           <input type="hidden" id="productid" name="productid" value="<?php echo $id_pro;?>" class="bv-noremember">
						   <div class="bv-submission-section">
                            <div class="bv-fieldsets bv-input-fieldsets">
                              <fieldset class="bv-fieldset bv-fieldset-rating bv-radio-field bv-fieldset-active">
                                <span class="bv-fieldset-inner">
									<span class="bv-fieldset-label-wrapper bv-fieldset-label-text" id="bv-fieldset-label-rating"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> Overall Rating* </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation"></span> </span> <span class="bv-off-screen">Rate from 1 to 5 where 1 is poor and 5 is excellent.</span> </span>
									<span class="fieldset-rating-wrapper">
										<input type="text" id="kv-gly-star" name="kv-gly-star" class="rating rating-loading"  value="0" data-size="md" data-min=0 data-max=5 data-step=1 title="">
									</span>
									<span class="rating-helper rating_error" style="display:none"> 
										<div class="clear-rating"><i class="glyphicon glyphicon glyphicon-remove"></i></div>
									</span>
									<span class="rating-helper rating_succecs1"> 
										<div class="clear-rating"><i class="glyphicon glyphicon-ok"></i></div>
									</span>
								 </span> 
                                </fieldset>
                              <fieldset class="bv-fieldset bv-fieldset-title bv-text-field bv-nocount">
                                <div class="bv-fieldset-arrowicon"></div>
                                <div class="bv-fieldset-inner">
                                  <label for="bv-text-field-title" class="bv-fieldset-label-wrapper"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> Review Title </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation"></span> </span> <span class="bv-off-screen">Example: Great Print Quality!</span> <span class="bv-off-screen">Maximum of 50 characters.</span> </label>
                                 
                                  <input id="title" class="bv-text bv-focusable " type="text" name="title" maxlength="50" placeholder="Example: Great Print Quality!" value="" tabindex="0">
                                </div>
                              </fieldset>
							  
                              <fieldset class="bv-fieldset bv-focusable bv-fieldset-reviewtext bv-textarea-field bv-mincount" tabindex="0">
                                
                                <div class="bv-fieldset-inner">
                                  <label for="bv-textarea-field-reviewtext" class="bv-fieldset-label-wrapper"> <span class="bv-fieldset-label" aria-describedby="reviewtext_validation"> <span class="bv-fieldset-label-text"> Review* </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation">0 out of a minimum 50 characters used</span> </span> <span class="bv-off-screen">Example: I ordered these business cards 2 weeks ago and I'm very happy...</span> </label>
                                  <span class="bv-helper">
                                  <label class="bv-helper-label">0 / 50</label>
                                  <span class="bv-helper-icon" aria-hidden="true"> <span class="bv-helper-icon-positive"> ✔ </span> <span class="bv-helper-icon-negative"> ✘ </span> </span> </span>
                                  <div class="bv-review-field-content-wrapper">
                                    <textarea id="bv-textarea-field-reviewtext" class="bv-focusable " id="reviewtext" name="reviewtext" maxlength="10000" placeholder="Example: I ordered these business cards 2 weeks ago and I'm very happy..." tabindex="0" style="word-wrap: break-word; overflow: hidden !important; height: 90px !important;"></textarea>
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
                               <span class="bv-fieldset-inner">
									<legend class="bv-fieldset-label-wrapper" id="bv-fieldset-label-rating_Quality"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> How would you rate the quality of this product? </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation"></span> </span> </legend>
									<span class="fieldset-rating-wrapper">
										<input type="text" id="kv-gly-quality" name="kv-gly-quality" class="rating rating-loading"  value="0" data-size="ms" data-min=0 data-max=5 data-step=1 title="">
									</span>
									<span class="rating-helper rating_succecs2"> 
										<div class="clear-rating"><i class="glyphicon glyphicon-ok"></i></div>
									</span>
								 </span> 
							   
							  
                              </fieldset>
                              <fieldset class="bv-fieldset bv-fieldset-rating_Value bv-radio-field bv-fieldset-secondary-rating">
                                 <span class="bv-fieldset-inner">
									<legend class="bv-fieldset-label-wrapper" id="bv-fieldset-label-rating_Value"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> How would you rate the value of this product? </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation"></span> </span> </legend>
									<span class="fieldset-rating-wrapper">
										<input type="text" id="kv-gly-value" name="kv-gly-value" class="rating rating-loading"  value="0" data-size="ms" data-min=0 data-max=5 data-step=1 title="">
									</span>
									<span class="rating-helper rating_succecs3"> 
										<div class="clear-rating"><i class="glyphicon glyphicon-ok"></i></div>
									</span>
								 </span> 
								
								 </fieldset>
                              <fieldset class="bv-fieldset bv-fieldset-usernickname bv-text-field bv-fieldset-small bv-mincount">
                                <div class="bv-fieldset-arrowicon"></div>
                                <div class="bv-fieldset-inner">
                                  <label for="bv-text-field-usernickname" class="bv-fieldset-label-wrapper"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> Nickname* </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation">0 out of a minimum 4 characters used</span> </span> <span class="bv-off-screen">Example: jackie27</span> <span class="bv-off-screen">Maximum of 25 characters.</span> </label>
                                  <span class="bv-helper">
                                  <label class="bv-helper-label">0 / 4</label>
                                  <span class="bv-helper-icon" aria-hidden="true"> <span class="bv-helper-icon-positive"> ✔ </span> <span class="bv-helper-icon-negative"> ✘ </span> </span> </span>
                                  <input id="usernickname" class="bv-text bv-focusable " type="text" name="usernickname" maxlength="25" placeholder="Example: jackie27" value="" tabindex="0">
                                </div>
                              </fieldset>
                              <fieldset class="bv-fieldset bv-fieldset-userlocation bv-text-field bv-nocount bv-fieldset-small">
                                <div class="bv-fieldset-arrowicon"></div>
                                <div class="bv-fieldset-inner">
                                  <label for="bv-text-field-userlocation" class="bv-fieldset-label-wrapper"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> Location </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation"></span> </span> <span class="bv-off-screen">Example: New York, NY</span> <span class="bv-off-screen">Maximum of 50 characters.</span> <span class="bv-off-screen">Autocomplete available, press the down arrow to hear options</span></label>
                                  <span class="bv-helper">
                                  <label class="bv-helper-label"></label>
                                  <span class="bv-helper-icon" aria-hidden="true"> <span class="bv-helper-icon-positive"> ✔ </span> <span class="bv-helper-icon-negative"> ✘ </span> </span> </span>
                                  <input id="userlocation" class="bv-text bv-focusable  bv-autocomplete-input" type="text" name="userlocation" maxlength="50" placeholder="Example: New York, NY" value="" tabindex="0" autocomplete="off">
                                </div>
                              </fieldset>
                              <fieldset class="bv-fieldset bv-fieldset-hostedauthentication_authenticationemail bv-email-field bv-nocount bv-fieldset-small-alone">
                                <div class="bv-fieldset-arrowicon"></div>
                                <div class="bv-fieldset-inner">
                                  <label for="bv-email-field-hostedauthentication_authenticationemail" class="bv-fieldset-label-wrapper"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> Email* </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation"></span> </span> <span class="bv-off-screen">Example: youremail@example.com</span> <span class="bv-off-screen">Maximum of 255 characters.</span> </label>
                                  <span class="bv-helper">
                                  <label class="bv-helper-label"></label>
                                  <span class="bv-helper-icon" aria-hidden="true"> <span class="bv-helper-icon-positive"> ✔ </span> <span class="bv-helper-icon-negative"> ✘ </span> </span> </span>
                                  <input id="email" class="bv-text bv-focusable bv-email" type="email" name="email" maxlength="255" placeholder="Example: youremail@example.com" value="" tabindex="0">
                                </div>
                              </fieldset>
                              <fieldset class="bv-fieldset bv-fieldset-contextdatavalue_Gender bv-select-field">
                                <div class="bv-fieldset-arrowicon"></div>
                                <div class="bv-fieldset-inner">
                                  <label for="bv-select-field-contextdatavalue_Gender" class="bv-fieldset-label-wrapper"> <span class="bv-fieldset-label"> <span class="bv-fieldset-label-text"> What is your gender? </span> <span aria-hidden="false" class="bv-off-screen bv-field-aria-validation"></span> </span> </label>
                                  <span class="bv-helper">
                                  <label class="bv-helper-label"></label>
                                  <span class="bv-helper-icon" aria-hidden="true"> <span class="bv-helper-icon-positive"> ✔ </span> <span class="bv-helper-icon-negative"> ✘ </span> </span> </span> <span class="bv-fieldset-select-wrapper">
                                  <select id="gender" class="bv-select-cleanslate bv-select bv-focusable bv-fastclick-ignore" name="gender" tabindex="0">
                                    <option value="" selected="selected" class="bv-option-disabled" > Select </option>
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
                                  <select id="companySize" class="bv-select-cleanslate bv-select bv-focusable bv-fastclick-ignore" name="companySize" tabindex="0">
                                    <option value="" selected="selected" class="bv-option-disabled" > Select </option>
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
                                  <select id="HowDidYouHearAboutPrintrunner" class="bv-select-cleanslate bv-select bv-focusable bv-fastclick-ignore" name="HowDidYouHearAboutPrintrunner" tabindex="0">
                                    <option value="" selected="selected" class="bv-option-disabled" > Select </option>
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
                                    <button type="button" id="btn_rating" aria-label="Post Review. You may receive emails regarding this submission. Any emails will include the ability to opt-out of future communications." class="bv-form-actions-submit bv-submit bv-focusable bv-submission-button-submit" name="bv-submit-button" tabindex="0">Post Review</button>
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
    </div>
  </div>
</div>



<!--model-->
<?php include('inc/footer.php'); ?>
