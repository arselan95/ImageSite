	<?php
/*
login page
backend by Arselan (php libraries used from php website).
Front end by Austin
*/
session_start();
require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);


$_SESSION["user"]="";
$_SESSION["pass"]="";


if (isset($_POST['username']) && isset($_POST['password']))
{
	//$user="";
	//$pass="";
	
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	 $passwordunhash=SHA1($password);
	// echo $passwordunhash."</br>";
	
	$query = "SELECT userName from customer where userName='$username'";
		$result1 = $conn->query($query);
		while ($row = $result1->fetch_assoc()) {
		//	echo $row['userName']."<br>";
			$_SESSION["user"]=$row['userName'];
			}
			
			
			$query = "SELECT password from customer where password='$passwordunhash'";
		$result2 = $conn->query($query);
		while ($row = $result2->fetch_assoc()) {
			//echo $row['password']."<br>";
			$_SESSION["pass"]=$row['password'];
			}

			
	
	
	if ($username==$_SESSION["user"] && $passwordunhash===$_SESSION["pass"])
	{
		session_start();
        $_SESSION["authenticated"] = 'true';
		header("location: startScreen.php");
	}
	else
	{
		$message = "Incorrect Username or Password";
		echo "<script type='text/javascript'>alert('$message');</script>";
	}
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
		<div class="container">
			<h1>Login</h1>
			<br>
			<form action="loginPage.php" method="post">
				<row>
					<p>Username</p> <input class="validate" type="text" name="username">
				</row>
				</row>
					<p>Password</p> <input class="validate" type="password" name="password">
				</row>
				<button class="btn waves-effect waves-light" type="submit" value="">Login</button>
			</form>
			<p>Not a member? <a href="signupPage.php"> Sign Up</a></p>

		</div>
	</body>
	<footer>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	</footer>
</html>
