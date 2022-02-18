-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2022 年 2 月 10 日 01:53
-- サーバのバージョン： 5.7.34
-- PHP のバージョン: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gs_db`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `gs_shop_table`
--

CREATE TABLE `gs_shop_table` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `hyouka` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `kutikomi` text COLLATE utf8_unicode_ci NOT NULL,
  `indate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `gs_shop_table`
--

INSERT INTO `gs_shop_table` (`id`, `name`, `address`, `hyouka`, `kutikomi`, `indate`) VALUES
(2, '', '', '選択', '', '2022-01-31'),
(3, 'ラーメン佳', '日本、〒062-0021 北海道札幌市豊平区月寒西１条７丁目８−１９', '⭐️⭐️⭐️', 'めっちゃ美味い', '2022-02-01'),
(4, '鶴は', '日本、〒060-0908 北海道札幌市東区北８条東４丁目１−２０', '', '悪い', '2022-02-09'),
(5, '徳寿', '日本、〒060-0908 北海道札幌市東区北８条東５丁目１９−１', '⭐️', '接客いい', '2022-02-05'),
(6, 'サツドラ', '日本、〒060-0908 北海道札幌市東区北８条東４丁目１−２０', '⭐️⭐️⭐️', 'めっちゃいい', '2022-02-05'),
(7, '', '', '', '', '2022-02-06'),
(8, '', '', '', '', '2022-02-08'),
(9, 'くろべこや', '日本、〒060-0003 北海道札幌市中央区北３条西７丁目１−１ 緑苑ビル B１F', '⭐️⭐️⭐️', 'めっちゃいい', '2022-02-08');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `gs_shop_table`
--
ALTER TABLE `gs_shop_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `gs_shop_table`
--
ALTER TABLE `gs_shop_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
