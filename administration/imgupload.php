<?php
session_start();
include("../inc/global_admin.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Add Pictures to Listing</title>
<link href="../css/style.php?sheet=main" rel="stylesheet" type="text/css" />
<link href="uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="uploadify/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="uploadify/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript" src="uploadify/swfobject.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#fileInput').uploadify({
	'uploader'  : 'uploadify/uploadify.swf',
	'script'    : 'uploadify/uploadify.php',
	'cancelImg' : 'uploadify/cancel.png',
	'folder'    : '../images/shop/products',
	'fileDesc'	: 'Image Files(*.jpg;*.gif;*.png)',
	'fileExt'	: '*.jpg;*.gif;*.png',
	'multi'		: true,
	'auto'      : true
  });
});
</script>
</head>
<body style="background-color:#FFFFFF;">
<table width="500" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td height="5"></td>
  </tr>
  <tr>
    <td>
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="0">
      	
      	<tr>
          <td colspan="2" class="black_small2">&nbsp;</td>
        </tr>        
        
        <tr>
          <td width="100%" colspan="2">&nbsp;</td>
          </tr>
        
        <tr>
          <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="8">
            <tr>
              <td><input type="file" name="fileInput" id="fileInput" />
                <p>Please use Browse  above to choose images to upload.&nbsp; Keep clicking Browse to add more images  to the upload.</p>
                <p><strong>Image Types Accepted: </strong>.JPG .PNG .GIF</p>
                <table width="157" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="200">
                        <table width="157" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="21" valign="top" background="imgs/blue_button2.png"><table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td height="2"><img src="imgs/pixel.gif" width="2" height="2" /></td>
                                </tr>
                                <tr>
                                  <td valign="top"><div align="center"><a href="#" onclick="javascript:$('#fileInput').uploadifyUpload();" class="white"><strong>Start Upload</strong></a></div></td>
                                </tr>
                            </table></td>
                          </tr>
                        </table>   
					</td>         
                    <td width="200">
                        <table width="157" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="21" valign="top" background="imgs/blue_button2.png"><table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td height="2"><img src="imgs/pixel.gif" width="2" height="2" /></td>
                                </tr>
                                <tr>
                                  <td valign="top"><div align="center"><a href="#" onclick="javascript:$('#fileInput').uploadifyClearQueue();" class="white"><strong>Clear Queue</strong></a></div></td>
                                </tr>
                            </table></td>
                          </tr>
                        </table>                     
                    </td>
                  </tr>
                </table>                     
			  </td>
            </tr>
          </table></td>
        </tr>
       
      </table></td>
  </tr>
</table>
</body>
</html>