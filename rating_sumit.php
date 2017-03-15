<?php
include("inc/global.php");
$OptionType=explode('|',$_POST['data']);
$arr_Rating = array();
foreach($OptionType as $item){
	$arr_Type=explode(':',$item);
	if($arr_Type[0] !=" "){
		$arr_Rating[$arr_Type[0]]=$arr_Type[1];
	}
}
$id_pro = $arr_Rating['productid'];
$email = $arr_Rating['email'];
$over_rat = $arr_Rating['kv-gly-star'];
$re_title = $arr_Rating['title'];
$re_content = $arr_Rating['reviewtext'];
$recommend = $arr_Rating['isrecommended'];
$re_qualty = $arr_Rating['kv-gly-quality'];
$re_value = $arr_Rating['kv-gly-value'];
$username = $arr_Rating['usernickname'];
$localtion = $arr_Rating['userlocation'];
$gender = $arr_Rating['gender'];
$employees = $arr_Rating['companySize'];
$hear_about = $arr_Rating['HowDidYouHearAboutPrintrunner'];
$date = date("Y-m-d");
$sql = "SELECT * FROM v_rating WHERE email='{$email}' and isactive=1 and id_pro='{$id_pro}'";
$result = mysql_query($sql);
if(mysql_num_rows($result) > 0){

	$sql_update = "UPDATE v_rating SET over_rat='{$over_rat}',re_title='{$re_title}',
										re_content='{$re_content}',recommend='{$recommend}',
										re_qualty='{$re_qualty}',re_value='{$re_value}',
										username='{$username}',localtion='{$localtion}',
										gender='{$gender}',employees='{$employees}',
										hear_about='{$hear_about},date='{$date}' 
									WHERE email='{$email}' and isactive=1 and id_pro='{$id_pro}'";
	mysql_query($sql_update);
}else{
	$sql_insert = "INSERT INTO v_rating(id_pro,over_rat,re_title,re_content,recommend,email,re_qualty,re_value,username,localtion,gender,employees,hear_about,date,isactive)
								VALUES('{$id_pro}','{$over_rat}','{$re_title}','{$re_content}','{$recommend}','{$email}','{$re_qualty}','{$re_value}','{$username}','{$localtion}','{$gender}','{$employees}','{$hear_about}','{$date}','1')
				";
	mysql_query($sql_insert);
}
echo "success";
?>