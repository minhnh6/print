<?php
session_start();
include('inc/global.php');
$PageId=$_GET['page'];
$sqlpage="SELECT * FROM pages WHERE id='".$PageId."'";
$respage=mysql_query($sqlpage);
$rowpage=mysql_fetch_assoc($respage);
$MetaKeywords='Stickers Printing | Folders Printing | Brochures Printing';
$MetaDescriprtion='Stickers Printing | Folders Printing | Brochures Printing';
$MetaTitle=$rowpage['headertitle'].' : PrintingPeriod | Stickers Printing | Folders Printing | Brochures Printing';
include("inc/header.php");


?>

<section id="feature" >
  <div class="container">
    <div class="center wow fadeInDown">
      <h2>Printing<span>period</span>.com</h2>
      <div class="hor-line">
        <hr>
        <div class="circle"> <span></span> </div>
      </div>
      <p class="lead">Sum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis </p>
    </div>
    <div class="row">
      <div class="features">
        <div class="col-md-6 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
          <div class="feature-wrap"> <img src="images/who.png">
            <h2>Who We Are</h2>
            <p>PrintingPeriod.com is one of the top online printing companies that is in printing business since last one decade. PrintingPeriod.com is serving the diverse printing needs of worldwide consumers by incorporating state-of-the-art printing facilities, innovative designing tools </p>
          </div>
        </div>
        <!--/.col-md-4-->
        
        <div class="col-md-6 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
          <div class="feature-wrap"> <img src="images/Team.png">
            <h2>Our Team</h2>
            <p>PrintingPeriod.com has a pool of creative designers and printing process experts. Utilizing their expertise in the designing and printing fields, our team brings you the top quality printing services. We have a friendly and knowledgeable team of customer services who are available 24/7 to help </p>
          </div>
        </div>
        <!--/.col-md-4-->
        
        <div class="col-md-6 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
          <div class="feature-wrap"> <img src="images/aim.png">
            <h2>Our Aim</h2>
            <p>Our aim is to provide a complete printing solution including designing, copying, printing and finishing of business, personal and marketing materials at the most competitive rates</p>
          </div>
        </div>
        <!--/.col-md-4-->
        
        <div class="col-md-6 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
          <div class="feature-wrap"> <img src="images/umatched-printing.png">
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
<!--/#Features-->
<section class="skills">
  <div class="container"> 
    <!-- Our Skill -->
    <div class="skill-wrap clearfix">
      <div class="center wow fadeInDown">
        <h2>Our Skill</h2>
        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut <br>
          et dolore magna aliqua. Ut enim ad minim veniam</p>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="sinlge-skill wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
            <div class="joomla-skill">
              <p><em>85%</em></p>
              <p>Joomla</p>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="sinlge-skill wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="html-skill">
              <p><em>95%</em></p>
              <p>HTML</p>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="sinlge-skill wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="900ms">
            <div class="css-skill">
              <p><em>80%</em></p>
              <p>CSS</p>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="sinlge-skill wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="1200ms">
            <div class="wp-skill">
              <p><em>90%</em></p>
              <p>Game Designing</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/.our-skill--> 
  </div>
</section>
<?php
include("inc/footer.php");
?>