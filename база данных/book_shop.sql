-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 02 2020 г., 13:51
-- Версия сервера: 8.0.15
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `book_shop`
--

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`axeman`@`localhost` PROCEDURE `nds` (IN `book` TINYTEXT, IN `nds` INT, OUT `num` FLOAT)  BEGIN
	SELECT ROUND(`books`.`B_PRICE` * (nds / 100)) INTO num FROM `books` WHERE `books`.`B_TITLE` = book;
END$$

--
-- Функции
--
CREATE DEFINER=`axeman`@`localhost` FUNCTION `name` (`val` VARCHAR(50)) RETURNS VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci BEGIN
DECLARE name VARCHAR(50);
SELECT `A_FIO` INTO name FROM `authors` WHERE `authors`.`A_ID` = (SELECT `books`.`B_AUTHORS` FROM `books` WHERE `books`.`B_TITLE` = val);
RETURN name;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `access`
--

CREATE TABLE `access` (
  `A_ID_USER` int(3) NOT NULL,
  `A_LOGIN` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `A_PASSWORD` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `A_ACCESS` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `access`
--

INSERT INTO `access` (`A_ID_USER`, `A_LOGIN`, `A_PASSWORD`, `A_ACCESS`) VALUES
(1, 'admin', '12345', 'admin'),
(2, 'user', '12345', 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `authors`
--

CREATE TABLE `authors` (
  `A_ID` int(15) NOT NULL COMMENT 'Код автора',
  `A_FIO` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ФИО Автора',
  `A_BORN` date NOT NULL COMMENT 'Дата рождения'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `authors`
--

INSERT INTO `authors` (`A_ID`, `A_FIO`, `A_BORN`) VALUES
(29, 'Дж. Роулинг', '1965-07-31'),
(30, 'П. Коэльо', '1947-08-24'),
(31, 'Ж. Верн', '1828-02-08'),
(32, 'Н.В. Гоголь', '1809-03-31'),
(33, 'А.С. Пушкин', '1799-06-06'),
(34, 'М.Ю. Лермонтов', '1814-10-15'),
(35, 'М.А. Булгаков', '1891-05-15');

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `B_ID` int(20) NOT NULL COMMENT 'Код книги',
  `B_TITLE` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Название книги',
  `B_DATE` date NOT NULL COMMENT 'Дата издания',
  `B_AUTHORS` int(15) NOT NULL COMMENT 'ВК к Authors',
  `B_GENRES` int(15) NOT NULL COMMENT 'ВК к Genres',
  `B_PRICE` int(10) NOT NULL COMMENT 'Цена Книги',
  `B_NUMBERS` int(10) NOT NULL COMMENT 'Количество книг'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`B_ID`, `B_TITLE`, `B_DATE`, `B_AUTHORS`, `B_GENRES`, `B_PRICE`, `B_NUMBERS`) VALUES
(31, 'Гарри Поттер и Кубок Огня', '2009-07-12', 29, 1, 1000, 50),
(32, 'Алхимик', '1999-12-23', 30, 2, 700, 100),
(33, 'Дневник мага', '2001-11-22', 30, 2, 1000, 150),
(34, 'Таинственный остров', '2002-10-30', 31, 3, 500, 50),
(35, 'Гарри Поттер и Тайная комната', '1998-08-22', 29, 1, 1000, 100),
(36, 'Вий', '2008-05-17', 32, 2, 900, 30),
(37, 'Евгений Онегин', '2001-01-01', 33, 5, 500, 15),
(38, 'Капитанская дочка', '2002-02-02', 33, 2, 600, 100),
(39, 'Ранние повествования', '2003-03-03', 34, 6, 700, 20),
(40, 'Мастер и Маргарита', '2004-04-04', 35, 2, 800, 30);

--
-- Триггеры `books`
--
DELIMITER $$
CREATE TRIGGER `delete_book` AFTER DELETE ON `books` FOR EACH ROW BEGIN
	DELETE FROM `logs_table_book` WHERE `logs_table_book`.`LOG_BOOK` = OLD.`B_ID`;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_book` AFTER INSERT ON `books` FOR EACH ROW BEGIN
	INSERT INTO `logs_table_book`(`LOG_BOOK`, `LOG_NUMBERS`, `LOG_DATE`) VALUES(NEW.`B_ID`, NEW.`B_NUMBERS`, NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `employers`
--

CREATE TABLE `employers` (
  `E_ID` int(15) NOT NULL COMMENT 'Код сотрудника',
  `E_FIO` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ФИО сотрудника',
  `E_BORN` date NOT NULL COMMENT 'Дата рождения',
  `E_RDATE` date NOT NULL COMMENT 'Дата принятия на работу',
  `E_POST` int(90) NOT NULL COMMENT 'ВК к POST',
  `E_TEL` bigint(12) NOT NULL COMMENT 'Телефон'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `employers`
--

INSERT INTO `employers` (`E_ID`, `E_FIO`, `E_BORN`, `E_RDATE`, `E_POST`, `E_TEL`) VALUES
(1, 'Сотников Р.Я.', '2000-10-23', '2018-01-01', 1, 905175223532),
(2, 'Филичев В.Н.', '2000-03-11', '2018-12-31', 2, 222000111000),
(3, 'Иванов И.И.', '2002-03-11', '2020-10-21', 3, 222888111333),
(4, 'Петров П.П.', '1999-03-11', '2020-10-01', 4, 222111111000),
(5, 'Сидоров С.С.', '2001-03-11', '2020-11-30', 4, 222999111980);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `favorite_books`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `favorite_books` (
`Жанр` varchar(20)
,`Название книги` varchar(45)
,`ФИО автора` varchar(45)
,`ФИО клиента` varchar(40)
);

-- --------------------------------------------------------

--
-- Структура таблицы `genres`
--

CREATE TABLE `genres` (
  `G_ID` int(15) NOT NULL COMMENT 'Код жанра',
  `G_NAME` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Название жанра'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `genres`
--

INSERT INTO `genres` (`G_ID`, `G_NAME`) VALUES
(1, 'Фэнтези'),
(2, 'Повесть'),
(3, 'Приключения'),
(4, 'Комикс'),
(5, 'Стихи'),
(6, 'Комедия');

-- --------------------------------------------------------

--
-- Структура таблицы `list of post`
--

CREATE TABLE `list of post` (
  `LP_ID` int(90) NOT NULL COMMENT 'Код должности',
  `LP_POST` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Название должности',
  `LP_WAGE` int(10) NOT NULL COMMENT 'Заработная плата'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `list of post`
--

INSERT INTO `list of post` (`LP_ID`, `LP_POST`, `LP_WAGE`) VALUES
(1, 'Директор', 15000),
(2, 'Менеджер', 10000),
(3, 'Тех. персонал', 6000),
(4, 'Кассир', 6500);

-- --------------------------------------------------------

--
-- Структура таблицы `logs_table_book`
--

CREATE TABLE `logs_table_book` (
  `LOG_ID` int(11) NOT NULL COMMENT 'ID лога',
  `LOG_BOOK` int(11) NOT NULL COMMENT 'ID книги',
  `LOG_NUMBERS` int(11) NOT NULL COMMENT 'Количество',
  `LOG_DATE` date NOT NULL COMMENT 'Дата добавления'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `logs_table_book`
--

INSERT INTO `logs_table_book` (`LOG_ID`, `LOG_BOOK`, `LOG_NUMBERS`, `LOG_DATE`) VALUES
(1, 31, 50, '2020-05-14'),
(2, 32, 100, '2020-05-14'),
(3, 33, 150, '2020-05-14'),
(4, 34, 50, '2020-05-14'),
(5, 35, 100, '2020-05-14'),
(6, 36, 30, '2020-05-14'),
(7, 37, 15, '2020-05-14'),
(8, 38, 100, '2020-05-14'),
(9, 39, 20, '2020-05-14'),
(10, 40, 30, '2020-05-14');

-- --------------------------------------------------------

--
-- Структура таблицы `purchases`
--

CREATE TABLE `purchases` (
  `P_ID` int(15) NOT NULL COMMENT 'Код покупки',
  `P_CLIENT` int(15) NOT NULL COMMENT 'ВК к REGULAR CLIENTS',
  `P_EMPLOY` int(15) NOT NULL COMMENT 'ВК к EMPLOYERS',
  `P_BOOKS` int(15) NOT NULL COMMENT 'ВК к BOOKS',
  `P_NUMBERS` int(10) NOT NULL COMMENT 'Количество купленных книг'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `purchases`
--

INSERT INTO `purchases` (`P_ID`, `P_CLIENT`, `P_EMPLOY`, `P_BOOKS`, `P_NUMBERS`) VALUES
(1, 3, 4, 32, 2),
(2, 1, 4, 40, 1),
(3, 2, 5, 36, 1),
(8, 4, 5, 40, 2),
(10, 1, 4, 34, 1);

--
-- Триггеры `purchases`
--
DELIMITER $$
CREATE TRIGGER `change_numbers_book_delete` AFTER DELETE ON `purchases` FOR EACH ROW BEGIN
SET @ID_BOOKS = (SELECT `logs_table_book`.`LOG_BOOK` FROM `logs_table_book` WHERE `logs_table_book`.`LOG_BOOK` = OLD.P_BOOKS);

SET @NUMBERS_BOOKS = (SELECT `logs_table_book`.`LOG_NUMBERS` FROM `logs_table_book` WHERE `logs_table_book`.`LOG_BOOK` = OLD.P_BOOKS);

UPDATE `books` SET `books`.`B_NUMBERS` = @NUMBERS_BOOKS WHERE `books`.`B_ID` = @ID_BOOKS;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `change_numbers_book_insert` AFTER INSERT ON `purchases` FOR EACH ROW BEGIN
    SET
        @NUM = NEW.`P_NUMBERS`;
    SET
        @BOOK = NEW.`P_BOOKS`;
    UPDATE
        `books`
    SET
        `books`.`B_NUMBERS` = `books`.`B_NUMBERS` - @NUM
    WHERE
        `books`.`B_ID` = @BOOK;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `change_numbers_book_update` AFTER UPDATE ON `purchases` FOR EACH ROW BEGIN
SET @ID_BOOKS = (SELECT `logs_table_book`.`LOG_BOOK` FROM `logs_table_book` WHERE `logs_table_book`.`LOG_BOOK` = NEW.P_BOOKS);

SET @NUMBERS_BOOKS = (SELECT `logs_table_book`.`LOG_NUMBERS` FROM `logs_table_book` WHERE `logs_table_book`.`LOG_BOOK` = NEW.P_BOOKS);

UPDATE `books` SET `books`.`B_NUMBERS` = @NUMBERS_BOOKS WHERE `books`.`B_ID` = @ID_BOOKS;

SET @NUM = NEW.`P_NUMBERS`;
SET @BOOK = NEW.`P_BOOKS`;

UPDATE `books` SET `books`.`B_NUMBERS` = `books`.`B_NUMBERS` - @NUM WHERE `books`.`B_ID` = @BOOK;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `regular clients`
--

CREATE TABLE `regular clients` (
  `RC_ID` int(15) NOT NULL COMMENT 'Код клиента',
  `RC_FIO` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ФИО клиента',
  `RC_TEL` bigint(12) NOT NULL COMMENT 'Телефон'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `regular clients`
--

INSERT INTO `regular clients` (`RC_ID`, `RC_FIO`, `RC_TEL`) VALUES
(1, 'Третьякова Е.А.', 899999999999),
(2, 'Новосельцова Е.Я.', 234567890123),
(3, 'Водянин В.Н.', 123456789010),
(4, 'Подшивайло В.Т.', 90909900909009),
(5, 'Минченко Е.Б.', 1010101010101);

-- --------------------------------------------------------

--
-- Структура для представления `favorite_books`
--
DROP TABLE IF EXISTS `favorite_books`;

CREATE ALGORITHM=UNDEFINED DEFINER=`axeman`@`localhost` SQL SECURITY DEFINER VIEW `favorite_books`  AS  select `regular clients`.`RC_FIO` AS `ФИО клиента`,`books`.`B_TITLE` AS `Название книги`,`authors`.`A_FIO` AS `ФИО автора`,`genres`.`G_NAME` AS `Жанр` from ((((`purchases` join `regular clients` on((`purchases`.`P_CLIENT` = `regular clients`.`RC_ID`))) join `books` on((`purchases`.`P_BOOKS` = `books`.`B_ID`))) join `authors` on((`books`.`B_AUTHORS` = `authors`.`A_ID`))) join `genres` on((`books`.`B_GENRES` = `genres`.`G_ID`))) order by `regular clients`.`RC_FIO` ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`A_ID_USER`);

--
-- Индексы таблицы `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`A_ID`);

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`B_ID`),
  ADD KEY `B_AUTHORS` (`B_AUTHORS`),
  ADD KEY `B_GENRES` (`B_GENRES`);

