"use strict";

//When unchecking the checkbox
$("#check-all").on('ifUnchecked', function(event) {
    //Uncheck all checkboxes
    $("input[type='checkbox']", ".dataTable").iCheck("uncheck");
    $("#btn-remove").attr('disabled', 'disabled');
});
//When checking the checkbox
$("#check-all").on('ifChecked', function(event) {
    //Check all checkboxes
    $("input[type='checkbox']", ".dataTable").iCheck("check");
    $("#btn-remove").removeAttr('disabled');
});

// State of the button remove.
function stateCheckbox() 
{
	var checked = $('.cbid:checked').length;
	
	if (checked == 0) {
		$("#btn-remove").attr('disabled', 'disabled');
		$("#check-all").iCheck('uncheck');
	} else {
		$("#btn-remove").removeAttr('disabled');
	}
}

$("input[type='checkbox']", "tbody").on('ifChanged', function(event) {
	stateCheckbox();
});

// Action remove.
$("#btn-remove").click(function(e)
{
	e.preventDefault();

	bootbox.confirm("<h4 class='text-danger'>Deseja prosseguir com esta ação?</h4>", function(result) {
		if (result == true) {
			
			var list = new Array();
			
			$(".cbid:checked").each(function(index, field) {
				list[index] = field.value;
			});
			
			$.ajax({
				type : 'POST',
				url : $('#btn-remove').val(),
				data : {
	                'list[]': list
	            },
				dataType: 'json',
			}).done(function(data) {
				if (! data['error']) {
					bootbox.alert("<h4 class='text-success'>Operação realizada com sucesso!</h4>", function() {
						document.location.reload(true);
					});
					
				} else {
					bootbox.alert("<h4 class='text-danger'>101 - Ocorreram alguns erros na operação!</h4>", function() {
						document.location.reload(true);
					});
				}
				
			}).fail(function() {
				bootbox.alert("<h4 class='text-danger'>102 - Ocorreram alguns erros na operação!</h4>", function() {
					document.location.reload(true);
				});
			});
		} 
	}); 

	return false;
});