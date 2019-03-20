<?php
/**
 * @BY  : phpStorm
 * @Name: GogoPro
 * @Date: 2019/3/20
 * @Time: 20:32
 * @Remarks: 日志类
 * @Version: 1.0.0.0 主版本号.子版本号.修订版本号.编译版本号
 */

//定义命名空间
namespace ob_deskt\core\Log;
//引入接口文件
include_once (DIR_CORE.'/Log/log.temp.php');
/*
 * 日志库
 * 主要用于：功能日志，状态日志，数据日志
*/
final class Log implements LogT
{
    #定义错误类型
    const LOG_ERROR = 'ERROR';
    #定义类名称
    static private $_className = Log;
    #定义返回
    static private $_return = array('Result'=>'','Code'=>'','Message'=>'');

    //重构私有构造函数
    private function __construct(){/*关闭 new方法*/}

    //定义：写函数
    //@Param 日志信息，日志类型，日志来源，发起人，样式
    //@return bool
    static public function set($P_logMessage,$P_logType,$P_logCome = 'Root',$P_logUser = 'System',$P_logStyle = 'A')
    {
        //初始化 5W 数组--开始
        $L_logParamArray = array('&message&' => $P_logMessage, '&type&' => $P_logType, '&come&' => $P_logCome, '&user&' => $P_logUser, '&time&' => date('Y-m-d H:i:s'));

        //*过滤第二参数 安全策略
        self::filter($P_logType);
        //*过滤第五参数 安全策略
        self::filter($P_logStyle);

        //拼接模板名称
        $L_tempString = eval('return TEMP_' . $L_logParamArray['&type&'] . '_' . $P_logStyle . ';');

        //验证模板是否真实存在
        if($L_tempString == 'TEMP_' . $L_logParamArray['&type&'] . '_' . $P_logStyle)
        {
            //通过返回方法返回
            return self::r(false,'CONSTANT UNDEFINED','常量未定义');
        }

        //创建日志根目录
        $L_createResult = self::create(DIR_LOG_ROOT);
        //--如果创建失败 返回
        if(!$L_createResult) {return $L_createResult;}

        //创建日志类型目录
        $L_createResult = self::create(DIR_LOG_ROOT.'/'.$L_logParamArray['&type&']);
        //--如果创建失败 返回
        if(!$L_createResult) {return $L_createResult;}

        //通过返回属性查询目录
        $L_logFileDir = self::$_return['Message'];

        //创建一个时间深度数组
        $L_depthArray = explode('-',date('Y-m-d-H-i-s'));

        //循环创建深度目录
        for($i = 0; $i < DIR_LOG_DEPTH; $i++)
        {
            //拼接目录
            $L_logFileDir .= '/' . $L_depthArray[$i];
            //创建日志深度目录
            $L_createResult = self::create($L_logFileDir);
            //--如果创建失败 返回
            if(!$L_createResult) {return $L_createResult;}
        }

        //通过返回属性查询目录
        $L_logFileDir = self::$_return['Message'] . '/';

        //循环拼接文件名
        for($i = 0; $i < DIR_LOG_DEPTH + 1; $i++)
        {
            //拼接目录
            $L_logFileDir .= $L_depthArray[$i] . '_';
        }

        //删除最后一个下划线 拼装文件后缀名
        $L_logFileDir = substr($L_logFileDir,0,strlen($L_logFileDir) - 1) . '.'  . $L_logParamArray['&type&'] . '.log.txt';

        //循环替换模板中变量
        foreach ($L_logParamArray as $key=>$value)
        {
            //替换模板中变量
            $L_tempString = str_replace($key,$value,$L_tempString);
        }

        //写到文件
        $L_result = file_put_contents($L_logFileDir, $L_tempString, FILE_APPEND);

        //如果写出结果为false
        if($L_result == false)
        {
            //写出到文件失败 通过返回方法返回
            return self::r(false,'NOT CREATE FILE','日志写出失败');
        }
        //通过返回方法返回
        return self::r(true,'0','成功');
    }

