$(document).ready(function() {
    $('#login_form').submit(function(event) {
        var json;
        event.preventDefault();
        // console.log($(this).serialize())
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            // contentType: "application/json; charset=utf-8",
            cache: false,
            // processData: false,
            success: function(response) {
                // console.log(response)
                json = JSON.parse(response);
                if(json.url) {
                    window.location.href = json.url;
                } else {
                    alert(json.message);
                }
            },
        });
    });

    $('#sku_form').submit(function(event) {
        var json;
        event.preventDefault();
        // console.log($(this).serialize())
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            // contentType: "application/json; charset=utf-8",
            cache: false,
            // processData: false,
            success: function(response) {
                // console.log(response)
                json = JSON.parse(response);
                if(json.url) {
                    window.location.href = json.url;
                } else {
                    alert(json.message);
                }
            },
        });
    });
});