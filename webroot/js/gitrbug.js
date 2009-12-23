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
        '         .db  .d8            .d8                        ',
        '         dP"  d88            d88                        ',
        '         "    888.           888.                       ',
        '  .d88b.  .d8 88888P .d8d88b 88888b.  .d8  .d8  .d88b.  ',
        ' d88P"88b d88 88P"   d88P"   888 "88b 888  d88 d88P"88b ',
        ' 888  888 888 888    888     888 .888 888. 888 888  888 ',
        ' Y88b 888 888 Y88b.  888     Y88 d88P Y88b d88.Y88b 888 ',
        '  "Y88888 8P"  "Y88b 8P"     "Y888P"   "Y88888b."Y88888 ',
        '     "888                                          "888 ',
        ' Y8b.d88P                                      Y8b.d88P ',
        '  "Y88P"                                        "Y88P"  '
    ];

    $('pre').remove();

    fill_height = $('#cl_bleft').height();

    $(banner).each(function (s) {
                       $('#cl_header').append('<pre>' + banner[s] + '</pre>');
                   });

    cwrite(head, '#cl_bright');

    $(head).each(function (s) {
                     $('#cl_bleft').append('<pre>' + head[s] + '</pre>');
                 });

    sec_height = $('#cl_bleft').children('pre').height() * 3;
    cur_height = sec_height;

    r_secs = 0;
    while(cur_height + sec_height < (fill_height - (3 * sec_height)) && r_secs < 5) {
        cwrite(repeat, '#cl_bleft');
        cwrite(repeat, '#cl_bright');
        cur_height += sec_height;
        r_secs++;
    }
    cur_height_left = cur_height;

    while(cur_height + sec_height < fill_height && r_secs < 9) {
        cwrite(repeat, '#cl_bright');
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


cw_colors = {
    "34D1B2": ['5ED1BA','DEEDD0','FFFFFF'], // 1
    "5ED1BA": ['34D1B2','FFFFFF'], // 2
    "D0DEDD": ['5ED1BA','DEEDD0','FFFFFF','FFF7CB','D0DEDD'], // 4
    "DEEDD0": ['34D1B2','D0DEDD','FFF7B8','FFF7CB'], // 5
    "FFA100": ['FFFA73','FFD1BA'], // 7
    "FFD1BA": ['FFF7B8'], // 8
    "FFF7B8": ['FFD1BA','FFF7CB','FFFA73','FFA100','FFFFFF'], // 9
    "FFF7CB": ['FFF7B8','FFFA73','FFD1BA','D0DEDD','FFFFFF','FFF7CB'], // 10
    "FFFA73": ['FFF7CB','FFFFFF','FFA100','FFFA73'], // 11
    "FFFFFF": ['FFFA73','D0DEDD','DEEDD0','FFF7CB','FFFFFF'] // 12

}
color = 'FFFFFF';

function cwrite(data, target) {
    cline = '';

    $(data).each(function (s) {
                     cline = cline + '<pre><span style="color:#' + color + ';">';
                     c = 0;
                     while(c < data[s].length) {
                         dr = Math.floor(Math.random() * 8);
                         dc = data[s][c];
                         if(dr == 1) {
                             newcolor_n = Math.floor(Math.random() * cw_colors[color].length);
                             color = cw_colors[color][newcolor_n];
                             cline = cline + '</span><span style="color:#' + color + ';">' + dc;
                         } else {
                             cline = cline + dc;
                         }
                         c++;
                     }
                 });

    cline = cline + '</span></pre>';
    $(target).append(cline);
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