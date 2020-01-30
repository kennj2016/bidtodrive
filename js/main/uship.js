var access_token=''
    $(document).ready(function(){
        $.ajax({
            type: 'GET',
            url:'https://apistaging.uship.com/v2/oauth/token',
            headers: {    
                'Content-Type':'application/x-www-form-urlencoded',
                'Accept':'application/json',  
                
            }, 
             dataType: 'jsonp',
			crossDomain: true,
            data: {grant_type: 'client_credentials', client_id: '7gcwvxeesem5vkc549u2tfvb',client_secret:'pZyHUakApP'},
            success:function(res){
                console.log('OK');
                 access_token=res.access_token;
                 console.log(access_token);
            },
            error:function(err){
                console.log('NOT OK');
                console.log(err)
            }
        });
    })
    // function get_Price(){
    //     var bearToken=JSON.stringify('Bearer '+ access_token);
    //     console.log(bearToken);
    //     $.ajax({
    //         type: 'GET',
    //         url:'https://apistaging.uship.com/v2/fixedprice?originzip=12345&destinationzip=43210&length=20&width=30&height=40&weight=100&skuid=1234',
    //         headers: {
    //             'Authorization' :JSON.stringify('Bearer ' + access_token), 
    //             'Content-Type':'application/x-www-form-urlencoded',
    //             'Accept':'application/json', 
                   
    //         },  
    //         success:function(res){
    //             console.log('OK');
    //             console.log(res);
    //         },
    //         error:function(err){
    //             console.log('NOT OK');
    //             console.log(err)
    //         }
    //     })
    // }