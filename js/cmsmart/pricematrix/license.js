$j = jQuery.noConflict();

function block(){
    $j("input[id^='pricematrix'],textarea[id^='pricematrix'],select[id^='pricematrix'],button[id^='pricematrix']").prop('disabled', true);
//    $j("textarea[id^='pricematrix']").prop('disabled', true);
//    $j("select[id^='pricematrix']").prop('disabled', true);
//    $j("button[id^='pricematrix']").prop('disabled', true);


    $j("[id*='cmsmart_license_skuproduct'],[id*='cmsmart_license_key'],[id*='cmsmart_license_domain']").prop('disabled', false);
//    $j("[id*='cmsmart_license_key']").prop('disabled', false);
//    $j("[id*='cmsmart_license_domain']").prop('disabled', false);
}
function active(){
    $j("input[id^='pricematrix'],textarea[id^='pricematrix'],select[id^='pricematrix'],button[id^='pricematrix']").prop('disabled', false);
//    $j("textarea[id^='pricematrix']").prop('disabled', false);
//    $j("select[id^='pricematrix']").prop('disabled', false);
//    $j("button[id^='pricematrix']").prop('disabled', false);


    $j("[id*='cmsmart_license_skuproduct'],[id*='cmsmart_license_key'],[id*='cmsmart_license_domain']").prop('disabled', false);
//    $j("[id*='cmsmart_license_key']").prop('disabled', false);
//    $j("[id*='cmsmart_license_domain']").prop('disabled', false);
}



$j(window).load(function(){
    
    var root = location.protocol + '//' + location.host;
    //Cmsmart("[name='jform[params][domain]']").val(root);     
    var action_url = 'http://cmsmart.net/index.php?option=com_license&task=active';
    var product_sku = $j("[name='groups[cmsmart][fields][license_skuproduct][value]']").val();
    var license_key = $j("[name='groups[cmsmart][fields][license_key][value]']").val();
    var domain = $j("[name='jform[params][domain]']").val();
    $j('#orderupload_cmsmart').append(
    '<div style="margin-top: 28px; position: relative" class="comment">'+
    '<img style="margin-right: 18px; float: left" src="http://magento-australia.com/demo/logo-about-us.png" />'+
    '<h2 style="color: #3d7aac; font-weight: normal; font-family: Arial">About Cmsmart</h2>'+
    '<div class="cmsmart-description">'+
    '<p>Cmsmart.net is a Special Devision of NetBase JSC, a Vietnam Software Outsourcing Company established by a group of three software and internet experts. We have been working in software outsourcing market since 2005. Looking forward to develop better software solutions toward web base application, we decide to officially open the outsourcing software company and located the headquarter office in Hanoi, the dynamic developing capital of Vietnam.</p>'+
    '<p>Developing +300 Magento and Virtuemart project sinces 2007, Netbase team has extensive experience on this powerfull ecommercial CMS. From 2011 we officially open Netbase JSC, base in Hanoi, Vietnam and supply Commercial Virtuemart and Magento add-on on Cmsmart.net</p>'+
    '</div>'+
    '<div class="cmsmart-contact">'+
    '<p>If you are looking to visit our office, the here is the address:</p>'+
    '<p>Netbase JSC.,</p>'+
    '<p>Address: A702, M3M4 Building, Nguyen Chi Thanh Street, Dong Da, Hanoi</p>'+
    '<p>Company Tax ID: 0105951482</p>'+
    '</div>'+
    '<ul style="list-style-type:disc;" class="cmsmart-links">'+
    '<li style="color: #218bca"><a style="color: #218bca; text-decoration: none" href="http://virtuemart-extensions.cmsmart.net/virtuemart-extensions" target="_blank">Virtuemart Extensions</a></li>'+
    '<li style="color: #218bca"><a style="color: #218bca; text-decoration: none" href="http://virtuemart-templates.cmsmart.net/virtuemart-templates" target="_blank">Virtuemart Templates</a></li>'+
    '<li style="color: #218bca"><a style="color: #218bca; text-decoration: none" href="http://magento-themes.cmsmart.net/magento-themes" target="_blank">Magento Themes</a></li>'+
    '<li style="color: #218bca"><a style="color: #218bca; text-decoration: none" href="http://magento-extensions.cmsmart.net/magento-extensions" target="_blank">Magento Extensions</a></li>'+
    '<li style="color: #218bca"><a style="color: #218bca; text-decoration: none" href="http://cloodo.com/projects/cmsmart-support" target="_blank">Technical Support</a></li>'+
    '<li style="color: #218bca"><a style="color: #218bca; text-decoration: none" href="http://bloorum.com/" target="_blank">Forum</a></li>'+
    '</ul>'+
    '<img style="position: absolute; bottom: 0; right: 0" src="http://magento-australia.com/demo/cmsmart-logo.png" />'+
    '</div>'	
    );

    $j.ajax({
        type: 'POST',
        url: action_url,
        data: 'license[product_sku]='+product_sku+'&license[license_key]='+license_key+'&license[domain]='+domain,       
        dataType: 'json',
        beforeSend: function(){
            $j('#ajax-loader').fadeIn("fast");
            },
        success: function(html){
            $j('#ajax-loader').fadeOut("fast");
            $j('#license-messages').text('');
            Cmsmartstr = '';
            if(html.result == true){
                Cmsmartstr = '<span style="color:green; font-weight: bold" class="license-messages-success">'+html.data+'</span>';
                active();
            }else{
                Cmsmartstr = '<span style="color:red; font-weight: bold" class="license-messages-fail">'+html.data+'</span>';
                block();
            }
            $j('#license-messages').text('');
            $j('#license-messages').append(Cmsmartstr);
            },
            error:function()
            {
                $j('#ajax-loader').fadeOut("fast");
                $j('#license-messages').text('');
                $j('#license-messages').append(Cmsmartstr);
            }
    });


    $j('.scalable').click(function(){
    
        var product_sku = $j("[name='jform[params][product_sku]']").val();
        var license_key = $j("[name='jform[params][license_key]']").val();
        var domain = $j("[name='jform[params][domain]']").val();

        $j.ajax({
            type: 'POST',
            url: action_url,
            data: 'license[product_sku]='+product_sku+'&license[license_key]='+license_key+'&license[domain]='+domain,
            dataType:'json',
            beforeSend: function(){
                $j('#ajax-loader').fadeIn("fast");
            },

            success: function(html){
                $j('#ajax-loader').fadeOut("fast");
                $j('#license-messages').text('');
                //Cmsmart('#license-messages').append(html.data);
                Cmsmartstr = '';
                if(html.result == true){
                    Cmsmartstr = '<span style="color:green; font-weight: bold" class="license-messages-success">'+html.data+'</span>';
                    active();
                }else{
                    Cmsmartstr = '<span style="color:red; font-weight: bold" class="license-messages-fail">'+html.data+'</span>';
                    block();
                }
                $j('#license-messages').text('');
                $j('#license-messages').append(Cmsmartstr);
            },

            error:function(){
                $j('#ajax-loader').fadeOut("fast");
                $j('#license-messages').text('');
                $j('#license-messages').append(Cmsmartstr);
            }
        });       
   
   });   
    
   
});



