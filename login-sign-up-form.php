<?php
session_start();
include('inc/global.php');
$MetaKeywords='Stickers Printing | Folders Printing | Brochures Printing';
$MetaDescriprtion='Stickers Printing | Folders Printing | Brochures Printing';
$MetaTitle='PrintingPeriod | Stickers Printing | Folders Printing | Brochures Printing';
include("inc/header.php");
?>
<section class="login-register">
  <div class="container">
    <div class="login-register-title">
      <h1>Login or Register</h1>
    </div>
    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="login-form">
          <form>
            <h4>Returning Customers</h4>
            <p>Please login below to continue:</p>
            <div class="form-group">
              <label for="usr">Email Address:</label>
              <input type="email" class="form-control" id="usr" placeholder="Email">
            </div>
            <div class="form-group">
              <label for="usr">Password</label>
              <input type="password" class="form-control" id="usr" placeholder="Password">
            </div>
            <button type="submit">Login</button>
            <a href="#" data-toggle="modal" data-target="#forgot-password">Forgot Password?</a>
          </form>
        </div>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="register-form">
          <form>
            <h4>Returning Customers</h4>
            <p>Please login below to continue:</p>
            <div class="form-group">
              <label for="usr">First Name:</label>
              <input type="text" class="form-control" id="usr" placeholder="First Name">
            </div>
            <div class="form-group">
              <label for="usr">Last Name:</label>
              <input type="text" class="form-control" id="usr" placeholder="Last Name">
            </div>
            <div class="form-group">
              <label for="usr">Email Address:</label>
              <input type="email" class="form-control" id="usr" placeholder="Email">
            </div>
            <div class="form-group">
              <label for="usr">Phone Number</label>
              <input type="email" class="form-control" id="usr" placeholder="(888) 888-8888">
            </div>
            <div class="form-group">
              <label for="usr">Password</label>
              <input type="password" class="form-control" id="usr" placeholder="Password">
            </div>
            <button type="submit">Create Account</button>
            <p> By clicking "Create Account" you are agreeing to PrintRunner's <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>. PrintRunner.com may send you discounts and other offers. </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include('inc/footer.php'); ?>
