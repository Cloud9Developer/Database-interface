<?php
session_start(); /*required for session data*/
?>

<html>
<title>FBCA DB</title>
 <h2><center>FBC Avondale Visitations Database</center></h2>
 <head>
 <link rel="stylesheet" href="StyleSheet.css">
 </head>
</html>
<?php
 $conn = connectToSql(); //connect to Database
 ?>

<!-- ************************************************************************************* -->
<html>

<!-- Dropdown Menu Buttons -->
<div class="dropdown">
  <button class="dropbtn">Menu</button>
  <div class="dropdown-content">
    <a href="/entryInput.php">Input Entry</a>
    <a href="/updateEntry.php">Update Entry</a>
    <a href="/logout.php">Logout</a>
  </div>
</div><br /><br />

<style>
    /* Dropdown Button */
    .dropbtn {
        background-color: #000000;
        color: white;
        padding: 13px;
        font-size: 15px;
        border: none;
    }

    /* The container <div> - needed to position the dropdown content */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 140px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {
        background-color: #ddd;
    }

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* Change the background color of the dropdown button when the dropdown content is shown */
    .dropdown:hover .dropbtn {
        background-color: #777777;
    }
</style> <!-- dropdown button style-->
</html>


<html>
<!-- ********************************************************************************************** -->

<button type="Refresh" name="refresh" style="float: right;" onClick="location.href='database.php'">Refresh</button>

<?php
// Filter goes here
echo "<center><table width=100%>";
echo "<td>";

// filter form
echo "<form method='post'>
    <b>Filter: </b>
    <select name='Attr'>
        <option value='F_ID'>F_ID</option>
        <option value='House'>House Number</option>
        <option value='Street_Addr'>Street Address</option>
        <option value='Last_Name'>Last name</option>
        <option value='First_Name'>First name</option>
        <option value='Age'>Age</option>
        <option value='Next_Visitation'>Next Visitation</option>
        <option value='Last_Visitation'>Last Visitation</option>
        <option value='Phone_Number'>Phone Number</option>
    </select>

    <input type='text' name='Specify' placeholder='Specify'>
    <button type='Submit' name='filter'>Filter</button>
    <button type='Clear' name='clear'>Clear</button>
    </form>";

    echo "</td>";

echo "<td>";

//delete form
echo "<form method='post'>
    <b>Delete: </b>
    <input type='text' name='EntryNumberEntry' placeholder='Entry Number(s)'>
    <button type='Submit' name='delete'>Delete</button>
    </form>";
    echo "</td>";

echo "</table></center>";


//this is to choose what attributes are shown
echo "<table width='50%'>";
echo "<tr><td>";

echo "<details>"; //creates dropdown
    echo "<summary><font size='4' color='darkred'>Shown Attributes</font></summary>"; //"title" of dropdown

    echo "<br/>";
    echo "<form method='post' class='boxed'>

        <input type='checkbox' name='check_list[]' value='E_ID' checked='checked'>E_ID
        <input type='checkbox' name='check_list[]' value='F_ID' checked='checked'>F_ID
        <input type='checkbox' name='check_list[]' value='House' checked='checked'>House
        <input type='checkbox' name='check_list[]' value='Street_Addr' checked='checked'>Street_Addr
        <input type='checkbox' name='check_list[]' value='Last_Name' checked='checked'>Last_Name
        <input type='checkbox' name='check_list[]' value='First_Name' checked='checked'>First_Name<br/>
        <input type='checkbox' name='check_list[]' value='Age' checked='checked'>Age
        <input type='checkbox' name='check_list[]' value='Visitation_Information_and_Description' checked='checked'>Visitation_Information_and_Description
        <input type='checkbox' name='check_list[]' value='Next_Visitation' checked='checked'>Next_Visitation
        <input type='checkbox' name='check_list[]' value='Last_Visitation' checked='checked'>Last_Visitation<br/>
        <input type='checkbox' name='check_list[]' value='Phone_Number' checked='checked'>Phone_Number
        <input type='checkbox' name='check_list[]' value='Status_' checked='checked'>Status_

        <br/>
        <button type='Submit' name='UpdateAttr'>Update</button>
        </form>";

    echo "</details>";

