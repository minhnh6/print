<?php 
session_start();
$demo = new SortableExample();
if($_POST["hIDConfirm"]=="Delete"){	
	if($_POST["checkAll"] != ""){
		foreach($_POST["checkAll"] as $ordID){
			mysql_query("DELETE tbl_order_details,tbl_order FROM tbl_order_details LEFT JOIN tbl_order ON tbl_order_details.fld_orderIdNo =tbl_order.fld_orderIdNo WHERE tbl_order.fld_orderIdNumber = '".$ordID."'");	
//			mysql_query("DELETE FROM tbl_order_details WHERE fld_orderIdNumber='".$ordID."'");
//			mysql_query("DELETE FROM tbl_order WHERE fld_orderIdNumber='".$ordID."'");				
		}
	}
}
if($_POST["updteStatus"] == "Update Status"){
	foreach($_POST["checkAll"] as $ordID){
//		echo "UPDATE tbl_order SET fld_orderStatus='".$_POST["slctStatus_".$ordID]."' WHERE fld_orderIdNumber = '".$ordID."'";
		mysql_query("UPDATE tbl_order SET fld_orderStatus = '".$_POST["slctStatus_".$ordID]."' WHERE fld_orderIdNumber = '".$ordID."'");
	}
}
if($_GET["Submit"] == "Search"){
	$perpage=20;
	if($_GET["page"] ==""){
		$page=1;
	}else{
		$page=$_GET["page"];
	}
	if($page<1){
		$page=1;
	}
	$starter = (($page -1)*$perpage);
	$sql = "";
	switch($_GET["radDate"]){
	case 1:
		$sql .= "";
		break;
	case 2:	
		$month=date('n',time());
		$year=date('Y',time());
		$monthstart=date('Y-m-1 00:00:00');
		$sql .= "WHERE fld_orderDate >='".$monthstart."'";
		break;
	case 3:
		$weekday=date('w',time());
		$thisweek = mktime(0,0,0,date("m"),date("d")-$weekday,date("Y"));
		$weekstart=date('Y-m-d 00:00:00', $thisweek);
		$sql .= "WHERE fld_orderDate >='".$weekstart."'";
		break;
	case 4:
		$todaydate=date('Y-m-d 00:00:00');
		$sql .= "WHERE fld_orderDate >='".$todaydate."'";
		break;
	case 5:
		$datefrom=$_GET["year1"].'-'.$_GET["month1"].'-'.$_GET["day1"].' 00:00:00';
		$dateto=$_GET["year2"].'-'.$_GET["month2"].'-'.$_GET["day2"].' 11:59:59';
		$sql .= "WHERE fld_orderDate >='".$datefrom."' AND fld_orderDate <='".$dateto."'";
		break;
	default:
	$sql .= "";
	}
	if ($_GET['products']!='') {
	if ($sql!='') {
	$sql.=" and fld_orderIdNumber in (select fld_orderIdNumber FROM tbl_order_details where premadeid='".$_GET['products']."') ";
	} else {
	$sql.=" WHERE fld_orderIdNumber in (select fld_orderIdNumber FROM tbl_order_details where premadeid='".$_GET['products']."') ";
	}
	}
	if ($sql!='') {
	$sql.=" and fld_orderStatus<>'Failed' and fld_orderStatus<>'Declined'  ";
	} else {
	$sql.=" WHERE fld_orderStatus<>'Failed' and fld_orderStatus<>'Declined'  ";
	}
	$sqlSrch = "";
	switch ($_GET["sort"]){
	case 1:
	$sqlSrch.= " ORDER BY fld_orderIdNumber";
	break;
	case 2:
	$sqlSrch.= " ORDER BY fname";
	break;
	case 3:
	$sqlSrch.= " ORDER BY fld_orderDate";
	break;
	case 4:
	$sqlSrch.= " ORDER BY fld_totalPrice";
	break;
	case 5:
	$sqlSrch.= " ORDER BY fld_orderIdNumber desc";
	break;
	case 6:
	$sqlSrch.= " ORDER BY fname desc";
	break;
	case 7:
	$sqlSrch.= " ORDER BY fld_orderDate DESC";
	break;
	case 8:
	$sqlSrch.= " ORDER BY totalamount DESC";
	break;
	default:
	$sqlSrch.= " ORDER BY fld_orderDate DESC";
	}
	$result=mysql_query("SELECT * FROM tbl_order  ".$sql."  ".$sqlSrch." limit $starter,$perpage");
	$result2=mysql_query("SELECT count(tbl_order.fld_orderIdNumber) as cnt FROM tbl_order ".$sql)or die(mysql_error());
	if(mysql_num_rows($result2)) {
	$countrow = mysql_fetch_assoc($result2);
	$countRows =$countrow["cnt"];
	mysql_free_result($result2);
	} else {
	$countRows=0;
	}
	$totalPages= ceil($countRows/$perpage);
	if($totalPages==0){$totalPages=1;}
	$flgSrckRsult = 1;
}		
?>
<script type="text/javascript" src="../js/thickbox.js"></script>
<link href="../css/thickbox.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
function disp_confirm(delid){
var r=confirm("Are you sure you want to delete this Product?\nThis action cannot be restored!");
if (r==true){
window.location.href='?p=<?php echo $_GET['p']; ?>&do=<?php echo $_GET['do']; ?>&a=delete&id='+delid;
}else{
return false;
}
}
function CheckBoxAll(len){
	if(document.getElementById('AllChecked').checked){
		checkAll(len);
	}else{
		UncheckAll(len)
	}
}
function checkAll(len){
	for(i=0; i < len ; i++){
		document.getElementById("checkAll_"+ i).checked = true;
	}
}
function UncheckAll(len){
	for(i=0; i < len ; i++){
		document.getElementById("checkAll_"+ i).checked = false;
	}
}
function ruSure(){
	if(confirm("Are you sure you want delete selected Order from the list?\n\nIf you click Ok all selected Order will be delete.")){
		document.frmSrchResult.hIDConfirm.value="Delete";
		document.frmSrchResult.submit();
	}
}
function enable(id){
	if(id==5){
		document.getElementById('month1').disabled = false;
		document.getElementById('month2').disabled = false;
		document.getElementById('day1').disabled = false;
		document.getElementById('day2').disabled = false;
		document.getElementById('year1').disabled = false;
		document.getElementById('year2').disabled = false;
	}else{
		document.getElementById('month1').disabled = true;
		document.getElementById('month2').disabled = true;
		document.getElementById('day1').disabled = true;
		document.getElementById('day2').disabled = true;
		document.getElementById('year1').disabled = true;
		document.getElementById('year2').disabled = true;
	}
}
</script>
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
<table align="center" width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div style="padding-left: 3px; padding-top: 5px; height: 30px;"><?php echo $successmessage; ?></div></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2" valign="top">
                <table width="650" border="0" align="center" cellpadding="2" cellspacing="1">
                    <tr>
                        <td height="5" colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="adminheader" colspan="2">Search Orders </td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr></td>
                    </tr>
                    <tr>
                      <td colspan="2"><table wIdth="100%" height="98" border="0" cellspacing="0">
                          <tr>
                            <td height="24" colspan="2" align="left" valign="mIddle">
                            <form name="frmSrch" action="" method="get">
                                <table width="100%" border="0" cellpadding="2" cellspacing="1" class="storeStpTbl" >
                                  <tr>
                                    <td colspan="2" class="admlsttxt"> Filling the whole form is not obligatory.<br>
                                      Specify only the search parameters you need and click on 'Search'.
                                      <input type="hidden" name="section" value="<?php echo $_GET['section'];?>" />
                                      <input type="hidden" name="do" value="<?php echo $_GET['do'];?>" /></td>
                                  </tr>
                                  <tr>
                                    <td width="27%" valign="top" class="admlsttxt">Date period: </td>
                                    <td width="73%" class="admlsttxt"><input name="radDate" type="radio" value="1" <?php if(!isset($_GET["radDate"]) || $_GET["radDate"] == 1) echo 'checked="checked"';?> onClick="enable(1)">
                                      All dates
                                      <input name="radDate" type="radio" value="2" <?php if($_GET["radDate"] == 2) echo 'checked="checked"';?> onClick="enable(2)">
                                      This month
                                      <input name="radDate" type="radio" value="3" <?php if($_GET["radDate"] == 3) echo 'checked="checked"';?> onClick="enable(3)">
                                      This week
                                      <input name="radDate" type="radio" value="4" <?php if($_GET["radDate"] == 4) echo 'checked="checked"';?> onClick="enable(4)">
                                      Today<br>
                                      <input id="SelectedDate" name="radDate" type="radio" value="5" <?php if($_GET["radDate"] == 5) echo 'checked="checked"';?> onClick="enable(5)">
                                      Specify the period below </td>
                                  </tr>
                                  <tr>
                                    <td class="admlsttxt">Order date from: </td>
                                    <td><select name="month1" id="month1" disabled="disabled" class="formfields">
                                        <option value="1" <?php if($_GET["month1"]=="1") echo 'selected';?>>January</option>
                                        <option value="2" <?php if($_GET["month1"]=="2") echo 'selected';?>>February</option>
                                        <option value="3" <?php if($_GET["month1"]=="3") echo 'selected';?>>March</option>
                                        <option value="4" <?php if($_GET["month1"]=="4") echo 'selected';?>>April</option>
                                        <option value="5" <?php if($_GET["month1"]=="5") echo 'selected';?>>May</option>
                                        <option value="6" <?php if($_GET["month1"]=="6") echo 'selected';?>>June</option>
                                        <option value="7" <?php if($_GET["month1"]=="7") echo 'selected';?>>July</option>
                                        <option value="8" <?php if($_GET["month1"]=="8") echo 'selected';?>>August</option>
                                        <option value="9" <?php if($_GET["month1"]=="9") echo 'selected';?>>September</option>
                                        <option value="10" <?php if($_GET["month1"]=="10") echo 'selected';?>>October</option>
                                        <option value="11" <?php if($_GET["month1"]=="11") echo 'selected';?>>November</option>
                                        <option value="12" <?php if($_GET["month1"]=="12") echo 'selected';?>>December</option>
                                      </select>
                                      <select name="day1" id="day1" disabled="disabled" class="formfields">
                                        <?php for($i=1; $i <=31; $i++){?>
                                        <option <?php echo $i; ?> <?php if($_GET["day1"] == $i) echo 'selected';?>><?php echo $i; ?></option>
                                        <?php } ?>
                                      </select>
                                      <select name="year1" id="year1" disabled="disabled" class="formfields">
                                        <option value="<?php echo date("Y")-1?>" <?php if($_GET["year1"] == date("Y")-1) echo 'selected';?>><?php echo date("Y")-1?></option>
                                        <option value="<?php echo date("Y")?>" <?php if($_GET["year1"] == date("Y")) echo 'selected';?>><?php echo date("Y")?></option>
                                        <option value="<?php echo date("Y")+1?>" <?php if($_GET["year1"] == date("Y")+1) echo 'selected';?>><?php echo date("Y")+1?></option>
                                      </select></td>
                                  </tr>
                                  <tr>
                                    <td class="admlsttxt">Order date through: </td>
                                    <td><select name="month2" id="month2" disabled="disabled" class="formfields">
                                        <option value="1" <?php if($_GET["month2"] == "1") echo 'selected';?>>January</option>
                                        <option value="2" <?php if($_GET["month2"] == "2") echo 'selected';?>>February</option>
                                        <option value="3" <?php if($_GET["month2"] == "3") echo 'selected';?>>March</option>
                                        <option value="4" <?php if($_GET["month2"] == "4") echo 'selected';?>>April</option>
                                        <option value="5" <?php if($_GET["month2"] == "5") echo 'selected';?>>May</option>
                                        <option value="6" <?php if($_GET["month2"] == "6") echo 'selected';?>>June</option>
                                        <option value="7" <?php if($_GET["month2"] == "7") echo 'selected';?>>July</option>
                                        <option value="8" <?php if($_GET["month2"] == "8") echo 'selected';?>>August</option>
                                        <option value="9" <?php if($_GET["month2"] == "9") echo 'selected';?>>September</option>
                                        <option value="10" <?php if($_GET["month2"] == "10") echo 'selected';?>>October</option>
                                        <option value="11" <?php if($_GET["month2"] == "11") echo 'selected';?>>November</option>
                                        <option value="12" <?php if($_GET["month2"] == "12") echo 'selected';?>>December</option>
                                      </select>
                                      <select name="day2" id="day2" disabled="disabled" class="formfields">
                                        <?php for($i=1; $i <=31; $i++){?>
                                        <option <?php echo $i; ?> <?php if($_GET["day2"] == $i) echo 'selected';?>><?php echo $i; ?></option>
                                        <?php } ?>
                                      </select>
                                      <select name="year2" id="year2" disabled="disabled" class="formfields">
                                        <option value="<?php echo date("Y")-1?>" <?php if($_GET["year2"] == date("Y")-1) echo 'selected';?>><?php echo date("Y")-1?></option>
                                        <option value="<?php echo date("Y")?>" <?php if($_GET["year2"] == date("Y")) echo 'selected';?>><?php echo date("Y")?></option>
                                        <option value="<?php echo date("Y")+1?>" <?php if($_GET["year2"] == date("Y")+1) echo 'selected';?>><?php echo date("Y")+1?></option>
                                      </select></td>
                                  </tr>
                                  <tr>
                                    <td class="admlsttxt">Search By Products Ordered:</td>
                                    <td class="admlsttxt"><select name="products" id="products" class="formfields">
                                        <option value="" selected>All Products</option>
                                        <?php    
