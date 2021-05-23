<?php
    header('Content-Type: text/html; charset=utf-8');

    if (isset($_GET['kol']) && isset($_GET['tek']))
    {
        include("database.php");

        $query = "select * from news LIMIT ".$_GET['kol']." OFFSET ".$_GET['tek'];
        $myArray = array();

        if ($result = mysqli_query($con, $query)) { 
            while ($row = $result->fetch_array(MYSQLI_ASSOC)){
                $myArray[] = $row;  
            }
             
            $json = json_encode($myArray);        
            echo $json;        
        }
    }
?>