<?php
class SortableExample {
	protected $conn;
	//protected $user = 'vadesign_dbuser';
	//protected $pass = '#eEnz7M#fq?1';
	//protected $dbname = 'vadesign_db';	
	protected $user = 'root';
	protected $pass = 'root';
	protected $dbname = 'allcity_ziggis';
	protected $host = 'localhost';
	
	public function __construct() {
		$this->conn = mysql_connect($this->host, $this->user, $this->pass);
		mysql_select_db($this->dbname,$this->conn);
	}
	
	public function getAnList($tblName, $id=0) {
		
		if($tblName=='quotes') {
			$sql = "SELECT quotes.*, quote_cats.parent_cat FROM quotes inner join quote_cats on quotes.catid=quote_cats.id ORDER BY quote_cats.id, quotes.id";
		} else if($tblName=='products') {
			$sql = "SELECT products.*, category.catname FROM products inner join category on products.catid=category.catid ORDER BY category.catid, products.productid";
		} else if($tblName=='vinyl_customsize') {
			$sql = "SELECT * FROM vinyl_customsize where productid='".$id."' ORDER BY id";
		} else if($tblName=='orders') {
		$sql = "SELECT * FROM ".$tblName." ORDER BY orderdate";
		}else if($id=='1' and $tblName=='vinyl_category'){
			$sql = "SELECT * FROM ".$tblName." ORDER BY parent_cat";
		}else if($id=='1' and $tblName=='quote_cats'){
			$sql = "SELECT * FROM ".$tblName." ORDER BY parent_cat";
		}else if($id=='1' and $tblName=='fontCategory'){
			$sql = "SELECT * FROM ".$tblName." ORDER BY orderby";
		}else if($tblName=='font_table'){
			$sql ="SELECT font_table.*, fontcategory.parent_cat FROM font_table inner join 
			fontcategory on font_table.parent_cats=fontcategory.id ORDER BY font_table.font_name";	
		}else if($tblName=='color_table'){
			$sql ="SELECT color_table.*, vinyl_use.vinyl_uses FROM color_table inner join 
			vinyl_use on color_table.vinyl_use=vinyl_use.id ORDER BY color_table.color_name";
		}else if($tblName=='sliders'){
			$sql ="SELECT * FROM sliders ORDER BY orderby";	
		}else if($tblName=='vinyl_use'){
			$sql ="SELECT * FROM vinyl_use ORDER BY orderby";	
		}else if($tblName=='quote_cats'){
			$sql ="SELECT * FROM quote_cats ORDER BY orderby";	
		}else if($tblName=='vinyl_category'){
			$sql ="SELECT * FROM vinyl_category ORDER BY orderby";	
		}else{
			$sql = "SELECT * FROM ".$tblName." ORDER BY id";
		}
		//echo $sql;
		$recordSet = mysql_query($sql,$this->conn) or die( mysql_error());
		$results = array();
		while($row = mysql_fetch_assoc($recordSet)) {
			$results[] = $row;
		}
		return $results;
	}
	
