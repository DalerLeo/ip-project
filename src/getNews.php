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
        $news = $stmt->fetchAll();
        $results = array();

        foreach ($news as $value) {
         $result = array(
            'title' => $value['title'],
            'content' => $value['content'],
            'id' => $value['id']);
         $results[] = $result;
        }

        echo json_encode($results);
    }
    catch (PDOException $except) {
        echo  $except->getMessage();
    }
    $connect = null;




/*
$stmt = $connect->prepare("SELECT *FROM News WHERE userName = $user");
$stmt->execute();*/
?>