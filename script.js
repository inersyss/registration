$(document).ready(function () {
    $(document).on('click', '#task', function () {
        let url = location.pathname;
        $.ajax({
            type: "POST",
            url: url,
            data: {
                user: {
                    name : $('input[name="name"]').val(),
                    last_name: $('input[name="last_name"]').val(),
                    mail: $('input[name="mail"]').val(),
                    password: $('input[name="password"]').val(),
                    conf_password:  $('input[name="conf_password"]').val(),
                }
            },
            success: function(response) {
                let contentForm = $(response).find('.card-body').html(),
                    contentList = $(response).find('.table').html();
                    console.log(contentList);
                $('.card-body').html(contentForm);
                $('.table').html(contentList);
            },
          });

    });

});
