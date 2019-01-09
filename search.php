<?php
/*
search images by name or category
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

//credits
 $query = "SELECT * from customer where userName='$tmp' and password='$p'";
	$result = $conn->query($query);
	while ($row = $result->fetch_assoc()) {
			//echo "Welcome ".$tmp." , id: ".$row['id']."<br>";
			$ti=$row['id'];
			$tcustcre=$row['credits'];
			}
	if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";

	if (isset($_POST['choose']) && isset($_POST['id']))
{
	$id = get_post($conn, 'id');
	$query = "SELECT * FROM music WHERE id='$id'";
	$result = $conn->query($query);
	
	while ($row = $result->fetch_assoc()) {
		$s=$row['id'];	
		$t=$row['resolution'];
		$u=$row['size'];
		$v=$row['source'];
		$w=$row['category'];
		$x=$row['credits'];
	}
	
	 $query ="INSERT INTO cart VALUES('$s','$t','$u','$v','$w','$x')";
		$result = $conn->query($query);
		if (!$result) echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
		
	//	$query = "DELETE FROM music WHERE id='$s'";
	//$result = $conn->query($query);
	//if (!$result) echo "DELETE failed: $query<br>" . $conn->error . "<br><br>";
		

	}

//search
echo <<<_END
_END;
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css" integrity="sha384-aOkxzJ5uQz7WBObEZcHvV5JvRW3TUc2rNPA7pe3AwnsUohiw1Vj2Rgx2KSOkF5+h" crossorigin="anonymous">
	<style type="text/css">
		@import url(https://fonts.googleapis.com/css?family=Open+Sans);

	body{
	  background: #f2f2f2;
	  font-family: 'Open Sans', sans-serif;
	}

	.search {
	  width: 100%;
	  position: relative
	}

	.searchTerm {
	  float: left;
	  width: 100%;
	  border: 3px solid #28a745;
	  padding: 5px;
	  height: 40px;
	  border-radius: 5px;
	  outline: none;
	  color: #28a745;
	}

	.searchTerm:focus{
	  color: #000000;
	}

	.searchButton {
	  position: absolute;  
	  right: -30px;
	  width: 40px;
	  height: 38px;
	  border: 1px solid #28a745;
	  background: #28a745;
	  text-align: center;
	  color: #fff;
	  border-radius: 5px;
	  cursor: pointer;
	  font-size: 20px;
	}

	/*Resize the wrap to see the search bar change!*/
	.wrap{
	  width: 30%;
	  position: absolute;
	  top: 50%;
	  left: 50%;
	  transform: translate(-50%, -50%);
	}

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
			      <a class="nav-link" href="searchTransaction.php">Search</a>
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
		   <div class="container-fluid col-5 search ml-5" style="position: fixed; left: 0">
		   	<h4 class="mt-2">Search</h4>
		   	<form class="" method="post">
			      <input type="text" name="enter" class="searchTerm" placeholder="What are you looking for?">
			      <button type="submit" name="search" class="searchButton">
			        <i class="fa fa-search"></i>
			     </button>
		     </form>
		   </div>
	<div id="columns" class="row">
	<?php
	
	//search by category then by name
