<html>
<body>

<button onclick="history.go(-1);">Back </button><br>
<?php
    echo "<h1>Actor REPORT BY Rating</h1><br>";
    $servername = "Yourserver";
    $username = "Youruser";
    $password = "Yourpassword";
    $dbname = "Yourdatabase";
    $tempaid= 0 ;// temp actor id minimum 
    $tempaidend = 100 ;
    $tempgid= 0 ;// temp year minimum 
    $tempgidend =2;
    $currentyear=0;

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //insert into table
    // prepare sql and bind parameters
    $rating = array("PG", "R", "G");
    $getaid = $conn-> prepare ("select MIN(aid) , MAX(aid) from actor");
    $getaid-> execute();
     while( $aidrow = $getaid->fetch(PDO::FETCH_ASSOC) )
     {
        $tempaid =$aidrow['MIN(aid)'];
        $tempaidend = $aidrow['MAX(aid)'];
     }
   

     $currentyear=$tempgid;
    $tempname= 0;
    $temptableyear =0;
 
while ($tempaid <= $tempaidend)
{
    
    
    while ($tempgid<=$tempgidend)
        {
 
        $stmt = $conn->prepare("select genre.gid, actor.aid, movie.title, movie.rating, role.rolename, movie.year, genre.gname, actor.fname, actor.lname
            from movie, genre, role, actor  
            where movie.gid=genre.gid and role.mid=movie.mid and role.aid = actor.aid and actor.aid =:tempaid and movie.rating= :rating");
        $stmt->bindParam(':tempaid', $tempaid);
        $stmt->bindParam(':rating', $rating[$tempgid]);
        // insert a row
        $stmt->execute();
       
     
            foreach ($stmt->fetchAll() as $row)
            {
                    if($tempname == $tempaid)
                    {
                        if($temptableyear == $tempgid)
                           { 
                                
                            print '<br /> ' . $row['title'] . '('. $row['rating'] .')'. $row['gname'] . '['. $row ['rolename'] . ']';
                            }
                            else
                            {
                                print  '<br />'.$row ['rating'];
                            print '<br /> ' . $row['title'] . '('. $row['rating'] .')'. $row['gname'] . '['. $row ['rolename'] . ']';
                            $temptableyear= $tempgid;
                            }
                    }
                    else
                    {
                        print $row['fname']. ' ' . $row['lname']. '<br />';
                    
                        print $row['rating'];
                        print '<br /> ' . $row['title'] . '('. $row['rating'] .')'. $row['gname'] . '['. $row ['rolename'] . ']';
                         $tempname=$tempaid;
                         $temptableyear= $tempgid;
                    }
                
             }
        $tempgid= $tempgid + 1;
        
        }   
        $tempgid=$currentyear;
   echo "<br><br>"; 
   $tempaid = $tempaid + 1;
}
 $conn = null;
?>
</body>
</html>
