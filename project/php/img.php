<?php 
session_start();
try{
    include('config.php');

    $sql = 'SELECT * FROM books WHERE user_id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id'=> $_SESSION['id']]);
    $result = $stmt->fetchAll();
    $count = $_SESSION['book'];
    if ($count >= count($result)){
        $count = 0;
    }else if ($count < 0){
        $count = count($result) - 1;
    }
    $_SESSION['book'] = $count;
    if (count($result) > 0){
        $current = $result[$count];
    }

    $img = imagecreatefromjpeg($current[6]);

    $width = 300;  // Новая ширина
    $height =  (int)(imagesy($img) * 300 / imagesx($img));  // Новая высота

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