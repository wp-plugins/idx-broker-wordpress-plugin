jQuery(document).ready(function(){
    
    // ajax loading gif
    var ajax_load = "<img src='/images/ajax-loader.gif' />";
    
    // path to the admin ajax file
    var ajaxPath = jQuery('#saveChanges').attr('ajax');
    
    // url of the blog
    var blogUrl = jQuery('#blogUrl').attr('ajax');
    
    // expand collapse the advanced section
    
    jQuery('.expand').attr({ title: "Click to Expand/Collapse" });
    
    jQuery('.expandable').click(function() {
        var content = jQuery(this).find('.expand').html();
        jQuery(this).next().slideToggle('fast');
        if (content == '[+]') {
            jQuery(this).find('.expand').html('[-]');
        } else {
            jQuery(this).find('.expand').html('[+]');
        }
    });
    
    // when the save changes button is clicked

    jQuery('#saveChanges').click(function(event){

        // prevent the default action as we need to save the links to the db first.
        event.preventDefault();
        
        var cid = jQuery('#idx_broker_cid').val();
        var pass = jQuery('#idx_broker_pass').val();
        var domain = jQuery('#idx_broker_domain').val();
        
        var submit = true;
        
        if (cid == '') {
            jQuery('#idx_broker_cid').parents('li').css('background', '#FDB7B7');
            submit = false;
        } else {
            jQuery('#idx_broker_cid').parents('li').css('background', 'none');
        }
        if (pass == '') {
            jQuery('#idx_broker_pass').parents('li').css('background', '#FDB7B7');
            submit = false;
        } else {
            jQuery('#idx_broker_pass').parents('li').css('background', 'none');
        }
        if (domain == '') {
            jQuery('#idx_broker_domain').parents('li').css('background', '#FDB7B7');
            submit = false;
        } else {
            jQuery('#idx_broker_domain').parents('li').css('background', 'none');
        }
        
        // place a typical ajax loading gif on the screen so the user knows that something is actually happening

        // give the user a pseudo status console so they know something is happening
        var status = jQuery(this).siblings('.status')
        status.fadeIn('fast').html(ajax_load+'Saving Links...');

        // need to get the custom links from the form, if any

        jQuery('.customLink').each(function(){
            var linkName = jQuery(this).attr('name');
            var linkState = jQuery(this).is(':checked');
            var linkUrl = jQuery(this).attr('url');
            var jsonObjCustom = ({"action":"idxUpdateCustomLinks","name":linkName,"state":linkState,"url":linkUrl});

            jQuery.getJSON(ajaxPath,jsonObjCustom,function(data){
                }
            );
        });
        
        //here are the states of the checkboxes
        var basicLink = jQuery('.idx_broker_basicSearchLink').is(':checked');
        var advancedLink = jQuery('.idx_broker_advancedSearchLink').is(':checked');
        var mapLink = jQuery('.idx_broker_mapSearchLink').is(':checked');
        var addressLink = jQuery('.idx_broker_addressSearchLink').is(':checked');
        var listingLink = jQuery('.idx_broker_listingSearchLink').is(':checked');
        var featuredLink = jQuery('.idx_broker_featuredLink').is(':checked');
        var soldPendLink = jQuery('.idx_broker_soldPendLink').is(':checked');
        var openHouseLink = jQuery('.idx_broker_openHousesLink').is(':checked');
        var contactLink = jQuery('.idx_broker_contactLink').is(':checked');
        var rosterLink = jQuery('.idx_broker_rosterLink').is(':checked');
        var listManLink = jQuery('.idx_broker_listManLink').is(':checked');
        var homeValLink = jQuery('.idx_broker_homeValLink').is(':checked');
        
        var jsonObj = {"action":"idxUpdateLinks","basicLink":basicLink,"advancedLink":advancedLink,"mapLink":mapLink,"addressLink":addressLink,"listingLink":listingLink,"featuredLink":featuredLink,"soldPendLink":soldPendLink,"openHouseLink":openHouseLink,"contactLink":contactLink,"rosterLink":rosterLink,"listManLink":listManLink,"homeValLink":homeValLink};

        jQuery.getJSON(ajaxPath,jsonObj,function(data){
                status.fadeIn('fast').html(ajax_load+'Saving Options...');
                jQuery('#idxOptions').submit();
            }
        );
        
    });
    
    jQuery('#clearLinks').click(function(event){
        
        event.preventDefault();
        
        var status = jQuery(this).siblings('.status')
        status.fadeIn('fast').html(ajax_load+'Cleaning Links...');
        
        jQuery.get(
            ajaxPath,
            {
                "action": "idx_clearCustomLinks"
            },
            function(responseText){
                alert('All old links that are no longer in the IDX Broker Admin area have been removed from your navigation.')
                status.fadeOut();
                jQuery('#idxOptions').submit();	
            }
        );
            
    });
    
    // fire the update wrapper function
    
    jQuery('#updateWrapper').click(function(event){
        
        event.preventDefault();
        var blogUrl = jQuery(this).attr('ajax') + '/';
        var choice = jQuery('#wrapperOption').val();
        
        if(choice == 'echoCode'){
            var message = "Generating Code...";
        } else if (choice == 'writeCode'){
            var message = "Updating Wrapper...";
        }
        
        jQuery('#wrapperStatus').fadeIn('fast').html(ajax_load+message);

        jQuery.get(
            ajaxPath,
            {
                "action": "idxUpdateWrapper",
                "method": choice,
                "url": blogUrl
            },
            function(responseText){
                
                if(responseText != '0'){
                    
                    if(choice == 'echoCode'){
                        
                        jQuery('#wrapperStatus').html('Code Generated!').css('color', 'green');
                        jQuery('#echoedCode').html(responseText.substring(0,responseText.length-1));
                        
                    } else if (choice == 'writeCode'){
                        
                        jQuery('#wrapperStatus').html('Files Written!').css('color', 'green');
                        
                    }
 
                } else {
                    
                    jQuery('#wrapperStatus').html('!Error <a href="http://www.idxbroker.com/support/kb/questions/291/">How do I fix this?</a>').css('color', 'red');
                    
                }
            }
        );
    });
    
    // user choice on wrapper method
    
    jQuery('#wrapperOption').change(function(){
       var choice = jQuery(this).val();
       
       if(choice == 'echoCode'){
            jQuery('#echoStep').fadeIn();
            jQuery('#writeStep').fadeOut();
       } else if (choice == 'writeCode'){
            jQuery('#writeStep').fadeIn();
            jQuery('#echoStep').fadeOut();
       }
       
    });
    
});