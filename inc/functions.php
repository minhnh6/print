<?php
// Functions
function ShowOptions($Catid, $Optid,$typrname) {
	$sqlcat="SELECT * FROM option_values WHERE type_id='".$Optid."'";
	$rescat=mysql_query($sqlcat);
	$check=0;
	$SelId=strtolower(trim($typrname));
	$SelId=str_replace(' ','_',$SelId);
	while($rowcat=mysql_fetch_assoc($rescat)){
		$sqlval="SELECT * FROM category_options WHERE cat_id='".$Catid."' AND option_value_id='".$rowcat['id']."'";
		$resval=mysql_query($sqlval);
		if(mysql_num_rows($resval)){
			if($check==0){
				echo '<h2>'.$typrname.':</h2>';
				echo '<select name="'.$SelId.'" id="'.$SelId.'" onchange="javascript:InstantPrice();">';
				$check=1;
			}
			echo '<option value="'.$rowcat['id'].'">'.$rowcat['name'].'</option>';	
		}
	}
		if($check==1){
			echo '</select>';
		}

}
function ShowType($Catid,$Pid=0) {
	$sqlcat="SELECT * FROM products WHERE (isseo='0' or id='".$pid."') and cat_id='".$Catid."'";
	$rescat=mysql_query($sqlcat);
	$check=0;
	if(mysql_num_rows($rescat)){
		echo '<select name="select_type" id="select_type" onchange="javascript:InstantPrice();">';
		while($rowcat=mysql_fetch_assoc($rescat)){
			echo '<option '.($rowcat['id']==$Pid?'selected="selected"':'').' value="'.$rowcat['id'].'">'.$rowcat['ptitle'].'</option>';	
		}
		echo '</select>';
	}
}

function check_eclub($email) {
	
	$xml = '<xmlrequest>
	<username>ziggiscoffee</username>
	<usertoken>515f94dfcf7b464337f0339da268da78cf7d7282</usertoken>
	<requesttype>subscribers</requesttype>
	<requestmethod>IsSubscriberOnList</requestmethod>
		<details>
			<Email>'.$email.'/Email>
			<List>233</List>
		</details>
	</xmlrequest>';
		
	$ch = curl_init('http://www.allcitysolutions.com/mailcp/xml.php');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
	$result = @curl_exec($ch);
	$xml_doc = simplexml_load_string($result);
	return $xml_doc;
/* 	$dataval = "";
	if ($xml_doc->data == 0) {
		$dataval = "0";
	} else {
		$dataval = "1";		
	} */

}

function add_eclub($email) {
	 $xmladd = '
	 <xmlrequest>
		<username>ziggiscoffee</username>
		<usertoken>515f94dfcf7b464337f0339da268da78cf7d7282</usertoken>
		<requesttype>subscribers</requesttype>
		<requestmethod>AddSubscriberToList</requestmethod>
		<details>
			<emailaddress>'.$email.'</emailaddress>
			<mailinglist>233</mailinglist>
			<format>html</format>
			<confirmed>yes</confirmed>
		</details>
	</xmlrequest>'; 
	
	$ch = curl_init('http://www.allcitysolutions.com/mailcp/xml.php');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xmladd);
	$result = @curl_exec($ch);
	$xml_doc = simplexml_load_string($result);
	if ($xml_doc->data == 0) {
		// Not Found
	} else {
		// Found
	}
}

function access_allowed($ip)
{
	$hosts = array (
		DEVELOPER_OFFICE,
		DEVELOPER_HOME,
		DEVELOPER_HOME2,
		DEVELOPER_DEV1,
		DEVELOPER_DEV2,		
		DESIGNER1,
		DESIGNER2,
		BRANDON,
		BRANDON2,
		BRANDON3
	);
	if ( ($ip == DEVELOPER_IP) || (array_key_exists('login', $_GET) && $_GET['login'] == DEVELOPER_LOGIN) )
		return 2;
	else
		return (in_array($ip, $hosts) ? 1 : 0);
}

