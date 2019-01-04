/**
 * Created by jsalgado on 27/06/2017.
 */

var chechComercialForm = $('#check-comercial-form');
$(document).on('click', '#check', function (ev) {
    ev.preventDefault();
    $('#response').html(
        '<label class="control-label"></label>' +
        '<div class="form-group">' +
        loadingImg +
        '<div style="display: inline-block">Buscando... </div>' +
        '</div>'
    );
    ajaxCheckComercial(urlAjaxCheckComercial);
});
$("form").on("afterValidateAttribute", function (event, attribute, messages) {
    if (messages.length === 0) {
        $('#check').attr('disabled', false);
    } else {
        $('#check').attr('disabled', true);
    }

});

$(document).on('input focusout', '#check-comercial-form input', function (ev) {
    // $('#check-comercial-form').yiiActiveForm('validate', true);
    var mail = $('#autorizaciones-mail');
    var phone = $('#autorizaciones-phone');
    // var errorMessage = $('#error-message');

    if ((mail.val() === '' || mail.val() === undefined) && (phone.val() === '' || phone.val() === undefined )) {
        chechComercialForm.yiiActiveForm('validateAttribute', 'autorizaciones-phone');
        chechComercialForm.yiiActiveForm('validateAttribute', 'autorizaciones-mail');
        mail.prop('disabled', false);
        phone.prop('disabled', false);
        $('#check').prop('disabled', true);
        //errorMessage.html('<div class="alert alert-danger alert-dismissable face in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>* Se debe rellenar el campo de "Correo electrónico" o el de "Teléfono".</div>');
    }
    else if (ev.type === 'focusout') {
        if (mail.val() !== '' && mail.val() !== undefined) {
            disableField(phone);
        }
        if (phone.val() !== '' && phone.val() !== undefined) {
            disableField(mail);
        }
    }
});

function ajaxCheckComercial(url) {
    var data = {
        mail: $('#autorizaciones-mail').val(),
        phone: $('#autorizaciones-phone').val(),
        empresa: $('#autorizaciones-empresa').val()
    };
    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: data,
        url: url,
        success: function (response) {
            if (response.success) {
                $('#response').html(response.message);
            }
            else {
                $('#error-message').html('<div class="alert alert-danger alert-dismissable face in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>¡Se ha producido un error en el procesamiento de datos!".</div>');
            }

        }
    });
}
//
// function deleteErrorMessage() {
//     window.setTimeout(function () {
//         $("#error-message").find(".alert").slideUp(500, function () {
//             $(this).remove();
//         });
//     }, 3000);
// }

function disableField(field) {

    var formSettings = chechComercialForm.yiiActiveForm('data').settings;
    var fieldContainer = chechComercialForm.find(chechComercialForm.yiiActiveForm('find', field.attr('id')).container);
    var fieldError = chechComercialForm.find(chechComercialForm.yiiActiveForm('find', field.attr('id')).error);
    $(fieldContainer).removeClass(formSettings.validatingCssClass + ' ' + formSettings.errorCssClass + ' ' + formSettings.successCssClass);
    $(fieldError).empty();
    $(field).attr('disabled', true);


}