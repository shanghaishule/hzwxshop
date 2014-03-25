/*本脚本可以反复执行，重复执行*/
DROP TABLE IF EXISTS `tp_guide`;
CREATE TABLE `tp_guide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(60) NOT NULL,
  `guide` char(255) NOT NULL,
  `info` varchar(90) NOT NULL,
  `upd_type` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `tp_animation`;
CREATE TABLE `tp_animation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(60) NOT NULL,
  `open_animation` varchar(2) NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;