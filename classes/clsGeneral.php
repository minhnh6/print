<?php
class clsGeneral{

	function clsGeneral()
	{

	}


	function isExist($table, $field, $val)
	{
		global $dbh2;
	 	$rs=$dbh2->Query("select * from ".$table." where ".$field." = '".$val."'");
	 	$totalRows=$dbh2->NumRows($rs);

		if($totalRows>0)
		{
			return true;
		}
		else
		{
			return false;
		}


	}


	function chkLogin($table,$loginField, $loginId, $passField,$loginPass)
	{
	 	global $dbh2;
	 	$rs=$dbh2->Query("select * from ".$table." where ".$loginField." = '".$loginId."' and ".$passField."='".$loginPass."'");
	 	$totalRows=$dbh2->NumRows($rs);

		if($totalRows>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

function chkVal($query)
{
	 	global $dbh2;
	 	$rs=$dbh2->Query($query);
 	 	$totalRows=$dbh2->NumRows($rs);
		if($totalRows>0)
		{
			return true;
		}
		else
		{
			return false;
		}
}

function getVal($table,$field, $val, $getField)
{
	 	global $dbh2;
	 	$rs=$dbh2->Query("select ".$getField." from ".$table." where ".$field." = '".$val."'");
 	 	$totalRows=$dbh2->NumRows($rs);
	 	$Rows=$dbh2->FetchRow($rs);
		if($totalRows>0)
		{
			return $Rows[$getField];
		}
		else
		{
			return 0;
		}
}


function file_upload ($upload_path, $fname)
{
		  global $_FILES;
          $problem = FALSE;

          switch ($_FILES[$fname]['error'])
          {
              case UPLOAD_ERR_FORM_SIZE:
                   echo $error = "The uploaded file exceeds the 85kb";
                   break;
              case UPLOAD_ERR_NO_FILE:
                   echo $error = "No file was uploaded";
                   break;
              default:
                   $error = "";
          }


		  $dest = $upload_path.$_FILES[$fname]['name'];
          $tmpfile = $_FILES[$fname]['tmp_name'];

          if ($tmpfile)
          {
              $info = getimagesize($tmpfile);
            	$ftype = $info['mime'];

              if ($ftype != "image/gif" && $ftype != "image/jpeg")
              {
                   echo $error = "File type not supported";
                   $problem = FALSE;
              }
              else
              {

					copy ($tmpfile,$dest);
					$problem = TRUE;

              }
          }

          return $problem;
}

function getMapping($table,$field, $val)
{
	 	global $dbh2;
	 	$rs=$dbh2->Query("select * from ".$table." where ".$field." = '".$val."'");
 	 	$totalRows=$dbh2->NumRows($rs);

		if($totalRows>0)
		{
			return $totalRows;
		}
		else
		{
			return 0;
		}
}

function UstoMysql($date)
{

		$arr=explode("-",$date);
		return $arr[2]."-".$arr[0]."-".$arr[1];
}

function MysqltoUs($date)
{

		$arr=explode("-",$date);
		return $arr[1]."-".$arr[2]."-".$arr[0];
}

function UstoTextual($date)
{

		$arr=explode("-",$date);

		if($arr[0]==01)
			$m="Jan";
		else if($arr[0]==02)
			$m="Feb";
		else if($arr[0]==03)
			$m="Mar";
		else if($arr[0]==04)
			$m="Apr";
		else if($arr[0]==05)
			$m="May";
		else if($arr[0]==06)
			$m="Jun";
		else if($arr[0]==07)
			$m="Jul";
		else if($arr[0]==08)
			$m="Aug";
		else if($arr[0]==09)
			$m="Sep";
		else if($arr[0]==10)
			$m="Oct";
		else if($arr[0]==11)
			$m="Nov";
		else if($arr[0]==12)
			$m="Dec";

		return $m." ".$arr[1].", ".$arr[2];

}

function MySqltoTextual($date)
{
		$arr=explode("-",$date);

		if($arr[1]==01)
			$m="Jan";
		else if($arr[1]==02)
			$m="Feb";
		else if($arr[1]==03)
			$m="Mar";
		else if($arr[1]==04)
			$m="Apr";
		else if($arr[1]==05)
			$m="May";
		else if($arr[1]==06)
			$m="Jun";

		else if($arr[1]==07)
			$m="Jul";

		else if($arr[1]==8)
			$m="Aug";

		else if($arr[1]==9)
			$m="Sep";

		else if($arr[1]==10)
			$m="Oct";

		else if($arr[1]==11)
			$m="Nov";

		else if($arr[1]==12)
			$m="Dec";

		return $m." ".$arr[2].", ".$arr[0];

}

function getMaxRecord($table,$field)
{
		global $dbh2;
		$rs=$dbh2->Query("select MAX(".$field.") as m from ".$table);
		$row=$dbh2->FetchRow($rs);
		return $row['m'];

}
function replacespace($string)
{

		$arr=str_replace(" ","_",trim($string));
		return $arr;
}

function publish_exam($id, $filename)
{
	global $dbh2, $ObjGen;
	$this->publish_exam_pages($id);

}
function publish_exam_pages($id)
{

	global $dbh2, $ObjGen;


	$rsj=$dbh2->Query("select * from ".TB_EXAMS." where fld_productId='".$id."'");
	$exam_rowj=$dbh2->FetchRow($rsj);

	$rsq=$dbh2->Query("select * from ".TB_CATEGORY." where fld_categoryId='".$exam_rowj['fld_categoryIdNo']."' and fld_parentId <>'0'");
	if($dbh2->NumRows($rsq)>0)
	{
		$exam_rowq=$dbh2->FetchRow($rsq);
		$this->publish_subcat_pages($exam_rowj['fld_categoryIdNo']);
	}
	else
	{

		$this->publish_cat_pages($exam_rowj['fld_categoryIdNo']);

	}
	$rsqm=$dbh2->Query("select * from ".TB_CATEGORY." where fld_categoryId='".$exam_rowq['fld_parentId']."'");
	$exam_rowqm=$dbh2->FetchRow($rsqm);

	$rs3=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId=0 order by fld_categoryName ASC");
	$larr=Array();
	while($rowk=mysql_fetch_array($rs3))
	$larr[]=$rowk;
	$subcatId=$exam_rowj['fld_categoryIdNo'];
	$subcatName=$exam_rowq['fld_categoryName'];
	$pId=$exam_rowq['fld_parentId'];
	$catName=$exam_rowqm['fld_categoryName'];

	$rs=$dbh2->Query("select * from ".TB_EXAMS." where fld_productId='".$id."'");
	$exam_row=$dbh2->FetchRow($rs);

	$arrVars=Array(

		"exam_name" =>$exam_row['fld_examTitle'],
		"exam_code" =>$exam_row['fld_examCode']

		);


	$rs_template=$dbh2->Query("select * from ".TB_TEMPLATES." ORDER BY is_main DESC");
	$arrTemplates_data=Array();

	while($template_row=$dbh2->FetchRow($rs_template))
	{
		$arrTemplates_data[]=$template_row;
	}

	for($tp=0;$tp<count($arrTemplates_data);$tp++)
	{

		$templateShortDesc=$exam_row['fld_examShortDesc'];
		$templateTopDesc=$arrTemplates_data[$tp]['fld_templateTopDesc'];
		$templateBottomDesc=$arrTemplates_data[$tp]['fld_templateBottomDesc'];
		$templateTitle=stripslashes($arrTemplates_data[$tp]['fld_templatePageTitle']);
		$templateKeywords=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaKeywords']);
		$templateDesc=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaDesc']);

		foreach($arrVars as $key=>$val)
		{
			$templateShortDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateShortDesc);
			$templateTopDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTopDesc);
			$templateBottomDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateBottomDesc);
			$templateTitle=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTitle);
			$templateKeywords=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateKeywords);
			$templateDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateDesc);
		}
		$key='';
		$val='';
		if($arrTemplates_data[$tp][is_main]==1)
		{
			$filename=$ObjGen->replacespace($exam_row[fld_examCode]).".html";
		}
		else
		{
			$filename=$ObjGen->replacespace($exam_row[fld_examCode])."_".$arrTemplates_data[$tp][fld_templateLink];
		}

		if($arrTemplates_data[$tp+1][is_main]==1)
		{

			$previousTemplateUrl=$exam_row[fld_examCode]."_".$filename;
		}
		else
		{
			$previousTemplateUrl=$exam_row[fld_examCode]."_".$arrTemplates_data[$tp+1][fld_templateLink];
		}






	$rs=$dbh2->Query("select * from ".TB_EXAMS." where fld_productId='".$id."'");
	$exam_row=$dbh2->FetchRow($rs);


	$templateTopDesc=$template_row[0][fld_templateTopDesc];
	$templateBottomDesc=$template_row[0][fld_templateBottomDesc];

	$arrVars=Array();
	$arrVars['exam_name']=$exam_row[fld_examTitle];
	$arrVars['exam_code']=$exam_row[fld_examCode];






	$tab="<html>
		<title>".$templateTitle."</title>
		<head>
		<meta http-equiv=\"Content-Language\" content=\"en-us\">
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">
		<meta name=\"GENERATOR\" content=\"Microsoft FrontPage 5.0\">
		<meta name=\"Author\" content=\"".stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaAuthor'])."\">
		<meta name=\"Keywords\" content=\"".$templateKeywords."\">
		<meta name=\"Description\" content=\"".$templateDesc."\">";


        $tab.="<script type=\"text/javascript\">

              var _gaq = _gaq || [];
              _gaq.push(['_setAccount', 'UA-7389997-8']);
              _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";
        
        

		$tab.="<style type=\"text/css\">

body {
	background-color: #CCCCCC;
}

