<?php
header("ContentType: application/json");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Records";

    try {
        $connect = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $connect->prepare("SELECT *FROM News");
        $stmt->execute();
        $news_row = $stmt->fetchAll();
        $results = array();

        foreach ($news_row as $news) {
         $result = array(
            'title' => $news['title'],
            'content' => $news['content'],
            'id' => $news['id']);
         $results[] = $result;
        }

        echo json_encode($news_row);
    }
    catch (PDOException $except) {
        echo  $except->getMessage();
    }
    $connect = null;




/*
$stmt = $connect->prepare("SELECT *FROM News WHERE userName = $user");
$stmt->execute();*/
?>