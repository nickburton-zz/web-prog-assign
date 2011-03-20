<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" 
  xml:lang="en" lang="en">

<head>

 <title>rmitlibs | Register</title>

 <meta name="description" content="Student register for the RMIT Library Management System."/>
 <meta name="keywords" content="register, books, library, borrow books, library books, library staff, university booklist"/>

 <link type="text/css" rel="stylesheet" href="style.css" />

</head> 

<body>

	<div class="navbarl">
  		<a href="home.php">Home</a>
   		| <strong>Register</strong>
 	</div>

 	<div><br/></div>

	<hr/>

  	<div class="homesign">
  		<img src="logoxsmall.jpg" alt="rmitlibs" /><br/><br/></div>
	<div class="results">
		<strong>Student Registration</strong></div>

<?php

//	Assign variables to capture (trimmed) input from the form for LOGIN details.

	$fname = str_replace(" ","",$_POST['fname']);
	$lname = str_replace(" ","",$_POST['lname']);
	$uname = str_replace(" ","",$_POST['uname']);
	$pword = str_replace(" ","",$_POST['pword']);
		
	$login_details = array($uname, $pword, $fname, $lname);

//	Assign variables to capture (trimmed) input from the form for STUDENT details.

	$snumber = str_replace(" ","",$_POST['snumber']);
	$email = str_replace(" ","",$_POST['email']);
	$program = str_replace(" ","",$_POST['program']);
	$program_end = str_replace(" ","",$_POST['program_end']);
	
	$student_details = array($snumber, $email, $program, $program_end);
	
//	Assigns variables to capture (trimmed) input from the form for PERSONAL details.

	$birth_date = str_replace(" ","",$_POST['birth_date']);
	$birth_month = str_replace(" ","",$_POST['birth_month']);
	$birth_year = str_replace(" ","",$_POST['birth_year']);
	
	$telephone = str_replace(" ","",$_POST['telephone']);
	$address = str_replace(" ","",$_POST['address']);
	$suburb = str_replace(" ","",$_POST['suburb']);
	$state = str_replace(" ","",$_POST['state']);
	$pcode = str_replace(" ","",$_POST['pcode']);
					
//	Put variables into an array (for the purposes of validation).

	$form_values = array($fname, $lname, $uname, $pword, 
						$snumber, $email, $program, $program_end, 
						$birth_date, $birth_month, $birth_year,
						$telephone,	$address, $suburb, $state, $pcode); 

//	Check each value in the array to ensure it has a value.
	
	$has_error = 0;

	foreach($form_values as $value)
	{
		if(strlen($value) == 0)
		{
			$has_error = 1;
			$msg[] = "Enter a value for all fields in the form;";
		}
	}
	
//	Test for numerical values only.

	$numFields = array($snumber,$program_end,$birth_date,$birth_month,$birth_year,$telephone,$pcode);
	$numTitles = array("Student Number","Program End","Birth Date","Birth Month","Birth Year","Telephone","Post Code");
	
	for($counter=0;$counter<count($numFields);$counter++)
	{
		if(!is_numeric($numFields[$counter]))
		{
			$has_error = 1;
			$msg[] = "Enter numerical values in the " . $numTitles[$counter] . " field;";
		}
	}

//	Test username is only letters or an underscore and not greater than 8 characters.

	if(!ereg("[a-zA-Z_]",$uname))
	{
		$has_error = 1;
		$msg[] = "Username must be only letters or an underscore;";
	}
	if(strlen($uname)>8)
	{
		$has_error = 1;
		$msg[] = "Username must be 8 characters or less;";
	}

//	Ensure student number is not less than 7 characters.

	if(strlen($snumber)<7)
	{
		$has_error = 1;
		$msg[] = "Student number must be 7 characters in length;";
	}

//	Send a dynamic message which confirms whether or not the submission is valid.

	echo "<p>";

  	if($has_error == 0)
	{
		echo "Your registration is <strong>complete</strong>. Your details are as follows:</strong><br/><br/>";
	}
	else
	{
		echo "Your registration is <strong>not complete</strong>. Please correct the following:<br/><br/>";		
		
		if(is_array($msg))
		{
			foreach($msg as $value)
			{
				echo " - " . $value . "<br/>";
			}
		}
		echo "<br/><br/>";
	}	
	
// 	Echo arrays to the screen.
    
	$login_titles = array("Username","Password", "First Name", "Last Name");
	
	for($counter = 0; $counter < count($login_titles); $counter++)
	{
			echo $login_titles[$counter];
			echo ": ";
			echo $login_details[$counter];
			echo "<br/>";
	}

	$student_titles = array("Student Number", "Email", "Program", "Program End");
	
	for($counter = 0; $counter < count($login_titles); $counter++)
	{
			echo $student_titles[$counter];
			echo ": ";
			echo $student_details[$counter];
			echo "<br/>";
	}
	
	echo "Date of Birth: " . $birth_date . "/" . $birth_month . "/" . $birth_year . "<br/>";
	
	$address_details = array($telephone, $address, $suburb, $state, $pcode);
	$address_titles = array("Telephone", "Address", "Suburb", "State", "Post Code");
	
	for($counter=0; $counter < count($login_titles); $counter++)
	{
			echo $address_titles[$counter];
			echo ": ";
			echo $address_details[$counter];
			echo "<br/>";
	}
	
//Provide a link to the Log-in page if form was valid and write to the file. 
	
	if($has_error == 0)
	{
		echo"<br/><a href='login.php'>Go to Log-in Page</a></p>";

		$fp = fopen("users.txt","a");
		fwrite($fp, "\n");
		
		foreach($login_details as $value)
		{
			fwrite($fp, $value);
			fwrite($fp, "|");
		}
		
		foreach($student_details as $value)
		{
			fwrite($fp, $value);
			fwrite($fp, "|");
		}
	
		fwrite($fp, $birth_date . $birth_month . $birth_year . "|");
	
		fwrite($fp, $telephone . "|");
		fwrite($fp, $address . "|" . $suburb . "|");
		fwrite($fp, $state . "|" . $pcode . "|");
		fwrite($fp, "Student|");
		fwrite($fp, "Unblocked|");
		
		fclose($fp);
	}

?>

</body>
</html>