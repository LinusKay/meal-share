<!doctype html>
<?php
$plate = 'img/platesmall.png';
$bases_src = glob('img/food/bases/*.png'); //select one base
$toppings_src = glob('img/food/toppings/*.png'); //select 3 toppings
$garnish_src = glob('img/food/garnish/*.png'); //select one garnish

//SELECT BASE
shuffle($bases_src);
$base_path = $bases_src[0];
$base_name = strip_path($bases_src[0]);

//SELECT TOPPINGS
$toppings_path = array();
$toppings_name = array();
$toppings_count = rand(1, count($toppings_src));
for($i=0;$i<3;$i++){
	shuffle($toppings_src);
	array_push($toppings_path, $toppings_src[0]);
	array_push($toppings_name, strip_path($toppings_src[0]));
	$toppings_src = array_diff($toppings_src, [$toppings_src[0]]);
}
$last_topping = array_pop($toppings_name);
$toppings_string = count($toppings_name) ? implode(", ", $toppings_name) . " and " . $last_topping : $last_topping;

//SELECT GARNISH
shuffle($garnish_src);
$garnish_path = $garnish_src[0];
$garnish_name = strip_path($garnish_src[0]);



function strip_path($file){
	$file = preg_replace('/img\/food\/((.*))\//', '', $file);
	$file = str_replace('.png', '', $file);
	return $file;
}


//CREATE IMAGE
//SETUP IMAGE
$img_width = 175;  
$img_height = 175;
$output_image = imagecreatetruecolor ($img_width,$img_height);
imagesavealpha($output_image , true);

$transparent = imagecolorallocatealpha($output_image , 255, 255, 255, 127);
imagefill($output_image,0,0,$transparent);

$plate_image = imagecreatefrompng($plate);
$plate_width = imagesx($plate_image);
$plate_height = imagesy($plate_image);
imagecopyresized($output_image, $plate_image, 0, 0, 0, 0, $img_width, $img_height, $plate_width, $plate_height);

//BASE
$base_img = imagecreatefrompng($base_path);
$base_width = imagesx($base_img);  
$base_height = imagesy($base_img);
imagecopyresized($output_image, $base_img, 0, 0, 0, 0, $img_width, $img_height, $base_width, $base_height);

//TOPPINGS
foreach($toppings_path as $top){
	$top_img = imagecreatefrompng($top);
	$top_width = imagesx($top_img);  
	$top_height = imagesy($top_img);
	imagecopyresized($output_image, $top_img, 0, 0, 0, 0, $img_width, $img_height, $top_width, $top_height);
}
//GARNISH
$garnish_img = imagecreatefrompng($garnish_path);
$garnish_width = imagesx($garnish_img);  
$garnish_height = imagesy($garnish_img);
imagecopyresized($output_image, $garnish_img, 0, 0, 0, 0, $img_width, $img_height, $garnish_width, $garnish_height);

//OUTPUT IMAGE
$file_name = $base_name . ', ' . $toppings_string . ' with ' . $garnish_name . '.png';
$out_path = 'img/output/';
imagepng($output_image, $out_path . $file_name);
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Meal Share </title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<style>
	*{
		margin:0;
	}
	body{
		width:100%;
		height:100%;
		font-family:'Times New Roman';
		background:#dadada;
	}
	#plating-bench{
		height:100%;
		width:60%;
		margin:auto;
		background:#f3f3f3;
	}
	.plate{
		width:500px;
		height:500px;
		display:block;
		margin:25px auto;
	}
	.comment-box{
		height:100px;
		width:90%;
		margin:auto;
		border: solid 1px #d8d8d8;
		background:#eeeeee;
	}
	.comment-img{
		width:90px;
		height:90px;
		margin:5px;
		display:inline-block;
		float:left;
	}
	.comment-text{
		margin:10px 0;
	}
	h1, h2, h3, .desc{
		text-align:center;
	}
	.comment-title{
		width:90%;
		margin:auto;
	}
	.web-desc{
		margin-bottom:25px;
	}
	#ad{
	width:300px;
	height:300px;
	background:black;
	position:fixed;
	bottom:0;
	border:solid 1px black;
	border-radius:3px;
}
#ad:hover{
	cursor:pointer;
}
#ad img{
	width:300px;
	height:300px;
	position:absolute;
	z-index:0;
}
.ad-sign{
	position:absolute;
	top:0; left:0;
	z-index:1;
	background:black;
	color:white;
	width:100%;
}
.ad-name{
	margin-top:20px;
	position:relative;
	z-index:2;
	color:white;
	text-decoration:none;
	text-align:center;
	font-size:23px;
}
.ad-close{
	float:right;
	text-align:right;
}
	</style>
