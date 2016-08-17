<html>
<body>

 <button onclick="history.go(-1);">Back </button>

 <?php
echo $_POST[title];
echo $_POST[year];
echo $_POST[rating];
echo $_POST[genre];

echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Id</th><th>Title</th><th>Year</th><th>Rating</th><th>Genre</th></tr>";

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
    
    $stmt1 = $conn->prepare("INSERT INTO movie ( title , year , rating , gid) 
        VALUES( :title, :year, :rating, :gid)");
    $stmt1->bindParam(':title', $_POST[title]);
    $stmt1->bindParam(':year', $_POST[year]);
    $stmt1->bindParam(':rating', $_POST[rating]);
    $stmt1->bindParam(':gid', $_POST[genre]);
    $stmt1->execute();
    
    // prepare sql and bind parameters
    $stmt = $conn->prepare("Select * from movie");
 

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
