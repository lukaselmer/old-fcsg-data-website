
function toggle_player_description(id){
    var el = $('player_' + id).down('.description');
    Effect.toggle(el, 'blind');
}

function show_all_player_descriptions(){
    $$('.player').each(function(v){
        d = v.down('.description');
        if(d && !d.visible()){
            Effect.BlindDown(d);
        }
    });
}

function hide_all_player_descriptions(){
    $$('.player').each(function(v){
        d = v.down('.description');
        if(d && d.visible()){
            Effect.BlindUp(d);
        }
    });
}
