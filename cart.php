<?php
/*
shopping cart
backend by Arselan (php libraries used from php website).
Front end by Austin
*/
require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);

require_once('authenticate.php');
$tmp= $_SESSION["user"];
$p= $_SESSION["pass"];

if ($conn->connect_error) die($conn->connect_error);
$buyid= $_SESSION["tmpid"];


//credits
 $query = "SELECT * from customer where userName='$tmp' and password='$p'";
	$result = $conn->query($query);
	while ($row = $result->fetch_assoc()) {
			//echo "Welcome ".$tmp." , id: ".$row['id']."<br>";
			$ti=$row['id'];
			$tcustcre=$row['credits'];
			}
	if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";



//delete from cart
if (isset($_POST['delete']) && isset($_POST['id']) && isset($_POST['res']) && isset($_POST['size']) && isset($_POST['source']) && isset($_POST['category']) && isset($_POST['credits']))
{
	$id = get_post($conn, 'id');
	$res = get_post($conn, 'res');
	$size = get_post($conn, 'size');
	$name = get_post($conn, 'source');
	$cat = get_post($conn, 'category');
	$cre = get_post($conn, 'credits');
	
	
	$query = "DELETE FROM cart WHERE id='$id'";
	$result = $conn->query($query);
	if (!$result) echo "DELETE failed: $query<br>" . $conn->error . "<br><br>";
	}

	if (isset($_POST['buy']) && isset($_POST['id']))
{
	$imageid = get_post($conn, 'id');
	//echo $imageid;
	
	$query ="SELECT * FROM cart";
		$result = $conn->query($query);
		$tcred= array();
		
		while ($row = $result->fetch_assoc()) {
		$s[]=$row['id'];
		$ts=$row['source'];
			$newts[]=substr_replace($ts, '.jpg',-7);
		$tc[] = $row['category'];
		$tcred[]=$row['credits'];
	}
	$sum = array_sum($tcred);
		if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";
	$query = "SELECT * from customer where id='$buyid'";
	$result = $conn->query($query);
	while ($row = $result->fetch_assoc()) {
			//echo "Welcome ".$tmp." , id: ".$row['id']."<br>";
			$ti=$row['id'];
			$tcustcre=$row['credits'];
			}
	if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";
	if($tcustcre > $sum){
		$upcustcre=$tcustcre-$sum;
		$query = "update customer set credits=$upcustcre where id='$buyid'";
		$result=$conn->query($query);
		if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";
	}
	
		foreach ($s as $k => $v) {
			//foreach($newts as $b => $bit){
    $query ="INSERT INTO transaction VALUES(NULL,'$ti','$s[$k]','$newts[$k]', '$tc[$k]',CURDATE())";
	$result = $conn->query($query);
	if (!$result) echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
			//}
}

	$query = "DELETE FROM cart";
	$result = $conn->query($query);
	if (!$result) echo "DELETE failed: $query<br>" . $conn->error . "<br><br>";
	
	}
echo <<<_END

_END;
?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css" integrity="sha384-aOkxzJ5uQz7WBObEZcHvV5JvRW3TUc2rNPA7pe3AwnsUohiw1Vj2Rgx2KSOkF5+h" crossorigin="anonymous">
<head>
	<title></title>
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
					    <a class="dropdown-item" href="logout.php">Logout</a>
					</div>
		      	</div>
		      </li>
		    </ul>
		  </div>
	</nav>
	<div class="mr-5 mb-5" style="position: fixed; right: 0">
		<form class="mt-5 mr-5"  action="cart.php" method="post">
			<input type="hidden" name="id" value="">
			<input type="hidden" name="buy" value="yes">
			<button class="btn btn-success btn-lg mt-" onclick="myFunction()" type="submit">Purchase</button>
		</form>
	</div>
	<div id="columns" class="row">
		<?php
		//Display Cart
			 $query ="SELECT * FROM cart";
		$result = $conn->query($query);
		if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";
		echo "</br>";
		while ($row = $result->fetch_assoc()) {
			
		$q= $row['id'];
		$t=$row['resolution'];
		$u=$row['size'];
		$v=$row['source'];
	}

	
	$query = "SELECT * FROM cart";
		$result = $conn->query($query);
		if (!$result) die ("Database access failed: " . $conn->error);
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
<figure>
<div class="column ml-2 mb-5" style=float:left;padding:10 10 10 10>
	<div class="card" style="width: 15rem;">
	  <img class="card-img-top" src= $row[3] alt="HTML5 Icon">
	  <div class="card-body">
	    <h5 class="card-title">$value</h5>
	    <p class="card-text">id: $row[0]</p>
	    <p class="card-text">resolution: $row[1]</p>
	    <p class="card-text">size: $row[2]</p>
	    <p class="card-text">category: $row[4]</p>
	    <p class="card-text">credits: $row[5]</p>
	  
		<form class = "mt-2" action="cart.php" method="post">
			<input type="hidden" name="delete" value="yes">
			<input type="hidden" name="id" value="$row[0]">
			<input type="hidden" name="res" value="$row[1]">
			<input type="hidden" name="size" value="$row[2]">
			<input type="hidden" name="source" value="$row[3]">
			<input type="hidden" name="category" value="$row[4]">
			<input type="hidden" name="credits" value="$row[5]">
			<button class = "btn btn-outline-danger" type="submit">Remove</button>
		</form>
	  </div>
	</div>
</figure>
_END;
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

<script>
function myFunction() {
  alert("Purchase Successful!");
}
</script>
</footer>
</html>