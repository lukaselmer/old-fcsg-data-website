<? if(strlen($startpage_content->content) > 0){ ?>
<div style="height: 4px; width: 10px;"></div>
<div class="player rounded">
    <div class="inner">
        <? echo htmlspecialchars_decode($startpage_content->content); ?>
    </div>
</div>
<? } ?>