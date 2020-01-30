$(function(){
	
	formValidator('form.validate', [
		{name: 'transaction_id', label: 'Transaction ID', required: true},
	]);
	
	$('.form-field-repeating-return').click(function(){
		var link = $(this);
		var input = link.closest('.form-field-repeating-item').find('.form-field-repeating-is-returned');
		if(input.length > 0){
			if(input.val() == 1){
				link.addClass('action-status-off').removeClass('action-status-on');
				input.val( 0);
			}else{
				link.addClass('action-status-on').removeClass('action-status-off');
				input.val(1);
			}
		}
		return false;
	});
	
	$('.form-field-send-email').click(function(){
		var link = $(this);
		if(!link.data('busy')){
			link.data('busy', true);
			$.get(window.location.href,{action: 'sent_email'},function(data){
				if(data.has_error){
					defaultErrorPopup(data.status);
				}else{
					defaultSuccessPopup(data.status);
				}
				link.data('busy', false);
			}, 'json');
		}
		return false;
	})
	
});

function sentShipmentEmail(){
	console.log(this);return;
	$.get(window.location.href,{action: 'sent_email'},function(data){
		if(data.has_error){
			defaultErrorPopup(data.status);
		}else{
			defaultSuccessPopup(data.status);
		}
	}, 'json');
}
