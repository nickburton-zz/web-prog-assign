<?php
	session_start();
	
	if(!isset($posted))
	{
		unset($_SESSION['uname']);
		unset($_SESSION['pword']);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" 
  xml:lang="en" lang="en">

<head>

 <title>rmitlibms | Log-in</title>

 <meta name="description" content="Student and Staff log-in for the RMIT Library Management System."/>
 <meta name="keywords" content="login, books, library, borrow books, library books, library staff, university booklist"/>

 <link type="text/css" rel="stylesheet" href="style.css" />

</head> 

<body>

  <div class="navbarl">

  <strong>Log-in</strong>
  | <a href="register.html">Register</a>
 
 </div>

 <div><br/></div>
<hr/>

     <form method="post" action="login.php">
      
       <div class="signin">
        <img src="logoxsmall.jpg" alt="rmitlibs" /><br/>       
        Username: <br/>
        <input type="text" maxlength="10" name="uname" size="15" value="" /><br/>
        Password: <br/>
        <input type="password" maxlength="10" name="pword" size="15" value="" /><br/>
        <input type="submit" value="Log-in" /> 
        <input type="hidden" name="posted" value="true" />
       or <a href="register.html">Register</a>.
       </div>
     </form>
    
 <div class="homemid"><img src="logo.jpg" alt="rmitlibs" /></div>
    
<?php

function showHome()
{
	echo "<div class='homemid'>";
	echo "<table class='home'>";
	echo "<tr><td>";
	echo "<a href='search.php'><img src='search.png' alt='Search' height='64' width='64' title='Search' /></a><br/><br/>";
	echo "<a href='search.php'>Search</a>";
	echo "</td><td>";
	echo "<a href='borrow.php'><img src='borrow.png' alt='Borrow' width='64' height='64' title='Borrow' /></a><br/><br/>";
	echo "<a href='borrow.php'>Borrow</a>";
	echo "</td><td>";
	echo "<a href='return.php'><img src='return.png' alt='Return' width='64' height='64' title='Return' /></a><br/><br/>";
	echo "<a href='return.php'>Return</a>";
	echo "</td></tr>";
	echo "</table></div>";
}

$valid_user = false;											
								
$posted = $_POST['posted'];
	
if(isset($posted))
{
	$uname = $_POST['uname'];									//	Define variables to capture the username
	$pword = $_POST['pword'];									//	and password from the form.
	
	$fp = fopen("users.txt","r");  								//	Open the file for reading.
	rewind($fp);												//	Will ensure the file is read from the start.
	
	while(!feof($fp) and $valid_user == false)
	{
		$line = fgets($fp);										//	Reads a line of the file and stores as a string.
		$element = split("\|", $line);							//	Puts the string into an array using the delimeter.
								
		if($uname != '')										//	Ensure username is enetered.
        {
        	if((strcmp(trim($element[0]), $uname) == 0) 		//	strcmp() ensures case sensitive validation.
			and (strcmp(trim($element[1]), $pword) == 0))
           	{       
				$_SESSION['uname'] = $uname;					//	If the form input matches the file variable, set session username
               	$_SESSION['pword'] = $pword;					//	and password.
				$_SESSION['user'] = trim($element[14]);					
				$valid_user = true;  						
            }
		}
	}
	fclose($fp);
}

if(isset($posted) == false)
{
	echo "<div class='homemid'><p>Please log in to access the Library Management System.</p></div>";
}
else if(strcmp(trim($element[15]),"Blocked") == 0)
{
	echo "<div class='homemid'><p>Your access to the Library Management System has been blocked.</p></div>";
}
else if ($valid_user == false)
{
	echo "<div class='homemid'><p>Your username and or password is incorrect. Please try again.</p></div>";
}
else
{
	if(strcmp(trim($element[14]), "Student") == 0)
	{
		echo "<div class='homemid'><p>Welcome to the Library Management System. What would you like to do?</p></div>";
		showHome();
	}
	else
	{
		echo "<div class='homemid'><p>Please click through to the <a href='students.php'>Student Administration</a> page.</p></div>";
	}
}
?>

</body>
</html>