</style>
<link href=\"include/CssStyle.css\" rel=\"stylesheet\" type=\"text/css\">
<script type=\"text/javascript\">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf('#')!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf(\"?\"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage()
{
  	var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function chk()
{
	if(!validateTEmail(document.frm_signup.email_signup_qestions.value))
	{
		alert('Please enter a valid email address.');
		document.frm_signup.email_signup_qestions.focus();
		return false;
	}
}
function validateTEmail( strValue) {
var objRegExp  = /(^[a-z0-9A-Z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)([.][a-z]{3})$)|(^[0-9A-Za-z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)(\.[a-z]{3})(\.[a-z]{2})*$)/i;


							  return objRegExp.test(strValue);
							}

						function Tellchk()
						{
							if(!validateTEmail(document.frm_tellAfirend.txtFriendEmail.value))
							{
								alert('Please enter a valid email address.');
								document.frm_tellAfirend.txtFriendEmail.focus();
								return false;
							}
							if(!validateTEmail(document.frm_tellAfirend.txtYourEmail.value))
							{
								alert('Please enter a valid email address.');
								document.frm_tellAfirend.txtYourEmail.focus();
								return false;
							}
						}




//-->
</script>
</head>";
$tab.="<body leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' onLoad=\"MM_preloadImages('images/but_home_over.jpg','images/but_Shoppingcart_over.jpg','images/but_corporate_over.jpg','images/but_guarantee_over.jpg','images/but_affiliates_over.jpg','images/but_contact_over.jpg')\">
<table width=\"767\"  border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\" align=\"center\">
	<tr>
		<td>

        	<table width=\"767\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">

	<tr>
	  <td width=\"767\" valign=\"top\" background=\"images/header_certarea.jpg\"><table width=\"767\" height=\"121\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
        <tr>
          <td width=\"472\" height=\"121\"></td>
          <td><table width=\"295\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
              <tr>
                <td height=\"32\" width=\"295\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"right\">
                    <tr>
                      <td><a href=\"index.php\"><img src=\"images/icon_home.gif\" alt=\"Certarea\" border=\"0\" /></a></td>
                      <td></td>
                      <td><a href=\"\"><img src=\"images/icon_sitemap.gif\" alt=\"Certarea\" border=\"0\" /></a></td>
                      <td></td>
                      <td><a href=\"contact2.php\"><img src=\"images/icon_contact.gif\" alt=\"Certarea\" border=\"0\" /></a></td>
                      <td width=\"30\"></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td height=\"54\"></td>
              </tr>
              <tr>
                <td height=\"35\"><form name=\"search_form\" method=\"post\" action=\"exam.php\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                    <tr>
                      <td width=\"90\" class=\"links\">Enter Search :</td>
                      <td><input name=\"search_keyword\" type=\"text\" class=\"textfield\" /></td>
                      <td width=\"10\"></td>
                      <td><a href=\"\"><img src=\"images/header_bottom_28.jpg\" alt=\"Certarea\" border=\"0\" /></a></td>
                    </tr>
                </table></form></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
	  </tr>

	<tr>
		<td valign=\"top\">

        	<table width=\"767\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"left\">
	<tr>

		<td><a href=\"index.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('home','','images/but_home_over.jpg',1)\"><img src=\"images/but_home.jpg\" name=\"home\" width=\"80\" height=\"37\" border=\"0\"></a></td>
		<td width=\"1\"></td>
		<td><a href=\"cart.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Shoppingcart','','images/but_Shoppingcart_over.jpg',1)\"><img src=\"images/but_Shoppingcart.jpg\" name=\"Shoppingcart\" width=\"130\" height=\"37\" border=\"0\"></a></td>
		<td width=\"1\"></td>
		<td><a href=\"licensing.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('cor','','images/but_corporate_over.jpg',1)\"><img src=\"images/but_corporate.jpg\" name=\"cor\" width=\"168\" height=\"37\" border=\"0\"></a></td>
		<td width=\"1\"></td>
		<td><a href=\"guarantee.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('gre','','images/but_guarantee_over.jpg',1)\"><img src=\"images/but_guarantee.jpg\" name=\"gre\" width=\"104\" height=\"37\"  border=\"0\"></a></td>
		<td width=\"1\"></td>
		<td><a href=\"affiliates.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('affi','','images/but_affiliates_over.jpg',1)\"><img src=\"images/but_affiliates.jpg\" name=\"affi\" width=\"96\" height=\"37\" border=\"0\"></a></td>
		<td width=\"1\"></td>
		<td><a href=\"faq.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('faq','','images/but_faq_over.jpg',0)\"><img src=\"images/but_faq.jpg\" name=\"faq\" width=\"70\" height=\"37\"  border=\"0\"></a></td>
		<td width=\"1\"></td>
		<td><a href=\"contact.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('contact','','images/but_contact_over.jpg',1)\"><img src=\"images/but_contact.jpg\" name=\"contact\" width=\"113\" height=\"37\"  border=\"0\"></a></td>
		</tr>
</table>        </td>
	</tr>

</table>


        </td>
	</tr>
	<tr>
		<td height=\"20\"></td>
	</tr>
	<tr>
		<td>

        		<table width=\"767\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
		<td width=\"9\"></td>
		<td width=\"186\" valign=\"top\">

        <table width=\"186\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
<tr height=\"35\">
		<td width=\"12\"><img src=\"images/left_links_heading_bar_cor1.jpg\"></td>
  		<td width=\"162\" background=\"images/left_links_heading_bg.jpg\" class=\"heading1\">Our Vendors</td>
	  <td><img src=\"images/left_links_heading_bar_cor2.jpg\"></td>
		</tr>

  <tr><td width=\"12\" background=\"images/body_left_cor1.jpg\"></td>

        <td class=\"color_gray\">

        	<table width=\"162\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";







		for($a=0;$a<count($larr);$a++)
		{

			$tab.="<tr><td height=\"1\" background=\"images/doted_line.gif\"></td></tr>";

    		$tab.="<tr><td class=\"links1\"><a href='".DR_ROOT.$ObjGen->replacespace($larr[$a]['fld_categoryName']).".html"."'><img src=\"images/aero.gif\" align=\"absmiddle\" border=\"0\">&nbsp;&nbsp;".trim($larr[$a][fld_categoryName])."</a></td></tr>";

		}



		$tab.="<tr><td height=\"1\" background=\"images/doted_line.gif\"></td></tr>

	<tr><td height=\"5\"></td>
	</tr>
</table>
</td>";

	$tab.="<td width=\"12\" background=\"images/body_left_cor2.jpg\"></td>
  		</tr>

        <tr><td><img src=\"images/body_left_cor3.jpg\"></td>
  		<td background=\"images/body_left_cor4.jpg\"></td>
  		<td><img src=\"images/body_left_cor5.jpg\"></td>
  		</tr>
</table>";


$tab.="</td>
		<td width=\"11\"></td>
		<td width=\"553\" valign=\"top\" align=\"left\">


			<table  width=\"554\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">

	<tr>
		<td width=\"554\">

        	<table width=\"386\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr><td height=\"29\">
    	<table width=\"548\" height=\"29\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
		<td width=\"5\" height=\"29\"><img src=\"images/heading1_cor1.jpg\"></td>
		<td width=\"13\" class=\"color_blue\"></td>
		<td class=\"color_blue\"><span class=\"heading2\">".trim($exam_rowq[fld_categoryName])."</span></td>
		<td width=\"5\"><img src=\"images/heading1_cor2.jpg\"></td>
	</tr>
</table>
    </td></tr>
	<tr>
		<td>

        	<table width=\"548\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"color_blue3\">
			<tr>
		<td width=\"15\" height=\"8\"></td>
		<td width=\"515\"></td>
		<td width=\"18\"></td>
		</tr>
			";







         $tab.="<tr>
		<td height=\"15\"></td>
		<td></td>
		<td></td>
		</tr>";


        $tab.="<tr>
		<td height=\"15\"></td>
		<td>
        <form name=\"examform\" method=\"post\" action=\"".DR_ROOT."shopCart.php"."\">
		<input type=\"hidden\" name=\"examId\" value=\"".$exam_row['fld_productId']."\">
		<input type=\"hidden\" name=\"catId\" value=\"".$id."\">
		<input type=\"hidden\" name=\"quantity\" value=\"1\">
		<input type=\"hidden\" name=\"action\" value=\"add\">
        <table width=\"515\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"color_blue2\">
	<tr>
		<td width=\"16\" height=\"17\"></td>
		<td width=\"79\"></td>
		<td width=\"22\"></td>
		<td width=\"369\"></td>
		<td width=\"29\"></td>
	</tr>
	<tr>
		<td height=\"107\"></td>
		<td><img src=\"images/book.png\" width=\"79\" height=\"107\" alt=\"book\" style=\"margin-top:10px\"></td>
  		<td></td>
		<td valign=\"top\">

       <table width=\"369\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">

   <tr class=\"color_blue4\"><td height=\"6\"></td></tr>
  <tr class=\"color_blue4\"><td class=\"heading1\">".trim($exam_row[fld_examCode])." - ".$exam_row['fld_examTitle']."</td>
  </tr>
	 <tr class=\"color_blue4\">
    <td class=\"normal_text\" valign=\"middle\">".trim($exam_row['fld_examShortDesc'])."</td></tr>

  <tr class=\"color_blue4\">
    <td class=\"heading1\" height=\"40\">Updated :&nbsp;&nbsp;&nbsp;".date("m/d/Y",$exam_row['fld_updatedOn'])."<br>
     Price :     &nbsp;&nbsp;&nbsp;$".$exam_row['fld_examFee']."</td>
  </tr class=\"color_blue4\">
  <tr><td class=\"color_blue4\" height=\"5\"></td></tr>

</table>   </td>
		<td></td>
	</tr>
	<tr>
		<td height=\"7\"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td height=\"26\"></td>
		<td></td>
		<td></td>
		<td><input type=\"image\" src=\"images/buynow.gif\" border=\"0\">";
		if(trim($exam_row['fld_examQAdemoFile'])!="" or trim($exam_row['fld_examStudyGuidedemoFile'])!="" or trim($exam_row['fld_examTestEnginedemoFile'])!="" or trim($exam_row['fld_examAudioGuidedemoFile'])!="")
		{

			$tab.="&nbsp;&nbsp;&nbsp;<a href=\"demo.php?exid=".$exam_row['fld_productId']."\"><img src=\"images/demo.gif\" border=\"0\"></a>";
		}
		$tab.="</td>
		<td></td>
	</tr>
	<tr>
		<td height=\"12\"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table></form> </td>
		<td></td>
		</tr>




        <tr>
		<td height=\"5\"></td>
		<td></td>
		<td></td>
		</tr>";





$tab.="<tr>
		<td height=\"15\"></td>
		<td></td>
		<td></td>
		</tr>
		<tr class=\"heading_with_bg\">
		<td height=\"5\"></td>
		<td></td>
		<td></td>
		</tr>";



		$tab.="<tr>
		<td height=\"30\"></td>
		<td></td>
		<td></td>
		</tr>
        <tr>
		<td width=\"15\" ></td>
		<td width=\"515\" class=\"normal_text\">".$templateTopDesc."</td>
		<td width=\"18\"></td>
		</tr>
		<tr>
		<td width=\"15\" height=\"8\"></td>
		<td width=\"515\"></td>
		<td width=\"18\"></td>
		</tr>
        <tr>
		<td height=\"10\"></td>
		<td class=\"heading3\">All prices in US Dollars.<br></td>
		<td></td>
		</tr>
        <tr>
		<td height=\"5\"></td>
		<td></td>
		<td></td>
		</tr>
         <tr>
		<td height=\"5\"></td>
		<td class=\"links\"><form name=\"frm_cat\" method=\"post\" action=\"".DR_ROOT."searchExams.php"."\">
		<input type=\"hidden\" name=\"hdnSubmit\" value=\"1\">
		<table width=\"100%\" cellspacing=\"2\" cellpadding=\"2\"><tr><td class=\"links\">

		Main:&nbsp;&nbsp;&nbsp;&nbsp;
		  <select name=\"listCategory\" class=\"textfield\" id=\"listCategory\" onchange=\"document.frm_cat.submit();\">
		  <option value=\"-1\" selected>Select Category</option>";

							 $rsc=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId='0'  order by fld_categoryName");
							 while($rowc=$dbh2->FetchRow($rsc))
							 {
								 if($rowc[fld_categoryId]==$pId)
									$tab.="<option value=".$rowc[fld_categoryId]." selected>".$rowc[fld_categoryName]."</option>";
								 else
									$tab.="<option value=".$rowc[fld_categoryId].">".$rowc[fld_categoryName]."</option>";
							 }


		$tab.="</select></td></tr><tr><td class=\"links\">Sub:&nbsp;&nbsp;&nbsp;&nbsp;
		  <select name=\"subCategory\" class=\"textfield\" id=\"subCategory\" onchange=\"document.frm_cat.submit();\">
		  <option value=\"-1\" selected>Select Sub Category</option>";

							 $rss=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId='".$pId."' order by fld_categoryName");
							 while($rows=$dbh2->FetchRow($rss))
							 {
								 if($rows[fld_categoryId]==$subcatId)
									$tab.="<option value=".$rows[fld_categoryId]." selected>".$rows[fld_categoryName]."</option>";
								 else
									$tab.="<option value=".$rows[fld_categoryId].">".$rows[fld_categoryName]."</option>";
							 }


		$tab.="</select></td></tr></table></form> </td>
		<td></td>
		</tr>
        <tr>
		<td height=\"15\"></td>
		<td></td>
		<td></td>
		</tr>

        <tr>
		<td height=\"10\"></td>
		<td>";

			$rst=$dbh2->Query("select * from ".TB_TESTIMONIAL." order by fld_tId desc");
			if($dbh2->NumRows($rst)>0)
			{

        		$tab.="<table width=\"515\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";

 while($rowt=$dbh2->FetchRow($rst))
{
 $tab.="<tr>
    <td height=\"2\"></td>
  </tr>
  <tr>
  <td height=\"40\" valign=\"middle\" class=\"color_blue2\"><span class=\"normal_text\">".trim($rowt['fld_tmessage'])."</span></td>
</tr>";

}

$tab.="</table> ";
}
    $tab.="</td>
		<td></td>
		</tr>

        <tr>
		<td height=\"25\"></td>
		<td></td>
		<td></td>
		</tr>

        <tr>
		<td height=\"10\"></td>
		<td height=\"23\" class=\"heading_with_bg\">&nbsp;&nbsp;&nbsp;Question of the Day </td>
		<td></td>
		</tr>
        <form name=\"frm_signup\" method=post action=\"emailAction.php?action=signup\" onsubmit=\"return chk();\">
						<input type=\"hidden\" name=\"hdnEmail\" value=\"true\">
        <tr>
		<td height=\"10\"></td>
		<td height=\"40\">&nbsp;&nbsp;&nbsp;<input name=\"email_signup_qestions\" size=\"40\" type=\"text\" class=\"textfield\">&nbsp;&nbsp;&nbsp;<input type=\"image\" src=\"images/but_submit.gif\" align=\"absmiddle\" border=\"0\"></td>
		<td></td>
		</tr>
        </form>
        <tr>
		<td height=\"25\"></td>
		<td></td>
		<td></td>
		</tr>

        <tr>
		<td height=\"10\"></td>
		<td>
        <form name=\"frm_tellAfirend\" method=POST action=\"emailAction.php?action=tellafriend\" onsubmit=\"return Tellchk();\">
						<input type=\"hidden\" name=\"hdnTellAFriend\" value=\"true\">
						<input type=\"hidden\" name=\"hdnPage\" value=\"".$_SERVER['PHP_SELF']."\">
        <table width=\"515\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
  <tr>
    <td height=\"23\" bgcolor=\"#a0ceff\" class=\"heading_with_bg\">&nbsp;&nbsp;Refer a Friend</td>
  </tr>
  <tr>
    <td><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#ebf8ff\">
       <tr>
        <td height=\"3\"></td>
        <td></td>
      </tr>
      <tr>
        <td width=\"24%\" align=\"right\" class=\"links\">&nbsp;&nbsp;&nbsp;Friend email :&nbsp;&nbsp;</td>
        <td width=\"76%\"><input name=\"txtFriendEmail\" type=\"text\" size=\"25\" class=\"textfield\" id=\"txtFriendEmail\" /></td>
      </tr>

      <tr>
        <td height=\"3\"></td>
        <td></td>
      </tr>

      <tr>
        <td align=\"right\" class=\"links\">&nbsp;&nbsp;&nbsp;Your email :&nbsp;&nbsp;</td>
        <td><input name=\"txtYourEmail\" size=\"25\" type=\"text\" class=\"textfield\" id=\"txtYourEmail\" /></td>
      </tr>
       <tr>
        <td height=\"3\"></td>
        <td></td>
      </tr>
      <tr>
        <td align=\"right\" class=\"links\">&nbsp;&nbsp;&nbsp;Message box :&nbsp;&nbsp;</td>
        <td><textarea cols=\"40\" rows=\"3\" class=\"textfield\" name=\"txtMessage\"></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;<input type=\"image\" src=\"images/but_submit.gif\" align=\"absmiddle\" border=\"0\"></a>
          <br /></td>
      </tr>
    </table></td>
  </tr>
</table> </form>      </td>
		<td></td>
		</tr>
		<tr>
		<td width=\"15\" height=\"8\"></td>
		<td width=\"515\"></td>
		<td width=\"18\"></td>
		</tr>
        <tr>
		<td width=\"15\" ></td>
		<td width=\"515\" class=\"normal_text\">".$templateBottomDesc."</td>
		<td width=\"18\"></td>
		</tr>

        <tr>
		<td height=\"10\"></td>
		<td></td>
		<td></td>
		</tr>";


















































		$tab.= "</table></td>
	</tr>
	<tr>
		<td height=\"5\">
        <table width=\"548\" height=\"5\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr><td width=\"5\" height=\"5\"><img src=\"images/blue2_bot_coe1.jpg\"></td>
  		<td width=\"538\" class=\"color_blue3\"></td>
		<td width=\"5\"><img src=\"images/blue2_bot_cor2.jpg\"></td>
  </tr>
</table>

        </td>
	</tr>
</table>

        </td>
	</tr>



</table>
</td>

		<td width=\"10\"></td>
	</tr>
</table>

        </td>
	</tr>
	<tr>
		<td height=\"15\"></td>
	</tr>
	<tr>
		<td><table width=\"767\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
        <tr><td height=\"46\">
        <table width=\"767\" height=\"46\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr><td width=\"11\" height=\"46\"><img src=\"images/footer_cor1.jpg\"></td>
  	<td background=\"images/footer_cor2.jpg\" width=\"745\" align=\"center\" class=\"footer_text\">
   <a href=\"index.php\"> Home </a> | <a href=\"careers.php\"> Careers </a> | <a href=\"aboutus.php\"> About </a> | <a href=\"contact.php\"> Contact </a> | <a href=\"testimonials.php\"> Testimonials </a> | <a href=\"disclaimer.php\"> Disclaimer </a> | <a href=\"licensing.php\"> Site Licensing </a>

    </td>
  	<td><img src=\"images/footer_cor3.jpg\"></td>
  </tr>
</table>

        </td></tr>
        <tr><td height=\"6\"></td></tr>
        </table>

        </td>
	</tr>
</table>
</body>
</html>";



$f = @fopen(DR_BASE_ROOT.$filename, "w");
$r = @fwrite($f, $tab);
fclose($f);

}
}
function publish_exam_pages1($id)
{

	global $dbh2, $ObjGen;


	$rsj=$dbh2->Query("select * from ".TB_EXAMS." where fld_productId='".$id."'");
	$exam_rowj=$dbh2->FetchRow($rsj);


	$rsqm=$dbh2->Query("select * from ".TB_CATEGORY." where fld_categoryId='".$exam_rowq['fld_parentId']."'");
	$exam_rowqm=$dbh2->FetchRow($rsqm);

	$rs3=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId=0 order by fld_categoryName ASC");
	$larr=Array();
	while($rowk=mysql_fetch_array($rs3))
	$larr[]=$rowk;
	$subcatId=$exam_rowj['fld_categoryIdNo'];
	$subcatName=$exam_rowq['fld_categoryName'];
	$pId=$exam_rowq['fld_parentId'];
	$catName=$exam_rowqm['fld_categoryName'];

	$rs=$dbh2->Query("select * from ".TB_EXAMS." where fld_productId='".$id."'");
	$exam_row=$dbh2->FetchRow($rs);

	$arrVars=Array(

		"exam_name" =>$exam_row['fld_examTitle'],
		"exam_code" =>$exam_row['fld_examCode']

		);


	$rs_template=$dbh2->Query("select * from ".TB_TEMPLATES." ORDER BY is_main DESC");
	$arrTemplates_data=Array();

	while($template_row=$dbh2->FetchRow($rs_template))
	{
		$arrTemplates_data[]=$template_row;
	}

	for($tp=0;$tp<count($arrTemplates_data);$tp++)
	{

		$templateShortDesc=$exam_row['fld_examShortDesc'];
		$templateTopDesc=$arrTemplates_data[$tp]['fld_templateTopDesc'];
		$templateBottomDesc=$arrTemplates_data[$tp]['fld_templateBottomDesc'];
		$templateTitle=stripslashes($arrTemplates_data[$tp]['fld_templatePageTitle']);
		$templateKeywords=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaKeywords']);
		$templateDesc=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaDesc']);

		foreach($arrVars as $key=>$val)
		{
			$templateShortDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateShortDesc);
			$templateTopDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTopDesc);
			$templateBottomDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateBottomDesc);
			$templateTitle=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTitle);
			$templateKeywords=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateKeywords);
			$templateDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateDesc);
		}
		$key='';
		$val='';
		if($arrTemplates_data[$tp][is_main]==1)
		{
			$filename=$ObjGen->replacespace($exam_row[fld_examCode]).".html";
		}
		else
		{
			$filename=$ObjGen->replacespace($exam_row[fld_examCode])."_".$arrTemplates_data[$tp][fld_templateLink];
		}

		if($arrTemplates_data[$tp+1][is_main]==1)
		{

			$previousTemplateUrl=$exam_row[fld_examCode]."_".$filename;
		}
		else
		{
			$previousTemplateUrl=$exam_row[fld_examCode]."_".$arrTemplates_data[$tp+1][fld_templateLink];
		}






	$rs=$dbh2->Query("select * from ".TB_EXAMS." where fld_productId='".$id."'");
	$exam_row=$dbh2->FetchRow($rs);


	$templateTopDesc=$template_row[0][fld_templateTopDesc];
	$templateBottomDesc=$template_row[0][fld_templateBottomDesc];

	$arrVars=Array();
	$arrVars['exam_name']=$exam_row[fld_examTitle];
	$arrVars['exam_code']=$exam_row[fld_examCode];






	$tab="<html>
		<title>".$templateTitle."</title>
		<head>
		<meta http-equiv=\"Content-Language\" content=\"en-us\">
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">
		<meta name=\"GENERATOR\" content=\"Microsoft FrontPage 5.0\">
		<meta name=\"Author\" content=\"".stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaAuthor'])."\">
		<meta name=\"Keywords\" content=\"".$templateKeywords."\">
		<meta name=\"Description\" content=\"".$templateDesc."\">";

          $tab.="<script type=\"text/javascript\">

              var _gaq = _gaq || [];
              _gaq.push(['_setAccount', 'UA-7389997-8']);
              _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";

		$tab.="<style type=\"text/css\">

body {
	background-color: #CCCCCC;
}