echo "</td></tr>";
echo "</table><br />";

$attribs = $_SESSION["ShownAttr"];

if (count($attribs) != 12 & count($attribs) != 0) //if not default
{
    $search_param = implode(',', $attribs); //set the select to all selected attributes
    //echo $search_param; //testing
}
else { //if all or none of the attributes are selected, show all
    $search_param = '*';
}


$sqlqs = $_SESSION["sqlQuerySpecific"]; // filter query "WHERE x=x"

$sqlq = "SELECT $search_param FROM Families $sqlqs ORDER BY F_ID + 1 ASC"; //this is the actual sqlQuery

// echos what is being shown (mostly for testing purposes)
//echo "<center>" . $sqlq . "</center>";


//get results from database
$result = mysqli_query($conn,"$sqlq");
//$result = mysqli_query($conn,"sqlq");
$all_property = array();  //declare an array for saving property

//showing properties
echo '<center><table class="data-table" border="1" width="100%">
        <tr class="data-heading">';  //initialize table tag

while ($property = mysqli_fetch_field($result)) {
    echo "<td><center><b>" . $property->name . "</b></center></td>";  //get field name for header
    array_push($all_property, $property->name);  //save those to array
}

echo '</tr>'; //end tr tag




//showing all data (populating table with database data)
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    foreach ($all_property as $item) {
        if($item == "E_ID") { //color code the E_ID to be more apparent
            echo "<td><em><b><center><font color='red'>" . nl2br($row[$item]) . "</font></center></b></em></td>"; //get items using property value
        }
        else {
            echo "<td>" . nl2br($row[$item]) . "</td>"; //get items using property value
        }
    }
    echo '</tr>';
}
echo "</table>";

$conn->close();
?>
</html>


<!-- ******************FUNCTIONS **************-->
<?php
function deleteEntry()
{
    $conn = connectToSql();

    // sql to delete records
    // set variable to handle user input on form submit
    $EN = $_POST['EntryNumberEntry'];

    // take user input into array seperated by comma (',')
    $MEN = explode(",",$EN);

    if($MEN[0] != "")
    {
        // delete each entry user input seperated by comma
        foreach ($MEN as &$EN)
        {
            // next 5 lines inputs query and executes it as well as error handling
            $sql = "DELETE FROM Families WHERE E_ID='$EN'";
            if (mysqli_query($conn, $sql)) {
                echo "Entry $EN deleted successfully<br />";
            } else {
                echo "Error deleting record: " . mysqli_error($conn);
            }
        }

        echo "<b>", sizeof($MEN), " Entries Deleted</b>";
        echo "
        <script>
            setTimeout(function()
            {
                window.location = 'database.php';
            },0);
            </script>"; //script to reload page automatically after 0 microseconds (1000=1sec)
    }
    $conn->close();
}

if (isset($_POST['delete']))
{
    deleteEntry();

}

/* ************************************************************************* */
function filter()
{
    $conn = connectToSql();
    if ($_POST[Specify] != "") {
        $_SESSION["sqlQuerySpecific"] = $sqlq = "WHERE $_POST[Attr] = '$_POST[Specify]'";
        echo "
        <script>
            setTimeout(function()
            {
                window.location = 'database.php';
            },0);
            </script>"; //reloads page
    }
}


if (isset($_POST['filter']))
{
    filter();

}

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

function clearFilter()
{
    echo "clear filter";
    unset($_SESSION['sqlQuerySpecific']); //resets session variable
    echo "
    <script>
        setTimeout(function()
        {
            window.location = 'database.php';
        },0);
        </script>"; //reloads page

}

if (isset($_POST['clear']))
{
    clearFilter();

}

function ShownAttr()
{
    $_SESSION["ShownAttr"] = $_POST['check_list'];
    echo count($_SESSION["ShownAttr"]);
    echo "
    <script>
        setTimeout(function()
        {
            window.location = 'database.php';
        },0);
        </script>"; //reloads page

}

if(isset($_POST['UpdateAttr']))
{
    shownAttr();
}

?>
