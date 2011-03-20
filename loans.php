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

 <title>rmitlibms | Loans</title>

 <meta name="description" content="Staff attend to borrowed items in Library Management System."/>
 <meta name="keywords" content="loans, books, library, borrow books, library books, library staff, university booklist"/>

 <link type="text/css" rel="stylesheet" href="style.css" />

</head> 

<body>

  <div class="navbarl">

   <a href="login.php">Logout</a>
 
 </div>

 <div class="navbarr">

   
  <a href="students.php">Students</a>
  | <a href="books.php">Books</a>
  | <strong>Loans</strong>

 </div>
 <div><br/></div>
<hr/>

<div class="homesign">
  <img src="logoxsmall.jpg" alt="rmitlibs" /><br/><br/>
</div>
<div class="results">
<strong>Loaned Books</strong>

</div>

<table class="loans">
 
<?php

function echoLine($line)
{
	//This function is used in conjunction with a while/if loop to display only those books that are on loan.
	echo "<tr>";
	echo "<td><img src='return.png' alt='Book Photo' width='60' height='60' /></td>";
	echo "<td><p>";
	
	echo "<strong>" . $line[0] . "</strong>" . "<br/>";
	echo "<font color='grey'>by " . $line[1] . " - " . $line[2] . " - " . $line[3] . " - " . $line[4] . " pages</font><br/>";
	echo $line[5] . "<br/>";
	echo "<font color='#B22222'>Call Number: " . $line[6] . " | " . "Status: " . $line[7];

	//This two if functions allow for any cases where the text file may not have written back perfectly.	
	if(trim($line[9]) != "" and trim($line[9]) != "|")
	{
		echo " | User: " . $line[9];
	}
	
	if(trim($line[10]) != "" and trim($line[10]) != "|")
	{
		echo " | Due: " . $line[10];
	}
	
	echo "</font>";
	echo "<br/>";
		
	echo "</p></td></tr>";
	echo "\n";
}

function getBooks()
{
	//This is the main function.
	$fp = fopen("books.txt","r"); 
	rewind($fp);
	
	while(!feof($fp))
	{
		$line = fgets($fp);
		$element = split("\|", $line);
		
		//This line of code ensures only loaned items are displayed.
		if(strcmp(trim($element[7]), "On Loan") == 0)
		{						
			//These two arrays will be sorted for display.
			$dueItems["$element[0]"] = $element[10];
		}
	}
	
	//Sort the associative array but keep the relative key values.
	asort($dueItems);
	
	//Put the key values into an array for comparison.
	foreach($dueItems as $key => $value)
	{
		$dueKeys[] = $key;
	}
		
	//Echo the items to screen in date order.
	rewind($fp);

	foreach($dueKeys as $value)
	{
		while(!feof($fp))
		{
			$line = fgets($fp);
			$element = split("\|", $line);
						
			if(strcmp(trim($element[0]), trim($value)) == 0)
			{
				echoLine($element);
			}
		}
		rewind($fp);
	}			
}

getBooks();

?>
 
</table>

</body>
</html>
