/*本脚本可以反复执行，重复执行*/

/*前台用户表，加所属人*/
alter table tp_users add `belonguser` int NOT NULL DEFAULT 0;
