-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 27 2020 г., 10:42
-- Версия сервера: 8.0.20
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `l8`
--

-- --------------------------------------------------------

--
-- Структура таблицы `connection`
--

CREATE TABLE `connection` (
  `addr` varchar(45) NOT NULL,
  `count` int UNSIGNED NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `proxy` tinyint(1) NOT NULL DEFAULT '0',
  `forwarded` varchar(45) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `connection`
--

INSERT INTO `connection` (`addr`, `count`, `created`, `proxy`, `forwarded`) VALUES
('127.0.0.1', 52, '2020-05-27 07:39:56', 0, ''),
('192.168.1.14', 58, '2020-05-20 03:57:06', 0, ''),
('192.168.1.179', 63, '2020-05-19 23:11:33', 0, '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `connection`
--
ALTER TABLE `connection`
  ADD PRIMARY KEY (`addr`,`forwarded`,`proxy`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
