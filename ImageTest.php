<?php
/*
Image page (Wall) 
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
	


$query = "SELECT id from customer where userName='$tmp' and password='$p'";
	$result = $conn->query($query);
	while ($row = $result->fetch_assoc()) {
			//echo "Welcome ".$tmp." , id: ".$row['id']."<br>";
			$_SESSION["tmpid"]=$row['id'];
			}
	if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";
//from sqltest example provided by professor
//delete from database
if (isset($_POST['delete']) && isset($_POST['id']))
{
	$id = get_post($conn, 'id');
	$query = "DELETE FROM music WHERE id='$id'";
	$result = $conn->query($query);
	if (!$result) echo "DELETE failed: $query<br>" . $conn->error . "<br><br>";
	}
	
	//choose image into cart
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
	
//display cart

// test if connection is successful . MAMAMIA

// upload image and insert into Database
if(isset($_POST['image_upload']) && isset($_POST['category'])){

 
 //get the image file ( from php website)
 $name = $_FILES['file']['name'];
 $size=$_FILES['file']['size'];
 $filepath= "images/".$name;
 //echo $name;
 
 // the target directory
 $target_dir = "upload/";
 $target_file = $target_dir . basename($_FILES["file"]["name"]);

 // file type
 $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

 // check for file extensions to make sure it is an image file
 $extensions_arr = array("jpg","jpeg","png","gif");
 
 //get size and convert into kb or mb
 $size = $_FILES['file']['size'];
	//(size info from php file sizes)
        if ($size >= 1048576)
        {
            $size = number_format($size / 1048576, 2) . ' MB';
        }
        elseif ($size >= 1024)
        {
            $size = number_format($size / 1024, 2) . ' KB';
        }
        elseif ($size > 1)
        {
            $size = $size . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $size = $size . ' byte';
        }
        else
        {
            $size = '0 bytes';
        }
 
 //get resolution
$tmpName = $_FILES['file']['tmp_name'];        
list($width, $height, $type, $attr) = getimagesize($tmpName);
$res= "$width" . 'x' . "$height";
$newwidth = $width/2; 
$newheight = $height/2;

 // Check extension
 if( in_array($imageFileType,$extensions_arr) ){
	$category = get_post($conn, 'category');
	
	//water mark
	$image= imagecreatefromjpeg($name);
	$foreground = imagecreatefrompng("watermark2.png");
	$tmpnewname=substr($name, 0, -4);
	$newname=$tmpnewname."new.png";
	//echo $newname;
	//save alpha channel information ( from php website)
	imagesavealpha($foreground, true); 
	
	//set blending mode for alpha image
	imagealphablending($foreground, true);    //from php website
	
	
	//copy images by setting coordinates width and height 
	imagecopy($image, $foreground, $newwidth, $newheight, 0,0 , $newwidth,$newheight);  //from php website
	imagepng($image,$newname);
 
  // Insert record

 $query = "insert into music values(NULL,'$res','$size','$newname','$category', ROUND((RAND() * (20-1))+1),CURDATE(), '$tmp')";

 $result = $conn->query($query);
if (!$result) die("Database access failed: ". $conn->error);

//update customer credits
$query ="SELECT * FROM music";
		$result = $conn->query($query);
		$tcred=array();
		
		while ($row = $result->fetch_assoc()) {
		$tcred=$row['credits'];
	}

$query = "SELECT * from customer where userName='$tmp' and password='$p'";
	$result = $conn->query($query);
	while ($row = $result->fetch_assoc()) {
			//echo "Welcome ".$tmp." , id: ".$row['id']."<br>";
			//$_SESSION["tmpid"]=$row['id'];
			$tid=$row['id'];
			$tcustcre=$row['credits'];
			}
	if (!$result) echo "SELECT failed: $query<br>" . $conn->error . "<br><br>";
	
	$newcustcred=$tcred+$tcustcre;
	$query = "update customer set credits=$newcustcred where id='$tid'";
 $result = $conn->query($query);
if (!$result) die("Database access failed: ". $conn->error);
	

  // Upload file (from php website)
  move_uploaded_file($_FILES['file']['name'],$target_dir.$name);

}
}


//from sqltest example provided by professor
// show the image database on webpage
			function get_post($conn, $var){return $conn->real_escape_string($_POST[$var]);
			}	
			
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css" integrity="sha384-aOkxzJ5uQz7WBObEZcHvV5JvRW3TUc2rNPA7pe3AwnsUohiw1Vj2Rgx2KSOkF5+h" crossorigin="anonymous">

		<style type="text/css">
		input[type="file"] { 
		  z-index: -1;
		  position: absolute;
		  opacity: 0;
		}

		input:focus + label {
		  outline: 2px solid;
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
	<div class="container-fluid ml-5">
		<div class="row">
			<form method="post" action="" enctype='multipart/form-data'>
				<label class="btn btn-success btn-file mt-4">
				    Select Image<input type="file" id="file-upload" name="file">
				</label>
				<div id="file-upload-filename"></div><br>
				Category<input class="ml-2" type="text" name="category">
				<button class="btn btn-success" type='submit' onclick="myUpload()" name='image_upload'>Upload</button>
			</form>
		</div>
		<div id="columns">
			<?php
			//display images on wall
			$query = "SELECT * FROM music";
		$result = $conn->query($query);
		if (!$result) die ("Database access failed: " . $conn->error);
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
		//echo $value;
			//echo '<img src="'.$g.'" alt="HTML5 Icon" style="width:128px;height:128px">';
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
		<p class="card-text">cost: $row[5]</p>
		<p class="card-text">source: $row[7]</p>
		<form class = "mt-2 mb-2" action="ImageTest.php" method="post">
			<input type="hidden" name="choose" value="yes">
			<input type="hidden" name="id" value="$row[0]">
			<button class = "btn btn-outline-success" onclick = "myFunction()" type="submit">Add to Cart</button>
		</form>
		 <form class = "" action="ImageTest.php" method="post">
			<input type="hidden" name="delete" value="yes">
			<input type="hidden" name="id" value="$row[0]">
			<button class = "btn btn-outline-danger btn-sm" type="submit">Delete</button>
		</form>
	  </div>
	</div>
</div>
</figure>

_END;

			}	
			$result->close();
			$conn->close();	
			?>
		</div>
	</div>
</body>
<footer>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript">
	var input = document.getElementById( 'file-upload' );
var infoArea = document.getElementById( 'file-upload-filename' );

input.addEventListener( 'change', showFileName );

function showFileName( event ) {
  
  // the change event gives us the input it occurred in 
  var input = event.srcElement;
  
  // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
  var fileName = input.files[0].name;
  
  // use fileName however fits your app best, i.e. add it into a div
  infoArea.textContent = 'File name: ' + fileName;
}
</script>
<script>
function myFunction() {
  alert("Added to Cart!");
}

function myUpload() {
  alert("Uploaded Image!");
}
</script>
</footer>
</html>