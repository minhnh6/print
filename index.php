<?php
session_start();
include('inc/global.php');
$MetaKeywords='Stickers Printing | Folders Printing | Brochures Printing';
$MetaDescriprtion='Stickers Printing | Folders Printing | Brochures Printing';
$MetaTitle='PrintingPeriod | Stickers Printing | Folders Printing | Brochures Printing';
include("inc/header.php");
?>
<section id="main-slider" class="no-margin">
  <div class="carousel slide">
    <ol class="carousel-indicators">
      <li data-target="#main-slider" data-slide-to="0" class="active"></li>
      <li data-target="#main-slider" data-slide-to="1"></li>
      <li data-target="#main-slider" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="item active" style="background-image: url(images/slider/bg1.jpg)"> 
        <!--<div class="container">
                        <div class="row slide-margin">
                            <div class="col-sm-6">
                                <div class="carousel-content">
                                    <h1 class="animation animated-item-1">Lorem ipsum dolor sit amet consectetur adipisicing elit</h1>
                                    <h2 class="animation animated-item-2">Accusantium doloremque laudantium totam rem aperiam, eaque ipsa...</h2>
                                    <a class="btn-slide animation animated-item-3" href="#">Read More</a>
                                </div>
                            </div>

                            <div class="col-sm-6 hidden-xs animation animated-item-4">
                                <div class="slider-img"> 
                                    <img src="images/slider/img1.png" class="img-responsive">
                                </div>
                            </div>

                        </div>
                    </div>--> 
      </div>
      <!--/.item-->
      
      <div class="item" style="background-image: url(images/slider/bg2.jpg)">
        <div class="container">
          <div class="row slide-margin">
            <div class="col-sm-6">
              <div class="carousel-content">
                <h1 class="animation animated-item-1">Lorem ipsum dolor sit amet consectetur adipisicing elit</h1>
                <h2 class="animation animated-item-2">Accusantium doloremque laudantium totam rem aperiam, eaque ipsa...</h2>
                <a class="btn-slide animation animated-item-3" href="#">Read More</a> </div>
            </div>
            <div class="col-sm-6 hidden-xs animation animated-item-4">
              <div class="slider-img"> <img src="images/slider/img2.png" class="img-responsive"> </div>
            </div>
          </div>
        </div>
      </div>
      <!--/.item-->
      
      <div class="item" style="background-image: url(images/slider/bg3.jpg)">
        <div class="container">
          <div class="row slide-margin">
            <div class="col-sm-6">
              <div class="carousel-content">
                <h1 class="animation animated-item-1">Lorem ipsum dolor sit amet consectetur adipisicing elit</h1>
                <h2 class="animation animated-item-2">Accusantium doloremque laudantium totam rem aperiam, eaque ipsa...</h2>
                <a class="btn-slide animation animated-item-3" href="#">Read More</a> </div>
            </div>
            <div class="col-sm-6 hidden-xs animation animated-item-4">
              <div class="slider-img"> <img src="images/slider/img3.png" class="img-responsive"> </div>
            </div>
          </div>
        </div>
      </div>
      <!--/.item--> 
    </div>
    <!--/.carousel-inner--> 
  </div>
  <!--/.carousel--> 
  <a class="prev hidden-xs" href="#main-slider" data-slide="prev"> <i class="fa fa-chevron-left"></i> </a> <a class="next hidden-xs" href="#main-slider" data-slide="next"> <i class="fa fa-chevron-right"></i> </a> </section>
<!--/#main-slider-->
<section id="shipping">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="free-design">
          <div class="free-design-img"> <img src="<?php echo LINK_PATH;?>images/free-design.png"> </div>
          <div class="free-design-text">
            <h2>Free <b> DESIGN</b></h2>
            <p>Services</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="shipping-inner">
          <div class="shipping-inner-img"> <img src="<?php echo LINK_PATH;?>images/shipping-truk.png"> </div>
          <div class="shipping-inner-text">
            <h2>Free <b> SHIPPING</b></h2>
            <p>Services</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="free-design-right">
          <div class="printing-img"> <img src="<?php echo LINK_PATH;?>images/printer.png"> </div>
          <div class="printing-text">
            <h2>Quality<b> PRINTING</b></h2>
            <p>Services</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="printing-periods-products">
  <div class="container">
    <h2>Printing<span>Period</span> Top Products</h2>
    <div class="hor-line">
      <hr>
      <div class="circle"> <span></span> </div>
    </div>
    <div class="row">
    	<?php
		$sqlprd="SELECT products.id,products.ptitle,products.learnmore_top,products.main_image,category.prod_title FROM products 
		INNER JOIN category ON products.cat_id = category.id
		WHERE products.isactive=1 LIMIT 6";
	
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
				<div class=" col-md-4 col-sm-4">
			        <div class="product-description"> <img src="<?php echo LINK_PATH;?><?php echo $rowprd['main_image'];?>">
			          <div class="product-description-inner">
			            <h3><?php echo $rowprd['ptitle'];?></h3>
			            <p><?php echo substr($rowprd['learnmore_top'],0,180);?>...</p>
			            <a href="<?php echo LINK_PATH;?><?php echo $pagemenulink.'/'.$menulink.'.html';?>">View details</a> </div>
			        </div>
					
			       
			      </div>
		<?php } } ?>
    
    
    
      </div>
    </div>
  </div>
