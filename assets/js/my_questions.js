$(document).ready(function() {

    load_data(1);

    function load_data(page, query = '') {
        $.ajax({
            url: "fetch_my_quetions.php",
            method: "POST",
            data: { page: page, query: query },
            success: function(data) {
                // console.log("data", data);
                $('#dynamic_content').html(data);
            }
        });
    }

    $(document).on('click', '.page-link', function() {
        var page = $(this).data('page_number');
        var query = $('#search_box').val();
        load_data(page, query);
    });

    $('#search_box').keyup(function() {
        var query = $('#search_box').val();
        load_data(1, query);
    });

});