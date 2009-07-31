<div style="height: 4px; width: 10px;"></div>
<div class="player rounded">
    <div class="inner">
        <div style="position:absolute; width:703px;">
            <div class="fl">
                <div style="position:absolute; z-index:200;">
                    <a href="<? echo url_for('players', 'index', Array('open_all' => 1)) ?>" onclick="show_all_player_descriptions(); return false;" style="text-decoration:none;">
                        <em>Details einblenden</em>
                    </a>
                </div>
            </div>

            <div class="fr" style="width: 112px;">
                <div style="position:absolute; z-index:200; width: 120px;">
                    <a href="<? echo url_for('players', 'index') ?>" onclick="hide_all_player_descriptions(); return false;" style="text-decoration:none;">
                        <em>Details ausblenden</em>
                    </a>
                </div>
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
