<?php
include 'GenericFunctions.php';

//global variables
$errors = 0;
$body = "";
//$orgName = $_COOKIE['CompanyForm']['organization'];
$formData = array();
$hostname = "localhost";
$username = "adminer";
$password = "plane-shown-89";
$DBConnect = false;
$DBName = "conferenceregistration";
$TableName = "";
$DBConnect = false;

/* MAIN FORM PROCESSING -------------------------------------------------------------*/
//check for cookies no- send back
if (!isset($_COOKIE['Index'])){
	$body .= "<a href='Index.php'>Timed out, click to restart.</a><br />\n";
} else if(!isset($_POST['submit'])){
	$body .= seminarForm($hostname, $username, $password, $DBName, $TableName);
} else {
	//stuff
	
	//default
	if ($errors > 0) {
		$body .= seminarForm($hostname, $username, $password, $DBName, $TableName);	
	}
}

/* Unique Functions ----------------------------------------------------------------*/	
function seminarForm($hostname, $username, $password, $DBName, $TableName) {
	
	//global variables
	global $body;
//	global $errors; #do not uncomment
	//local variables
	$errors = 0;
	$bodyForm = "";
	$DBConnect = false;
	
	$bodyForm .= "<form action='SeminarForm.php' method='post'>";
	
	//login to database
	if ($errors == 0) {
	   $DBConnect = mysqli_connect($hostname, $username, $password);
	   if (!$DBConnect) {
		   ++$errors;
		   $body .= "<p>Unable to connect to the database server" . " error code: " . mysqli_connect_error() . "</p>\n";
	   }
	   else {
		   $result = mysqli_select_db($DBConnect, $DBName);
		   if (!$result) {
			   ++$errors;
			   $body .= "<p>Unable to select the database server" . " \"$DBName\" error code: " . mysqli_error($DBConnect) . "</p>\n";
		   }
	   }
	}
	//display all seminars
	$TableName = "seminars";
	if ($errors == 0) {
		$seminarsDBTable = array();
		$SQLstring = "SELECT semID, semName, semTime" .
			" FROM $TableName";
		$queryResult = mysqli_query($DBConnect, $SQLstring);
		if (!$queryResult) {
			++$errors;
		} else if (mysqli_num_rows($queryResult) > 0) {
			while (($row = mysqli_fetch_assoc($queryResult)) != false) {
				$seminarsDBTable[] = $row;
			}
			mysqli_free_result($queryResult);
		}
	}

	if ($DBConnect) {
	   mysqli_close($DBConnect);
	}
	
	
//	if (!empty($lastRequestDate)) {
//		$body .= "You last requested an opportunity on $lastRequestDate.";
//	}

	$bodyForm .= "" .
		"<table border='1' width='100%'>\n" .
		"<tr>\n".
		"<th style='background-color: cyan'>Select</th>\n".
		"<th style='background-color: cyan'>Name</th>\n".
		"<th style='background-color: cyan'>Time</th>\n".
		"</tr>\n";
	
	if ($errors == 0) {
		$i = 0;
		foreach ($seminarsDBTable as $seminarRow) {
			$bodyForm .= "<tr>".
			"<td><input type='checkbox' name=\"checkbox[]\" value='".$seminarRow['semName']."' /></td>" .
			"<td>".htmlentities($seminarRow['semName'])."</td>" .
			"<td>".htmlentities($seminarRow['semTime'])."</td>" .
			"</tr>\n";
			$i++;
		}
		$bodyForm .= "</table>\n";
	}

//	if ($errors > 0) {$body .= "There are error(s)\n";}
	
	$bodyForm .= "<input type='reset' name='reset' value='Reset Form' />" .
			"<input type='submit' name='submit' value='Continue' />" .
		"</form>";
	//return form table (prefilled) html.
	return $bodyForm;
}
?>
<!doctype html>
<html>
	<head>
		<!--
		Author: Conner Duncan
		Date: 12.05.18

		file: CompanyForm.php
		-->
		<title>SeminarForm.php</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
	</head>

	<body>
		<h3>Available Seminars</h3>
		<?php echo $body; ?>
		<a href="Index.php">Attendee Info (Edit)</a>
		
		<a href="CompanyForm.php">Company Info (Edit)</a>
		<a href="SeminarForm.php">Seminar Info (Edit)</a>
		
		
		
<!--
		<form action="CompanyForm.php" method="post">
			<input type="reset" name="reset" value="Reset Form">
			<input type="submit" name="submit" value="Continue">
		</form>
-->
	</body>
</html>