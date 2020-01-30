$(function(){
	
	formValidator('form.signin', [
		{name: 'email', label: 'Email', required: true, format: 'email'},
		{name: 'password', label: 'Password', required: true}
	]);
	
});