    //读函数
    //@Param 文件全路径，偏移量，结束符，欲取行数，块宽度
    //@return bool
    static public function get($P_fileName,$P_pointer = 0,$P_endSign = '',$P_row = 30,$P_chunkWeight = 2)
    {
        //重定义$P_endSign参数
        if(!isset($P_endSign) || empty($P_endSign)){$P_endSign = '~';}
        if(strlen($P_endSign) > 1)
        {
            //结束标识符过长 通过返回方法返回
            return self::r(false,'PARAM(3) TOO LONG','结束标识符必须为1个字节');
        }
        //定义循环开关
        $L_whileBool = true;
        //*获取文件大小 防止文件过大取文件大小时报错
        $L_fileSize = sprintf('%u', filesize($P_fileName));
        //定义块宽度 为了不影响速度 块宽度上限为 8192b
        $L_chunkWeight = 1024 * ($P_chunkWeight > 8 ? 8 : $P_chunkWeight);
        //*判断文件是否已超限制 在8388608TB - $L_chunkWeight内的均可以正常读取
        if(intval($L_fileSize) == (PHP_INT_MAX - $L_chunkWeight))
        {
            //文件超出限制 通过返回方法返回
            return self::r(false,'FILE TOO BIG','文件过大');
        }
        //定义偏移量
        $L_pointer = (intval($P_pointer) == (PHP_INT_MAX - $L_chunkWeight)) ? (PHP_INT_MAX - $L_chunkWeight) : intval($P_pointer);
        //定义字符串数组
        $L_stringArray = array();
        //定义取出行数
        $L_xRow = 0;
        //进入循环
        while($L_whileBool)
        {
            //重定义块宽度 如果现偏移量 + 移动块宽度 小于等于 文件大小 采用宽度偏移 否则 采用差值偏移
            $L_chunkWeight = ($L_pointer + $L_chunkWeight <= $L_fileSize) ? $L_chunkWeight : ($L_fileSize - $L_pointer);
            //只读模式开启文件
            $fileHeader = fopen($P_fileName, 'r');
            //移动指针
            fseek($fileHeader, $L_pointer, SEEK_CUR);
            //获取由指针开始长度为$L_chunkWeight的字符串
            $L_stringPart = fread($fileHeader,$L_chunkWeight);
            //按照结束符分割字符串成数组
            $L_stringPartArray = explode($P_endSign,$L_stringPart);
            //如果数组成员数-2依然大于或等于欲取出行数 开始整理信息 准备跳出循环
            if(sizeof($L_stringPartArray) - 2 >= ($P_row - $L_xRow))
            {
                //取行信息
                $L_pointer += self::getRows($P_row - $L_xRow,$L_stringArray,$L_stringPartArray,$P_endSign);
                //关闭文件
                fclose($fileHeader);
                //重定义取出行数
                $L_xRow += $P_row - $L_xRow;
                //循环开关关闭
                $L_whileBool = false;
            }
            //如果数组成员数-2依然小于欲取出行数 且 偏移量 = 文件大小 说明文件已结尾 开始整理信息 准备跳出循环
            elseif (sizeof($L_stringPartArray) - 2 < ($P_row - $L_xRow) && ($L_pointer + $L_chunkWeight == $L_fileSize))
            {
                //取行信息
                $L_pointer += self::getRows(sizeof($L_stringPartArray) - 1,$L_stringArray,$L_stringPartArray,$P_endSign);
                //关闭文件
                fclose($fileHeader);
                //重定义取出行数
                $L_xRow += sizeof($L_stringPartArray) - 1;
                //循环开关关闭
                $L_whileBool = false;
            }
            //如果数组成员数-2依然小于欲取出行数 开始整理该段信息
            else
            {
                //定义临时行数
                $L_tempRow = sizeof($L_stringPartArray) - 2;
                //取行信息
                $L_pointer += self::getRows($L_tempRow,$L_stringArray,$L_stringPartArray,$P_endSign);
                //重定义取出行数
                $L_xRow += $L_tempRow;
            }
        }
        //整理返回信息
        $L_MessageArray = array('Dev'=> ($L_pointer < $L_fileSize ? $L_pointer : 0),'Rows'=>$L_stringArray);
        //返回
        return self::r(true,'0',$L_MessageArray);
    }

