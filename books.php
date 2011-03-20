<?php
	session_start();
	if(!isset($_SESSION['uname']))
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

 <title>rmitlibms | Books</title>

 <meta name="description" content="Staff attend to books at the RMIT Library."/>
 <meta name="keywords" content="books, library, borrow books, library books, library staff, university booklist"/>

 <link type="text/css" rel="stylesheet" href="style.css" />

</head> 

<body>

  <div class="navbarl">

   <a href="login.php">Logout</a>
 
 </div>

 <div class="navbarr">

    <a href="students.php">Students</a>
  | <strong>Books</strong>
  | <a href="loans.php">Loans</a>

 </div>
 <div><br/></div>
<hr/>

<form action="books.php" method="post">
 <div class="signin">
  <img src="logoxsmall.jpg" alt="rmitlibs" /><br/>
  <input type="text" name="search_book" maxlength="110" size="41" value="" />
  <input type="submit" value="Search" /> or <a href="#addsection">Add a book</a><br/>
 </div>
 <div class="homesign">  
  Search:
<!--  <input type="radio" name="search" />author -->
  <input type="radio" name="search" checked="checked" />title
<!--  <input type="radio" name="search" />keyword -->
  <input type="hidden" name="searched" value="true" /><br/><br/>
 </div>
</form>

<div class="results">
<strong>Search Results</strong>
</div>

<table class="borrow">

<?php

function showBooks($fp)
{
	while (!feof($fp))
	{			
		$line = fgets($fp);
		if(trim($line) != "")
		{
			$element = split("\|", $line);
			echoLine($element);
		}
	}
}

function delEditButtons()
{
	echo "<tr>";
	echo "<td></td><td><p>";
	echo "<form action='books.php' method='post'>";
	echo "<input type='submit' name='edit' value='Edit'/>";
	echo "</form>";	
	echo "<form action='books.php' method='post'>";
	echo "<input type='submit' name='delete' value='Delete'/>";
	echo "</form>";	
	echo "</p></td></tr>";
}

