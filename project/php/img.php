<?php 
session_start();
try{
    include('config.php');

    $sql = 'SELECT * FROM books WHERE user_id = :id and id = :self_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id'=> $_SESSION['id'], 'self_id' => $_GET['id']]);
    $result = $stmt->fetch();

    $img = imagecreatefromjpeg($result[6]);

    $width = 200;  // Новая ширина
    $height =  (int)(imagesy($img) * 200 / imagesx($img));  // Новая высота

    $tmp = imagecreatetruecolor($width, $height); 


    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $width, $height, imagesx($img), imagesy($img));  // Масштабируем изображение
    header('Content-Type: image/jpeg');
    echo imagejpeg($tmp);  
    imagedestroy($tmp); 
    imagedestroy($img);
    exit();
}catch (PDOException $e){
    echo 'Ошибка '.$e->getMessage();
}
?>