	public function updateAnList($orderArray,$tblUpdate) {
		$orderid = 1;
		foreach($orderArray as $anid) {
			$anid = (int) $anid;
			$sql = "UPDATE ".$tblUpdate." SET orderby={$orderid} WHERE id={$anid}";
			$recordSet = mysql_query($sql,$this->conn);
			$orderid++;
		}
	}
	public function updateActBtn($updtid,$updtvalue,$tblName){
		$sql =mysql_query("UPDATE ".$tblName." SET isactive='".$updtvalue."' WHERE id='".$updtid."'");
		
		if($updtvalue=='0'){$activate=true;}else{ $activate=false;}
		if($activate) {
			echo '<a href="javascript:void(0);" title="Activate" onclick="update_status('.$updtid.',1,\''.$tblName.'\');">
			<img src="images/activate.png" alt="Activate" border="0"></a>';
		} else { 
			echo '<a href="javascript:void(0);" title="Deactivate" onclick="update_status('.$updtid.',0,\''.$tblName.'\');">
			<img src="images/deactivate.png" alt="Deactivate" border="0"></a>';
		}
	}
	public function updateFeatureBtn($updtid,$updtvalue,$tblName){
		$sql =mysql_query("UPDATE ".$tblName." SET featured='".$updtvalue."' WHERE id='".$updtid."'");
		
		if($updtvalue=='0'){$featured=true;}else{ $featured=false;}
		if($featured) {
			echo '<a href="javascript:void(0);" onClick="javascript:update_Fstatus(\''.$updtid.'\',\'1\',\'F\',\''.$tblName.'\');" title="Make Featured"><img src="images/activate.png" alt="Activate" width="16" height="16" border="0"></a>';
		} else { 
			echo '<a href="javascript:void(0);" onClick="javascript:update_Fstatus(\''.$updtid.'\',\'0\',\'F\',\''.$tblName.'\');" title="Remove Featured"><img src="images/deactivate.png" alt="Deactivate" width="16" height="16" border="0"></a>';
		}
	}
	public function updateCoupBtn($updtid,$updtvalue,$tblName){
		$sql =mysql_query("UPDATE ".$tblName." SET coupstatus='".$updtvalue."' WHERE id='".$updtid."'");
		
		if($updtvalue=='0'){$activate=true;}else{ $activate=false;}
		if($activate) {
			echo '<a href="javascript:void(0);" onClick="javascript:update_Cstatus(\''.$updtid.'\',\'1\',\''.$tblName.'\');" title="Activate"><img src="images/activate.png" alt="Activate" width="16" height="16" border="0"></a>';
		} else { 
			echo '<a href="javascript:void(0);" onClick="javascript:update_Cstatus(\''.$updtid.'\',\'0\',\''.$tblName.'\');" title="Deactivate"><img src="images/deactivate.png" alt="Deactivate" width="16" height="16" border="0"></a>';
		}
	}					
	public function filterlist($tblName,$filterid){
		if($tblName=='vinyl_product'){
			if($filterid!='All'){
				$sql = "SELECT vinyl_product.*, vinyl_category.parent_cat FROM vinyl_product inner join vinyl_category on vinyl_product.product_catid=vinyl_category.id where product_catid='".$filterid."' ORDER BY vinyl_category.id, vinyl_product.id";	
			} else {
				$sql = "SELECT vinyl_product.*, vinyl_category.parent_cat FROM vinyl_product inner join vinyl_category on vinyl_product.product_catid=vinyl_category.id ORDER BY vinyl_category.id, vinyl_product.id";
			}												
		
		}
		if($tblName=='quotes'){
			if($filterid!='All'){
				$sql = "SELECT quotes.*, quote_cats.parent_cat FROM quotes inner join quote_cats on quotes.catid=quote_cats.id  where catid='".$filterid."' ORDER BY quote_cats.id, quotes.id";
			} else {
				$sql = "SELECT quotes.*, quote_cats.parent_cat FROM quotes inner join quote_cats on quotes.catid=quote_cats.id  ORDER BY quote_cats.id, quotes.id";
			}													
		
		}
		
		if($tblName=='font_table'){
			if($filterid!='All'){
				$sql = "SELECT font_table.*, fontcategory.parent_cat FROM font_table inner join 
			fontcategory on font_table.parent_cats=fontcategory.id where font_table.parent_cats='".$filterid."' 
			ORDER BY font_table.font_name";	
			} else {
				$sql = "SELECT font_table.*, fontcategory.parent_cat FROM font_table inner join 
			fontcategory on font_table.parent_cats=fontcategory.id ORDER BY font_table.font_name";
			}												
		}
		
		if($tblName=='color_table'){
			if($filterid!='All'){
				$sql = "SELECT color_table.*, vinyl_use.vinyl_uses FROM color_table inner join 
			vinyl_use on color_table.vinyl_use=vinyl_use.id where color_table.vinyl_use='".$filterid."' 
			ORDER BY color_table.color_name";	
			} else {
				$sql = "SELECT color_table.*, vinyl_use.vinyl_uses FROM color_table inner join 
			vinyl_use on color_table.vinyl_use=vinyl_use.id ORDER BY color_table.color_name";
			}												
		}
		$recordSet = mysql_query($sql,$this->conn)or die(mysql_error());
		$results = array();
		while($row = mysql_fetch_assoc($recordSet)) {
			$results[] = $row;
		}
		return $results;
	}	
	
	public function filteroption($tblName,$filterid){
		if($tblName=='vinyl_category'){
			$sql ="select cf1,cf2,cf3,cf4,cf5,cf6,cf7,cf8,cf9,cf10 from vinyl_category where id='".$filterid."'";
		}
		
		$res_option=mysql_query($sql,$this->conn) or die(mysql_error());
		$options= array();
		$optionlist=mysql_fetch_assoc($res_option);
		foreach($optionlist as $option){
			if($option!=''){
			$options[]=$option;
			}
		}
		return $options;
	}
	
}


	

?>