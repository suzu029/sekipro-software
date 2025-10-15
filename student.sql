-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2025-10-15 11:53:34
-- サーバのバージョン： 8.0.41
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `student`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `cal`
--

CREATE TABLE `cal` (
  `ban` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `member` int NOT NULL,
  `day` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- テーブルのデータのダンプ `cal`
--

INSERT INTO `cal` (`ban`, `name`, `number`, `member`, `day`) VALUES
(10, '坂西', '1', 1, '2025-08-07'),
(11, '坂西', '1', 1, '2025-08-11');

-- --------------------------------------------------------

--
-- テーブルの構造 `submission`
--

CREATE TABLE `submission` (
  `id` int NOT NULL,
  `s_number` int DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `subject` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sub` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `day` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- テーブルのデータのダンプ `submission`
--

INSERT INTO `submission` (`id`, `s_number`, `name`, `subject`, `sub`, `day`) VALUES
(6, 1402720, '坂西', '数学', '未提出', '2025-08-19'),
(8, 1402720, '坂西', '国語', '未提出', '2025-08-19'),
(9, 1402720, '坂西', '国語', '提出済み', '2025-09-04'),
(10, 1402720, '坂西', '国語', '提出済み', '2025-09-11'),
(11, 1402720, '坂西', '国語', '提出済み', '2025-09-18'),
(13, 1402720, '坂西', '国語', '提出済み', '2025-10-23');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `cal`
--
ALTER TABLE `cal`
  ADD PRIMARY KEY (`ban`);

--
-- テーブルのインデックス `submission`
--
ALTER TABLE `submission`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `cal`
--
ALTER TABLE `cal`
  MODIFY `ban` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- テーブルの AUTO_INCREMENT `submission`
--
ALTER TABLE `submission`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
