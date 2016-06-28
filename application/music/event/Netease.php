<?php
namespace app\music\event;

class Netease
{
    /**
     * 获取歌词
     * @author M.J
     */
    public function getLrc($songid)
    {
        $id = intval($songid);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://music.163.com/api/song/media?id=' . $id);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Cookie: appver=2.0.2',
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, 'http://music.163.com;');
        $cexecute = curl_exec($ch);
        curl_close($ch);

        if ($cexecute) {
            $result = json_decode($cexecute, true);
            if ($result['code'] == 200 && $result['lyric']) {
                return $result['lyric'];
            }
        } else {
            return false;
        }
    }

    /**
     * 获取歌曲信息
     * @author M.J
     */
    public function SongInfo($songid)
    {
        $id  = intval($songid);
        $url = "http://music.163.com/api/song/detail/?ids=[$id]";
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Cookie: appver=2.0.2',
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, 'http://music.163.com/;');
        $cexecute = curl_exec($ch);
        curl_close($ch);

        if ($cexecute) {
            $result = json_decode($cexecute, true);
            if ($result['code'] == 200 && $result['songs']) {
                return $result['songs'][0];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