</style>
<link href=\"include/CssStyle.css\" rel=\"stylesheet\" type=\"text/css\">
<script type=\"text/javascript\">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf('#')!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf(\"?\"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage()
{
  	var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function chk()
{
	if(!validateTEmail(document.frm_signup.email_signup_qestions.value))
	{
		alert('Please enter a valid email address.');
		document.frm_signup.email_signup_qestions.focus();
		return false;
	}
}
function validateTEmail( strValue) {
var objRegExp  = /(^[a-z0-9A-Z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)([.][a-z]{3})$)|(^[0-9A-Za-z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)(\.[a-z]{3})(\.[a-z]{2})*$)/i;


							  return objRegExp.test(strValue);
							}

						function Tellchk()
						{
							if(!validateTEmail(document.frm_tellAfirend.txtFriendEmail.value))
							{
								alert('Please enter a valid email address.');
								document.frm_tellAfirend.txtFriendEmail.focus();
								return false;
							}
							if(!validateTEmail(document.frm_tellAfirend.txtYourEmail.value))
							{
								alert('Please enter a valid email address.');
								document.frm_tellAfirend.txtYourEmail.focus();
								return false;
							}
						}




//-->
</script>
</head>";
$tab.="<body leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' onLoad=\"MM_preloadImages('images/but_home_over.jpg','images/but_Shoppingcart_over.jpg','images/but_corporate_over.jpg','images/but_guarantee_over.jpg','images/but_affiliates_over.jpg','images/but_contact_over.jpg')\">
<table width=\"767\"  border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\" align=\"center\">
	<tr>
		<td>

        	<table width=\"767\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">

	<tr>
	  <td width=\"767\" valign=\"top\" background=\"images/header_certarea.jpg\"><table width=\"767\" height=\"121\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
        <tr>
          <td width=\"472\" height=\"121\"></td>
          <td><table width=\"295\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
              <tr>
                <td height=\"32\" width=\"295\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"right\">
                    <tr>
                      <td><a href=\"index.php\"><img src=\"images/icon_home.gif\" alt=\"Certarea\" border=\"0\" /></a></td>
                      <td></td>
                      <td><a href=\"\"><img src=\"images/icon_sitemap.gif\" alt=\"Certarea\" border=\"0\" /></a></td>
                      <td></td>
                      <td><a href=\"contact2.php\"><img src=\"images/icon_contact.gif\" alt=\"Certarea\" border=\"0\" /></a></td>
                      <td width=\"30\"></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td height=\"54\"></td>
              </tr>
              <tr>
                <td height=\"35\"><form name=\"search_form\" method=\"post\" action=\"exam.php\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                    <tr>
                      <td width=\"90\" class=\"links\">Enter Search :</td>
                      <td><input name=\"search_keyword\" type=\"text\" class=\"textfield\" /></td>
                      <td width=\"10\"></td>
                      <td><a href=\"\"><img src=\"images/header_bottom_28.jpg\" alt=\"Certarea\" border=\"0\" /></a></td>
                    </tr>
                </table></form></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
	  </tr>

	<tr>
		<td valign=\"top\">

        	<table width=\"767\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"left\">
	<tr>

		<td><a href=\"index.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('home','','images/but_home_over.jpg',1)\"><img src=\"images/but_home.jpg\" name=\"home\" width=\"80\" height=\"37\" border=\"0\"></a></td>
		<td width=\"1\"></td>
		<td><a href=\"cart.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Shoppingcart','','images/but_Shoppingcart_over.jpg',1)\"><img src=\"images/but_Shoppingcart.jpg\" name=\"Shoppingcart\" width=\"130\" height=\"37\" border=\"0\"></a></td>
		<td width=\"1\"></td>
		<td><a href=\"licensing.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('cor','','images/but_corporate_over.jpg',1)\"><img src=\"images/but_corporate.jpg\" name=\"cor\" width=\"168\" height=\"37\" border=\"0\"></a></td>
		<td width=\"1\"></td>
		<td><a href=\"guarantee.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('gre','','images/but_guarantee_over.jpg',1)\"><img src=\"images/but_guarantee.jpg\" name=\"gre\" width=\"104\" height=\"37\"  border=\"0\"></a></td>
		<td width=\"1\"></td>
		<td><a href=\"affiliates.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('affi','','images/but_affiliates_over.jpg',1)\"><img src=\"images/but_affiliates.jpg\" name=\"affi\" width=\"96\" height=\"37\" border=\"0\"></a></td>
		<td width=\"1\"></td>
		<td><a href=\"faq.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('faq','','images/but_faq_over.jpg',0)\"><img src=\"images/but_faq.jpg\" name=\"faq\" width=\"70\" height=\"37\"  border=\"0\"></a></td>
		<td width=\"1\"></td>
		<td><a href=\"contact.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('contact','','images/but_contact_over.jpg',1)\"><img src=\"images/but_contact.jpg\" name=\"contact\" width=\"113\" height=\"37\"  border=\"0\"></a></td>
		</tr>
</table>        </td>
	</tr>

</table>


        </td>
	</tr>
	<tr>
		<td height=\"20\"></td>
	</tr>
	<tr>
		<td>

        		<table width=\"767\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
		<td width=\"9\"></td>
		<td width=\"186\" valign=\"top\">

        <table width=\"186\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
<tr height=\"35\">
		<td width=\"12\"><img src=\"images/left_links_heading_bar_cor1.jpg\"></td>
  		<td width=\"162\" background=\"images/left_links_heading_bg.jpg\" class=\"heading1\">Our Vendors</td>
	  <td><img src=\"images/left_links_heading_bar_cor2.jpg\"></td>
		</tr>

  <tr><td width=\"12\" background=\"images/body_left_cor1.jpg\"></td>

        <td class=\"color_gray\">

        	<table width=\"162\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";







		for($a=0;$a<count($larr);$a++)
		{

			$tab.="<tr><td height=\"1\" background=\"images/doted_line.gif\"></td></tr>";

    		$tab.="<tr><td class=\"links1\"><a href='".DR_ROOT.$ObjGen->replacespace($larr[$a]['fld_categoryName']).".html"."'><img src=\"images/aero.gif\" align=\"absmiddle\" border=\"0\">&nbsp;&nbsp;".trim($larr[$a][fld_categoryName])."</a></td></tr>";

		}



		$tab.="<tr><td height=\"1\" background=\"images/doted_line.gif\"></td></tr>

	<tr><td height=\"5\"></td>
	</tr>
</table>
</td>";

	$tab.="<td width=\"12\" background=\"images/body_left_cor2.jpg\"></td>
  		</tr>

        <tr><td><img src=\"images/body_left_cor3.jpg\"></td>
  		<td background=\"images/body_left_cor4.jpg\"></td>
  		<td><img src=\"images/body_left_cor5.jpg\"></td>
  		</tr>
</table>";


$tab.="</td>
		<td width=\"11\"></td>
		<td width=\"553\" valign=\"top\" align=\"left\">


			<table  width=\"554\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">

	<tr>
		<td width=\"554\">

        	<table width=\"386\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr><td height=\"29\">
    	<table width=\"548\" height=\"29\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
		<td width=\"5\" height=\"29\"><img src=\"images/heading1_cor1.jpg\"></td>
		<td width=\"13\" class=\"color_blue\"></td>
		<td class=\"color_blue\"><span class=\"heading2\">".trim($exam_rowq[fld_categoryName])."</span></td>
		<td width=\"5\"><img src=\"images/heading1_cor2.jpg\"></td>
	</tr>
</table>
    </td></tr>
	<tr>
		<td>

        	<table width=\"548\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"color_blue3\">
			<tr>
		<td width=\"15\" height=\"8\"></td>
		<td width=\"515\"></td>
		<td width=\"18\"></td>
		</tr>
			";





       $tab.="<tr>
		<td height=\"15\"></td>
		<td class=\"normal_text\"><span class=\"heading1\">".trim($exam_row[fld_examCode])." - ".trim($exam_row[fld_examTitle])." Exam</span><br><br>";
if(trim($exam_row['fld_examShortDesc']) != "")
{

$tab.="<ul>
<li>".$exam_row['fld_examShortDesc'];
}
$tab.="</td>
		<td></td>
		</tr>";

         $tab.="<tr>
		<td height=\"15\"></td>
		<td></td>
		<td></td>
		</tr>";


        $tab.="<tr>
		<td height=\"15\"></td>
		<td>
        <form name=\"examform\" method=\"post\" action=\"".DR_ROOT."shopCart.php"."\">
		<input type=\"hidden\" name=\"examId\" value=\"".$exam_row['fld_productId']."\">
		<input type=\"hidden\" name=\"catId\" value=\"".$id."\">
		<input type=\"hidden\" name=\"quantity\" value=\"1\">
		<input type=\"hidden\" name=\"action\" value=\"add\">
        <table width=\"515\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"color_blue2\">
	<tr>
		<td width=\"16\" height=\"17\"></td>
		<td width=\"79\"></td>
		<td width=\"22\"></td>
		<td width=\"369\"></td>
		<td width=\"29\"></td>
	</tr>
	<tr>
		<td height=\"107\"></td>
		<td><img src=\"images/book.png\" width=\"79\" height=\"107\" alt=\"book\" style=\"margin-top:10px\"></td>
  		<td></td>
		<td valign=\"top\">

        <table width=\"369\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr><td class=\"heading1\">".$exam_row['fld_examTitle']."</td>
  </tr>
   <tr><td height=\"6\"></td></tr>



  <tr>
    <td class=\"color_blue4\" height=\"40\"><span class=\"heading2\">Updated :&nbsp;&nbsp;&nbsp;".date("m/d/Y",$exam_row['fld_updatedOn'])."<br>
     Price :     &nbsp;&nbsp;&nbsp;$".$exam_row['fld_examFee']."</span></td>
  </tr>
  <tr><td class=\"color_blue4\" height=\"5\"></td></tr>
  <tr class=\"color_blue4\">
    <td class=\"normal_text\" valign=\"middle\">".trim($exam_row['fld_examShortDesc'])."</td></tr>
</table>        </td>
		<td></td>
	</tr>
	<tr>
		<td height=\"7\"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td height=\"26\"></td>
		<td></td>
		<td></td>
		<td><input type=\"image\" src=\"images/buynow.gif\" border=\"0\">";
		if(trim($exam_row['fld_examQAdemoFile'])!="" or trim($exam_row['fld_examStudyGuidedemoFile'])!="" or trim($exam_row['fld_examTestEnginedemoFile'])!="" or trim($exam_row['fld_examAudioGuidedemoFile'])!="")
		{

			$tab.="&nbsp;&nbsp;&nbsp;<a href=\"demo.php?exid=".$exam_row['fld_productId']."\"><img src=\"images/demo.gif\" border=\"0\"></a>";
		}
		$tab.="</td>
		<td></td>
	</tr>
	<tr>
		<td height=\"12\"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table></form> </td>
		<td></td>
		</tr>




        <tr>
		<td height=\"5\"></td>
		<td></td>
		<td></td>
		</tr>";





$tab.="<tr>
		<td height=\"15\"></td>
		<td></td>
		<td></td>
		</tr>
		<tr class=\"heading_with_bg\">
		<td height=\"5\"></td>
		<td></td>
		<td></td>
		</tr>";



		$tab.="<tr>
		<td height=\"30\"></td>
		<td></td>
		<td></td>
		</tr>
        <tr>
		<td width=\"15\" ></td>
		<td width=\"515\" class=\"normal_text\">".$templateTopDesc."</td>
		<td width=\"18\"></td>
		</tr>
		<tr>
		<td width=\"15\" height=\"8\"></td>
		<td width=\"515\"></td>
		<td width=\"18\"></td>
		</tr>
        <tr>
		<td height=\"10\"></td>
		<td class=\"heading3\">All prices in US Dollars.<br></td>
		<td></td>
		</tr>
        <tr>
		<td height=\"5\"></td>
		<td></td>
		<td></td>
		</tr>
         <tr>
		<td height=\"5\"></td>
		<td class=\"links\"><form name=\"frm_cat\" method=\"post\" action=\"".DR_ROOT."searchExams.php"."\">
		<input type=\"hidden\" name=\"hdnSubmit\" value=\"1\">
		<table width=\"100%\" cellspacing=\"2\" cellpadding=\"2\"><tr><td class=\"links\">

		Main:&nbsp;&nbsp;&nbsp;&nbsp;
		  <select name=\"listCategory\" class=\"textfield\" id=\"listCategory\" onchange=\"document.frm_cat.submit();\">
		  <option value=\"-1\" selected>Select Category</option>";

							 $rsc=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId='0'  order by fld_categoryName");
							 while($rowc=$dbh2->FetchRow($rsc))
							 {
								 if($rowc[fld_categoryId]==$pId)
									$tab.="<option value=".$rowc[fld_categoryId]." selected>".$rowc[fld_categoryName]."</option>";
								 else
									$tab.="<option value=".$rowc[fld_categoryId].">".$rowc[fld_categoryName]."</option>";
							 }


		$tab.="</select></td></tr><tr><td class=\"links\">Sub:&nbsp;&nbsp;&nbsp;&nbsp;
		  <select name=\"subCategory\" class=\"textfield\" id=\"subCategory\" onchange=\"document.frm_cat.submit();\">
		  <option value=\"-1\" selected>Select Sub Category</option>";

							 $rss=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId='".$pId."' order by fld_categoryName");
							 while($rows=$dbh2->FetchRow($rss))
							 {
								 if($rows[fld_categoryId]==$subcatId)
									$tab.="<option value=".$rows[fld_categoryId]." selected>".$rows[fld_categoryName]."</option>";
								 else
									$tab.="<option value=".$rows[fld_categoryId].">".$rows[fld_categoryName]."</option>";
							 }


		$tab.="</select></td></tr></table></form> </td>
		<td></td>
		</tr>
        <tr>
		<td height=\"15\"></td>
		<td></td>
		<td></td>
		</tr>

        <tr>
		<td height=\"10\"></td>
		<td>";

			$rst=$dbh2->Query("select * from ".TB_TESTIMONIAL." order by fld_tId desc Limit 0,2");
			if($dbh2->NumRows($rst)>0)
			{

        		$tab.="<table width=\"515\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";

 while($rowt=$dbh2->FetchRow($rst))
{
 $tab.="<tr>
    <td height=\"2\"></td>
  </tr>
  <tr>
  <td height=\"40\" valign=\"middle\" class=\"color_blue2\"><span class=\"normal_text\">".trim($rowt['fld_tmessage'])."</span></td>
</tr>";

}

$tab.="</table> ";
}
    $tab.="</td>
		<td></td>
		</tr>

        <tr>
		<td height=\"25\"></td>
		<td></td>
		<td></td>
		</tr>

        <tr>
		<td height=\"10\"></td>
		<td height=\"23\" class=\"heading_with_bg\">&nbsp;&nbsp;&nbsp;Question of the Day </td>
		<td></td>
		</tr>
        <form name=\"frm_signup\" method=post action=\"emailAction.php?action=signup\" onsubmit=\"return chk();\">
						<input type=\"hidden\" name=\"hdnEmail\" value=\"true\">
        <tr>
		<td height=\"10\"></td>
		<td height=\"40\">&nbsp;&nbsp;&nbsp;<input name=\"email_signup_qestions\" size=\"40\" type=\"text\" class=\"textfield\">&nbsp;&nbsp;&nbsp;<input type=\"image\" src=\"images/but_submit.gif\" align=\"absmiddle\" border=\"0\"></td>
		<td></td>
		</tr>
        </form>
        <tr>
		<td height=\"25\"></td>
		<td></td>
		<td></td>
		</tr>

        <tr>
		<td height=\"10\"></td>
		<td>
        <form name=\"frm_tellAfirend\" method=POST action=\"emailAction.php?action=tellafriend\" onsubmit=\"return Tellchk();\">
						<input type=\"hidden\" name=\"hdnTellAFriend\" value=\"true\">
						<input type=\"hidden\" name=\"hdnPage\" value=\"".$_SERVER['PHP_SELF']."\">
        <table width=\"515\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
  <tr>
    <td height=\"23\" bgcolor=\"#a0ceff\" class=\"heading_with_bg\">&nbsp;&nbsp;Refer a Friend</td>
  </tr>
  <tr>
    <td><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#ebf8ff\">
       <tr>
        <td height=\"3\"></td>
        <td></td>
      </tr>
      <tr>
        <td width=\"24%\" align=\"right\" class=\"links\">&nbsp;&nbsp;&nbsp;Friend email :&nbsp;&nbsp;</td>
        <td width=\"76%\"><input name=\"txtFriendEmail\" type=\"text\" size=\"25\" class=\"textfield\" id=\"txtFriendEmail\" /></td>
      </tr>

      <tr>
        <td height=\"3\"></td>
        <td></td>
      </tr>

      <tr>
        <td align=\"right\" class=\"links\">&nbsp;&nbsp;&nbsp;Your email :&nbsp;&nbsp;</td>
        <td><input name=\"txtYourEmail\" size=\"25\" type=\"text\" class=\"textfield\" id=\"txtYourEmail\" /></td>
      </tr>
       <tr>
        <td height=\"3\"></td>
        <td></td>
      </tr>
      <tr>
        <td align=\"right\" class=\"links\">&nbsp;&nbsp;&nbsp;Message box :&nbsp;&nbsp;</td>
        <td><textarea cols=\"40\" rows=\"3\" class=\"textfield\" name=\"txtMessage\"></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;<input type=\"image\" src=\"images/but_submit.gif\" align=\"absmiddle\" border=\"0\"></a>
          <br /></td>
      </tr>
    </table></td>
  </tr>
</table> </form>      </td>
		<td></td>
		</tr>
		<tr>
		<td width=\"15\" height=\"8\"></td>
		<td width=\"515\"></td>
		<td width=\"18\"></td>
		</tr>
        <tr>
		<td width=\"15\" ></td>
		<td width=\"515\" class=\"normal_text\">".$templateBottomDesc."</td>
		<td width=\"18\"></td>
		</tr>

        <tr>
		<td height=\"10\"></td>
		<td></td>
		<td></td>
		</tr>";


















































		$tab.= "</table></td>
	</tr>
	<tr>
		<td height=\"5\">
        <table width=\"548\" height=\"5\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr><td width=\"5\" height=\"5\"><img src=\"images/blue2_bot_coe1.jpg\"></td>
  		<td width=\"538\" class=\"color_blue3\"></td>
		<td width=\"5\"><img src=\"images/blue2_bot_cor2.jpg\"></td>
  </tr>
</table>

        </td>
	</tr>
</table>

        </td>
	</tr>



</table>
</td>

		<td width=\"10\"></td>
	</tr>
</table>

        </td>
	</tr>
	<tr>
		<td height=\"15\"></td>
	</tr>
	<tr>
		<td><table width=\"767\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
        <tr><td height=\"46\">
        <table width=\"767\" height=\"46\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr><td width=\"11\" height=\"46\"><img src=\"images/footer_cor1.jpg\"></td>
  	<td background=\"images/footer_cor2.jpg\" width=\"745\" align=\"center\" class=\"footer_text\">
   <a href=\"index.php\"> Home </a> | <a href=\"careers.php\"> Careers </a> | <a href=\"aboutus.php\"> About </a> | <a href=\"contact.php\"> Contact </a> | <a href=\"testimonials.php\"> Testimonials </a> | <a href=\"disclaimer.php\"> Disclaimer </a> | <a href=\"licensing.php\"> Site Licensing </a>

    </td>
  	<td><img src=\"images/footer_cor3.jpg\"></td>
  </tr>
</table>

        </td></tr>
        <tr><td height=\"6\"></td></tr>
        </table>

        </td>
	</tr>
</table>
</body>
</html>";



$f = @fopen(DR_BASE_ROOT.$filename, "w");
$r = @fwrite($f, $tab);
fclose($f);

}
}
function publish_cat_pages($id)
{
	global $dbh2, $ObjGen;
	
$rs=$dbh2->Query("select * from ".TB_CATEGORY." where fld_categoryId='".$id."'");
$exam_row=$dbh2->FetchRow($rs);
$arrVars=Array(
	"exam_name" =>$exam_row[fld_categoryName],
	"exam_code" =>$exam_row[fld_categoryName]
);
	$rs_template=$dbh2->Query("select * from ".TB_CTEMPLATES." ORDER BY is_main DESC");
	$arrTemplates_data=Array();
	while($template_row=$dbh2->FetchRow($rs_template)){
		$arrTemplates_data[]=$template_row;
	}

	for($tp=0;$tp<count($arrTemplates_data);$tp++){
		$templateShortDesc="";
		$templateTopDesc=$arrTemplates_data[$tp]['fld_templateTopDesc'];
		$templateBottomDesc=$arrTemplates_data[$tp]['fld_templateBottomDesc'];
		$templateTitle=stripslashes($arrTemplates_data[$tp]['fld_templatePageTitle']);
		$templateKeywords=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaKeywords']);
		$templateDesc=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaDesc']);

		foreach($arrVars as $key=>$val)	{
			$templateShortDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateShortDesc);
			$templateTopDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTopDesc);
			$templateBottomDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateBottomDesc);
			$templateTitle=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTitle);
			$templateKeywords=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateKeywords);
			$templateDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateDesc);
		}
		$key='';
		$val='';
		if($arrTemplates_data[$tp][is_main]==1){
			$filename=$ObjGen->replacespace($exam_row[fld_categoryName]).FILES_EXT.".html";
		}else{
			$filename=$ObjGen->replacespace($exam_row[fld_categoryName])."_".$arrTemplates_data[$tp][fld_templateLink];
		}

		if($arrTemplates_data[$tp+1][is_main]==1){
			$previousTemplateUrl=$exam_row[fld_categoryName]."_".$filename;
		}else{
			$previousTemplateUrl=$exam_row[fld_categoryName]."_".$arrTemplates_data[$tp+1][fld_templateLink];
		}

		$pId=$ObjGen->getVal(TB_CATEGORY,"fld_parentId",$id,"fld_categoryId");
		$catName=$ObjGen->getVal(TB_CATEGORY,"fld_categoryId",$id,"fld_categoryName");

		$sqls="select fld_categoryId from ".TB_CATEGORY." where fld_parentId=".$id;
		$rssubcategories=$dbh2->Query($sqls);
		$earr=Array();
		while($rowsa=mysql_fetch_array($rssubcategories)){
			$rs1=$dbh2->Query("select * from ".TB_EXAMS." where fld_categoryIdNo=' ".$rowsa['fld_categoryId']."' order by fld_examCode ASC");
			while($row=mysql_fetch_array($rs1))
			$earr[]=$row;
		}
		$rs3=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId=0 order by fld_categoryName ASC");
		$larr=Array();

		while($row=mysql_fetch_array($rs3))
		$larr[]=$row;


		$rs34=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId=".$id." order by fld_categoryName ASC");
   	 	$larrsub=Array();
		while($rowsubcat=mysql_fetch_array($rs34))
		$larrsub[]=$rowsubcat;
$tab ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<meta http-equiv="Content-Language" content="en-us" />
<meta name="GENERATOR" content="Microsoft FrontPage 5.0" />
<meta name="Author" content="'.stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaAuthor']).'" />
<meta name="Keywords" content="'.$templateKeywords.'" />
<meta name="Description" content="'.$templateDesc.'" />
<title>'.$templateTitle.'</title>
<link href="css/mainSyler.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

              var _gaq = _gaq || [];
              _gaq.push(["_setAccount", "UA-7389997-8"]);
              _gaq.push(["_trackPageview"]);

  (function() {
    var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
    ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
  })();


function blank(a){
if(a.value == a.defaultValue) a.value = "";
}
function unblank(a){
if(a.value == "") a.value = a.defaultValue;
}
</script>

<script type="text/javascript">
<!--
function chk()
{
	if(!validateTEmail(document.frm_signup.email_signup_qestions.value))
	{
		alert(\'Please enter a valid email address.\');
		document.frm_signup.email_signup_qestions.focus();
		return false;
	}
}
function validateTEmail( strValue) {
var objRegExp  = /(^[a-z0-9A-Z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)([.][a-z]{3})$)|(^[0-9A-Za-z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)(\.[a-z]{3})(\.[a-z]{2})*$)/i;
  return objRegExp.test(strValue);
}

function Tellchk()
{
	if(!validateTEmail(document.frm_tellAfirend.txtFriendEmail.value)){
		alert(\'Please enter a valid email address.\');
		document.frm_tellAfirend.txtFriendEmail.focus();
		return false;
	}
	if(!validateTEmail(document.frm_tellAfirend.txtYourEmail.value)){
		alert(\'Please enter a valid email address.\');
		document.frm_tellAfirend.txtYourEmail.focus();
		return false;
	}
}
//-->
</script>
</script>
</head>
<body>';
$tab .='<div class="mainContaner">
<div class="headerContaner">
<div class="logoHolder">
      <h1><a href="<?php echo LINK_PATH;?>#"></a></h1>
    </div>
    <div class="ChatHolder"><!-- BEGIN ProvideSupport.com Graphics Chat Button Code -->
<div id="cijMWT" style="z-index:100;position:absolute"></div><div id="scjMWT" style="display:inline"></div><div id="sdjMWT" style="display:none"></div><script type="text/javascript">var sejMWT=document.createElement("script");sejMWT.type="text/javascript";var sejMWTs=(location.protocol.indexOf("https")==0?"https":"http")+"://image.providesupport.com/js/nextagetech/safe-standard.js?ps_h=jMWT&ps_t="+new Date().getTime();setTimeout("sejMWT.src=sejMWTs;document.getElementById(\'sdjMWT\').appendChild(sejMWT)",1)</script><noscript><div style="display:inline"><a href="<?php echo LINK_PATH;?>http://www.providesupport.com?messenger=nextagetech">Chat Support</a></div></noscript>
<!-- END ProvideSupport.com Graphics Chat Button Code --></div>
    <div class="headerRight">
    <input name="" type="image" src="images/registerBtn.png" border="0"  align="right" class="regBtn" onclick="javascript:window.location=\'register.php\';"><br />
    <div class="topmenu">
         <div class="cart"><strong><a href="<?php echo LINK_PATH;?>'.DR_ROOT.'cart.php">Shopping Cart</a></strong></div>
        
      </div>
    </div>
</div>

<div class="bodyContaner">
<div class="bodyContanerTop"></div>
<div class="bodyInner">

<div class="menuContaner">
<div class="navouter">
<div id="navcontainer">
        <ul id="navlist">
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'index.php">Home</a></li>
          <li id="active"><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'all-categories.php">Exams</a></li>
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'licensing.php">Corporate Licensing</a></li>     
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'guarantee.php">Guarantee</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'affiliates.php">Affiliates</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'faq.php">FAQs</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'aboutus.php">About Us</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'contact.php">Contact Us</a></li>
        </ul>
      </div>
</div>
<div class="serchCont">
<form name="search_form" method="post" action="'. DR_ROOT.'exam.php"><input type="text" class="searchFIld" value="Search" name="search_keyword"  onfocus="blank(this)" onblur="unblank(this)"> 
<a href="javascript:void(0);" onclick="document.search_form.submit();"><img src="<?php echo LINK_PATH;?>images/search.jpg" border="0" align="top" /></a></form></div>
</div>
<div class="bodyData">';
$tab .='<div class="leftContaner"><div class="leftHead">
    <h3>Our Vendors </h3>
  </div>
  <div id="button">
    <ul>';
    $rs=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId='0' order by fld_categoryName asc");
    $stpos = 0;
	while($row=$dbh2->FetchRow($rs)){
		$tab .='<li><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($row['fld_categoryName']).FILES_EXT.'.html">'. $row[fld_categoryName] .'</a></li>';
	}

    $tab .='</ul>
  </div>
</div>';
    $tab .='<div class="rightContaner"> 
     <p>'.trim($exam_row[fld_categoryName]).' Exam by Certmagic</p>';      
		$rspk1=$dbh2->Query("select p.fld_PackId, p.fld_PackCode, p.fld_PackName, p.fld_PackFee, p.fld_PackEdition from ".TB_PACKAGE." p INNER JOIN ".TB_PACK_CATEGORY." pc on p.fld_PackId=pc.fld_PackId where pc.fld_categoryId='".$id."' order by p.fld_PackCode ASC");
		if(mysql_num_rows($rspk1)) {
			$catnameap=true;
			while($rowpk1=mysql_fetch_array($rspk1)) {
				$tab .='<div class="cateMan">
            			<div class="cateManList">';
						$tab .='<ul>
                <li><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($rowpk1['fld_PackCode']).FILES_EXT.".html".'">'.$rowpk1['fld_PackCode'].'</a></li>

                <li><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($rowpk1['fld_PackCode']).FILES_EXT.".html".'">'.$rowpk1['fld_PackName'].'</a></li>
              </ul>
            </div>
                          <div style="clear:both;"></div>
                          <div class="cateManTxt">'.$rowpk1['fld_PackEdition'].'</div>
            <h1 class="valBtm"><form method=post action="'.DR_ROOT."shopCart.php".'">
                        	<input type="hidden" name="packId" value="'.$rowpk1['fld_PackId'].'">
							<input type="hidden" name="type" value="bundle">
                            <input type="hidden" name="catId" value="'.$id.'">
                            <input type="hidden" name="quantity" value="1">$'.$rowpk1['fld_PackFee'].' 
                            <input type="hidden" name="action" value="add"><input type="image" src="images/add_cart.png" name="buy_now" value="Buy now" width="132" height="36"/></form></h1>
            
          </div>';
			}
		}
  for($i7=0;$i7<count($larrsub);$i7++){
		$earr=Array();
		$catnameap=false;
		$rs1k=$dbh2->Query("select * from ".TB_EXAMS." where fld_categoryIdNo='".$larrsub[$i7]['fld_categoryId']."' order by fld_examCode ASC");
		$rspk=$dbh2->Query("select p.fld_PackId, p.fld_PackCode, p.fld_PackName, p.fld_PackFee, p.fld_PackEdition from ".TB_PACKAGE." p INNER JOIN ".TB_PACK_CATEGORY." pc on p.fld_PackId=pc.fld_PackId where pc.fld_categoryId='".$larrsub[$i7]['fld_categoryId']."' order by p.fld_PackCode ASC");
		if(mysql_num_rows($rspk)) {
			$catnameap=true;
			$packcnt=0;
			while($rowpk=mysql_fetch_array($rspk)) {
				$tab .='<div class="cateMan">
            			<div class="cateManList">';
						if($packcnt==0) $tab .='<h2><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($larrsub[$i7]['fld_categoryName']).FILES_EXT.'.html">'.$larrsub[$i7]['fld_categoryName'].' Exam by Certmagic</a></h2>';
						$tab .='<ul>
                <li><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($rowpk['fld_PackCode']).FILES_EXT.".html".'">'.$rowpk['fld_PackCode'].'</a></li>
                <li><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($rowpk['fld_PackCode']).FILES_EXT.".html".'">'.$rowpk['fld_PackName'].'</a></li>
              </ul>
            </div>
                          <div style="clear:both;"></div>
                          <div class="cateManTxt">'.$rowpk['fld_PackEdition'].'</div>
            <h1 class="valBtm"><form method=post action="'.DR_ROOT."shopCart.php".'">
                        	<input type="hidden" name="packId" value="'.$rowpk['fld_PackId'].'">
							<input type="hidden" name="type" value="bundle">
                            <input type="hidden" name="catId" value="'.$larrsub[$i7]['fld_categoryId'].'">
                            <input type="hidden" name="quantity" value="1">$'.$rowpk['fld_PackFee'].' 
                            <input type="hidden" name="action" value="add"><input type="image" src="images/add_cart.png" name="buy_now" value="Buy now" width="132" height="36"/></form></h1>
            
          </div>';
		  $packcnt++;
			}
		}
if(mysql_num_rows($rs1k) > 0 && !$catnameap) {
	$tab .='<h2><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($larrsub[$i7]['fld_categoryName']).FILES_EXT.'.html">'.$larrsub[$i7]['fld_categoryName'].' Exam by Certmagic</a></h2>';
}

		while($rowsk=mysql_fetch_array($rs1k))
		$earr[]=$rowsk;
  
      for($i3=0;$i3<count($earr);$i3++){
			$tab .='<div class="cateHead">
            <h4><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($earr[$i3]['fld_examCode']).FILES_EXT.".html".'">'.$earr[$i3]['fld_examCode'].'</a> <a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($earr[$i3]['fld_examCode']).FILES_EXT.".html".'">'.$earr[$i3]['fld_examTitle'].'</a></h4>
          </div>
          <div class="catAll">
          <div style="float:left; width:300px;">'.$earr[$i3]['fld_examShortDesc'].'</div>
          <div style="float:left;  padding:0 30px;"><strong>'.$ObjGen->MySqltoTextual($earr[$i3]['fld_examDate']).'</strong>
		  <p align="center">$'.$earr[$i3]['fld_examFee'].'</p></div>
          <div style="float:right;"><form method=post action="'.DR_ROOT."shopCart.php".'">
                        	<input type="hidden" name="examId" value="'.$earr[$i3]['fld_productId'].'">
                            <input type="hidden" name="catId" value="'.$id.'">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="action" value="add"><input type="image" src="images/add_cart.png" name="buy_now" value="Buy now" width="132" height="36"/> ';
							if(trim($earr[$i3]['fld_examQAdemoFile'])!="" or trim($earr[$i3]['fld_examStudyGuidedemoFile'])!="" or trim($earr[$i3]['fld_examTestEnginedemoFile'])!="" or trim($earr[$i3]['fld_examAudioGuidedemoFile'])!=""){
							  	$tab .="<a href=\"demo.php?exid=".$earr[$i3]['fld_productId']."\"><img src='images/demo1.png' border='0' /></a>";
							}
							$tab .='</form></div>
          </div>';       
      }
  }

		$tab .='<div class="pclass">'.$templateTopDesc.'</div>
      <div>      	
'.$templateBottomDesc.'
      </div>
	  <form class="formclass" name="frm_tellAfirend" method=POST action="emailAction.php?action=tellafriend" onsubmit="return Tellchk();">
						<input type="hidden" name="hdnTellAFriend" value="true">
						<input type="hidden" name="hdnPage" value="'.$_SERVER['PHP_SELF'].'">
	<div class="topMargn" style="float:right;">
        <div class="dicVocher" align="right">Recomenned to a Friend :<br /><input name="" type="text" value="Friend Email Address"  onfocus="blank(this)" onblur="unblank(this)" /> 
        <input type="image" src="images/submit.png" width="95" height="26" align="absmiddle" /></div></form>
        </div>';      	
      $tab .='</div>';
	$tab .='</div>
</div>
<div class="bodyContanerbotom"></div>
</div>

<div class="footerInner">
     <div class="newscontaner">
      <h4>What\'s in TroyTec</h4>
      <ul class="footerList">
                <li>Secure Site</li>
       <li> 100% Instant Download</li>
        <li>Providing Certifications Exams since 1997</li>
       <li> 24/7 Support</li>
        <li>Industry Leader</li>
      </ul>
    </div>
    
    <div class="newscontaner">
      <h4>Popular Products</h4>
      <ul class="footerList">
        <li>Cisco</li>
<li>Apple</li>
<li>Checkpoint</li>
<li>Avaya</li>
<li>CompTIA</li>
<li>ECCouncil</li>

      </ul>
    </div>
    
    <div class="newscontaner">
      <h4>Popular Exams</h4>
      <ul class="footerList">
        <li>9L0-621</li>
<li>MB7-840</li>
<li>640-803</li>
<li>JN0-101</li>
<li>JN0-643</li>
<li>650-473</li>

      </ul>
    </div>
    <div class="footrRight"></div>
     </div>
     <div class="footerLinks">
     TestKiller Copyright 2012 All Rights Reserved. The Registered TestKiller Trademark Is Used Exclusively Under Licence Agreement   
     </div>
</div>
</div>
</body></html>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7389997-2");
pageTracker._trackPageview();
} catch(err) {}</script>';
	
	
	$f = fopen(FILE_ROOT.$filename, "w");
	$r = fwrite($f, $tab);
	fclose($f);
	}
}


