SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS `news_aggregator`;
USE `news_aggregator`;

--
-- Структура таблицы `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) NOT NULL DEFAULT '',
  `url` varchar(1024) NOT NULL DEFAULT '',
  `md5` varchar(32) NOT NULL DEFAULT '',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `text` text,
  `sub_title` varchar(512) NOT NULL DEFAULT '',
  `category` varchar(127) NOT NULL DEFAULT '',
  `key_point` varchar(1024) NOT NULL DEFAULT '',
  `inner_url` text NOT NULL,
  `parsed` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `str_time` varchar(64) NOT NULL DEFAULT '',
  `related` text NOT NULL,
  `tags` varchar(1024) NOT NULL DEFAULT '',
  `tags2` varchar(1024) NOT NULL DEFAULT '',
  `time_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `response` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5` (`md5`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=406 ;

-- --------------------------------------------------------

--
-- Структура таблицы `article_korr`
--

DROP TABLE IF EXISTS `article_korr`;
CREATE TABLE IF NOT EXISTS `article_korr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) NOT NULL DEFAULT '',
  `url` varchar(1024) NOT NULL DEFAULT '',
  `md5` varchar(32) NOT NULL DEFAULT '',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `text` text NOT NULL,
  `sub_title` varchar(512) NOT NULL DEFAULT '',
  `category` varchar(127) NOT NULL DEFAULT '',
  `parsed` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `str_time` varchar(64) NOT NULL DEFAULT '',
  `time_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `response` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5` (`md5`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25771 ;

-- --------------------------------------------------------

--
-- Структура таблицы `block`
--

DROP TABLE IF EXISTS `block`;
CREATE TABLE IF NOT EXISTS `block` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `url` varchar(512) NOT NULL DEFAULT '',
  `md5` varchar(32) NOT NULL DEFAULT '',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5` (`md5`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

-- --------------------------------------------------------

--
-- Структура таблицы `block_item`
--

DROP TABLE IF EXISTS `block_item`;
CREATE TABLE IF NOT EXISTS `block_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `block_id` int(10) unsigned NOT NULL DEFAULT '0',
  `article_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=306 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cnbc_article`
--

DROP TABLE IF EXISTS `cnbc_article`;
CREATE TABLE IF NOT EXISTS `cnbc_article` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(512) NOT NULL DEFAULT '',
  `url` varchar(512) NOT NULL DEFAULT '',
  `md5` varchar(32) NOT NULL DEFAULT '',
  `parsed` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `response` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `published` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `text` (`text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `cnbc_article_cat`
--

DROP TABLE IF EXISTS `cnbc_article_cat`;
CREATE TABLE IF NOT EXISTS `cnbc_article_cat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(10) unsigned NOT NULL DEFAULT '0',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`article_id`,`category_id`),
  KEY `category_id` (`category_id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2040 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cnbc_category`
--

DROP TABLE IF EXISTS `cnbc_category`;
CREATE TABLE IF NOT EXISTS `cnbc_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `title` varchar(1024) NOT NULL DEFAULT '',
  `url` varchar(1024) NOT NULL DEFAULT '',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `parsed` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `md5` varchar(32) NOT NULL DEFAULT '',
  `page` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `max_page` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5` (`md5`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=805 ;

-- --------------------------------------------------------

--
-- Структура таблицы `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(1024) NOT NULL DEFAULT '',
  `http_code` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `total_time` float NOT NULL DEFAULT '0',
  `connect_time` float NOT NULL DEFAULT '0',
  `size_download` float NOT NULL DEFAULT '0',
  `speed_download` float NOT NULL DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `res` varchar(127) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44703 ;

-- --------------------------------------------------------

--
-- Структура таблицы `options`
--

DROP TABLE IF EXISTS `options`;
CREATE TABLE IF NOT EXISTS `options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL DEFAULT '',
  `value` varchar(1024) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `proxy`
--

DROP TABLE IF EXISTS `proxy`;
CREATE TABLE IF NOT EXISTS `proxy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `proxy` varchar(32) NOT NULL DEFAULT '',
  `port` int(10) unsigned NOT NULL DEFAULT '0',
  `country` varchar(32) NOT NULL DEFAULT '',
  `type` varchar(32) NOT NULL DEFAULT '',
  `success` int(10) unsigned NOT NULL DEFAULT '0',
  `error` int(10) unsigned NOT NULL DEFAULT '0',
  `banned` int(10) unsigned NOT NULL DEFAULT '0',
  `last_error` int(10) unsigned DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`proxy`,`port`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1791 ;

-- --------------------------------------------------------

--
-- Структура таблицы `search`
--

DROP TABLE IF EXISTS `search`;
CREATE TABLE IF NOT EXISTS `search` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(10) unsigned NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `title` varchar(1024) NOT NULL DEFAULT '',
  `table_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `article_id` (`article_id`,`table_id`) USING BTREE,
  KEY `table_id` (`table_id`),
  FULLTEXT KEY `fulltext` (`text`,`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33544 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` text COMMENT 'имя пользователя',
  `last_name` text COMMENT 'фамилия пользователя',
  `email` text COMMENT 'email пользователя',
  `nickname` text COMMENT 'псевдоним пользователя',
  `bdate` text COMMENT 'дата рождения в формате DD.MM.YYYY',
  `sex` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'пол пользователя (0 – не определен, 1 – женский, 2 – мужской)',
  `phone` text COMMENT 'телефон пользователя в цифровом формате без лишних символов',
  `photo` text COMMENT 'адрес квадратной аватарки (до 100*100)',
  `photo_big` text COMMENT 'адрес самой большой аватарки, выдаваемой соц. сетью',
  `city` text COMMENT 'город',
  `country` text COMMENT 'страна',
  `network` varchar(64) DEFAULT NULL COMMENT 'идентификатор соцсети пользователя',
  `profile` text COMMENT 'адрес профиля пользователя (ссылка на его страницу в соцсети, если удастся ее получить)',
  `uid` varchar(64) DEFAULT NULL COMMENT 'уникальный идентификатор пользователя в рамках соцсети',
  `identity` text COMMENT 'глобально уникальный идентификатор пользователя',
  `manual` text COMMENT 'массив вручную заполненных пользователем полей',
  `verified_email` text COMMENT 'индикатор верификации email, принимает значения 1 и -1',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `enabled` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `time_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'последнее время захода',
  `unique` varchar(32) NOT NULL DEFAULT '',
  `login` varchar(245) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`unique`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
