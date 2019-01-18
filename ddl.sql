-- 데이터베이스 테이블 DDL
DROP DATABASE IF EXISTS `idus`;
CREATE DATABASE IF NOT EXISTS `idus`;
USE `idus`;

DROP TABLE IF EXISTS `member_list`;
CREATE TABLE IF NOT EXISTS `member_list` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `regdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(50) NOT NULL DEFAULT '',
  `affiliate` varchar(50) DEFAULT NULL,
  `phone` varchar(13) NOT NULL,
  `eventagree` tinyint(1) unsigned zerofill NOT NULL DEFAULT '0',
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `member_list_deleted`;
CREATE TABLE IF NOT EXISTS `member_list_deleted` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `regdate` datetime DEFAULT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `affiliate` varchar(50) DEFAULT NULL,
  `phone` varchar(13) NOT NULL,
  `eventagree` tinyint(1) unsigned zerofill NOT NULL DEFAULT '0',
  `deldate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


-- 데이터를 insert 하기 위한 query
INSERT INTO `idus`.`member_list` (`email`, `password`, `regdate`, `name`, `affiliate`, `phone`) VALUES
('idus@idus.com', '122345', '2019-01-18 11:55:37', 'idusdev', 'idus@idus.com', '01012345678');