function publish_subcat_pages($id)
{

	global $dbh2, $ObjGen;

	$rs=$dbh2->Query("select * from ".TB_CATEGORY." where fld_categoryId='".$id."'");
	$exam_row=$dbh2->FetchRow($rs);
	$this->publish_cat_pages($exam_row['fld_parentId']);
	$arrVars=Array(

		"exam_name" =>$exam_row[fld_categoryName],
		"exam_code" =>$exam_row[fld_categoryName]

		);

	$pId=$ObjGen->getVal(TB_CATEGORY,"fld_categoryId",$id,"fld_parentId");
	$catName=$ObjGen->getVal(TB_CATEGORY,"fld_categoryId",$pId,"fld_categoryName");
	$rs_template=$dbh2->Query("select * from ".TB_STEMPLATES." ORDER BY is_main DESC");
	$arrTemplates_data=Array();
	while($template_row=$dbh2->FetchRow($rs_template))
	{
		$arrTemplates_data[]=$template_row;
	}

	for($i=0;$i<count($arrTemplates_data);$i++)
	{
		if($arrTemplates_data[$i]['fld_templateId']==$id)
		{
			$template_row[]=$arrTemplates_data[$i];
			$template_row[]=$arrTemplates_data[$i+1];
		}
	}

	/*
	$rs_template=$dbh2->Query("select * from ".TB_CTEMPLATES." ORDER BY is_main DESC");
	$arrTemplates_data=Array();
	while($template_row=$dbh2->FetchRow($rs_template))
	{
		$arrTemplates_data[]=$template_row;
	}
	*/
	for($tp=0;$tp<count($arrTemplates_data);$tp++)
	{
		$templateShortDesc="";
		$templateTopDesc=$arrTemplates_data[$tp]['fld_templateTopDesc'];
		$templateBottomDesc=$arrTemplates_data[$tp]['fld_templateBottomDesc'];
		$templateTitle=stripslashes($arrTemplates_data[$tp]['fld_templatePageTitle']);
		$templateKeywords=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaKeywords']);
		$templateDesc=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaDesc']);

		foreach($arrVars as $key=>$val)
		{
			$templateShortDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateShortDesc);
			$templateTopDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTopDesc);
			$templateBottomDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateBottomDesc);
			$templateTitle=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTitle);
			$templateKeywords=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateKeywords);
			$templateDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateDesc);
		}
		$key='';
		$val='';
		if($arrTemplates_data[$tp][is_main]==1)
		{
			$filename=$ObjGen->replacespace($exam_row[fld_categoryName]).".html";
		}
		else
		{
			$filename=$ObjGen->replacespace($exam_row[fld_categoryName])."_".$arrTemplates_data[$tp][fld_templateLink];
		}

		if($arrTemplates_data[$tp+1][is_main]==1)
		{
			$previousTemplateUrl=$exam_row[fld_categoryName]."_".$filename;
		}
		else
		{
			$previousTemplateUrl=$exam_row[fld_categoryName]."_".$arrTemplates_data[$tp+1][fld_templateLink];
		}






		$earr=Array();

		$rs1=$dbh2->Query("select * from ".TB_EXAMS." where fld_categoryIdNo=' ".$id."' order by fld_examCode ASC");




		while($row=mysql_fetch_array($rs1))
		$earr[]=$row;



		//$earr=array_unique($earr);
		$rs3=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId=0 order by fld_categoryName ASC");
		$larr=Array();

		while($row=mysql_fetch_array($rs3))
		$larr[]=$row;






		$tab ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<meta http-equiv="Content-Language" content="en-us" />
<meta name="GENERATOR" content="Microsoft FrontPage 5.0" />
<meta name="Author" content="'.stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaAuthor']).'" />
<meta name="Keywords" content="'.$templateKeywords.'" />
<meta name="Description" content="'.$templateDesc.'" />
<title>'.$templateTitle.'</title>
<link href="css/mainSyler.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

              var _gaq = _gaq || [];
              _gaq.push(["_setAccount", "UA-7389997-8"]);
              _gaq.push(["_trackPageview"]);

  (function() {
    var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
    ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
  })();


function blank(a){
	if(a.value == a.defaultValue) a.value = "";
}
function unblank(a){
	if(a.value == "") a.value = a.defaultValue;
}
</script>

<script type="text/javascript">
<!--
function chk()
{
	if(!validateTEmail(document.frm_signup.email_signup_qestions.value))
	{
		alert(\'Please enter a valid email address.\');
		document.frm_signup.email_signup_qestions.focus();
		return false;
	}
}
function validateTEmail( strValue) {
var objRegExp  = /(^[a-z0-9A-Z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)([.][a-z]{3})$)|(^[0-9A-Za-z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)(\.[a-z]{3})(\.[a-z]{2})*$)/i;
  return objRegExp.test(strValue);
}

function Tellchk()
{
	if(!validateTEmail(document.frm_tellAfirend.txtFriendEmail.value)){
		alert(\'Please enter a valid email address.\');
		document.frm_tellAfirend.txtFriendEmail.focus();
		return false;
	}
	if(!validateTEmail(document.frm_tellAfirend.txtYourEmail.value)){
		alert(\'Please enter a valid email address.\');
		document.frm_tellAfirend.txtYourEmail.focus();
		return false;
	}
}
//-->
</script>
</script>
</head>
<body>';
$tab .='<div class="mainContaner">
<div class="headerContaner">
<div class="logoHolder">
      <h1><a href="<?php echo LINK_PATH;?>#"></a></h1>
    </div>
    <div class="ChatHolder"><!-- BEGIN ProvideSupport.com Graphics Chat Button Code -->
<div id="cijMWT" style="z-index:100;position:absolute"></div><div id="scjMWT" style="display:inline"></div><div id="sdjMWT" style="display:none"></div><script type="text/javascript">var sejMWT=document.createElement("script");sejMWT.type="text/javascript";var sejMWTs=(location.protocol.indexOf("https")==0?"https":"http")+"://image.providesupport.com/js/nextagetech/safe-standard.js?ps_h=jMWT&ps_t="+new Date().getTime();setTimeout("sejMWT.src=sejMWTs;document.getElementById(\'sdjMWT\').appendChild(sejMWT)",1)</script><noscript><div style="display:inline"><a href="<?php echo LINK_PATH;?>http://www.providesupport.com?messenger=nextagetech">Chat Support</a></div></noscript>
<!-- END ProvideSupport.com Graphics Chat Button Code --></div>
    <div class="headerRight">
    <input name="" type="image" src="images/registerBtn.png" border="0"  align="right" class="regBtn" onclick="javascript:window.location=\'register.php\';"><br />
    <div class="topmenu">
        <div class="cart"><strong><a href="<?php echo LINK_PATH;?>'.DR_ROOT.'cart.php">Shopping Cart</a></strong></div>
        
      </div>
    </div>
</div>

<div class="bodyContaner">
<div class="bodyContanerTop"></div>
<div class="bodyInner">

<div class="menuContaner">
<div class="navouter">
<div id="navcontainer">
        <ul id="navlist">
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'index.php">Home</a></li>
          <li id="active"><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'all-categories.php">Exams</a></li>
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'licensing.php">Corporate Licensing</a></li>     
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'guarantee.php">Guarantee</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'affiliates.php">Affiliates</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'faq.php">FAQs</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'aboutus.php">About Us</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'contact.php">Contact Us</a></li>
        </ul>
      </div>
</div>
<div class="serchCont">
<form name="search_form" method="post" action="'. DR_ROOT.'exam.php"><input type="text" class="searchFIld" value="Search" name="search_keyword" onfocus="blank(this)" onblur="unblank(this)"> 
<a href="javascript:void(0);" onclick="document.search_form.submit();"><img src="<?php echo LINK_PATH;?>images/search.jpg" border="0" align="top" /></a></form></div>
</div>
<div class="bodyData">';
$tab .='<div class="leftContaner"><div class="leftHead">
    <h3>Our Vendors </h3>
  </div>
  <div id="button">
    <ul>';
    $rs=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId='0' order by fld_categoryName asc");
    $stpos = 0;
	while($row=$dbh2->FetchRow($rs)){
		$tab .='<li><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($row['fld_categoryName']).FILES_EXT.'.html">'. $row[fld_categoryName] .'</a></li>';
	}

    $tab .='</ul>
  </div>
</div>';
    $tab .='<div class="rightContaner"> 
     <p>'.trim($exam_row[fld_categoryName]).' Exam by Certmagic</p>';
	  
	  $rspk=$dbh2->Query("select p.fld_PackId, p.fld_PackCode, p.fld_PackName, p.fld_PackFee, p.fld_PackEdition from ".TB_PACKAGE." p INNER JOIN ".TB_PACK_CATEGORY." pc on p.fld_PackId=pc.fld_PackId where pc.fld_categoryId='".$id."' order by p.fld_PackCode ASC");
		if(mysql_num_rows($rspk)) {
			$catnameap=true;
			while($rowpk=mysql_fetch_array($rspk)) {
				$tab .='<div class="cateMan">
            			<div class="cateManList">';
						$tab .='<ul>
                <li><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($rowpk['fld_PackCode']).FILES_EXT.".html".'">'.$rowpk['fld_PackCode'].'</a></li>
                <li><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($rowpk['fld_PackCode']).FILES_EXT.".html".'">'.$rowpk['fld_PackName'].'</a></li>
              </ul>
            </div>
                          <div style="clear:both;"></div>
                          <div class="cateManTxt">'.$rowpk['fld_PackEdition'].'</div>
            <h1 class="valBtm"><form method=post action="'.DR_ROOT."shopCart.php".'">
                        	<input type="hidden" name="packId" value="'.$rowpk['fld_PackId'].'">
							<input type="hidden" name="type" value="bundle">
                            <input type="hidden" name="catId" value="'.$id.'">
                            <input type="hidden" name="quantity" value="1">$'.$rowpk['fld_PackFee'].' 
                            <input type="hidden" name="action" value="add"><input type="image" src="images/add_cart.png" name="buy_now" value="Buy now" width="132" height="36"/></form></h1>
            
          </div>';
		  $packcnt++;
			}
		}
	  
	  
      for($i3=0;$i3<count($earr);$i3++){
		  $tab .='<div class="cateHead">
            <h4><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($earr[$i3]['fld_examCode']).FILES_EXT.".html".'">'.$earr[$i3]['fld_examCode'].'</a> <a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($earr[$i3]['fld_examCode']).FILES_EXT.".html".'">'.$earr[$i3]['fld_examTitle'].'</a></h4>
          </div>
          <div class="catAll">
          <div style="float:left; width:300px;">'.$earr[$i3]['fld_examShortDesc'].'</div>
          <div style="float:left;  padding:0 30px;"><strong>'.$ObjGen->MySqltoTextual($earr[$i3]['fld_examDate']).'</strong>
		  <p align="center">$'.$earr[$i3]['fld_examFee'].'</p></div>
          <div style="float:right;"><form method=post action="'.DR_ROOT."shopCart.php".'">
                        	<input type="hidden" name="examId" value="'.$earr[$i3]['fld_productId'].'">
                            <input type="hidden" name="catId" value="'.$id.'">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="action" value="add"><input type="image" src="images/add_cart.png" name="buy_now" value="Buy now" width="132" height="36"/> ';
							if(trim($earr[$i3]['fld_examQAdemoFile'])!="" or trim($earr[$i3]['fld_examStudyGuidedemoFile'])!="" or trim($earr[$i3]['fld_examTestEnginedemoFile'])!="" or trim($earr[$i3]['fld_examAudioGuidedemoFile'])!=""){
							  	$tab .="<a href=\"demo.php?exid=".$earr[$i3]['fld_productId']."\"><img src='images/demo1.png' border='0' /></a>";
							}
							$tab .='</form></div>
          </div>';
      }
		$tab .='<div>'.$templateTopDesc.'</div>

      <div>      	
'.$templateBottomDesc.'
      </div>';

	  
      $tab .='<form class="formclass" name="frm_tellAfirend" method=POST action="emailAction.php?action=tellafriend" onsubmit="return Tellchk();">
						<input type="hidden" name="hdnTellAFriend" value="true">
						<input type="hidden" name="hdnPage" value="'.$_SERVER['PHP_SELF'].'">
	<div class="topMargn" style="float:right;">
        <div class="dicVocher" align="right">Recomenned to a Friend :<br /><input name="" type="text" value="Friend Email Address" /> 
        <input type="image" src="images/submit.png" width="95" height="26" align="absmiddle" /></div></form></div>';
$tab .='</div>
</div>
<div class="bodyContanerbotom"></div>
</div>

<div class="footerInner">
     <div class="newscontaner">
      <h4>What\'s in TroyTec</h4>
      <ul class="footerList">
                <li>Secure Site</li>
       <li> 100% Instant Download</li>
        <li>Providing Certifications Exams since 1997</li>
       <li> 24/7 Support</li>
        <li>Industry Leader</li>
      </ul>
    </div>
    
    <div class="newscontaner">
      <h4>Popular Products</h4>
      <ul class="footerList">
        <li>Cisco</li>
<li>Apple</li>
<li>Checkpoint</li>
<li>Avaya</li>
<li>CompTIA</li>
<li>ECCouncil</li>

      </ul>
    </div>
    
    <div class="newscontaner">
      <h4>Popular Exams</h4>
      <ul class="footerList">
        <li>9L0-621</li>
<li>MB7-840</li>
<li>640-803</li>
<li>JN0-101</li>
<li>JN0-643</li>
<li>650-473</li>

      </ul>
    </div>
    <div class="footrRight"></div>
     </div>
     <div class="footerLinks">
     TestKiller Copyright 2012 All Rights Reserved. The Registered TestKiller Trademark Is Used Exclusively Under Licence Agreement   
     </div>
</div>
</div>
</body></html>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7389997-2");
pageTracker._trackPageview();
} catch(err) {}</script>';


		$f = fopen(FILE_ROOT.$filename, "w");

		$r = fwrite($f, $tab);

		fclose($f);
	}

}
	function generate_pack_pages()
	{
	global $dbh2, $ObjGen;
$rs_template=$dbh2->Query("select * from ".TB_TEMPLATES." ORDER BY is_main DESC");
$arrTemplates_data=Array();
while($template_row=$dbh2->FetchRow($rs_template)){
	$arrTemplates_data[]=$template_row;
}

$rsj=$dbh2->Query("select pc.fld_packId, pc.fld_categoryId, p.fld_PackName, p.fld_PackCode, p.fld_PackFee, p.fld_PackEdition from ".TB_PACK_CATEGORY." pc inner join ".TB_PACKAGE." p on pc.fld_packId=p.fld_packId order by pc.fld_packId asc");
$larr_exam=Array();
while($exam_row=$dbh2->FetchRow($rsj)) $larr_exam[]=$exam_row;

$pq=0;
for($im=0;$im<sizeof($larr_exam);$im++){
	$pq++;
	$rsq=$dbh2->Query("select * from ".TB_CATEGORY." where fld_categoryId='".$larr_exam[$im]['fld_categoryId']."'");
	$exam_rowq=$dbh2->FetchRow($rsq);

	$pId=$larr_exam[$im]['fld_categoryId'];
	if(empty($currentPID))
		$currentPID = $pId;		

	$subcatId=$larr_exam[$im]['fld_categoryId'];
	$subcatName=$exam_rowq['fld_categoryName'];
	$pId=$exam_rowq['fld_parentId'];
	$rsm=$dbh2->Query("select * from ".TB_CATEGORY." where fld_categoryId='".$pId."'");
	$exam_rowqm=$dbh2->FetchRow($rsm);
	$catName=$exam_rowqm['fld_categoryName'];


	$arrVars=Array(
		"exam_name" =>$larr_exam[$im]['fld_PackName'],
		"exam_code" =>$larr_exam[$im]['fld_PackCode']
		);

	/* new boxes  */
	if($currentPID != $pId)	{
		unset($boxes1);
		$i = 0;	unset($catIDs);
		$catIDs = array();
		$rsj_child=$dbh2->Query("select `fld_categoryId` from ".TB_CATEGORY." where fld_parentId='".$pId."' ORDER BY fld_addedOn desc");
		while($child=$dbh2->FetchRow($rsj_child)){	
			array_push($catIDs, $child['fld_categoryId']);
		}
		$count = 0; $end = 0;
		$boxarr=array();
		foreach($catIDs as $value){		
			if($count == "150"){
				unset($catIDs);				
				continue;
			}
						
			$rsj_latest=$dbh2->Query("select `fld_examCode` from ".TB_EXAMS." where fld_categoryIdNo='".$value."' ORDER BY fld_addedOn desc LIMIT 150");
			while($boxes=$dbh2->FetchRow($rsj_latest)){
				$boxarr[]=$boxes['fld_examCode'];
				if($count == 150){
					unset($catIDs);				
					continue;
				}			
				$rc++;
				$count++;			
			}	
		}

		$i = 0;	
		unset($boxes2);		
		$rsj_latest=$dbh2->Query("select `fld_examCode` from ".TB_EXAMS." where `fld_featured` = '1' ORDER BY fld_addedOn desc");
		$totrec=mysql_num_rows($rsj_latest);
		$percolumn=ceil($totrec/3);
		while($boxes=$dbh2->FetchRow($rsj_latest)){
			if($i == $percolumn){ 	
				$boxes2 .='<ul>';				
			}
			
			$boxes2 .='<li><a href="<?php echo LINK_PATH;?>'.$ObjGen->replacespace(trim($boxes['fld_examCode'])).FILES_EXT.'.html">'.$boxes['fld_examCode'].'</a></li>';
			if($i >= $percolumn-1){ 
				$boxes2 .='</ul><ul>';
				$i = 0;				
			} else {
				$i++;	
			}
			$rc++;
		}
	
		$i = 0;	unset($boxes3);		
		$rsj_latest=$dbh2->Query("select `fld_examCode` from ".TB_EXAMS." ORDER BY fld_addedOn desc LIMIT 200");
		$totrec=mysql_num_rows($rsj_latest);
		$percolumn=ceil($totrec/3);
		while($boxes=$dbh2->FetchRow($rsj_latest)){		
			if($i == $percolumn)	{ 	
				$boxes3 .='<ul>';				
			}
			
			$boxes3 .='<li><a href="<?php echo LINK_PATH;?>'.$ObjGen->replacespace(trim($boxes['fld_examCode'])).FILES_EXT.'.html">'.$boxes['fld_examCode'].'</a></li>';
			if($i >= $percolumn-1){ 
				$boxes3 .=
					'</ul><ul>';			
				$i = 0;				
			} else {
				$i++;	
			}
			$rc++;
		}	
	}	
	$totrec=count($boxarr);
	$percolumn=round($totrec/3);
	$i=0;

	foreach($boxarr as $boxval) {
		if($i == $percolumn){ 	
			$boxes1 .='<ul>';				
		}
		$boxes1 .='<li><a href="<?php echo LINK_PATH;?>'.trim($boxval).FILES_EXT.'.html">'.$boxval.'</a></li>';			
		if($i >= $percolumn-1){ 
			$boxes1 .='</ul><ul>';			
			$i = 0;				
		} else {
			$i++;	
		}
	}
	
	
	
	$currentPID = $pId;

	for($tp=0;$tp<count($arrTemplates_data);$tp++)
	{

		$templateShortDesc=$larr_exam[$im]['fld_examShortDesc'];
		$templateTopDesc=$arrTemplates_data[$tp]['fld_templateTopDesc'];
		$templateBottomDesc=$arrTemplates_data[$tp]['fld_templateBottomDesc'];
		$templateTitle=stripslashes($arrTemplates_data[$tp]['fld_templatePageTitle']);
		$templateKeywords=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaKeywords']);
		$templateDesc=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaDesc']);

		foreach($arrVars as $key=>$val)
		{
			$templateShortDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateShortDesc);
			$templateTopDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTopDesc);
			$templateBottomDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateBottomDesc);
			$templateTitle=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTitle);
			$templateKeywords=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateKeywords);
			$templateDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateDesc);
		}
		$key='';
		$val='';
		if($arrTemplates_data[$tp][is_main]==1)
		{
			$filename=$ObjGen->replacespace($larr_exam[$im][fld_PackCode]).FILES_EXT.".html";
		}
		else
		{
			$filename=$ObjGen->replacespace($larr_exam[$im][fld_PackCode])."_".$arrTemplates_data[$tp][fld_templateLink];
		}

		if($arrTemplates_data[$tp+1][is_main]==1)
		{

			$previousTemplateUrl=$larr_exam[$im][fld_PackCode]."_".$filename;
		}
		else
		{
			$previousTemplateUrl=$larr_exam[$im][fld_PackCode]."_".$arrTemplates_data[$tp+1][fld_templateLink];
		}

		//$templateTopDesc=$template_row[0][fld_templateTopDesc];
		//$templateBottomDesc=$template_row[0][fld_templateBottomDesc];

		$arrVars=Array();
		$arrVars['exam_name']=$larr_exam[$im][fld_PackName];
		$arrVars['exam_code']=$larr_exam[$im][fld_PackCode];