    //创建目录
    //@Param 文件目录，权限编号
    //@return bool
    static private function create($P_fileDir,$P_mode = 0777)
    {
        //检查目录是否存在
        if(!file_exists($P_fileDir))
        {
            //不存在 创建并检查是否创建成功
            if(!@mkdir ($P_fileDir,$P_mode,true))
            {
                //权限不足 通过返回方法返回
                return self::r(false,'NOT CREATE DIR','目录创建失败');
            }
        }
        //检目录权限
        if(!is_writable($P_fileDir))
        {
            //权限不足 通过返回方法返回
            return self::r(false,'DIR NOT PERMISSION','目录权限不足');
        }
        //创建完成 通过返回方法返回
        return self::r(true,'0',$P_fileDir);
    }

    //整理行信息
    //@Param 欲取行数，总信息，分段信息，结束符
    //@return bool
    static private function getRows($P_row,&$P_stringArray,$P_stringPartArray,$P_endSign)
    {
        //初始化字符串临时容器
        $L_stringTemp = '';
        //循环装入字符串临时容器
        for ($i = 0; $i < $P_row; $i++)
        {
            //装入字符串临时容器
            $L_stringTemp .= $P_stringPartArray[$i];
            //删除换行符重新装入字符串数组
            $P_stringArray[] = str_replace(PHP_EOL, '', $P_stringPartArray[$i]);
        }
        //计算取出$P_row行的字符串长度 这也就是指针偏移量
        return (strlen($L_stringTemp) + (strlen($P_endSign) * $P_row) + ($P_stringPartArray[$P_row - 1] == PHP_EOL ? 0 : strlen(PHP_EOL)));
    }

    //过滤参数
    //@Param 待过滤参数
    static private function filter(&$P_value)
    {
        //使用正则替换 转换到大写字母
        $P_value = strtoupper(preg_replace('/\W/','',$P_value));
    }

    //返回方法
    //@Param 结果，代码，信息
    //@return bool
    static private function r($P_result,$P_code,$P_message)
    {
        self::$_return['Result'] = $P_result;
        self::$_return['Code'] = $P_code;
        self::$_return['Message'] = $P_message;

        return self::$_return['Result'];
    }

    //结果方法
    //@return array()
    static public function e()
    {
        return self::$_return;
    }

    //单元测试
    static public function test()
    {
        echo '这里是单元测试接口：OB-DeskT->' . self::$_className .'Class<br>';
    }

    //帮助函数
    static public function help()
    {
        echo "该库中含有【 2 】个公开函数<br><br>";
        echo "Log::set(日志信息[string],日志类型[LOG_开头的常量],信息来源[选填string],发起人[选填string],日志样式[选填A~Z])<br>";
        echo "返回一个类 属性：Code 属性：Message<br><br>";
        echo "use frame\core\Log as Log;<br>";
        echo "\$L_return = Log\Log::set('未知原因', Log\Log::LOG_ERROR);<br>";
        echo "\$L_return = Log\Log::set('未知原因', Log\Log::LOG_ERROR, 'frame\core\Db\sqlHelper');<br>";
        echo "\$L_return = Log\Log::set('未知原因', Log\Log::LOG_ERROR, 'frame\core\Db\sqlHelper', '127.0.0.1');<br>";
        echo "var_dump(\$L_return->Message);<br>";
        echo "<br><br>";
        echo "Log::get(文件全路径[string],偏移量[int],结束符[选填string],欲取行数[选填int],块宽度[选填 <= 8])<br>";
        echo "返回一个类 属性：Code 属性：Message<br><br>";
        echo "use frame\core\Log as Log;<br>";
        echo "\$L_return = Log\Log::get(DIR_ROOT.'/log/ERROR/2018/01/2018_01_05.ERROR.log.txt', 0);<br>";
        echo "\$L_return = Log\Log::get(DIR_ROOT.'/log/ERROR/2018/01/2018_01_05.ERROR.log.txt', 0, '~');<br>";
        echo "\$L_return = Log\Log::get(DIR_ROOT.'/log/ERROR/2018/01/2018_01_05.ERROR.log.txt', 0, '~',30);<br>";
        echo "var_dump(\$L_return->Message);<br>";
    }

    //重构私有克隆函数
    private function __clone(){}

    //重构私有析构函数
    private function destruct(){}
}