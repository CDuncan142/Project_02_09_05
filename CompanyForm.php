<?php
include 'GenericFunctions.php';

//global variables
$errors = 0;
$body = "";
$formData = array();
$formData['organization'] = ""; $formData['position'] = "";

//check for cookies no- link to first page, yes- 
if(!isset($_COOKIE['Index'])){
	$errors++;
	$body .= "<a href='Index.php'>Timed out, click here to restart</a><br />\n";
} else if(!isset($_POST['submit'])){
	$errors++;
	$body .= displayForm("", "");
} else {
	//Validate
	$formData['organization'] = formatValidate($_POST['organization'], "Organization Name");
	$formData['position'] = formatValidate($_POST['position'], "Title of position");
	
	/*Unique Validation*/
	if ($errors == 0){
		//check if the organization exists
	}
	
	/*Save information*/
	if ($errors == 0) {
		//set new cookies
		setcookie("CompanyForm['organization']", $formData['organization'], time() + 3600);
		setcookie("CompanyForm['position']", $formData['position'], time() + 3600);
		//Link to next page
		$body .= "<a href='SeminarForm.php'>Choose Seminars</a><br />\n";
	}
	else if ($errors > 0) {
		$body .= displayForm($formData['organization'], $formData['position']);
	}	
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
		<title>CompanyForm.php</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
	</head>

	<body>
		<?php echo "<h3>Company Information</h3><br/>\n" . $body; ?>
		<?php function displayForm($org, $pos) { 
			return "" .
			"<form action='CompanyForm.php' method='post'>\n" .
				"<p>\n" .
					"Organization Name:\n" .
					"<input type='text' name='organization' value='".htmlentities($org)."'>\n" .
					"Title of position\n" .
					"<input type='text' name='position' value='".htmlentities($pos)."'>\n" .
				"</p>\n" .
				"<input type='reset' name='reset' value='Reset Form'>\n" .
				"<input type='submit' name='submit' value='Continue'>\n" .
			"</form>\n";
		} ?>
	</body>
</html>