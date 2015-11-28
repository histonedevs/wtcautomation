$(document).on('change','#users',function(e){
    var user = $('#users').val();
    $(".div_child_users").remove();

    if(user) {
        $.ajax({
            url: APP_URL + "/users/child-user",
            type: "get",
            data: {'user': user},
            success: function (data) {
                var closest_form_group = $('#users').closest('div[class^="form-group"]');
                $(data).insertAfter(closest_form_group);
            }
        });
    }
});

$(document).on('change','#child_users',function(e){
    var child_user = $('#child_users').val();
    $(".div_products").remove();

    if(child_user){
        $.ajax({
            url: APP_URL +"/users/product",
            type: "get",
            data: {'child_user': child_user},
            success: function (data) {
                var closest_form_group = $('#child_users').closest('div[class^="form-group"]');
                $(data).insertAfter(closest_form_group);
            }
        });
    }
});