function redirectToHTTPS()
{
  if($_SERVER['HTTPS']!="on")
  {
     $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
     header("Location:$redirect");
  }
}

function PageTitle($module='', $dbdata='', $title='') {
	$sqlsetting = "select * from settings";
	$ressetting = mysql_query($sqlsetting);
	$config_array = array();
	while($rowsetting = mysql_fetch_array($ressetting)) {
		$config_array[$rowsetting['configname']] = $rowsetting['configvalue'];
	}	
	
	if($module == 'cms') {
		$first = str_replace('%site%',$config_array['SiteName'],$config_array['SiteTitle']);
		$second = str_replace('%title%',stripslashes($dbdata),$first);
		echo $second;		
	}		
}

function FindContactText($string) {
	$result = str_replace('contact us','<a href="<?php echo LINK_PATH;?>/contact">contact us</a>',$string);
	$result2 = str_replace('Contact Us','<a href="<?php echo LINK_PATH;?>/contact">Contact Us</a>',$result);	
	$result3 = str_replace('CONTACT US','<a href="<?php echo LINK_PATH;?>/contact">CONTACT US</a>',$result2);		
	echo $result3;
}

function _make_url_clickable_cb($matches) {
	$ret = '';
	$url = $matches[2];
	if ( empty($url) )
		return $matches[0];
	// removed trailing [.,;:] from URL
	if ( in_array(substr($url, -1), array('.', ',', ';', ':')) === true ) {
		$ret = substr($url, -1);
		$url = substr($url, 0, strlen($url)-1);
	}
	return $matches[1] . "<a href=\"$url\" rel=\"nofollow\">$url</a>" . $ret;
}
function _make_web_ftp_clickable_cb($matches) {
	$ret = '';
	$dest = $matches[2];
	$dest = 'http://' . $dest;
	if ( empty($dest) )
		return $matches[0];
	// removed trailing [,;:] from URL
	if ( in_array(substr($dest, -1), array('.', ',', ';', ':')) === true ) {
		$ret = substr($dest, -1);
		$dest = substr($dest, 0, strlen($dest)-1);
	}
	return $matches[1] . "<a href=\"$dest\" rel=\"nofollow\">$dest</a>" . $ret;
}
function _make_email_clickable_cb($matches) {
	$email = $matches[2] . '@' . $matches[3];
	return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
}
function make_clickable($ret) {
	$ret = ' ' . $ret;
	// in testing, using arrays here was found to be faster
	$ret = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '_make_url_clickable_cb', $ret);
	$ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '_make_web_ftp_clickable_cb', $ret);
	$ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', '_make_email_clickable_cb', $ret);
	// this one is not in an array because we need it to run last, for cleanup of accidental links within links
	$ret = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $ret);
	$ret = trim($ret);
	return $ret;
}

function just_clean($string) {	
	// Replace other special chars
/* 	$specialCharacters = array('#' => '', '$' => '', '&' => '', '@' => '', '.' => '', 'Ä' => '', '+' => '', '=' => '', 'ß' => '');
	 
	while (list($character, $replacement) = each($specialCharacters)) {
	$string = str_replace($character, '-' . $replacement . '-', $string);
	}
 */	 
//	$string = strtr($string,"¿¡¬√ƒ≈? ·‚„‰Â“”‘’÷ÿÚÛÙıˆ¯»… ÀËÈÍÎ«ÁÃÕŒœÏÌÓÔŸ⁄€‹˘˙˚¸ˇ—Ò","AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn");	 // orig
//	$string = strtr($string,"¿¡¬√ƒ≈? ·‚„‰Â“”‘’÷ÿÚÛÙıˆ¯»… ÀËÈÍÎ«ÁÃÕŒœÏÌÓÔŸ⁄€‹˘˙˚¸ˇ—Ò","AAAAAAa aaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn");	
	 
	// Remove all remaining other unknown characters
//	$string = preg_replace('/[^a-zA-Z0-9-]/', '', $string);
	$string = str_replace("-"," ",$string);
	$string = str_replace(" - "," ", $string);
	$string = preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
	$string = preg_replace('/^[-]+/', '', $string);
	$string = preg_replace('/[-]+$/', '', $string);
	$string = preg_replace('/[-]{2,}/', '', $string);
	$string = strtolower($string);
	return $string;
}