--
-- Индексы таблицы `employers`
--
ALTER TABLE `employers`
  ADD PRIMARY KEY (`E_ID`),
  ADD KEY `E_POST` (`E_POST`);

--
-- Индексы таблицы `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`G_ID`);

--
-- Индексы таблицы `list of post`
--
ALTER TABLE `list of post`
  ADD PRIMARY KEY (`LP_ID`);

--
-- Индексы таблицы `logs_table_book`
--
ALTER TABLE `logs_table_book`
  ADD PRIMARY KEY (`LOG_ID`);

--
-- Индексы таблицы `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`P_ID`),
  ADD KEY `P_CLIENT` (`P_CLIENT`),
  ADD KEY `P_EMPLOY` (`P_EMPLOY`),
  ADD KEY `P_BOOKS` (`P_BOOKS`);

--
-- Индексы таблицы `regular clients`
--
ALTER TABLE `regular clients`
  ADD PRIMARY KEY (`RC_ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `access`
--
ALTER TABLE `access`
  MODIFY `A_ID_USER` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `authors`
--
ALTER TABLE `authors`
  MODIFY `A_ID` int(15) NOT NULL AUTO_INCREMENT COMMENT 'Код автора', AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `B_ID` int(20) NOT NULL AUTO_INCREMENT COMMENT 'Код книги', AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT для таблицы `employers`
--
ALTER TABLE `employers`
  MODIFY `E_ID` int(15) NOT NULL AUTO_INCREMENT COMMENT 'Код сотрудника', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `genres`
--
ALTER TABLE `genres`
  MODIFY `G_ID` int(15) NOT NULL AUTO_INCREMENT COMMENT 'Код жанра', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `list of post`
--
ALTER TABLE `list of post`
  MODIFY `LP_ID` int(90) NOT NULL AUTO_INCREMENT COMMENT 'Код должности', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `logs_table_book`
--
ALTER TABLE `logs_table_book`
  MODIFY `LOG_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID лога', AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `purchases`
--
ALTER TABLE `purchases`
  MODIFY `P_ID` int(15) NOT NULL AUTO_INCREMENT COMMENT 'Код покупки', AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `regular clients`
--
ALTER TABLE `regular clients`
  MODIFY `RC_ID` int(15) NOT NULL AUTO_INCREMENT COMMENT 'Код клиента', AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`B_AUTHORS`) REFERENCES `authors` (`A_ID`),
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`B_GENRES`) REFERENCES `genres` (`G_ID`);

--
-- Ограничения внешнего ключа таблицы `employers`
--
ALTER TABLE `employers`
  ADD CONSTRAINT `employers_ibfk_1` FOREIGN KEY (`E_POST`) REFERENCES `list of post` (`LP_ID`);

--
-- Ограничения внешнего ключа таблицы `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`P_EMPLOY`) REFERENCES `employers` (`E_ID`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`P_BOOKS`) REFERENCES `books` (`B_ID`),
  ADD CONSTRAINT `purchases_ibfk_3` FOREIGN KEY (`P_CLIENT`) REFERENCES `regular clients` (`RC_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
