-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.37-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for school_board
DROP DATABASE IF EXISTS `school_board`;
CREATE DATABASE IF NOT EXISTS `school_board` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `school_board`;

-- Dumping structure for table school_board.grade
DROP TABLE IF EXISTS `grade`;
CREATE TABLE IF NOT EXISTS `grade` (
  `grade_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(10) unsigned NOT NULL,
  `grade` int(10) unsigned NOT NULL,
  PRIMARY KEY (`grade_id`),
  KEY `fk_grade_student_id` (`student_id`),
  CONSTRAINT `fk_grade_student_id` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table school_board.grade: ~0 rows (approximately)
/*!40000 ALTER TABLE `grade` DISABLE KEYS */;
REPLACE INTO `grade` (`grade_id`, `student_id`, `grade`) VALUES
	(2, 1, 5),
	(3, 1, 6),
	(4, 1, 7),
	(5, 1, 8),
	(6, 2, 5),
	(7, 2, 6),
	(8, 2, 7),
	(9, 2, 8),
	(10, 3, 6),
	(12, 3, 7),
	(13, 3, 8),
	(14, 3, 9),
	(15, 4, 7),
	(16, 4, 8),
	(17, 4, 9);
/*!40000 ALTER TABLE `grade` ENABLE KEYS */;

-- Dumping structure for table school_board.student
DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `student_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `school_board` enum('CSM','CSMB') COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table school_board.student: ~0 rows (approximately)
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
REPLACE INTO `student` (`student_id`, `name`, `school_board`) VALUES
	(1, 'Alekas', 'CSM'),
	(2, 'Aleksa2', 'CSMB'),
	(3, 'MarkoCSM', 'CSM'),
	(4, 'MarkoCSMB', 'CSMB');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
