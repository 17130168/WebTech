<?php
$comment = $_POST['data'];
$result = "";

if(!empty($comment['name']) && !empty($comment['text']) && !empty($comment['email']) && !empty($comment['newsId'])){

    include("database.php");
    $query = "insert into comments(datetime, name, email, text, newsid) values(Now(), '".$comment['name']."', '".$comment['email']."', '".$comment['text']."', '".$comment['newsId']."')";
    
    if (mysqli_query($con,$query))
    {
        $result =  "Комментарий был добавлен";
    }
    else
    {
        $result =  "Ошибка добавления в БД";
    }
}
else
{
    $result =  "Все поля должны быть заполненны";
}

echo json_encode($result);
?>