$tab ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<meta http-equiv="Content-Language" content="en-us" />
<meta name="GENERATOR" content="Microsoft FrontPage 5.0" />
<meta name="Author" content="'.stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaAuthor']).'" />
<meta name="Keywords" content="'.$templateKeywords.'" />
<meta name="Description" content="'.$templateDesc.'" />
<title>'.$templateTitle.'</title>
<link href="css/mainSyler.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

              var _gaq = _gaq || [];
              _gaq.push(["_setAccount", "UA-7389997-8"]);
              _gaq.push(["_trackPageview"]);

  (function() {
    var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
    ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
  })();


function blank(a){
if(a.value == a.defaultValue) a.value = "";
}
function unblank(a){
if(a.value == "") a.value = a.defaultValue;
}
</script>

<script type="text/javascript">
<!--
function chk()
{
	if(!validateTEmail(document.frm_signup.email_signup_qestions.value))
	{
		alert(\'Please enter a valid email address.\');
		document.frm_signup.email_signup_qestions.focus();
		return false;
	}
}
function validateTEmail( strValue) {
var objRegExp  = /(^[a-z0-9A-Z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)([.][a-z]{3})$)|(^[0-9A-Za-z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)(\.[a-z]{3})(\.[a-z]{2})*$)/i;
  return objRegExp.test(strValue);
}

function Tellchk()
{
	if(!validateTEmail(document.frm_tellAfirend.txtFriendEmail.value)){
		alert(\'Please enter a valid email address.\');
		document.frm_tellAfirend.txtFriendEmail.focus();
		return false;
	}
	if(!validateTEmail(document.frm_tellAfirend.txtYourEmail.value)){
		alert(\'Please enter a valid email address.\');
		document.frm_tellAfirend.txtYourEmail.focus();
		return false;
	}
}
//-->
</script>
</head>
<body>';
$tab .='<div class="mainContaner">
<div class="headerContaner">
<div class="logoHolder">
      <h1><a href="<?php echo LINK_PATH;?>#"></a></h1>
    </div>
    <div class="ChatHolder"><!-- BEGIN ProvideSupport.com Graphics Chat Button Code -->
<div id="cijMWT" style="z-index:100;position:absolute"></div><div id="scjMWT" style="display:inline"></div><div id="sdjMWT" style="display:none"></div><script type="text/javascript">var sejMWT=document.createElement("script");sejMWT.type="text/javascript";var sejMWTs=(location.protocol.indexOf("https")==0?"https":"http")+"://image.providesupport.com/js/nextagetech/safe-standard.js?ps_h=jMWT&ps_t="+new Date().getTime();setTimeout("sejMWT.src=sejMWTs;document.getElementById(\'sdjMWT\').appendChild(sejMWT)",1)</script><noscript><div style="display:inline"><a href="<?php echo LINK_PATH;?>http://www.providesupport.com?messenger=nextagetech">Chat Support</a></div></noscript>
<!-- END ProvideSupport.com Graphics Chat Button Code --></div>
    <div class="headerRight">
    <input name="" type="image" src="images/registerBtn.png" border="0"  align="right" class="regBtn" onclick="javascript:window.location=\'register.php\';"><br />
    <div class="topmenu">
	<div class="cart"><strong><a href="<?php echo LINK_PATH;?>'.DR_ROOT.'cart.php">Shopping Cart</a></strong></div>
        
      </div>
    </div>
</div>

<div class="bodyContaner">
<div class="bodyContanerTop"></div>
<div class="bodyInner">

<div class="menuContaner">
<div class="navouter">
<div id="navcontainer">
        <ul id="navlist">
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'index.php">Home</a></li>
          <li id="active"><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'all-categories.php">Exams</a></li>
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'licensing.php">Corporate Licensing</a></li>     
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'guarantee.php">Guarantee</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'affiliates.php">Affiliates</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'faq.php">FAQs</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'aboutus.php">About Us</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'contact.php">Contact Us</a></li>
        </ul>
      </div>
</div>
<div class="serchCont">
<form name="search_form" method="post" action="'. DR_ROOT.'exam.php"><input type="text" class="searchFIld" value="Search" name="search_keyword" onfocus="blank(this)" onblur="unblank(this)"> 
<a href="javascript:void(0);" onclick="document.search_form.submit();"><img src="<?php echo LINK_PATH;?>images/search.jpg" border="0" align="top" /></a></form></div>
</div>
<div class="bodyData">';
$tab .='<div class="leftContaner"><div class="leftHead">
    <h3>Our Vendors </h3>
  </div>
  <div id="button">
    <ul>';
    $rs=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId='0' order by fld_categoryName asc");
    $stpos = 0;
	while($row=$dbh2->FetchRow($rs)){
		$tab .='<li><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($row['fld_categoryName']).FILES_EXT.'.html">'. $row[fld_categoryName] .'</a></li>';
	}

    $tab .='</ul>
  </div>
</div>';
    $tab .='<div class="rightContaner">';

$tab .='<p>'.$larr_exam[$im]['fld_PackName'].'</p>
		<form name="examform'.$larr_exam[$im]['fld_packIdNo'].'" method="post" action="'.DR_ROOT."shopCart.php".'">
		<input type="hidden" name="packId" value="'.$larr_exam[$im]['fld_packIdNo'].'">
		<input type="hidden" name="type" value="bundle">
		<input type="hidden" name="catId" value="'.$larr_exam[$im]['fld_categoryIdNo'].'">
		<input type="hidden" name="quantity" value="1">
		<input type="hidden" name="action" value="add">
 <div class="valuPackMan">
    <div class="valuPacList"> <img src="<?php echo LINK_PATH;?>images/book.png" />
      <h1>'.substr($larr_exam[$im]['fld_PackName'],0,25).'</h1>
      <ul>';
	  $rspexam=$dbh2->Query("select e.fld_productId, e.fld_examTitle, e.fld_examFee, e.fld_examShortDesc from ".TB_PACKAGE_EXAMS." pe inner join ".TB_EXAMS." e on pe.fld_productIdNo=e.fld_productId where pe.fld_packIdNo='".$larr_exam[$im]['fld_packId']."' order by pe.fld_productIdNo asc");
	  $totexamfee=0;
	  while($rowpexam=mysql_fetch_array($rspexam)) {
        $tab .='<li><strong>'.substr($rowpexam['fld_examTitle'],0,38).'</strong><br />
          '.substr($rowpexam['fld_examShortDesc'],0,40).'
          <p>$'.$rowpexam['fld_examFee'].'</p>
        </li>';
		$totexamfee +=$rowpexam['fld_examFee'];
	  }
      $tab .='</ul>';
		$feedifference=$totexamfee-$larr_exam[$im]['fld_PackFee'];
$tab .='</div>
    <p style="margin-left:30px; width:180px;">Save $'.number_format($feedifference,2).' Now</p>
    <div align="center">';
	$tab .='<input type="image" src="images/add_cart.png" /></div>
  </div>
 </form>';

 
 $tab .='<div>'.$templateTopDesc.'</div>
';     
$tab .='<div class="cartHead"><h4>All Featured Exams</h4></div>
<div class="catAll"><ul>'.$boxes1.'</ul></div>

<div class="cartHead"><h4>All Latest Exams</h4></div>
<div class="catAll"><ul>'.$boxes3.'</ul></div>
<form class="formclass" name="frm_tellAfirend" method=POST action="emailAction.php?action=tellafriend" onsubmit="return Tellchk();">
						<input type="hidden" name="hdnTellAFriend" value="true">
						<input type="hidden" name="hdnPage" value="'.$_SERVER['PHP_SELF'].'">
	<div class="topMargn" style="float:right;">
        <div class="dicVocher" align="right">Recomenned to a Friend :<br /><input name="" type="text" value="Friend Email Address"   onfocus="blank(this)" onblur="unblank(this)" /> 
        <input type="image" src="images/submit.png" width="95" height="26" align="absmiddle" /></div></form></div></div>';

$tab .='</div>
</div>
<div class="bodyContanerbotom"></div>
</div>

<div class="footerInner">
     <div class="newscontaner">
      <h4>What\'s in TroyTec</h4>
      <ul class="footerList">
                <li>Secure Site</li>
       <li> 100% Instant Download</li>
        <li>Providing Certifications Exams since 1997</li>
       <li> 24/7 Support</li>
        <li>Industry Leader</li>
      </ul>
    </div>
    
    <div class="newscontaner">
      <h4>Popular Products</h4>
      <ul class="footerList">
        <li>Cisco</li>
<li>Apple</li>
<li>Checkpoint</li>
<li>Avaya</li>
<li>CompTIA</li>
<li>ECCouncil</li>

      </ul>
    </div>
    
    <div class="newscontaner">
      <h4>Popular Exams</h4>
      <ul class="footerList">
        <li>9L0-621</li>
<li>MB7-840</li>
<li>640-803</li>
<li>JN0-101</li>
<li>JN0-643</li>
<li>650-473</li>

      </ul>
    </div>
    <div class="footrRight"></div>
     </div>
     <div class="footerLinks">
     TestKiller Copyright 2012 All Rights Reserved. The Registered TestKiller Trademark Is Used Exclusively Under Licence Agreement   
     </div>
</div>
</div>
</body></html>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7389997-2");
pageTracker._trackPageview();
} catch(err) {}</script>';

$f = @fopen(FILE_ROOT.$filename, "w");
$r = @fwrite($f, $tab);
fclose($f);
}

}

return $pq;

}
	function generate_exam_pages()
	{
		global $dbh2, $ObjGen;
$rs3=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId=0 order by fld_categoryName ASC");
$larr=Array();
while($rowk=mysql_fetch_array($rs3))
$larr[]=$rowk;
$rs_template=$dbh2->Query("select * from ".TB_TEMPLATES." ORDER BY is_main DESC");
$arrTemplates_data=Array();
while($template_row=$dbh2->FetchRow($rs_template)){
	$arrTemplates_data[]=$template_row;
}
$rst=$dbh2->Query("select * from ".TB_TESTIMONIAL." order by fld_tId desc");
$arratesti=Array();
while($rowt=$dbh2->FetchRow($rst))$arratesti[]=$rowt;

$rsj=$dbh2->Query("select * from ".TB_EXAMS." order by fld_categoryIdNo DESC");
$larr_exam=Array();

while($exam_row=$dbh2->FetchRow($rsj)){

	$larr_exam[]=$exam_row;
}

$pq=0;
for($im=0;$im<sizeof($larr_exam);$im++){
$rst=$dbh2->Query("select * from ".TB_TESTIMONIAL." where fld_type='"."exam"."' and fld_rid='".$larr_exam[$im][fld_productId]."'");
$arratesti=Array();
while($rowt=$dbh2->FetchRow($rst))
$arratesti[]=$rowt;
		$pq++;

	$rsq=$dbh2->Query("select * from ".TB_CATEGORY." where fld_categoryId='".$larr_exam[$im]['fld_categoryIdNo']."'");
	$exam_rowq=$dbh2->FetchRow($rsq);

	if(empty($currentPID))
		$currentPID = $pId;		

	$subcatId=$larr_exam[$im]['fld_categoryIdNo'];
	$subcatName=$exam_rowq['fld_categoryName'];
	$pId=$exam_rowq['fld_parentId'];
	$rsm=$dbh2->Query("select * from ".TB_CATEGORY." where fld_categoryId='".$pId."'");
	$exam_rowqm=$dbh2->FetchRow($rsm);
	$catName=$exam_rowqm['fld_categoryName'];


	$arrVars=Array(

		"exam_name" =>$larr_exam[$im]['fld_examTitle'],
		"exam_code" =>$larr_exam[$im]['fld_examCode']

		);

	/* new boxes  */
	if($currentPID != $pId)	{
		unset($boxes1);
		$i = 0;	unset($catIDs);
		$catIDs = array();
		$rsj_child=$dbh2->Query("select `fld_categoryId` from ".TB_CATEGORY." where fld_parentId='".$pId."' ORDER BY fld_addedOn desc");
		while($child=$dbh2->FetchRow($rsj_child)){	
			array_push($catIDs, $child['fld_categoryId']);
		}
		$count = 0; $end = 0;
		$boxarr=array();
		foreach($catIDs as $value){		
			if($count == "150"){
				unset($catIDs);				
				continue;
			}
						
			$rsj_latest=$dbh2->Query("select `fld_examCode` from ".TB_EXAMS." where fld_categoryIdNo='".$value."' ORDER BY fld_addedOn desc LIMIT 150");
			while($boxes=$dbh2->FetchRow($rsj_latest)){
				$boxarr[]=$boxes['fld_examCode'];
				if($count == 150){
					unset($catIDs);				
					continue;
				}			
				$rc++;
				$count++;			
			}	
		}

		$i = 0;	
		unset($boxes2);		
		$rsj_latest=$dbh2->Query("select `fld_examCode` from ".TB_EXAMS." where `fld_featured` = '1' ORDER BY fld_addedOn desc");
		$totrec=mysql_num_rows($rsj_latest);
		$percolumn=ceil($totrec/3);
		while($boxes=$dbh2->FetchRow($rsj_latest)){
			if($i == $percolumn){ 	
				$boxes2 .='<ul>';				
			}
			
			$boxes2 .='<li><a href="<?php echo LINK_PATH;?>'.$ObjGen->replacespace(trim($boxes['fld_examCode'])).FILES_EXT.'.html">'.$boxes['fld_examCode'].'</a></li>';
			if($i >= $percolumn-1){ 
				$boxes2 .='</ul><ul>';
				$i = 0;				
			} else {
				$i++;	
			}
			$rc++;
		}
	
		$i = 0;	unset($boxes3);		
		$rsj_latest=$dbh2->Query("select `fld_examCode` from ".TB_EXAMS." ORDER BY fld_addedOn desc LIMIT 200");
		$totrec=mysql_num_rows($rsj_latest);
		$percolumn=ceil($totrec/3);
		while($boxes=$dbh2->FetchRow($rsj_latest)){		
			if($i == $percolumn)	{ 	
				$boxes3 .='<ul>';				
			}
			
			$boxes3 .='<li><a href="<?php echo LINK_PATH;?>'.$ObjGen->replacespace(trim($boxes['fld_examCode'])).FILES_EXT.'.html">'.$boxes['fld_examCode'].'</a></li>';
			if($i >= $percolumn-1){ 
				$boxes3 .=
					'</ul><ul>';			
				$i = 0;				
			} else {
				$i++;	
			}
			$rc++;
		}	
	}	
	$totrec=count($boxarr);
	$percolumn=ceil($totrec/3);
	$i=0;
	$boxes1='';
	foreach($boxarr as $boxval) {
		if($i == $percolumn){ 	
			$boxes1 .='<ul>';				
		}
		$boxes1 .='<li><a href="<?php echo LINK_PATH;?>'.trim($boxval).FILES_EXT.'.html">'.$boxval.'</a></li>';			
		if($i >= $percolumn-1){ 
			$boxes1 .='</ul><ul>';			
			$i = 0;				
		} else {
			$i++;	
		}
	}
	
	$currentPID = $pId;
	for($tp=0;$tp<count($arrTemplates_data);$tp++)
	{

		$templateShortDesc=$larr_exam[$im]['fld_examShortDesc'];
		$templateTopDesc=$arrTemplates_data[$tp]['fld_templateTopDesc'];
		$templateBottomDesc=$arrTemplates_data[$tp]['fld_templateBottomDesc'];
		$templateTitle=stripslashes($arrTemplates_data[$tp]['fld_templatePageTitle']);
		$templateKeywords=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaKeywords']);
		$templateDesc=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaDesc']);

		foreach($arrVars as $key=>$val)
		{
			$templateShortDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateShortDesc);
			$templateTopDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTopDesc);
			$templateBottomDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateBottomDesc);
			$templateTitle=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTitle);
			$templateKeywords=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateKeywords);
			$templateDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateDesc);
		}
		$key='';
		$val='';
		if($arrTemplates_data[$tp][is_main]==1)
		{
			$filename=$ObjGen->replacespace($larr_exam[$im][fld_examCode]).FILES_EXT.".html";
		}
		else
		{
			$filename=$ObjGen->replacespace($larr_exam[$im][fld_examCode])."_".$arrTemplates_data[$tp][fld_templateLink];
		}

		if($arrTemplates_data[$tp+1][is_main]==1)
		{

			$previousTemplateUrl=$larr_exam[$im][fld_examCode]."_".$filename;
		}
		else
		{
			$previousTemplateUrl=$larr_exam[$im][fld_examCode]."_".$arrTemplates_data[$tp+1][fld_templateLink];
		}

		//$templateTopDesc=$template_row[0][fld_templateTopDesc];
		//$templateBottomDesc=$template_row[0][fld_templateBottomDesc];

		$arrVars=Array();
		$arrVars['exam_name']=$larr_exam[$im][fld_examTitle];
		$arrVars['exam_code']=$larr_exam[$im][fld_examCode];


