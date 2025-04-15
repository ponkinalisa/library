-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Апр 15 2025 г., 15:12
-- Версия сервера: 5.7.24
-- Версия PHP: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `library`
--

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `author` text NOT NULL,
  `count_pages` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `path_to_img` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `genre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id`, `user_id`, `name`, `author`, `count_pages`, `year`, `path_to_img`, `description`, `genre`) VALUES
(6, 3, 'Altai State University', 'ponkina', 34, 2025, '../user_img/pupa@gmail.com/9692315915.jpg', 'dassadsa', 'fiction'),
(7, 3, 'Тест по дисциплине', 'тургенев', 212, 2021, '../user_img/pupa@gmail.com/5342694686.jpg', 'ASSDASAD', 'fiction'),
(11, 4, 'Altai State University', 'ponkina', 1, 2002, '../user_img/pupa1@gmail.com/1554900295.jpg', 'asassad', 'fiction'),
(12, 4, 'ewwe', '212', 0, 1999, '../user_img/pupa1@gmail.com/5263745372.jpg', 'ADASDSDA', 'fiction'),
(13, 4, 'Заведующая кафедрой', 'ponkina', 0, 2023, '../user_img/pupa1@gmail.com/5546183303.jpeg', 'gddgds', 'fiction'),
(14, 4, 'Sarsen Amangolov East-Kazakhstan University', 'zz', 0, 2023, '../user_img/pupa1@gmail.com/2142551125.jpg', 'sdaaa', 'fiction'),
(15, 4, '2225004738', 'ponkina', 10, 2012, '../user_img/pupa1@gmail.com/5041602779.jpg', 'sds', 'fiction'),
(16, 4, 'Altai State University3333', 'errrrrrrrrrrr', 0, 2013, '../user_img/pupa1@gmail.com/5517677400.jpg', 'sss', 'fiction');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'vova.pupkin@yandex.ru', '$2y$10$cxXLVq4MOuSqtb5/DN4a.OGO.zE3thaZcR2i2yWBt7OPE4uKCXhxG'),
(2, 'elisaveta.ponkina@yandex.ru', '$2y$10$GUeMMvbrjVs31Yr0XYKdouSjD5bkbOpY3usqxaSA7SVmFUEcecDOq'),
(3, 'pupa@gmail.com', '$2y$10$KzZMcp4Zq3PfxRc9NCXVVOsrQntP6NW4QEpdC9PvRsBSzwM1hrVUa'),
(4, 'pupa1@gmail.com', '$2y$10$CK2aWpFgmj/jcrfSvVs9AOkbxSbVwBZXF0BCOSty96YurbLf7mKZu'),
(5, 'pupa123@gmail.com', '$2y$10$0U.34RX4JXXdpo4NzCse3utpw8J9YStvfMpPOpWGs55KKZwmo7qaG');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
