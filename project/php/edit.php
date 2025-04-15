<?php 
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (!empty($_POST) and isset($_SESSION['book_current_id'])){
        include('config.php');

        $title = trim($_POST['title']);
        $author = trim($_POST['author']);
        $genre = trim($_POST['genre']);
        $year = trim($_POST['year']);
        $page = trim($_POST['page']);
        $description = trim($_POST['description']);
        $sql = 'SELECT path_to_img FROM books WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id'=> $_SESSION['book_current_id']]);
        $path = $stmt->fetch(PDO::FETCH_ASSOC)['path_to_img'];
        if (isset($_FILES['cover']) and is_uploaded_file($_FILES['cover']['tmp_name'])){
            unlink($path);
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
            $sql = 'UPDATE books SET name = :name, author = :author, count_pages = :count_pages, year = :year, path_to_img = :path_to_img, description = :description, genre = :genre WHERE user_id = :user_id AND id = :id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $_SESSION['book_current_id'], 'user_id'=> $_SESSION['id'], 'name'=>$title, 'author'=>$author, 'count_pages'=>$page, 'year'=>$year, 'description' => $description, 'path_to_img'=>$path, 'genre' =>$genre]);
            $stmt->fetch();
            header('Location: ../pages/main_page.php');
        } catch (PDOException $e) {
            echo 'Ошибка подключения: ' . $e->getCode() . ' - ' . $e->getMessage();
        }
    }else{
        header('Location: ../pages/main_page.php');
    }
}
?>