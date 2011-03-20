<?php
	session_start();
	if(!isset($_SESSION['uname']) or !isset($_SESSION['pword']))
	{
		echo "You must <a href='login.php'>log-in</a> to access this page.";
		exit;
	}
	if($_SESSION['user'] != "Staff")
	{
		echo "You must be a Staff Member to access this page.";
		exit;
	}	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" 
  xml:lang="en" lang="en">

<head>

 <title>rmitlibms | Students</title>

 <meta name="description" content="Staff management of Students at the RMIT Library."/>
 <meta name="keywords" content="manage students, staff, books, library, borrow books, library books, library staff, university booklist"/>

 <link type="text/css" rel="stylesheet" href="style.css" />

</head> 

<body>

  <div class="navbarl">

   <a href="login.php">Logout</a>
 
 </div>

 <div class="navbarr">

  <strong>Students</strong>
  | <a href="books.php">Books</a>
  | <a href="loans.php">Loans</a>

 </div>
 <div><br/></div>
<hr/>

<form action="students.php" method="post">
 <div class="homesign">
  <img src="logoxsmall.jpg" alt="rmitlibs" /><br/>
  <input type="text" name="search_student" maxlength="110" size="41" value="" />
  <input type="submit" name="search" value="Search" /><br/>
  Search: 
  <input type="hidden" name="searched" value="true" />
<!--  <input type="radio" name="search" />student number -->
  <input type="radio" name="search" checked="checked" />student name<br/><br/>
 </div>
</form>

<div class="results">
<strong>Search Results</strong>
</div>

<table class="students">
  
<?php

function edit_button()
{
	echo "<tr><td></td>";
	echo "<td><p>";
	echo "<form action='students.php' method='post'>";
	echo "<input type='submit' name='edit' value='Edit'/>";
	echo "</form>";	
	echo "</p></td></tr>";
}

function echoLine($element)
{
	echo "<tr>";
	echo "<td><div class='shadow'><div class='content'><img src='photo.jpg' alt='Student Photo' /></div></div></td>";
	echo "<td><p>";

	echo "<strong>" . $element[2] . " " . $element[3] . "</strong>" . "<br/>";
	echo "Username: " . $element[0] . "<br/>";
	echo "Password: " . $element[1] . "<br/>";
	echo "Student Number: " . $element[4] . "<br/>";
	echo $element[5] . "<br/>";
	echo $element[15] . "<br/>";
		
	echo "</p></td></tr>";
	echo "\n";
}

function editForm($element)
{
	echo "<tr>";
	echo "<td><div class='shadow'><div class='content'><img src='photo.jpg' alt='Student Photo' /></div></div></td>";
	echo "<td><p>";

	echo "<form action='students.php' method='post'>";
	
	echo "<input type='text' size='15' name='fname' value='$element[2]' />";
	echo "<input type='text' size='15' name='lname' value='$element[3]' />" . "<br/>";
	echo "<input type='text' size='10' name='uname' value='$element[0]' />"; 
	echo "<input type='text' size='10' name='pword' value='$element[1]' />";
	echo "<input type='text' size='5' name='snumber' value='$element[4]' />" . "<br/>";
	echo "<input type='text' size='35' name='email' value='$element[5]' />" . "<br/>";	
	echo "<input type='text' size='25' name='program' value='$element[6]' />";
	echo "<input type='text' size='5' name='program_end' value='$element[7]' />" . "<br/>";
	echo "<input type='text' size='15' name='birth' value='$element[8]' />";
	echo "<input type='text' size='15' name='telephone' value='$element[9]' />" . "<br/>";
	echo "<input type='text' size='35' name='address' value='$element[10]' />" . "<br/>";
	echo "<input type='text' size='15' name='suburb' value='$element[11]' />";	
	echo "<input type='text' size='5' name='state' value='$element[12]' />";	
	echo "<input type='text' size='5' name='pcode' value='$element[13]' />" . "<br/>";	
	echo "<input type='text' size='35' name='status' value='$element[15]' />" . "<br/>";	
	echo "<input type='submit' name='submit' value='Submit'/>";
	
	echo "</form>";
		
	echo "</p></td></tr>";
}

