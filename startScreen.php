<?php

/*
start screen that shows the trending images and latest uploads
backend by Arselan (php libraries used from php website).
Front end by Austin
*/
require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

require_once('authenticate.php');

$_SESSION["tmpid"]="";
$tmp= $_SESSION["user"];
$p= $_SESSION["pass"];
$tcustcre;

//credits
 $query = "SELECT * from customer where userName='$tmp' and password='$p'";
	$result = $conn->query($query);
	while ($row = $result->fetch_assoc()) {
			//echo "Welcome ".$tmp." , id: ".$row['id']."<br>";
			$ti=$row['id'];
			$tcustcre=$row['credits'];
			}
	if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";

//trending
	


$query = "SELECT id from customer where userName='$tmp' and password='$p'";
	$result = $conn->query($query);
	while ($row = $result->fetch_assoc()) {
			//echo "Welcome ".$tmp." , id: ".$row['id']."<br>";
			$_SESSION["tmpid"]=$row['id'];
			}
	if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";
	
	
	//choose
	if (isset($_POST['choose'])&& isset($_POST['category']) && isset($_POST['source']) )
{
	$ca = mysqli_real_escape_string($conn, $_POST['category']);
	//echo $ca;
	//echo "</br>";
	$source = mysqli_real_escape_string($conn, $_POST['source']);
	//echo $source;
	
	
	$query = "SELECT * from music where source='$source'";
	$result = $conn->query($query);
	$sou=array();
	$value=array();
	while ($row = $result->fetch_assoc()) {
			//echo "Welcome ".$tmp." , id: ".$row['id']."<br>";
			//$_SESSION["tmpid"]=$row['id'];
			$sou[]=$row['source'];
			}
			//echo $sou;
	if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";
	
	if(in_array($source, $sou)!==false)
	{
	$query = "SELECT * from music where source='$source'";
	$result = $conn->query($query);
	while ($row = $result->fetch_assoc()) {
			//echo "Welcome ".$tmp." , id: ".$row['id']."<br>";
			//$_SESSION["tmpid"]=$row['id'];
			$iid=$row['id'];
			$t=$row['resolution'];
		$u=$row['size'];
		$sou=$row['source'];
		$w=$row['category'];
		$x=$row['credits'];
			}
			//echo $sou;
	if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";	
	$query ="INSERT INTO cart VALUES('$iid','$t','$u','$sou','$w','$x')";
		$result = $conn->query($query);
		if (!$result) echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
		

	if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";
	}
	else{
		$message = "Image Sold Out";
		echo "<script type='text/javascript'>alert('$message');</script>";
	}
	


}
	

