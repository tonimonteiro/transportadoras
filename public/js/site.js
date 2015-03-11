"use strict";
/**
 * Font size.
 */
$(function() {
	var sizeMax = 32;
	var sizeMin = 11;
	$("#expand").click(function() {
		var sizeText = $('.content-text').css('font-size').substring(0, 2);
		if (sizeText <= sizeMax) {
			sizeText++;
			$('.content-text').css({
				'fontSize' : sizeText
			});
		}
	});
	$("#lower").click(function() {
		var sizeText = $('.content-text').css('font-size').substring(0, 2);
		if (sizeText >= sizeMin) {
			sizeText--;
			$('.content-text').css({
				'fontSize' : sizeText
			});
		}
	});
})
/**
 * Fade out.
 */
$('.fadeOut').fadeOut(5000);