<?php
namespace app\img\controller;

class Proxy
{
    public function get()
    {
        header('X-Authorize: Only authorized sites available.');
        if (empty($_GET['src'])) {
            Header("http/1.0 400 Bad Request");
            exit();
        }
        $domain_list = array(
            "www.anotherhome.net",
            "blog.lwl12.com",
            "myhloli.com",
            "img.myhloli.com",
	        "www.wingsdream.cn",
        );

        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : false;
        if ($referer) {
            $refererhost = parse_url($referer);
            $host        = strtolower($refererhost['host']);
            if ($host == $_SERVER['HTTP_HOST'] || in_array($host, $domain_list)) {
                $src = $_GET['src'];
                $src = preg_replace('/http:\/\/.+\.gravatar\.com/', 'https://cn.gravatar.com', $src);
                header('Content-Type:image/png');
                $cacheimg = S('proxy_' . $_GET["src"]);
                if (empty($cacheimg)) {
                    if (@exif_imagetype($src)) {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $src);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $img = curl_exec($ch);
                        curl_close($ch);
                        S('proxy_' . $_GET["src"], $img);
                        header("Cache-Control: max-age=2592000");
                        echo $img;
                        return;
                    } else {
                        Header("http/1.0 400 Bad Request");
                        exit();
                    }
                } else {
                    header('X-Server-Cache: From Cache');
                    header("Cache-Control: max-age=2592000");
                    echo $cacheimg;
                    return;
                }
            } else {
                Header("http/1.0 403 Forbidden");
                exit();
            }
        } else {
            Header("http/1.0 403 Forbidden");
            exit();
        }
    }

    public function del()
    {
        var_dump(S('proxy_' . $_GET["src"], null));
    }

    public function add()
    {
        header('Content-Type:image/png');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $src);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $img = curl_exec($ch);
        curl_close($ch);
        S('proxy_' . $_GET['name'], $img);
        return $img;
    }
}
