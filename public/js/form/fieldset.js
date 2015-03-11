/**
 * Setting class to mask input.
 */
var masks = ['(00) 00000-0000', '(00) 0000-00009'],
    maskBehavior = function(val, e, field, options) {
    return val.length > 14 ? masks[0] : masks[1];
};

$(document).ready(function(){
  $('.mdate').mask('00/00/0000');
  $('.mtime').mask('00:00:00');
  $('.mdate_time').mask('00/00/0000 00:00:00');
  $('.cep').mask('00000-000');
  $('.phone').mask('0000-0000');
  $('.phone_ddd').mask(maskBehavior, {onKeyPress: 
	   function(val, e, field, options) {
	       field.mask(maskBehavior(val, e, field, options), options);
	   }
	});
  $('.phone_us').mask('(000) 000-0000');
  $('.cpf').mask('000.000.000-00', {reverse: true});
  $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
  $('.money').mask('000.000.000.000.000,00', {reverse: true});
  $('.money2').mask("#.##0,00", {reverse: true, maxlength: false});
  $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {translation: {'Z': {pattern: /[0-9]/, optional: true}}});
  $('.ip_address').mask('099.099.099.099');
  $('.percent').mask('##0,00%', {reverse: true});
});