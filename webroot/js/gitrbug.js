function decorate() {
    head = [
        '  ; '  ,
        ',´ ;'  ,
        '`,´ '
    ];

    repeat = [
        '( ; '  ,
        ',´ ;'  ,
        '`,´ '
    ];

    foot_l = [
        '( `+._,—(',
        ' `+._,—´˙`—-._,— -('
    ];

    foot_r = [
        ')-- -- —, _ .- —` ˙ ´+ —, _ .- —´˙ `—, _ .+´ ) ',
        ')-._,-—´˙`—._,+´  '
    ];

    $('pre').remove();

    fill_height = $('#cl_bleft').height();

    $(head).each(function (s) {
                     $('#cl_bleft').append('<pre>' + head[s] + '</pre>');
                     $('#cl_bright').append('<pre>' + head[s] + '</pre>');
                 });

    sec_height = $('#cl_bleft').children('pre').height() * 3;
    cur_height = sec_height;

    r_secs = 0;
    while(cur_height + sec_height < (fill_height - (3 * sec_height)) && r_secs < 5) {
        $(repeat).each(function(s) {
                           $('#cl_bleft').append('<pre>' + repeat[s] + '</pre>');
                           $('#cl_bright').append('<pre>' + repeat[s] + '</pre>');
                       });
        cur_height += sec_height;
        r_secs++;
    }
    cur_height_left = cur_height;

    while(cur_height + sec_height < fill_height && r_secs < 9) {
        $(repeat).each(function(s) {
                           $('#cl_bright').append('<pre>' + repeat[s] + '</pre>');
                       });
        cur_height += sec_height;
        r_secs++;
    }

    $('#cl_bleft_spacer').height(fill_height - cur_height_left);
    $('#cl_bright_spacer').height(fill_height - cur_height);

    $('#cl_fleft').append('<pre>' + foot_l[0] + '</pre>');
    $('#cl_ileft').append('<pre>' + foot_l[1] + '</pre>');
    $('#cl_fright').append('<pre>' + foot_r[0] + '</pre>');
    $('#cl_iright').append('<pre>' + foot_r[1] + '</pre>');

    if($('#cl_flash').text() == '') $('#cl_flash').text('hit tab to grab input');

}

function test() {

}

function cli_key(e) {
    $('#cl_flash').text(e.keyCode);
}

$(document).ready(function() {
    $('#cli').bind('keyup', function(e) {
                       cli_key(e);
                   });
    decorate();
    $(window).resize(function() {
                         decorate();
                     });
});