
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link type="text/css" href="../css/style.php?sheet=main" rel="stylesheet" />
<script src="js/jquery1_5.js" type="text/javascript" /></script>
<script src="js/jquery_ui_1_8_9.js" type="text/javascript" /></script>
<script src="js/jquery.fileupload.js" type="text/javascript" /></script>
<script src="js/jquery.fileupload-ui.js" type="text/javascript" /></script> 
<script>
/*global $ */
var allfiles = new Array();
var globalcounter = 0;
$(function () {
    $('#file_upload').fileUploadUI({
        uploadTable: $('#files'),
		
        downloadTable: $('#files', window.parent.document), //$('#files'),
        buildUploadRow: function (files, index) {
			allfiles.push(files[index].name);   // we put all filename into an array
            return $('<tr><td>' + files[index].name + '<\/td>' +
                    '<td class="file_upload_progress"><div><\/div><\/td>' +
                    '<td class="file_upload_cancel">' +
                    '<button class="ui-state-default ui-corner-all" title="Cancel">' +
                    '<span class="ui-icon ui-icon-cancel">Cancel<\/span>' +
                    '<\/button><\/td><\/tr>');
        },
        buildDownloadRow: function (file) {
			parent.document.getElementById('adsnl_image').value=parent.document.getElementById('adsnl_image').value+','+file.name;
			parent.document.getElementById('main_image').value=file.name;
            return $('<td align="center" ><div id="' + file.name + '"><img src="../images/shop/products/' + file.name + '" height="100" border="0"><div><input type="radio" name="primages[]" id="primages[]" value="' + file.name + '" onclick="javascript:setMainImage(this.value);" checked="checked">Default &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="javascript:removeImage(\'' + file.name + '\');"><img src="images/trash.png" border="0" /></a></div></div><\/td>');
        },
        onComplete: function (event, files, index, xhr, handler) {
            handler.onCompleteAll(files);
        },
        onCompleteAll: function (files) {
            globalcounter++;
            if(globalcounter == allfiles.length) {
        		parent.Shadowbox.close();
        		globalcounter = 0;
            	allfiles = Array();
            }

        }
    });
});
</script>
<link href="<?php echo LINK_PATH;?>administration/css/jquery_ui_1_8_9.css" rel="stylesheet" type="text/css" />
<link href="<?php echo LINK_PATH;?>administration/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css" />
 <style>
.file_upload {
  position: relative;
  overflow: hidden;
  direction: ltr;
  cursor: pointer;
  text-align: center;
  color: #333;
  font-weight: bold;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
  width: 130px;
  line-height: 20px;
  background: #CCC;
  border: 1px solid #AAA;
  margin-bottom:10px;
}

.file_upload_highlight {
  background: #EEE;
}

.file_upload input {
  position: absolute;
  opacity: 0;
  -ms-filter: 'alpha(opacity=0)';
  filter: alpha(opacity=0);
  -o-transform: translate(-130px, -130px) scale(10);
  -moz-transform: translate(-300px, 0) scale(10);
  cursor: pointer;
}

.file_upload iframe, .file_upload button {
  display: none;
}

.file_upload_preview img {
  width: 80px;
}

.file_upload_progress .ui-progressbar-value {
  background: url(images/pbar-ani.gif);
}

.file_upload_progress div {
  width: 150px;
  height: 15px;
}

.file_upload_cancel button {
  cursor: pointer;
}
</style> 
</head>

<body style="background:none;">
<table id="files"><tr><td align="center" ></td></tr></table></td>
                          
                          </tr>
                      </table>
 <form id="file_upload" name="file_upload" action="shop_upload.php" method="post" enctype="multipart/form-data"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
                            <tr>
                            <td colspan="2" class="admlsttxt">
                                <input type="file" name="file" multiple>
                                <button>Upload</button>
                                <div>Browse Images</div>
							</td>
                            </tr></table></form>
</body>
</html>