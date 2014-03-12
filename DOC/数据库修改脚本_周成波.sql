/*本脚本可以反复执行，重复执行*/

/*前台用户表，加所属人*/
alter table tp_users add `belonguser` int NOT NULL DEFAULT 0;

/*品牌表，加tokenTall*/
alter table tp_brandlist add `tokenTall` varchar(20) NOT NULL DEFAULT '';

/*分类表，加tokenTall*/
alter table tp_item_cate add `tokenTall` varchar(20) NOT NULL DEFAULT '';

/*首页背景图片表*/
DROP TABLE IF EXISTS `tp_background`;
CREATE TABLE `tp_background` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(60) NOT NULL,
  `img` char(255) NOT NULL,
  `info` varchar(90) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

/*用户表增加头像*/
alter table tp_users add `headerpic` varchar(255) NOT NULL DEFAULT '';

