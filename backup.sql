-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Апр 18 2019 г., 21:06
-- Версия сервера: 5.7.23
-- Версия PHP: 7.1.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `wolfeco`
--

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int(255) NOT NULL,
  `grup` varchar(255) NOT NULL,
  `cloud` text NOT NULL,
  `yearStartStudy` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `progress`
--

CREATE TABLE `progress` (
  `id` int(255) NOT NULL,
  `studentID` int(255) NOT NULL,
  `semester` int(2) NOT NULL,
  `data` json NOT NULL,
  `grup` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `id` int(255) NOT NULL,
  `login` int(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` int(255) NOT NULL,
  `FIO` text NOT NULL,
  `grup` varchar(255) NOT NULL,
  `hash` text NOT NULL,
  `time` int(255) NOT NULL,
  `timed` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Структура таблицы `subjects`
--

CREATE TABLE `subjects` (
  `id` int(255) NOT NULL,
  `data` text NOT NULL,
  `grup` varchar(255) NOT NULL,
  `semester` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- Структура таблицы `timeTable`
--

CREATE TABLE `timeTable` (
  `id` int(255) NOT NULL,
  `timeS` time NOT NULL,
  `timeE` time NOT NULL,
  `dayW` int(255) NOT NULL,
  `week` int(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `tutor` varchar(255) NOT NULL,
  `corps` varchar(255) NOT NULL,
  `aud` int(255) NOT NULL,
  `type` int(255) NOT NULL,
  `isS` tinyint(1) NOT NULL DEFAULT '0',
  `grup` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Структура таблицы `visits`
--

CREATE TABLE `visits` (
  `id` int(255) NOT NULL,
  `date` date NOT NULL,
  `data` json NOT NULL,
  `semester` int(2) NOT NULL,
  `grup` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `timeTable`
--
ALTER TABLE `timeTable`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `progress`
--
ALTER TABLE `progress`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `timeTable`
--
ALTER TABLE `timeTable`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
