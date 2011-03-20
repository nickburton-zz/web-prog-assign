<?php
	session_start();
	if(!isset($_SESSION['uname']))
	{
		echo "You must <a href='login.php'>log-in</a> to access this page.";
		exit;
	}
	if($_SESSION['user'] != "Student")
	{
		echo "You must be a Student to access this page.";
		exit;
	}	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" 
  xml:lang="en" lang="en">

<head>

 <title>rmitlibms | Search</title>

 <meta name="description" content="Student search for the RMIT Library Management System."/>
 <meta name="keywords" content="search, books, library, borrow books, library books, library staff, university booklist"/>

 <link type="text/css" rel="stylesheet" href="style.css" />

</head> 

<body>

  <div class="navbarl">

  <a href="login.php">Logout</a>  
  | <a href="home.php">Home</a>

 
  </div>

 <div class="navbarr">

  <strong>Search</strong>
  | <a href="borrow.php">Borrow</a>
  | <a href="return.php">Return</a>
  
 </div>
 <div><br/></div>
<hr/>

 <form method="get" action="borrow.php">

 <div class="search">

   <img src="logo.jpg" alt="rmitlibs" />
  <p>Let's get straight to it. Which book are you after?</p>

  <input type="text" name="search" maxlength="110" size="55" value="" /><br/><br/>
  Search: 
  <input type="radio" name="type" value="author" />author
  <input type="radio" name="type" value="title" checked="checked" />title
  <input type="radio" name="type" value="keywords" />keywords
  <input type="radio" name="type" value="ISBN" />ISBN<br/><br/>
  <input type="submit" value="Search Books" />   

 </div>

 </form>

</body>
</html>
