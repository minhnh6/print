<ul class="sidebar-nav">
	<?php
        $sqlmenu="SELECT id, title,prod_title FROM category WHERE isactive=1 ORDER BY title LIMIT 15";
        $resmenu=mysql_query($sqlmenu);
        while($rowmenu=mysql_fetch_assoc($resmenu)){
			$menulink=strtolower($rowmenu['prod_title']);
			$menulink=str_replace(' ','-',$menulink);
			$menulink .='-printing';
            echo '<li><a href="'.LINK_PATH.$menulink.'.html">'.$rowmenu['title'].'</a></li>';
        }
   ?>
</ul>