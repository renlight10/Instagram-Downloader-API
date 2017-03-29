<?php
/**
 * PHP Instagram downloader API
 *
 * PHP version 5
 *
 * @category  Tools
 * @package   Instagram_API
 * @author    ren <ren_ice@live.com>
 * @copyright 2010-2017 notepy
 * @license   MIT http://opensource.org/licenses/MIT
 * @link      https://notepy.gitlab.io
 */

require"api.php";

$ua = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36";
ini_set("user_agent", $ua);

$url = isset($_GET['url']) ? $_GET['url'] : "";

if (!empty($url)) {
    if (checkUrl($url)) {
        header('Content-Type:application/json');
        echo genLink(file_get_contents($url));
        exit;
    } else {
        header('Content-Type:application/json');
        $out = array(
                "status"  => "error",
                "err_msg" => "invalid instagram url!",
               );
        echo json_encode($out, JSON_PRETTY_PRINT);
        exit;
    }
} else {
    header('Content-Type:application/json');
    $out = array(
            "status"  => "error",
            "err_msg" => "no input!",
           );
    echo json_encode($out, JSON_PRETTY_PRINT);
    exit;
}//end if
