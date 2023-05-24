/*
 * versions 1.0.0
 * */
jQuery(document).ready(function(){

    /**
     * get plugin dir from PHP and use it in JS
     */
     var web2smsPluginUrl = web2sms_data.plugin_url;
        
    jQuery("#btn_pending").click(function(){
        pendingStr = jQuery('#wc_settings_web2sms_pending_text').val();
        if(isEmpty(pendingStr)) {
            console.log('Is empty');
            toastr.error('Please, enter a SMS content for pending status!', 'Error!');
            return false;
        }
        
        isStandard = isStandardTxt(pendingStr);
        smsCalculation(pendingStr, isStandard, web2smsPluginUrl);
    });

    jQuery("#btn_onhold").click(function(){
        pendingStr = jQuery('#wc_settings_web2sms_on-hold_text').val();
        if(isEmpty(pendingStr)) {
            console.log('Is empty');
            toastr.error('Please, enter a SMS content for On-Hols status!', 'Error!');
            return false;
        }
        
        isStandard = isStandardTxt(pendingStr);
        smsCalculation(pendingStr, isStandard, web2smsPluginUrl);
    });
    
    jQuery("#btn_failed").click(function(){
        pendingStr = jQuery('#wc_settings_web2sms_failed_text').val();
        if(isEmpty(pendingStr)) {
            console.log('Is empty');
            toastr.error('Please, enter a SMS content for failed status!', 'Error!');
            return false;
        }
        
        isStandard = isStandardTxt(pendingStr);
        smsCalculation(pendingStr, isStandard, web2smsPluginUrl);
    });
    
    jQuery("#btn_processing").click(function(){
        pendingStr = jQuery('#wc_settings_web2sms_processing_text').val();
        if(isEmpty(pendingStr)) {
            console.log('Is empty');
            toastr.error('Please, enter a SMS content for processing status!', 'Error!');
            return false;
        }
        
        isStandard = isStandardTxt(pendingStr);
        smsCalculation(pendingStr, isStandard, web2smsPluginUrl);
    });
    
    jQuery("#btn_cancelled").click(function(){
        pendingStr = jQuery('#wc_settings_web2sms_cancelled_text').val();
        if(isEmpty(pendingStr)) {
            console.log('Is empty');
            toastr.error('Please, enter a SMS content for cancelled status!', 'Error!');
            return false;
        }
        
        isStandard = isStandardTxt(pendingStr);
        smsCalculation(pendingStr, isStandard, web2smsPluginUrl);
    });
    
    jQuery("#btn_completed").click(function(){
        pendingStr = jQuery('#wc_settings_web2sms_completed_text').val();
        if(isEmpty(pendingStr)) {
            console.log('Is empty');
            toastr.error('Please, enter a SMS content for completed status!', 'Error!');
            return false;
        }
        
        isStandard = isStandardTxt(pendingStr);
        smsCalculation(pendingStr, isStandard, web2smsPluginUrl);
    });
    
    jQuery("#btn_refunded").click(function(){
        pendingStr = jQuery('#wc_settings_web2sms_refunded_text').val();
        if(isEmpty(pendingStr)) {
            console.log('Is empty');
            toastr.error('Please, enter a SMS content for refunded status!', 'Error!');
            return false;
        }
        
        isStandard = isStandardTxt(pendingStr);
        smsCalculation(pendingStr, isStandard, web2smsPluginUrl);
    });
    
    jQuery("#btn_reminder").click(function(){
        pendingStr = jQuery('#wc_settings_web2sms_reminder_text').val();
        if(isEmpty(pendingStr)) {
            console.log('Is empty');
            toastr.error('Please, enter a SMS content for Abandoned cart!', 'Error!');
            return false;
        }
        
        isStandard = isStandardTxt(pendingStr);
        smsCalculation(pendingStr, isStandard, web2smsPluginUrl);
    });

    jQuery("#show_documention").click(function(){
        web2smsDocumention(web2smsPluginUrl);
    });
});

/**
 * Calculate Nr of SMS
 */
function smsCalculation(str, isStandard, web2smsPluginUrl) {
    var maxSizeStandard          = 160; // Max Character in standard            | (140*8)/7
    var maxSizeNoneStandard      = 70;  // Max Character in none standard       | (140*8)/16
    var maxSpilitSizeStandard    = 153; // Max Character in split Standard      | ((140-6)*8)/7
    var maxSplitSizeNoneStandard = 67;  // Max Character in split none standard | ((140-6)*8)/16


    if(isStandard) {
        if(str.length <= maxSizeStandard) {
            // Calculate by 160
            smsNr = 1;
        } else {
            // Calculate by 153
            smsNr = Math.ceil(str.length / maxSpilitSizeStandard);
        }
    } else {
        if(str.length <= maxSizeNoneStandard) {
            // Calculate by 70
            smsNr = 1;
        } else {
            // Calculate by 67
            smsNr = Math.ceil(str.length / maxSplitSizeNoneStandard);
        }
    }
   
    var data = {
        'action': 'web2sms_sms_content_calculation',
        'str': str
    };
    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
    jQuery.post(ajaxurl, data, function(response) {
        tb_show("Mobile view", "../"+web2smsPluginUrl+"src/devicesViewCellPhone.php?TB_iframe=true&width=400&height=770");
    });

    var smsLengthNote = "";
    if(isStandard) {
        smsLengthNote = "(Max 160 character per SMS)";
    } else {
        smsLengthNote = "(Max 70 character per SMS)";
    }

    toastr.success('<b>SMS length</b>: ~'+ str.length + '<br><b>Standard Text</b> : ' + isStandard + '<br><b>SMS nr</b> : ~' + smsNr + '<br>'+ smsLengthNote +'</br>');
    
}

function isStandardTxt(str) {
    for (var i = 0; i < str.length; i++) {
        if(!isGsm7bit(str.charAt(i))) {
            return false;
        }
    }
    return true;
  }

function isGsm7bit(letter) {
    gsm = "@£$¥èéùìòÇØøÅåΔ_ΦΓΛΩΠΨΣΘΞ^{}\[~]|€ÆæßÉ!\"#¤%&'()*+,-./0123456789:;<=>?¡ABCDEFGHIJKLMNOPQRSTUVWXYZÄÖÑÜ§¿abcdefghijklmnopqrstuvwxyzäöñüà ";
    var letterInAlfabet = gsm.indexOf(letter) !== -1;
    return(letterInAlfabet);
}

/**
 * Check if variable is null | Undefine | Empty 
 */
function isEmpty(val){
    return (val === undefined || val == null || val.length <= 0) ? true : false;
}

function web2smsDocumention(web2smsPluginUrl) {
    tb_show("Documention", "../"+web2smsPluginUrl+"src/web2smsDocumention.php?TB_iframe=true&width=700&height=770");
}
