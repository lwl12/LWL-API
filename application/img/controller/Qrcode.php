<?php
namespace app\img\controller;

class Qrcode
{
    public function Get()
    {
        include 'saeqrcode.class.php';
        $qr = new SaeQRcode();
//二维码内容数据
        if (empty($_GET["ct"])) {
            exit("Error:Not content");
        }
        if (isset($_GET["ct"]{150})) {
            exit("Error:Content is too long!");
        }
        $qr->data = $_GET["ct"];
//二维码宽高
        if (isset($_GET["w"]) && $_GET["w"] <= 500) {
            $qr->width = $_GET["w"];
        } else {
            $qr->width = 300;
        }
        if (isset($_GET["h"]) && $_GET["h"] <= 500) {
            $qr->height = $_GET["h"];
        } else {
            $qr->height = 300;
        }
//二维码图片边缘间距值，值越大，间距越宽，可自由调整，默认0
        $qr->margin = 1;
//在二维码正中间放置icon，默认为空，即不放置，支持绝对与相对地址
        if (isset($_GET["icon"])) {
            if ($_GET["icon"] == "lwl") {
                $qr->icon = APP_PATH . 'img/controller/icon.png';
            }
        }
//生成二维码图片，成功返回文件绝对地址（放在了SAE_TMP_PATH），失败返回false
        $file = $qr->build();
        if (!$file) {
            var_dump($qr->errno(), $qr->errmsg());
            exit;
        }

//输出图片
        header('Content-Type: image/png');
        header("Cache-Control: max-age=7884000");
        exit(file_get_contents($file));

    }
}
