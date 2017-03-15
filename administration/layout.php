<?php 

session_start();

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

// Same as error_reporting(E_ALL);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_DEPRECATED);


if (!isset($_SESSION['UserId'])){
	echo '<script>window.location="?section=login"</script>';
}
include("../inc/global_admin.php");
include("inc/functions.php");
if(isset($_SESSION['UserId'])) {
	if($_GET['section'] != "changepassword") {
		$checkpass = "select pwdreset from users where id='".$_SESSION['UserId']."'";
		$respass = mysql_query($checkpass);
		$rowpass = mysql_fetch_assoc($respass);			
		if($rowpass['pwdreset'] == "1") {
			header('Location: '.LINK_PATH.'administration/index.php?section=changepassword');
			die();
		} 
	}
}
//$section = $_POST['section'];
if (!$section) { 
	$section=$_GET['section']; 
}
if ($section == "options") {
	$headertitle = "Options";
} else if ($section == "products") {
	$headertitle = "Products";
} else if ($section == "category") {
	$headertitle = "Category";
} else if ($section == "pages") {
	$headertitle = "Pages";
} else if ($section == "recyclebin") {
	$headertitle = "Recycle Bin";
} else if ($section == "customers") {
	$headertitle = "Customers"; 
} else if ($section == "orders") {
	$headertitle = "Orders"; 
} else if ($section == "products") {
	$headertitle = "Products"; 
} else if (($section == "") || ($section == "dashboard")) {
	$headertitle = "Dashboard";
} else if ($section == "sliders") {
	$headertitle = "Sliders";
} else if ($section == "changepassword") {
	$headertitle = "Change your Password";
} else if ($section == "settings") {
	$headertitle = "Website and Module Settings";
} else if ($section == "shop") {
	$headertitle = "Shop";
} else if ($section == "calendar") {
	$headertitle = "Calendar";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Site Manager - Printing Period</title>
<link rel="shortcut icon" href="<?php echo LINK_PATH; ?>favicon.ico" />
<link href="<?php echo LINK_PATH; ?>administration/css/style.php?sheet=main" rel="stylesheet" type="text/css" />
<script src="<?php echo LINK_PATH; ?>administration/js/jquery-1.4.3.js" type="text/javascript"></script>
<script src="<?php echo LINK_PATH; ?>administration/js/jquery.ui.core.js" type="text/javascript"></script>
<script src="<?php echo LINK_PATH; ?>administration/js/jquery.ui.widget.js" type="text/javascript"></script>
<script src="<?php echo LINK_PATH; ?>administration/js/jquery.ui.mouse.js" type="text/javascript"></script>
<script src="<?php echo LINK_PATH; ?>administration/js/jquery.ui.sortable.js" type="text/javascript"></script>
<script src="<?php echo LINK_PATH; ?>administration/js/jsFunctions.js" type="text/javascript" /></script>
<script src="<?php echo LINK_PATH; ?>administration/js/tmce/jscripts/tiny_mce/tiny_mce.js" language="javascript" type="text/javascript" /></script>
<link href="<?php echo LINK_PATH; ?>administration/css/tipsy.css" rel="stylesheet" type="text/css" />
<link href="<?php echo LINK_PATH; ?>administration/css/tipsy-docs.css" rel="stylesheet" type="text/css" />
<script src="<?php echo LINK_PATH; ?>administration/js/jquery.tipsy.js" type="text/javascript" /></script>
<script src="<?php echo LINK_PATH; ?>js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
<?php 
$sqltt = mysql_query("SELECT * FROM acsmtooltips");
while($rowtt=mysql_fetch_assoc($sqltt)) {
	if($rowtt['tooltip'] != "") {
		$ttt = stripslashes(htmlentities($rowtt['tooltip']));
	} else {
		$ttt = "No help available for this tooltip.";
	}
?>
$('#<?php echo $rowtt['refname']; ?>').tipsy({fade: true, fallback: "<?php echo $ttt; ?>", gravity: 'sw', opacity: '1.0'});
<?php 
} 
?>
});
</script>


