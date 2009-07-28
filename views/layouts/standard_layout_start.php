<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>FC SG Data</title>
    <!-- <link rel="shortcut icon" href="/favicon.ico"> -->

    <link href="/public/stylesheets/base.css" media="screen" rel="stylesheet" type="text/css" />

    <script src="/public/js/prototype.js" type="text/javascript"></script>
    <script src="/public/js/scriptaculous.js" type="text/javascript"></script>
    <script src="/public/js/application.js" type="text/javascript"></script>
    <script src="/public/js/rounded.js" type="text/javascript"></script>
    <script src="/public/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>

    <meta name="language" content="de" />
    <meta name="author" content="Lukas Elmer" />
    <meta name="publisher" content="Beat Haueter" />
    <meta name="copyright" content="Lukas Elmer, 2009" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="audience" content="alle" />

</head>
<body>
<div class="base-outer">
<div class="base-inner">
<div class="header rounded">
    <div class="inner">
        <div class="fl"><a href="/" style="border:0;"><? image_tag('logo.png'); ?></a></div>
        <div class="navi fr">
            <ul>
                <li><? link_to('Übersicht', 'players') ?></li>
                <li><? link_to('Kontakt', 'home', 'contact') ?></li>
                <li><? link_to('Administration', 'admin') ?></li>

                <? if($authenticated){ ?>
                <li><? link_to('Neuer Spieler', 'admin', 'nnew'); ?></li>
                <li><? link_to('Startseite bearbeiten', 'admin', 'edit_startpage_content'); ?></li>
                <li><? link_to('Logout', 'users', 'logout') ?></li>
                <? } ?>
            </ul>
        </div>
        <? clearer() ?>
    </div>
</div>

<div class="main-content">
