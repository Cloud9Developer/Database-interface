<!-- THIS IS THE SUBMISSION PAGE FOR UPDATING ENTRIES-->

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
/*
$sql="INSERT INTO Families (F_ID, House_number, Street_Addr, Last_name, First_Name, Age, Visitation_Info, Next_Visitation, Last_Visitation, Phone_Number)
VALUES ('$_POST[F_ID]','$_POST[House_number]','$_POST[Street_Addr]','$_POST[Last_name]','$_POST[First_Name]','$_POST[Age]','$_POST[Visitation_Info]','$_POST[Next_Visitation]','$_POST[Last_Visitation]','$_POST[Phone_Number]')";
*/

$arr = array($_POST[F_ID],$_POST[House_number],$_POST[Street_Addr],$_POST[Last_name],$_POST[First_Name],$_POST[Age],$_POST[Visitation_Info],$_POST[Next_Visitation],$_POST[Last_Visitation],$_POST[Phone_Number],$_POST[Status_]);
$count = 1;

foreach ($arr as &$data)
{
    if ($data != "")
    {
        $attr=getAttr($count);

        $sql="UPDATE Families SET $attr = '$data' WHERE E_ID = $_POST[E_ID]";

        if (mysqli_query($conn, $sql)) {

        } else {
            echo '<form><button type="button" value="Return to previous page" onClick="javascript:history.go(-1)">Return to previous page</button></form>';
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            die();
        }
    }
    $count = $count + 1;
}
echo "Record updated successfully";

?>

<html>
<form><button type='button' value='Return to Main' onClick="location.href='database.php'">Return to Main</button></form>
</html>

<?php
mysql_close($conn);
 ?>

 <?php
 function getAttr($count)
 {
     switch ($count)
     {
     case 1:
         return "F_ID";
         break;
     case 2:
         return "House_Number";
         break;
     case 3:
        return "Street_Addr";
        break;
     case 4:
         return "Last_Name";
         break;
     case 5:
         return "First_Name";
         break;
     case 6:
         return "Age";
         break;
     case 7:
         return "Visitation_Info";
         break;
     case 8:
         return "Next_Visitation";
         break;
     case 9:
         return "Last_Visitation";
         break;
     case 10:
         return "Phone_Number";
         break;
     case 11:
        return "Status_";
        break;
    }
 }
 ?>
