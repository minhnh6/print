<?php header('content-type:text/css');
if($_SERVER['HTTP_HOST']=='localhost') {
	define(CSS_PATH,'/printingperiod/administration/');
} else {
	define(CSS_PATH,'/administration/');
}	

?>
<?php if($_GET['sheet'] == "main") { ?>
body {
	font-family: Tahoma;
	font-size: 11px;
	font-weight: none;
	color: #666666;
	margin: 0px;
	background: #f7f7f7;
}

table, tr, td {
	font-family: Tahoma;
	font-size: 11px;
	font-weight: none;
	color: #666666;
	margin: 0px;
}

#PageMain {
	background:#f7f7f7 url(<?php echo CSS_PATH; ?>images/bgblack.png) repeat-x;
	width:100%;	
}

#MainDiv {
	width:960px; 
	margin:0px auto;	
}

#HeaderDiv {
	height:153px; 
	width:960px;	
}

#ContainerDiv {
	width:960px;
}

#ContainerTop {
	background:#FFF;  
	float:left;
}

#SubPageHead {
	width:917px;
	padding:15px;
	float:left; 
	height:22px;
	background:url(<?php echo CSS_PATH; ?>images/subpage_title.gif) no-repeat top left; 
}

#ContainerBottom {
	background: url(<?php echo CSS_PATH; ?>images/center_bottom.png) left bottom no-repeat;
}

a.helplink:link {
	font-family: Tahoma;
	font-size: 11px;
	font-weight: bold;
	color: #666666;
	text-decoration: none;	
}

a.helplink:visited {
	font-family: Tahoma;
	font-size: 11px;
	font-weight: bold;
	color: #666666;
	text-decoration: none;
}

a.helplink:hover {
	font-family: Tahoma;
	font-size: 11px;
	font-weight: bold;
	color: #89C64C;
	text-decoration: none;
}

a.helplink:active {
	font-family: Tahoma;
	font-size: 11px;
	font-weight: bold;
	color: #666666;
	text-decoration: underline;
}

hr {
	float: left;
	width: 100%;
	border: none;
	background-color: #404040;
	color: #404040;
	height: 1px;
}

.admheadtxt {
	font-family: Tahoma;
	font-size: 16px;
	font-weight: bold;
	color: #666666;
}

.block {
	float: left;
}

.redline {
	float: left;
	width: 100%;
	border: 1px dashed #F00;
	padding: 1px;
	background-color: #D63301;
	color: #D63301;
	height: 1px;
}

.highlight {
	cursor: pointer;
	background-color:#EBEBEB;
}

.normal {
	cursor: pointer;
	background-color: #FFF;
}

select {
	color: #666;
	font-size: 14px;
	padding: 4px;
}

select:hover, select:focus, select:active {
	color: #333;
	background-color: #EBEBEB;
	font-size: 14px;
	padding: 4px;
}

textarea {
	color: #666;
	font-size: 14px;
	padding: 4px;
}

textarea:hover, textarea:focus, textarea:active {
	color: #333;
	background-color: #EBEBEB;
	font-size: 14px;
	padding: 4px;
}

input {
	color: #666;
	font-size: 14px;
	padding: 4px;
}

input:hover, input:focus, input:active {
	color: #666;
	background-color: #EBEBEB;
	font-size: 14px;
	padding: 4px;
}

span.successval {
    color: #FFF;
}

.success {
    border: 1px solid #CCC;
    padding: 5px;		
    color: #4F8A10;
	padding-left: 20px;
	background: url(/administration/images/success.png) no-repeat left #DFF2BF;	
}


input.error, select.error, textbox.error, textarea.error {
	border:1px solid #FF0000;
}

.error1 {
    border: 1px solid #CCC;
    padding: 5px;		
    color: #FFF;
	padding-left: 20px;
	background: url(<?php echo CSS_PATH; ?>images/error.png) no-repeat left #F33;	
}

.errorpwd {
    border: 1px solid #CCC;
    padding: 5px;		
    color: #FFF;
	padding-left: 20px;
	background: url(<?php echo CSS_PATH; ?>images/error.png) no-repeat left #F33;	
}

.msgcountbox {
	float: right;
	margin-top: 35px;
	margin-right: 3px;
	width: 130px;
    border: 1px solid #CCC;
    padding: 5px;		
    color: #4F8A10;
	background: #DFF2BF;	
}

.commentmover {
	margin-top: 5px;	
	width: 690px;
    border: 1px solid #CCC;
    padding: 5px;
	background: #EBEBEB;
	font-weight: none;
}

.warning {
    border: 1px solid #FFF;	
	vertical-align: middle;
    padding: 10px;
	width: 130px;
	padding-left: 20px;
}

.warning:hover {
    border: 1px solid #D8412B;
	vertical-align: middle;
    padding: 10px;
	width: 130px;
	padding-left: 20px;
	background: url(<?php echo CSS_PATH; ?>images/warning.png) no-repeat left #FFCCBA;	
}

a.warn:link {
	font-family: Tahoma;
	font-size: 12px;
	font-weight: none;
	color: #D63301;
	text-decoration: none;	
}

a.warn:visited {
	font-family: Tahoma;
	font-size: 12px;
	font-weight: none;	
	color: #D63301;
	text-decoration: none;
}

a.warn:hover {
	font-family: Tahoma;
	font-size: 12px;
	font-weight: none;	
	vertical-align: middle;
    color: #D63301;
	text-decoration: none;
}