if (isset($_POST['search']) && isset($_POST['enter']))
{
	$t=array();
	$q=array();
	$y=array();
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
			$value=strtolower(substr($value, 0, -7));
			
		}
		$test[]=$value;
		//echo $value;
		//$val=$value;
		
		$t[]=$row['category'];
		$y[]=$row['contrib'];
		//echo $q;
		
		//print_r ($t);
	}
	echo "</br>";
	//print_r($t);
	//print_r($test);
	//echo $category;
	if(in_array($category, $t)!==false)
	{

	$query = "SELECT * FROM music WHERE category like '$category'";
	$result = $conn->query($query);
	if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";
while ($row = $result->fetch_assoc()) {
		$q[]= $row['source'];
		foreach($q as $value)
		{
			$value=strtolower(substr($value, 0, -7));
			
		}
		$test[]=$value;
	}	
	$rows = $result->num_rows;
	for ($j = 0 ; $j < $rows ; ++$j)
		{
			$result->data_seek($j);
			$row = $result->fetch_array(MYSQLI_NUM);
			$g[]=$row[3];
			foreach($g as $value)
		{
			$value=substr($value, 0, -7);
			
		}
echo <<<_END
<figure class ="mt-5">
<div class="card mt-5 ml-3">
	<img class = "card-image-top" src= $row[3] alt="HTML5 Icon" style="width:128px;height:128px">
	<div class="card-body">
	    <h5 class="card-title">$value</h5>
	    <p class="card-text">id: $row[0]</p>
	    <p class="card-text">resolution: $row[1]</p>
	    <p class="card-text">size: $row[2]</p>
	    <p class="card-text">category: $row[4]</p>
		<p class="card-text">credits: $row[5]</p>
		<p class="card-text">source: $row[7]</p>
		<form class = "mt-2 mb-2" action="search.php" method="post">
			<input type="hidden" name="choose" value="yes">
			<input type="hidden" name="id" value="$row[0]">
			<button class = "btn btn-outline-success" onclick = "myFunction()" type="submit">Add to Cart</button>
		</form>
		<form action="search.php" method="post">
			<input type="hidden" name="delete" value="yes">
			<input type="hidden" name="id" value="$row[0]">
			<input type="hidden" name="resolution" value="$row[1]">
			<input type="hidden" name="size" value="$row[2]">
			<input type="hidden" name="source" value="$row[3]">
			<input type="hidden" name="category" value="$row[4]">
			<input type="hidden" name="credits" value="$row[5]">
			<input type="hidden" name="source" value="$row[7]">
			<button class="btn btn-outline-danger  btn-sm" type="submit">Delete</button>
		</form>
	  </div>
</div>
</figure>
_END;
			}		
	}
	
	//echo $category;
	 if(in_array($category, $test)!==false)
	{
		//echo $category;
		echo "</br>";
		echo $val;
	//echo "yes";
	$query = "SELECT * from music where LOWER(substr(source from 1 for char_length(source)-7)) = LOWER('$category')";
	$result = $conn->query($query);
	if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";	
	while ($row = $result->fetch_assoc()) {
		$q[]= $row['source'];
		foreach($q as $value)
		{
			$value=strtolower(substr($value, 0, -7));
			
		}
		$test[]=$value;
	}
	$rows = $result->num_rows;
	for ($j = 0 ; $j < $rows ; ++$j)
		{
			$result->data_seek($j);
			$row = $result->fetch_array(MYSQLI_NUM);
			$g[]=$row[3];
			foreach($g as $value)
		{
			$value=substr($value, 0, -7);
			
		}
echo <<<_END
<figure class = "mt-5">
<div class="card mt-5 ml-3">
	<img class = "card-image-top" src= $row[3] alt="HTML5 Icon" style="width:128px;height:128px">
	<div class="card-body">
	    <h5 class="card-title">$value</h5>
	    <p class="card-text">id: $row[0]</p>
	    <p class="card-text">resolution: $row[1]</p>
	    <p class="card-text">size: $row[2]</p>
	    <p class="card-text">category: $row[4]</p>
		<p class="card-text">credits: $row[5]</p>
				<p class="card-text">source: $row[7]</p>
		<form class = "mt-2 mb-2" action="search.php" method="post">
			<input type="hidden" name="choose" value="yes">
			<input type="hidden" name="id" value="$row[0]">
			<button class = "btn btn-outline-success" onclick = "myFunction()" type="submit">Add to Cart</button>
		</form>
		 <form action="search.php" method="post">
			<input type="hidden" name="delete" value="yes">
			<input type="hidden" name="id" value="$row[0]">
			<input type="hidden" name="resolution" value="$row[1]">
			<input type="hidden" name="size" value="$row[2]">
			<input type="hidden" name="source" value="$row[3]">
			<input type="hidden" name="category" value="$row[4]">
			<input type="hidden" name="credits" value="$row[5]">
			<input type="hidden" name="source" value="$row[7]">
			<button class="btn btn-outline-danger btn-sm" type="submit">Delete</button>
		</form>
	  </div>
</div>
</figure>
_END;
			}		
	}
	if(in_array($category, $y)!==false)
	{

	$query = "SELECT * FROM music WHERE contrib like '$category'";
	$result = $conn->query($query);
	if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";
while ($row = $result->fetch_assoc()) {
		$q[]= $row['source'];
		foreach($q as $value)
		{
			$value=strtolower(substr($value, 0, -7));
			
		}
		$test[]=$value;
	}	
	$rows = $result->num_rows;
	for ($j = 0 ; $j < $rows ; ++$j)
		{
			$result->data_seek($j);
			$row = $result->fetch_array(MYSQLI_NUM);
			$g[]=$row[3];
			foreach($g as $value)
		{
			$value=substr($value, 0, -7);
			
		}
echo <<<_END
<figure class = "mt-5">
<div class="card mt-5 ml-3">
	<img class = "card-image-top" src= $row[3] alt="HTML5 Icon" style="width:128px;height:128px">
	<div class="card-body">
	    <h5 class="card-title">$value</h5>
	    <p class="card-text">id: $row[0]</p>
	    <p class="card-text">resolution: $row[1]</p>
	    <p class="card-text">size: $row[2]</p>
	    <p class="card-text">category: $row[4]</p>
		<p class="card-text">credits: $row[5]</p>
		<p class="card-text">credits: $row[7]</p>
		<form class = "mt-2 mb-2" action="search.php" method="post">
			<input type="hidden" name="choose" value="yes">
			<input type="hidden" name="id" value="$row[0]">
			<button class = "btn btn-outline-success" onclick = "myFunction()" type="submit">Add to Cart</button>
		</form>
		<form action="search.php" method="post">
			<input type="hidden" name="delete" value="yes">
			<input type="hidden" name="id" value="$row[0]">
			<input type="hidden" name="resolution" value="$row[1]">
			<input type="hidden" name="size" value="$row[2]">
			<input type="hidden" name="source" value="$row[3]">
			<input type="hidden" name="category" value="$row[4]">
			<input type="hidden" name="credits" value="$row[5]">
			<input type="hidden" name="source" value="$row[7]">
			<button class="btn btn-outline-danger btn-sm" type="submit">Delete</button>
		</form>
	  </div>
</div>
</figure>
_END;
			}		
	}
			
	}
$query = "SELECT * FROM music";
		$result = $conn->query($query);
		if (!$result) die ("Database access failed: " . $conn->error);
		$rows = $result->num_rows;
		
		for ($j = 0 ; $j < $rows ; ++$j)
		{
			$result->data_seek($j);
			$row = $result->fetch_array(MYSQLI_NUM);
			}		
			$result->close();
			$conn->close();
			function get_post($conn, $var){return $conn->real_escape_string($_POST[$var]);
			}	
			?>
	</div>
</body>
<footer>

	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<script type="text/javascript">
	function myFunction() {
  alert("Added to Cart!");
}
</script>
</footer>
</html>
			

