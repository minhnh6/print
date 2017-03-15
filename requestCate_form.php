<?php
session_start();
session_save_path('tmp/');
include('inc/global.php');
$MetaKeywords='Stickers Printing | Folders Printing | Brochures Printing';
$MetaDescriprtion='Stickers Printing | Folders Printing | Brochures Printing';
$MetaTitle='Custom Quote : PrintingPeriod | Stickers Printing | Folders Printing | Brochures Printing';
include("inc/header.php");
require_once ("simple_html_dom.php");
?>
<?php 
	function get_calculator($html){
		$link = $_POST['link'];
        $html = file_get_html($link);
		
	}
	function info_headers($html){
		$arr_headers = array();
		$arr_headers['metatitle'] = str_replace(array("UPrinting","uprinting"),array("Printing","printing"),preg_replace('/\s\s+/', ' ',trim($html->find('h1',0)->plaintext)));
        $arr_headers['metakeywords'] = str_replace(array("UPrinting","uprinting"),array("Printing","printing"),preg_replace('/\s\s+/', ' ',trim($html->find("meta[name='keywords']",0)->content)));
       	$arr_headers['metadescriprtion'] = str_replace(array("UPrinting","uprinting"),array("Printing","printing"),preg_replace('/\s\s+/', ' ',trim($html->find("meta[name='description']",0)->content)));
						
		return $arr_headers;
	}
	function get_infoCate($html){
		$arr_infoCate = array();
        $arr_infoCate['name_cate'] = str_replace(array("UPrinting","uprinting"),array("Printing","printing"),preg_replace('/\s\s+/', ' ',trim($html->find('h1',0)->plaintext)));
        $arr_infoCate['prod_title'] = trim(str_replace("Printing","", $arr_infoCate['name_cate'])) ;
        $arr_infoCate['slug']= convertUtf8ToLatin(trim(str_replace(array("Printing","printing"),"",$arr_infoCate['name_cate'])));
 
       foreach($html->find('section.product-details') as $infocategory){
                 $arr_infoCate['des_cate'] = str_replace(array("UPrinting","uprinting"),array("Printing","printing"),preg_replace('/\s\s+/', ' ', trim($html->find('h2',1)->plaintext)));
                 foreach($infocategory->find('p') as $info){
                 	$arr_infoCate['conten_cate'] .= str_replace(array("UPrinting","uprinting"),array("Printing","printing"),$info->outertext);
                 }
		}
		
		return  $arr_infoCate;
	}
	function listpro_cate($html){
		$arr_proCate = array();
		/*foreach($html->find('div.single-category') as $category){
		                 $item['name_pro']     = preg_replace('/\s\s+/', ' ', trim($category->find('p.product-txt',0)->plaintext));
						 $item['src_pro']    =$category->find('img',0)->src;
						  $item['date_pri_pro']     = preg_replace('/\s\s+/', ' ', trim($category->find('p.ta-txt',0)->plaintext));
						 $item['price_pro'] = preg_replace('/\s\s+/', ' ', trim($category->find('i.price-txt', 0)->plaintext));
						 $arr_proCate[] = $item;
		               
		}*/
		foreach($html->find('div.single-category') as $category){
			$arr_proCate[]    ='http://www.uprinting.com'.$category->find('a',0)->href;
			}
		return $arr_proCate;
	}
	function get_infoPro($html){
		$arr_infoProduct = array();
		foreach($html->find('section.product-main') as $infopro){
	          $arr_infoProduct['name_pro']     = str_replace(array("UPrinting","uprinting"),array("Printing","printing"),preg_replace('/\s\s+/', ' ', trim($infopro->find('h1.pull-left',0)->plaintext)));
			  $arr_infoProduct['src_pro']    =$infopro->find('img',0)->src;
		}
		$arr_infoProduct['pro_slug'] = convertUtf8ToLatin($arr_infoProduct['name_pro']);
		$item_learnmore_top = array();
		foreach($html->find('ul.green-check') as $infopro_learnmore_top){
			foreach($infopro_learnmore_top->find('li') as $item_li){
        			$item_learnmore_top[]= str_replace(array("UPrinting","uprinting"),array("Printing","printing"),preg_replace('/\s\s+/', ' ', trim($item_li->plaintext)));
        		}
					
		}
		$arr_infoProduct['learnmore_top'] = implode('|', $item_learnmore_top);
		$arr_infoProduct['learnmore_bottom'] = '';
		foreach($html->find('div#overview') as $item_learnmore_bottom){
                 foreach($item_learnmore_bottom->find('p') as $info_item){
                 	$arr_infoProduct['learnmore_bottom'] .= str_replace(array("UPrinting","uprinting"),array("Printing","printing"),$info_item->outertext);
                 }
		}
	/*	$arr_infoProduct['specs'] = array();
		foreach($html->find('div#paperSpecs') as $item_specs){
                 foreach($item_specs->find('div.col-sm-7') as $info_item){
                 	$arr_specs['h3'] = $info_item->plaintext;
                 	$arr_specs['ul'] .= $info_item->outertext;
                 }
                 $arr_infoProduct['specs']= $arr_specs;
		}*/
		return 	$arr_infoProduct;			
	}
	function breadcrumb($html){
		$arr_breadcrumb = array();
						
        foreach($html->find('ol.breadcrumb') as $item_ol){
        	foreach($item_ol->find('li') as $item_li){
        		$arr_breadcrumb[]= preg_replace('/\s\s+/', ' ', trim($item_li->plaintext));
        	}
        	//$arr_breadcrumb[] = $item;
        }
		return $arr_breadcrumb;
	}
	function getimg($path,$ten_file,$file_name) {
           if(!is_dir($path))
			{
				mkdir($path);
			}
			$url_file_name = 'http:'.$file_name;
			$img = $path.$ten_file;
            file_put_contents($img, file_get_contents($url_file_name));
  }
	function dowload_img($slug_cate,$arr_infoProduct){
		$path = "images/products_up/{$slug_cate}/";
		$path_root = $_SERVER["DOCUMENT_ROOT"].'/'.$path;
		//xu ly anh: lấy tên ảnh
		$file_name = $arr_infoProduct['src_pro'];	
		$str_filename  = explode("/", $file_name);
		$ten_file = $str_filename[count($str_filename)-1];
		getimg($path_root,$ten_file,$file_name);
		
		$arr_infoProduct["main_image"]=$path.$ten_file;
		return $arr_infoProduct;
	}
	function product($arr_infoProduct){
		$ptitle = mysql_real_escape_string($arr_infoProduct['name_pro']);
		$pro_slug = mysql_real_escape_string($arr_infoProduct['pro_slug']);
		$cat_id = mysql_real_escape_string($arr_infoProduct['name_pro']);
		$learnmore_top = mysql_real_escape_string($arr_infoProduct['learnmore_top']);
		$learnmore_bottom = mysql_real_escape_string($arr_infoProduct['learnmore_bottom']);
		$metatitle = mysql_real_escape_string($arr_infoProduct['metatitle']);
		$metakeywords = mysql_real_escape_string($arr_infoProduct['metakeywords']);
		$metadescriprtion = mysql_real_escape_string($arr_infoProduct['metadescriprtion']);
		$cat_id = $arr_infoProduct['cat_id'];
		$main_image = $arr_infoProduct['main_image'];
		//kiem tra product ton tại chưa
		
		$sql_pro = "SELECT * FROM products_up WHERE isactive=1 AND pro_slug='{$pro_slug}' ";
		//echo $sql_pro;
		$result = mysql_query($sql_pro);
		if(mysql_num_rows($result) > 0){
			//da ton tai
			$row_pr = mysql_fetch_assoc($result);
			$id_pro = $row_pr['id'];
			$sql_proup = "UPDATE products_up SET ptitle='{$ptitle}',pro_slug='{$pro_slug}',cat_id='{$cat_id}',learnmore_top='{$learnmore_top}',learnmore_bottom='{$learnmore_bottom}',metatitle ='{$metatitle}',metakeywords='{$metakeywords}',metadescriprtion='{$metadescriprtion},main_image='{$main_image}'
											WHERE  id={$id_pro} ";
			mysql_query($sql_proup);
		}else{
			$sql_proinsert = "INSERT INTO products_up(ptitle,pro_slug,cat_id,learnmore_top,learnmore_bottom,metatitle,metakeywords,metadescriprtion,iscustom,isactive,main_image)
							VALUES('{$ptitle}','{$pro_slug}','{$cat_id}','{$learnmore_top}','{$learnmore_bottom}','{$metatitle}','{$metakeywords}','{$metadescriprtion}',0,1,'{$main_image}')
							";
			mysql_query($sql_proinsert);
			
		}
	
	
}

	
?>
<div class="faqs-inner-list ">
		<h2>List Link </h2>
        <ul >
        	<?php 
        		$mess = "";
        		if(isset($_POST['link'])){
        			$link = $_POST['link'];
        			$html = file_get_html($link);
        			//get info headers
        			$arr_headers = info_headers($html);
        		
        			//get list product Categolue
        			$arr_proCate = listpro_cate($html);
        			if(count($arr_proCate) > 0){
        				//get info Categolue
        				$arr_infoCate = get_infoCate($html);
        				//mer arr_headers
        				$arr_infoCate = array_merge($arr_headers,$arr_infoCate);
        				
        				$title =str_replace("Printing","  ", mysql_real_escape_string($arr_infoCate['name_cate'])) ;
						$prod_title = mysql_real_escape_string($arr_infoCate['name_cate']);
						$slug = mysql_real_escape_string($arr_infoCate['slug']);
						$learnmore_top = mysql_real_escape_string($arr_infoCate['des_cate']);
						$learnmore_bottom = mysql_real_escape_string($arr_infoCate['conten_cate']);
						$metatitle = mysql_real_escape_string($arr_infoCate['metatitle'].' Printing');
						$metakeywords = mysql_real_escape_string($arr_infoCate['metakeywords']);
						$metadescriprtion = mysql_real_escape_string($arr_infoCate['metadescriprtion']);
						
						//thực hiện insert hoặc update dữ liệu
						//Kiểm tra cate tồn tại chưa
						$sql = "SELECT * FROM category_up WHERE isactive=1  and slug ='$slug' ";
						
						$rescate = mysql_query($sql);
						if(mysql_num_rows($rescate) > 0){
							$row = mysql_fetch_assoc($rescate);
							$id_cate = $row['id'];
							$sql_update = "UPDATE category_up SET title='{$title}',prod_title='{$prod_title}',slug='{$slug}',learnmore_top='{$learnmore_top}',learnmore_bottom='{$learnmore_bottom}',metatitle='{$metatitle}',metakeywords='{$metakeywords}',metadescriprtion='{$metadescriprtion}'
											WHERE isactive=1  and id ={$id_cate} ";
							mysql_query($sql_update);
						}else{
							//thực hiện insert Cate
							
							$sql_insert = "INSERT INTO category_up(title,prod_title,slug,learnmore_top,learnmore_bottom,metatitle,metakeywords,	metadescriprtion,isactive)
											VALUES('{$title}','{$prod_title}','{$slug}','{$learnmore_top}','{$learnmore_bottom}','{$metatitle}','{$metakeywords}','{$metadescriprtion}',1)
											";
							mysql_query($sql_insert);
						}
        				
        				
						//xử lý sp cho cate
						foreach ($arr_proCate as $item){
							$html = file_get_html($item);
							$arr_breadcrumb = breadcrumb($html);
							//
							$arr_infoProduct = get_infoPro($html);
							//mer arr_headers
        					$arr_infoProduct = array_merge($arr_headers,$arr_infoProduct);
        					
        					$name_cate = trim(str_replace(array("Printing","printing"),"", $arr_breadcrumb['1'])) ;
        					$slug_cate = convertUtf8ToLatin($name_cate);//kiêm tra cate đã tôn tại chưa
	        				$sql = "SELECT * FROM category_up WHERE isactive=1  and slug ='$slug_cate' ";
							
							$rescate = mysql_query($sql);
							if(mysql_num_rows($rescate) > 0){
								//da ton tai
								$row = mysql_fetch_assoc($rescate);
								$id_cate = $row['id'];
								
							}else{
								$sql_insert = "INSERT INTO category_up(title,prod_title,slug,isactive)
												VALUES('{$name_cate}','{$name_cate}','{$slug_cate}',1)
												";
								mysql_query($sql_insert);
								$id_cate = mysql_insert_id();
								
							}
	        				$arr_infoProduct['cat_id'] = $id_cate;
							$arr_infoProduct = dowload_img($slug_cate,$arr_infoProduct);
	        				
	        				
							//thực hiện luu db
							product($arr_infoProduct);
							
							
						}
						//thực hiên truy vấn sql & foreach $arr_proCate
						$mess = "<span style='color:blue'>Get info Cate succces</span>";
        			}else{
        				$arr_calculator = get_calculator($html);
        				echo "<pre>";
        					print_r($arr_calculator);
        				echo "</pre>";
        				exit();
        				//đường dẫn cate
						$arr_breadcrumb = breadcrumb($html);
						if(count($arr_breadcrumb)>0){
							$arr_infoProduct = get_infoPro($html);
							//mer arr_headers
        					$arr_infoProduct = array_merge($arr_headers,$arr_infoProduct);
        					
        					$name_cate = trim(str_replace(array("Printing","printing"),"", $arr_breadcrumb['1'])) ;
        					$slug_cate = convertUtf8ToLatin($name_cate);//kiêm tra cate đã tôn tại chưa
	        				$sql = "SELECT * FROM category_up WHERE isactive=1  and slug ='$slug_cate' ";
							
							$rescate = mysql_query($sql);
							if(mysql_num_rows($rescate) > 0){
								//da ton tai
								$row = mysql_fetch_assoc($rescate);
								$id_cate = $row['id'];
								
							}else{
								$sql_insert = "INSERT INTO category_up(title,prod_title,slug,isactive)
												VALUES('{$name_cate}','{$name_cate}','{$slug_cate}',1)
												";
								mysql_query($sql_insert);
								$id_cate = mysql_insert_id();
								
							}
	        				$arr_infoProduct['cat_id'] = $id_cate;
							$arr_infoProduct = dowload_img($slug_cate,$arr_infoProduct);
	        				
	        				
							//thực hiện luu db
							product($arr_infoProduct);
							
							
	        				$mess = "<span style='color:blue'>Get info Product succces</span>";
						}else {
							$mess = "<span style='color:red'>Get info page {$link} error</span>";
						}
        			}
					
					
					
        		}	
			?>
        	<?php echo $mess;?>
        	<?php 
				$doc = new DOMDocument();
				
				$doc->load('reCate.xml');
				$arr_Cate = $doc->getElementsByTagName("Cate");
				$i=1;
				foreach ($arr_Cate as $item){
					$tag_Cate = $item->getElementsByTagName("ten");
			        $name_Cate = $tag_Cate->item(0)->nodeValue;
			        
			        $tag_link = $item->getElementsByTagName("link");
			        $link = $tag_link->item(0)->nodeValue;
			?>
			
			<form action="" method="post" name="requestCate_form" id="requestCate_form<?php echo $i;?>" onsubmit="javascript: return false;" enctype="multipart/form-data" novalidate="novalidate">
         	 <li><?php echo $i.' /';?><i class="fa fa-check-square-o" aria-hidden="true"></i>
          		<a href="javascript:void(0)"><?php echo $name_Cate;?></a>
          		<div class="form-group">
				  <input type="text" width="70%" class="form-control" name="link" id="link" value="<?php echo $link;?>" placeholder="Name">
				 <button type="button" onclick="document.getElementById('requestCate_form<?php echo $i;?>').submit();" id="btnrequest" class="form-btn">Send</button>
					
				</div>
          </li><br/>
        </form>
       	<?php $i++; } ?>
         </ul>
       
      </div>

<?php
include("inc/footer.php");
?>
