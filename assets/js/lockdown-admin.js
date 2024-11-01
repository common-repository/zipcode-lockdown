jQuery(document).ready( function( $ ){
    var lockBtn = $('#zcld-btn');
    var lockInput = $('#cst-zcld-textarea');
    lockBtn.click(function(){
        lockInput[0].value = '';
    });
});