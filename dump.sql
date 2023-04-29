-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: mysql
-- Время создания: Мар 04 2023 г., 14:27
-- Версия сервера: 8.0.21
-- Версия PHP: 8.1.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `products_crud`
--

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
                            `id` int NOT NULL,
                            `name` varchar(255) NOT NULL,
                            `sku` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `sku_settings`
--

CREATE TABLE `sku_settings` (
                                `prefix` varchar(255) NOT NULL,
                                `index` int UNSIGNED NOT NULL,
                                `suffix` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
                         `login` varchar(255) NOT NULL,
                         `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `name` (`name`),
    ADD UNIQUE KEY `sku` (`sku`);


--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
    ADD UNIQUE KEY `login` (`login`);


--
-- Индексы таблицы `sku_settings`
--
ALTER TABLE `sku_settings`
    ADD CONSTRAINT sku_settings_unique
        UNIQUE (prefix, `index`, suffix);

ALTER TABLE `sku_settings`
    ADD CONSTRAINT sku_settings_prefix_suffix_unique
        UNIQUE (prefix, suffix);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

# admin user with password `secret`
INSERT INTO `users` (login, password)
values ('admin', '$2y$10$7MBUoFwk4DbCzg99S1iWcO2X4mWVGx4HEYslKJidCNd7xfBa5e1CW')


