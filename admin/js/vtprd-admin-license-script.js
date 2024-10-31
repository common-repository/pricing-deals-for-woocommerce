//****************************
// FILE CREATED V2.0.3
//****************************

     jQuery(document).ready(function($) {
            
         
            //****************************
            // Show Discount Where
            //****************************  
            
                          //first time in
                          screen_init_Control();
                          
                          //on CHANGE
                          $("#radio-prod").click(function(){ //use 'change' rather than 'click' 
                               $(".production_url_for_test").hide("slow");                           
                           });     
                          $("#radio-demo").click(function(){ //use 'change' rather than 'click' 
                               $(".production_url_for_test").hide("slow");                           
                           });     
                          $("#radio-test").click(function(){ //use 'change' rather than 'click' 
                               $(".production_url_for_test").show("slow");                           
                           }); 
                           
                          $("#show-info-button").click(function(){
                              $("#show-licensing-info").show("slow");                             
                          });                              
                                                        
                                   
                          function screen_init_Control() {                     
                            
                            if($('#radio-prod').is(':checked')){ //use 'change' rather than 'click' 
                                 $(".production_url_for_test").hide();                           
                             };     
                            if($('#radio-demo').is(':checked')){ //use 'change' rather than 'click' 
                                 $(".production_url_for_test").hide();                           
                             };     
                            if($('#radio-test').is(':checked')){ //use 'change' rather than 'click' 
                                 $(".production_url_for_test").show("slow");                           
                             };
                             
                            $("#show-licensing-info").hide();  
                                                       
                          }; 
                                      
           	 $("#title-anchor-plus-1").click(function(){ 
                    $("#title-anchor-plus-1").hide();
                    $("#title-anchor-minus-1").show();
                    $("#example-details-1").show("slow");    
             });        
           	 $("#title-anchor-minus-1").click(function(){ 
                    $("#title-anchor-minus-1").hide();
                    $("#title-anchor-plus-1").show();
                    $("#example-details-1").hide("slow");    
             }); 
           	 $("#title-anchor-plus-2").click(function(){ 
                    $("#title-anchor-plus-2").hide();
                    $("#title-anchor-minus-2").show();
                    $("#example-details-2").show("slow");    
             });        
           	 $("#title-anchor-minus-2").click(function(){ 
                    $("#title-anchor-minus-2").hide();
                    $("#title-anchor-plus-2").show();
                    $("#example-details-2").hide("slow");    
             });
             
             //v2.0.0.5 begin
             //show URL naming requirement if 'test' selected
              $("#radio-test").change(function(){
                  radioTest();
              });
              $("#radio-prod").change(function(){
                  radioTest();
              });
              radioTest(); 

              function radioTest() {
                if($('#radio-test').prop('checked')) {
                  $("#example-details-3").show("slow");  
                } else { 
                  $("#example-details-3").hide();   
                }
              }              
             //v2.0.0.5 end                                                          
                        
      }); 
  
  