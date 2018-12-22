<!-- THIS IS THE SUBMISSION PAGE FOR INSERTING ENTRIES-->

<html>
<head>
<link rel="stylesheet" href="StyleSheet.css">
</head>
</html>

<?php
session_start(); /*required for session data*/
unset($_SESSION['sqlQuery']); //resets session variable

$host = "localhost";
$_SESSION['user'] = $user = $_SESSION["user"];
$_SESSION['pass'] = $pass = $_SESSION["pass"];
$db_name = "fbca_visitation";

//create connection
$conn = mysqli_connect($host, $user, $pass, $db_name);

//test if connection failed
if(!$conn)
{
    die("connection failed: "
        . mysqli_connect_error()
        . " (" . mysqli_connect_errno()
        . ")"
    );
}

mysqli_select_db($user, $conn);

$sql="INSERT INTO Families (F_ID, House, Street_Addr, Last_name, First_Name, Age, Visitation_Information_and_Description, Next_Visitation, Last_Visitation, Phone_Number, Status_)
VALUES ('$_POST[F_ID]','$_POST[House]','$_POST[Street_Addr]','$_POST[Last_name]','$_POST[First_Name]','$_POST[Age]','$_POST[Visitation_Info]','$_POST[Next_Visitation]','$_POST[Last_Visitation]','$_POST[Phone_Number]','$_POST[Status_]')";

if (mysqli_query($conn, $sql)) {
      echo "New record created successfully";
} else {
    echo '<form><button type="button" value="Return to previous page" onClick="javascript:history.go(-1)">Return to previous page</button></form>';
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    die();
}


?>

<html>
<br/>
<form>
    <button type='button' value='New Entry' onClick="location.href='entryInput.php'">Insert Another Entry</button><br/><br/>
    <button type='button' value='Return to Main' onClick="location.href='database.php'">Return to Main</button>
</form>
</html>

<?php
mysql_close($conn);
 ?>
