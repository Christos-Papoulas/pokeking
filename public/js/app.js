$( document ).ready(() => {
    $('#find_king').click(() => {
        $.ajax('/pokemon/king')
        .done((res) => {
            console.log(res);
            $('#king-name').text(res.king.name);
            $('#king-stats').text(res.score);
            $('#king-alert').removeClass('d-none');
        })
        .fail(() => {
            alert('something went wrong');
        });
    });
});
