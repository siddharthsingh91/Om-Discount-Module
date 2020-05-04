jQuery(document).ready(function(e) {
    //checkMaxNoCart();

    jQuery('.addtocartbutton span').click(function(e) {
    
      //checkMaxNoCart();
      jQuery("#top-menu").hide();  
      jQuery("#page-container").css({'visibility':'hidden'}); 
      jQuery("body").append("<div id=\"load-message\"><p>Wait System Calculating....</p></div>"); 
      var om_pro_pri = jQuery(this).parent().find('input').attr('price');
      var om_pro_id = jQuery(this).parent().find('input').attr('id');
      var om_pro_qunt = jQuery(this).parent().find('input').val();


      console.log(om_pro_pri);
      console.log(om_pro_id);
      console.log(om_pro_qunt);
      

      var data = {
        action: 'add_foobar',
        om_pro_pri: om_pro_pri,
        om_pro_id : om_pro_id,
        om_pro_qunt : om_pro_qunt
    };
    
    jQuery.ajax({
    url : add_to_cart.ajaxurl, //ajax object of localization
    type : 'post', //post method to access data
    data : 
    {
        action : 'add_foobar', //action on prefix_ajax_add_foobar function
        om_pro_pri: om_pro_pri,
        om_pro_id : om_pro_id,
        om_pro_qunt : om_pro_qunt
    },

    success : function(response){
        jQuery(window).scrollTop(jQuery('.new-bar-discount').offset().top - 200);
        //var scrollPos =  jQuery(".new-bar-discount").offset().top;
        //jQuery(window).scrollTop(scrollPos);
        //jQuery(window).scrollTop(jQuery('#post-2178').offset().top + 400);
		    jQuery("#load-message").remove(); 
            jQuery("#page-container").css({'visibility':'visible'});
            jQuery("#top-menu").show(); 
            jQuery('.new-bar-discount').html(response);			
            console.log("Product Added successfully..");        
    }

});

return false;
});
});


function checkMaxNoCart(){
var pro_qunt = 0 
jQuery( ".pro_quant_input" ).each(function() {
     pro_qunt = pro_qunt + parseInt(jQuery( this ).val());
});
console.log(pro_qunt);



if(pro_qunt <= 6){
var maxLimit = 6-pro_qunt
jQuery( ".pro_quant_input" ).each(function() {
    var thisProMax = parseInt(jQuery( this ).val()) + maxLimit;
    jQuery( this ).attr('max',thisProMax);
});
}
}