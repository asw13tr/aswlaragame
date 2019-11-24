-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 14 Ağu 2019, 18:01:06
-- Sunucu sürümü: 5.7.26
-- PHP Sürümü: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `aswlaragameclear`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `keywords` varchar(1024) DEFAULT NULL,
  `description` text,
  `summary` text,
  `author` varchar(255) DEFAULT NULL,
  `status` enum('published','draft','trash') NOT NULL DEFAULT 'published',
  `content` text,
  `views` int(11) NOT NULL DEFAULT '0',
  `cover` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `hide_cover` varchar(3) NOT NULL DEFAULT 'off',
  `allow_comments` varchar(3) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `p_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blog_categories`
--

DROP TABLE IF EXISTS `blog_categories`;
CREATE TABLE IF NOT EXISTS `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `status` enum('published','draft','trash') NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `config`
--

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `val` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `config_key_unique` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `config`
--

INSERT INTO `config` (`id`, `key`, `val`) VALUES
(1, 'url', 'http://127.0.0.1:8000'),
(2, 'title', 'Asw Laara Game'),
(3, 'description', NULL),
(4, 'author', NULL),
(5, 'refresh', '0'),
(6, 'site_offline', '0'),
(7, 'site_offline_message', 'Site bakım aşamasındadır.'),
(8, 'allow_register', '1'),
(9, 'allow_register_panel', '1'),
(10, 'contact_email', 'examplemail@atabassoft.com'),
(11, 'contact_sender_mail', 'examplemail@atabassoft.com'),
(12, 'contact_sender_name', 'Atabaş Software'),
(13, 'mail_driver', 'smtp'),
(14, 'mail_host', 'smtp.gmail.com'),
(15, 'mail_port', '587'),
(16, 'mail_username', 'gmail-hesabiniz@gmail.com'),
(17, 'mail_password', 'gmail-parolanız'),
(18, 'mail_encryption', 'tls'),
(19, 'path_media', 'media'),
(20, 'path_media_upload', 'media/upload'),
(21, 'path_media_page', 'media/page'),
(22, 'path_media_user', 'media/user'),
(23, 'path_media_article', 'media/article'),
(24, 'path_media_game', 'media/game'),
(25, 'path_media_game_category', 'media/game-category'),
(26, 'path_media_game_files', 'media/game-file'),
(27, 'img_allow_original', '1'),
(28, 'img_lg_crop', '0'),
(29, 'img_lg_quality', '90'),
(30, 'img_lg_w', '1024'),
(31, 'img_lg_h', '768'),
(32, 'img_md_crop', '0'),
(33, 'img_md_quality', '90'),
(34, 'img_md_w', '700'),
(35, 'img_md_h', '500'),
(36, 'img_sm_crop', '1'),
(37, 'img_sm_quality', '90'),
(38, 'img_sm_w', '500'),
(39, 'img_sm_h', '300'),
(40, 'pages_allow_comments', '1'),
(41, 'articles_allow_commens', '1'),
(42, 'articles_list_limit', '10'),
(43, 'articles_summary_limit', '33'),
(44, 'games_allow_commens', '1'),
(45, 'games_allow_detail_page', '1'),
(46, 'games_list_limit', '10'),
(47, 'games_summary_limit', '33'),
(48, 'games_summary_play', '512'),
(49, 'pre_panel_url', 'aswpanel');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `conn_art_cat`
--

DROP TABLE IF EXISTS `conn_art_cat`;
CREATE TABLE IF NOT EXISTS `conn_art_cat` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `blog_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `conn_game_cat`
--

DROP TABLE IF EXISTS `conn_game_cat`;
CREATE TABLE IF NOT EXISTS `conn_game_cat` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `game_id` int(11) NOT NULL,
  `game_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `games`
--

DROP TABLE IF EXISTS `games`;
CREATE TABLE IF NOT EXISTS `games` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `summary` varchar(512) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `game_file` varchar(255) DEFAULT NULL,
  `game_url` varchar(255) DEFAULT NULL,
  `game_code` varchar(512) DEFAULT NULL,
  `game_video` varchar(255) DEFAULT NULL,
  `game_screen` enum('normal','fullsize') NOT NULL DEFAULT 'normal',
  `game_scale` enum('1x1','4x3','5x3','2x1','16x9','1x2','3x4','3x5') NOT NULL DEFAULT '4x3',
  `status` enum('published','draft','trash') NOT NULL DEFAULT 'published',
  `content` text,
  `views` int(11) NOT NULL DEFAULT '0',
  `like` int(11) NOT NULL DEFAULT '0',
  `dislike` int(11) NOT NULL DEFAULT '0',
  `allow_comments` varchar(3) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `p_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `game_categories`
--

DROP TABLE IF EXISTS `game_categories`;
CREATE TABLE IF NOT EXISTS `game_categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `cover` varchar(255) DEFAULT NULL,
  `status` enum('published','draft','trash') NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `src` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `info` text,
  `author` int(11) DEFAULT NULL,
  `app` varchar(255) DEFAULT NULL,
  `app_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `content` text,
  `cover` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `status` enum('published','draft','trash') NOT NULL DEFAULT 'published',
  `hide_cover` varchar(3) NOT NULL DEFAULT 'off',
  `allow_comments` varchar(3) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `p_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `level` smallint(6) NOT NULL DEFAULT '1',
  `description` varchar(1024) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` enum('Belirtilmedi','Erkek','Kadın') NOT NULL DEFAULT 'Belirtilmedi',
  `datas` text,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `status` enum('active','passive','trash') NOT NULL DEFAULT 'passive',
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_name_unique` (`name`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
