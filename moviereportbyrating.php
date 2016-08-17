<html>
<body>

<button onclick="history.go(-1);">Back </button><br>
<?php
    echo "<h1>MOVIE REPORT BY Rating</h1><br>";
    $servername = "Yourserver";
    $username = "Youruser";
    $password = "Yourpassword";
    $dbname = "Yourdatabase";
    $tempgid= 0 ;// temp year minimum 
    $tempgidend = 2 ;

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //insert into table
    // prepare sql and bind parameters
    $rating = array("PG", "R", "G");

while ($tempgid <= $tempgidend)
{
    
    
        echo $rating[$tempgid];
      


    $stmt = $conn->prepare("select movie.title, movie.rating, actor.fname, actor.lname 
        from movie, genre, role, actor  
        where movie.gid=genre.gid and role.mid=movie.mid and role.aid=actor.aid  and movie.rating=:tempgid");
    $stmt->bindParam(':tempgid', $rating[$tempgid]);
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
   $tempgid= $tempgid + 1;
}
 $conn = null;
?>
</body>
</html>