if (isset($_POST['search']) && isset($_POST['enter']))
{
	$t=array();
	$q=array();
	$value=array();
	$val="";
	$category = get_post($conn, 'enter');
	//echo $category;
	echo "</br>";
	//$query = "SELECT * FROM music WHERE category='$category'";
	$query = "SELECT * FROM music";
	$result = $conn->query($query);
	if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";
	$rows = $result->num_rows;
	while ($row = $result->fetch_assoc()) {
			
		$q[]= $row['source'];
		foreach($q as $value)
		{
			$value=strtolower(substr($value, 0, -4));
			
		}
		$test[]=$value;
		//echo $value;
		//$val=$value;
		
		$t[]=$row['category'];
		//echo $q;
		
		//print_r ($t);
	}
	echo "</br>";

	if(in_array($category, $t)!==false)
	{

	$query = "SELECT * FROM music WHERE category like '$category'";
	$result = $conn->query($query);
	if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";	
	}
	if(in_array($category, $test)!==false)
	{
		//echo $category;
		echo "</br>";
		echo $val;
	echo "yes";
	$query = "SELECT * from music where LOWER(substr(source from 1 for char_length(source)-4)) = LOWER('$category')";
	$result = $conn->query($query);
	if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";	
	}
}

	
	if (isset($_POST['trending']))
{
	$query = "select * from transaction group by source order by count(*) desc;";
	$result = $conn->query($query);
	if (!$result) echo "Select failed: $query<br>" . $conn->error . "<br><br>";
	$rows = $result->num_rows;
		echo "Items bought: ";
		while ($row = $result->fetch_assoc()) {
			
		$q= $row['orderNumber'];
		$t=$row['customerID'];
		$u=$row['imageID'];
		$v=$row['transactionDate'];
	}

	
		
		for ($j = 0 ; $j < $rows ; ++$j)
		{
			$result->data_seek($j);
			$row = $result->fetch_array(MYSQLI_NUM);
echo <<<_END
<div class=column style=float:left;padding:10 10 10 10>
<pre>
source: $row[3]
<img src= $row[3] alt="HTML5 Icon" style="width:128px;height:128px">

</pre>
<form action="itemsBought.php" method="post">
<input type="hidden" name="choose" value="yes">
<input type="hidden" name="source" value="$row[3]">
<input type="submit" value="CHOOSE RECORD">
</form>
</div>
_END;
			}
			
			$result->close();
			$conn->close();
			function get_post($conn, $var){return $conn->real_escape_string($_POST[$var]);
			}	
	}
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css" integrity="sha384-aOkxzJ5uQz7WBObEZcHvV5JvRW3TUc2rNPA7pe3AwnsUohiw1Vj2Rgx2KSOkF5+h" crossorigin="anonymous">

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
	<!--NAVBAR-->
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
  		<h2 class="display-5"><a class="navbar-brand" href="startScreen.php">Welcome to Aurora</a></h2>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		 </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav mr-auto">
		      <li class="nav-item">
		        <a class="nav-link" href="startScreen.php">Home <span class="sr-only">(current)</span></a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="ImageTest.php">Share</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="ItemsBought.php">Purchases</a>
		      </li>   
		      <li class="nav-item"> 
			      <a class="nav-link" href="search.php">Search</a>
			  </li>
			  <li class="nav-item" style="position: absolute; right: 0">
		      	<div>
		      		<a href="cart.php"><button class="btn btn-success mr-2"><i class="fa fa-shopping-cart mr-2"></i>Cart</button></a>
		      	</div>
		      </li>
		       <li class="nav-item mr-5" style="position: absolute; right: 0">
		      	<div class="dropdown mr-5">
		      		<button class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Welcome, <?= $tmp ?>
		      		</button>
		      		<div class="dropdown-menu">
		      			<a class="dropdown-item" href="#">Wallet: $<?= $tcustcre ?></a>
					    <div class="dropdown-divider"></div>
					    <a class="dropdown-item" href="cart.php">Cart</a>
					    <a class="dropdown-item" href="ItemsBought.php">Purchases</a>
					    <a class="dropdown-item" href="ImageTest.php">Upload</a>
					    <div class="dropdown-divider"></div>
					    <a class="dropdown-item" href="adminProfile.php">Admin</a>
					    <a class="dropdown-item" href="logout.php">Logout</a>
					</div>
		      	</div>
		      </li>
		    </ul>
		  </div>
	</nav>
	<h2 class="ml-5 mt-3" style="position: center">Trending</h2>
	<div id="columns" class="row">
		<?php
		
		//here i display images that were purchased the most during this week. (would be useful for bussiness)
			$query = "select * from transaction where transactionDate between '2018-12-12' and '2018-12-13'  group by source order by count(*) desc";
	$result = $conn->query($query);
	if (!$result) echo "Select failed: $query<br>" . $conn->error . "<br><br>";
		while ($row = $result->fetch_assoc()) {
			
		$q= $row['source'];
		$c[]=$row['category'];
		$newq[]=substr_replace($q, 'new.png',-4);
	}
	//print_r($newq);
	foreach ($newq as $k => $v) {
	$query ="INSERT INTO trending VALUES(NULL,'$newq[$k]','$c[$k]')";
	$result = $conn->query($query);
	if (!$result) echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
	
	$query = "SELECT * FROM trending";
		$result = $conn->query($query);
		if (!$result) die ("Database access failed: " . $conn->error);
		$rows = $result->num_rows;
		
		for ($j = 0 ; $j < $rows ; ++$j)
		{
			
			$result->data_seek($j);
			$row = $result->fetch_array(MYSQLI_NUM);
			//$g=$row[3];
			//echo '<img src="'.$g.'" alt="HTML5 Icon" style="width:128px;height:128px">';
echo <<<_END

<figure>
<div class="column ml-2 mb-5 mt-2" style=float:left;padding:10 10 10 10>
	<div class="card" style="">
	  <img class="card-img-top" height ="150" width = "42" src= $row[1] alt="HTML5 Icon">
	  <div class="card-body">
	    <form action="startScreen.php" method="post">
			<input type="hidden" name="choose" value="yes">
			<input type="hidden" name="source" value="$row[1]">
			<input type="hidden" name="category" value="$row[2]">
			<button class = "btn btn-outline-success" type="submit">Add to Cart</button>
		</form>
	  </div>
	</div>
</div>
</figure>
_END;

			}
				$query = "delete  FROM trending";
		$result = $conn->query($query);
		if (!$result) die ("Database access failed: " . $conn->error);	
	}
		?>
		
	</div>
	<h2 class="ml-5">Latest Uploads</h2>
	<div id="columns" class="row">
		<?php
		//show latest uploads on main page
			$query = "select * from music order by postDate desc";
	$result = $conn->query($query);
	if (!$result) echo "Select failed: $query<br>" . $conn->error . "<br><br>";
		while ($row = $result->fetch_assoc()) {
			
		$tsour[]= $row['source'];
		$tcat[]=$row['category'];
		//$newq[]=substr_replace($q, 'new.png',-4);
	}
	//print_r($newq);
	foreach ($tsour as $k => $v) {
	$query ="INSERT INTO trending VALUES(NULL,'$tsour[$k]','$tcat[$k]')";
	$result = $conn->query($query);
	if (!$result) echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
	
	$query = "SELECT * FROM trending";
		$result = $conn->query($query);
		if (!$result) die ("Database access failed: " . $conn->error);
		$rows = $result->num_rows;
		
		for ($j = 0 ; $j < $rows ; ++$j)
		{
			
			$result->data_seek($j);
			$row = $result->fetch_array(MYSQLI_NUM);
			//$g=$row[3];
			//echo '<img src="'.$g.'" alt="HTML5 Icon" style="width:128px;height:128px">';
echo <<<_END

<figure>
<div class="column ml-2 mb-5 mt-2" style=float:left;padding:10 10 10 10>
	<div class="card" style="">
	  <img class="card-img-top" height = "150" width = "42" src= $row[1] alt="HTML5 Icon">
	  <div class="card-body">
	    <form action="startScreen.php" method="post">
			<input type="hidden" name="choose" value="yes">
			<input type="hidden" name="source" value="$row[1]">
			<input type="hidden" name="category" value="$row[2]">
			<button class = "btn btn-outline-success" type="submit">Add to Cart</button>
		</form>
	  </div>
	</div>
</div>
</figure>
_END;

			}
				$query = "delete  FROM trending";
		$result = $conn->query($query);
		if (!$result) die ("Database access failed: " . $conn->error);	
	}
		?>
		
	</div>
</body>
<footer>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</footer>
</html>