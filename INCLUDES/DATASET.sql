-- References:
-- https://copyprogramming.com/howto/insert-into-multiple-selects
-- https://stackoverflow.com/questions/6854996/mysql-insert-if-custom-if-statements
-- https://stackoverflow.com/questions/1361340/how-can-i-do-insert-if-not-exists-in-mysql
CREATE DATABASE IF NOT EXISTS stuovfdb;

USE stuovfdb;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `USER` (
  `UserID` int NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Surname` varchar(255)  NULL,
  `Firstname` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Coffees` int(7) DEFAULT 0,
  `IsAdmin` BOOLEAN DEFAULT 0,
  PRIMARY KEY (`UserID`)
--   KEY `EMAILLIST` (`Email`),
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `MODULE`(
    ModuleID int NOT NULL AUTO_INCREMENT,
    ModuleName varchar(50) NOT NULL,
    ModuleDescription varchar(100) DEFAULT NULL,
    PRIMARY KEY (ModuleID)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `QUESTION` (
  `QuestionID` int NOT NULL AUTO_INCREMENT,
  `UserID` int NOT NULL,
  `ModuleID` int NOT NULL,
  `QuestionTitle` varchar(160) NOT NULL,
  `QuestionText` varchar(10000) NOT NULL,
  `QuestionImage` varchar(255) DEFAULT NULL,	
  `QuestionCreateDate` datetime DEFAULT NOW(),
  `QuestionUpdateDate` datetime DEFAULT NOW(),
  PRIMARY KEY (`QuestionID`),
  FOREIGN KEY (`UserID`) REFERENCES USER(`UserID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (ModuleID) REFERENCES MODULE(ModuleID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
--   KEY `EMAILLIST` (`Email`)	
) ENGINE=InnoDB DEFAULT CHARSET=latin1;	

CREATE TABLE IF NOT EXISTS `COMMENT` (
  `CommentID` int NOT NULL AUTO_INCREMENT,
  `CommentText` varchar(10000) NOT NULL,
  `CommentCreateDate` datetime DEFAULT NOW(),
  `QuestionID` int NOT NULL,
  `UserID` int NOT NULL,
  PRIMARY KEY (`CommentID`),
  FOREIGN KEY (`QuestionID`) REFERENCES QUESTION(QuestionID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (`UserID`) REFERENCES USER(`UserID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `DB` (
  `Setting` varchar(100) NOT NULL,
  `Value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT IGNORE INTO `module` (`ModuleID`, `ModuleName`, `ModuleDescription`)
  SELECT 1, 'Web Programming', '                Programming for the web  ' UNION
  SELECT 3, 'Law', 'And order            ' UNION
  SELECT 4, 'Marketing', '        Now at only £3,99!                ' UNION
  SELECT 5, 'General', 'Any topic that is not listed in other modules.'
WHERE NOT EXISTS (SELECT * FROM DB WHERE Setting = 'Imported' AND `Value` = 'Yes');

INSERT IGNORE INTO `user` (`UserID`, `Username`, `Password`, `Surname`, `Firstname`, `Email`, `Coffees`, `IsAdmin`)
SELECT 1, 'admyalda', '$2y$10$COwbsUYeCx48.OhG8/3YoegSWUN3ZtSZDoUZu9Xjzvm4v9mi7qMnC', 'Firoozbakht', 'Yalda', 'superglobaladmin@studentoverflow.com', 100, 1
UNION
SELECT 2, 'tobi', '$2y$10$u9YK8YYS3IVksiuI9IdaxuoSKgdE39gJH0NwAUwmWKch7lYhRM13K', 'Uchiha', 'Obito', 'dontlookforme@gmail.com', 0, 0
UNION
SELECT 4, 'someuser', '$2y$10$9T0tY0djZw5vlCxLc3UcveiaM6CjgNf7dJk9n/Aw833oSh8go8Kvu', 'user', 'some', 'some@gmailc.om', 0, 0
WHERE NOT EXISTS (SELECT * FROM DB WHERE Setting = 'Imported' AND `Value` = 'Yes');

INSERT IGNORE INTO `question` (`QuestionID`, `UserID`, `ModuleID`, `QuestionTitle`, `QuestionText`, `QuestionImage`, `QuestionCreateDate`, `QuestionUpdateDate`)
SELECT 1, 1, 1, 'How do I copy StackOverflow without it being obvious?', '           I had a million dollars idea, turns out:\r\n- I wasn\'t the first\r\n- I didn\'t have the million dollars             ', NULL, '2024-01-01 20:47:01', '2024-01-01 20:47:01'
UNION
SELECT 3, 1, 5, 'How to have breakfast while still being on time for uni at 9 AM?', '                Asking for a friend...\r\n\r\n                    ', NULL, '2024-01-01 20:52:39', '2024-01-01 23:41:51'
UNION
SELECT 7, 2, 3, 'Nevermind we good now.', 'Ignore  my previous post please< I don\'t know how to delete it. This is not the kind of stuff I\'m good at.', NULL, '2024-01-01 21:23:23', '2024-01-01 21:23:23'
UNION
SELECT 8, 2, 4, 'I think I\'m having too much coffee, any ideas?', '            Well recently I started drinking coffee before bed. I know a brilliant idea right...\r\n\r\nBut it didn\'t affect me before, so any ideas what happend? \r\n\r\nShould I call a doctor?', NULL, '2024-01-01 21:27:05', '2024-01-01 21:27:05'
UNION
SELECT 9, 4, 1, 'a new post here', '123123            ', NULL, '2024-01-01 23:44:25', '2024-01-01 23:44:25'
WHERE NOT EXISTS (SELECT * FROM DB WHERE Setting = 'Imported' AND `Value` = 'Yes');

-- Save Imported = Yes in DB table to know we already imported the data automatically before
INSERT INTO DB(Setting, `Value`) VALUES('Imported', 'Yes');