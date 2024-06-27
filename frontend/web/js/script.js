function addToCart(id) {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    var quantity = $('input.count-input[data-id="' + id + '"]').val();

    $.ajax({
        url: "../cart/create",
        type: 'POST',
        data: {
            'id': id,
            'quantity': quantity,
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