<?php if($_GET['section'] == "products"||$_GET['section'] == "sliders") { ?>
<link href="<?php echo LINK_PATH;?>administration/js/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo LINK_PATH;?>administration/js/uploadify/swfobject.js"></script>
<script type="text/javascript" src="<?php echo LINK_PATH;?>administration/js/uploadify/jquery.uploadify.v2.1.4.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#file_upload').uploadify({
    'uploader' 		 	: '<?php echo LINK_PATH;?>administration/js/uploadify/uploadify.swf',
    'script'   		 	: '<?php echo LINK_PATH;?>administration/js/uploadify/uploadify.php',
    'cancelImg'		 	: '<?php echo LINK_PATH;?>administration/js/uploadify/cancel.png',
    <?php if($_GET['section'] == "sliders") {?>
		'folder'   		 	: '<?php echo IMG_PATH;?>/banners/',
	<?php } else {?>
		'folder'   		 	: '<?php echo IMG_PATH;?>/products/',
	<?php }?>
	'multi'				: false,
	'fileExt'     		: '*.jpg;*.gif;*.png',
  	'fileDesc'      	: 'Image Files',
	'onComplete' 		: function(event, ID, fileObj, response, data) {
	document.getElementById('imgpath').value=response;
	$('#imgupload').html('<img src="../'+response+'" height="90" border="0" style="padding:3px;"/>'); 
    },
    'auto'     		 	: true
  });
});


$(document).ready(function() {
  $('#cat_file_upload').uploadify({
    'uploader' 		 	: '<?php echo LINK_PATH;?>administration/js/uploadify/uploadify.swf',
    'script'   		 	: '<?php echo LINK_PATH;?>administration/js/uploadify/uploadify.php',
    'cancelImg'		 	: '<?php echo LINK_PATH;?>administration/js/uploadify/cancel.png',
	'folder'   		 	: '<?php echo IMG_PATH;?>/products/',
	'multi'				: false,
	'fileExt'     		: '*.jpg;*.gif;*.png',
  	'fileDesc'      	: 'Image Files',
	'onComplete' 		: function(event, ID, fileObj, response, data) {
	document.getElementById('cat_imgpath').value=response;
	$('#cat_imgupload').html('<img src="../'+response+'" height="90" border="0" style="padding:3px;"/>'); 
    },
    'auto'     		 	: true
  });
});
</script>
<?php }?>


<?php if ($_GET['section'] == "settings" || $_GET['section'] == "sliders" || ($_GET['section'] == "shop"  and $_GET['do'] == "coupons")) { ?>
<script src="<?php echo LINK_PATH; ?>administration/js/tmce/jscripts/tiny_mce/plugins/imagemanager/js/mcimagemanager.js" type="text/javascript" /></script>
<link href="<?php echo LINK_PATH;?>administration/css/ui.all.css" rel="stylesheet" type="text/css" />
<script src="<?php echo LINK_PATH; ?>administration/js/ui.core.js" type="text/javascript" /></script>
<script src="<?php echo LINK_PATH; ?>administration/js/ui.datepicker.js" type="text/javascript" /></script>

<script type="text/javascript">
$(function() {
    $("#datepickers").datepicker();
    $("#datepickerd1").datepicker();
    $("#datepickerd2").datepicker();	
    $("#Config_CouponExpire").datepicker();	
});
</script>
<?php } ?>
<?php if($_GET['section'] == "category"){ ?>
<link href="css/shadowbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/shadowbox.js"></script>
<script type="text/javascript">
function moveCloseLink(){ 
    var cb=document.getElementById('sb-nav-close'); 
    var tb=document.getElementById('sb-title'); 
    if(tb) tb.appendChild(cb); 
} 
Shadowbox.init({
	handleOversize:"drag",
	modal:true,
	player:"html",
	displayCounter:false,
	showMovieControls:false,
	overlayOpacity : 0,
	onOpen: moveCloseLink
});

</script>
<?php }?>

