            <div id="firstpane" class="menu_list"> <!--Code for menu starts here-->
                <div class="submenu_head"><a href="?section=dashboard" style="text-decoration: none;">Dashboard</a></div>
                <div style="position:relative;"><img src="images/splitter8.gif" width="184" height="1" /></div>
                <div class="submenu_head" style="background: url(images/arrow4.gif) 90% center  no-repeat;">Category</div>
                <div class="submenu_body"<?php echo ($_GET['section']=="category"?" style=\"display:block;\"":""); ?>>
                    <ul class="SubMenuList">
                        <li><a href="?section=category&a=add">Add Category</a></li>
                        <li><a href="?section=category">Edit Category</a></li>
                    </ul>
                </div>
                <div style="position:relative;"><img src="images/splitter8.gif" width="184" height="1" /></div>
                <div class="submenu_head" style="background: url(images/arrow4.gif) 90% center  no-repeat;">Options</div>
                <div class="submenu_body"<?php echo ($_GET['section']=="options"?" style=\"display:block;\"":""); ?>>
                    <ul class="SubMenuList">
                        <li><a href="?section=options&do=optiontype&a=add">Add Option Type</a></li>
                        <li><a href="?section=options&do=optiontype">Edit Option Type</a></li>
                        <li><a href="?section=options&do=optionvalue&a=add">Add Option Value</a></li>
                        <li><a href="?section=options&do=optionvalue">Edit Option Value</a></li>
                    </ul>
                </div>  
                <div style="position:relative;"><img src="images/splitter8.gif" width="184" height="1" /></div>
                <div class="submenu_head" style="background: url(images/arrow4.gif) 90% center  no-repeat;">Products</div>
                <div class="submenu_body"<?php echo ($_GET['section']=="products"?" style=\"display:block;\"":""); ?>>
                    <ul class="SubMenuList">
                        <li><a href="?section=products&a=add">Add Product</a></li>
                        <li><a href="?section=products">Edit Product</a></li>
                    </ul>
                </div>
                <div style="position:relative;"><img src="images/splitter8.gif" width="184" height="1" /></div>                    
                <div class="submenu_head" style="background: url(images/arrow4.gif) 90% center  no-repeat;">Pages</div>
                <div class="submenu_body"<?php echo ($_GET['section']=="pages" || $_GET['section']=="recyclebin" || $_GET['section']=="sortmenu"?" style=\"display:block;\"":""); ?>>
                <?php 
				$sql = mysql_query("SELECT * FROM pages");
				$queryresult = mysql_num_rows($sql);
				
				if(!$queryresult) {					
					$total = "(0)";
				} else {
					$total = "(" . $queryresult . ")";
				}
				?>
                    <ul class="SubMenuList">
                        <li><a href="?section=pages&a=add">Add Page</a></li>
                        <li><a href="?section=pages">Edit Page</a></li>
                    </ul>
                </div> 
                <div style="position:relative;"><img src="images/splitter8.gif" width="184" height="1" /></div>
                <div class="submenu_head" style="background: url(images/arrow4.gif) 90% center  no-repeat;">Shop</div>
                <div class="submenu_body"<?php echo ($_GET['section']=="shop"?" style=\"display:block;\"":""); ?>>
                    <ul class="SubMenuList">
                        <li><a href="?section=shop&do=customers&a=add">Add Customer</a></li>
                        <li><a href="?section=shop&do=customers">Edit Customer</a></li>
                        <li><a href="?section=shop&do=orders">View Orders</a></li>
                    </ul>
                </div>   
                <div style="position:relative;"><img src="images/splitter8.gif" width="184" height="1" /></div>
                <div class="submenu_head" style="background: url(images/arrow4.gif) 90% center  no-repeat;">Sliders</div>
                <div class="submenu_body"<?php echo ($_GET['section']=="sliders"?" style=\"display:block;\"":""); ?>>
                    <ul class="SubMenuList">
                        <li><a href="?section=sliders&a=add">Add Slider</a></li>
                        <li><a href="?section=sliders">Edit Slider</a></li>
                    </ul>
                </div>
                <div style="position:relative;"><img src="images/splitter8.gif" width="184" height="1" /></div>
                <div class="submenu_head"><a href="?section=changepassword" style="text-decoration: none;">Change Password</a></div>                   
                <div style="position:relative;"><img src="images/splitter8.gif" width="184" height="1" /></div>
                <div class="submenu_head"><a href="?section=settings" style="text-decoration: none;">Settings</a></div>   
                <div style="position:relative;"><img src="images/splitter8.gif" width="184" height="1" /></div>                              
                <div class="submenu_head"><a href="?section=logout" style="text-decoration: none;">Logout</a></div>                                   
            </div>	