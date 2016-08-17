<html>
<body>

 <button onclick="history.go(-1);">Back </button>

 <?php


echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Id</th><th>Firstname</th><th>Lastname</th><th>Date of birth</th><th>Gender</th></tr>";

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


    $servername = "Yourserver";
    $username = "Youruser";
    $password = "Yourpassword";
    $dbname = "Yourdatabase";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //insert into table
    $stmt1 = $conn->prepare("INSERT INTO actor (fname, lname, dob, gender) VALUES( :fname, :lname, :dob, :gender)");
    $stmt1->bindParam(':fname', $_POST[fname]);
    $stmt1->bindParam(':lname', $_POST[lname]);
    $stmt1->bindParam(':dob', $_POST[DOB]);
    $stmt1->bindParam(':gender', $_POST[gender]);
    $stmt1->execute();

    // prepare sql and bind parameters
    $stmt = $conn->prepare("Select * from actor");
 

    // insert a row
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
</body>
</html>
