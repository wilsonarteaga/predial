var last_propietario = 0;
$(document).ready(function() {

    if ($('#excento_impuesto').length > 0) {
        $('#excento_impuesto').off('click').on('click', function() {
            if ($(this).is(':checked')) {
                $('#span_excento_impuesto').html('SI');
                $(this).val(1);
            } else {
                $('#span_excento_impuesto').html('NO');
                $(this).val(0);
            }
        });
    }
    if ($('#predio_incautado').length > 0) {
        $('#predio_incautado').off('click').on('click', function() {
            if ($(this).is(':checked')) {
                $('#span_predio_incautado').html('SI');
                $(this).val(1);
            } else {
                $('#span_predio_incautado').html('NO');
                $(this).val(0);
            }
        });
    }
    if ($('#aplica_ley44').length > 0) {
        $('#aplica_ley44').off('click').on('click', function() {
            if ($(this).is(':checked')) {
                $('#span_aplica_ley44').html('SI');
                $(this).val(1);
            } else {
                $('#span_aplica_ley44').html('NO');
                $(this).val(0);
            }
        });
    }

    $('#save_db').off('click').on('click', function() {
        saveDatosPredio('form-predios-datos-basicos', 'modal-datos-basicos', 'predios_datos_basicos', 'db');
    });
    $('#save_dp').off('click').on('click', function() {
        saveDatosPredio('form-predios-datos-propietarios', 'modal-datos-propietarios', 'predios_datos_propietarios', 'dp');
    });
    $('#save_dc').off('click').on('click', function() {
        saveDatosPredio('form-predios-datos-calculo', 'modal-datos-calculo', 'predios_datos_calculo', 'dc');
    });
    $('#save_dpa').off('click').on('click', function() {
        saveDatosPredio('form-predios-datos-pagos', 'modal-datos-pagos', 'predios_datos_pagos', 'dpa');
    });
    $('#save_dap').off('click').on('click', function() {
        saveDatosPredio('form-predios-datos-acuerdos-pago', 'modal-datos-acuerdos-pago', 'predios_datos_acuerdos_pago', 'dap');
    });
    $('#save_da').off('click').on('click', function() {
        saveDatosPredio('form-predios-datos-abonos', 'modal-datos-abonos', 'predios_datos_abonos', 'da');
    });
    $('#save_ph').off('click').on('click', function() {
        saveDatosPredio('form-predios-datos-procesos-historicos', 'modal-datos-procesos-historicos', 'predios_datos_procesos_historicos', 'pi');
    });

    /// datos-basicos
    $('#modal-datos-basicos').on('show.bs.modal', function() {
        if ($('#tr_predio_' + $('#id_edit').val()).attr('data-db') !== undefined) {
            var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-db'));
            setFormData('form-predios-datos-basicos', objJson);
        }
    });

    $('#modal-datos-basicos').on('hidden.bs.modal', function() {
        $('.datohidden').remove();
    });

    /// datos-propietarios
    $('#modal-datos-propietarios').on('show.bs.modal', function() {
        if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dp') !== undefined) {
            var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dp'));
            if (objJson.length !== undefined) {
                last_propietario = 0;
                setFormData('form-predios-datos-propietarios', objJson[last_propietario]);
                $('#form-predios-datos-propietarios').find('#span_jerarquia').html(objJson[last_propietario].jerarquia);
                $('.control_propietarios').css('display', '');
                $('.control_propietarios').attr('disabled', false);
                $('#prev_dp').attr('disabled', true);
                if (objJson.length < 2) {
                    $('#next_dp').css('display', 'none');
                    $('#prev_dp').css('display', 'none');
                } else {
                    $('#span_de_jererquia').html(' de ' + objJson.length);
                }
            }
        }
    });

    $('#modal-datos-propietarios').on('hidden.bs.modal', function() {
        $('.datohidden').remove();
        $('.control_propietarios').css('display', 'none');
        $('#cancel_dp').css('display', 'none');
        last_propietario = 0;
    });

    /// datos-calculo
    $('#modal-datos-calculo').on('show.bs.modal', function() {
        if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dc') !== undefined) {
            var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dc'));
            setFormData('form-predios-datos-calculo', objJson);
        }
    });

    $('#modal-datos-calculo').on('hidden.bs.modal', function() {
        $('.datohidden').remove();
    });

    /// datos-pagos
    $('#modal-datos-pagos').on('show.bs.modal', function() {
        if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dpa') !== undefined) {
            var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dpa'));
            setFormData('form-predios-datos-pagos', objJson);
        }
    });

    $('#modal-datos-pagos').on('hidden.bs.modal', function() {
        $('.datohidden').remove();
    });

    /// datos-acuerdos-pago
    $('#modal-datos-acuerdos-pago').on('show.bs.modal', function() {
        if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dap') !== undefined) {
            var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dap'));
            setFormData('form-predios-datos-acuerdos-pago', objJson);
        }
    });

    $('#modal-datos-acuerdos-pago').on('hidden.bs.modal', function() {
        $('.datohidden').remove();
    });

    /// datos-abonos
    $('#modal-datos-abonos').on('show.bs.modal', function() {
        if ($('#tr_predio_' + $('#id_edit').val()).attr('data-da') !== undefined) {
            var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-da'));
            setFormData('form-predios-datos-abonos', objJson);
        }
    });

    $('#modal-datos-abonos').on('hidden.bs.modal', function() {
        $('.datohidden').remove();
    });

    /// datos-procesos-historicos
    $('#modal-datos-procesos-historicos').on('show.bs.modal', function() {
        if ($('#tr_predio_' + $('#id_edit').val()).attr('data-ph') !== undefined) {
            var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-ph'));
            setFormData('form-predios-datos-procesos-historicos', objJson);
        }
    });

    $('#modal-datos-procesos-historicos').on('hidden.bs.modal', function() {
        $('.datohidden').remove();
    });

    $('#new_dp').off('click').on('click', function() {
        $('.datohidden').remove();
        $('.control_propietarios').css('display', 'none');
        $('#cancel_dp').css('display', '');
        $('#form-predios-datos-propietarios')[0].reset();
        clear_form_elements("#form-predios-datos-propietarios");

        if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dp') !== undefined) {
            var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dp'));
            if (objJson.length !== undefined) {
                $('#form-predios-datos-propietarios').find('#jerarquia').val(objJson.length + 1);
                $('#form-predios-datos-propietarios').find('#span_jerarquia').html(objJson.length + 1);
                $('#span_de_jererquia').html('');
            }
        }
    });

    $('#cancel_dp').off('click').on('click', function() {
        $('.control_propietarios').css('display', '');
        if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dp') !== undefined) {
            var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dp'));
            if (objJson.length !== undefined) {
                setFormData('form-predios-datos-propietarios', objJson[last_propietario]);
                $('#form-predios-datos-propietarios').find('#span_jerarquia').html(objJson[last_propietario].jerarquia);
                if (objJson.length < 2) {
                    $('#next_dp').css('display', 'none');
                    $('#prev_dp').css('display', 'none');
                } else {
                    $('#span_de_jererquia').html(' de ' + objJson.length);
                }
            }
        }
        $('#cancel_dp').css('display', 'none');
    });

    $('#next_dp').off('click').on('click', function() {
        if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dp') !== undefined) {
            var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dp'));
            last_propietario++;
            if (objJson[last_propietario] !== undefined) {
                if (objJson.length !== undefined) {
                    setFormData('form-predios-datos-propietarios', objJson[last_propietario]);
                    $('#form-predios-datos-propietarios').find('#span_jerarquia').html(objJson[last_propietario].jerarquia);
                    if (objJson.length === (last_propietario + 1)) {
                        $('#next_dp').attr('disabled', true);
                    }
                    $('#prev_dp').attr('disabled', false);
                }
            } else {
                last_propietario--;
            }
        }
    });

    $('#prev_dp').off('click').on('click', function() {
        if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dp') !== undefined) {
            var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dp'));
            last_propietario--;
            if (objJson[last_propietario] !== undefined) {
                if (objJson.length !== undefined) {
                    setFormData('form-predios-datos-propietarios', objJson[last_propietario]);
                    $('#form-predios-datos-propietarios').find('#span_jerarquia').html(objJson[last_propietario].jerarquia);
                    if (last_propietario === 0) {
                        $('#prev_dp').attr('disabled', true);
                    }
                    $('#next_dp').attr('disabled', false);
                }
            } else {
                last_propietario++;
            }
        }
    });
});

