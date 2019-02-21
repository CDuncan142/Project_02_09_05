<!-- php functions -->
<!--Global variables-->
<?php
//Function to connect to database
function connectToDB($hostname, $username, $password) {
	$DBConnect = mysqli_connect($hostname, $username, $password);
	if(!$DBConnect){
		echo "<p>Connection error: " . mysqli_connect_error() . "</p><br />\n";
	}
	return $DBConnect;
}

//function to select a database
function selectDB($DBConnect, $DBName) {
	//select database
	$success = mysqli_select_db($DBConnect, $DBName);
	//test for successful selection  yes- nothing, else create database and select it
	if ($success) {
//				echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
	} else {
//				echo "<p>Could not select the \"$DBName\" database: " . mysqli_error($DBConnect) . ", creating it.</p>\n";
		//create database and test it
		$sql = "CREATE DATABASE $DBName";
		if(mysqli_query($DBConnect, $sql)) {
//					echo "<p>Successfully created the \"$DBName\" database.</p><br />\n";
			//select new database and test it
			$success = mysqli_select_db($DBConnect, $DBName);
			if ($success) {
//						echo "<p>Successfully selected the \"$DBName\" database.</p><br />\n";
			} else {
//						echo "<p>Could not select the newly created \"$DBName\" database:" . mysqli_error($DBConnect) . "</p>\n";
			}

		}
		else {
//					echo "<p>Could not create the \"$DBName\" datavase: ". mysqli_error($DBConnect) . "</p>\n";
		}
	}
	return $success;
}

function createTable($DBConnect, $tableName) {
	//Return whether or not to continue
	$success = false;
	//find table
	$sql = "SHOW TABLES LIKE '$tableName'";
	$result = mysqli_query($DBConnect, $sql);
	//check if table exists
	if (mysqli_num_rows($result) === 0){
//				echo "<p>Number of rows in" .
//				" <strong>$tableName</strong>: " .
//				mysqli_num_rows($result) . ".</p>\n";
		//create table if does not exist

		//create incrementing primary key and columns for the table
		$sql = "CREATE TABLE $tableName " .
			"(registrarID SMALLINT NOT NULL".
			" AUTO_INCREMENT PRIMARY KEY,".
			" randomRecord VARCHAR(40),";
		$result = mysqli_query($DBConnect, $sql);
		if ($result === false){
			$success = false;
//					echo "<p>Unable to create the $tableName table.</p>";
//					echo "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";

		}
		else {
			$success = true;
//					echo "<p>Successfully created the $tableName table.</p>";
		}
	}
	else {
		$success = true;
//				echo "The $tableName table already exists.<br />\n";
	}
	return $success;
}

function errorMessage($subject, $errMsg) {
	global $errors;
	$errors++;
	return "Error with $subject: $errorMsg<br />\n";
}

function formatValidate($fieldData, $fieldName){
	global $errors;
	$retval = "";

	if(empty($fieldData)){
		$errors++;
		$retval = "";
		echo "$fieldName is required.<br />";
	}else{
		//format value (bulletproofing)
		$retval = trim($fieldData);
		$retval = stripslashes($retval);
	}
	return $retval;
}
?>