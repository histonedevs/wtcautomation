$(document).on('change','#users',function(e){
    var user = $('#users').val();
    console.log(APP_URL);
    $.ajax({
        url: APP_URL +"/download/child-user",
        type: "get",
        data: {'user': user},
        success: function (data) {
            $(".div_child_users").remove();
            var closest_form_group = $('#users').closest('div[class^="form-group"]');
            if(user=="") {
                $(".div_child_users").remove();
            }
            else {
                $(data).insertAfter(closest_form_group);
            }
        }
    });
});

$(document).on('change','#child_users',function(e){
    var child_user = $('#child_users').val();
    $.ajax({
        url: APP_URL +"/download/product",
        type: "get",
        data: {'child_user': child_user},
        success: function (data) {
            console.log(data);
            $(".div_products").remove();
            var closest_form_group = $('#child_users').closest('div[class^="form-group"]');
            $(data).insertAfter(closest_form_group);
        }
    });
});
