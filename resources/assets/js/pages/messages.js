(function(){

    'use strict';

    WEBSTORE.message.send = function(){

        // Create subcategory
        $(".quote").on('click', function (e) {

            var token = $(this).data('token');
            var product_id = $(this).attr('id');


            $.ajax({
                type: 'POST',
                url: '/send-quote/'+product_id,
                data: {token: token, sender_name: sender_name, sender_email: sender_email},
                success: function(data){
                    var response = jQuery.parseJSON(data);
                    $(".notification").css("display", "block").delay(4000).slideUp(300)
                        .html(response.success);
                },
                error:function(request, error){

                    var errors = jQuery.parseJSON(request.responseText);
                    var ul = document.createElement('ul');

                    $.each(errors, function(key, value){
                        var li = document.createElement('li');
                        li.appendChild(document.createTextNode(value));
                        ul.appendChild(li);

                    })
                    $(".notification").css("display", "block").removeClass("primary").addClass("alert").delay(6000).slideUp(300)
                        .html(ul);
                }
            });

            e.preventDefault();
        })


    };
})();

