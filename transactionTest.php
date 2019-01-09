<?php
require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

//provided by professor
if (isset($_POST['delete']) && isset($_POST['orderNumber']))
{
	$orderNumber = get_post($conn, 'orderNumber');
	$query = "DELETE FROM transaction WHERE orderNumber='$orderNumber'";
	$result = $conn->query($query);
	if (!$result) echo "DELETE failed: $query<br>" . $conn->error . "<br><br>";
	}
	
if ( isset($_POST['orderNumber']) && isset($_POST['customerID']) &&isset($_POST['imageID']) && isset($_POST['transactionDate']))
 {
		$orderNumber = get_post($conn, 'orderNumber');
		$customerID = get_post($conn, 'customerID');
			$query= "select id from customer where id='$customerID'";
			$result1 = $conn->query($query);
			//from sql website
			while ($row = $result1->fetch_assoc()) {
			#echo $row['id']."<br>";
			$r1=$row['id'];
			}
		$imageID = get_post($conn, 'imageID');
			$query= "select id from music where id='$imageID'";
			$result2 = $conn->query($query);
			while ($row = $result2->fetch_assoc()) {
			# echo $row['id']."<br>";
			$r2=$row['id'];
}
		$transactionDate = get_post($conn, 'transactionDate');
		 $query ="INSERT INTO transaction VALUES(NULL,'$r1','$r2',CURDATE())";
		
		$result = $conn->query($query);
		if (!$result) echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
		
 }

		
		
echo <<<_END
<form action="transactionTest.php" method="post">
<pre>
orderNumber <input type="text" name="orderNumber">
customerID <input type="text" name="customerID">
imageID <input type="text" name="imageID">
transactionDate <input type="text" name="transactionDate">
<input type="submit" value="ADD RECORD">
</pre>
</form>
_END;

/*
//get customer
$query= "select id from customer where id='33'";
$result1 = $conn->query($query);
while ($row = $result1->fetch_assoc()) {
    #echo $row['id']."<br>";
	$r1=$row['id'];
}
if (!$result1) echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";

// get image (in this case a music image)
$query= "select id from music where id='19'";
$result2 = $conn->query($query);
while ($row = $result2->fetch_assoc()) {
   # echo $row['id']."<br>";
	$r2=$row['id'];
}
if (!$result2) echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";



// insert a transaction

$query = "INSERT INTO transaction VALUES(NULL,'$r1','$r2',CURDATE())";
	#	$query = "INSERT INTO customer VALUES(NULL,'miller','james','charlie123','123','admin')";
		$result = $conn->query($query);
		if (!$result) echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
		*/




//display transactions (html by professor)
		$query = "SELECT * FROM transaction";
		$result = $conn->query($query);
		if (!$result) die ("Database access failed: " . $conn->error);
		$rows = $result->num_rows;
		
		for ($j = 0 ; $j < $rows ; ++$j)
		{
			$result->data_seek($j);
			$row = $result->fetch_array(MYSQLI_NUM);
echo <<<_END
<pre>
orderNumber $row[0]
customerID $row[1]
imageID $row[2]
transactionDate $row[3]
</pre>
<form action="transactionTest.php" method="post">
<input type="hidden" name="delete" value="yes">
<input type="hidden" name="orderNumber" value="$row[0]">
<input type="submit" value="DELETE RECORD">
</form>
_END;
			}
			
			$result->close();
			$conn->close();
			function get_post($conn, $var){return $conn->real_escape_string($_POST[$var]);
			}		
		
		
// test if connection is successful . MAMAMIA
echo "Mamamia". '<br>'. '<br>';


?>