function echoLine($line)
{
	echo "<tr>";
	echo "<td><img src='return.png' alt='Book Photo' width='60' height='60' /></td>";
	echo "<td><p>";
	
	echo "<strong>" . $line[0] . "</strong>" . "<br/>";
	echo "<font color='grey'>by " . $line[1] . " - " . $line[2] . " - " . $line[3] . " - " . $line[4] . " pages</font><br/>";
	echo $line[5] . "<br/>";
	echo "<font color='#B22222'>Call Number: " . $line[6] . " | " . "Status: " . $line[7];

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

function editForm($element)
{
	echo "<tr>";
	echo "<td><img src='return.png' alt='Book Photo' width='60' height='60' /></td>";
	echo "<td></td><td><p>";

	echo "<form action='books.php' method='post'>";
	
	echo "<input type='text' size='30' name='title' value='$element[0]' />" . "<br/>";
	echo "<input type='text' size='30' name='author' value='$element[1]' />" . "<br/>";
	echo "<input type='text' size='10' name='category' value='$element[2]' />"; 
	echo "<input type='text' size='5' name='year' value='$element[3]' />";
	echo "<input type='text' size='6' name='pages' value='$element[4]' />" . "<br/>";
	echo "<textarea cols='45' rows='4' name='notes'>" . $element[5] . "</textarea>" . "<br/>";	
	echo "<input type='text' size='15' name='cnumber' value='$element[6]' />";
	echo "<input type='text' size='10' name='status' value='$element[7]' />" . "<br/>";
	echo "<input type='text' size='30' name='keywords' value='$element[8]' />" . "<br/>";
	echo "<input type='text' size='10' name='borrower' value='$element[9]' />";
	echo "<input type='text' size='10' name='due' value='$element[10]' />" . "<br/>";
	echo "<input type='submit' name='submit' value='Submit'/>";
	
	echo "</form>";
		
	echo "</p></td></tr>";
}

function add_button()
{
	echo "<tr>";
	echo "<td></td><td><p>";
	echo "<form action='books.php' method='post'>";
	echo "<a name='addsection'><input type='submit' name='add' value='Add Book'/></a>";
	echo "</form>";	
	echo "</p></td></tr>";
}

function addForm()
{
	echo "<tr>";
	echo "<td><img src='return.png' alt='Book Photo' width='60' height='60' /></td>";
	echo "<td></td><td><p>";

	echo "<form action='books.php' method='post'>";
	
	echo "<input type='text' size='30' name='title' value='Title' />" . "<br/>";
	echo "<input type='text' size='30' name='author' value='Author' />" . "<br/>";
	echo "<input type='text' size='10' name='category' value='Category' />"; 
	echo "<input type='text' size='5' name='year' value='Year' />";
	echo "<input type='text' size='6' name='pages' value='Pages' />" . "<br/>";
	echo "<textarea cols='45' rows='4' name='notes'>" . "Notes" . "</textarea>" . "<br/>";	
	echo "<input type='text' size='15' name='cnumber' value='Call Number' />";
	echo "<input type='text' size='10' name='status' value='Loan Status' />" . "<br/>";
	echo "<input type='text' size='30' name='keywords' value='Keywords' />" . "<br/>";
	echo "<input type='submit' name='addbook' value='Add Book'/>";
	
	echo "</form>";
		
	echo "</p></td></tr>";
}

function getBooks()
{
	$fp = fopen("books.txt","r"); 
	rewind($fp);

	$searched = $_POST['searched'];
	$edit = $_POST['edit'];
	$submit = $_POST['submit'];
	$add = $_POST['add'];
	$addbook = $_POST['addbook'];
	$delete = $_POST['delete'];

	if(isset($delete))
	{
		$cfp = fopen("bookcopy.txt","w"); 
	
		while(!feof($fp))
		{
			$line = fgets($fp);
			$element = split("\|", $line);

			if(strcasecmp($element[0], $_SESSION['search_book']) != 0)
			{
				fwrite($cfp,$line);
			}
		}
		fclose($fp);
		fclose($cfp);

		$bookFile = "books.txt";
		$copyFile = "bookcopy.txt";
		$fp = fopen($bookFile, "w+");		
		$cfp = fopen($copyFile, "r");		
		$file_contents = fread($cfp, filesize($copyFile));
		fwrite($fp, $file_contents);
		rewind($fp);
		
		showBooks($fp);
		add_button();
		
		fclose($fp);
		fclose($cfp);		
	}
	else if(isset($add))
	{
		addForm();
	}
	else if(isset($addbook))
	{
		$isMatch = false;
		$fp = fopen("books.txt","a"); 
		fwrite($fp,"\n");
									
		$title = trim($_POST['title']);
		$author = trim($_POST['author']);	
		$category = trim($_POST['category']);
		$year = trim($_POST['year']);
		$pages = trim($_POST['pages']);
		$notes = trim($_POST['notes']);
		$cnumber = trim($_POST['cnumber']);
		$status = trim($_POST['status']);
		$keywords = trim($_POST['keywords']);
		$borrower = "|";
		$due = "|";
		
		$write_values = array("$title","$author","$category","$year","$pages","$notes","$cnumber","$status","$keywords", "$borrower","$due"); 
		
		echoLine($write_values); //Need to echo this to so I can use the echoLine function before imploding.
		add_button();
		echo "<tr><td></td><td><p>Display all books on <a href='books.php'>Item Management</a> page.</p></td>";
				
		$write_values = implode("|",$write_values);
		fwrite($fp, $write_values);
		
		rewind($fp);
		fclose($fp);
	}
	else if(isset($submit))
	{
		$cfp = fopen("bookcopy.txt","w"); 
	
		while(!feof($fp))
		{
			$line = fgets($fp);
			$element = split("\|", $line);

			if(strcasecmp($element[0], $_SESSION['search_book']) == 0)
			{				
				$title = trim($_POST['title']);
				$author = trim($_POST['author']);	
				$category = trim($_POST['category']);
				$year = trim($_POST['year']);
				$pages = trim($_POST['pages']);
				$notes = trim($_POST['notes']);
				$cnumber = trim($_POST['cnumber']);
				$status = trim($_POST['status']);
				$keywords = trim($_POST['keywords']);
				$borrower = trim($_POST['borrower']);
				$due = trim($_POST['due']) . " |";
	
				$write_values = array("$title","$author","$category","$year","$pages","$notes","$cnumber","$status","$keywords","$borrower","$due"); 
				
				echoLine($write_values); 
				echo "<tr><td></td><td><p>Display all books on <a href='books.php'>Item Management</a> page.</p></td>";
				
				$write_values = implode("|",$write_values);
				fwrite($cfp, $write_values);
				fwrite($cfp,"\n");
			}
			else
			{
				fwrite($cfp,$line);
			}
		}
		fclose($fp);
		fclose($cfp);

		$bookFile = "books.txt";
		$copyFile = "bookcopy.txt";
		$fp = fopen($bookFile, "w+");		
		$cfp = fopen($copyFile, "r");		
		$file_contents = fread($cfp, filesize($copyFile));
		fwrite($fp, $file_contents);
		rewind($fp);
		fclose($fp);
		fclose($cfp);
	}
	else if(isset($edit))
	{
		$isMatch = false;
	
		while(!feof($fp) and $isMatch == false)
		{
			$line = fgets($fp);
			$element = split("\|", $line);
			
			if(strcasecmp(trim($element[0]), $_SESSION['search_book']) == 0)
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
		$_SESSION['search_book'] = $_POST['search_book'];
		$isMatch = false;
		
		while(!feof($fp) and $isMatch == false)
		{
			$line = fgets($fp);
			$element = split("\|", $line);
		
			if(strcasecmp($element[0], $_SESSION['search_book']) == 0)
			{
				$isMatch = true;
				echoLine($element);
				delEditButtons();
			}
			else
			{
				$isMatch = false;
			}
		}
	}
	else
	{
		showBooks($fp);
		add_button();
	}
}

getBooks();

?>

</table>

</body>
</html>
