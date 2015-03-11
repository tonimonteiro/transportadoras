/* functions navigation */
var loadParent = function( nameGroup ) {
	$.ajax({
		type : 'POST',
		url : '/admin/navigation/navigation/name-group',
		data : [{name:'data', value:nameGroup}],
	}).done(function(data) {
		var options = $("#parent");
		options.empty().append($("<option />").val('').text('Selecione'));
		$.each(data, function() {
			options.append($("<option />").val(this.value).text(this.label));
		});
	});
};

$(document).ready(function(){ 
	$( '#nameGroup' ).change(function() {
		var nameGroup = $(this).val();
		loadParent( nameGroup );
	});
});
