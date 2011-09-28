<? if (strlen($journal_content->content) > 0) { ?>
    <div style="height: 4px; width: 10px;"></div>
    <div class="player rounded">
        <div class="inner">
            <div class="fl" style="width: 700px;"><? echo htmlspecialchars_decode($journal_content->content); ?></div>
            <? clearer(); ?>
        </div>
    </div>
<? } ?>