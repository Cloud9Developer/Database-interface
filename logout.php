<html>
<title>Logging off</title>
<head>
<link rel="stylesheet" href="StyleSheet.css">
</head>
</html>

<?php
session_start(); /*required for session data*/
echo "<h3>Logging out..</h3>";
session_unset();
header( "Refresh:2; url=/index.php", true, 303);

?>
