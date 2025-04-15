<?php 
session_start();
if (!isset($_SESSION['id'])){
    header('Location: registr.php');
}
else{
    include('../php/config.php');

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
        $_SESSION['book_current_id'] = $current[0];
        $width = getimagesize($current[6])[0];
        $height = getimagesize($current[6])[1];
    }
    if (!isset($width)){
        $width = 200;
        $height =  200;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личная библиотека</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Подключение стилей -->
    <style> 
#a{
    text-decoration: none;
    z-index: 5;
    color: white;
    font-size: 20px;
}
#logout{
    position: absolute;
    top: 0;
    right: 0;
}
</style>
</head>
<body>
   <button id="logout" onclick="logout()">Выйти</button>
    <!-- Главная страница (список книг) -->
    <div id="main-content">
        <div id="book-list" class="section">
            <h2>Список книг</h2>
            <table>
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Автор</th>
                        <th>Год издания</th>
                        <th>Жанр</th>
                        <th>Обложка</th>
                        <th>Номер страницы</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Книги будут отображаться здесь через серверный рендеринг -->
                    <tr>
                        <?php 
                        if (isset($current)){
                            echo('<td>'.$current[2].'</td>');
                            echo('<td>'.$current[3].'</td>');
                            echo('<td>'.$current[5].'</td>');
                            if ($current[8] == 'fiction'){
                                echo('<td>Фантастика</td>');
                            }else if ($current[8] == 'non-fiction'){
                                echo('<td>Нон-фикшн</td>');
                            }else if ($current[8] == 'mystery'){
                                echo('<td>Детектив</td>');
                            }else{
                                echo('<td>Неизвестный жанр</td>');
                            }
                            $height1 = $height;
                            $width1 = $width;
                            if ($width1 > 70){
                                $height1 = (int)($height1 / ($width1 / 70));
                                $width1 = 70;
                            }
                            else if ($height1 > 70){
                                $width1 = (int)($width1 / ($height1 / 70));
                                $height1 = 70;
                            }
                            echo('<td><img src="../php/img1.php" alt="Обложка книги"></td>');
                            echo('<td>'.$current[4].'</td>');
                        }else{
                        echo('<td>Название книги</td>');
                        echo('<td>Автор</td>');
                        echo('<td>Год</td>');
                        echo('<td>Жанр</td>');
                        echo('<td><img src="bookfoto.jpg" alt="Обложка книги" width="50"></td>');
                        echo('<td>45</td>');
                        }
                        ?>
                        <td>
                            <a href="#" onclick="see_book1()">Просмотреть</a>
                            <a href="#" onclick="edit_book1()">Редактировать</a>
                            <a href="../php/delete_book.php" onclick="return confirm('Удалить книгу?')">Удалить</a>
                        </td>
                    </tr>
                    <!-- Пагинация -->
                    <tr>
                        <td colspan="7">
                        <a href='../php/previous.php' id='a'><button>Предыдущая</button></a>
                        <a href='../php/next_page.php' id='a'><button>Следующая</button></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <a href="#" onclick="add_book1()">Добавить книгу</a>
        </div>

        <!-- Форма добавления книги -->
        <div id="book-form" class="section" style="display: none;">
            <h2>Добавить книгу</h2>
            <form action="../php/add_book.php" method="POST" enctype="multipart/form-data">
                <label for="title">Название книги:</label>
                <input type="text" id="title" name="title" required maxlength="100">

                <label for="author">Автор:</label>
                <input type="text" id="author" name="author" required maxlength="100">

                <label for="genre">Жанр:</label>
                <select id="genre" name="genre" required>
                    <option value="fiction">Фантастика</option>
                    <option value="non-fiction">Нон-фикшн</option>
                    <option value="mystery">Детектив</option>
                    <!-- Другие жанры -->
                </select>

                <label for="year">Год издания:</label>
                <input type="number" id="year" name="year" required min="1800" max="2025">

                <label for="description">Описание:</label>
                <textarea id="description" name="description" maxlength="500"></textarea>

                <label for="cover">Обложка книги (jpg, до 3 МБ):</label>
                <input type="file" id="cover" name="cover" accept="image/jpeg">

                <label for="page-number">Номер страницы:</label>
                <input type="number" id="page-number" name="page" min="0" value="0" required>

                <button type="submit">Сохранить</button>
            </form>
        </div>

         <!-- Форма редактирования книги -->
         <div id="book-form" class="section edit" style="display: none;">
            <h2>Редактировать книгу</h2>
            <form action="../php/edit.php" method="POST" enctype="multipart/form-data">
                <label for="title">Название книги:</label>
                <input type="text" id="title" name="title" required maxlength="100" value="<?php if (isset($current)){echo($current[2]);}?>">

                <label for="author">Автор:</label>
                <input type="text" id="author" name="author" required maxlength="100" value="<?php if (isset($current)){echo($current[3]);}?>">

                <label for="genre">Жанр:</label>
                <select id="genre" name="genre" required>
                    <option value="fiction" <?php if (isset($current) and $current[8] == 'fiction'){echo('selected');}?>>Фантастика</option>
                    <option value="non-fiction" <?php if (isset($current) and $current[8] == 'non-fiction'){echo('selected');}?>>Нон-фикшн</option>
                    <option value="mystery" <?php if (isset($current) and $current[8] == 'mystery'){echo('selected');}?>>Детектив</option>
                    <!-- Другие жанры -->
                </select>

                <label for="year">Год издания:</label>
                <input type="number" id="year" name="year" required min="1800" max="2025" value="<?php if (isset($current)){echo($current[5]);}?>">

                <label for="description">Описание:</label>
                <textarea id="description" name="description" maxlength="500"><?php if (isset($current)){echo($current[7]);}?></textarea>

                <label for="cover">Обложка книги (jpg, до 3 МБ):</label>
                <input type="file" id="cover" name="cover" accept="image/jpeg">

                <label for="page-number">Номер страницы:</label>
                <input type="number" id="page-number" name="page" min="1" required value="<?php if (isset($current)){echo($current[4]);}?>">

                <button type="submit">Сохранить</button>
            </form>
        </div>

        <!-- Просмотр книги -->
        <div id="book-view" class="section" style="display: none;">
            <h2>Просмотр книги</h2>
            <?php 
            if (isset($current)){
                echo('<h3>'.$current[2].'</h3>');
                echo('<p>Автор: '.$current[3].'</p>');
                echo('<p> Год издания: '.$current[5].'</p>');
                if ($current[8] == 'fiction'){
                    echo('<p>Жанр: Фантастика</p>');
                }else if ($current[8] == 'non-fiction'){
                    echo('<p>Жанр: Нон-фикшн</p>');
                }else if ($current[8] == 'mystery'){
                    echo('<p>Жанр: Детектив</p>');
                }
                echo('<p>Описание книги: '.$current[7].'</p>');
                echo('<p><img src="../php/img.php" alt="Обложка книги"></p>');
                echo('<p>Номер страницы: <span id="current-page">'.$current[4].'</span></p>');
            }else{
                echo('<h3>Название книги</h3>');
                echo('<p>Автор: Автор книги</p>');
                echo('<p>Год издания: Год</p>');
                echo('<p>Жанр: Жанр</p>');
                echo('<p>Описание книги...</p>');
                echo('<p><img src="bookfoto.jpg" alt="Обложка книги" width="100"></p>');
                echo('<p>Номер страницы: <span id="current-page">45</span></p>');
            }
            ?>
            <a href='#' onclick="edit_book1()">Редактировать</a> |
            <a href="../php/delete_book.php" onclick="return confirm('Удалить книгу?')">Удалить</a>
        </div>
    </div>
    <script>
        const see_book = document.getElementById('book-view');
        const add_book = document.getElementById('book-form');
        const edit_book = document.getElementsByClassName('edit')[0];

        function add_book1(){
            see_book.style.display = 'none';
            edit_book.style.display = 'none';
            add_book.style.display = 'block';
        }

        function edit_book1(){
            see_book.style.display = 'none';
            edit_book.style.display = 'block';
            add_book.style.display = 'none';
        }

        function see_book1(){
            see_book.style.display = 'block';
            edit_book.style.display = 'none';
            add_book.style.display = 'none';
        }

        function logout(){
            window.location.href = '../php/logout.php';
        }
    </script>

</body>
</html>
