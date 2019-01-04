$(document).on('change', '#status', function () {
    $('#estadocarterasearch-status').val($('#status').val()).change();
});
$(document).on('change', '#in_campa', function () {
    $('#estadocarterasearch-in_campa').val($('#in_campa').val()).change();
});

$(document).on('click', '.toggle-data-btn', function () {
    $('.toggle-data-btn').attr('href', $('.toggle-data-btn').attr('href') + '&period=' + $('#period').val())
});