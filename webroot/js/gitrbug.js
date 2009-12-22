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

    banner = [
        '##         .db .d8                .d8                         ',
        '#          dP" d88                d88                         ',
        '#              888.               888.                        ',
        '#  .d88b.  .d8 88888P   .d8d88b   88888b.  .d8  .d8   .d88b.  ',
        '# d88P"88b d88 88P"     d88P"     888 "88b 888  d88  d88P"88b ',
        '# 888  888 888 888      888       888  888 888  888  888  888 ',
        '# Y88b 888 888 Y88b.    888       Y88 d88P Y88b d88. Y88b 888 ',
        '#  "Y88888 8P"  "Y88b   8P"       "Y888P"   "Y88888b. "Y88888 ',
        '#      888                                                888 ',
        '# Y8b d88P                                           Y8b d88P ',
        '#  "Y88P"                                             "Y88P"  '
    ];

    $('pre').remove();

    fill_height = $('#cl_bleft').height();

    /*
    $(banner).each(function (s) {
                       $('#cl_header').append('<pre>' + banner[s] + '</pre>');
                   });
    */
    
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