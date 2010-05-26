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
        jQuery(this).next().slideToggle('fast');
        var content = jQuery(this).find('.expand').html();
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
        
        // place a typical ajax loading gif on the screen so the user knows that something is actually happening

        // give the user a pseudo status console so they know something is happening
        var status = jQuery(this).siblings('.status')
        status.fadeIn('fast').html(ajax_load+'Saving Links...');

        // get info from the page so that we can build out our ajax request
        
        // here are the states of the checkboxes
        var basicLink = jQuery('.idx_broker_basicSearchLink').is(':checked');
        var advancedLink = jQuery('.idx_broker_advancedSearchLink').is(':checked');
        var mapLink = jQuery('.idx_broker_mapSearchLink').is(':checked');
        var addressLink = jQuery('.idx_broker_addressSearchLink').is(':checked');
        var listingLink = jQuery('.idx_broker_listingSearchLink').is(':checked');
        var featuredLink = jQuery('.idx_broker_featuredLink').is(':checked');
        var soldPendLink = jQuery('.idx_broker_soldPendLink').is(':checked');
        
        // here are the custom labels for the links
        var basicLabel = jQuery('.idx_broker_basicSearchLabel').val();
        var advancedLabel = jQuery('.idx_broker_advancedSearchLabel').val();
        var mapLabel = jQuery('.idx_broker_mapSearchLabel').val();
        var addressLabel = jQuery('.idx_broker_addressSearchLabel').val();
        var listingLabel = jQuery('.idx_broker_listingSearchLabel').val();
        var featuredLabel = jQuery('.idx_broker_featuredLabel').val();
        var soldPendLabel = jQuery('.idx_broker_soldPendLabel').val();

        // need to get the custom links from the form, if any
        
        var customLinksString = 'action=idxUpdateCustomLinks&';

        jQuery('.customLink').each(function(){
            var linkName = jQuery(this).attr('name');
            var linkState = jQuery(this).is(':checked');
            var linkUrl = jQuery(this).attr('url');
            customLinksString += linkName+'='+linkState+'&';
            customLinksString += linkName+'Url'+'='+linkUrl+'&';
        });
        
        customLinksString = customLinksString.substring(0, customLinksString.length-1);

        // place our ajax request
        jQuery.get(
            ajaxPath,
            {
                "action": "idxUpdateLinks",
                "basicLink": basicLink,
                "advancedLink": advancedLink,
                "mapLink": mapLink,
                "addressLink": addressLink,
                "listingLink": listingLink,
                "featuredLink": featuredLink,
                "soldPendLink": soldPendLink,
                "basicLabel": basicLabel,
                "advancedLabel": advancedLabel,
                "mapLabel": mapLabel,
                "addressLabel": addressLabel,
                "listingLabel": listingLabel,
                "featuredLabel": featuredLabel,
                "soldPendLabel": soldPendLabel
            },
            function(responseText){
                jQuery.get(
                    ajaxPath,
                    customLinksString,
                    function(responseText){
                        // when the ajax is complete, then change the state of the psuedo status console and submit the form like normal
                        status.html(ajax_load+'Saving Options...');
                        jQuery('#idxOptions').submit();	
                    }
                );

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
                alert(responseText);
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
        jQuery('#wrapperStatus').fadeIn('fast').html(ajax_load+'Updating Wrapper...');

        jQuery.get(
            ajaxPath,
            {
                "action": "idxUpdateWrapper",
                "url": blogUrl
            },
            function(responseText){
                
                if(responseText != '0'){
                    jQuery('#wrapperStatus').html('Verified!').css('color', 'green');
                } else {
                    jQuery('#wrapperStatus').html('!Error <a href="http://www.idxbroker.com/support/kb/questions/291/">How do I fix this?</a>').css('color', 'red');
                }
            }
        );
    });
});