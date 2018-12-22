<html>
<title>Update Entry</title>
<center>
<h2>Update Entry</h2>
<head>
<link rel='stylesheet' href='StyleSheet.css'>
</head>
</html>

<?php
session_start(); /*required for session data*/
unset($_SESSION['sqlQuery']); //resets session variable

$conn = connectToSql();


?>

<?php
echo "<table>";
echo "<td valign='top'>";
echo "<center>
<div class='boxed'>
<form action='update_data.php' method='post'>

    <label id='entryNumber'><b>Entry Number:<font color='red'>*</font></b></label><br/>
    <input type='text' name='E_ID' required><br/>

    <label id='first'>Family ID:</label><br/>
    <input type='text' name='F_ID'><br/>

    <label id='first'>House Number:</label><br/>
    <input type='text' name='House_number'><br/>

    <label id='first'>Street Address:</label><br/>
    <input type='text' name='Street_Addr'><br/>

    <label id='first'>Last Name:</label><br/>
    <input type='text' name='Last_name'><br/>

    <label id='first'>First Name:</label><br/>
    <input type='text' name='First_Name'><br/>

    <label id='first'>Age:</label><br/>
    <select name='Age'>
        <option value=''>Select If Needed..</option>
        <option value='Adult'>Adult</option>
        <option value='Youth'>Youth</option>
        <option value='Child'>Child</option>
        <option value='Toddler'>Toddler</option>
    </select><br/>

    <label id='first'>Visitation Info:</label><br/>
    <textarea wrap='hard' type='text' name='Visitation_Info' style='height:100px;width:350px'></textarea><br/>

    <label id='first'>Next Visitation:</label><br/>
    <input type='date' name='Next_Visitation'><br/>

    <label id='first'>Last Visitation:</label><br/>
    <input type='date' name='Last_Visitation'><br/>

    <label id='first'>Phone Number:</label><br/>
    <input type='tel' name='Phone_Number'><br/>

    <label id='Status_'>Status:</label><br/>
    <select name='Status_'>
        <option value=''>Select If Needed..</option>
        <option value='Church'>Church</option>
        <option value='Prospect'>Prospect</option>
        <option value='Moved'>Moved</option>
        <option value='Deceased'>Deceased</option>
        <option value='Unwanted'>Unwanted</option>
    </select><br/>


    <button type='submit' name='save'>Save</button>

</form>

<form action='database.php' method='post'>
<button type='Back' name='back' onClick='location.href='database.php'>Back</button>
</form>
</div>";


echo "</td>";


echo "<td valign='top'>";

/* **************************Show data in table *********************************/

$result = mysqli_query($conn,"Select * from Families");
$all_property = array();  //declare an array for saving property

//showing property
echo "<table class='data-table' border='1'>
        <tr class='data-heading'>";  //initialize table tag

while ($property = mysqli_fetch_field($result)) {
    echo '<td><b>' . $property->name . '</td></b>';  //get field name for header
    array_push($all_property, $property->name);  //save those to array
}

echo '</tr>'; //end tr tag
//showing all data
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    foreach ($all_property as $item) {
        echo '<td>' . nl2br($row[$item]) . '</td>'; //get items using property value
    }
    echo '</tr>';
}
echo "</table>";

$conn->close();

echo "</td></table>";
?>

<?php


$conn->close();
?>

<?php
function connectToSql()
{
    $host    = "localhost";
    $db_name = "fbca_visitation";
    $user = $_POST["Username"];
    $pass = $_POST["Password"];

    if($user == "" && $pass == ""){
        $user = $_SESSION["user"];
        $pass = $_SESSION["pass"];
    }

    $_SESSION["pass"] = $pass;
    $_SESSION["user"] = $user;

    $conn = mysqli_connect($host, $user, $pass, $db_name);

    //test if connection failed
    if(mysqli_connect_errno())
    {
        echo '<form><button type="button" value="Return to previous page" onClick="javascript:history.go(-1)">Return to previous page</button></form>';
        die("connection failed: "
            . mysqli_connect_error()
            . " (" . mysqli_connect_errno()
            . ")"
        );

    }
    return $conn;
}
 ?>
