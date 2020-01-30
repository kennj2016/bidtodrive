function changeStatuses(id){
    var data = 'id='+id;
    var str = ''+id+'';
    str = str.replace('.', '_');
    var request = $.ajax({
		url: "/admin/products_inventory/",
		type: "post",
		dataType: "json",
		data: data,
		success: function(response)
		{
			if (!response.has_records)
        //console.log($(".changeStatuses"+str.replace('.', '_')).html());
        if($(".changeStatuses"+str).html() == "Available")
        {
            $(".changeStatuses"+str).html("Out of Stock");
            $(".changeStatuses"+str).css('color','#f05500');
            
        }
        else
        {
            $(".changeStatuses"+str).html("Available");
            $(".changeStatuses"+str).css('color','#1fbba6');
        }
		}
	});
    
}