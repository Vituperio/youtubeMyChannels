$(document).ready(function(){
    $('#accordion').accordion({
        active: false,
        collapsible: true
    });

    $('#accordion h3').css({
        'color': 'white',
    });
    $('#accordion h3').removeClass('ui-state-default');
    $('#accordion h3 span').hide();
});