function ShowSubMenu($callmenu,$mpid, $title) {
	$callmenu = just_clean($callmenu);
	$sqlsub = "select * from pages where isactive='1' and callname='".$callmenu."' and mpID='".$mpid."' ORDER BY orderby";
	$ressub = mysql_query($sqlsub) or die(mysql_error());
	$maincount = mysql_num_rows($ressub);
	$i = 0;
	// Old Font Color # 6A3106
	while($rowsub = mysql_fetch_array($ressub)) {
		$i++;
		if(strtolower(str_replace(" ","-",$rowsub['refname']))==$title) {
			echo '<li'.($i == $maincount?' class="last"':'').'><span class="Golden16" style="color: #753707;">'.stripslashes($rowsub['menuname']).'</span>></li>';
		} else {
			echo '<li'.($i == $maincount?' class="last"':'').'><a href="<?php echo LINK_PATH;?>'.INC_ROOT.''.$rowsub['callname'].'/'.strtolower(str_replace(" ","-",$rowsub['refname'])).'" class="Golden16">'.stripslashes($rowsub['menuname']).'</a></li>';
		}
	}
}

function ShowSubMenu2($callmenu, $title) {
	$callmenu = just_clean($callmenu);	
	$sqlsub = "select * from pages where isactive='1' and callname='".$callmenu."' ORDER BY orderby";
	$ressub = mysql_query($sqlsub) or die(mysql_error());
	$maincount = mysql_num_rows($ressub);
	$i = 0;
	while($rowsub = mysql_fetch_array($ressub)) {
		$i++;
		if(strtolower(str_replace(" ","-",$rowsub['refname']))==$title) {
			echo '<li'.($i == $maincount?' class="last"':'').'><span class="Golden16" style="color: #753707;">'.stripslashes($rowsub['name']).'</span></li>';
		} else {			
			echo '<li'.($i == $maincount?' class="last"':'').'><a href="<?php echo LINK_PATH;?>'.INC_ROOT.''.$rowsub['callname'].'/'.strtolower(str_replace(" ","-",$rowsub['refname'])).'" class="Golden16">'.stripslashes($rowsub['menuname']).'</a></li>';		
		}
	}
}

