<?php
//定义命名空间
namespace ob_deskt\core\Log;
/*
 * 日志接口
 * 主要用于：规范日志库
*/
interface LogT
{
    //写函数
    static public function set($P_logMessage,$P_logType,$P_logCome,$P_logUser,$P_logStyle);

    //读函数
    static public function get($P_fileName);

    //帮助函数
    static public function help();
}