/**
 * Created by jsalgado on 22/02/2017.
 */
$(document).ready(function () {

    // $('#side-menu').metisMenu();
});
var url = window.location;
// var element = $('ul.nav a').filter(function() {
//     return this.href == url;
// }).addClass('active').parent().parent().addClass('in').parent();
// var element = $('#side-menu ul.nav li').filter(function () {
//     if($(this).hasClass('active')){
//         $(this).children('a').addClass('active current');
//     }
//     return $(this).hasClass('active');
// }).addClass('in');
//
// $('#side-menu ul.nav').siblings('a').append('<i class="fa arrow"></i>');
//
//
// while (true) {
//     if (element.is('li')) {
//         element = element.parent().addClass('collapse in').parent();
//     } else {
//         break;
//     }
// }

$(document).on('contextmenu','.kv-grid-table tbody',function(event){
    return false;
});


//add_filter
$('#add_filter').on('click', function() {

    $.ajax({
        type    : 'POST',
        data    : {
            contador : $("#idAdvSearch .table-hover tbody tr").length,
        },
        url     : 'leads/default/renderfiltro',
        success : function(response) {

            var nFilas = (parseInt($("#idAdvSearch .table-hover tr:last").attr("data-key"))+1);

            if (isNaN(nFilas)) nFilas = 0;

            $("#idAdvSearch .table-hover tbody").append(response);

            var element = $("#idAdvSearch .table-hover tr:last");
            $(element).find("select").select2();
            $(element).find(".kv-plugin-loading").remove();
            $(element).find(".select2").addClass("cien");
            $(element).find(".select2").addClass("select2-container--krajee");
            $(element).find(".select2").removeClass("select2-container--default");
            $(element).attr("data-key", nFilas);

            var tmpElement2 = $(element).find("textarea");
            $(tmpElement2).parent().css("display", "none");
        }
    });
});




//delete_filter
$('#delete_filter').on('click', function () {

    $('.kv-row-checkbox:checked').each(function () {
        var id = parseInt($(this).parent().parent().attr("data-key"));

        $('.table-hover tbody').find("[data-key='" + id + "']").remove();
        $(".select-on-check-all").prop("checked", false);
    });
});

$(document).on('click','.reset', function (e) {
    // e.preventDefault();
    this.form.reset();
    $(this).parents('form').find('input:first-child').change();
});


$(document).on('click','#exportar', function (e) {
    e.preventDefault();
    var flag = confirm("Esta seguro que quiere exportar los resgistros?");
    if (flag){
        $('#leadsExport').submit()
    }
});



// $(function () {
//
//     var unsaved = false;
//     $(":input").change(function () {
//         unsaved = true;
//     });
//
//     $('#btnCancel').click(function () {
//         if (unsaved) {
//             var flag = confirm("Job Function Not Saved. Are you Sure you want to leave with out saving the data?");
//             if (flag)
//                 $('#mymodal').modal('hide');
//
//         }
//         else
//             $('#mymodal').modal('hide');
//
//     });
//
// });
