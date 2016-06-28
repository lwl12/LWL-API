<?php
namespace app\music\controller;

class Netease
{
    public function song()
    {
        if (empty($_GET["id"])) {
            $return = array(
                'code' => 400,
                'msg'  => 'Parameter songid is missing',
            );
            return json_encode($return);
        }
        $Netease = A('Netease', 'event');
        if (($getMP3 = $Netease->getMP3(intval($_GET["id"]))) == false) {
            $return = array(
                'code' => 501,
                'msg'  => 'Invalid song or Netease server error',
            );
            return json_encode($return);
        } else {
            Header("Location: " . $getMP3['url']);
            return true;
        }
    }

    public function pic()
    {
        if (empty($_GET["id"])) {
            $return = array(
                'code' => 400,
                'msg'  => 'Parameter songid is missing',
            );
            return json_encode($return);
        }
        $Netease = A('Netease', 'event');
        if (($songinfo = $Netease->SongInfo(intval($_GET["id"]))) == false) {
            $return = array(
                'code' => 501,
                'msg'  => 'Invalid song or Netease server error',
            );
            return json_encode($return);
        } else {
            Header("Location: " . $songinfo['album']['picUrl']);
            return true;
        }
    }
}
