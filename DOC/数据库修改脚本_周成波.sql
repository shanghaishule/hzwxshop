/*本脚本可以反复执行，重复执行*/

/*前台用户表，加所属人，默认所属admin*/
alter table tp_users add `belonguser` int NOT NULL DEFAULT 1;

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

/*功能表，加所属人，默认所属admin*/
alter table tp_function add `belonguser` int NOT NULL DEFAULT 1;

-- ----------------------------
-- 重建功能列表
-- ----------------------------
DROP TABLE IF EXISTS `tp_function`;
CREATE TABLE `tp_function` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` tinyint(3) NOT NULL DEFAULT '1',
  `usenum` int(11) NOT NULL DEFAULT '0',
  `name` varchar(60) NOT NULL,
  `funname` varchar(100) NOT NULL,
  `actname` varchar(100) NOT NULL DEFAULT '',
  `info` varchar(100) NOT NULL DEFAULT '',
  `isserve` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `belonguser` int(11) NOT NULL DEFAULT '1',
  `funtype` varchar(100) NOT NULL DEFAULT '默认',
  `funcolor` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


INSERT INTO `tp_function` VALUES ('1', '2', '0', '天气查询', 'tianqi', '', '天气查询服务，输入：城市名+天气', '1', '1', '1', '默认', '');
INSERT INTO `tp_function` VALUES ('2', '2', '0', '聊天', 'liaotian', '', '聊天　直接输入聊天关键词即可', '1', '1', '1', '默认', '');
INSERT INTO `tp_function` VALUES ('3', '2', '0', '附近周边信息查询', 'fujin', '', '附近周边信息查询', '1', '1', '1', '默认', '');
INSERT INTO `tp_function` VALUES ('4', '2', '0', '彩票查询', 'caipiao', '', '回复内容:彩票+彩种即可查询彩票中奖信息,例：彩票双色球', '1', '1', '1', '默认', '');

INSERT INTO `tp_function` VALUES ('5', '2', '0', '功能管理', 'Function', 'index', '勾选你要开启的功能', '1', '1', '1', '基础', 'Red');
INSERT INTO `tp_function` VALUES ('6', '2', '0', '关注回复', 'Areply', 'index', '设置公众号被关注时的回复', '1', '1', '1', '基础', 'Highland');
INSERT INTO `tp_function` VALUES ('7', '2', '0', '文本回复', 'Text', 'index', '设置公众号文本回复', '1', '1', '1', '基础', 'Navy');
INSERT INTO `tp_function` VALUES ('8', '2', '0', '图文回复', 'Img', 'index', '设置公众号图文回复', '1', '1', '1', '基础', 'DarkGreen');
INSERT INTO `tp_function` VALUES ('9', '2', '0', '语音回复', 'Voiceresponse', 'index', '设置公众号语音回复', '1', '1', '1', '基础', 'DarkGreen');
INSERT INTO `tp_function` VALUES ('10', '2', '0', 'DIY菜单', 'Diymen', 'index', '设置公众号自定义菜单', '1', '1', '1', '基础', 'LightBlue');
INSERT INTO `tp_function` VALUES ('11', '2', '0', 'LBS回复', 'Company', 'index', 'LBS回复', '1', '1', '1', '基础', 'Brown');
INSERT INTO `tp_function` VALUES ('12', '2', '0', '短信设置', 'Call', 'index', '短信设置', '1', '1', '1', '基础', 'LightBlue');
INSERT INTO `tp_function` VALUES ('13', '2', '0', '统计分析', 'Requerydata', 'index', '统计分析', '1', '1', '1', '基础', 'LightRed');
INSERT INTO `tp_function` VALUES ('14', '2', '0', '相册', 'Photo', 'index', '相册', '1', '1', '1', '基础', 'Brown');

INSERT INTO `tp_function` VALUES ('15', '5', '0', '首页设置', 'Home', 'set', '输入：首页，访问微网站', '2', '1', '1', '微网', 'Red');
INSERT INTO `tp_function` VALUES ('16', '5', '0', '模板设置', 'Tmpls', 'index', '微网站模板设置', '2', '1', '1', '微网', 'Highland');
INSERT INTO `tp_function` VALUES ('17', '5', '0', '分类设置', 'Classify', 'index', '微网站内容分类设置', '2', '1', '1', '微网', 'Navy');
INSERT INTO `tp_function` VALUES ('18', '5', '0', '幻灯片', 'Flash', 'index', '微网站幻灯片设置', '2', '1', '1', '微网', 'Orange');
INSERT INTO `tp_function` VALUES ('19', '5', '0', '背景图片', 'Background', 'index', '微网站背景图片设置', '2', '1', '1', '微网', 'LightRed');
INSERT INTO `tp_function` VALUES ('20', '5', '0', '拨号版权', 'Home', 'plugmenu', '微网站拨号版权设置', '2', '1', '1', '微网', 'LightPurple');

INSERT INTO `tp_function` VALUES ('21', '4', '0', '大转盘', 'Lottery', 'index', '输入：抽奖，即可参加幸运大转盘抽奖活动', '2', '1', '1', '营销', 'Red');
INSERT INTO `tp_function` VALUES ('22', '4', '0', '优惠券', 'Coupon', 'index', '输入：优惠券，领取先到先得', '2', '1', '1', '营销', 'Highland');
INSERT INTO `tp_function` VALUES ('23', '4', '0', '刮刮卡', 'Guajiang', 'index', '刮刮卡抽奖活动', '1', '1', '1', '营销', 'Navy');
INSERT INTO `tp_function` VALUES ('24', '4', '0', '砸金蛋', 'Zadan', 'index', '砸金蛋活动', '1', '1', '1', '营销', 'DarkGreen');
INSERT INTO `tp_function` VALUES ('25', '4', '0', '微喜帖', 'Xitie', 'index', '微喜帖', '2', '1', '1', '营销', 'LightBlue');
INSERT INTO `tp_function` VALUES ('26', '4', '0', '微调研', 'Diaoyan', 'index', '微调研', '2', '1', '1', '营销', 'Orange');
INSERT INTO `tp_function` VALUES ('27', '4', '0', '摇一摇', 'WechaWall', 'index', '摇一摇（微信墙）', '2', '1', '1', '营销', 'Brown');

INSERT INTO `tp_function` VALUES ('28', '4', '0', '微团购', 'Groupon', 'index', '微团购', '2', '1', '1', '商务',  'Highland');
INSERT INTO `tp_function` VALUES ('29', '4', '0', '微商城', 'WeTall', 'index', '微商城后台', '2', '1', '1', '商务', 'Red');
INSERT INTO `tp_function` VALUES ('30', '4', '0', '无线订餐', 'Product', 'orders', '无线网络订餐', '1', '1', '1', '商务', 'Navy');
INSERT INTO `tp_function` VALUES ('31', '4', '0', '通用订单', 'Host', 'index', '通用订单', '2', '1', '1', '商务', 'DarkGreen');
INSERT INTO `tp_function` VALUES ('32', '4', '0', '万能表单', 'Selfform', 'index', '自定义表单(用于报名，预约，留言)等', '1', '1', '1', '商务', 'LightBlue');
INSERT INTO `tp_function` VALUES ('33', '2', '0', 'DIY宣传', 'Adma', 'index', 'DIY宣传页,用于创建二维码宣传页', '1', '1', '1', '商务', 'Orange');
INSERT INTO `tp_function` VALUES ('34', '3', '0', '360全景', 'Panorama', 'index', '360全景', '2', '1', '1', '商务','LightPurple');

INSERT INTO `tp_function` VALUES ('35', '4', '0', '会员卡', 'Member_card', 'index', '尊贵享受vip会员卡，回复：会员卡，即可领取', '1', '1', '1', '会员', 'Highland');
INSERT INTO `tp_function` VALUES ('36', '4', '0', '会员商家', 'Member_card', 'info', '会员卡商家设置', '2', '1', '1', '会员', 'Red');
INSERT INTO `tp_function` VALUES ('37', '4', '0', '会员特权', 'Member_card', 'privilege', '会员特权', '1', '1', '1', '会员', 'Navy');
INSERT INTO `tp_function` VALUES ('38', '4', '0', '在线开卡', 'Member_card', 'create', '在线开卡', '1', '1', '1', '会员', 'DarkGreen');
INSERT INTO `tp_function` VALUES ('39', '4', '0', '积分设置', 'Member_card', 'exchange', '积分设置', '1', '1', '1', '会员', 'LightBlue');
INSERT INTO `tp_function` VALUES ('40', '4', '0', '资料管理', 'Member', 'index', '会员资料管理，输入：会员，即可参与', '2', '1', '1', '会员', 'Orange');

INSERT INTO `tp_function` VALUES ('41', '4', '0', '第三方', 'Api', 'index', '第三方接口整合模块，请在管理平台下载接口文件并配置接口信息', '1', '1', '1', '互动', 'Highland');
INSERT INTO `tp_function` VALUES ('42', '4', '0', '留言板', 'Liuyan', 'index', '留言板', '1', '1', '1', '互动', 'Navy');
-- ----------------------------
-- ----------------------------
