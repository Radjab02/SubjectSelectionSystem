<?php
session_start();
?>
<!DOCTYPE html>
<html >
  <head >
    
	 <meta charset="UTF-8">
	 
    <title> Welcome To Subject Selection System</title>
   
        <link rel="stylesheet" href="css/style_login.css"> 


  </head>

<body>


  
    <div class="wrapper">
	<div class="container">
		<h1>Welcome</h1>
	
		<form class="form" ENCTYPE=multipart/form-data ACTION=process_login.php METHOD=post >
			<input name=User type=text placeholder="username">
			<input name=password type="password" placeholder="password">
			<button type="submit" id="login-button" value="submit_login">Login</button>
			<br><?php if (isset($_SESSION['check_login']))  echo "<h2>",$_SESSION['check_login'],"</h2>" ;  $_SESSION['check_login']=" "; ?>				
		</form>
	</div>
	
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
  
        <script src="js/index.js"></script>
    
    
  </body>
</html>
