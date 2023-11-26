$(document).on('click', '.submit_star-lbl', function() {

    rating_data = $(this).data('rating');
    console.log("rating_data", rating_data);
    $(this).parent().parent().find('.cur-star-inp').val(rating_data);
    // console.log("$(this).parent().parent()", $(this).parent().parent().find('.cur-rat-inp'));
    $(this).parent().parent().submit();
    // console.log("rating_data", rating_data);
    // console.log("$(this).parent().closest('.cur-rat-inp')", $(this).parent().closest('.cur-rat-inp'));
    // $(this).parent().closest('.cur-rat-inp').val(rating_data);
});

// star ratting ends

$("#search_ans").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("ul.ans-list li").filter(function() {
        $(this).toggle($(this).find('p.mb-3').text().toLowerCase().indexOf(value) > -1)
    });
});