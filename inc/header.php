<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="<?=IMG_PATH ?>ico/favicon.ico">
<meta name="keywords" content="<?php echo $MetaKeywords;?>" />
<meta name="description" content="<?php echo $MetaDescriprtion;?>" />
<meta name="author" content="">
<title><?php echo ($MetaTitle != ''?$MetaTitle.'  ':'');?></title>

<!-- core CSS -->
<link href="<?php echo LINK_PATH;?>css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo LINK_PATH;?>css/font-awesome.min.css">
<link href="<?php echo LINK_PATH;?>css/animate.min.css" rel="stylesheet">
<link href="<?php echo LINK_PATH;?>css/prettyPhoto.css" rel="stylesheet">
<link href="<?php echo LINK_PATH;?>css/jquery-ui.css" rel="stylesheet">
<link href="<?php echo LINK_PATH;?>css/cloud-zoom.css" rel="stylesheet">
<link href="<?php echo LINK_PATH;?>css/main.css" rel="stylesheet">
<link href="<?php echo LINK_PATH;?>css/review.css" rel="stylesheet">
<link href="<?php echo LINK_PATH;?>css/responsive.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo LINK_PATH;?>rating/css/star-rating.css" media="all" type="text/css"/>
  
</head>
<!--/head-->

<body class="homepage">
<header id="header">
  <div class="top-bar">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-xs-4">
          <div class="top-number">
            <p class="p-border"><i class="fa fa-phone-square"></i> +(209)-676-5971</p>
            <p><a href="<?= LINK_PATH ?>live-chat.html"><i class="fa fa-comments" aria-hidden="true"></i> Live Chat</a></p>
          </div>
        </div>
        <div class="col-sm-6 col-xs-8">
          <div class="social">
          	 <?php
          	 	//$totals = 0;
			    $querycart="select fld_shopCartIdNumber from ".TB_SHOPPING_CART." where fld_shopSessionId= '".session_id()."' ORDER BY fld_productId";
			    $rscart=$dbh->Query($querycart);
			    $totals=$dbh->NumRows($rscart);
			    
			    ?>
            <ul class="social-share">
            	 <?php if(!$_SESSION['_SESSUSERID_']){?>
		             <li><a href="<?php echo LINK_PATH;?>signin.php"><i class="fa fa-user-plus"></i> Sign Up</a></li>
		        <?php }else{?>
		        	 <li><a href="<?php echo LINK_PATH;?>logout.php"><i class="fa fa-user-plus"></i>Logout</a></li>
		        	  <li><a href="<?php echo LINK_PATH;?>myaccount.php"><i class="fa fa-user" aria-hidden="true"></i>My Account</a></li>
		           
		        <?php }?>
                  <li><a href="<?php echo LINK_PATH;?>cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Shopping Cart(<?php echo $totals;?>)</a></li>
            </ul>
            <div class="search">
              <form role="form" name="search_form" method="post" id="search_form" action="<?= LINK_PATH ?>search.php">
                <input type="text"  id="search_text" name="search_text" class="search-form" autocomplete="off" placeholder="Search">
                <i onclick="document.getElementById('search_form').submit();" class="fa fa-search" ></i>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/.container--> 
  </div>
  <!--/.top-bar-->
  
  <nav class="navbar navbar-inverse" role="banner">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <a class="navbar-brand" href="<?= LINK_PATH ?>"><img src="<?php echo LINK_PATH;?>images/logo.png" alt="logo"></a> </div>
      <div class="collapse navbar-collapse navbar-right">
        <ul class="nav navbar-nav uper-nav">
          <li class="active"><a href="<?= LINK_PATH ?>">Home</a></li>
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Product <b class="caret"></b></a>
			<?php include("inc/productmenu.php"); ?>
          </li>
          <!-- /.dropdown -->
          <li><a href="<?php echo LINK_PATH;?>template.html">Free Templats</a></li>
          <li><a href="<?php echo LINK_PATH;?>customquote.html">Custom Quote</a></li>
          <li><a href="<?php echo LINK_PATH;?>aboutus.html">About Us</a></li>
          <li><a href="<?php echo LINK_PATH;?>testimonials.html">Testimonials</a></li>
          <li><a href="<?php echo LINK_PATH;?>faq.html">FAQs</a></li>
          <li><a href="<?php echo FULL_PATH;?>#bottom">Contact Us</a></li>
        </ul>
      </div>
    </div>
    <!--/.container--> 
  </nav>
  <!--/nav--> 
  
</header>
<!--/header-->