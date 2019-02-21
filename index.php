<?php
include 'GenericFunctions.php';
/*Unique PHP*/
//Global Variables
$errors = 0;
$body = "";#Contains information to be echoed
$index = array(); 
$formData['fName'] = ""; $formData['lName'] = ""; $formData['email'] = ""; $formData['phoneNum'] = "";#form Input Data

//check for form submition, (Predictably from itself) no- display empty form, yes- continue
if(!isset($_POST['submit'])) {
	$body .= displayForm("", "", "", "");
} else {
	$formData['fName'] = formatValidate($_POST["fName"], "First Name");
	$formData['lName'] = formatValidate($_POST["lName"], "Last Name");
	$formData['email'] = formatValidate($_POST["email"], "E-Mail");
	$formData['phoneNum'] = formatValidate($_POST["phoneNum"], "Phone Number");
	
	/*Unique Validation*/
	
	/*Duplicate Validation*/
	
	/*Record information*/
	//info valid  yes-set cookies, link to next page  no- display form, send errorMessage
	if ($errors == 0) {
		//set cookie form data
		setcookie("Index['fName']", $formData['fName'], time() + 3600);
		setcookie("Index['lName']", $formData['lName'], time() + 3600);
		setcookie("Index['email']", $formData['email'], time() + 3600);
		setcookie("Index['phoneNum']", $formData['phoneNum'], time() + 3600);
		//encrypt
		
		//link to next page
	 	$body .= "<a href='CompanyForm.php'>Company Information</a><br />\n";
	}
	
	//Redisplay form 
	if ($errors != 0){
		$body .= displayForm($formData['fName'], $formData['lName'], $formData['email'], $formData['phoneNum']);
		//possibly remove some cookies?
	}
}
/* -- */
?>

<!doctype html>
<html>
	<head>
		<!--
		Author: Conner Duncan
		Date: 12.04.18

		file: index.php
		-->
		<title>Index.php</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
	</head>

	<body>
		<h3>Conference Registration</h3>
		<?php echo $body; ?>
		<?php
		function displayForm($fName, $lName, $email, $phoneNum) { 
			return "" .
			"<form action='Index.php' method='post'>\n".
				"<p>\n".
					"Enter your name: First\n".
					"<input type='text' name='fName' value='".htmlentities($fName)."'>\n" .
					"last\n" .
					"<input type='text' name='lName' value='".htmlentities($lName)."'>\n" .
				"</p>\n" .
				"<p>\n" .
					"Enter your E-Mail address: \n" .
					"<input type='text' name='email' value='" . htmlentities($email) . "'>\n" .
				"</p>\n".
				"<p>\n".
					"Enter your phone number: \n" .
					"<input type='text' name='phoneNum' value='" . htmlentities($phoneNum) . "'>\n" .
				"</p>\n".
				"<input type='reset' name='reset' value='Reset Form'>\n".
				"<input type='submit' name='submit' value='Continue'>\n".
			"</form>";
		}
		?>
	</body>
</html>