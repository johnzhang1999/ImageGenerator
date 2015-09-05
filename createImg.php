<?php
$dst_path = './src/img.png';
//创建图片的实例
$dst = imagecreatefromstring(file_get_contents($dst_path));
//打上文字
$font = './src/msyh.ttc';
//字体
$white = imagecolorallocate($dst, 0xFF, 0xFF, 0xFF);
//字体颜色
$university = $_POST["university"];
$score = $_POST["score"];
$uid = $_POST["uid"];
$words = $_POST["words"];
imagefttext($dst, 20, 0, 120, 120, $white, $font, $university);
imagefttext($dst, 20, 0, 120, 140, $white, $font, $score);
imagefttext($dst, 20, 0, 120, 160, $white, $font, $uid);
imagefttext($dst, 20, 0, 120, 180, $white, $font, $words);
//输出图片
$md5OfUid = md5($uid);
$imgSrc = "./img/" . $md5OfUid . "/img.png";
$htmlSrc = "./img/" . $md5OfUid . "/index.html";
if (!is_dir("./img/" . $md5OfUid . "/"))
	mkdir("./img/" . $md5OfUid . "/");
if (!file_exists($htmlSrc))
	file_put_contents($htmlSrc, 'd');
$myfile = fopen($htmlSrc, "w") or die("操作失败");
$txt = "<html>
<meta charset='utf-8'>
	<head>
		<title>我的图片</title>
	</head>
	<body>
		<img src='img.png'>
	</body>
</html>";
fwrite($myfile, $txt);
fclose($myfile);
list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
switch ($dst_type) {
	case 1 :
		//GIF
		header('Content-Type: image/gif');
		imagegif($dst, $md5OfUid . '.gif');
		break;
	case 2 :
		//JPG
		header('Content-Type: image/jpeg');
		imagejpeg($dst, $md5OfUid . '.jpg');
		break;
	case 3 :
		//PNG
		header('Content-Type: image/png');
		imagepng($dst, $imgSrc);
		header("refresh:0;url=" . $htmlSrc);
		break;
	default :
		break;
}
imagedestroy($dst);
?>