</section>
<section id="feature" >
  <div class="container">
    <div class="center wow fadeInDown">
      <h2>Printing<span>period</span>.com</h2>
      <div class="hor-line">
        <hr>
        <div class="circle"> <span></span> </div>
      </div>
      <p class="lead">PrintingPeriod.com is a complete printing solution for all your personal, business and marketing printing needs. With our Head Office in Florida-USA, PrintingPeriod.com has been providing highest quality printing services to customers across the world </p>
    </div>
    <div class="row">
      <div class="features">
        <div class="col-md-6 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
          <div class="feature-wrap"> <img src="<?php echo LINK_PATH;?>images/who.png">
            <h2>Who We Are</h2>
            <p>PrintingPeriod.com is one of the top online printing companies that is in printing business since last one decade. PrintingPeriod.com is serving the diverse printing needs of worldwide consumers by incorporating state-of-the-art printing facilities, innovative designing tools </p>
          </div>
        </div>
        <!--/.col-md-4-->
        
        <div class="col-md-6 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
          <div class="feature-wrap"> <img src="<?php echo LINK_PATH;?>images/Team.png">
            <h2>Our Team</h2>
            <p>PrintingPeriod.com has a pool of creative designers and printing process experts. Utilizing their expertise in the designing and printing fields, our team brings you the top quality printing services. We have a friendly and knowledgeable team of customer services who are available 24/7 to help </p>
          </div>
        </div>
        <!--/.col-md-4-->
        
        <div class="col-md-6 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
          <div class="feature-wrap"> <img src="<?php echo LINK_PATH;?>images/aim.png">
            <h2>Our Aim</h2>
            <p>Our aim is to provide a complete printing solution including designing, copying, printing and finishing of business, personal and marketing materials at the most competitive rates</p>
          </div>
        </div>
        <!--/.col-md-4-->
        
        <div class="col-md-6 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
          <div class="feature-wrap"> <img src="<?php echo LINK_PATH;?>images/umatched-printing.png">
            <h2>Our Unmatched Printing Features</h2>
            <p>PrintingPeriod.com offers a wide range of advantages with its premium quality printing services which makes our printing services second to none</p>
          </div>
        </div>
        <!--/.col-md-4--> 
      </div>
      <!--/.services--> 
    </div>
    <!--/.row--> 
  </div>
  <!--/.container--> 
