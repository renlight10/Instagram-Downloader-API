<?php
#!/usr/bin/php -q

/**
 * PHP CLI Instagram Downloader
 *
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author     ren <ren_ice@live.com>
 * @homepage   https://github.com/guangrei
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

if(php_sapi_name()=="cli") {
	if(!file_exists('download'))
:		mkdir('download',0755,true);
	endif;
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
            $res = $videourl[1];
            
            
        }
        //type image
        else {
            preg_match('/<meta property="og:image" content="(.*?)" \/>/', $content, $image);
            $res = $image[1];
            
        }
    }
    //tidak ditemukan type
    else {
        $res = false;
        
    }
    //output
    return $res;
}
//akhir fungsi gen link
//function prompt content

function promCon(){
while(true):
echo"instagram post url:";
	$url = fgets(STDIN);
$url = str_replace("\n","",$url);
	if($url=="exit()")
:		 break;
	endif;
if(check_url($url)):
$link=gen_link(file_get_contents($url));
if($link!==false):
$name=parse_url(basename($link));
$name=$name['path'];
	$targetFile = fopen( "download/$name", 'w' );
	$ch = curl_init($link);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt( $ch, CURLOPT_FILE, $targetFile );
	curl_exec( $ch );
	fclose( $ch );
	echo"saved as download/$name complete!\n";
else:
echo"\033[31mNOTHING FOUND!  \033[0m  \n";
endif;
else:
echo"\033[31mINVALID URL!  \033[0m  \n";
endif;
endwhile;
}
//ahir prompt content
//function prompt profile

	function promProf(){
	while(true):echo"instagram username:";
	$user = fgets(STDIN);
	$user=str_replace("\n","",$user);
	if($user=="exit()")
:		 break;
	endif;
	//process data
	$data=json_decode(file_get_contents("https://www.instagram.com/$user/?__a=1"),true);
	if(isset($data['user']['profile_pic_url_hd']))
:		$urldownload=$data['user']['profile_pic_url_hd'];
	$targetFile = fopen( "download/$user.jpg", 'w' );
	$ch = curl_init($urldownload);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt( $ch, CURLOPT_FILE, $targetFile );
	curl_exec( $ch );
	fclose( $ch );
	echo"saved as download/$user.jpg complete!\n";
	else
		:echo"\033[31mInvalid instagram username!  \033[0m  \n";
	endif;
	endwhile;
}
//ahir function prompt profile
while(true):
echo"Please select one:\n[1] Instagram image profile downloader \n[2] Instagram content downloader \n[3] Quit program \n";
	$input = fgets(STDIN);
$input=str_replace("\n","",$input);
switch($input){
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
}
else{
die("please open this program in command line!");
}