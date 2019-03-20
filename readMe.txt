OB-DeskT==>observation desktop==>桌面观察团
L_-----局部变量
P_-----参数
C_-----程序集变量

M::模型调度器
V::视图视图器
C::控制调度器
L::语言调度器
F::过滤
R::路由
Q::队列
SC::验证码生成
Log::日志记录器
Cache::缓存操作器
Vdate::验证机
File::文件上传
Re::redis链表
RedisCache::redis缓存

模型层文件 继承 D类
控制层文件 继承 father.php 中的对应类


主目录--
---------log 用于存放日志文件
---------public_html
         -------------API 用于存放相关的API文件
         -------------config 用于存放配置文件
         -------------control 用于存放控制层文件
                      -------@father.php 综合父类
                      -------@scode.php 验证码
         -------------core 用于存放核心文件
                      -------db 用于存放数据库使用库
                             -------mysql.php MySql库
                      -------tool 用于存放常用工具库(AOP)
                             -------font 验证码字体库
                             -------@fileUpload.php 文件上传器
                             -------@filters.php 过滤器
                             -------@login_register.php 通用登陆注册器
                             -------@other.php 其他工具包
                             -------@securityCode.php 验证码生成器
                             -------@redis.php redis链表
                             -------@page.php 分页类
                             -------@validate.php 验证机类
                      -------cache 用于存放缓存使用库
                             -------@fileCache.php 默认缓存生成器
                             -------@redisCache.php redis缓存生成器
                      -------queue 用于存放队列操作库
                             -------@queue 队列操作类
                      -------log 用于存放日志操作库
                             -------@log.php 默认日志生成器
                      -------@control.php 控制调度器
                      -------@model.php 模型调度器
                      -------@view.php 视图调度器
                      -------@db.php 数据库操作类
                      -------@OB-DeskT.php 运行框架
                      -------@route.php 路由
         -------------language 用于存放语言配置
         -------------model 用于存放模型层文件
         -------------modle 用于存放模块文件
         -------------templates 用于存放视图层文件
                      -------default 默认视图模板文件
                      -------css 用于存放样式表
                             -------img 用于存放样式表引用图片
                             -------@Style 默认样式表
                      -------js 用于存放js或jq脚本
                             -------@Script 默认脚本文件
                      -------layout 用于存放布局文件
                             -------@default.layout.php 默认页头文件
                             -------@footer.html.php 默认页脚文件
         -------------varCache 默认变量缓存存放路径
         -------------timer 用于存放定时器
                      -------@index 定时器访问入口
         -------------admin 用于存放管理后台所有文件
                      -------public_html
                             -------------API 用于存放相关的API文件
                             -------------control 用于存放控制层文件
                             -------------language 用于存放语言配置
                             -------------templates 用于存放视图层文件
        -------------index.php 程序入口

**说明:@------表示文件