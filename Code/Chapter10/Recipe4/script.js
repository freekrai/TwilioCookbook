$(document).ready(function() {
	$('.orders-applet tr.hide input').attr('disabled', 'disabled');
	var app = $('.flow-instance.standard---orders');
	$('.orders-applet .orders-prompt .audio-choice', app).live('save', function(event, mode, value) {
		var text = '';
		if(mode == 'say') {
			text = value;
		} else {
			text = 'Play';
		}
		var instance = $(event.target).parents('.flow-instance.standard---orders');
		if(text.length > 0) {
			$(instance).trigger('set-name', 'Order ID: ' + text.substr(0, 6) + '...');
		}
	});
	$('.orders-applet .action.add').live('click', function(event) {
		event.preventDefault();
		var row = $(this).closest('tr');
		var newRow = $('tfoot tr', $(this).parents('.orders-applet')).html();
		newRow = $('<tr>' + newRow + '</tr>').show().insertAfter(row);
		$('td', newRow).flicker();
		$('input.keypress', newRow).attr('name', 'keys[]');
		$('input', newRow).removeAttr('disabled').focus();
		$(event.target).parents('.options-table').trigger('change');
		return false;
	});
	$('.orders-applet .action.remove').live('click', function() {
		var row = $(this).closest('tr');
		var bgColor = row.css('background-color');
		row.animate({backgroundColor : '#FEEEBD'},'fast').fadeOut('fast', function() {
			row.remove();
		});
		return false;
	});
	$('.orders-applet .options-table').live('change', function() {
		var first = $('tbody tr', this).first();
		$('.action.remove', first).hide();
	});
	$('.orders-applet .options-table').trigger('change');
});
