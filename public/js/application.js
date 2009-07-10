
function toggle_player_description(id){
    var el = $('player_' + id).down('.description');
    Effect.toggle(el, 'blind', { duration: 2.0 });
}