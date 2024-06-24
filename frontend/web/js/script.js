function addToBasket(id) {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    var count = $('input.count-input[data-id="' + id + '"]').val();

    $.ajax({
        url: "../basket/create",
        type: 'POST',
        data: {
            'id': id,
            'count': count,
            '_csrf': csrfToken
        },
        success: function(response) {
            console.log('AJAX request successful');
        },
        error: function(xhr, status, error) {
            console.error('Error occurred: ' + error);
        }
    });
}