function displayCMS($headertitle, $content, $sidebar, $sidebarproperties) {
	$headertitle = stripslashes($headertitle);
	
	$showsideimages = '';
	$showsideimages .= (substr($sidebarproperties,0,1)=='1'?'<a href="<?php echo LINK_PATH;?>'.LINK_PATH.'community/photo-gallery"><img src="<?php echo LINK_PATH;?>'.IMG_PATH.'sidebar/photogallery.png" border="0" style="padding-bottom: 25px;"></a>':'');
	$showsideimages .= (substr($sidebarproperties,1,1)=='1'?'<a href="<?php echo LINK_PATH;?>'.LINK_PATH.'locations"><img src="<?php echo LINK_PATH;?>'.IMG_PATH.'sidebar/locationhours.png" border="0" style="padding-bottom: 25px;"></a>':'');
	$showsideimages .= (substr($sidebarproperties,2,1)=='1'?'<a href="<?php echo LINK_PATH;?>'.LINK_PATH.'shop/gift-cards"><img src="<?php echo LINK_PATH;?>'.IMG_PATH.'sidebar/giftcards.png" border="0" style="padding-bottom: 25px;"></a>':'');
	$showsideimages .= (substr($sidebarproperties,3,1)=='1'?'<a href="<?php echo LINK_PATH;?>#"><img src="<?php echo LINK_PATH;?>'.IMG_PATH.'sidebar/licensing.png" border="0" style="padding-bottom: 25px;"></a>':'');	
	$showsideimages .= (substr($sidebarproperties,4,1)=='1'?'<a href="<?php echo LINK_PATH;?>'.LINK_PATH.'locations"><img src="<?php echo LINK_PATH;?>'.IMG_PATH.'sidebar/drivethru.png" border="0" style="padding-bottom: 25px;"></a>':'');
	$showsideimages .= (substr($sidebarproperties,5,1)=='1'?'<a href="<?php echo LINK_PATH;?>'.LINK_PATH.'community/e-club"><img src="<?php echo LINK_PATH;?>'.IMG_PATH.'sidebar/eclub.png" border="0" style="padding-bottom: 25px;"></a>':'');	
	
	if($sidebar == 1) {		
		echo '<div class="block" style="width: 300px; padding-right: 20px;">'.$showsideimages.'</div>';
		echo '<div class="block" style="width: 580px;">';
		echo '<div class="Golden30" style="padding-bottom: 15px;"><img src="<?php echo LINK_PATH;?>'.INC_ROOT.'makeheader.php?text='.$headertitle.'"></div>';
		echo '<div class="White13content">';
		echo make_clickable(FindContactText(stripslashes($content)));
		echo '</div>';
		echo '</div>';
	} else if($sidebar == 2) {
		echo '<div class="block" style="width: 580px;">';
		echo '<div class="Golden30" style="padding-bottom: 15px;"><img src="<?php echo LINK_PATH;?>'.INC_ROOT.'makeheader.php?text='.$headertitle.'"></div>';
		echo '<div class="White13content">';
		echo make_clickable(FindContactText(stripslashes($content)));
		echo '</div>';
		echo '</div>';		
		echo '<div class="block" style="width: 300px; padding-left: 20px;">'.$showsideimages.'</div>';		
	} else {
		echo '<div class="block Golden30" style="padding-bottom: 15px; width: 900px;"><img src="<?php echo LINK_PATH;?>'.INC_ROOT.'makeheader.php?text='.$headertitle.'"></div>';
		echo '<div class="block White13content">';
		echo make_clickable(FindContactText(stripslashes($content)));
		echo '</div>';
	}
}

function CheckCouponExpires($expires, $notified, $active, $expireflag, $name, $id, $sendmail) {
//	$expires = $rowsponsor['expiredate'];
//	$notified = $rowsponsor['notified'];
//	$active = $rowsponsor['isactive'];
//	$expireflag = $rowsponsor['expires'];
//	$name = $rowsponsor['name'];
//	$id = $rowsponsor['id'];

	$notifytime = 1296000; // 15 days in seconds
	$now = time();
	$time_to_expire = $expires - $now;		
	
/* 	if($expires >= $now && $active = 1 && $expireflag = 1) {
		mysql_query("UPDATE coupons set notified=0 where id=$id");
	} */
	
	if($expireflag == 1 && $notified == 0) {			
		$expiredate = date('D M jS, Y', $expires);
		if($sendmail == "yes") {
			if($expires >= $now && $notifytime > $time_to_expire) {
				// Update Database, so duplicate notification won't be sent.
				mysql_query("UPDATE coupons set notified=1 where id=$id");
				// Send Notification
				$msg = "Hi,\n\nThis message was automatically generated by the web server to notify you of imminent coupon expiration.\n\n";
				$msg .= "The coupon \"$name\" will expire $expiredate.\n";					
				$msg .= "\nThank you.\n\n";
				$to = 'john@allcitysolutions.com';
				$subject = 'Coupon Expiration';
				$add_hdrs = "From: Web Server <web_server@allcitysolutions.com>\r\n";
				mail($to, $subject, $msg, $add_hdrs);				
			}
		}
		
		if($expires <= $now && $active = 1) {
			mysql_query("UPDATE coupons set isactive=0, notified=1 where id=$id");
			// Send Notification
			if($sendmail == "yes") {
				$msg = "Hi,\n\nThis message was automatically generated by the web server to notify you that the following coupon has been removed from the active coupon list.\n\n";
				$msg .= "The coupon $name expired $expiredate.\n";					
				$msg .= "\nThank you.\n\n";
				$to = 'john@allcitysolutions.com';
				$subject = 'Coupon Expiration';
				$add_hdrs = "From: Web Server <web_server@allcitysolutions.com>\r\n";
				mail($to, $subject, $msg, $add_hdrs);					
			}
		}
	}	
}

