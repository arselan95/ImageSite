<?php
/*
customers data
backend by Arselan (php libraries used from php website).
Front end by Austin
*/
require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);
//html by professor
//delete customer
if (isset($_POST['delete']) && isset($_POST['id']))
{
	$id = get_post($conn, 'id');
	$query = "DELETE FROM customer WHERE id='$id'";
	$result = $conn->query($query);
	if (!$result) echo "DELETE failed: $query<br>" . $conn->error . "<br><br>";
	}

 
 //create customer (html by professor)
 if ( isset($_POST['id']) && isset($_POST['lastName']) &&isset($_POST['firstName']) && isset($_POST['userName']) &&isset($_POST['password']) &&isset($_POST['userType']))
 {
		$id = get_post($conn, 'id');
		$lastName = get_post($conn, 'lastName');
		$firstName = get_post($conn, 'firstName');
		$userName = get_post($conn, 'userName');
		$password = get_post($conn, 'password');
		$userType = get_post($conn, 'userType');
		$query = "INSERT INTO customer VALUES('$id','$lastName','$firstName','$userName',SHA1('$password'),'$userType')";
	#	$query = "INSERT INTO customer VALUES(NULL,'miller','james','charlie123','123','admin')";
		$result = $conn->query($query);
		if (!$result) echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
		
 }

		
		
echo <<<_END
<form action="customerTest.php" method="post">
<pre>
id <input type="text" name="id">
lastName <input type="text" name="lastName">
firstName <input type="text" name="firstName">
userName <input type="text" name="userName">
password <input type="text" name="password">
userType <input type="text" name="userType">
<input type="submit" value="ADD RECORD">
</pre>
</form>
_END;


$query = "SELECT * FROM customer";
		$result = $conn->query($query);
		if (!$result) die ("Database access failed: " . $conn->error);
		$rows = $result->num_rows;
		
		for ($j = 0 ; $j < $rows ; ++$j)
		{
			$result->data_seek($j);
			$row = $result->fetch_array(MYSQLI_NUM);
echo <<<_END
<pre>
id $row[0]
lastName $row[1]
firstName $row[2]
userName $row[3]
password $row[4]
userType $row[5]
</pre>
<form action="customerTest.php" method="post">
<input type="hidden" name="delete" value="yes">
<input type="hidden" name="id" value="$row[0]">
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