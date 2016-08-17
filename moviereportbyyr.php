<html>
<body>

<button onclick="history.go(-1);">Back </button><br>
<?php
    echo "<h1>MOVIE REPORT BY YEAR</h1><br>";
    $servername = "Yourserver";
    $username = "Youruser";
    $password = "Yourpassword";
    $dbname = "Yourdatabase";
    $tempyear= 0 ;// temp year minimum 
    $tempyearend =0;

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //insert into table
    // prepare sql and bind parameters
    $getyear = $conn-> prepare ("select MIN(year) , MAX(year) from movie");
    $getyear-> execute();
     while( $yearrow = $getyear->fetch(PDO::FETCH_ASSOC) )
     {
        $tempyear =$yearrow['MIN(year)'];
        $tempyearend = $yearrow['MAX(year)'];
     }

while ($tempyear <=$tempyearend)
{
    
    echo $tempyear;

    $stmt = $conn->prepare("select movie.title, movie.rating, genre.gname, actor.fname, actor.lname 
        from movie, genre, role, actor  
        where movie.gid=genre.gid and role.mid=movie.mid and role.aid=actor.aid  and movie.year=:year");
    $stmt->bindParam(':year', $tempyear);
    // insert a row
    $stmt->execute();
    $temptitle = '';
 
        foreach ($stmt->fetchAll() as $row)
        {

            if ($temptitle == $row['title'])
            {
               
                print   ','. $row ['fname'] .' ' . $row ['lname'] ;
            }
            else
                {
                    print '<br /> ' . $row['title'] . '('. $row['rating'] .')'. $row['gname'] . '['. $row ['fname'] .' ' . $row ['lname'];
                    $temptitle = $row['title'];
                }
            
         }
     echo "<br><br>";    
   $tempyear= $tempyear + 1;
}
 $conn = null;
?>
</body>
</html>