function ShowMenuItems($catid){ 
	$sqlsetting = "select * from settings";
	$ressetting = mysql_query($sqlsetting);
	$config_array = array();
	while($rowsetting = mysql_fetch_array($ressetting)) {
		$config_array[$rowsetting['configname']] = $rowsetting['configvalue'];
	}	
	
	$sqlmc=mysql_query("select * from menucats where id='$catid'");						
	$rowmc=mysql_fetch_assoc($sqlmc);
	if($catid == 1) {
		$catheader = stripslashes($config_array['MenuCat1']); 
	} else if($catid == 2) {
		$catheader = stripslashes($config_array['MenuCat2']); 
	} else if($catid == 3) {
		$catheader = stripslashes($config_array['MenuCat3']); 
	} else if($catid == 4) {
		$catheader = stripslashes($config_array['MenuCat4']); 
	} else if($catid == 5) {
		$catheader = stripslashes($config_array['MenuCat5']); 
	}
		
?>
<div class="block" style="width:500px;">
        <div class="menuboxtitle"><?php echo strtoupper($rowmc['dispname']); ?></div>
        <div class="menuboxtitlesmall DarkGolden18"><?php echo $catheader; ?></div>
        <div class="block" style="width:500px; height: 275px; padding-top:5px;">
		<?php
        $sqlur="select * from menu where catid='".$catid."' and isactive='1' order by orderby";
        $resur=mysql_query($sqlur);
		$num_rows = mysql_num_rows($resur);
		$splitcalc = ($num_rows / 2);
		$split = round($splitcalc);
        $t=0;
		if($catid == 4) { 
			$paddingval = "40px";
		} else if($catid == 5) {
			$paddingval = "60px";			
		} else {
			$paddingval = "5px";			
		}
        while($rowur=mysql_fetch_array($resur)) {
            if($t==0) {
                echo '<div class="block" style="width:250px;">';	
            }
			if($split>=7) {
				if($t==$split) {
					echo '</div><div class="block" style="width:250px;">';
				} 
			}
            if($t<$split) { 
				$camera = '';
				if($rowur['imagepath']) {
					$camera = '<a id="showmenuitem" href="'.$rowur['imagepath'].'"><img src="<?php echo LINK_PATH;?>'.IMG_PATH.'camera.png" border="0" /></a>';
				}
			?>
            <div class="menuboxlist">
              <div class="menuboxcontain">
                <div class="block"><?php echo stripslashes($rowur['name']); ?></div>
                <div class="block" style=" padding-left:10px;"><?php echo $camera; ?></div>
              </div>
              <div class="menuboxcontainsub">
			  <?php 
				$description = '';	
			  	if($rowur['description']) {
					$description = '('.stripslashes($rowur['description']).')';
				} else {
					$description = '';
				}
			   
			   echo $description; ?>
               </div>
            </div>            
            <?php } else { 
				$camera = '';
				if($rowur['imagepath']) {
					$camera = '<a id="showmenuitem" href="'.$rowur['imagepath'].'"><img src="<?php echo LINK_PATH;?>'.IMG_PATH.'camera.png" border="0" /></a>';
				}			
			?>
            <div class="menuboxlist">
              <div class="menuboxcontain">
                <div class="block"><?php echo stripslashes($rowur['name']); ?></div>
                <div class="block" style=" padding-left:10px;"><?php echo $camera; ?></div>
              </div>
              <div class="menuboxcontainsub">
			  <?php 
				$description = '';	
			  	if($rowur['description']) {
					$description = '('.stripslashes($rowur['description']).')';
				} else {
					$description = '';
				}
			   
			   echo $description; ?>              
              </div>
            </div>          
            <?php }
			$t++;
        }
        echo '</div>';
        ?>        
        </div>	
        <div class="menubottomtext"><?php echo $rowmc['bottomtext']; ?></div>
      </div>
      <div class="menuright">
        <div class="block1" style="padding:2px 1px 10px 0px;"><a href="<?php echo LINK_PATH;?>http://www.ziggiscoffee.com/pdf/menu.pdf" target="_blank"><img src="<?php echo LINK_PATH;?><?php echo IMG_PATH; ?>printpdf.png" class="print_menu" border="0" /></a> </div>
        <div style="float: right; width: 163px; clear:both; font-family:Tahoma, Geneva, sans-serif; font-size:11px; font-weight:none; color:#000;"><div align="left">Click <img src="<?php echo LINK_PATH;?><?php echo IMG_PATH; ?>camera.png" border="0" /> to view item photo.</div></div>
        <div class="block" style="width:100%; text-align:center; padding:<?php echo $paddingval; ?> 5px;"><img src="<?php echo LINK_PATH;?><?php echo IMG_PATH; ?><?php echo $rowmc['imagepath']; ?>" border="0" /></div>
      </div>        
<?php } ?>
<?php 

