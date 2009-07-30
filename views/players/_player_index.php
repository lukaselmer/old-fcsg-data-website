<div style="height: 4px; width: 10px;"></div>
<div class="player rounded">
    <div class="inner">
        <div style="position:absolute; width:703px;">
            <div class="fl">
                <a href="<? echo url_for('players', 'index', Array('open_all' => 1)) ?>" onclick="show_all_player_descriptions(); return false;" style="text-decoration:none;">
                    <em>Details einblenden</em>
                </a>
            </div>

            <div class="fr">
                <a href="<? echo url_for('players', 'index') ?>" onclick="hide_all_player_descriptions(); return false;" style="text-decoration:none;">
                    <em>Details ausblenden</em>
                </a>
            </div>
            <? clearer(); ?>
        </div>
        <div style="width:703px;">
            <div class="player-index" style="position: absolute; z-index:100; width:703px;">
                <? foreach ($anchor_letters as $startchar) { ?>
                <a href="#players-<? echo $startchar ?>" style="text-decoration:none;">
                    <em><? echo $startchar ?></em>
                </a>
                <? } ?>
            </div>
            &nbsp;
        </div>
    </div>
</div>
