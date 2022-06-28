(function( $ ) {
	'use strict';


        $(
		function() {

            var child = $('#jm_admin_helptext');
            var parent = $('input[name="jm-admin-helptip__switch"]');
  
            child.hide();
        
            if(parent.is(":checked")) {   
                child.show(); 
            } 
    
            parent.on('switchChange.bootstrapSwitch', function (event, state) {
              
             if(state)
              {
                child.show('slow'); 
              }
              else {
                child.hide('slow'); 
               
              }
            }); 
             

        }); 
     
 
})( jQuery );