function phpCalander($mkdate){
	
	$curmonth=date('m',$mkdate);
	$curyear=date('Y',$mkdate);
	
	$selflag=0;
	if(date('Ym',$mkdate)==date('Ym', time())) {
		$todaydate=date('d',time());
		$selflag=1;
	}
	
	//next month
	$nextmonth=$curmonth;
	if($curmonth==12){
		$nextmonth=1;
		$nextyear=$curyear+1;
	} else{
		$nextmonth=$nextmonth+1;
		$nextyear=$curyear;	
	}
	$previousmonth=$curmonth;
	if($curmonth==1){
		$previousmonth=12;
		$previousyear=$curyear-1;
	}else{
		$previousmonth=$curmonth-1;
		$previousyear=$curyear;	
	}
	
	$curmonts=mktime(0,0,0,$curmonth,1,$curyear);
	$nextmonts=mktime(0,0,0,$nextmonth,1,$nextyear);
	
	$sqlts="select edatetype, eventdate, eventenddate from calendar where (eventdate>=".$curmonts." and eventdate<".$nextmonts.") or(eventenddate>=".$curmonts." and eventenddate<".$nextmonts.") and isactive='1'" ;
	$rests=mysql_query($sqlts) or die(mysql_error());
	$EventDatAR=array();
	while($rowts=mysql_fetch_array($rests)) {
		
		if($rowts['edatetype']=='D') {
			$totdays=ceil(($rowts['eventenddate']-$rowts['eventdate'])/86400);
			if(date("m",$rowts['eventdate'])!=$curmonth) {
				$stday=1;
				$totdays=date("j",$rowts['eventenddate'])-1;
			} else {
				$stday=date("j",$rowts['eventdate']);
			}
						
			for($i=$stday; $i<=$stday+$totdays;$i++) {
				$EventDatAR[$i]=$rowts['eventdate'];
			}
		} else {
			if($EventDatAR[date("j",$rowts['eventdate'])]=='') {
				$EventDatAR[date("j",$rowts['eventdate'])]=$rowts['eventdate'];
			} else if($EventDatAR[date("j",$rowts['eventdate'])]>$rowts['eventdate']) {
				$EventDatAR[date("j",$rowts['eventdate'])]=$rowts['eventdate'];
			}
		}
	}
$nextdate=strtotime($nextmonth.'/01/'.$nextyear);
$previousdate=strtotime($previousmonth.'/01/'.$previousyear);
$strday=date('w',$mkdate);
$totdays=date('t',$mkdate);

	echo '<div id="SmallCalTopDiv" style="background:url('.IMG_PATH.'calendar/smallcaltop.png) no-repeat; height:23px;width:196px; padding:8px 11px;">
        	<div class="block" style="width:20px; padding-top:4px;"><a href="<?php echo LINK_PATH;?>#" onclick="javascript:calanderMonth(\''.$previousdate.'\');"><img src="<?php echo LINK_PATH;?>'.IMG_PATH.'calendar/smallcalprev.png" border="0" /></a></div>
            <div class="block" style="width:155px; font-family:Georgia; font-size:20px; color:#FFF; text-align:center;">'.date('F, Y',$mkdate).'</div>
            <div class="block" style="width:20px; padding-top:4px;"><a href="<?php echo LINK_PATH;?>#" onclick="javascript:calanderMonth(\''.$nextdate.'\');"><img src="<?php echo LINK_PATH;?>'.IMG_PATH.'calendar/smallcalnext.png" border="0" /></a></div>
        </div>';
	echo '<div id="smallcalmain" style="background-color:#260801; width:218px; float:left;padding:1px 0px; margin-top:1px; ">
        	<div class="CalWeekDays" style="border-left:1px solid #260801;">S</div>
            <div class="CalWeekDays">M</div>
            <div class="CalWeekDays">T</div>
            <div class="CalWeekDays">W</div>
            <div class="CalWeekDays">T</div>
            <div class="CalWeekDays">F</div>
            <div class="CalWeekDays">S</div>';
    
for($i=0;$i<$strday;$i++){
	if ($i==0) {
		echo '<div class="CalDatesDiv" style="border-left:1px solid #2e0a01;">&nbsp;</div>';
	} else {
		echo '<div class="CalDatesDiv">&nbsp;</div>';
	}
}	
for($md=1;$md<=$totdays;$md++){
	if($strday%7==0){
		if($selflag==1 && $todaydate==$md) {
			echo '<div class="CalDatesDiv" style="border-left:1px solid #2e0a01; background-color:#2e0a01;"><a href="<?php echo LINK_PATH;?>'.INC_ROOT.'community/calendar">'.$md.'</a></div>';
		} else {
			if($EventDatAR[$md]!='') {
				$datetopass=mktime(0,0,0,$curmonth,$md,$curyear);
				echo '<div class="CalEventDiv" style="border-left:1px solid #2e0a01;"><a href="<?php echo LINK_PATH;?>'.INC_ROOT.'community/calendar/1/'.$EventDatAR[$md].'">'.$md.'</a></div>';
			} else {
				echo '<div class="CalDatesDiv" style="border-left:1px solid #2e0a01;">'.$md.'</div>';
			}
		}
		$strday=0;
	} else {
		if($selflag==1 && $todaydate==$md) {
			echo '<div class="CalDatesDiv" style="background-color:#2e0a01;"><a href="<?php echo LINK_PATH;?>'.INC_ROOT.'community/calendar" style="color:#FFF;">'.$md.'</a></div>';
		} else {
			if($EventDatAR[$md]!='') {
				$datetopass=mktime(0,0,0,$curmonth,$md,$curyear);
				echo '<div class="CalEventDiv"><a href="<?php echo LINK_PATH;?>'.INC_ROOT.'community/calendar/1/'.$EventDatAR[$md].'">'.$md.'</a></div>';
			} else {
				echo '<div class="CalDatesDiv">'.$md.'</div>';
			}
		}
	}
	$strday++;
}	
for($i=$strday;$i<7;$i++){
	if ($i==0) {
		echo '<div class="CalDatesDiv" style="border-left:1px solid #c7c1b0;">&nbsp;</div>';
	} else {
		echo '<div class="CalDatesDiv">&nbsp;</div>';
	}
}
	
	echo '</div>';
}
?>