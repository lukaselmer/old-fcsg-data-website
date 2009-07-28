<div style="height: 4px; width: 10px;"></div>
<div class="player-index player rounded">
    <div class="inner">
        <? foreach ($anchor_letters as $startchar) { ?>
        <a href="#players-<? echo $startchar ?>" style="text-decoration:none;">
            <em><? echo $startchar ?></em>
        </a>
        <? } ?>
    </div>
</div>
