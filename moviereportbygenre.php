<html>
<body>

<button onclick="history.go(-1);">Back </button><br>
<?php
    echo "<h1>MOVIE REPORT BY Genre</h1><br>";
    $servername = "Yourserver";
    $username = "Youruser";
    $password = "Yourpassword";
    $dbname = "Yourdatabase";
    $tempgid= 0 ;// temp year minimum 
    $tempgidend = 0 ;

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //insert into table
    // prepare sql and bind parameters
    $getgid = $conn-> prepare ("select MIN(gid), MAX(gid) from genre");
    $getgid-> execute();
     while( $yearrow = $getgid->fetch(PDO::FETCH_ASSOC) )
     {
        $tempgid =$yearrow['MIN(gid)'];
        $tempgidend = $yearrow['MAX(gid)'];
     }

while ($tempgid <= $tempgidend)
{
    
    $getgname = $conn-> prepare ("select gname from genre where genre.gid=:tgid");
    $getgname->bindParam(':tgid', $tempgid);
    $getgname-> execute();
    while( $yearrow = $getgname->fetch(PDO::FETCH_ASSOC) )
     {
        echo $yearrow['gname'];
        }


    $stmt = $conn->prepare("select movie.title, movie.rating, actor.fname, actor.lname 
        from movie, genre, role, actor  
        where movie.gid=genre.gid and role.mid=movie.mid and role.aid=actor.aid  and genre.gid= :tempgid");
    $stmt->bindParam(':tempgid', $tempgid);
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
