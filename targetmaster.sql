-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 09 2017 г., 17:49
-- Версия сервера: 5.7.19
-- Версия PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `targetmaster`
--

-- --------------------------------------------------------

--
-- Структура таблицы `answers`
--

DROP TABLE IF EXISTS `answers`;
CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripton` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `replics`
--

DROP TABLE IF EXISTS `replics`;
CREATE TABLE IF NOT EXISTS `replics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `descr` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `replics`
--

INSERT INTO `replics` (`id`, `name`, `value`, `descr`) VALUES
(1, 'hello', 'Привет! Я бот Васян.\r\nЯ помогу тебе управлять своим вниманием, рассылая тебе эффективные установки, чтобы фокусировать внимание в нужную сторону.\r\n\r\nЧтобы получить список команд, напиши \"Помощь\"\r\n\r\nЯ присылаю тебе определенное количество установок в день, в случайное время. Ты можешь настроить количество установок, время, когда я могу тебе прислать установки и темы.\r\n\r\nЕсли я надоел, ты можешь меня отключить на время командой \"усни\". Включить командой \"работай\"\r\n\r\nНу что, ты хочешь получить первую установку? (Да/Нет)', 'Приветствие ботом пользователя, которого он видит первый раз'),
(2, 'unknownCommand', 'Я не знаю такой команды. Напиши \"Помощь\", чтобы получить список таковых', 'Попалась неизвестная команда'),
(3, 'noThemes', 'У тебя не выбрано ни одной темы', 'У пользователя не подключено ни одной темы'),
(4, 'sendTaskLater', 'Оке... я пришлю установку чуть позже', 'Пользователь сказал \"нет\" на предложение прислать установку'),
(5, 'writeYesNo', 'Просто напиши: \"Да\" или \"Нет\"', 'Требовалось написать \"Да\" / \"Нет\", а пользователь написал фигню:'),
(6, 'firstTask', 'Хорошо, вот твоя первая установка', 'Пользователь сказал \"Да\" на предложение прислать установку'),
(7, 'sleep', 'Ну как скажешь. Я не буду присылать тебе установки. Чтобы снова включить меня, напиши \"работай\"', 'Пользователь написал боту \"усни\"'),
(8, 'wakeUp', 'Хорошо, я буду присылать тебе установки', 'Пользователь написал боту \"работай\"'),
(9, 'colTasks', 'Введи число, сколько установок в день ты хочешь получать', 'Требуем от пользователя ввода количества установок в день'),
(10, 'changeThemes', 'Вот темы. Напиши номера тем, которые тебе понравились\r\n\r\n', 'Предлагаем пользователю выбрать темы из списка'),
(11, 'changeTime', 'Напиши время когда я могу присылать установки. Типа такого: \"с 12:00 до 22:00\"', 'Требуем от пользователя ввода времени, когда бот ему будет присылать установки'),
(12, 'help', 'Список команд:\r\n\r\nустановка - пришлю установку немедленно\r\nизменить время - изменить время, когда я могу присылать установки\r\nизменить количество - изменить количество установок в день\r\nвыбрать темы - изменит темы установок\r\nусни - перестану тебе присылать установки\r\nработай - снова начну присылать установки', 'Помощь'),
(13, 'Thanks', 'Да пожалуйста!', 'Боту написали \"Спасибо\"'),
(14, 'takeItEasy', 'Лан... забудь!', 'Бот устал ждать ответа пользователя'),
(15, 'writeThemeNumbers', 'Просто перечисли номера тем', 'Если пользователь неправильно выбрал темы из списка'),
(16, 'tryAgain', 'Что-то не так. Я тебя не понимаю', 'Пользователь что-то неправильно ввел'),
(17, 'themesAdded', 'Хорошо, я добавил темы:', 'Бот добавил темы'),
(18, 'writeTimeCorrect', 'Введи время, как я показал: с hh:mm до hh:mm', 'Пользователь запутался с форматом ввода времени'),
(19, 'wrongTime', 'Я не понимаю... просто введи время', 'Очень сильно запутался'),
(20, 'firstTimeIsMore', 'Ты написал первое значение времени больше, чем второе. Я не знаю, когда тебе присылать установки', 'Пользователь написал первое значение времени больше второго'),
(21, 'timeChanged', 'Хорошо, я поменял время', 'Бот изменил время рассылки установок'),
(22, 'colChanged', 'Я поменял количество установок', 'Бот изменил количество установок в день'),
(23, 'writeNumber', 'Просто напиши число установок... число', 'От пользователя требовалось написать число, а он не справился');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `uid`, `time`) VALUES
(81, 254229781, 1512838827),
(82, 254229781, 1512844880);

-- --------------------------------------------------------

--
-- Структура таблицы `texts`
--

DROP TABLE IF EXISTS `texts`;
CREATE TABLE IF NOT EXISTS `texts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `texts`
--

INSERT INTO `texts` (`id`, `tid`, `text`) VALUES
(24, 19, 'Металлист-Карлсон потерпел авиакатастрофу после того, как его волосы намотались на пропеллер'),
(19, 18, 'Astronomy\r\n\r\nClocks strikes twelve and...'),
(20, 18, 'Nothing else matters\r\n\r\nSo close, no matter how far\r\nTo be much more long from us\r\nForever trust me, who we are\r\nAnd nothing else matters'),
(21, 19, 'Красная шапочка умерла от спида'),
(22, 19, 'Ученые измерили диаметр колобка, опираясь на поддержку компании из Амстердама'),
(23, 19, 'Если золотая рыбка заржавела, значит она не золотая!'),
(13, 16, 'Трактористы Трактористы'),
(16, 16, 'Машинисты\r\n\"Машинисты\" так же рифмуются со словом \"триста\", как \"трактористы\"'),
(17, 16, 'Футболисты\r\n\r\n0:7 Севилье просрать. Как так? Карера, да ты гонишь!'),
(18, 18, 'Master of puppets I\'m pulling your strings\r\nTwisting your mind and smashing your dreams\r\nBlinded by me, you can\'t see a thing\r\nJust call my name, \'cause I\'ll hear you scream'),
(15, 16, 'Трактористы\r\n\r\nОглянись вокруг! Видишь тракториста? Нет? И я не вижу. А он есть!');

-- --------------------------------------------------------

--
-- Структура таблицы `themes`
--

DROP TABLE IF EXISTS `themes`;
CREATE TABLE IF NOT EXISTS `themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `themes`
--

INSERT INTO `themes` (`id`, `theme`) VALUES
(16, 'Шутки за 300'),
(18, 'Metallica'),
(19, 'Бред');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `sTime` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '11:00',
  `eTime` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '21:00',
  `col` int(11) NOT NULL DEFAULT '5',
  `themes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `enabled`, `sTime`, `eTime`, `col`, `themes`) VALUES
(254229781, 1, '11:00', '21:00', 5, '18,16,19');

-- --------------------------------------------------------

--
-- Структура таблицы `waitings`
--

DROP TABLE IF EXISTS `waitings`;
CREATE TABLE IF NOT EXISTS `waitings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `func` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `insptime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
