<?php
session_start();
include('inc/global.php');
$MetaKeywords='Stickers Printing | Folders Printing | Brochures Printing';
$MetaDescriprtion='Stickers Printing | Folders Printing | Brochures Printing';
$MetaTitle='PrintingPeriod | Stickers Printing | Folders Printing | Brochures Printing';
include("inc/header.php");
?>
<!--/header-->
<section id="breadcrumbs-fram">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">All products</li>
    </ol>
    <div class="grid-list">
      <ul>
        <li><a href="#"><i class="fa fa-th-large" aria-hidden="true"></i> Grid</a></li>
        <li><a href="#"><i class="fa fa-bars" aria-hidden="true"></i> list</a></li>
      </ul>
    </div>
  </div>
</section>
<!--/BreadCrumb-->
<section class="product-main-part">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 col-md-3 affix-sidebar">
        <div class="sidebar-nav">
          <div class="navbar-default" role="navigation">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
              <span class="visible-xs navbar-brand">Sidebar menu</span> </div>
            <div class="navbar-collapse collapse sidebar-navbar-collapse">
				<?php include("inc/leftmenu.php"); ?>
              
            </div>
            <!--/.nav-collapse --> 
          </div>
        </div>
      </div>
	  
      <div class="col-md-9 col-sm-9">
	  <?php
        $sqlprdpg="SELECT id, title,prod_title FROM category WHERE isactive=1 ORDER BY title";
        $resprdpg=mysql_query($sqlprdpg);
        while($rowprdpg=mysql_fetch_assoc($resprdpg)){
			$pagemenulink=strtolower($rowprdpg['prod_title']);
			$pagemenulink=str_replace(' ','',$pagemenulink);
            $sqlprd="SELECT id,ptitle,learnmore_top,main_image FROM products WHERE isactive=1 and cat_id='".$rowprdpg['id']."'";
            $resprd=mysql_query($sqlprd);
			if(mysql_num_rows($resprd)){
				?>
					<div class="product-title">
					  <h1><?php echo $rowprdpg['prod_title']?></h1>
					</div>
					 <div class="row">
						
				<?php
				while($rowprd=mysql_fetch_assoc($resprd)){
					$menulink=strtolower($rowprd['ptitle']);
					$menulink=str_replace('.','_',$menulink);
					$menulink=str_replace(' ','-',$menulink);
					$menulink .='-printing';
					$url_img = LINK_PATH.$rowprd['main_image'];

				?>
					<div class="col-md-4 col-sm-4 custom-margin">
					<div class="recent-work-wrap"> 
						<img class="img-responsive" src='<?php echo $url_img;?>' alt="">

					  <div class="overlay custom-overlay">
						<div class="recent-work-inner">
				
						  <h3><a href="<?php echo LINK_PATH;?><?php echo $pagemenulink.'/'.$menulink.'.html';?>"><?php echo $rowprd['ptitle'];?></a> </h3>
						  <p><?php echo substr($rowprd['learnmore_top'],0,180);?>...</p>
						  <a href="<?php echo LINK_PATH;?><?php echo $pagemenulink.'/'.$menulink.'.html';?>">View More</a> </div>
					  </div>
					</div>
					<div class="recent-work-description">
					  <h2><?php echo $rowprd['ptitle']?></h2>
					 
					  <ul>
					  	<?php
					  	$id_pro = $rowprd['id'];
				//xu hien thị rating
						$sql_rating ="SELECT  * FROM v_rating WHERE id_pro='{$id_pro}' and isactive=1 ";
						$result = mysql_query($sql_rating);
						$i=$strat=0;
						if(mysql_num_rows($result) > 0){
							
							$sum_strat1 = $sum_strat2=$sum_strat3=$sum_strat4=$sum_strat5 = 0;
							while($row=mysql_fetch_assoc($result)){
								switch($row["over_rat"]){
									case 1:  
										$sum_strat1++;
										break;
									case 2:  
										$sum_strat2++;
										break;
									case 3:  
										$sum_strat3++;
										break;
									case 4:  
										$sum_strat4++;
										break;
									case 5:  
										$sum_strat5++;
										break;
								}
								
								$i++;
							}
							//echo $i; 
							$strat = ((5*$sum_strat5)+(4*$sum_strat4)+(3*$sum_strat3)+(2*$sum_strat2)+(1*$sum_strat1))/$i;
						}
						?>
						<li><input type="text"  class="rating rating-loading rating-product"  value="<?php echo $strat;?>" data-size="ms" data-min=0 data-max=5  title=""></li>
						
					  </ul>
					</div>
				</div>
				<?php
				}
				?>
					
				</div>
				<?php
			}
        }
        ?>
       
		
       
      </div>
    </div>
  </div>
</section>
<?php include('inc/footer.php'); ?>
