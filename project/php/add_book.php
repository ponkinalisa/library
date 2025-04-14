<?php 
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (!empty($_POST)){
        include('config.php');

        $title = trim($_POST['title']);
        $author = trim($_POST['author']);
        $genre = trim($_POST['genre']);
        $year = trim($_POST['year']);
        $page = trim($_POST['page']);
        $description = trim($_POST['description']);
        $path = '';
        if (isset($_FILES['cover'])){
            $file = $_FILES['cover'];
            $sql = 'SELECT email FROM users WHERE id = :id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id'=> $_SESSION['id']]);
            $email = $stmt->fetch(PDO::FETCH_ASSOC)['email'];
            $file_name_sep = mb_split("\.", $file['name']);
        
            $new_file_name = random_int(1, 10000000000);
            $ext = $file_name_sep[count($file_name_sep)-1];
            $path = '../user_img/'.$email.'/'.$new_file_name.'.'.$ext;
            $directory = "../user_img/$email";
            if (!file_exists($directory)) {
                mkdir($directory);  
            }
            move_uploaded_file($file['tmp_name'], "./".$path);
        }
        try{
            $sql = 'INSERT INTO books(user_id, name, author, count_pages, year, path_to_img, description, genre) VALUES(:user_id, :name, :author, :count_pages, :year, :path_to_img, :description, :genre)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id'=> $_SESSION['id'], 'name'=>$title, 'author'=>$author, 'count_pages'=>$page, 'year'=>$year, 'description' => $description, 'path_to_img'=>$path, 'genre'=>$genre]);
            $stmt->fetch();
            header('Location: ../pages/main_page.php');

        } catch (PDOException $e) {
            echo 'Ошибка подключения: ' . $e->getCode() . ' - ' . $e->getMessage();
        }
    }
}
?>