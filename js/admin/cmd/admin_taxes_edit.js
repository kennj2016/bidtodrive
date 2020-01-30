$(function(){

	formValidator('form.validate', [
		{name: 'zip_code', label: 'ZIP Code', required: true},
		{name: 'city', label: 'City', required: true},
		{name: 'post_office', label: 'Post Office', required: true},
		{name: 'state_id', label: 'State', required: true},
		{name: 'county', label: 'County', required: true}
	]);
	
});