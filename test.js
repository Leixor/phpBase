$("#button").click(function () {
    $.ajax({
        type: 'POST',
        url: "test.php",
        data: {
            'number': $("#iField").val()
        },
        success: function (result) {
            console.log(result);
        }
    })
});
