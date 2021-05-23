<?php
header('Content-Type: text/html; charset=utf-8');
if(!empty($_GET['newsId'])){

    include("database.php");
    $query = "select * from comments where NewsId = ".$_GET['newsId'];
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