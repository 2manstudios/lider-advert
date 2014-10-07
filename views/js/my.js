jQuery(function ($) { 
    
   var url = 'http://ads.pricesale.com.ua';
    
   $("#town").change(function ()  { 
       
        $('#micro').html('');
        $('#micro').hide();
       
        $.get(url+"/index.php?do=api&type=micro&id="+$('#town option:selected').val(), { } )
              .done(function( data ) {
                  if(data) {
                      $('#micro').html(data);
                      $('#micro').show();
                  }
          }); 
        
   });
   
   $("#region").change(function ()  { 
       
       $('#district').html('');
       $('#district').hide();
       $('#street').html('');
       $('#street').hide();
       $('#micro').html('');
       $('#micro').hide();
       $('#town').html('');
       $('#town').hide();
       
        $.get(url+"/index.php?do=api&type=district&id="+$('#region option:selected').val(), { } )
             .done(function( data ) {
                 if(data) {
                     $('#district').html(data);
                     $('#district').show();
                 }
         });

        $.get(url+"/index.php?do=api&type=street&id="+$('#region option:selected').val(), { } )
             .done(function( data ) {
                 if(data) {
                     $('#street').html(data);
                     $('#street').show();
                 }
         });
       
   });
   
   $("#district").change(function ()  { 
                 
       $('#town').html('');
       $('#town').hide();       
       $('#micro').html('');
       $('#micro').hide();
       
        $.get(url+"/index.php?do=api&type=town&id="+$('#district option:selected').val(), { } )
            .done(function( data ) {
                if(data) {
                    $('#town').html(data);
                    $('#town').show();
                }
        });
       
   });
   
   
});
 