</section>
<!--/#feature-->
<section id="recent-works">
  <div class="container">
    <div class="center wow fadeInDown">
      <h2>Recent Works</h2>
      <div class="hor-line">
        <hr>
        <div class="circle"> <span></span> </div>
      </div>
      <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut <br>
        et dolore magna aliqua. Ut enim ad minim veniam</p>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="recent-work-wrap"> <img class="img-responsive" src="<?php echo LINK_PATH;?>images/portfolio/recent/item1.png" alt="">
          <div class="overlay">
            <div class="recent-work-inner">
              <h3><a href="#">Business theme</a> </h3>
              <p>There are many variations of passages of Lorem Ipsum available, but the majority</p>
              <a class="preview" href="<?php echo LINK_PATH;?>images/portfolio/full/item1.png" rel="prettyPhoto"><i class="fa fa-eye"></i> View</a> </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="recent-work-wrap"> <img class="img-responsive" src="<?php echo LINK_PATH;?>images/portfolio/recent/item2.png" alt="">
          <div class="overlay">
            <div class="recent-work-inner">
              <h3><a href="#">Business theme</a></h3>
              <p>There are many variations of passages of Lorem Ipsum available, but the majority</p>
              <a class="preview" href="<?php echo LINK_PATH;?>images/portfolio/full/item2.png" rel="prettyPhoto"><i class="fa fa-eye"></i> View</a> </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="recent-work-wrap"> <img class="img-responsive" src="<?php echo LINK_PATH;?>images/portfolio/recent/item3.png" alt="">
          <div class="overlay">
            <div class="recent-work-inner">
              <h3><a href="#">Business theme </a></h3>
              <p>There are many variations of passages of Lorem Ipsum available, but the majority</p>
              <a class="preview" href="<?php echo LINK_PATH;?>images/portfolio/full/item3.png" rel="prettyPhoto"><i class="fa fa-eye"></i> View</a> </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="recent-work-wrap"> <img class="img-responsive" src="<?php echo LINK_PATH;?>images/portfolio/recent/item4.png" alt="">
          <div class="overlay">
            <div class="recent-work-inner">
              <h3><a href="#">Business theme </a></h3>
              <p>There are many variations of passages of Lorem Ipsum available, but the majority</p>
              <a class="preview" href="<?php echo LINK_PATH;?>images/portfolio/full/item4.png" rel="prettyPhoto"><i class="fa fa-eye"></i> View</a> </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="recent-work-wrap"> <img class="img-responsive" src="<?php echo LINK_PATH;?>images/portfolio/recent/item5.png" alt="">
          <div class="overlay">
            <div class="recent-work-inner">
              <h3><a href="#">Business theme</a></h3>
              <p>There are many variations of passages of Lorem Ipsum available, but the majority</p>
              <a class="preview" href="<?php echo LINK_PATH;?>images/portfolio/full/item5.png" rel="prettyPhoto"><i class="fa fa-eye"></i> View</a> </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="recent-work-wrap"> <img class="img-responsive" src="<?php echo LINK_PATH;?>images/portfolio/recent/item6.png" alt="">
          <div class="overlay">
            <div class="recent-work-inner">
              <h3><a href="#">Business theme </a></h3>
              <p>There are many variations of passages of Lorem Ipsum available, but the majority</p>
              <a class="preview" href="<?php echo LINK_PATH;?>images/portfolio/full/item6.png" rel="prettyPhoto"><i class="fa fa-eye"></i> View</a> </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="recent-work-wrap"> <img class="img-responsive" src="<?php echo LINK_PATH;?>images/portfolio/recent/item7.png" alt="">
          <div class="overlay">
            <div class="recent-work-inner">
              <h3><a href="#">Business theme </a></h3>
              <p>There are many variations of passages of Lorem Ipsum available, but the majority</p>
              <a class="preview" href="<?php echo LINK_PATH;?>images/portfolio/full/item7.png" rel="prettyPhoto"><i class="fa fa-eye"></i> View</a> </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="recent-work-wrap"> <img class="img-responsive" src="<?php echo LINK_PATH;?>images/portfolio/recent/item8.png" alt="">
          <div class="overlay">
            <div class="recent-work-inner">
              <h3><a href="#">Business theme </a></h3>
              <p>There are many variations of passages of Lorem Ipsum available, but the majority</p>
              <a class="preview" href="<?php echo LINK_PATH;?>images/portfolio/full/item8.png" rel="prettyPhoto"><i class="fa fa-eye"></i> View</a> </div>
          </div>
        </div>
      </div>
    </div>
    <!--/.row--> 
  </div>
  <!--/.container--> 
</section>
<!--/#recent-works-->
<section class="testimonials" id="testimonials">
  <div class="container">
    <h2>What Our <span>Client Say</span></h2>
    <div class="row">
      <div class="col-md-3 col-sm-3">
        <div  class="testimonial-inner"> <img src="<?php echo LINK_PATH;?>images/client1.jpg">
          <h4>Antony Moore</h4>
          <div class="video-opner"> <a href="http://www.youtube.com/watch?v=6w4FI0Jq0lI" role="button"><img src="<?php echo LINK_PATH;?>images/video-opner.png"></a> </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-3">
        <div  class="testimonial-inner"> <img src="<?php echo LINK_PATH;?>images/client2.jpg">
          <h4>Bryan Thompson</h4>
          <div class="video-opner"> <a href="http://www.youtube.com/watch?v=6w4FI0Jq0lI" role="button"><img src="<?php echo LINK_PATH;?>images/video-opner.png"></a> </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-3">
        <div  class="testimonial-inner"> <img src="<?php echo LINK_PATH;?>images/client3.jpg">
          <h4>Ann Smith</h4>
          <div class="video-opner"> <a href="http://www.youtube.com/watch?v=6w4FI0Jq0lI" role="button"><img src="<?php echo LINK_PATH;?>images/video-opner.png"></a> </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-3">
        <div  class="testimonial-inner"> <img src="<?php echo LINK_PATH;?>images/client4.jpg">
          <h4>Alice Brown</h4>
          <div class="video-opner"> <a href="http://www.youtube.com/watch?v=6w4FI0Jq0lI" role="button"><img src="<?php echo LINK_PATH;?>images/video-opner.png"></a> </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="social-media">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-sm-6">
        <div class="social-media-iner">
          <h2>Follow  On Social Media</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipisci</p>
        </div>
      </div>
      <div class="col-md-6 col-sm-6">
        <div class="social-icons">
          <ul>
            <li><i class="fa fa-facebook" aria-hidden="true"></i></li>
            <li><i class="fa fa-twitter" aria-hidden="true"></i></li>
            <li><i class="fa fa-linkedin" aria-hidden="true"></i></li>
            <li><i class="fa fa-google-plus" aria-hidden="true"></i></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
include("inc/footer.php");
?>