<html>
<body>

<button onclick="history.go(-1);">Back </button><br>
<?php
    echo "<h1>Release Report</h1><br>";
    $servername = "Yourserver";
    $username = "Youruser";
    $password = "Yourpassword";
    $dbname = "Yourdatabase";
    $tempaid= 0 ;// temp actor id minimum 
    $tempaidend = 100 ;
    $tempmedium= 0 ;// temp year minimum 
    $tempmediumend =0;
    $currentmedium=0;

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //insert into table
    // prepare sql and bind parameters
    $rating = array("PG", "R", "G");
    $getmedium = $conn-> prepare ("select MIN(medid) , MAX(medid) from medium");
    $getmedium-> execute();
     while( $yearrow = $getmedium->fetch(PDO::FETCH_ASSOC) )
     {
        $tempmedium =$yearrow['MIN(medid)'];
        $tempmediumend = $yearrow['MAX(medid)'];
     }
     

   

    $currentmedium=$tempmedium;
    $tempname= 0;
    $temptableyear =0;
 

    
    
    while ($tempmedium<=$tempmediumend)
        {
 
        $stmt = $conn->prepare("select movie.title, movie.rating, releaserecord.releasedate,medium.medname, genre.gname
            from releaserecord, movie, medium, genre
            where medium.medid=releaserecord.medid and movie.mid=releaserecord.mid and genre.gid=movie.gid and medium.medid=:tempmedium Order by releaserecord.releasedate");

        $stmt->bindParam(':tempmedium', $tempmedium);
        // insert a row
        $stmt->execute();
       
     
            foreach ($stmt->fetchAll() as $row)
            {
                    if($tempname == $tempmedium)
                    {
                        if($temptableyear == $row['year'])
                           { 
                                
                            print '<br /> ' . $row['title'] . '('. $row['rating'] .')'. $row['medname'] . '['. $row ['releasedate'] . ']';
                            }
                            else
                            {
                                print  '<br />'.$row ['medname'];
                            print '<br /> ' . $row['title'] . '('. $row['rating'] .')'. $row['medname'] . '['. $row ['releasedate'] . ']';
                            $temptableyear= $row['year'];
                            }
                    }
                    else
                    {
                      
                        print  '<br />'.'<br />'. $row ['medname'];
                      
                        print '<br /> ' . $row['title'] . '('. $row['rating'] .')'. $row['medname'] . '['. $row ['releasedate'] . ']';
                         $tempname=$tempmedium;
                         $temptableyear= $row['year'];
                    }
                
             }
            
        $tempmedium= $tempmedium + 1;
        
        }   
  

 $conn = null;
?>
</body>
</html>
