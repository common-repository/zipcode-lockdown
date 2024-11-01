jQuery(document).ready(function( $ ) {
    var zipcodes = cst_zcld_params.zipcodes;
    //var customLogo = cst_zcld_params.logo;
    var page_id = cst_zcld_params.page_id;
    //var cslogo = cst_zcld_params.cslogo;
    var header = $('header');
    var content = $('div#content');
    var footer = $('footer');
    var page = $('body');
    var sess = sessionStorage;
    var output =    '<div id="zipcode-lockdown">';
        output +=       '<div id="lockdown-check-wrapper">';
        output +=           '<div id="lockdown-check">';
        output +=               '<div id="lockdown-inner-wrapper">';
        output +=                   '<div id="lockdown-header-wrapper">';
        output +=                       '<div id="lockdown-header-div">';
        output +=                           '<h2 id="lockdown-header">Zipcode Check</h2>';
        output +=                       '</div>';
        output +=                       '<div id="lockdown-subheader-div">';
        output +=                           '<span id="lockdown-subheader">Please enter your zipcode to view this page.</span>';
        output +=                       '</div>';
        output +=                   '</div>';
        output +=                   '<div id="lockdown-form-wrapper">';
        output +=                       '<div id="lockdown-input-wrapper">';
        output +=                           '<input id="lockdown-input" type="text" size="15" maxlength="5" placeholder="03801"></input>';
        output +=                       '</div>';
        output +=                       '<div id="lockdown-button-wrapper">';
        output +=                           '<a id="lockdown-button" class="lockdown-btn">Let&#039;s Go!</a>';
        output +=                       '</div>';
        output +=                   '</div>';
        output +=                   '<div id="lockdown-status-wrapper">';
        output +=                       '<div id="lockdown-status-div">';
        output +=                           '<span id="lockdown-status"></span>';
        output +=                       '</div>';
        output +=                   '</div>';
        output +=               '</div>';
        output +=           '</div>';
        output +=       '</div>';
        output +=   '</div>';
    
    function cst_zcld_zip_true(val){
        var unzip = new Promise(function(resolve, reject){
            var zipWrap = $('#zipcode-lockdown');
            resolve(zipWrap);
        });
        
        unzip.then(function(obj){
            obj.fadeOut(500, function(){
                obj.hide();
                header.fadeIn(300);
                content.fadeIn(300);
                footer.fadeIn(300);
            });
            return obj;
        }).then(function(){
            cst_zcld_set_zip_cache(val);
            return;
        });
    }
    function cst_zcld_zip_false(inpt){
        var statusSpan = $('#lockdown-status');
        statusSpan.html('Sorry, this page is not available based on the zipcode you entered.');
        inpt[0].value = '';
        statusSpan.animate({'opacity': 1}, 300);
    }
    function cst_zcld_get_zip_cache(){
        var zipSess = sess.getItem('zcld');
        if ( zipSess != null && zipcodes.search(zipSess) >= 0 ) {
            return true;
        } else {
            return false;
        }
    }
    function cst_zcld_set_zip_cache(val){
        sess.setItem('zcld', val);
    }
    
    var promise = new Promise(function(resolve, reject){
        if ( cst_zcld_get_zip_cache() == false ){
            header.fadeOut(500);
            content.fadeOut(500);
            footer.fadeOut(500);
            resolve(page);
        } else {
            var msg = 'User entered a matching zipcode';
            reject(msg);
        }
    });
    
    promise.then(function(){
        header.hide();
        content.hide();
        footer.hide();
        return page;
    }).then(function(obj){
        obj.prepend(output);
        return obj;
    }).then(function(obj){
        var lockBtn = $('.lockdown-btn');
        var lockClick;
        lockBtn.click(function(){
            lockClick = function(){
                var lockInput = $('#lockdown-input');
                var lockVal = lockInput[0].value;
                var zipFound = zipcodes.search(lockVal);
                console.log(zipFound);
                if (lockVal != '' && zipFound >= 0){
                    cst_zcld_zip_true(lockVal);
                } else if (lockVal != '' && zipFound == -1){
                    cst_zcld_zip_false(lockInput);
                }
            };
            lockClick();
        });
        return lockClick;
            
    }).catch(function(err){
        console.log(err);
    });
    
    

});