function saveDatosPredio(form, modal, path, suffix) {
    var jsonObj = $('#' + form).serializeJSON({ useIntKeysAsArrayIndex: true });
    if (jsonObj.id_predio === undefined) {
        jsonObj.id_predio = $('#id_edit').val();
    }
    $.ajax({
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: 'json',
        url: '/store/' + path,
        data: {
            form: JSON.stringify(jsonObj)
        },
        success: function(response) {
            if (response.data !== undefined) {
                if (response.data.success) {
                    $('#' + modal).modal('hide');
                    if (response.obj !== undefined) {
                        if (suffix === 'dp') {
                            if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dp') !== undefined) {
                                var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dp'));
                                if (objJson.length !== undefined) {
                                    if (jsonObj.id !== undefined) {
                                        objJson[last_propietario] = response.obj;
                                    } else {
                                        objJson.push(response.obj);
                                    }

                                    $('#tr_predio_' + $('#id_edit').val()).attr('data-' + suffix, JSON.stringify(objJson));
                                    $('#span_de_jererquia').html(' de ' + objJson.length);
                                }
                            } else {
                                var arr = [];
                                arr.push(response.obj);
                                $('#tr_predio_' + $('#id_edit').val()).attr('data-' + suffix, JSON.stringify(arr));
                            }
                        } else {
                            $('#tr_predio_' + $('#id_edit').val()).attr('data-' + suffix, JSON.stringify(response.obj));
                        }
                    }
                }

                swal({
                    title: "Atención",
                    text: response.data.message,
                    type: "warning",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Aceptar",
                    closeOnConfirm: true
                }, function(isConfirm) {
                    if (isConfirm) {
                        $('#' + form)[0].reset();
                        clear_form_elements("#" + form);
                    }
                });
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

function getJsonPrediosDatos() {
    $.ajax({
        type: 'GET',
        url: '/show/predios_datos',
        data: {
            id_predio: $('#id_edit').val()
        },
        success: function(response) {
            if (response.predio_dato !== undefined && response.predio_dato !== null) {
                $('#tr_predio_' + $('#id_edit').val()).attr('data-db', JSON.stringify(response.predio_dato));
            }

            if (response.predio_propietario !== undefined && response.predio_propietario !== null) {
                if (response.predio_propietario.length > 0) {
                    $('#tr_predio_' + $('#id_edit').val()).attr('data-dp', JSON.stringify(response.predio_propietario));
                }
            }

            if (response.predio_calculo !== undefined && response.predio_calculo !== null) {
                $('#tr_predio_' + $('#id_edit').val()).attr('data-dc', JSON.stringify(response.predio_calculo));
            }

            if (response.predio_pago !== undefined && response.predio_pago !== null) {
                $('#tr_predio_' + $('#id_edit').val()).attr('data-dpa', JSON.stringify(response.predio_pago));
            }

            if (response.predio_acuerdo_pago !== undefined && response.predio_acuerdo_pago !== null) {
                $('#tr_predio_' + $('#id_edit').val()).attr('data-dap', JSON.stringify(response.predio_acuerdo_pago));
            }

            if (response.predio_abono !== undefined && response.predio_abono !== null) {
                $('#tr_predio_' + $('#id_edit').val()).attr('data-da', JSON.stringify(response.predio_abono));
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

function setFormData(form, jsonObj) {
    $.each(jsonObj, function(i, el) {
        if ($('#' + form).find('#' + i).length > 0) {
            if ($('#' + form).find('#' + i).hasClass('selectpicker') || $('#' + form).find('#' + i).hasClass('selectpicker-noval')) {
                $('#' + form).find('#' + i).selectpicker('val', el);
            } else {
                if (el === '.00') {
                    if ($.inArray(i, arr_autonumeric) >= 0) {
                        AutoNumeric.set('#' + i, 0);
                    } else {
                        $('#' + form).find('#' + i).val('0');
                    }
                } else {
                    if ($.inArray(i, arr_autonumeric) >= 0) {
                        AutoNumeric.set('#' + i, Number(el));
                    } else {
                        $('#' + form).find('#' + i).val(el);
                        if ($('#' + form).find('#' + i).is(':checkbox')) {
                            if (Number(el) > 0) {
                                if (!$('#' + form).find('#' + i).is(':checked')) {
                                    $('#' + form).find('#' + i).trigger('click');
                                }
                            } else {
                                if ($('#' + form).find('#' + i).is(':checked')) {
                                    $('#' + form).find('#' + i).trigger('click');
                                }
                            }
                        }
                    }
                }
            }
        } else {
            var input_hidden = $('<input class="datohidden" id="' + i + '" name="' + i + '" type="hidden" value="' + el + '"  />');
            $('#' + form).prepend(input_hidden);
        }
    });
}
