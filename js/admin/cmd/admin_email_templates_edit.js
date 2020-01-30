$(function(){

	formValidator('form.validate', [
		{name: 'name', label: 'Name', required: true},
    {name: 'subject', label: 'Subject', required: true},
		{name: 'body', label: 'Body', required: true}
	]);
	
});