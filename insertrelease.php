<html>
<body>

 <button onclick="history.go(-1);">Back </button>

 <?php


echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Id</th><th>MID</th><th>MEDID</th><th>Release date</th></tr>";

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
    
    $stmt1 = $conn->prepare("INSERT INTO releaserecord (mid, medid, releasedate)
        VALUES( :mid, :medid, :releasedate)");
    $stmt1->bindParam(':mid', $_POST[mid]);
    $stmt1->bindParam(':medid', $_POST[medid]);
    $stmt1->bindParam(':releasedate', $_POST[releasedate]);
   
    $stmt1->execute();
    
    // prepare sql and bind parameters
    $stmt = $conn->prepare("Select * from releaserecord");
 

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
