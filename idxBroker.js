jQuery(document).ready(function(){
    
    // ajax loading gif
    var ajax_load = "<span class='ajax'></span>";
    
    // path to the admin ajax file
    var ajaxPath = jQuery('#saveChanges').attr('ajax');
    
    // url of the blog
    var blogUrl = jQuery('#blogUrl').attr('ajax');
    
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
        
        if(submit == true){
            
            var status = jQuery(this).siblings('.status')

            // give the user a pseudo status console so they know something is happening
            status.fadeIn('fast').html(ajax_load+'Saving Links...');
    
            // need to get the custom links from the form, if any

            if(jQuery('.customLink').size() > 0){
                jQuery('.customLink').each(function(){
                    var linkName = jQuery(this).attr('name');
                    var linkState = jQuery(this).is(':checked');
                    var linkUrl = jQuery(this).attr('url');
                    var jsonObjCustom = ({"action":"idxUpdateCustomLinks","name":linkName,"state":linkState,"url":linkUrl});
        
                    jQuery.getJSON(ajaxPath,jsonObjCustom,function(data){
                        }
                    );
                });
            }
            
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
            var sitemapLink = jQuery('.idx_broker_sitemapLink').is(':checked');
            var userSignupLink = jQuery('.idx_broker_userSignupLink').is(':checked');
            var mortgageCalcLink = jQuery('.idx_broker_mortgageCalcLink').is(':checked');
            var suppListingsLink = jQuery('.idx_broker_suppListingsLink').is(':checked');
            var agentLoginLink = jQuery('.idx_broker_agentLoginLink').is(':checked');
            
            var jsonObj = {"action":"idxUpdateLinks","basicLink":basicLink,"advancedLink":advancedLink,"mapLink":mapLink,"addressLink":addressLink,"listingLink":listingLink,"featuredLink":featuredLink,"soldPendLink":soldPendLink,"openHouseLink":openHouseLink,"contactLink":contactLink,"rosterLink":rosterLink,"listManLink":listManLink,"homeValLink":homeValLink,"sitemapLink":sitemapLink,"userSignupLink":userSignupLink,"mortgageCalcLink":mortgageCalcLink,"suppListingsLink":suppListingsLink,"agentLoginLink":agentLoginLink};
    
            jQuery.getJSON(ajaxPath,jsonObj,function(data){
                    status.fadeIn('fast').html(ajax_load+'Saving Options...');
                    jQuery('#idxOptions').submit();
                }
            );
        }
    });
    
    // select/deselect all link functionality
    
    jQuery('#idx_ml_group').click(function(event){
        jQuery('.idx_ml').attr('checked', jQuery(this).is(':checked'));
    });

    jQuery('#idx_cl_group').click(function(event){
        jQuery('.idx_cl').attr('checked', jQuery(this).is(':checked'));
    });
    
});