a.warn:active {
	font-family: Tahoma;
	font-size: 12px;
	font-weight: none;	
	color:#D63301;	
	text-decoration: underline;
}

input.btn {
  color:#fff;
  font: bold 110% 'Verdana',helvetica,sans-serif;
  background-color:#666;
  border:2px solid;
  padding: 5px;
  cursor: pointer;
  border-color: #666;
  margin-left: 0;
}

input.btnhov { 
  color:#333C5D;
  background-color:#9FCF6F;
}

div.sortableHelper {
        background-color: #FF0;
        z-index:1;
		height:22px;
		float:left;
		display:block;
		width:710px;
} 

.tooltip {
	background-color:#000;
	border:1px solid #fff;
	padding:10px 15px;
	width:200px;
	display:none;
	color:#fff;
	text-align:left;
	font-size:12px;

	/* outline radius for mozilla/firefox only */
	-moz-box-shadow:0 0 10px #000;
	-webkit-box-shadow:0 0 10px #000;
}

.submenu_list {	
	width: 150px;
}
.submenu_head {
	padding: 8px 0px;
	cursor: pointer;
	margin:1px;
    font-family: Tahoma;
	font-size: 11px;
	font-weight: bold;
	color: #666666;
}
.submenu_head a{
	font-family: Tahoma;
	font-size: 11px;
	font-weight: bold;
	color: #666666;
}
.submenu_body {
	display:none;
}

.SubMenuList {
	margin:0;
	padding:0;	
	list-style:none;
	padding-bottom:15px;
}
.SubMenuList li {
/*	background: url(<?php echo CSS_PATH; ?>images/arrow5.gif) no-repeat; */
	padding-left: 20px;
	padding-top: 0px;
	padding-bottom: 5px;
}
.SubMenuList li a{
  font-family: Tahoma;
  font-size: 11px;
  color: #666666;
  text-decoration:none;
}
.SubMenuList li a:hover{
  color: #9FCF6F;
  text-decoration:underline;
}

.dashboard_block {
	margin: 0 auto; 
	width: 688px; 
	height: 600px; 
	padding-top: 25px;
}

.dashboard_button {
	float: left;
	width: 133px;
	height: 35px;
	overflow: hidden;
	border: 2px solid #c0c0c0;
	padding: 15px;
	margin: 0 5px 5px 0;
	background: #eaeaea url(<?php echo CSS_PATH; ?>images/dashboard/highlight_line.gif) repeat-x top left;
	font-size: 11px;
	line-height: 1.4em;
	text-decoration: none;
	color: #a1a1a1;
}
	
.dashboard_button span {
	display: block;
	padding-top: 7px;
}

.dashboard_button_heading {
	display: block;
	color: #4a4a4a;
	font-size: 14px;
	padding: 0 0 0 40px;
	line-height: 19px;
	height: 35px;
}
	
.two_lines.dashboard_button_heading {
	line-height: 13px;
}
	
.dashboard_button:hover {
	background: #C3D9EA;
	border: 2px solid #aaa;
	height: 35px;
}

.dashboard_button:hover .dashboard_button_heading {
	color: #222;
}

.button_pages .dashboard_button_heading { background: transparent url(<?php echo CSS_PATH; ?>images/dashboard/pages.png) no-repeat 0px top;	}
.button_options .dashboard_button_heading { background: transparent url(<?php echo CSS_PATH; ?>images/dashboard/archive.png) no-repeat 0px top;	}
.button_category .dashboard_button_heading { background: transparent url(<?php echo CSS_PATH; ?>images/dashboard/productcat.png) no-repeat 0px top;	}
.button_products .dashboard_button_heading { background: transparent url(<?php echo CSS_PATH; ?>images/dashboard/product.png) no-repeat 0px top;	}
.button_calendar .dashboard_button_heading { background: transparent url(<?php echo CSS_PATH; ?>images/dashboard/calendar.png) no-repeat 0px top;	}
.button_news .dashboard_button_heading { background: transparent url(<?php echo CSS_PATH; ?>images/dashboard/news.png) no-repeat 0px top;	}
.button_coupons .dashboard_button_heading { background: transparent url(<?php echo CSS_PATH; ?>images/dashboard/coupon.png) no-repeat 0px top;	}
.button_photo .dashboard_button_heading { background: transparent url(<?php echo CSS_PATH; ?>images/dashboard/photo.png) no-repeat 0px top;	}
.button_menumanager .dashboard_button_heading { background: transparent url(<?php echo CSS_PATH; ?>images/dashboard/menumanager.png) no-repeat 0px top;	}
.button_shop .dashboard_button_heading { background: transparent url(<?php echo CSS_PATH; ?>images/dashboard/shop.png) no-repeat 0px top;	}
.button_changepassword .dashboard_button_heading { background: transparent url(<?php echo CSS_PATH; ?>images/dashboard/changepassword.png) no-repeat 0px top;	}
.button_sliders .dashboard_button_heading { background: transparent url(<?php echo CSS_PATH; ?>images/dashboard/sliders.png) no-repeat 0px top;	}
.button_settings .dashboard_button_heading { background: transparent url(<?php echo CSS_PATH; ?>images/dashboard/settings.png) no-repeat 0px top;	}
.button_logout .dashboard_button_heading { background: transparent url(<?php echo CSS_PATH; ?>images/dashboard/logout.png) no-repeat 0px top;	}
<?php } ?>