</head>
<body>
<div id="plating-bench">
<h1 class="web-title">MealShare</h1>
<h3 class="web-desc">Share your favourite meals with the world! Give your thoughts on others!</h3>
<?php
//COMMENTS
$faces = glob('../50/*.jpg');
$comments = file('text/comments.txt', FILE_IGNORE_NEW_LINES);
$name_end = ['avid', 'ichael', 'even', 'adam', 'ames', 'obert', 'illiam', 'ichard', 'arles', 'aniel', 'atthew', 'onald', 'oshua', 'evin', 'edward', 'ason', 'acob', 'ary', 'icholas', 'onathon', 'ank', 'amuel', 'imothy', 'aymond', 'alexander', 'athan', 'ethan', 'achary', 'arl', 'eremy', 'ristian', 'ordan', 'ylan', 'abriel', 'ogan', 'incent', 'adley'];
$name_start = ['B', 'D', 'Gr', 'J', 'Kl', 'McD', 'R', 'Sl', 'S', 'Tr', 'M', 'McM'];
$first_name = $name_start[array_rand($name_start)] . $name_end[array_rand($name_end)];
$second_name = $name_start[array_rand($name_start)] . $name_end[array_rand($name_end)];
$name = $first_name . ' ' . $second_name;	
$adj_array = file('text/adjectives.txt', FILE_IGNORE_NEW_LINES);
$noun_array = file('text/nouns.txt', FILE_IGNORE_NEW_LINES);
$star_array = file('text/stars.txt', FILE_IGNORE_NEW_LINES);

//GENERATE NAME
shuffle($adj_array);
shuffle($noun_array);
$meal_name = 'The ' . $adj_array[0] . ' ' . $noun_array[0];
echo '<h2>Featured meal: ' . $meal_name . '</h1>';
echo '<h3>Posted by ' . $name . '</h3>';
echo '<p class="desc">' . $base_name . ' with ' . $toppings_string . ' toppings and ' . $garnish_name . ' garnish!</p>';

//DISPLAY IMAGE

echo '<img class="plate" src="' . $out_path . $file_name . '">';
echo '<p class="comment-title">Comments:</p>';
$count = rand(1,5);
for($i=0;$i<$count;$i++){
	shuffle($faces);
	$face = $faces[0];
	$faces = array_diff($faces, [$face]);
	shuffle($comments);
	$comment = $comments[0];
	$comments = array_diff($comments, [$comment]);
	$comment = str_replace('[toppings]', $toppings_string, $comment);
	$comment = str_replace('[base]', $base_name, $comment);
	$comment = str_replace('[author]', $name, $comment);
	$comment = str_replace('[mealname]', $meal_name, $comment);
	$first_name = $name_start[array_rand($name_start)] . $name_end[array_rand($name_end)];
	$second_name = $name_start[array_rand($name_start)] . $name_end[array_rand($name_end)];
	$name = $first_name . ' ' . $second_name;	
	$comment = str_replace('[myname]', $name, $comment);
	shuffle($star_array);
	$stars = $star_array[0];
	$likes = rand(-5, 20);
	 echo '<div class="comment-box">
	 <img src="' . $face . '" class="comment-img">
	 <h4 class="comment-name">' . $name . ' | ' . $stars . '</h4>
	 <p class="comment-text">' . $comment . '</p>
	 <p class="comment-likes">👍' . $likes . ' likes</p>
	 </div>
	 ';
}


?>

</div>
<?php

$ad_image_array = glob('img/ad-img/*.jpg');
$ad_count = rand(1,1);
for($i=0;$i<$ad_count;$i++){
	echo 
'<div id="ad" style="right:' . rand(0,10) . '%">
	<a href="https://libus.xyz/ads" target="_blank">
		<img src="' . $ad_image_array[array_rand($ad_image_array)] . '">
		<p class="ad-name">Buy Deals Online!</p>
	</a>
	<p class="ad-sign" onclick="$(this).parent().remove()">Advert<span class="ad-close">X</span></p>
	</div>
	<br>';
}

$ad_image_array = glob('img/faces/50/*.jpg');
$ad_count = rand(1,1);
for($i=0;$i<$ad_count;$i++){
	echo 
'<div id="ad" style="left:' . rand(0,10) . '%">
	<a href="https://libus.xyz/friend-online" target="_blank">
		<img src="' . $ad_image_array[array_rand($ad_image_array)] . '">
		<p class="ad-name">Make Friends Online!</p></a>
	<p class="ad-sign" onclick="$(this).parent().remove()">Advert</p>
	</div>
	<br>';
}
?>
</body>
</html>