centOS 安装 yum install lynx
       安装 yum -y install vixie-cron
crontab -u root -e
进入文件后 点击键盘 i
进入编辑后 输入
//每分钟
*/1 * * * * /bin/sh /var/www/crontab/minute.sh
//每小时
0 */1 * * * /bin/sh /var/www/crontab/hour.sh
//每天23:59
59 23 * * * /bin/sh /var/www/crontab/day.sh
//每周日23:59
59 23 * * 0 /bin/sh /var/www/crontab/week.sh
//每月1日00:00
0 0 1 */1 * /bin/sh /var/www/crontab/month.sh
//每12月00:00
0 0 * */12 * /bin/sh /var/www/crontab/year.sh
完成后 点击键盘ESC
退出编辑后 输入 :wq 保存


minute.sh 内容:
#!/bin/sh
/usr/bin/w3m http://127.0.0.1/public_html/index.php?act=timer

注:请首先确保服务器安装了w3m
   查询本机sh 或 w3m 路径请使用 whereis sh 或 whereis w3m



service crond start //启动服务
service crond stop //关闭服务
service crond restart //重启服务
service crond reload //重新载入配置

* * * * * /bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 1;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 2;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 3;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 4;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 5;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 6;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 7;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 8;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 9;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 10;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 11;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 12;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 13;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 14;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 15;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 16;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 17;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 18;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 19;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 20;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 21;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 22;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 23;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 24;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 25;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 26;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 27;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 28;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 29;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 30;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 31;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 32;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 33;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 34;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 35;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 36;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 37;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 38;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 39;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 40;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 41;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 42;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 43;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 44;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 46;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 48;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 49;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 50;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 51;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 52;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 53;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 54;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 55;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 56;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 57;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 58;/bin/sh /var/www/crontab/asynchronous.sh
* * * * * sleep 59;/bin/sh /var/www/crontab/asynchronous.sh

