 <ul class="sidebar-nav">
		<?php
		$sqlprd="SELECT products.id,products.ptitle,products.learnmore_top,products.main_image,category.prod_title FROM products 
		INNER JOIN category ON products.cat_id = category.id
		WHERE products.isactive=1 LIMIT 40";
	
		$resprd=mysql_query($sqlprd);
		if(mysql_num_rows($resprd)){
			while($rowprd=mysql_fetch_assoc($resprd)){
				
				$pagemenulink=strtolower($rowprd['prod_title']);
				$pagemenulink=str_replace(' ','',$pagemenulink);
				
				$menulink=strtolower($rowprd['ptitle']);
				$menulink=str_replace('.','_',$menulink);
				$menulink=str_replace(' ','-',$menulink);
				$menulink .='-printing';
			?>
		<li><a href="<?php echo LINK_PATH;?><?php echo $pagemenulink.'/'.$menulink.'.html';?>"><?php echo $rowprd['ptitle'];?></a></li>
		<?php } } ?>
	  
</ul>