<?php if($_GET['section'] == "sliders") { ?>
<script>
	$(function() {
		$( "#SortableList" ).sortable({ 
			placeholder : 'sortableHelper', 
			update : function () { 
      		var order = $('#SortableList').sortable('serialize'); 
			var linkline="ajax/sliders_sort.php?"+order;
			$("#info").load(linkline);
	    	} 
		});
		$( "#SortableList" ).disableSelection();
	});
</script>
<?php } ?>
<script type="text/javascript">
<?php if($_GET['section'] == "pages" || $_GET['section'] == "category" || $_GET['section'] == "products") { ?>
tinyMCE.init({
	// General options
<?php if($_GET['section'] == "category" || $_GET['section'] == "products") { ?>
	mode : "exact",
	elements : "learnmore_bottom, learnmore_top, keyfeature",
	theme : "advanced",
	skin : "o2k7",
	skin_variant : "black",	
	width : "500",
	height : "300",	
<?php }else{?>
	mode : "textareas",
	theme : "advanced",
	skin : "o2k7",
	skin_variant : "black",
	width : "645",
	height : "500",	
<?php }?>
	editor_deselector : "noeditor",
	convert_urls : false,
	plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",

	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,image,fullscreen,insertdate,inserttime,preview,|,cut,copy,paste,pastetext,pasteword,formatselect",
	theme_advanced_buttons2 : "hr,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,insertimage,table,|,code",
	theme_advanced_buttons3 : "",
	theme_advanced_buttons4 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : false,
		

	// Example content CSS (should be your site CSS)
	content_css : "<?php echo LINK_PATH; ?>administration/css/wysiwyg.css",

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "js/template_list.js",
	external_link_list_url : "js/link_list.php",
	external_image_list_url : "js/image_list.js",
	media_external_list_url : "js/media_list.js",
	
//force text to be pasted as plaintext
	 setup: function(ed) {        
        ed.onPaste.add( function(ed, e, o) {
            ed.execCommand('mcePasteText', true);
            return tinymce.dom.Event.cancel(e);
        });
       
    },	

	// Replace values for the template plugin
	template_replace_values : {
		username : "Some User",
		staffid : "991234"
	}
});

// Pages Validation
$().ready(function() {
	
	$("#pages").validate({ 
		errorElement: "span", 
		success: function(label) {
			label.text("1").addClass("successval");
		},		
		rules: { 
		  isactive: "required",
		  name: "required",
		  headertitle: "required",
		  quotepath: "required",
		  pgtitle: "required",
		  headerpath: "required",
		  sidebar: "required",
		  ptype: "required",
		  mname: {
			  required: function(element) {
			  return $("#ptype").val()=='M';
		  }},
		  parentname: {
			  required: function(element) {
			  return $("#ptype").val()=='M';
		  }},		  
		  content: "required"
		}, 
		  messages: { 
			isactive: "&nbsp;",
			name: "&nbsp;",
			headertitle: "&nbsp;",
			quotepath: "&nbsp;",
			pgtitle: "&nbsp;",
			headerpath: "&nbsp;",			
			sidebar: "&nbsp;",
			ptype: "&nbsp;",
			mname: "&nbsp;",
			parentname: "&nbsp;",
			content: "&nbsp;"
		} 
	});
})
<?php } ?>

