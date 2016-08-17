<!DOCTYPE HTML> 
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body> 


<!-- List of button at the top for report -->
<!-- 
in this HTML will be using php as function to 
insert or update the table as well as generate report 
view has 3 php
viewmovie.php
viewrelease.php
viewactor.php
then there is general report for actor and movie 
actorreportbyyr.php
actorreportbyrating.php
actorreportbygenre.php
moviereportbyyr.php
moviereportbygenre.php
moviereportbyrating.php
because there is an requirement for single actor report 
singleactorbygenre.php
singleactorbyyear.php
singleactorbyrating.php
finally a report for release report
releaseresport.php
as for insert function there is three php
insertactor.php
insertmovie.php
insertgenre.php

 -->
<button onclick="history.go(-1);">Back </button>
<form action="viewactor.php" method="post">
	<input type="submit" value="viewactor"/>
</form>
<form action="viewmovie.php" method="post">
	<input type="submit" value="viewmovie"/>
</form>
<form action="viewrelease.php" method="post">
	<input type="submit" value="viewrelease"/>
</form>
<form action="actorreportbyyr.php" method="post">
	<input type="submit" value="Actor Report by year"/>
</form>
<form action="actorreportbygenre.php" method="post">
	<input type="submit" value="Actor Report by Genre"/>
</form>
<form action="actorreportbyrating.php" method="post">
	<input type="submit" value="Actor Report by Rating"/>
</form>
<form action="moviereportbyyr.php" method="post">
	<input type="submit" value="Movie Report by year"/>
</form>
<form action="moviereportbygenre.php" method="post">
	<input type="submit" value="Movie Report by genre"/>
</form>
<form action="moviereportbyrating.php" method="post">
	<input type="submit" value="Movie Report by rating"/>
</form>

<form action="releasereport.php" method="post">
	<input type="submit" value="Release Report "/>
</form>

<h2>INSERT ACTOR ID </h2>
<form action="singleactorbyyear.php" method="post">
Actor ID: <input type="text" name="actorid" />
	<input type="submit" value="Single actor Report by year"/>
</form>

<form action="singleactorbygenre.php" method="post">
Actor ID: <input type="text" name="actorid" />
	<input type="submit" value="Single actor Report by genre"/>
</form>



<form action="singleactorbyrating.php" method="post">
Actor ID: <input type="text" name="actorid" />
	<input type="submit" value="Single actor Report by rating"/>
</form>


<!-- list of from for insert and update  -->
<h1>Moive database</h1>
<h2>INSERT ACTOR </h2>
	<form action="insertactor.php" method="post">
	First name: <input type="text" name="fname" />&nbsp;
	Last name: <input type="text" name="lname" />&nbsp;
	Date of Birth: <input type="date" name="DOB" /> &nbsp;
	Gender: <input type="text" name="gender" /><br><br>
 
	<input type="submit" value="send"/>
	</form><br>

	<h2>UPDATE ACTOR </h2>
	<form action="updateactor.php" method="post">
	Old First name: <input type="text" name="fname" />&nbsp;
	Old Last name: <input type="text" name="lname" />&nbsp;
	Old Date of Birth: <input type="date" name="DOB" /> &nbsp;
	Old Gender: <input type="text" name="gender" /><br><br>

	New First name: <input type="text" name="nfname" />&nbsp;
	New Last name: <input type="text" name="nlname" />&nbsp;
	New Date of Birth: <input type="date" name="nDOB" /> &nbsp;
	New Gender: <input type="text" name="ngender" /><br><br>



	<input type="submit" value="update"/>
</form>

<h2>INSERT MOVIE </h2>
	<form action="insertmovie.php" method="post">
	Title: <input type="text" name="title" />&nbsp;
	Year: <input type="text" name="year" />&nbsp;
	Rating: <input type="text" name="rating" /> &nbsp;
	Genre: (please input the genre id )<input type="text" name="genre" /><br><br>


	<?php
	echo "<table style='border: solid 1px black;'>";
	echo "<tr><th>Id</th><th>Genre</th></tr>";
	class TableRows extends RecursiveIteratorIterator { 
	    function __construct($it) { 
	        parent::__construct($it, self::LEAVES_ONLY); 
	    }

	    function current() {
	        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
	    }

	    function beginChildren() { 
	        echo "<tr>"; 
	    } 

	    function endChildren() { 
	        echo "</tr>" . "\n";
	    } 
	} 


	$servername = "delphi.cs.uky.edu";
	$username = "sch226";
	$password = "u0669726";
	$dbname = "sch226";

	try {
	    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    // prepare sql and bind parameters
	    $stmt = $conn->prepare("Select * from genre group by gid");
	 	$stmt->execute();
	 	// set the resulting array to associative
	    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
	    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
	        echo $v;
	    	}
	    }
	catch(PDOException $e)
	    {
	    echo "Error: " . $e->getMessage();
	    }
	$conn = null;
	echo "</table>" ; 

	?>
	 
	<input type="submit" value="send"/>
	</form><br>

	<h2>UPDATE MOVIE </h2>
	<form action="updatemovie.php" method="post">
	Old Title: <input type="text" name="title" />&nbsp;
	Old Year: <input type="text" name="year" />&nbsp;
	Old Rating: <input type="text" name="rating" /> &nbsp;
	Old Genre: <input type="text" name="genre" /><br><br>

	New Title: <input type="text" name="ntitle" />&nbsp;
	New Year: <input type="text" name="nyear" />&nbsp;
	New Rating: <input type="text" name="nrating" /> &nbsp;
	New Genre: <input type="text" name="ngenre" /><br><br>



	<input type="submit" value="update"/>
</form>

<h2>INSERT GENRE </h2>
	<form action="insertgenre.php" method="post">
	Genre: <input type="text" name="gname" /><br><br>
 
	<input type="submit" value="send"/>
	</form><br>

	<h2>UPDATE GENRE </h2>
	<form action="updategenre.php" method="post">
	Old Genre: <input type="text" name="gname" /><br><br>
	New Genre: <input type="text" name="ngname" /><br><br>



	<input type="submit" value="update"/>
</form>


<h2>INSERT RELEASE </h2>
	<form action="insertrelease.php" method="post">
	Movie ID: <input type="text" name="mid" />&nbsp;
	Medium ID: <input type="text" name="medid" />&nbsp;
	Releasedate: <input type="date" name="releasedate" /><br><br>
 
	<input type="submit" value="send"/>
	</form><br>
<h2>UPDATE RELSEASE </h2>
	<form action="updaterelease.php" method="post">
	Old Movie ID: <input type="text" name="mid" />&nbsp;
	Old Medium ID:  <input type="text" name="medid" />&nbsp;
	Old Releasedate: <input type="date" name="releasedate" /><br><br>

	New Movie ID: <input type="text" name="nmid" />&nbsp;
	New Medium ID: <input type="text" name="nmedid" />&nbsp;
	New Releasedate: <input type="date" name="nreleasedate" /><br><br>



	<input type="submit" value="update"/>
</form>
<h2>Delete RELEASE </h2>
	<form action="deleterelease.php" method="post">
	Release ID: <input type="text" name="releaseid" /><br><br>




	<input type="submit" value="update"/>
	
</form>




</body>
</html>