$tab ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<meta http-equiv="Content-Language" content="en-us" />
<meta name="GENERATOR" content="Microsoft FrontPage 5.0" />
<meta name="Author" content="'.stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaAuthor']).'" />
<meta name="Keywords" content="'.$templateKeywords.'" />
<meta name="Description" content="'.$templateDesc.'" />
<title>'.$templateTitle.'</title>
<link href="css/mainSyler.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

              var _gaq = _gaq || [];
              _gaq.push(["_setAccount", "UA-7389997-8"]);
              _gaq.push(["_trackPageview"]);

  (function() {
    var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
    ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
  })();

function blank(a){
if(a.value == a.defaultValue) a.value = "";
}
function unblank(a){
if(a.value == "") a.value = a.defaultValue;
}
</script>

<script type="text/javascript">
<!--
function chk()
{
	if(!validateTEmail(document.frm_signup.email_signup_qestions.value))
	{
		alert(\'Please enter a valid email address.\');
		document.frm_signup.email_signup_qestions.focus();
		return false;
	}
}
function validateTEmail( strValue) {
var objRegExp  = /(^[a-z0-9A-Z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)([.][a-z]{3})$)|(^[0-9A-Za-z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)(\.[a-z]{3})(\.[a-z]{2})*$)/i;
  return objRegExp.test(strValue);
}

function Tellchk()
{
	if(!validateTEmail(document.frm_tellAfirend.txtFriendEmail.value)){
		alert(\'Please enter a valid email address.\');
		document.frm_tellAfirend.txtFriendEmail.focus();
		return false;
	}
	if(!validateTEmail(document.frm_tellAfirend.txtYourEmail.value)){
		alert(\'Please enter a valid email address.\');
		document.frm_tellAfirend.txtYourEmail.focus();
		return false;
	}
}
//-->
</script>
</script>
</head>
<body>';
$tab .='<div class="mainContaner">
<div class="headerContaner">
<div class="logoHolder">
      <h1><a href="<?php echo LINK_PATH;?>#"></a></h1>
    </div>
    <div class="ChatHolder"><!-- BEGIN ProvideSupport.com Graphics Chat Button Code -->
<div id="cijMWT" style="z-index:100;position:absolute"></div><div id="scjMWT" style="display:inline"></div><div id="sdjMWT" style="display:none"></div><script type="text/javascript">var sejMWT=document.createElement("script");sejMWT.type="text/javascript";var sejMWTs=(location.protocol.indexOf("https")==0?"https":"http")+"://image.providesupport.com/js/nextagetech/safe-standard.js?ps_h=jMWT&ps_t="+new Date().getTime();setTimeout("sejMWT.src=sejMWTs;document.getElementById(\'sdjMWT\').appendChild(sejMWT)",1)</script><noscript><div style="display:inline"><a href="<?php echo LINK_PATH;?>http://www.providesupport.com?messenger=nextagetech">Chat Support</a></div></noscript>
<!-- END ProvideSupport.com Graphics Chat Button Code --></div>
    <div class="headerRight">
    <input name="" type="image" src="images/registerBtn.png" border="0"  align="right" class="regBtn" onclick="javascript:window.location=\'register.php\';"><br />
    <div class="topmenu">
       <div class="cart"><strong><a href="<?php echo LINK_PATH;?>'.DR_ROOT.'cart.php">Shopping Cart</a></strong></div>
        
      </div>
    </div>
</div>

<div class="bodyContaner">
<div class="bodyContanerTop"></div>
<div class="bodyInner">

<div class="menuContaner">
<div class="navouter">
<div id="navcontainer">
        <ul id="navlist">
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'index.php">Home</a></li>
          <li id="active"><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'all-categories.php">Exams</a></li>
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'licensing.php">Corporate Licensing</a></li>     
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'guarantee.php">Guarantee</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'affiliates.php">Affiliates</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'faq.php">FAQs</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'aboutus.php">About Us</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'contact.php">Contact Us</a></li>
        </ul>
      </div>
</div>
<div class="serchCont">
<form name="search_form" method="post" action="'. DR_ROOT.'exam.php"><input type="text" class="searchFIld" value="Search" name="search_keyword" onfocus="blank(this)" onblur="unblank(this)"> 
<a href="javascript:void(0);" onclick="document.search_form.submit();"><img src="<?php echo LINK_PATH;?>images/search.jpg" border="0" align="top" /></a></form></div>
</div>
<div class="bodyData">';
$tab .='<div class="leftContaner"><div class="leftHead">
    <h3>Our Vendors </h3>
  </div>
  <div id="button">
    <ul>';
    $rs=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId='0' order by fld_categoryName asc");
    $stpos = 0;
	while($row=$dbh2->FetchRow($rs)){
		$tab .='<li><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($row['fld_categoryName']).FILES_EXT.'.html">'. $row[fld_categoryName] .'</a></li>';
	}

    $tab .='</ul>
  </div>
</div>';
    $tab .='<div class="rightContaner">
	<div><a href="<?php echo LINK_PATH;?>'.$ObjGen->replacespace(trim($catName)).FILES_EXT.'.html">'.trim($catName).'</a> > <a href="<?php echo LINK_PATH;?>'.$ObjGen->replacespace(trim($subcatName)).FILES_EXT.'.html">'.trim($subcatName).'</a> > '.trim($larr_exam[$im][fld_examCode]).' Exam</div>
 <p>'.$larr_exam[$im]['fld_examTitle'].'</p>
 <form name="examform" method="post" action="'.DR_ROOT."shopCart.php".'">
		<input type="hidden" name="examId" value="'.$larr_exam[$im]['fld_productId'].'">
		<input type="hidden" name="catId" value="'.$larr_exam[$im]['fld_categoryIdNo'].'">
		<input type="hidden" name="quantity" value="1">
		<input type="hidden" name="action" value="add">
 <div class="valuPackMan">
    <div class="valuPacList"><div style="float:left;"><div><img src="<?php echo LINK_PATH;?>images/book.png" /></div><div style="padding-left:90px; font-family:Georgia;font-size:40px;">$'.$larr_exam[$im]['fld_examFee'].'</div></div>
      <h1>Product Description</h1>
	  <div><strong>Exam Number/Code : </strong> '.trim($larr_exam[$im][fld_examCode]).'</div>
	  <div>&nbsp;</div>
	  <div><strong>Exam Name : </strong> '.$larr_exam[$im]['fld_examTitle'].'</div>
	  <div>&nbsp;</div>
	  <div><strong>Release / Update Date : </strong> '.$ObjGen->MySqltoTextual($larr_exam[$im]['fld_examDate']).'</div>
	  <div>&nbsp;</div>
      <div>'.trim($larr_exam[$im]['fld_examShortDesc']).'</div>
	  <div>&nbsp;</div>
      <ul>';
		if(trim($larr_exam[$im]['fld_examQAdemoFile'])!="" or trim($larr_exam[$im]['fld_examStudyGuidedemoFile'])!="" or trim($larr_exam[$im]['fld_examTestEnginedemoFile'])!="" or trim($larr_exam[$im]['fld_examAudioGuidedemoFile'])!=""){
			$tab .='<li><strong>Free Demo</strong><br /><span style="color:#000; font-size:12px;">CertArea.com offers free demo for '.trim($larr_exam[$im]['fld_examCode']).' exam ('.$larr_exam[$im]['fld_examTitle'].'). You can check out the interface, question quality and usability of our practice exams before you decide to buy it.</span>';
		}
      $tab .='</ul>';

$tab .='</div>
    <p class="valBtm">&nbsp;</p>
    <div style="float:left;" align="center">';
	if(trim($larr_exam[$im]['fld_examQAdemoFile'])!="" or trim($larr_exam[$im]['fld_examStudyGuidedemoFile'])!="" or trim($larr_exam[$im]['fld_examTestEnginedemoFile'])!="" or trim($larr_exam[$im]['fld_examAudioGuidedemoFile'])!=""){
	$tab .="<a href=\"demo.php?exid=".$larr_exam[$im]['fld_productId']."\"><img src=\"images/demo.png\" border=\"0\"></a>&nbsp;";
}
	$tab .='<input type="image" src="images/add_cart.png" /></div>
  </div>
 </form>';
  $rspack=$dbh2->Query("select pe.fld_packIdNo, p.fld_PackCode, p.fld_PackName, p.fld_PackFee, p.fld_PackEdition from ".TB_PACKAGE_EXAMS." pe inner join ".TB_PACKAGE." p on pe.fld_packIdNo=p.fld_PackId where pe.fld_productIdNo='".$larr_exam[$im]['fld_productId']."' order by pe.fld_packIdNo asc");
  if(mysql_num_rows($rspack)) {
	 while($rowpack=mysql_fetch_array($rspack)) {
		 $rsparent=$dbh2->Query("select fld_parentId from ".TB_CATEGORY." where fld_categoryId='".$larr_exam[$im]['fld_categoryIdNo']."'");
		 $rowparent=mysql_fetch_assoc($rsparent);
		 if($rowparent['fld_parentId']=='0') {
		 $rspcat=$dbh2->Query("select * from ".TB_PACK_CATEGORY." where fld_packId='".$rowpack['fld_packIdNo']."' and fld_categoryId<>'".$larr_exam[$im]['fld_categoryIdNo']."'");
		 } else {
			 $rspcat=$dbh2->Query("select * from ".TB_PACK_CATEGORY." where fld_packId='".$rowpack['fld_packIdNo']."' and fld_categoryId<>'".$larr_exam[$im]['fld_categoryIdNo']."' and fld_categoryId<>'".$rowparent['fld_parentId']."'");
		 }
		 if(!mysql_num_rows($rspcat)) {
		 $rspexam=$dbh2->Query("select e.fld_productId, e.fld_examTitle, e.fld_examFee, e.fld_examShortDesc from ".TB_PACKAGE_EXAMS." pe inner join ".TB_EXAMS." e on pe.fld_productIdNo=e.fld_productId where pe.fld_packIdNo='".$rowpack['fld_packIdNo']."' order by pe.fld_productIdNo asc");
		 if(mysql_num_rows($rspexam)<=5) {
		 $tab .='<form name="examform'.$rowpack['fld_packIdNo'].'" method="post" action="'.DR_ROOT."shopCart.php".'">
		<input type="hidden" name="packId" value="'.$rowpack['fld_packIdNo'].'">
		<input type="hidden" name="type" value="bundle">
		<input type="hidden" name="catId" value="'.$rowpack['fld_categoryIdNo'].'">
		<input type="hidden" name="quantity" value="1">
		<input type="hidden" name="action" value="add">
 <div class="valuPackMan">
    <div class="valuPacList"> <img src="<?php echo LINK_PATH;?>images/book.png" />
      <h1>'.substr($rowpack['fld_PackName'],0,25).'</h1>
      <ul>';
	  
	  $totexamfee=0;
	  while($rowpexam=mysql_fetch_array($rspexam)) {
        $tab .='<li><strong>'.substr($rowpexam['fld_examTitle'],0,38).'</strong><br />
          '.substr($rowpexam['fld_examShortDesc'],0,40).'
          <p>$'.$rowpexam['fld_examFee'].'</p>
        </li>';
		$totexamfee +=$rowpexam['fld_examFee'];
	  }
      $tab .='</ul>';
		$feedifference=$totexamfee-$rowpack['fld_PackFee'];
$tab .='</div>
    <p style="margin-left:30px; width:180px;">Save $'.number_format($feedifference,2).' Now</p>
    <div align="center">';
	$tab .='<input type="image" src="images/add_cart.png" /></div>
  </div>
 </form>';
		 }
		 }
	 }
  }
 
 $tab .='<div>'.$templateTopDesc.'</div>
';     
$tab .='<div class="cartHead"><h4>All Featured Exams</h4></div>
<div class="catAll"><ul>'.$boxes1.'</ul></div>

<div class="cartHead"><h4>All Latest Exams</h4></div>
<div class="catAll"><ul>'.$boxes3.'</ul></div>
<form class="formclass" name="frm_tellAfirend" method=POST action="emailAction.php?action=tellafriend" onsubmit="return Tellchk();">
						<input type="hidden" name="hdnTellAFriend" value="true">
						<input type="hidden" name="hdnPage" value="'.$_SERVER['PHP_SELF'].'">
	<div class="topMargn" style="float:right;">
        <div class="dicVocher" align="right">Recomenned to a Friend :<br /><input name="" type="text" value="Friend Email Address"  onfocus="blank(this)" onblur="unblank(this)" /> 
        <input type="image" src="images/submit.png" width="95" height="26" align="absmiddle" /></div></form></div></div>';

$tab .='</div>
</div>
<div class="bodyContanerbotom"></div>
</div>

<div class="footerInner">
     <div class="newscontaner">
      <h4>What\'s in TroyTec</h4>
      <ul class="footerList">
                <li>Secure Site</li>
       <li> 100% Instant Download</li>
        <li>Providing Certifications Exams since 1997</li>
       <li> 24/7 Support</li>
        <li>Industry Leader</li>
      </ul>
    </div>
    
    <div class="newscontaner">
      <h4>Popular Products</h4>
      <ul class="footerList">
        <li>Cisco</li>
<li>Apple</li>
<li>Checkpoint</li>
<li>Avaya</li>
<li>CompTIA</li>
<li>ECCouncil</li>

      </ul>
    </div>
    
    <div class="newscontaner">
      <h4>Popular Exams</h4>
      <ul class="footerList">
        <li>9L0-621</li>
<li>MB7-840</li>
<li>640-803</li>
<li>JN0-101</li>
<li>JN0-643</li>
<li>650-473</li>

      </ul>
    </div>
    <div class="footrRight"></div>
     </div>
     <div class="footerLinks">
     TestKiller Copyright 2012 All Rights Reserved. The Registered TestKiller Trademark Is Used Exclusively Under Licence Agreement   
     </div>
</div>
</div>
</body></html>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7389997-2");
pageTracker._trackPageview();
} catch(err) {}</script>';

$f = @fopen(FILE_ROOT.$filename, "w");
$r = @fwrite($f, $tab);
fclose($f);
}

}

return $pq;

}
	function generate_cat_pages()
	{
		global $dbh2, $ObjGen;
		$rsj=$dbh2->Query("select fld_categoryId from ".TB_CATEGORY." where fld_parentId='0'");
		$catmyarrays = array();
		while($exam_rowj=mysql_fetch_array($rsj))
		{
			$catmyarrays[]=$exam_rowj['fld_categoryId'];
		}
		foreach($catmyarrays as $uy)
		{
			
      $this->publish_cat_pages($uy);

		}

	}


	function generate_subcat_pages()
	{
		global $dbh2, $ObjGen;
		$rsubcate=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId<>0");
		$rs_template=$dbh2->Query("select * from ".TB_STEMPLATES." ORDER BY is_main DESC");		
		$arrTemplates_data = Array();
while($template_row=$dbh2->FetchRow($rs_template))
{
	$arrTemplates_data[]=$template_row;
}
/*
$rs_template=$dbh2->Query("select * from ".TB_CTEMPLATES." ORDER BY is_main DESC");
$arrTemplates_data=Array();
while($template_row=$dbh2->FetchRow($rs_template))
{
	$arrTemplates_data[]=$template_row;
}
*/
$rs3=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId=0 order by fld_categoryName ASC");
		$larr=Array();

		while($row=mysql_fetch_array($rs3))
		$larr[]=$row;

while($exam_row=$dbh2->FetchRow($rsubcate))
{

	$arrVars=Array(

		"exam_name" =>$exam_row[fld_categoryName],
		"exam_code" =>$exam_row[fld_categoryName]

		);

	$pId=$exam_row["fld_parentId"];
	$catName=$ObjGen->getVal(TB_CATEGORY,"fld_categoryId",$pId,"fld_categoryName");

	for($i=0;$i<count($arrTemplates_data);$i++)
	{
		if($arrTemplates_data[$i]['fld_templateId']==$exam_row["fld_categoryId"])
		{
			$template_row[]=$arrTemplates_data[$i];
			$template_row[]=$arrTemplates_data[$i+1];
		}
	}




	for($tp=0;$tp<count($arrTemplates_data);$tp++)
	{
		$templateShortDesc="";
		$templateTopDesc=$arrTemplates_data[$tp]['fld_templateTopDesc'];
		$templateBottomDesc=$arrTemplates_data[$tp]['fld_templateBottomDesc'];
		$templateTitle=stripslashes($arrTemplates_data[$tp]['fld_templatePageTitle']);
		$templateKeywords=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaKeywords']);
		$templateDesc=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaDesc']);

		foreach($arrVars as $key=>$val)
		{
			$templateShortDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateShortDesc);
			$templateTopDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTopDesc);
			$templateBottomDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateBottomDesc);
			$templateTitle=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTitle);
			$templateKeywords=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateKeywords);
			$templateDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateDesc);
		}
		$key='';
		$val='';
		if($arrTemplates_data[$tp][is_main]==1)
		{
			$filename=$ObjGen->replacespace($exam_row[fld_categoryName]).FILES_EXT.".html";
		}
		else
		{
			$filename=$ObjGen->replacespace($exam_row[fld_categoryName])."_".$arrTemplates_data[$tp][fld_templateLink];
		}

		if($arrTemplates_data[$tp+1][is_main]==1)
		{
			$previousTemplateUrl=$exam_row[fld_categoryName]."_".$filename;
		}
		else
		{
			$previousTemplateUrl=$exam_row[fld_categoryName]."_".$arrTemplates_data[$tp+1][fld_templateLink];
		}






		$earr=Array();

		$rs1=$dbh2->Query("select * from ".TB_EXAMS." where fld_categoryIdNo=' ".$exam_row['fld_categoryId']."' order by fld_examCode ASC");

		while($row=mysql_fetch_array($rs1))
		
		$earr[]=$row;
		
$tab ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<meta http-equiv="Content-Language" content="en-us" />
<meta name="GENERATOR" content="Microsoft FrontPage 5.0" />
<meta name="Author" content="'.stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaAuthor']).'" />
<meta name="Keywords" content="'.$templateKeywords.'" />
<meta name="Description" content="'.$templateDesc.'" />
<title>'.$templateTitle.'</title>
<link href="css/mainSyler.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

              var _gaq = _gaq || [];
              _gaq.push(["_setAccount", "UA-7389997-8"]);
              _gaq.push(["_trackPageview"]);

  (function() {
    var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
    ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
  })();


function blank(a){
	if(a.value == a.defaultValue) a.value = "";
}
function unblank(a){
	if(a.value == "") a.value = a.defaultValue;
}
</script>