<?php if($_GET['section'] == "settings") { ?>

// Settings Validation
$().ready(function() {
	
	$("#frmSettings").validate({ 
		errorElement: "span", 
		success: function(label) {
			label.text("1").addClass("successval");
		},		
		rules: { 
		  Config_WebsiteActive: "required",
		  Config_WebsiteDownMessage: "required",		  
		  Config_SiteName: "required",
		  Config_ZiggisLocations: "required",
		  Config_NotifyEmail: "required",
		  Config_Inquiry: "required",
		  Config_TwitterURL: "required",
		  Config_FacebookURL: "required",
		  Config_MenuCat1: "required",
		  Config_MenuCat2: "required",
		  Config_MenuCat3: "required",
		  Config_MenuCat4: "required",
		  Config_MenuCat5: "required"  
		  }, 
		  messages: { 
			Config_WebsiteActive: "&nbsp;",
			Config_WebsiteDownMessage: "&nbsp;",
			Config_SiteName: "&nbsp;",
			Config_ZiggisLocations: "&nbsp;",
			Config_NotifyEmail: "&nbsp;",
			Config_Inquiry: "&nbsp;",
			Config_TwitterURL: "&nbsp;",
			Config_FacebookURL: "&nbsp;",
			Config_MenuCat1: "&nbsp;",
			Config_MenuCat2: "&nbsp;",
			Config_MenuCat3: "&nbsp;",
			Config_MenuCat4: "&nbsp;",
			Config_MenuCat5: "&nbsp;"
		} 
	});
})
<?php } ?>

function ChangeStatus(id,status) {
	if(status==0) {
		window.location="?section=<?php echo $_GET['section']; ?>&a=deactivate&id="+id;
	} else {
		window.location="?section=<?php echo $_GET['section']; ?>&a=activate&id="+id;
	}
}
function ChangeStatusShop(id,status) {
	if(status==0) {
		window.location="?section=<?php echo $_GET['section']; ?>&do=<?php echo $_GET['do']; ?>&a=deactivate&id="+id;
	} else {
		window.location="?section=<?php echo $_GET['section']; ?>&do=<?php echo $_GET['do']; ?>&a=activate&id="+id;
	}
}
function ChangeStatus2(id,status,showmenu) {
	if(status==0) {
		window.location="?section=<?php echo $_GET['section']; ?>&showmenu=<?php echo $_GET['showmenu']; ?>&a=deactivate&id="+id;
	} else {
		window.location="?section=<?php echo $_GET['section']; ?>&showmenu=<?php echo $_GET['showmenu']; ?>&a=activate&id="+id;
	}
}

function ChangeFStatus(id,status) {
	if(status==0) {
		window.location="?section=<?php echo $_GET['section']; ?>&a=defeature&id="+id;
	} else {
		window.location="?section=<?php echo $_GET['section']; ?>&a=feature&id="+id;
	}
}

function ChangeHStatus(id,status) {
	if(status==0) {
		window.location="?section=<?php echo $_GET['section']; ?>&a=nohomepage&id="+id;
	} else {
		window.location="?section=<?php echo $_GET['section']; ?>&a=homepage&id="+id;
	}
}

function confirm_delete(delid) {
	var r=confirm("Are you sure you want to permanently delete this?\nTHIS ACTION CANNOT BE RESTORED!");
	if (r==true) {
		window.location.href='?section=<?php echo $_GET['section']; ?>&a=delete&id='+delid;
	} else {
		return false;
	}
}
function confirm_deleteShop(delid) {
	var r=confirm("Are you sure you want to permanently delete this?\nTHIS ACTION CANNOT BE RESTORED!");
	if (r==true) {
		window.location.href='?section=<?php echo $_GET['section']; ?>&do=<?php echo $_GET['do']; ?>&a=delete&id='+delid;
	} else {
		return false;
	}
}
function confirm_recycle(recid) {
	var r=confirm("Are you sure you want to move this to the recycle bin?");
	if (r==true) {
		window.location.href='?section=<?php echo $_GET['section']; ?>&a=recyclebin&id='+recid;
	} else {
		return false;
	}
}

function confirm_emptyrecycle() {
	var r=confirm("Are you sure you want empty your recycle bin?\nTHIS ACTION CANNOT BE RESTORED!");
	if (r==true) {
		window.location.href='?section=<?php echo $_GET['section']; ?>&a=emptybin';
	} else {
		return false;
	}
}

