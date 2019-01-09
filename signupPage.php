<?php
/*
sign up page
backend by Arselan (php libraries used from php website).
Front end by Austin
*/
require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

 //create customer (html by professor)

 if ( isset($_POST['lastName']) &&isset($_POST['firstName']) && isset($_POST['userName']) &&isset($_POST['password']))

 {
		$lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
		$firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
		$userName = mysqli_real_escape_string($conn, $_POST['userName']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$query = "INSERT INTO customer VALUES(NULL,'$lastName','$firstName','$userName',SHA1('$password'),'',50)";
	#	$query = "INSERT INTO customer VALUES(NULL,'miller','james','charlie123','123','admin')";
		$result = $conn->query($query);
		if (!$result) echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
		
		
		header("location: loginPage.php");
	
		
 }

?>
	<html>
	<head>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">	
		<style type="text/css">
			@font-face{font-family:'Calluna';
 src:url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/4273/callunasansregular-webfont.woff') format('woff');
}
body {
	background: url(//subtlepatterns.com/patterns/scribble_light.png);
  font-family: Calluna, Arial, sans-serif;
  min-height: 1000px;
}
#columns {
	column-width: 320px;
	column-gap: 15px;
  width: 90%;
	max-width: 1100px;
	margin: 50px auto;
}

div#columns figure {
	background: #fefefe;
	border: 2px solid #fcfcfc;
	box-shadow: 0 1px 2px rgba(34, 25, 25, 0.4);
	margin: 0 2px 15px;
	padding: 15px;
	padding-bottom: 10px;
	transition: opacity .4s ease-in-out;
  display: inline-block;
  column-break-inside: avoid;
}

div#columns figure img {
	width: 100%; height: auto;
	border-bottom: 1px solid #ccc;
	padding-bottom: 15px;
	margin-bottom: 5px;
}

div#columns figure figcaption {
  font-size: .9rem;
	color: #444;
  line-height: 1.5;
}

div#columns small { 
  font-size: 1rem;
  float: right; 
  text-transform: uppercase;
  color: #aaa;
} 

div#columns small a { 
  color: #666; 
  text-decoration: none; 
  transition: .4s color;
}

div#columns:hover figure:not(:hover) {
	opacity: 0.4;
}

@media screen and (max-width: 750px) { 
  #columns { column-gap: 0px; }
  #columns figure { width: 100%; }
}
		</style>
	</head>
		<body>
			<div class="container ml-5">
				<h1>Sign Up</h1>
				<br>
				<form action="signupPage.php" method="post">
					<row>
						<p>Username</p> <input class="" type="text" name="userName">
					</row>
					<row>
						<p>Password</p> <input type="password" name="password">
					</row>
					<row>
						<p>First Name</p> <input type="text" name="firstName">
					</row>
					<row>
						<p>Last Name</p> <input type="text" name="lastName">
					</row>
					
				<button class="btn waves-effect waves-light" type="submit" value="ADD RECORD">Register</button>
				</form>
				<p>Already a member? <a href="loginPage.php">Login</a></p>
			</div>
		</body>
	<footer>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	</footer>
</html>