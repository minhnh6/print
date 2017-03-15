<ul class="dropdown-menu mega-menu">
	<?php
		$sql_count = "SELECT count(*) as sl FROM category";
		$res_cout=mysql_query($sql_count);
		$row =  mysql_fetch_assoc($res_cout);
		$sl = $row['sl'];
		$rowcout = ceil($sl/4);
		for($i=1;$i<=4;$i++){
			$off = ($i-1)*$rowcout;
	?>
  <li class="mega-menu-column">
	<ul>
		<?php
		$j =1;
		$sqlmenu="SELECT id, title,prod_title FROM category WHERE isactive=1 ORDER BY title LIMIT $off,$rowcout";
        //echo $sqlmenu;
		$resmenu=mysql_query($sqlmenu);
        while($rowmenu=mysql_fetch_assoc($resmenu)){
			$menulink=strtolower($rowmenu['prod_title']);
			$menulink=str_replace(' ','-',$menulink);
			$menulink .='-printing';
            echo '<li><a href="'.LINK_PATH.$menulink.'.html">'.$rowmenu['title'].'&nbsp;'.'</a></li>';
            $j++;
        }
   ?>
		
	</ul>
  </li>
  <?php
		}
  ?>
 
</ul>
<!-- dropdown-menu --> 