<?php
#日志根目录
define('DIR_LOG_ROOT',DIR_ROOT.'/log');
#日志目录深度  目录深度表示在日志类型目下还将要分几层目录
#例如：深度为2 /frame/log/ERROR/年份/月份 深度为3 /frame/log/ERROR/年份/月份/日期
#深度为 1 日志将以 月 分割
#深度为 2 日志将以 日 分割
#深度为 3 日志将以 小时 分割
define('DIR_LOG_DEPTH',2);
#错误模板A
define('TEMP_ERROR_A','[&time&]&type&:from-[&come&]{&user&}message:[&message&]~'.PHP_EOL);
?>
