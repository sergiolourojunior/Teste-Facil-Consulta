<?php

$_meta['title'] = SITE_NAME;
$_meta['description'] = SITE_DESCRIPTION;
$_meta['color'] = SITE_COLOR;
$_meta['keyword'] = SITE_KEYWORD;

switch(PAGE) {
	case '':
		//
		break;
}

?>

<title><?=$_meta['title']?></title>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name='theme-color' content='<?=$_meta['color']?>'/>
<link rel="icon" sizes="192x192" href="<?=ASSETS?>css/images/logo-theme.png">

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<link rel="icon" href="<?=ASSETS?>css/images/logo-theme.png">
<link rel="canonical" href="<?=LINK?>" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<meta itemprop="name" content="<?=$_meta['title']?>">
<meta itemprop="description" content="<?=$_meta['description']?>">
<meta itemprop="image" content="">

<meta property="og:title" content="<?=$_meta['title']?>" />
<meta property="og:type" content="website" />
<meta property="og:$_meta['title']" content="<?=$_meta['title']?>" />
<meta property="og:url" content="<?=LINK?>" />
<meta property="og:image" content="<?=ASSETS?>css/images/thumb-facebook.png" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:description" content="<?=$_meta['description']?>" />

<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="<?=LINK?>">
<meta name="twitter:title" content="<?=$_meta['title']?>">
<meta name="twitter:description" content="<?=$_meta['description']?>">

<meta name="description" content="<?=$_meta['description']?>" xml:lang="pt-BR" lang="pt-BR" />
<meta name="keywords" content="<?=$_meta['keyword']?>">
<meta name="abstract" content="<?=$_meta['description']?>">

<meta name="robots" content="ALL" />
<meta name="author" content="Sérgio Louro Júnior" />
<meta name="language" content="pt-br" />
<meta name="reply-to" content="sergiolourojunior@gmail.com">
<meta name="geo.region" content="BR-RS" />
<meta name="DC.title" content="<?=$_meta['title']?>" />
<meta name="title" content="<?=$_meta['title']?>" />
<meta name="url" content="<?=LINK?>" />
<meta name="company" content="" />
<meta name="application-name" content="<?=$_meta['title']?>" />
<meta name="DC.creator.address" content="<?=LINK?>" />
<meta name="copyright" content="© Copyright <?=date("Y")?>" />
<meta name="rating" content="general" />
