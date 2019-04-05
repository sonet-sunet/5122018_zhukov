-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Мар 20 2019 г., 10:01
-- Версия сервера: 10.1.37-MariaDB
-- Версия PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `05122018_3project`
--
CREATE DATABASE IF NOT EXISTS `05122018_3project` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `05122018_3project`;

-- --------------------------------------------------------

--
-- Структура таблицы `catalogs`
--

CREATE TABLE IF NOT EXISTS `catalogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `catalogs`
--

INSERT INTO `catalogs` (`id`, `name`) VALUES
(1, 'Мужское'),
(2, 'Женское'),
(3, 'Детям');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_src` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `sku` varchar(10) NOT NULL,
  `price` float NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `img_src`, `name`, `sku`, `price`, `description`) VALUES
(1, '', 'Товар 1', '111111', 1000, 'Товар 1'),
(2, '', 'Товар 2', '2222222', 2000, 'Товар 2'),
(3, '', 'Товар 3', '3333333', 3000, 'Товар 3'),
(4, '', 'Товар 4', '444444', 4000, 'Товар 4'),
(5, '', 'Товар 5', '5000', 5000, 'Товар 5'),
(6, '', 'Товар 6', '66666', 6000, 'Товар 6');

-- --------------------------------------------------------

--
-- Структура таблицы `product_catalog`
--

CREATE TABLE IF NOT EXISTS `product_catalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `catalog_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_catalog`
--

INSERT INTO `product_catalog` (`id`, `product_id`, `catalog_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
