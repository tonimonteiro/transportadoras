/* funcoes datetimepicker */
$(function () {
	$('.datetime').datetimepicker({
		language: 'pt-br',
		sideBySide: true,
	});
	
	$('.time').datetimepicker({
		language: 'pt-br',
		pickDate: false
	});
	
	$('.date').datetimepicker({
		language: 'pt-br',
		pickTime: false
	});
});