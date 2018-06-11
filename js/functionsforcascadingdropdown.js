function resetValues() {
    $('#clazz_type').empty();
    $('#clazz_type').append(new Option('--select class type--', '', true, true));	
    $('#clazz_type').attr("disabled", "disabled");		
}


function populateClass(xmlindata) {

var mySelect = $('#clazz');
 $('#clazz_type').disabled = false;
$(xmlindata).find("clazz").each(function()
  {
  optionValue=$(this).find("id").text();
  optionText =$(this).find("name").text();
   mySelect.append($('<option></option>').val(optionValue).html(optionText));	
  });
}

function populateClass_type(xmlindata) {

var mySelect = $('#clazz_type');
$('#clazz_type').removeAttr('disabled');    
$(xmlindata).find("clazz_type").each(function()
  {
  optionValue=$(this).find("id").text();
  optionText =$(this).find("name").text();
   mySelect.append($('<option></option>').val(optionValue).html(optionText));	
  });
}