$sqlpro="SELECT id,ptitle FROM products group by ptitle order by ptitle";
$resultpro =mysql_query($sqlpro) or die(mysql_error());
while($rowpro =mysql_fetch_array($resultpro))
{?>
                                        <option value="<?php echo $rowpro['id']?>" <?php echo($rowpro['ptitle']==$_GET['products']?'selected="selected"':'');?>><?php echo $rowpro['ptitle']?></option>
                                        <?php
}		
?>
                                      </select></td>
                                  </tr>
                                  <tr>
                                    <td class="admlsttxt">&nbsp;</td>
                                    <td class="admlsttxt"><input name="Submit" type="submit" class="btn" value="Search"></td>
                                  </tr>
                                </table>
                              </form></td>
                          </tr>
                          <tr>
                            <td><?php if($flgSrckRsult){ ?>
                              <div><?php echo '<font face="Arial" color="#006600" size="2"><b>'.$infoMSG.'</b></font>'; $infoMSG="";?></div>
                              <table width="100%" border="0" cellpadding="3" cellspacing="1" class="storeStpTbl" >
                                <form name="frmSrchResult" method="post" action="<?php echo "?section=shop&do=orders&page=0".$_GET['page']."&radDate=".$_GET["radDate"]."&month1=".$_GET["month1"]."&day1=".$_GET["day1"]."&year1=".$_GET["year1"]."&month2=".$_GET["month2"]."&day2=".$_GET["day2"]."&year2=".$_GET["year2"]."&Submit=".$_GET["Submit"];?>">
                                  <input type="hidden" name="section" value="shop" />
                                  <input type="hidden" name="do" value="orders" />
                                  <tr>
                                    <td colspan="7" align="right" class="admlsttxt" style="padding-right:15px;padding-top:5px">&nbsp;</td>
                                  </tr>
                                  <tr style="padding-bottom:20px">
                                    <td colspan="7" class="admlsttxt">Result pages: <font color="#000000">
                                      <?php if($page<>1){ ?>
                                      <a href="<?php echo "?section=shop&do=orders&page=1&radDate=".$_GET["radDate"]."&month1=".$_GET["month1"]."&day1=".$_GET["day1"]."&year1=".$_GET["year1"]."&month2=".$_GET["month2"]."&day2=".$_GET["day2"]."&year2=".$_GET["year2"]."&Submit=".$_GET["Submit"];?>" style="color:#9fcf6f; text-decoration:underline;">First Page</a>
                                      <?php } ?>
                                      &nbsp;&nbsp;
                                      <?php if ($page>1){ ?>
                                      <a href="<?php echo "?section=shop&do=orders&page".($page-1)."&radDate=".$_GET["radDate"]."&month1=".$_GET["month1"]."&day1=".$_GET["day1"]."&year1=".$_GET["year1"]."&month2=".$_GET["month2"]."&day2=".$_GET["day2"]."&year2=".$_GET["year2"]."&Submit=".$_GET["Submit"];?>" style="color:#9fcf6f; text-decoration:underline;">Previous</a> &nbsp;&nbsp;&nbsp;
                                      <?php }
$start =1;
$ends =  $totalPages;
for ($i=$start;$i<=$ends;$i++){
if ($i== $page){?>
                                      <?php echo $i;?>&nbsp;&nbsp;
                                      <?php }else{ ?>
                                      <a href="<?php echo "?section=shop&do=orders&page".$i."&radDate=".$_GET["radDate"]."&month1=".$_GET["month1"]."&day1=".$_GET["day1"]."&year1=".$_GET["year1"]."&month2=".$_GET["month2"]."&day2=".$_GET["day2"]."&year2=".$_GET["year2"]."&Submit=".$_GET["Submit"];?>" style="color:#9fcf6f; text-decoration:underline;"><?php echo $i; ?></a>&nbsp;&nbsp;
                                      <?php 
}
}
if($totalPages > $page){ ?>
                                      &nbsp;&nbsp;&nbsp; <a href="<?php echo "?section=shop&do=orders&page".($page+1)."&radDate=".$_GET["radDate"]."&month1=".$_GET["month1"]."&day1=".$_GET["day1"]."&year1=".$_GET["year1"]."&month2=".$_GET["month2"]."&day2=".$_GET["day2"]."&year2=".$_GET["year2"]."&Submit=".$_GET["Submit"];?>" style="color:#9fcf6f; text-decoration:underline;">Next</a>
                                      <?php } ?>
                                      &nbsp;&nbsp;
                                      <?php if ($page <> $totalPages){ ?>
                                      <a href="<?php echo "?section=shop&do=orders&page".($totalPages)."&radDate=".$_GET["radDate"]."&month1=".$_GET["month1"]."&day1=".$_GET["day1"]."&year1=".$_GET["year1"]."&month2=".$_GET["month2"]."&day2=".$_GET["day2"]."&year2=".$_GET["year2"]."&Submit=".$_GET["Submit"];?>" style="color:#9fcf6f; text-decoration:underline;">Last Page</a>
                                      <?php } ?>
                                      </font></td>
                                  </tr>
                                  <tr>
                                    <td width="6%" class="admlsthead" style="text-align:center;"><input id="AllChecked" name="AllChecked" type="checkbox" onclick="javascript:CheckBoxAll(<?php echo mysql_num_rows($result) ?>);" value=""></td>
                                    <td width="9%" class="admlsthead"><strong>Order</strong></td>
                                    <td width="26%" class="admlsthead"><strong>Customer Name </strong></td>
                                    <td width="17%" class="admlsthead"><strong>Order Date </strong></td>
                                    <td width="15%" class="admlsthead"><strong>Order Status </strong></td>
                                    <td width="14%" align="center" class="admlsthead"><strong>Price</strong></td>
                                    <td width="11%" class="admlsthead"><strong>Action</strong></td>
                                  </tr>
                                    <tr>
                                        <td colspan="7"><hr></td>
                                    </tr>
                                  <?php
									if(mysql_num_rows($result)) {
									for($j=0; $j<mysql_num_rows($result); $j++){
									mysql_data_seek($result, $j);
									$row = mysql_fetch_assoc($result);
									$chkdisres=mysql_query("select * from products where ptitle='".$row['product']."'") or die(mysql_error());
									$chkdisrow=mysql_fetch_array($chkdisres);
									$nameres=mysql_query("select fld_fullName from tbl_users where fld_userId='".$row['fld_userIdNo']."'") or die(mysql_error());
									$namerow=mysql_fetch_array($nameres);
									if(fmod($j,2) == 0){
									$bgColor = 'bgcolor="#FFFFFF"'; 
									}else{ 
									$bgColor = 'bgcolor="#EEEEEE"';
									}
									?>
                                  <tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
                                    <td width="6%" align="center" class="admlsttxt"><input name="checkAll[]" type="checkbox" value="<?php echo $row["fld_orderIdNumber"];?>" id="checkAll_<?php echo $j;?>"></td>
                                    <td width="9%" class="admlsttxt"><a href="<?php echo "index.php?section=shop&do=orderdetail&fld_orderIdNumber=".$row['fld_orderIdNumber'];?>" style="color:#666666; text-decoration:underline;">#<?php echo $row["fld_orderIdNumber"];?></a></td>
                                    <td class="admlsttxt"><?php echo $namerow["fld_fullName"];?></td>
                                    <td class="admlsttxt"><?php echo substr($row["fld_orderDate"],0,10); ?></td>
                                    <td class="admlsttxt">
                            <select name="slctStatus_<?php echo $row["fld_orderIdNumber"];?>" class="formfields" style="padding:1px 2px;">
                                <option value="Pending" <?php if($row["fld_orderStatus"] == "Pending") echo 'selected';?>>Pending</option>
                                <option value="Completed" <?php if($row["fld_orderStatus"] == "Completed") echo 'selected';?>>Completed</option>
                            </select>
                                      </td>
                                    <td width="14%" align="center" class="admlsttxt">$<?php echo number_format(($row["fld_totalPrice"]),2); ?></td>
                                    <td width="11%"  class="admlsttxt"><a href="<?php echo "index.php?section=shop&do=orderdetail&orderno=".$row['fld_orderIdNumber'];?>"><img src="images/icon_view.png" border="0" /></a><a href="javascript:void(0);" onclick="ShowInvoice(<?php echo $row['fld_orderIdNumber'];?>);"><img src="images/print.png" border="0" /></a>
                                      <?php
if($row['fld_orderStatus']=='Shipped') {
?>
                                      <a href="shop_trackinfo.php?orderid=<?php echo $row['fld_orderIdNumber'];?>&modal=true&width=320&height=120" class="thickbox"><img src="images/icon_track.gif" border="0" title="<?php echo ($row['trackno']==''?'Set Tracking':'Edit Tracking');?>" /></a>
                                      <?php
}
?></td>
                                  </tr>
                                  <input type="hidden" name="hidValue[]" value="<?php echo $row["fld_orderIdNumber"];?>">
								<?php 
                                $grsTotal += $row["totalamount"] ;
                                if($row["paid"] == 1){
                                $paidTotal += $row["totalamount"] ;
                                }
                                } 
                                ?>

                                  <tr style="padding-top:20px">
                                    <td colspan="7" class="admlsttxt">Result pages:<font color="#000000">
                                      <?php if($page<>1){ ?>
                                      <a href="<?php echo "?section=shop&do=orders&page=1&radDate=".$_GET["radDate"]."&month1=".$_GET["month1"]."&day1=".$_GET["day1"]."&year1=".$_GET["year1"]."&month2=".$_GET["month2"]."&day2=".$_GET["day2"]."&year2=".$_GET["year2"]."&Submit=".$_GET["Submit"];?>" style="color:#9fcf6f; text-decoration:underline;">First Page</a>
                                      <?php } ?>
                                      &nbsp;&nbsp;
                                      <?php if ($page>1){ ?>
                                      <a href="<?php echo "?section=shop&do=orders&".($page-1)."&radDate=".$_GET["radDate"]."&month1=".$_GET["month1"]."&day1=".$_GET["day1"]."&year1=".$_GET["year1"]."&month2=".$_GET["month2"]."&day2=".$_GET["day2"]."&year2=".$_GET["year2"]."&Submit=".$_GET["Submit"];?>" style="color:#9fcf6f; text-decoration:underline;">Previous</a> &nbsp;&nbsp;&nbsp;
                                      <?php }
$start =1;
$ends =  $totalPages;
for ($i=$start;$i<=$ends;$i++){
if ($i== $page){
?>
                                      <?php echo $i;?>&nbsp;&nbsp;
                                      <?php }else{ ?>
                                      <a href="<?php echo "?section=shop&do=orders&page".$i."&radDate=".$_GET["radDate"]."&month1=".$_GET["month1"]."&day1=".$_GET["day1"]."&year1=".$_GET["year1"]."&month2=".$_GET["month2"]."&day2=".$_GET["day2"]."&year2=".$_GET["year2"]."&Submit=".$_GET["Submit"];?>" style="color:#9fcf6f; text-decoration:underline;"><?php echo $i; ?></a>&nbsp;&nbsp;
                                      <?php 
}
}
if($totalPages > $page){ ?>
                                      &nbsp;&nbsp;&nbsp; <a href="<?php echo "?section=shop&do=orders&page".($page+1)."&radDate=".$_GET["radDate"]."&month1=".$_GET["month1"]."&day1=".$_GET["day1"]."&year1=".$_GET["year1"]."&month2=".$_GET["month2"]."&day2=".$_GET["day2"]."&year2=".$_GET["year2"]."&Submit=".$_GET["Submit"];?>" style="color:#9fcf6f; text-decoration:underline;">Next</a>
                                      <?php } ?>
                                      &nbsp;&nbsp;
                                      <?php if ($page <> $totalPages){ ?>
                                      <a href="<?php echo "?section=shop&do=orders&page".($totalPages)."&radDate=".$_GET["radDate"]."&month1=".$_GET["month1"]."&day1=".$_GET["day1"]."&year1=".$_GET["year1"]."&month2=".$_GET["month2"]."&day2=".$_GET["day2"]."&year2=".$_GET["year2"]."&Submit=".$_GET["Submit"];?>" style="color:#9fcf6f; text-decoration:underline;">Last Page</a>
                                      <?php } ?>
                                      </font></td>
                                  </tr>
                                  <tr style="padding-top:20px">
                                    <input type="hidden" name="hIDConfirm">
                                    <td colspan="7" >&nbsp;&nbsp;&nbsp;
                                      <input name="Del" type="button" class="formbutton" onClick="ruSure()" value="Delete selected">
                                      &nbsp;&nbsp;&nbsp;
                                      <input name="updteStatus" type="submit" class="formbutton" value="Update Status" />
                                      <br>
                                      <br></td>
                                  </tr>
                                  <?php
}
?>
                                </form>
                              </table>
                              <?php } ?></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<script>
function ShowInvoice(OrdNo){
	Shadowbox.open({
		content:    'shop_invoiceshow.php?orderno='+OrdNo,
		player:     "iframe",
		title:      "Print Invoice",
		width:      720
	});
}
if(document.getElementById('SelectedDate').checked){
	enable('5');
}

</script> 
