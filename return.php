<?php
	session_start();
	if(!isset($_SESSION['uname']) or !isset($_SESSION['pword']))
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

 <title>rmitlibms | Return</title>

 <meta name="description" content="Students borrow from the RMIT Library Management System."/>
 <meta name="keywords" content="books, library, borrow books, library books, library staff, university booklist"/>

 <link type="text/css" rel="stylesheet" href="style.css" />

</head> 

<body>

  <div class="navbarl">

   <a href="login.php">Logout</a>
   | <a href="home.php">Home</a>
 
 </div>

 <div class="navbarr">

  <a href="search.php">Search</a>
  | <a href="borrow.php">Borrow</a>
  | <strong>Return</strong>

 </div>
 <div><br/></div>
<hr/>

 <div class="homesign">
  <a href="search.php"><img src="logoxsmall.jpg" alt="rmitlibs" /></a><br/><br/>
 </div>

<div class="results">
<strong>My Books</strong>
</div>


<table class="borrow">

<?php

function return_button()
{
	echo "<tr><td></td>";
	echo "<td><p>";
	echo "<input type='submit' name='return' value='Return'/>";
	echo "</form>";	
	echo "</p></td></tr>";
}

function echoLine($line)
{
	echo "<tr>";
	echo "<td><img src='return.png' alt='Book Photo' width='60' height='60' /></td>";
	echo "<td><p>";
	
	echo "<strong>" . $line[0] . "</strong><br/>";
	echo "<font color='grey'>by " . $line[1] . " - " . $line[2] . " - " . $line[3] . " - " . $line[4] . " pages</font><br/>";
	echo $line[5] . "<br/>";
	echo "<font color='#B22222'>Call number: " . $line[6] . " | Status: " . $line[7];

	if(trim($line[9]) != "" and trim($line[9]) != "|")
	{
		echo " | User: " . $line[9] . " | Due: " . $line[10];
	}
	
	echo "</font>";
	echo "<br/>";
	
	if(trim($line[7]) == "On Loan")
	{
		echo "<input type='checkbox' name='toReturn[]' value='" . $line[0] . "' /> Return this item";
	}
	echo "</p></td></tr>";
	echo "\n";
}

function getBooks()
{
	$fp = fopen("books.txt","r"); 
	rewind($fp);
	
	$return = $_POST['return'];

	if (isset($return))
	{
		$toReturn = $_POST['toReturn'];	
		$cfp = fopen("bookcopy.txt","w"); 
		
		for($counter=0;$counter<count($toReturn);$counter++)
		{
			while(!feof($fp))
			{
				$line = fgets($fp);
				$element = split("\|", $line);
				
				if(strcmp($element[0], $toReturn[$counter]) == 0)
				{
					$element[7] = "Available";
					$element[9] = " ";
					$element[10] = " ";
					
					echoLine($element);
					
					$write_values = implode("|",$element);
					fwrite($cfp, $write_values);
				}
				else
				{
					fwrite($cfp,$line);
				}
			}
				
			echo "<tr><td></td><td><p>Display all of <a href='return.php'>My Books</a></p></td></td></tr>";
			
			fclose($fp);
			fclose($cfp);
	
			$bookFile = "books.txt";
			$copyFile = "bookcopy.txt";
			$fp = fopen($bookFile, "w+");		
			$cfp = fopen($copyFile, "r");		
			$file_contents = fread($cfp, filesize($copyFile));
			fwrite($fp, $file_contents);
			fclose($cfp);
			rewind($fp);		
			fclose($fp);
		}
	}
	else
	{	
		echo "<form action='return.php' method='post'>";
	
		while(!feof($fp))
		{
			$line = fgets($fp);
			$element = split("\|", $line);
			
			if(strcmp(trim($element[9]), $_SESSION['uname']) == 0 and trim($element[9]) != "")
			{						
				echoLine($element);
				$counter++;
			}
		}
		if($counter != 0)
		{
			return_button();
		}
		else
		{
			echo "<tr><td></td><p>You have no books. <a href='search.html'>Search</a> for books.</p></td></tr>";
		}
	}
}
getBooks();
?>


  
</table>

</body>
</html>