<script type="text/javascript">
<!--
function chk()
{
	if(!validateTEmail(document.frm_signup.email_signup_qestions.value))
	{
		alert(\'Please enter a valid email address.\');
		document.frm_signup.email_signup_qestions.focus();
		return false;
	}
}
function validateTEmail( strValue) {
var objRegExp  = /(^[a-z0-9A-Z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)([.][a-z]{3})$)|(^[0-9A-Za-z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)(\.[a-z]{3})(\.[a-z]{2})*$)/i;
  return objRegExp.test(strValue);
}

function Tellchk()
{
	if(!validateTEmail(document.frm_tellAfirend.txtFriendEmail.value)){
		alert(\'Please enter a valid email address.\');
		document.frm_tellAfirend.txtFriendEmail.focus();
		return false;
	}
	if(!validateTEmail(document.frm_tellAfirend.txtYourEmail.value)){
		alert(\'Please enter a valid email address.\');
		document.frm_tellAfirend.txtYourEmail.focus();
		return false;
	}
}
//-->
</script>
</script>
</head>
<body>';
$tab .='<div class="mainContaner">
<div class="headerContaner">
<div class="logoHolder">
      <h1><a href="<?php echo LINK_PATH;?>#"></a></h1>
    </div>
    <div class="ChatHolder"><!-- BEGIN ProvideSupport.com Graphics Chat Button Code -->
<div id="cijMWT" style="z-index:100;position:absolute"></div><div id="scjMWT" style="display:inline"></div><div id="sdjMWT" style="display:none"></div><script type="text/javascript">var sejMWT=document.createElement("script");sejMWT.type="text/javascript";var sejMWTs=(location.protocol.indexOf("https")==0?"https":"http")+"://image.providesupport.com/js/nextagetech/safe-standard.js?ps_h=jMWT&ps_t="+new Date().getTime();setTimeout("sejMWT.src=sejMWTs;document.getElementById(\'sdjMWT\').appendChild(sejMWT)",1)</script><noscript><div style="display:inline"><a href="<?php echo LINK_PATH;?>http://www.providesupport.com?messenger=nextagetech">Chat Support</a></div></noscript>
<!-- END ProvideSupport.com Graphics Chat Button Code --></div>
    <div class="headerRight">
    <input name="" type="image" src="images/registerBtn.png" border="0"  align="right" class="regBtn" onclick="javascript:window.location=\'register.php\';"><br />
    <div class="topmenu">
        <div class="cart"><strong><a href="<?php echo LINK_PATH;?>'.DR_ROOT.'cart.php">Shopping Cart</a></strong></div>
        
      </div>
    </div>
</div>

<div class="bodyContaner">
<div class="bodyContanerTop"></div>
<div class="bodyInner">

<div class="menuContaner">
<div class="navouter">
<div id="navcontainer">
        <ul id="navlist">
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'index.php">Home</a></li>
          <li id="active"><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'all-categories.php">Exams</a></li>
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'licensing.php">Corporate Licensing</a></li>     
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'guarantee.php">Guarantee</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'affiliates.php">Affiliates</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'faq.php">FAQs</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'aboutus.php">About Us</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'contact.php">Contact Us</a></li>
        </ul>
      </div>
</div>
<div class="serchCont">
<form name="search_form" method="post" action="'. DR_ROOT.'exam.php"><input type="text" class="searchFIld" value="Search" name="search_keyword" onfocus="blank(this)" onblur="unblank(this)"> 
<a href="javascript:void(0);" onclick="document.search_form.submit();"><img src="<?php echo LINK_PATH;?>images/search.jpg" border="0" align="top" /></a></form></div>
</div>
<div class="bodyData">';
$tab .='<div class="leftContaner"><div class="leftHead">
    <h3>Our Vendors </h3>
  </div>
  <div id="button">
    <ul>';
    $rs=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId='0' order by fld_categoryName asc");
    $stpos = 0;
	while($row=$dbh2->FetchRow($rs)){
		$tab .='<li><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($row['fld_categoryName']).FILES_EXT.'.html">'. $row[fld_categoryName] .'</a></li>';
	}

    $tab .='</ul>
  </div>
</div>';
    $tab .='<div class="rightContaner"> 
     <p>'.trim($exam_row[fld_categoryName]).' Exam by Certmagic</p>';
	  
	  $rspk=$dbh2->Query("select p.fld_PackId, p.fld_PackCode, p.fld_PackName, p.fld_PackFee, p.fld_PackEdition from ".TB_PACKAGE." p INNER JOIN ".TB_PACK_CATEGORY." pc on p.fld_PackId=pc.fld_PackId where pc.fld_categoryId='".$exam_row['fld_categoryId']."' order by p.fld_PackCode ASC");
		if(mysql_num_rows($rspk)) {
			$catnameap=true;
			while($rowpk=mysql_fetch_array($rspk)) {
				$tab .='<div class="cateMan">
            			<div class="cateManList">';
						$tab .='<ul>
                <li><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($rowpk['fld_PackCode']).FILES_EXT.".html".'">'.$rowpk['fld_PackCode'].'</a></li>
                <li><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($rowpk['fld_PackCode']).FILES_EXT.".html".'">'.$rowpk['fld_PackName'].'</a></li>
              </ul>
            </div>
                          <div style="clear:both;"></div>
                          <div class="cateManTxt">'.$rowpk['fld_PackEdition'].'</div>
            <h1 class="valBtm"><form method=post action="'.DR_ROOT."shopCart.php".'">
                        	<input type="hidden" name="packId" value="'.$rowpk['fld_PackId'].'">
							<input type="hidden" name="type" value="bundle">
                            <input type="hidden" name="catId" value="'.$id.'">
                            <input type="hidden" name="quantity" value="1">$'.$rowpk['fld_PackFee'].' 
                            <input type="hidden" name="action" value="add"><input type="image" src="images/add_cart.png" name="buy_now" value="Buy now" width="132" height="36"/></form></h1>
            
          </div>';
		  $packcnt++;
			}
		}
	  
	  
      for($i3=0;$i3<count($earr);$i3++){
		  $tab .='<div class="cateHead">
            <h4><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($earr[$i3]['fld_examCode']).FILES_EXT.".html".'">'.$earr[$i3]['fld_examCode'].'</a> <a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($earr[$i3]['fld_examCode']).FILES_EXT.".html".'">'.$earr[$i3]['fld_examTitle'].'</a></h4>
          </div>
          <div class="catAll">
          <div style="float:left; width:300px;">'.$earr[$i3]['fld_examShortDesc'].'</div>
          <div style="float:left;  padding:0 30px;"><strong>'.$ObjGen->MySqltoTextual($earr[$i3]['fld_examDate']).'</strong>
		  <p align="center">$'.$earr[$i3]['fld_examFee'].'</p></div>
          <div style="float:right;"><form method=post action="'.DR_ROOT."shopCart.php".'">
                        	<input type="hidden" name="examId" value="'.$earr[$i3]['fld_productId'].'">
                            <input type="hidden" name="catId" value="'.$id.'">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="action" value="add"><input type="image" src="images/add_cart.png" name="buy_now" value="Buy now" width="132" height="36"/> ';
							if(trim($earr[$i3]['fld_examQAdemoFile'])!="" or trim($earr[$i3]['fld_examStudyGuidedemoFile'])!="" or trim($earr[$i3]['fld_examTestEnginedemoFile'])!="" or trim($earr[$i3]['fld_examAudioGuidedemoFile'])!=""){
							  	$tab .="<a href=\"demo.php?exid=".$earr[$i3]['fld_productId']."\"><img src='images/demo1.png' border='0' /></a>";
							}
							$tab .='</form></div>
          </div>';
      }
		$tab .='<div>'.$templateTopDesc.'</div>

      <div>      	
'.$templateBottomDesc.'
      </div>';

	  
      $tab .='<form class="formclass" name="frm_tellAfirend" method=POST action="emailAction.php?action=tellafriend" onsubmit="return Tellchk();">
						<input type="hidden" name="hdnTellAFriend" value="true">
						<input type="hidden" name="hdnPage" value="'.$_SERVER['PHP_SELF'].'">
	<div class="topMargn" style="float:right;">
        <div class="dicVocher" align="right">Recomenned to a Friend :<br /><input name="" type="text" value="Friend Email Address" /> 
        <input type="image" src="images/submit.png" width="95" height="26" align="absmiddle" /></div></form></div>';
$tab .='</div>
</div>
<div class="bodyContanerbotom"></div>
</div>

<div class="footerInner">
     <div class="newscontaner">
      <h4>What\'s in TroyTec</h4>
      <ul class="footerList">
                <li>Secure Site</li>
       <li> 100% Instant Download</li>
        <li>Providing Certifications Exams since 1997</li>
       <li> 24/7 Support</li>
        <li>Industry Leader</li>
      </ul>
    </div>
    
    <div class="newscontaner">
      <h4>Popular Products</h4>
      <ul class="footerList">
        <li>Cisco</li>
<li>Apple</li>
<li>Checkpoint</li>
<li>Avaya</li>
<li>CompTIA</li>
<li>ECCouncil</li>

      </ul>
    </div>
    
    <div class="newscontaner">
      <h4>Popular Exams</h4>
      <ul class="footerList">
        <li>9L0-621</li>
<li>MB7-840</li>
<li>640-803</li>
<li>JN0-101</li>
<li>JN0-643</li>
<li>650-473</li>

      </ul>
    </div>
    <div class="footrRight"></div>
     </div>
     <div class="footerLinks">
     TestKiller Copyright 2012 All Rights Reserved. The Registered TestKiller Trademark Is Used Exclusively Under Licence Agreement   
     </div>
</div>
</div>
</body></html>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7389997-2");
pageTracker._trackPageview();
} catch(err) {}</script>';
		$f = fopen(FILE_ROOT.$filename, "w");

		$r = fwrite($f, $tab);

		fclose($f);


	}
	
	}

	}



	function publish_category_template($id)
	{
		global $dbh2, $ObjGen;
		$rst=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId=0");
		while($exam_rowt=$dbh2->FetchRow($rst))
		{
			$this->publish_cat_pages($exam_rowt['fld_categoryId']);
		}
	}
	function publish_subcategory_template($id)
	{
		global $dbh2, $ObjGen;
		$rsubcate=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId<>0");
$rs_template=$dbh2->Query("select * from ".TB_STEMPLATES." ORDER BY is_main DESC");
$arrTemplates_data=Array();
while($template_row=$dbh2->FetchRow($rs_template))
{
	$arrTemplates_data[]=$template_row;
}

$rs3=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId=0 order by fld_categoryName ASC");
		$larr=Array();

		while($row=mysql_fetch_array($rs3))
		$larr[]=$row;

while($exam_row=$dbh2->FetchRow($rsubcate))
{

	$arrVars=Array(

		"exam_name" =>$exam_row[fld_categoryName],
		"exam_code" =>$exam_row[fld_categoryName]

		);

	$pId=$exam_row["fld_parentId"];
	$catName=$ObjGen->getVal(TB_CATEGORY,"fld_categoryId",$pId,"fld_categoryName");

	for($i=0;$i<count($arrTemplates_data);$i++)
	{
		if($arrTemplates_data[$i]['fld_templateId']==$exam_row["fld_categoryId"])
		{
			$template_row[]=$arrTemplates_data[$i];
			$template_row[]=$arrTemplates_data[$i+1];
		}
	}




	for($tp=0;$tp<count($arrTemplates_data);$tp++)
	{
		$templateShortDesc="";
		$templateTopDesc=$arrTemplates_data[$tp]['fld_templateTopDesc'];
		$templateBottomDesc=$arrTemplates_data[$tp]['fld_templateBottomDesc'];
		$templateTitle=stripslashes($arrTemplates_data[$tp]['fld_templatePageTitle']);
		$templateKeywords=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaKeywords']);
		$templateDesc=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaDesc']);

		foreach($arrVars as $key=>$val)
		{
			$templateShortDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateShortDesc);
			$templateTopDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTopDesc);
			$templateBottomDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateBottomDesc);
			$templateTitle=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTitle);
			$templateKeywords=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateKeywords);
			$templateDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateDesc);
		}
		$key='';
		$val='';
		if($arrTemplates_data[$tp][is_main]==1)
		{
			$filename=$ObjGen->replacespace($exam_row[fld_categoryName]).".html";
		}
		else
		{
			$filename=$ObjGen->replacespace($exam_row[fld_categoryName])."_".$arrTemplates_data[$tp][fld_templateLink];
		}

		if($arrTemplates_data[$tp+1][is_main]==1)
		{
			$previousTemplateUrl=$exam_row[fld_categoryName]."_".$filename;
		}
		else
		{
			$previousTemplateUrl=$exam_row[fld_categoryName]."_".$arrTemplates_data[$tp+1][fld_templateLink];
		}






		$earr=Array();

		$rs1=$dbh2->Query("select * from ".TB_EXAMS." where fld_categoryIdNo=' ".$exam_row['fld_categoryId']."' order by fld_examCode ASC");




		while($row=mysql_fetch_array($rs1))
		$earr[]=$row;











		$tab ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<meta http-equiv="Content-Language" content="en-us" />
<meta name="GENERATOR" content="Microsoft FrontPage 5.0" />
<meta name="Author" content="'.stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaAuthor']).'" />
<meta name="Keywords" content="'.$templateKeywords.'" />
<meta name="Description" content="'.$templateDesc.'" />
<title>'.$templateTitle.'</title>
<link href="css/mainSyler.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

              var _gaq = _gaq || [];
              _gaq.push(["_setAccount", "UA-7389997-8"]);
              _gaq.push(["_trackPageview"]);

  (function() {
    var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
    ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
  })();


function blank(a){
	if(a.value == a.defaultValue) a.value = "";
}
function unblank(a){
	if(a.value == "") a.value = a.defaultValue;
}
</script>

<script type="text/javascript">
<!--
function chk()
{
	if(!validateTEmail(document.frm_signup.email_signup_qestions.value))
	{
		alert(\'Please enter a valid email address.\');
		document.frm_signup.email_signup_qestions.focus();
		return false;
	}
}
function validateTEmail( strValue) {
var objRegExp  = /(^[a-z0-9A-Z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)([.][a-z]{3})$)|(^[0-9A-Za-z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)(\.[a-z]{3})(\.[a-z]{2})*$)/i;
  return objRegExp.test(strValue);
}

function Tellchk()
{
	if(!validateTEmail(document.frm_tellAfirend.txtFriendEmail.value)){
		alert(\'Please enter a valid email address.\');
		document.frm_tellAfirend.txtFriendEmail.focus();
		return false;
	}
	if(!validateTEmail(document.frm_tellAfirend.txtYourEmail.value)){
		alert(\'Please enter a valid email address.\');
		document.frm_tellAfirend.txtYourEmail.focus();
		return false;
	}
}
//-->
</script>
</script>
</head>
<body>';
$tab .='<div class="mainContaner">
<div class="headerContaner">
<div class="logoHolder">
      <h1><a href="<?php echo LINK_PATH;?>#"></a></h1>
    </div>
    <div class="ChatHolder"><!-- BEGIN ProvideSupport.com Graphics Chat Button Code -->
<div id="cijMWT" style="z-index:100;position:absolute"></div><div id="scjMWT" style="display:inline"></div><div id="sdjMWT" style="display:none"></div><script type="text/javascript">var sejMWT=document.createElement("script");sejMWT.type="text/javascript";var sejMWTs=(location.protocol.indexOf("https")==0?"https":"http")+"://image.providesupport.com/js/nextagetech/safe-standard.js?ps_h=jMWT&ps_t="+new Date().getTime();setTimeout("sejMWT.src=sejMWTs;document.getElementById(\'sdjMWT\').appendChild(sejMWT)",1)</script><noscript><div style="display:inline"><a href="<?php echo LINK_PATH;?>http://www.providesupport.com?messenger=nextagetech">Chat Support</a></div></noscript>
<!-- END ProvideSupport.com Graphics Chat Button Code --></div>
    <div class="headerRight">
    <input name="" type="image" src="images/registerBtn.png" border="0"  align="right" class="regBtn" onclick="javascript:window.location=\'register.php\';"><br />
    <div class="topmenu">
        <div class="cart"><strong><a href="<?php echo LINK_PATH;?>'.DR_ROOT.'cart.php">Shopping Cart</a></strong></div>
        
      </div>
    </div>
</div>

<div class="bodyContaner">
<div class="bodyContanerTop"></div>
<div class="bodyInner">

<div class="menuContaner">
<div class="navouter">
<div id="navcontainer">
        <ul id="navlist">
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'index.php">Home</a></li>
          <li id="active"><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'all-categories.php">Exams</a></li>
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'licensing.php">Corporate Licensing</a></li>     
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'guarantee.php">Guarantee</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'affiliates.php">Affiliates</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'faq.php">FAQs</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'aboutus.php">About Us</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'contact.php">Contact Us</a></li>
        </ul>
      </div>
</div>
<div class="serchCont">
<form name="search_form" method="post" action="'. DR_ROOT.'exam.php"><input type="text" class="searchFIld" value="Search" name="search_keyword" onfocus="blank(this)" onblur="unblank(this)"> 
<a href="javascript:void(0);" onclick="document.search_form.submit();"><img src="<?php echo LINK_PATH;?>images/search.jpg" border="0" align="top" /></a></form></div>
</div>
<div class="bodyData">';
$tab .='<div class="leftContaner"><div class="leftHead">
    <h3>Our Vendors </h3>
  </div>
  <div id="button">
    <ul>';
    $rs=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId='0' order by fld_categoryName asc");
    $stpos = 0;
	while($row=$dbh2->FetchRow($rs)){
		$tab .='<li><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($row['fld_categoryName']).FILES_EXT.'.html">'. $row[fld_categoryName] .'</a></li>';
	}

    $tab .='</ul>
  </div>
</div>';
    $tab .='<div class="rightContaner"> 
     <p>'.trim($exam_row[fld_categoryName]).' Exam by Certmagic</p>';
	  
	  $rspk=$dbh2->Query("select p.fld_PackId, p.fld_PackCode, p.fld_PackName, p.fld_PackFee, p.fld_PackEdition from ".TB_PACKAGE." p INNER JOIN ".TB_PACK_CATEGORY." pc on p.fld_PackId=pc.fld_PackId where pc.fld_categoryId='".$id."' order by p.fld_PackCode ASC");
		if(mysql_num_rows($rspk)) {
			$catnameap=true;
			while($rowpk=mysql_fetch_array($rspk)) {
				$tab .='<div class="cateMan">
            			<div class="cateManList">';
						$tab .='<ul>
                <li><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($rowpk['fld_PackCode']).FILES_EXT.".html".'">'.$rowpk['fld_PackCode'].'</a></li>
                <li><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($rowpk['fld_PackCode']).FILES_EXT.".html".'">'.$rowpk['fld_PackName'].'</a></li>
              </ul>
            </div>
                          <div style="clear:both;"></div>
                          <div class="cateManTxt">'.$rowpk['fld_PackEdition'].'</div>
            <h1 class="valBtm"><form method=post action="'.DR_ROOT."shopCart.php".'">
                        	<input type="hidden" name="packId" value="'.$rowpk['fld_PackId'].'">
							<input type="hidden" name="type" value="bundle">
                            <input type="hidden" name="catId" value="'.$id.'">
                            <input type="hidden" name="quantity" value="1">$'.$rowpk['fld_PackFee'].' 
                            <input type="hidden" name="action" value="add"><input type="image" src="images/add_cart.png" name="buy_now" value="Buy now" width="132" height="36"/></form></h1>
            
          </div>';
		  $packcnt++;
			}
		}
	  
	  
      for($i3=0;$i3<count($earr);$i3++){
		  $tab .='<div class="cateHead">
            <h4><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($earr[$i3]['fld_examCode']).FILES_EXT.".html".'">'.$earr[$i3]['fld_examCode'].'</a> <a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($earr[$i3]['fld_examCode']).FILES_EXT.".html".'">'.$earr[$i3]['fld_examTitle'].'</a></h4>
          </div>
          <div class="catAll">
          <div style="float:left; width:300px;">'.$earr[$i3]['fld_examShortDesc'].'</div>
          <div style="float:left;  padding:0 30px;"><strong>'.$ObjGen->MySqltoTextual($earr[$i3]['fld_examDate']).'</strong>
		  <p align="center">$'.$earr[$i3]['fld_examFee'].'</p></div>
          <div style="float:right;"><form method=post action="'.DR_ROOT."shopCart.php".'">
                        	<input type="hidden" name="examId" value="'.$earr[$i3]['fld_productId'].'">
                            <input type="hidden" name="catId" value="'.$id.'">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="action" value="add"><input type="image" src="images/add_cart.png" name="buy_now" value="Buy now" width="132" height="36"/> ';
							if(trim($earr[$i3]['fld_examQAdemoFile'])!="" or trim($earr[$i3]['fld_examStudyGuidedemoFile'])!="" or trim($earr[$i3]['fld_examTestEnginedemoFile'])!="" or trim($earr[$i3]['fld_examAudioGuidedemoFile'])!=""){
							  	$tab .="<a href=\"demo.php?exid=".$earr[$i3]['fld_productId']."\"><img src='images/demo1.png' border='0' /></a>";
							}
							$tab .='</form></div>
          </div>';
      }
		$tab .='<div>'.$templateTopDesc.'</div>

      <div>      	
'.$templateBottomDesc.'
      </div>';

	  
      $tab .='<form class="formclass" name="frm_tellAfirend" method=POST action="emailAction.php?action=tellafriend" onsubmit="return Tellchk();">
						<input type="hidden" name="hdnTellAFriend" value="true">
						<input type="hidden" name="hdnPage" value="'.$_SERVER['PHP_SELF'].'">
	<div class="topMargn" style="float:right;">
        <div class="dicVocher" align="right">Recomenned to a Friend :<br /><input name="" type="text" value="Friend Email Address" /> 
        <input type="image" src="images/submit.png" width="95" height="26" align="absmiddle" /></div></form></div>';
$tab .='</div>
</div>
<div class="bodyContanerbotom"></div>
</div>

<div class="footerInner">
     <div class="newscontaner">
      <h4>What\'s in TroyTec</h4>
      <ul class="footerList">
                <li>Secure Site</li>
       <li> 100% Instant Download</li>
        <li>Providing Certifications Exams since 1997</li>
       <li> 24/7 Support</li>
        <li>Industry Leader</li>
      </ul>
    </div>
    
    <div class="newscontaner">
      <h4>Popular Products</h4>
      <ul class="footerList">
        <li>Cisco</li>
<li>Apple</li>
<li>Checkpoint</li>
<li>Avaya</li>
<li>CompTIA</li>
<li>ECCouncil</li>

      </ul>
    </div>
    
    <div class="newscontaner">
      <h4>Popular Exams</h4>
      <ul class="footerList">
        <li>9L0-621</li>
<li>MB7-840</li>
<li>640-803</li>
<li>JN0-101</li>
<li>JN0-643</li>
<li>650-473</li>

      </ul>
    </div>
    <div class="footrRight"></div>
     </div>
     <div class="footerLinks">
     TestKiller Copyright 2012 All Rights Reserved. The Registered TestKiller Trademark Is Used Exclusively Under Licence Agreement   
     </div>
</div>
</div>
</body></html>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7389997-2");
pageTracker._trackPageview();
} catch(err) {}</script>';


		$f = fopen(DR_BASE_ROOT.$filename, "w");

		$r = fwrite($f, $tab);

		fclose($f);
	}
	}
	}
	function publish_exam_template($id)
	{
		global $dbh2, $ObjGen;
		$rs3=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId=0 order by fld_categoryName ASC");
$larr=Array();
while($rowk=mysql_fetch_array($rs3))
$larr[]=$rowk;
$rs_template=$dbh2->Query("select * from ".TB_TEMPLATES." ORDER BY is_main DESC");
$arrTemplates_data=Array();
while($template_row=$dbh2->FetchRow($rs_template))
{
	$arrTemplates_data[]=$template_row;
}
$rst=$dbh2->Query("select * from ".TB_TESTIMONIAL." order by fld_tId desc");
$arratesti=Array();
while($rowt=$dbh2->FetchRow($rst))
$arratesti[]=$rowt;

$rsj=$dbh2->Query("select * from ".TB_EXAMS." order by fld_productId desc");
$tab1="";
for($ad=0;$ad<count($larr);$ad++)
{

	$tab1.="<tr><td height=\"1\" background=\"images/doted_line.gif\"></td></tr>";

    $tab1.="<tr><td class=\"links1\"><a href='".DR_ROOT.$ObjGen->replacespace($larr[$ad]['fld_categoryName']).".html"."'><img src=\"images/aero.gif\" align=\"absmiddle\" border=\"0\">&nbsp;&nbsp;".trim($larr[$ad][fld_categoryName])."</a></td></tr>";

}
$tab2="";
if(sizeof($arratesti)>0)
{

	$tab2.="<table width=\"515\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";

 	foreach($arratesti as $tr)
	{
 		$tab2.="<tr><td height=\"2\"></td></tr><tr><td height=\"40\" valign=\"middle\" class=\"color_blue2\"><span class=\"normal_text\">".trim($tr['fld_tmessage'])."</span></td>
</tr>";

	}
	$tab2.="</table> ";
}
$larr_exam=Array();
while($exam_row=$dbh2->FetchRow($rsj))
{

	$larr_exam[]=$exam_row;
}

$pq=0;
for($im=0;$im<sizeof($larr_exam);$im++)
{
		$pq++;
	$rsq=$dbh2->Query("select * from ".TB_CATEGORY." where fld_categoryId='".$larr_exam[$im]['fld_categoryIdNo']."'");
	$exam_rowq=$dbh2->FetchRow($rsq);

	$subcatId=$larr_exam[$im]['fld_categoryIdNo'];
	$subcatName=$exam_rowq['fld_categoryName'];
	$pId=$exam_rowq['fld_parentId'];
	$rsm=$dbh2->Query("select * from ".TB_CATEGORY." where fld_categoryId='".$pId."'");
	$exam_rowqm=$dbh2->FetchRow($rsm);
	$catName=$exam_rowqm['fld_categoryName'];


	$arrVars=Array(

		"exam_name" =>$larr_exam[$im]['fld_examTitle'],
		"exam_code" =>$larr_exam[$im]['fld_examCode']

		);




	for($tp=0;$tp<count($arrTemplates_data);$tp++)
	{

		$templateShortDesc=$larr_exam[$im]['fld_examShortDesc'];
		$templateTopDesc=$arrTemplates_data[$tp]['fld_templateTopDesc'];
		$templateBottomDesc=$arrTemplates_data[$tp]['fld_templateBottomDesc'];
		$templateTitle=stripslashes($arrTemplates_data[$tp]['fld_templatePageTitle']);
		$templateKeywords=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaKeywords']);
		$templateDesc=stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaDesc']);

		foreach($arrVars as $key=>$val)
		{
			$templateShortDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateShortDesc);
			$templateTopDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTopDesc);
			$templateBottomDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateBottomDesc);
			$templateTitle=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateTitle);
			$templateKeywords=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateKeywords);
			$templateDesc=preg_replace('/\[\['.$key.'\]\]/im',$val,$templateDesc);
		}
		$key='';
		$val='';
		if($arrTemplates_data[$tp][is_main]==1)
		{
			$filename=$ObjGen->replacespace($larr_exam[$im][fld_examCode]).".html";
		}
		else
		{
			$filename=$ObjGen->replacespace($larr_exam[$im][fld_examCode])."_".$arrTemplates_data[$tp][fld_templateLink];
		}

		if($arrTemplates_data[$tp+1][is_main]==1)
		{

			$previousTemplateUrl=$larr_exam[$im][fld_examCode]."_".$filename;
		}
		else
		{
			$previousTemplateUrl=$larr_exam[$im][fld_examCode]."_".$arrTemplates_data[$tp+1][fld_templateLink];
		}

		//$templateTopDesc=$template_row[0][fld_templateTopDesc];
		//$templateBottomDesc=$template_row[0][fld_templateBottomDesc];

		$arrVars=Array();
		$arrVars['exam_name']=$larr_exam[$im][fld_examTitle];
		$arrVars['exam_code']=$larr_exam[$im][fld_examCode];


		$tab ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<meta http-equiv="Content-Language" content="en-us" />
