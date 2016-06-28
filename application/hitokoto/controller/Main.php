<?php
namespace app\hitokoto\controller;

class Main
{
    public function Get()
    {
        header('X-Powered-By:Liwanglin12 API (api.lwl12.com)');
        header('access-control-allow-origin:*');

//预备一言数据
        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        $hitokoto_num = $redis->get('Api_hitokoto_num');
        if (empty($hitokoto_num)) {
            header('X-reload: reload');
            $Model    = M();
            $all_hitokoto = $Model->query('select * from hitokoto');
            foreach ($all_hitokoto as $toredis) {
                $redis->set("Api_hitokoto_" . $toredis['id'],$toredis['hitokoto']);
            }
            $redis->set('Api_hitokoto_num', count($all_hitokoto));
            $hitokoto_num = $redis->get('Api_hitokoto_num');
        }
        $hitokoto = $redis->get("Api_hitokoto_" . mt_rand(0, $hitokoto_num));
        
//开始输出
        if (isset($_GET["charset"])) {
            if ($_GET["charset"] == "gbk") {
                header("Content-type: text/html; charset=gbk");
                $hitokoto = iconv("UTF-8", "GBK", $hitokoto);
                if (!isset($_GET["encode"])) {
                    echo $hitokoto;
                    exit();
                }
                if ($_GET["encode"] == "js") {
                    header('Content-type: application/x-javascript');
                    echo "function lwlhitokoto(){document.write(\"" . $hitokoto . "\");}";
                    exit();
                } else if ($_GET["encode"] == "json") {
                    header('Content-type: application/json');
                    echo 'echokoto(' . json_encode(array('code' => 200, 'hitokoto' => $hitokoto)) . ');';
                    exit();
                } else {
                    echo $hitokoto;
                    exit();
                }
            } else {
                header("Content-type: text/html; charset=utf-8");
                if (!isset($_GET["encode"])) {
                    echo $hitokoto;
                    exit();
                }
                if ($_GET["encode"] == "js") {
                    header('Content-type: application/x-javascript');
                    echo "function lwlhitokoto(){document.write(\"" . $hitokoto . "\");}";
                    exit();
                } else if ($_GET["encode"] == "json") {
                    header('Content-type: application/json');
                    echo 'echokoto(' . json_encode(array('code' => 200, 'hitokoto' => $hitokoto)) . ');';
                    exit();
                } else {
                    echo $hitokoto;
                    exit();
                }
            }
        }
        header("Content-type: text/html; charset=utf-8");
        if (!isset($_GET["encode"])) {
            echo $hitokoto;
            exit();
        }
        if ($_GET["encode"] == "js") {
            header('Content-type: application/x-javascript');
            echo "function lwlhitokoto(){document.write(\"" . $hitokoto . "\");}";
            exit();
        } else if ($_GET["encode"] == "json") {
            header('Content-type: application/json');
            echo 'echokoto(' . json_encode(array('code' => 200, 'hitokoto' => $hitokoto)) . ');';
            exit();
        } else {
            echo $hitokoto;
            exit();
        }

    }

}
