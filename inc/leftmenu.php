<ul class="nav navbar-nav" id="sidenav01">
<?php
        $sqlprdpg="SELECT id, title,prod_title FROM category WHERE isactive=1 ORDER BY title";
        $resprdpg=mysql_query($sqlprdpg);
		$i = 0;
        while($rowprdpg=mysql_fetch_assoc($resprdpg)){
			$pagemenulink=strtolower($rowprdpg['prod_title']);
			$pagemenulink=str_replace(' ','',$pagemenulink);
				?>
				<li> <a href="javascript:void(0)" data-toggle="collapse" data-target="#toggleDemo<?php echo $i;?>" data-parent="#sidenav01" class="collapsed"> <i class="fa fa-caret-down" aria-hidden="true"></i><?php echo $rowprdpg['prod_title']?> </a>
				  <div class="collapse" id="toggleDemo<?php echo $i;?>" style="height: 0px;">
					<ul class="nav nav-list">
						<?php
							$sqlprd="SELECT id,ptitle,learnmore_top,main_image FROM products WHERE isactive=1 and cat_id='".$rowprdpg['id']."'";
							$resprd=mysql_query($sqlprd);
							if(mysql_num_rows($resprd)){
								while($rowprd=mysql_fetch_assoc($resprd)){
									$menulink=strtolower($rowprd['ptitle']);
									$menulink=str_replace('.','_',$menulink);
									$menulink=str_replace(' ','-',$menulink);
									$menulink .='-printing';
								?>
							<li><a href="<?php echo LINK_PATH;?><?php echo $pagemenulink.'/'.$menulink.'.html';?>"><?php echo $rowprd['ptitle'];?></a></li>
							<?php } } ?>
					</ul>
				  </div>
				</li>
				<?php
			
			$i++;
			}
?>

	
	
 </ul>