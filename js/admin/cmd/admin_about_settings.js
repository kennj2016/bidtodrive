$(function(){
	
	if ($(".custom-bucket-item").length == 2){
		$(".form-field-repeating-footer").hide();
	}
	
	$(".key-featured-buckets .form-field-repeating-add").click(function() {
		if ($(".custom-bucket-item").length == 2){
			$(".form-field-repeating-footer").hide();
		}
	});
	
	$(".how-it-works-steps .form-field-repeating-add").click(function() {
		if ($(".custom-step-item").length == 3){
			$(".how-it-works-steps .form-field-repeating-footer").hide();
		}
	});

});