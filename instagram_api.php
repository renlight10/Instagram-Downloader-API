<?php
/**
 * Instagram API
 *
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author     ren <ren_ice@live.com>
 * @homepage   https://github.com/guangrei
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
$ua = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36";
ini_set("user_agent", $ua);
//fungsi mengecek url
function check_url($url)
{
    //jika tidak kosong
    if (!empty($url)) {
        $parse = parse_url($url);
        //jika url host instagram
        if ($parse['host'] == "instagram.com" || $parse['host'] == "www.instagram.com") {
            return true;
        } else {
            //bukan instagram
            return false;
        }
    } else {
        //url kosong
        return false;
    }
}
//akhir fungsi check url

//fungsi generate link
function gen_link($content)
{
    //mendeteksi type
    preg_match('/<meta name="medium" content="(.*?)" \/>/', $content, $type);
    //menemukan type
    if (!empty($type[1])) {
        //jika type video
        if ($type[1] == "video") {
            //video url
            preg_match('/<meta property="og:video" content="(.*?)" \/>/', $content, $videourl);
            //video img
            preg_match('/<meta property="og:image" content="(.*?)" \/>/', $content, $videoimg);
            $res = array(
                "status" => "success",
                "type" => "video",
                "video_url" => $videourl[1],
                "video_thumb" => $videoimg[1]
            );
            
            
        }
        //type image
        else {
            preg_match('/<meta property="og:image" content="(.*?)" \/>/', $content, $image);
            $res = array(
                "status" => "success",
                "type" => "image",
                "image_url" => $image[1]
            );
            
        }
    }
    //tidak ditemukan type
    else {
        $res = array(
            "status" => "error",
            "err_msg" => "nothing found!"
        );
        
    }
    //output
    return json_encode($res, JSON_PRETTY_PRINT);
}
//akhir fungsi gen link
$url = $_GET['url'];

if (!empty($url)) {
    
    if (check_url($url)) {
        header('Content-Type:application/json');
        echo gen_link(file_get_contents($url));
        exit;
    } else {
        header('Content-Type:application/json');
        $out = array(
            "status" => "error",
            "err_msg" => "invalid instagram url!"
        );
        echo json_encode($out, JSON_PRETTY_PRINT);
        exit;
    }
} else {
    header('Content-Type:application/json');
    $out = array(
        "status" => "error",
        "err_msg" => "no input!"
    );
    echo json_encode($out, JSON_PRETTY_PRINT);
    exit;
}
?>