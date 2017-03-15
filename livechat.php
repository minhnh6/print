<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>Printing Periods</title>

<!-- core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link href="css/main.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link rel="shortcut icon" href="images/ico/favicon.ico">
</head>
<!--/head-->

<body class="homepage">
<nav class="navbar navbar-inverse" role="banner">
  <div class="container">
    <div class="chat-logo"> <a href="/"><img src="images/logo.png"></a> </div>
  </div>
</nav>
<div class="container">
  <div class="chat-title">
    <h1>Welcome to Printingperiod Online Support!</h1>
  </div>
  <div class="chat-description">
    <form>
      <div class="form-group">
        <label for="sel1">Please select the department you would like to reach: </label>
        <select class="form-control" id="sel1">
          <option>Please select the department you would like to reach:</option>
          <option>Customer Service</option>
          <option>Technical Support</option>
        </select>
      </div>
      <div class="form-group">
        <label for="usr">Your Name: </label>
        <input type="text" class="form-control" id="usr" required>
      </div>
      <div class="form-group">
        <label for="comment">Your Query:</label>
        <textarea class="form-control" rows="5" id="comment" required></textarea>
      </div>
      <button type="button">Start Chat</button>
    </form>
  </div>
</div>
<script src="js/jquery.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/scripts.js"></script>
</body>
</html>