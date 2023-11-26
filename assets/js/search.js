$(document).ready(function() {

    load_data(1);

    function load_data(page, query = '') {
        $.ajax({
            url: "fetch_search_quetions.php",
            method: "POST",
            data: { page: page, query: query },
            success: function(data) {
                // console.log("data", data);
                $('#search_content').html(data);
            }
        });
    }

    $('#search_que').keyup(function() {
        var query = $('#search_que').val();
        load_data(1, query);
    });

});