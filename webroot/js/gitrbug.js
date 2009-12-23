function decorate() {
    head = [
        '  ; '  ,
        ',´ ;'  ,
        '`,´ '
    ];

    repeat = [
        '( ; '  ,
        ',´  '  ,
        '`,´ '
    ];

    foot_fl = ['( `+._,—('];
    foot_il = [' `+._,—´˙`— —._,—-('];

    foot_fr = [')-—._,-—´˙`—._,-—˙`+—._,-—´˙`-._,—-´˙`—._,+´ ) '];
    foot_ir = [')-._,-—´˙`—._,+´  '];

    banner = [
        '          ,db .d8            .d8                        ',
        '          d8b d83            d83                        ',
        '          "   834.           834.                       ',
        '  .d83b.  .d8 83438P .d8d83b 83438b.  .d8  .d8  .d83b.  ',
        ' d83P"38b d83 83P"   d83P"   834 "83b 834  d83 d83P"83b ',
        ' 834  438 834 834    834     834 .834 834. 834 834  834 ',
        ' Y83b 438 Y83 Y83b.  834     Y83 d83P Y83b d83.Y83b 834 ',
        '  "Y83438 "Y8  "Y83b 8P"     "Y834P"  "Y834438b."Y83438 ',
        '     "834                               """"       "834 ',
        ' Y8b.d83P                                      Y8b.d83P ',
        '  "Y83P"                                        "Y83P"  '
    ];

    $('pre').remove();

    buffer_height = $('#cl_bleft').height();

    $(banner).each(function (s) {
                       $('#cl_header').append('<pre>' + banner[s] + '</pre>');
                   });

    $(head).each(function (s) {
                     $('#cl_bleft').append('<pre>' + head[s] + '</pre>');
                 });

    sec_height = $('#cl_bleft').children('pre').height() * 3;
    cur_height = sec_height;
    cwrite(foot_fl, '#cl_fleft');
    cwrite(foot_il, '#cl_ileft');

    cwrite(head, '#cl_bright');

    r_secs = 0;
    while(cur_height + sec_height < (buffer_height - (3 * sec_height)) && r_secs < 5) {
        cwrite(repeat, '#cl_bleft');
        cur_height += sec_height;
        r_secs++;
    }
    cur_height_left = cur_height;

    for(i=0; i<r_secs; i++) {
        cwrite(repeat, '#cl_bright');
    }

    while(cur_height + sec_height < buffer_height && r_secs < 9) {
        cwrite(repeat, '#cl_bright');
        cur_height += sec_height;
        r_secs++;
    }

    $('#cl_bleft_spacer').height(buffer_height - cur_height_left);
    $('#cl_bright_spacer').height(buffer_height - cur_height);

    cwrite(foot_fr, '#cl_fright');
    cwrite(foot_ir, '#cl_iright');

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

function cli_key(e) {
    $('#cl_flash').text(e.keyCode);

    switch(e.keyCode) {
        case 13: // enter
//            buf_out($('#cli').val());
            $.post('/peers/cmd', { data: $('#cli').val() }, function(r) {
                       buf_out(r);
                   }, 'json');
            $('#cli').val('');
            break;
    } // pass everything else
}

buffer_height = 0;
scroll_position = 0;

function buf_out(s) {
    $('#cl_buffer').append("<p>" + s + "</p>");
    if(scroll_position > 0) $('#cl_buffer').children().last().hide();
    refresh_buffer();
}

function refresh_buffer() {
    c = $('#cl_buffer').children();
    i = c.length - scroll_position;
    if(i >= c.length) i = c.length-1;
    h = 0;

    while(i >= 0) {
        while(c.length - i <= scroll_position) {
            $(c[i]).hide();
            i = i-1;
        }

        if((h = h+$(c[i]).height()) < buffer_height) {
            $(c[i]).show();
            i = i-1;
        } else {
            while(i >= 0) {
                if($(c[i]).css('display') == "none") return true;
                $(c[i]).hide();
                i = i-1;
            }
        }
    }
}

$(document).ready(function() {
    $('#cli').bind('keyup', function(e) {
                       cli_key(e);
                   });
    decorate();
    $('#cl_buffer').bind('mousewheel', function(e, d) {
                             mdir = d>0?1:-1;
                             scroll_position = scroll_position + mdir;
                             mscroll = $('#cl_buffer').children(':hidden').length;
                             if(scroll_position < 0) scroll_position = 0;
                             if(scroll_position > mscroll) scroll_position = mscroll;
                             refresh_buffer();
                             return false;
                         });
    $(window).resize(function() {
                         decorate();
                     });
    $('#cli').focus();
    $('#cli').blur(function () { $(this).focus(); } );
});