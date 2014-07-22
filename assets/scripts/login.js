var $errors = $('.errors');
var $loginButton = $('#login');

$('#login-form').on('submit', function(e) {
    e.preventDefault();

    $.ajax('authenticate.php', {
        dataType: 'json',
        type: 'POST',
        data: $(this).serialize(),
        beforeSend: function() {
            $loginButton.attr('disabled', true).val('Processing...');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $errors.text('Somethig went wrong, please try again in a few minutes...');
            $loginButton.removeAttr('disabled').val('Login');
        },
        success: function(response) {
            if (response.error) {
                $errors.text(response.error);
                $loginButton.removeAttr('disabled').val('Login');
            }

            if (response.success) {
                window.location.href = 'books.php';
            }
        }
    });
});
