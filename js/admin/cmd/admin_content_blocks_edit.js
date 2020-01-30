$(function(){

	formValidator('form.validate', [
		{name: 'title', label: 'Title', required: true}
	]);
	
	var paymentMethod = $('#payment-method');
	var CBdescription = $('#cb-description');
	paymentMethod.hide();
	CBdescription.show();
	
	var blogType = $("#type").val();
	if(blogType == "Payment/Pickup"){
		paymentMethod.show();
		CBdescription.hide();
	}else{
		paymentMethod.hide();
		CBdescription.show();
	}
	
	$('#type').on('change', function() {
		var CBtype = this.value;
		if(CBtype == "Payment/Pickup"){
			paymentMethod.show();
			CBdescription.hide();
		}else{
			paymentMethod.hide();
			CBdescription.show();
		}
	})
	
});