function confirm_restore(restid) {
	var r=confirm("Are you sure you want to restore this content page?");
	if (r==true) {
		window.location.href='?section=<?php echo $_GET['section']; ?>&a=restore&id='+restid;
	} else {
		return false;
	}
}

function DoNav(theUrl) {
	document.location.href = theUrl;
}


$(document).ready(function() {
	//slides the element with class "menu_body" when paragraph with class "menu_head" is clicked 
	$("#firstpane div.submenu_head").click(function() {
		$(this).css({}).next("div.submenu_body").slideToggle(300).siblings("div.submenu_body").slideUp("slow");
	});
});

setTimeout(function() {
    $('#messagebox').fadeOut('slow'); }, 4000);

function ShowMenu(val) {
	if(val!='') {
		window.location='?section=<?php echo $_GET['section']; ?>&showmenu='+val;	
	}
}
</script>
</head>

<body>

<div id="PageMain" style="width: 100%; min-height: 100%; height: auto !important; height: 100%; margin: 0 auto -100px;">
	<div style="background: url(images/main_bg.png) no-repeat center top; padding-top: 8px;">
        <div id="MainDiv" style="width: 960px; margin: 0px auto;">
            <div id="HeaderDiv" style="height: 75px; width: 960px;">
				<div style="float: right; width: 320px; color: #fff; font-weight: none; font-size: 10px; font-family: Verdana, Geneva, sans-serif;">
					
				</div>
            </div>
            <div id="ConatinerDiv" style="width: 960px;"> 
                <div id="ContainerTop">
                    <div style="width: 954px; float: left; padding-left: 5px; padding-top: 0px;">
                        <div id="SubPageHead" style="width: 917px; padding: 17px 15px 15px 15px; float: left; height: 22px; float: left;">
                        <div class="admheadtxt"><?php echo $headertitle; ?></div>
                        </div>
                    </div>
                    <div style="width:960px; float:left;">                    
					<?php if (($section == 'dashboard') || ($section == '')) { include('dashboard.php'); ?>
                    <?php } else {?>                    
                        <div style="float: left; width: 190px; padding-left: 10px; padding-top: 10px;"><?php include('inc/menu.php'); ?></div>
                        <div style="float: left; width: 707px; padding: 0px 20px 30px 20px;">
                            <div style="float: left; width: 707px; padding-bottom: 15px;" class="subtitle">
                            <?php
							if ($section == 'calendar') {
								include('calendar.php');
							}							
							if ($section == 'pages') {
								include('pages.php');
							}
							if ($section == 'category') {
								include('category.php');
							}
							if ($section == 'options') {
								if ($_GET['do'] == 'optiontype') {
									include('optiontype.php');
								}
								if ($_GET['do'] == 'optionvalue') {
									include('optionvalue.php');
								}
							}
							if ($section == 'products') {
								include('products.php');
							}
							if ($section == 'recyclebin') {
								include('recyclebin.php');
							}		
							if ($section == 'settings') {
								include('settings.php');
							}	
							if ($section == 'changepassword') {
								include('changepassword.php');
							}
							if ($section == 'sliders') {
								include('sliders.php');
							}								
							if ($section == 'sortmenu') {
								include('pages_sort.php');
							}
							if ($section == 'shop') {
								if ($_GET['do'] == 'customers') {
									include('shop_customers.php');
								}
								if ($_GET['do'] == 'orders') {
									include('shop_orders.php');
								}
								if ($_GET['do'] == 'orderdetail') {
									include('shop_ordersdetailadm.php');
								}
								if ($_GET['do'] == 'invoiceshow') {
									include('shop_invoiceshow.php');
								}
							}							
							?>
                            </div>
                            <div style="float: left; width: 707px;">
                            
                            </div>
                        </div>
                        <?php } ?>    	                        
                    </div>                             
                </div>
                <div id="ContainerBottom"><img src="<?php echo LINK_PATH; ?>administration/images/center_bottom.png" /></div>         
            </div>
        </div>
	</div>
</div>
</body>
</html>                