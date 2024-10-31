 /*
v2.0.3 new
will be added to in rules-ui via inline
 */

      
                       jQuery.noConflict();

                        jQuery(document).ready(function($) {  
						
							 //DatePicker                       
							 // from  http://jquerybyexample.blogspot.com/2012/01/end-date-should-not-be-greater-than.html
								$("#date-begin-0").datepicker({
								  dateFormat : "yy-mm-dd", 
								  minDate: 0,
								 // maxDate: "+60D",
								  numberOfMonths: 2,
								  onSelect: function(selected) {
									$("#date-end-0").datepicker("option","minDate", selected)
								  }
							  });
							  $("#date-end-0").datepicker({ 
								  dateFormat : "yy-mm-dd", 
								  minDate: 0,
								 // maxDate:"+60D",
								  numberOfMonths: 2,
								  onSelect: function(selected) {
									 $("#date-begin-0").datepicker("option","maxDate", selected)
							  } 
							  
                             }); 

                    }); //end ready function 
                   
