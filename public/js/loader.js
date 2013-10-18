$('#loading_spinner').show();

var post_data = "my_variable="+my_variable;
$.ajax({
    url: 'ajax/my_php_page.php',
    type: 'POST',
    data: post_data,
    dataType: 'html',
    success: function(data) {
        $('.my_update_panel').html(data);
    },
    error: function() {
        alert("Something went wrong!");
    }
});

$('#loading_spinner').hide();