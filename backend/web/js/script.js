function statusChange(id, selectedStatus) {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    $.ajax({
        url: "../order/status",
        type: 'POST',
        data: {
            '_csrf': csrfToken,
            'id': id,
            'selectedStatus': selectedStatus
        },
        success: function(response) {
            console.log('AJAX request successful');
            console.log(response);
        },
        error: function(xhr, status, error) {
            console.error('Error occurred: ' + error);
        }
    });
}

console.log('connected')