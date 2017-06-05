<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>
<?php
$username = "root";
$password = "";
$server = "localhost";
$db = "trial";
$table = "student";
$_SESSION['check_login']=" ";
if(!($connection = mysql_connect($server, $username, $password)))	
	die( "Could not connect to database </body></html>" );

 if ( !mysql_select_db($db, $connection ) )
	die( "Could not open " . $db . " database </body></html>" );
//extract($_POST);
$name = isset($_POST["User"])?$_POST["User"]:"";
$pass = isset($_POST["password"])?$_POST["password"]:"";

//get the student data
$query = "SELECT * FROM $table where Stud_ID = '$name' AND Password ='$pass' ";
$result = mysql_query( $query, $connection) ;
$rowsnum = mysql_num_rows($result);
if ($rowsnum == 1) {
$_SESSION['student_id']=$name;
$_SESSION['check_login']=" ";
header('Location: http://localhost/assignment/student_list.php');	 // Redirecting To Other Page


} 

else {
$_SESSION['check_login']="The server did not recognize your username and password combination";
header('Location: http://localhost/assignment/login.php ');
}
	

mysql_close( $connection);

?>

</body>

</html> 
