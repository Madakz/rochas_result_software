	jQuery().ready(function($){
			 
		// Ajax Called When Page is Load/Ready (Load clazz)
		jQuery.ajax({
						  url: 'class_in_xml.php',		//set the page with records in xml format here
						  global:false,
						  type: "POST",
						  dataType: "xml",
						  async: true,	
						  success: populateClass
						}); 
					
					

		//Ajax Called When You Change  clazz Name
		$("#clazz").change(function (env) 
			{
			 resetValues();	
			 	var data = { class_id :$('#clazz').val()	};
			 		//console.log(data);
			jQuery.ajax({
							  url: 'class_type_in_xml.php',
							  type: "POST",
							  dataType: "xml",
							  data:data,
							  async: true,	
							  success: populateClass_type
						}); 
			});
	
		});	
	