function getStudents()
{
	$fp = fopen("users.txt","r"); 
	rewind($fp);

	$searched = $_POST['searched'];
	$edit = $_POST['edit'];
	$submit = $_POST['submit'];

	if(isset($submit))
	{
		$isMatch = false;
		$cfp = fopen("usercopy.txt","w"); 
	
		while(!feof($fp))
		{
			$line = fgets($fp);
			$element = split("\|", $line);

			if(strcasecmp(($element[2] . " " . $element[3]), $_SESSION['search_student']) == 0)
			{
				$isMatch = true;
				
				//Assign variables to capture (trimmed) input from the form.
				$uname = str_replace(" ","",$_POST['uname']);
				$pword = str_replace(" ","",$_POST['pword']);	
				$fname = str_replace(" ","",$_POST['fname']);
				$lname = str_replace(" ","",$_POST['lname']);
				$snumber = str_replace(" ","",$_POST['snumber']);
				$email = str_replace(" ","",$_POST['email']);
				$program = str_replace(" ","",$_POST['program']);
				$program_end = str_replace(" ","",$_POST['program_end']);
				$birth = str_replace(" ","",$_POST['birth']);
				$telephone = str_replace(" ","",$_POST['telephone']);
				$address = str_replace(" ","",$_POST['address']);
				$suburb = str_replace(" ","",$_POST['suburb']);
				$state = str_replace(" ","",$_POST['state']);
				$pcode = str_replace(" ","",$_POST['pcode']);
				$status = str_replace(" ","",$_POST['status']);
	
				$write_values = array("$uname","$pword","$fname","$lname","$snumber","$email","$program",
									"$program_end","$birth","$telephone","$address","$suburb","$state","$pcode","Student","$status");
				echoLine($write_values);
				echo "<tr><td></td><td><p>Back to <a href='students.php'>Student Management</a>.</p></td>";
				
				$write_values = implode("|",$write_values);
				fwrite($cfp, $write_values);
				fwrite($cfp,"\n");
			}
			else
			{
				$isMatch = false;
				fwrite($cfp,$line);
			}
		}
		fclose($fp);
		fclose($cfp);

		$userFile = "users.txt";
		$copyFile = "usercopy.txt";
		$fp = fopen($userFile, "w+");		
		$cfp = fopen($copyFile, "r");		
		$file_contents = fread($cfp, filesize($copyFile));
		fwrite($fp, $file_contents);
		fclose($cfp);
		
		rewind($fp);
		fclose($fp);
	}
	else if(isset($edit))
	{
		$isMatch = false;
	
		while(!feof($fp) and $isMatch == false)
		{
			$line = fgets($fp);
			$element = split("\|", $line);
			
			//This compares the first and second name of a student with the search field.
			if(strcasecmp(($element[2] . " " . $element[3]), $_SESSION['search_student']) == 0)
			{
				$isMatch = true;
				editForm($element);
			}
			else
			{
				$isMatch = false;
			}
		}
	}
	else if(isset($searched))
	{
		$_SESSION['search_student'] = $_POST['search_student'];
		$isMatch = false;
		
		while(!feof($fp) and $isMatch == false)
		{
			$line = fgets($fp);
			$element = split("\|", $line);
		
			if(strcasecmp(($element[2] . " " . $element[3]), $_SESSION['search_student']) == 0)
			{
				$isMatch = true;
				echoLine($element);
				edit_button();
			}
			else
			{
				$isMatch = false;
			}
		}
	}
	else
	{
		while (!feof($fp))
		{			
			$line = fgets($fp);
			$element = split("\|", $line);
				
			if(strcmp(trim($element[14]), "Student") == 0)
			{
				echoLine($element);
			}
		}
	}
}

getStudents();


 

//Populate the form with variables.

/*
      <a href="students.html">Edit account</a> - 
      <a href="students.html">Block account</a> - 
      <a href="students.html">Email student</a>
*/

?>
 
</table>

</body>
</html>
