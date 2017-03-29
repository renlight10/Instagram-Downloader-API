<?php
// !/usr/bin/php -q
/**
 * PHP Instagram downloader CLI
 *
 * PHP version 5
 *
 * @category  Tools
 * @package   Instagram_CLI
 * @author    ren <ren_ice@live.com>
 * @copyright 2010-2017 notepy
 * @license   MIT http://opensource.org/licenses/MIT
 * @link      https://notepy.gitlab.io
 */
require "api.php";
if (php_sapi_name()=="cli") {
    if (!file_exists('download')) :
        mkdir('download', 0755, true);
    endif;
    $ua = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36";
    ini_set("user_agent", $ua);

    while (true) :
        echo"Please select one:\n[1] Instagram image profile downloader \n[2] Instagram content downloader \n[3] Quit program \n";
         $input = fgets(STDIN);
        $input=str_replace("\n", "", $input);
        switch ($input) {
            case 1:
                echo"Enter instagram username or type ",' exit() ',"to exit this section \n";
                promProf();
                break;
            case 2:
                echo"Enter instagram user post url include http/https or type ",'exit() ',"to exit this section: \n";
                promCon();
                break;
            case 3:
                exit("see you later :)\n");
            break;
            default:
                echo"\033[31mYour input is wrong please select 1,2 or 3 \033[0m  \n";
        }
    endwhile;
} else {
    die("please open this program in command line!");
}
