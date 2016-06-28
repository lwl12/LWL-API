<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 定义项目路径
define('APP_PATH', dirname(__DIR__) . '/application/');
// 开启调试模式
define('APP_DEBUG', true);
//发送头部信息
header('X-Powered-By:Liwanglin12 API (api.lwl12.com)');
//自动生成
//define('APP_AUTO_BUILD', true);
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
// 执行应用
\think\App::run();
