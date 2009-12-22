function test() {

}

function cli_key(e) {
    $('#cl_flash').text(e.keyCode);
}

$(document).ready(function() {
    $('#cli').bind('keyup', function(e) { cli_key(e); });
});
