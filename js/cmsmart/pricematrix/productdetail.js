jQuery(document).ready(function(){
	var checkWidth = jQuery(window).width();
	if(checkWidth > 768){
		jQuery('.td-hidden').tooltip({html:true});    
		jQuery('.td-hidden').tooltip();          
		jQuery('.td-hidden').on('hidden.bs.tooltip',  
		function() { 
		   jQuery(this).css("display", "");
		});
	}
    jQuery('#pricematrix-table tr td').click(function (){
        jQuery(this).children('input:radio').prop('checked', true).trigger('change');
        jQuery('#pricematrix-table tr td').removeClass("active");
        jQuery('#pricematrix-table tr td').removeClass("highlight");
        jQuery('#pricematrix-table tr').removeClass("active");
        var className = jQuery(this).attr('class');
        if(className){
            jQuery('#pricematrix-table tr td.' + className).addClass("active");
        }
        jQuery(this).parent('tr').addClass("active");
        jQuery(this).addClass('highlight');

        var range = jQuery(this).attr('data-range');
        jQuery('#qty').removeClass().addClass('input-text qty required-entry validate-digits-range digits-range-'+range);
		jQuery('#qty').attr("minmax", range);
		
		
        var min = jQuery(this).attr('data-minqty');
        jQuery('#qty').val(min);

		document.getElementById("custom_matrix_price").value = jQuery(this).text();
    });

});