<meta name="GENERATOR" content="Microsoft FrontPage 5.0" />
<meta name="Author" content="'.stripslashes($arrTemplates_data[$tp]['fld_templatePageMetaAuthor']).'" />
<meta name="Keywords" content="'.$templateKeywords.'" />
<meta name="Description" content="'.$templateDesc.'" />
<title>'.$templateTitle.'</title>
<link href="css/mainSyler.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

              var _gaq = _gaq || [];
              _gaq.push(["_setAccount", "UA-7389997-8"]);
              _gaq.push(["_trackPageview"]);

  (function() {
    var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
    ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
  })();

function blank(a){
if(a.value == a.defaultValue) a.value = "";
}
function unblank(a){
if(a.value == "") a.value = a.defaultValue;
}
</script>

<script type="text/javascript">
<!--
function chk()
{
	if(!validateTEmail(document.frm_signup.email_signup_qestions.value))
	{
		alert(\'Please enter a valid email address.\');
		document.frm_signup.email_signup_qestions.focus();
		return false;
	}
}
function validateTEmail( strValue) {
var objRegExp  = /(^[a-z0-9A-Z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)([.][a-z]{3})$)|(^[0-9A-Za-z]([0-9A-Za-z_\.]*)@([0-9A-Za-z_\.]*)(\.[a-z]{3})(\.[a-z]{2})*$)/i;
  return objRegExp.test(strValue);
}

function Tellchk()
{
	if(!validateTEmail(document.frm_tellAfirend.txtFriendEmail.value)){
		alert(\'Please enter a valid email address.\');
		document.frm_tellAfirend.txtFriendEmail.focus();
		return false;
	}
	if(!validateTEmail(document.frm_tellAfirend.txtYourEmail.value)){
		alert(\'Please enter a valid email address.\');
		document.frm_tellAfirend.txtYourEmail.focus();
		return false;
	}
}
//-->
</script>
</script>
</head>
<body>';
$tab .='<div class="mainContaner">
<div class="headerContaner">
<div class="logoHolder">
      <h1><a href="<?php echo LINK_PATH;?>#"></a></h1>
    </div>
    <div class="ChatHolder"><!-- BEGIN ProvideSupport.com Graphics Chat Button Code -->
<div id="cijMWT" style="z-index:100;position:absolute"></div><div id="scjMWT" style="display:inline"></div><div id="sdjMWT" style="display:none"></div><script type="text/javascript">var sejMWT=document.createElement("script");sejMWT.type="text/javascript";var sejMWTs=(location.protocol.indexOf("https")==0?"https":"http")+"://image.providesupport.com/js/nextagetech/safe-standard.js?ps_h=jMWT&ps_t="+new Date().getTime();setTimeout("sejMWT.src=sejMWTs;document.getElementById(\'sdjMWT\').appendChild(sejMWT)",1)</script><noscript><div style="display:inline"><a href="<?php echo LINK_PATH;?>http://www.providesupport.com?messenger=nextagetech">Chat Support</a></div></noscript>
<!-- END ProvideSupport.com Graphics Chat Button Code --></div>
    <div class="headerRight">
    <input name="" type="image" src="images/registerBtn.png" border="0"  align="right" class="regBtn" onclick="javascript:window.location=\'register.php\';"><br />
    <div class="topmenu">
       <div class="cart"><strong><a href="<?php echo LINK_PATH;?>'.DR_ROOT.'cart.php">Shopping Cart</a></strong></div>
        
      </div>
    </div>
</div>

<div class="bodyContaner">
<div class="bodyContanerTop"></div>
<div class="bodyInner">

<div class="menuContaner">
<div class="navouter">
<div id="navcontainer">
        <ul id="navlist">
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'index.php">Home</a></li>
          <li id="active"><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'all-categories.php">Exams</a></li>
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'licensing.php">Corporate Licensing</a></li>     
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'guarantee.php">Guarantee</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'affiliates.php">Affiliates</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'faq.php">FAQs</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'aboutus.php">About Us</a></li>      
          <li><a href="<?php echo LINK_PATH;?>'. DR_ROOT.'contact.php">Contact Us</a></li>
        </ul>
      </div>
</div>
<div class="serchCont">
<form name="search_form" method="post" action="'. DR_ROOT.'exam.php"><input type="text" class="searchFIld" value="Search" name="search_keyword" onfocus="blank(this)" onblur="unblank(this)"> 
<a href="javascript:void(0);" onclick="document.search_form.submit();"><img src="<?php echo LINK_PATH;?>images/search.jpg" border="0" align="top" /></a></form></div>
</div>
<div class="bodyData">';
$tab .='<div class="leftContaner"><div class="leftHead">
    <h3>Our Vendors </h3>
  </div>
  <div id="button">
    <ul>';
    $rs=$dbh2->Query("select * from ".TB_CATEGORY." where fld_parentId='0' order by fld_categoryName asc");
    $stpos = 0;
	while($row=$dbh2->FetchRow($rs)){
		$tab .='<li><a href="<?php echo LINK_PATH;?>'.DR_ROOT.$ObjGen->replacespace($row['fld_categoryName']).FILES_EXT.'.html">'. $row[fld_categoryName] .'</a></li>';
	}

    $tab .='</ul>
  </div>
</div>';
    $tab .='<div class="rightContaner">
	<div><a href="<?php echo LINK_PATH;?>'.$ObjGen->replacespace(trim($catName)).FILES_EXT.'.html">'.trim($catName).'</a> > <a href="<?php echo LINK_PATH;?>'.$ObjGen->replacespace(trim($subcatName)).FILES_EXT.'.html">'.trim($subcatName).'</a> > '.trim($larr_exam[$im][fld_examCode]).' Exam</div>
 <p>'.$larr_exam[$im]['fld_examTitle'].'</p>
 <form name="examform" method="post" action="'.DR_ROOT."shopCart.php".'">
		<input type="hidden" name="examId" value="'.$larr_exam[$im]['fld_productId'].'">
		<input type="hidden" name="catId" value="'.$larr_exam[$im]['fld_categoryIdNo'].'">
		<input type="hidden" name="quantity" value="1">
		<input type="hidden" name="action" value="add">
 <div class="valuPackMan">
    <div class="valuPacList"><div style="float:left;"><div><img src="<?php echo LINK_PATH;?>images/book.png" /></div><div style="padding-left:90px; font-family:Georgia;font-size:40px;">$'.$larr_exam[$im]['fld_examFee'].'</div></div>
      <h1>Product Description</h1>
	  <div><strong>Exam Number/Code : </strong> '.trim($larr_exam[$im][fld_examCode]).'</div>
	  <div>&nbsp;</div>
	  <div><strong>Exam Name : </strong> '.$larr_exam[$im]['fld_examTitle'].'</div>
	  <div>&nbsp;</div>
	  <div><strong>Release / Update Date : </strong> '.$ObjGen->MySqltoTextual($larr_exam[$im]['fld_examDate']).'</div>
	  <div>&nbsp;</div>
      <div>'.trim($larr_exam[$im]['fld_examShortDesc']).'</div>
	  <div>&nbsp;</div>
      <ul>';
		if(trim($larr_exam[$im]['fld_examQAdemoFile'])!="" or trim($larr_exam[$im]['fld_examStudyGuidedemoFile'])!="" or trim($larr_exam[$im]['fld_examTestEnginedemoFile'])!="" or trim($larr_exam[$im]['fld_examAudioGuidedemoFile'])!=""){
			$tab .='<li><strong>Free Demo</strong><br /><span style="color:#000; font-size:12px;">CertArea.com offers free demo for '.trim($larr_exam[$im]['fld_examCode']).' exam ('.$larr_exam[$im]['fld_examTitle'].'). You can check out the interface, question quality and usability of our practice exams before you decide to buy it.</span>';
		}
      $tab .='</ul>';

$tab .='</div>
    <p class="valBtm">&nbsp;</p>
    <div style="float:left;" align="center">';
	if(trim($larr_exam[$im]['fld_examQAdemoFile'])!="" or trim($larr_exam[$im]['fld_examStudyGuidedemoFile'])!="" or trim($larr_exam[$im]['fld_examTestEnginedemoFile'])!="" or trim($larr_exam[$im]['fld_examAudioGuidedemoFile'])!=""){
	$tab .="<a href=\"demo.php?exid=".$larr_exam[$im]['fld_productId']."\"><img src=\"images/demo.png\" border=\"0\"></a>&nbsp;";
}
	$tab .='<input type="image" src="images/add_cart.png" /></div>
  </div>
 </form>';
  $rspack=$dbh2->Query("select pe.fld_packIdNo, p.fld_PackCode, p.fld_PackName, p.fld_PackFee, p.fld_PackEdition from ".TB_PACKAGE_EXAMS." pe inner join ".TB_PACKAGE." p on pe.fld_packIdNo=p.fld_PackId where pe.fld_productIdNo='".$larr_exam[$im]['fld_productId']."' order by pe.fld_packIdNo asc");
  if(mysql_num_rows($rspack)) {
	 while($rowpack=mysql_fetch_array($rspack)) {
		 $rsparent=$dbh2->Query("select fld_parentId from ".TB_CATEGORY." where fld_categoryId='".$larr_exam[$im]['fld_categoryIdNo']."'");
		 $rowparent=mysql_fetch_assoc($rsparent);
		 if($rowparent['fld_parentId']=='0') {
		 $rspcat=$dbh2->Query("select * from ".TB_PACK_CATEGORY." where fld_packId='".$rowpack['fld_packIdNo']."' and fld_categoryId<>'".$larr_exam[$im]['fld_categoryIdNo']."'");
		 } else {
			 $rspcat=$dbh2->Query("select * from ".TB_PACK_CATEGORY." where fld_packId='".$rowpack['fld_packIdNo']."' and fld_categoryId<>'".$larr_exam[$im]['fld_categoryIdNo']."' and fld_categoryId<>'".$rowparent['fld_parentId']."'");
		 }
		 if(!mysql_num_rows($rspcat)) {
		 $rspexam=$dbh2->Query("select e.fld_productId, e.fld_examTitle, e.fld_examFee, e.fld_examShortDesc from ".TB_PACKAGE_EXAMS." pe inner join ".TB_EXAMS." e on pe.fld_productIdNo=e.fld_productId where pe.fld_packIdNo='".$rowpack['fld_packIdNo']."' order by pe.fld_productIdNo asc");
		 if(mysql_num_rows($rspexam)<=5) {
		 $tab .='<form name="examform'.$rowpack['fld_packIdNo'].'" method="post" action="'.DR_ROOT."shopCart.php".'">
		<input type="hidden" name="packId" value="'.$rowpack['fld_packIdNo'].'">
		<input type="hidden" name="type" value="bundle">
		<input type="hidden" name="catId" value="'.$rowpack['fld_categoryIdNo'].'">
		<input type="hidden" name="quantity" value="1">
		<input type="hidden" name="action" value="add">
 <div class="valuPackMan">
    <div class="valuPacList"> <img src="<?php echo LINK_PATH;?>images/book.png" />
      <h1>'.substr($rowpack['fld_PackName'],0,25).'</h1>
      <ul>';
	  
	  $totexamfee=0;
	  while($rowpexam=mysql_fetch_array($rspexam)) {
        $tab .='<li><strong>'.substr($rowpexam['fld_examTitle'],0,38).'</strong><br />
          '.substr($rowpexam['fld_examShortDesc'],0,40).'
          <p>$'.$rowpexam['fld_examFee'].'</p>
        </li>';
		$totexamfee +=$rowpexam['fld_examFee'];
	  }
      $tab .='</ul>';
		$feedifference=$totexamfee-$rowpack['fld_PackFee'];
$tab .='</div>
    <p style="margin-left:30px; width:180px;">Save $'.number_format($feedifference,2).' Now</p>
    <div align="center">';
	$tab .='<input type="image" src="images/add_cart.png" /></div>
  </div>
 </form>';
		 }
		 }
	 }
  }
 
 $tab .='<div>'.$templateTopDesc.'</div>
';     
$tab .='<div class="cartHead"><h4>All Featured Exams</h4></div>
<div class="catAll"><ul>'.$boxes1.'</ul></div>

<div class="cartHead"><h4>All Latest Exams</h4></div>
<div class="catAll"><ul>'.$boxes3.'</ul></div>
<form class="formclass" name="frm_tellAfirend" method=POST action="emailAction.php?action=tellafriend" onsubmit="return Tellchk();">
						<input type="hidden" name="hdnTellAFriend" value="true">
						<input type="hidden" name="hdnPage" value="'.$_SERVER['PHP_SELF'].'">
	<div class="topMargn" style="float:right;">
        <div class="dicVocher" align="right">Recomenned to a Friend :<br /><input name="" type="text" value="Friend Email Address"  onfocus="blank(this)" onblur="unblank(this)" /> 
        <input type="image" src="images/submit.png" width="95" height="26" align="absmiddle" /></div></form></div></div>';

$tab .='</div>
</div>
<div class="bodyContanerbotom"></div>
</div>

<div class="footerInner">
     <div class="newscontaner">
      <h4>What\'s in TroyTec</h4>
      <ul class="footerList">
                <li>Secure Site</li>
       <li> 100% Instant Download</li>
        <li>Providing Certifications Exams since 1997</li>
       <li> 24/7 Support</li>
        <li>Industry Leader</li>
      </ul>
    </div>
    
    <div class="newscontaner">
      <h4>Popular Products</h4>
      <ul class="footerList">
        <li>Cisco</li>
<li>Apple</li>
<li>Checkpoint</li>
<li>Avaya</li>
<li>CompTIA</li>
<li>ECCouncil</li>

      </ul>
    </div>
    
    <div class="newscontaner">
      <h4>Popular Exams</h4>
      <ul class="footerList">
        <li>9L0-621</li>
<li>MB7-840</li>
<li>640-803</li>
<li>JN0-101</li>
<li>JN0-643</li>
<li>650-473</li>

      </ul>
    </div>
    <div class="footrRight"></div>
     </div>
     <div class="footerLinks">
     TestKiller Copyright 2012 All Rights Reserved. The Registered TestKiller Trademark Is Used Exclusively Under Licence Agreement   
     </div>
</div>
</div>
</body></html>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7389997-2");
pageTracker._trackPageview();
} catch(err) {}</script>';
echo '<p>Writing file: '.$filename.'</p>';

$f = @fopen(DR_BASE_ROOT.$filename, "w");
$r = @fwrite($f, $tab);
fclose($f);

}

}
	}
}
?>