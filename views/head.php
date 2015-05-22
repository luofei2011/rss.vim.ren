<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0; user-scalable=no, minimal-ui" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
    <title><?php echo $title;?>-博客记录器</title>
	<link rel="stylesheet" type="text/css" href="./static/css/recss.css">
	<link rel="stylesheet" type="text/css" href="./static/css/fontello.css">
	<link rel="stylesheet" type="text/css" href="./static/css/index.css">
	<link rel="stylesheet" type="text/css" href="./static/css/login.css">
</head>
<body>
	<header>
        <?php if (!$need_back) {?>
        <a href="<?php echo BASE_URL . '?f=user_login';?>">
		    <i class="user-head">E</i>
        </a>
        <?php } else {?>
        <a href="<?php echo BASE_URL;?>" class="back">
            <i class="icon-left-open-big"></i>
        </a>
        <?php }?>
        <h1><?php echo $head_title;?></h1>
	</header>
