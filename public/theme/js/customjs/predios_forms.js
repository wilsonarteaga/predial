var DTAbonos = null;
var last_propietario = 0;
var idx_update = 0;
var current_page = 0;
var PAGE_LENGTH = 3;
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
    if ($('#uso_suelo').length > 0) {
        $('#uso_suelo').off('click').on('click', function() {
            if ($(this).is(':checked')) {
                $('#span_uso_suelo').html('SI');
                $(this).val(1);
            } else {
                $('#span_uso_suelo').html('NO');
                $(this).val(0);
            }
        });
    }
    if ($('#acuerdo_pago').length > 0) {
        $('#acuerdo_pago').off('click').on('click', function() {
            if ($(this).is(':checked')) {
                $('#span_acuerdo_pago').html('SI');
                $(this).val(1);
            } else {
                $('#span_acuerdo_pago').html('NO');
                $(this).val(0);
            }
        });
    }

    $('.datepickerforms').datepicker({
        //container: $('#modal-datos-pagos'),
        language: 'es-ES',
        format: 'yyyy-mm-dd',
        autoHide: true
    });

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
        $('#form-predios-datos-propietarios')[0].reset();
        clear_form_elements("#form-predios-datos-propietarios");
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
        $('#form-predios-datos-calculo')[0].reset();
        clear_form_elements("#form-predios-datos-calculo");
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
        $('#form-predios-datos-pagos')[0].reset();
        clear_form_elements("#form-predios-datos-pagos");
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
        $('#form-predios-datos-acuerdos-pago')[0].reset();
        clear_form_elements("#form-predios-datos-acuerdos-pago");
    });

    /// datos-abonos
    $('#modal-datos-abonos').on('show.bs.modal', function() {
        if ($('#tr_predio_' + $('#id_edit').val()).attr('data-da') !== undefined) {
            var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-da'));
            if (objJson.length !== undefined) {
                setFormData('form-predios-datos-abonos', objJson[0]);
                $('#new_da').css('display', '');
                $('#cancel_da').css('display', 'none');
                if (DTAbonos !== null) {
                    DTAbonos.page(0).draw('page');
                    DTAbonos.search('')
                        .columns().search('')
                        .draw();

                    var tr = $('#abonosTable').find('tbody').find('tr:eq(0)');
                    DTAbonos.$('.row-selected').toggleClass('row-selected');
                    $(tr).addClass('row-selected');
                }
            }
        }
    });

    $('#modal-datos-abonos').on('hidden.bs.modal', function() {
        $('.datohidden').remove();
        $('#form-predios-datos-abonos')[0].reset();
        clear_form_elements("#form-predios-datos-abonos");
        idx_update = 0;
        current_page = 0;
        $('#text_page_abono').html('Edici&oacute;n<br />P&aacute;gina: 1');
        $('#text_row_abono').html('Fila: 1');
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
        $('#form-predios-datos-procesos-historicos')[0].reset();
        clear_form_elements("#form-predios-datos-procesos-historicos");
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

    $('#new_da').off('click').on('click', function() {
        $('.datohidden').remove();
        $(this).css('display', 'none');
        $('#cancel_da').css('display', '');
        $('.info_abonos').css('display', 'none');
        $('#form-predios-datos-abonos')[0].reset();
        clear_form_elements("#form-predios-datos-abonos");
        $('#divAbonosTable').css('display', 'none');
        if (DTAbonos !== null) {
            DTAbonos.$('.row-selected').toggleClass('row-selected');
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

    $('#cancel_da').off('click').on('click', function() {
        $('#new_da').css('display', '');
        $(this).css('display', 'none');
        $('.info_abonos').css('display', '');
        if (DTAbonos !== null) {
            var data = DTAbonos.rows().data();
            if (data.length > 1) {
                if (idx_update >= 0) {
                    DTAbonos.page(current_page).draw('page');
                    DTAbonos.$('tr:eq(' + idx_update + ')').toggleClass('row-selected');
                    DTAbonos.$('tr:eq(' + idx_update + ')').find('.editAbono').trigger('click');
                }
                $('#divAbonosTable').css('display', '');
            }
        } else {
            if ($('#tr_predio_' + $('#id_edit').val()).attr('data-da') !== undefined) {
                var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-da'));
                if (objJson.length !== undefined) {
                    setFormData('form-predios-datos-abonos', objJson[0]);
                }
            }
        }
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

    DTAbonos = $('#abonosTable').DataTable({
        initComplete: function(settings, json) {
            $('#divAbonosTable').css('display', '');
        },
        "destroy": true,
        "ordering": false,
        //"filter": false,
        "order": [],
        "lengthChange": false,
        "info": false,
        "pageLength": PAGE_LENGTH,
        "select": false,
        "autoWidth": false,
        "language": {
            "url": ROOT_URL + "/theme/plugins/bower_components/datatables/spanish.json"
        },
        'data': [],
        'columns': [{
            data: 'id',
            title: 'id',
            visible: false
        }, {
            data: 'anio_abono',
            title: 'A&ntilde;o',
            defaultContent: ''
        }, {
            data: 'factura_abono',
            title: 'Factura abono',
            defaultContent: ''
        }, {
            //data: 'valor_abono',
            title: 'Valor abono',
            "render": function(data, type, row, meta) {
                return accounting.formatMoney(Number(row.valor_abono), "$ ", 2, ".", ",");
            }
        }, {
            title: 'Acción',
            "render": function(data, type, row, meta) {
                return '<a href="#" data-toggle="tooltip" data-placement="top" title="Editar abono" class="editAbono"> <i class="fa fa-edit"></i> </a>';
            }
        }],
        drawCallback: function(settings) {
            $('.editAbono').off('click').on('click', function() {
                var tr = $(this).closest('tr');
                var data = DTAbonos.row(tr).data();
                $('.datohidden').remove();
                setFormData('form-predios-datos-abonos', data);
                $('#new_da').css('display', '');
                $('#cancel_da').css('display', 'none');
                DTAbonos.$('.row-selected').toggleClass('row-selected');
                $(tr).addClass('row-selected');
                idx_update = DTAbonos.row(tr).index();
                var info = DTAbonos.page.info();
                current_page = info.page;
                $('#text_page').html('Edici&oacute;n<br />P&aacute;gina: ' + (current_page + 1));
                var row = ((idx_update + 1) % PAGE_LENGTH) === 0 ? PAGE_LENGTH : (idx_update + 1) % PAGE_LENGTH;
                $('#text_row').html('Fila: ' + row);
            });
        },
        columnDefs: [
            { className: 'text-center', "targets": [1, 2, 3, 4] }
            //{ className: 'text-center', "targets": [6] },
            //{ className: 'text-right money', targets: [1, 2] },
            //{ className: 'text-center stock_selected', targets: [4] },
            //, { "visible": false, "targets": [2] }
        ]
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
                    //$('#' + modal).modal('hide');
                    if (response.obj !== undefined) {
                        var objJson = null;
                        var arr = [];
                        if (suffix === 'dp') {
                            if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dp') !== undefined) {
                                objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dp'));
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
                                arr.push(response.obj);
                                $('#tr_predio_' + $('#id_edit').val()).attr('data-' + suffix, JSON.stringify(arr));
                            }
                        } else {
                            $('#tr_predio_' + $('#id_edit').val()).attr('data-' + suffix, JSON.stringify(response.obj));
                            if (suffix === 'da') {
                                if (DTAbonos !== null) {
                                    DTAbonos.clear().draw();
                                    DTAbonos.rows.add(response.obj).draw();
                                    if (jsonObj.id !== undefined) { // actualizando reg
                                        if (idx_update >= 0) {
                                            DTAbonos.page(current_page).draw('page');
                                            DTAbonos.$('tr:eq(' + idx_update + ')').toggleClass('row-selected');
                                        }
                                    } else {
                                        var info = DTAbonos.page.info();
                                        DTAbonos.page(info.pages - 1).draw('page');
                                        var last_row = DTAbonos.row(':last').index();
                                        DTAbonos.$('tr:eq(' + last_row + ')').toggleClass('row-selected');
                                        DTAbonos.$('tr:last').find('.editAbono').trigger('click');
                                        $('#divAbonosTable').css('display', '');
                                        $('#new_da').css('display', '');
                                        $('#cancel_da').css('display', 'none');
                                        $('.info_abonos').css('display', '');
                                    }
                                }
                            }
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
                        // $('.datohidden').remove();
                        // $('#' + form)[0].reset();
                        // clear_form_elements("#" + form);
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

            if (response.predio_abonos !== undefined && response.predio_abonos !== null) {
                $('#tr_predio_' + $('#id_edit').val()).attr('data-da', JSON.stringify(response.predio_abonos));
                if (response.predio_abonos.length > 1) {
                    if (DTAbonos !== null) {
                        DTAbonos.clear().draw();
                        DTAbonos.rows.add(response.predio_abonos).draw();
                    }
                }
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