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

 <title>rmitlibms | Home</title>

 <meta name="description" content="Student home page for the RMIT Library Management System"/>
 <meta name="keywords" content="home, books, library, borrow books, library books, library staff, university booklist"/>

 <link type="text/css" rel="stylesheet" href="style.css" />

</head> 

<body>

  <div class="navbarl">

   <a href="login.php">Logout</a>
   | <strong>Home</strong>
 
 </div>

 <div class="navbarr">

  <a href="search.php">Search</a>
  | <a href="borrow.php">Borrow</a>
  | <a href="return.php">Return</a>

 </div>
 <div><br/></div>
<hr/>

 <div class="home">

   <img src="logo.jpg" alt="rmitlibs" />
   <p>Welcome to the Library Management System. What would you like to do?</p>

 <br/>
 </div>

 <div class="homemid">
 <table class="home">
  <tr>
    <td>
    <a href="search.php"><img src="search.png" alt="Search" height="64" width="64"  
     title="Search" /></a><br/><br/>
    <a href="search.php">Search</a>
    </td>
    <td>
    <a href="borrow.php"><img src="borrow.png" alt="Borrow" width="64" height="64"
     title="Borrow" /></a><br/><br/>
    <a href="borrow.php">Borrow</a>
   </td>
   <td>
    <a href="return.php"><img src="return.png" alt="Return" width="64" height="64" 
     title="Return" /></a><br/><br/>
    <a href="return.php">Return</a>
   </td>
  </tr>
 </table>
 </div>

</body>
</html>
