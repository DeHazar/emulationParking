-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 08 2020 г., 12:23
-- Версия сервера: 8.0.19
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `parking`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cars`
--

CREATE TABLE `cars` (
  `id` int NOT NULL,
  `carNumber` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text,
  `transactionId` int NOT NULL,
  `parkingId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `carNumber`, `description`, `transactionId`, `parkingId`) VALUES
(20, 'AU13OI102', 'lo123123', 37, 1),
(21, 'AU13OI102', 'lo123123', 38, 1),
(22, 'AU13OI102', 'lo123123', 39, 1),
(23, 'AU13OI102', 'lo123123', 40, 1),
(25, 'AU13OI102', 'lo123123', 43, 1),
(28, 'AU13OI102', 'lo123123', 44, 1),
(29, 'AU13OI102', 'lo123123', 46, 1),
(30, 'test', 'lo123123', 47, 1),
(31, 'test', 'lo123123', 48, 1),
(32, 'test', '', 49, 1),
(33, 'test', '', 50, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `skuds`
--

CREATE TABLE `skuds` (
  `id` int NOT NULL,
  `emptyPlaces` int NOT NULL,
  `priceForMinute` int NOT NULL,
  `address` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `skuds`
--

INSERT INTO `skuds` (`id`, `emptyPlaces`, `priceForMinute`, `address`) VALUES
(1, 190, 10, 'Московская парковка'),
(2, 300, 2, 'Уфимский паркинг');

-- --------------------------------------------------------

--
-- Структура таблицы `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `transactionStartTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transactionPaidTime` timestamp NULL DEFAULT NULL,
  `total` double DEFAULT NULL,
  `isPaid` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `transactions`
--

INSERT INTO `transactions` (`id`, `transactionStartTime`, `transactionPaidTime`, `total`, `isPaid`) VALUES
(1, '2020-04-28 17:03:08', NULL, 0, 0),
(2, '2020-04-28 17:04:02', NULL, 0, 0),
(28, '2020-04-28 17:18:51', NULL, 0, 0),
(29, '2020-04-28 17:19:54', NULL, 0, 0),
(30, '2020-04-28 17:31:16', NULL, 0, 0),
(31, '2020-04-28 17:31:19', NULL, 0, 0),
(32, '2020-04-28 17:31:21', NULL, 0, 0),
(33, '2020-04-28 17:31:21', NULL, 0, 0),
(34, '2020-04-28 17:31:22', NULL, 0, 0),
(35, '2020-04-28 17:31:24', NULL, 0, 0),
(36, '2020-04-28 17:31:28', NULL, 0, 0),
(37, '2020-04-28 18:20:55', NULL, 0, 0),
(38, '2020-04-28 18:21:46', NULL, 0, 0),
(39, '2020-04-28 18:22:39', NULL, 0, 0),
(40, '2020-04-28 18:24:00', NULL, 0, 0),
(41, '2020-04-28 18:24:26', NULL, 0, 0),
(42, '2020-04-28 18:25:43', NULL, 0, 0),
(43, '2020-04-28 19:07:16', '2020-04-28 14:12:48', 0, 0),
(44, '2020-04-28 12:17:10', '2020-05-06 12:59:06', 115619.33333333, 0),
(45, '2020-04-28 14:21:11', NULL, 0, 0),
(46, '2020-05-06 12:58:57', NULL, 0, 0),
(47, '2020-05-08 05:51:18', '2020-05-08 07:17:33', 862.5, 1),
(48, '2020-05-08 05:51:19', '2020-05-08 07:18:37', 873, 1),
(49, '2020-05-08 05:51:23', '2020-05-08 07:21:38', 902.5, 1),
(50, '2020-05-08 05:51:23', NULL, 0, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction` (`transactionId`),
  ADD KEY `parkingId` (`parkingId`);

--
-- Индексы таблицы `skuds`
--
ALTER TABLE `skuds`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `skuds`
--
ALTER TABLE `skuds`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`transactionId`) REFERENCES `transactions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `cars_ibfk_2` FOREIGN KEY (`parkingId`) REFERENCES `skuds` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
