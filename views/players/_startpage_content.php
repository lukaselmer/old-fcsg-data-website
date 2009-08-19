<? if(strlen($startpage_content->content) > 0) { ?>
<div style="height: 4px; width: 10px;"></div>
<div class="player rounded">
    <div class="inner">
        <div class="fl" style="width: 550px;"><? echo htmlspecialchars_decode($startpage_content->content); ?></div>
        <div class="fl rss" style="width: 150px; font-size: 0.8em;">
            <? print_r($_SERVER) ?>
            <? include("http://".$_SERVER['HTTP_HOST']."/lib/rss_parser/rss2html.php?XMLFILE=http://feeds.feedburner.com/fcsg%3fformat%3dxml&TEMPLATE=http://local.fcsg-data.ch/lib/rss_parser/fcsg-template.html&MAXITEMS=3"); ?>
        </div>
        <? clearer(); ?>
    </div>
</div>
<? } ?>