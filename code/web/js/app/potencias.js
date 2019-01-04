/** Variables externas:
 * var validations
 * var urlAtr
 * var urlPotenciasRow
 * var urlGetPowError
 * var urlDownloadTemplate
 * var modelId
 * var loadingBlock
 * */

var extraValidationmoment = '';
$(document).on('change', '#potencias-grupo_id', function () {
    $('#pow_fields').find('.row').html(loadingBlock);

    $.ajax({
        url: urlPotenciasRow,
        type: 'POST',
        dataType: 'json',
        data: {
            current_group: $('#potencias-grupo_id').val(),
            cups: $('#potencias-cups_atr').val(),
            tarifa: $('#potencias-tarifa_id').val()
        },
        success: function (data) {
            $('#pow_fields').find('.row').html(data.html);
            $('#pow_errors').html('');
            validations = data.extra_data;
        }
    });
});

if (validations.free) {
    extraValidationmoment = ' input';
}
$(document).on('focusout change' + extraValidationmoment, '.pow_val', function () {
    $('#solicitud-cdp').yiiActiveForm('validateAttribute', $(this).attr('id'));
    $('#solicitar').attr('disabled', true);
    var currentField = $(this);

    var allFieldsOk = true;
    var emptyField = false;

    var potencias = 0;

    var minAnyReach = false;
    var minAllFail = false;
    var minAllFailElements = '';


    var maxAny = false;
    var maxAllFail = false;
    var maxAllFailElements = '';

    var errorMessage = '';
    $('.pow_val:enabled').each(function (key, power) {
        if (!power.value || power.value === '0') {
            emptyField = true;
        }
        if (validations.free) {
            $('#solicitud-cdp').yiiActiveForm('validateAttribute', $(power).attr('id'));
            var floatPowerValue = parseFloat($(power).val());

            if (validations.max_all !== null && floatPowerValue > validations.max_all) {
                maxAllFail = true;
            }
            if (validations.min_all !== null && floatPowerValue < validations.min_all) {
                minAllFail = true;
            }

            potencias += floatPowerValue;
            if (validations.max_any !== null && floatPowerValue <= validations.max_any) {
                maxAny = true;
            }
            if (validations.min_any !== null && floatPowerValue >= validations.min_any) {
                minAnyReach = true;
            }
        }
        else {
            if (validations.equals) {
                if ($(power).attr('id') !== currentField.attr('id')) {
                    $(power).val(currentField.val());
                    $('#solicitud-cdp').yiiActiveForm('validateAttribute', currentField.attr('id'));
                }
            }
        }
    });

    if ($(this).parents('.row').find('.has-error').length === 0) {
        $('#solicitar').attr('disabled', true);
    }
    if (validations.free) {
        if (validations.max_any !== null && !maxAny) {
            allFieldsOk = false;
            errorMessage += 'Al menos una de las potencias debe ser inferior o igual a ' + validations.max_any + '.';
        }
        if (validations.min_any !== null && !minAnyReach) {
            allFieldsOk = false;
            errorMessage += 'Al menos una de las potencias debe ser superior o igual a ' + validations.min_any + '.';
        }
        if (maxAllFail) {
            allFieldsOk = false;
            if (errorMessage !== '') {
                errorMessage += '<br>';
            }
            errorMessage += 'Todas las potencias deben ser inferiores a ' + validations.max_all + '.';
            $(maxAllFailElements).parents('.form-group').addClass('has-error');
        }
        if (minAllFail) {
            allFieldsOk = false;
            if (errorMessage !== '') {
                errorMessage += '<br>';
            }
            errorMessage += 'Todas las potencias deben ser superiores a ' + validations.min_all + '.';
            $(minAllFailElements).parents('.form-group').addClass('has-error');
        }
    }

    if (!allFieldsOk) {
        $.ajax({
            url: urlGetPowError,
            type: 'POST',
            data: {
                errorMessage: errorMessage
            },
            success: function (data) {
                $('#pow_errors').html(data);
            }
        });
    } else {
        $('#pow_errors').html('');
        if (!emptyField) {
            $('#solicitar').attr('disabled', false);
        }
    }
});

$('#solicitud-cdp').on('beforeValidateAttribute', function (ev, field) {
    $('#solicitud-cdp').yiiActiveForm('find', field.id).validate = function (field, value, messages, deferred, $form) {
        if ($.inArray(field.name, ['P1', 'P2', 'P3', 'P4', 'P5', 'P6']) >= 0) {
            var floatPowerValue = parseFloat(value);
            var pNumber = field.id.substr(-1);
            var lastValue = null;
            currentValue = null;
            if (pNumber > 1) {
                lastValue = parseFloat($('#potencias-p' + (pNumber - 1)).val());
                currentValue = parseFloat($('#potencias-p' + pNumber).val())
            }

            if (value == 0 || value == '' || value == '0') {

                $form.yiiActiveForm('updateAttribute', field.id, [field.name + ' no puede estar vacío.']);
                $('#solicitar').attr('disabled', true);
            }
            if (validations.max_all !== null && floatPowerValue > validations.max_all) {
                $form.yiiActiveForm('updateAttribute', field.id, [field.name + ' no puede ser superior a  ' + validations.max_all + '.']);

                $('#solicitar').attr('disabled', true);
            }
            if (validations.min_all !== null && floatPowerValue < validations.min_all) {
                $form.yiiActiveForm('updateAttribute', field.id, [field.name + ' no puede ser inferior a  ' + validations.min_all + '.']);

                $('#solicitar').attr('disabled', true);
            }
            if (validations.rising) {
                if (lastValue !== null && currentValue < lastValue) {
                    $form.yiiActiveForm('updateAttribute', field.id, [field.name + ' debe ser superior o igual a P' + (pNumber - 1) + '.']);
                    $('#solicitar').attr('disabled', true);
                }

            }
        }
    };
    return true;
});
$(document).on('click', '#solicitar', function (ev) {
    ev.preventDefault();
    krajeeDialog.confirm('¿Quiere descargar la plantilla del cambio de potencia?', function (result) {
        if (result) {
            $('#download_template').find('.bootstrap-dialog-footer-buttons').html(loadingGeneratingBlock);
            $.ajax({
                url: urlDownloadTemplate,
                type: 'POST',
                data: {
                    id: modelId,
                    grupo_id: $('#potencias-grupo_id').val(),
                    alta_id: $('#potencias-alta_id').val(),
                    lang: $('#potencias-lang').val(),
                    cups: $('#potencias-cups_atr').val(),
                    P1: $('#potencias-p1').val(),
                    P2: $('#potencias-p2').val(),
                    P3: $('#potencias-p3').val(),
                    P4: $('#potencias-p4').val(),
                    P5: $('#potencias-p5').val(),
                    P6: $('#potencias-p6').val()
                },
                success: function (data) {
                    window.open(data);
                },
                complete: function () {
                    window.location.href = urlAtr;
                }
            });
            return true;
        } else {
            $('#solicitud-cdp').submit();
        }
    });

});
/**
 * Created by jsalgado on 16/03/2017.
 */
