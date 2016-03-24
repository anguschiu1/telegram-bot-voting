-- for MySQL

CREATE TABLE IF NOT EXISTS `polling` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` bigint(20) NOT NULL,
  `User_Name` varchar(255) NOT NULL,
  `Poll` int(11) NOT NULL,
  `Last_Modified_Date` datetime NOT NULL,
  `IP` varchar(46),
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;