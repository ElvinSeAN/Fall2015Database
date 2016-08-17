<html>
<body>

<button onclick="history.go(-1);">Back </button><br>
<?php
    echo "<h1>Actor REPORT BY Year</h1><br>";
    $servername = "Yourserver";
    $username = "Youruser";
    $password = "Yourpassword";
    $dbname = "Yourdatabase";
    $tempaid= 0 ;// temp actor id minimum 
    $tempaidend = 100 ;
    $tempyear= 0 ;// temp year minimum 
    $tempyearend =0;
    $currentyear=0;

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //insert into table
    // prepare sql and bind parameters
    $rating = array("PG", "R", "G");
    $getyear = $conn-> prepare ("select MIN(year) , MAX(year) from movie");
    $getyear-> execute();
     while( $yearrow = $getyear->fetch(PDO::FETCH_ASSOC) )
     {
        $tempyear =$yearrow['MIN(year)'];
        $tempyearend = $yearrow['MAX(year)'];
     }
     
    $getaid = $conn-> prepare ("select MIN(aid) , MAX(aid) from actor");
    $getaid-> execute();
     while( $aidrow = $getaid->fetch(PDO::FETCH_ASSOC) )
     {
        $tempaid =$aidrow['MIN(aid)'];
        $tempaidend = $aidrow['MAX(aid)'];
     }
   

     $currentyear=$tempyear;
    $tempname= 0;
    $temptableyear =0;
 

    
    
    while ($tempyear<=$tempyearend)
        {
 
        $stmt = $conn->prepare("select actor.aid, movie.title, movie.rating, role.rolename, movie.year, genre.gname, actor.fname, actor.lname
            from movie, genre, role, actor  
            where movie.gid=genre.gid and role.mid=movie.mid and role.aid = actor.aid and actor.aid =:tempaid and movie.year=:year");
        $stmt->bindParam(':tempaid', $_POST[actorid]);
        $stmt->bindParam(':year', $tempyear);
        // insert a row
        $stmt->execute();
       
     
            foreach ($stmt->fetchAll() as $row)
            {
                    if($tempname == $tempaid)
                    {
                        if($temptableyear == $row['year'])
                           { 
                                
                            print '<br /> ' . $row['title'] . '('. $row['rating'] .')'. $row['gname'] . '['. $row ['rolename'] . ']';
                            }
                            else
                            {
                                print  '<br />'.$row ['year'];
                            print '<br /> ' . $row['title'] . '('. $row['rating'] .')'. $row['gname'] . '['. $row ['rolename'] . ']';
                            $temptableyear= $row['year'];
                            }
                    }
                    else
                    {
                        print $row['lname']. ' ,' . $row['fname']. '<br />';
                        print  $row ['year'];
                      
                        print '<br /> ' . $row['title'] . '('. $row['rating'] .')'. $row['gname'] . '['. $row ['rolename'] . ']';
                         $tempname=$tempaid;
                         $temptableyear= $row['year'];
                    }
                
             }
        $tempyear= $tempyear + 1;
        
        }   
        $tempyear=$currentyear;
   echo "<br><br>"; 

 $conn = null;
?>
</body>
</html>
