var global_json = null;
var global_json_predio = null;
var global_url_autocomplete_predio = "/autocomplete";
var arr_autonumeric = ['porcentaje', 'minimo_urbano', 'minimo_rural', 'avaluo_inicial', 'avaluo_final', 'tarifa', 'porcentaje_car',
    'area_metros', 'area_construida', 'area_hectareas', 'tarifa_actual', 'avaluo', 'avaluo_presente_anio', 'valor_pago', 'valor_abono',
    'valor_facturado', 'avaluoigac', 'area'
];
var ROOT_URL = window.location.protocol + "//" + window.location.host;
$(document).ready(function() {

    if ($('#codigo_predio').length > 0) {
        $('.buttonTareas').css('display', 'none');
    }

    if ($('#tab').length > 0) {
        $('#' + $('#tab').val()).trigger('click');
    }

    if ($('#li-section-bar-1').length > 0) {
        $('#li-section-bar-1').bind('click', function() {
            if ($('#tab').val() === 'li-section-bar-2') {
                if ($('#codigo_predio').length > 0) {
                    $('.buttonTareas').css('display', 'none');
                    $('.span_predio').html('');
                    $('.span_predio').closest('div').parent('div').css('opacity', '0');
                    $('.codigo_15').find('input').val('');
                    $('.codigo_25').find('input').val('');
                    $('.codigo_15_25').find('input').val('');
                    $('.codigo_25').css({
                        'display': 'none'
                    });
                    $('.codigo_15').css({
                        'display': ''
                    });
                }

                if ($("#pagosTable").length > 0) {
                    if (DTPagos !== null) {
                        DTPagos.clear().draw();
                        $("#pagos-filtro-form")[0].reset();
                        clear_form_elements("#pagos-filtro-form");
                    }
                }
                $('.result').empty();
                if ($('#tab').length > 0) {
                    $('#tab').val('li-section-bar-1');
                }
                setTimeout(function() {
                    $('#btn_cancel_edit').trigger('click');
                }, 300);

                if ($("#update-form").length > 0) {
                    $("#update-form")[0].reset();
                    $('.text-danger').remove();
                    clear_form_elements("#update-form");
                    var validatorUpdate = $("#update-form").validate();
                    validatorUpdate.resetForm();
                    if ($("#create-form").length > 0) {
                        $("#create-form")[0].reset();
                        clear_form_elements("#create-form");
                        var validatorCreate = $("#create-form").validate();
                        validatorCreate.resetForm();
                    }
                    $.each($(".selectpicker"), function(i, el) {
                        var val = $(el).find('option:selected').val();
                        if (val !== undefined)
                            $(el).val(val).selectpicker("refresh");
                        else
                            $(el).val('default').selectpicker("refresh");
                    });

                    $.each($('.has-success'), function(i, el) {
                        $(el).removeClass('has-success');
                    });
                    $.each($('.has-error'), function(i, el) {
                        $(el).removeClass('has-error');
                    });
                }

                // Limpiar la ultima busqueda realizada en predios
                if($('#id_predio.select2.json').length > 0) {
                    $('#id_predio.select2.json').val(null).trigger('change');
                    $('#id_predio.select2.json').find('option').remove();
                    if($('#myTable').length > 0) {
                        $('#myTable').find('tbody').empty();
                    }
                }
            }
        });
    }

    if ($('#li-section-bar-2').length > 0) {
        $('#li-section-bar-2').bind('click', function() {
            if ($('#tab').val() === 'li-section-bar-1') {
                //$('#btn_cancel_edit').trigger('click');
                //} else {
                $('.result').empty();
                if ($('#tab').length > 0) {
                    $('#tab').val('li-section-bar-2');
                }

                if ($("#create-form").length > 0) {
                    $("#create-form")[0].reset();
                    $('.text-danger').remove();
                    clear_form_elements("#create-form");
                    var validatorCreate = $("#create-form").validate();
                    validatorCreate.resetForm();
                    if ($("#update-form").length > 0) {
                        $("#update-form")[0].reset();
                        clear_form_elements("#update-form");
                        var validatorUpdate = $("#update-form").validate();
                        validatorUpdate.resetForm();
                    }
                    $.each($(".selectpicker"), function(i, el) {
                        var val = $(el).find('option:selected').val();
                        if (val !== undefined)
                            $(el).val(val).selectpicker("refresh");
                        else
                            $(el).val('default').selectpicker("refresh");
                    });
                    $.each($('.has-success'), function(i, el) {
                        $(el).removeClass('has-success');
                    });
                    $.each($('.has-error'), function(i, el) {
                        $(el).removeClass('has-error');
                    });
                }
            }
        });
    }

    if ($('#btn_save_edit').length > 0) {
        $('#btn_save_edit').off('click').on('click', function() {
            if($('#update-form').valid()) {
                checkSaveResolucion($(this).closest('form'), $(this).closest('form').attr('desc-to-resolucion-modal'));
            }
        });
    }

    if ($('#btn_save_create').length > 0) {
        $('#btn_save_create').off('click').on('click', function() {
            if($('#create-form').valid()) {
                checkSaveResolucion($(this).closest('form'), $(this).closest('form').attr('desc-to-resolucion-modal'));
            }
        });
    }

    if ($('#btn_cancel_edit').length > 0) {
        $('#btn_cancel_edit').off('click').on('click', function() {
            $('#div_edit_form').fadeOut(function() {
                if ($('#codigo_predio').length > 0) {
                    $('.buttonTareas').css('display', 'none');
                    $('.codigo_15_edit').find('input').val('');
                    $('.codigo_25_edit').find('input').val('');
                    $('.codigo_15_25_edit').find('input').val('');
                }
                if ($('#div_table').length > 0)
                    $('#div_table').fadeIn();

                // if ($('#timeline_citas').length > 0)
                //     $('#timeline_citas').fadeIn();

                // if ($('#div_est_usu_tmp_edit').length > 0) {
                //     $('#label_est_usu_edit').text(' Inactivo');
                //     $('#est_usu_tmp_edit').prop('checked', false);
                // }

                if ($("#create-form").length > 0) {
                    var validatorCreate = $("#create-form").validate();
                    validatorCreate.resetForm();
                    $.each($('.has-success'), function(i, el) {
                        $(el).removeClass('has-success');
                    });
                    $.each($('.has-error'), function(i, el) {
                        $(el).removeClass('has-error');
                    });
                }

                if ($("#update-form").length > 0) {
                    var validatorUpdate = $("#update-form").validate();
                    validatorUpdate.resetForm();
                    $.each($('.has-success'), function(i, el) {
                        $(el).removeClass('has-success');
                    });
                    $.each($('.has-error'), function(i, el) {
                        $(el).removeClass('has-error');
                    });
                }

            });
        });
    }

    setEditRow(true);
    setModifyRow();
    setDeleteRow();

    $('.selectpicker').selectpicker();
    $('.selectpicker-noval').selectpicker();

    $('.selectpicker').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        if ($("#create-form").length > 0) {
            $('#create-form').validate().element($(this));
        }
        if ($("#update-form").length > 0) {
            $('#update-form').validate().element($(this));
        }
    });

    $('.datepicker').datepicker({
        language: 'es-ES',
        format: 'yyyy-mm-dd',
        //startDate: ($('#fec_cit').length > 0) ? moment($('#fer_cit').val()) : null, // Or '02/14/2014'
        hide: function() {
            if ($("#create-form").length > 0) {
                if ($('#' + $(this).attr('id') + '-error').length > 0)
                    $('#' + $(this).attr('id') + '-error').remove();

                if ($('#create-form').is(':visible')) {
                    $('#create-form').validate().element($(this));
                }
            }
            if ($("#update-form").length > 0) {
                if ($('#' + $(this).attr('id') + '-error').length > 0)
                    $('#' + $(this).attr('id') + '-error').remove();

                if ($('#update-form').is(':visible')) {
                    $('#update-form').validate().element($(this));
                }
            }
        }
    });

    if ($('.datelimite').length > 0) {
        $('.datelimite').datepicker({
            language: 'es-ES',
            format: 'yyyy-mm-dd',
            //startDate: moment($('#fecha_oculta').val()), // Or '02/14/2014'
            hide: function() {
                if ($("#create-form").length > 0) {
                    if ($('#' + $(this).attr('id') + '-error').length > 0)
                        $('#' + $(this).attr('id') + '-error').remove();

                    if ($('#create-form').is(':visible')) {
                        $('#create-form').validate().element($(this));
                    }
                }
                if ($("#update-form").length > 0) {
                    if ($('#' + $(this).attr('id') + '-error').length > 0)
                        $('#' + $(this).attr('id') + '-error').remove();

                    if ($('#update-form').is(':visible')) {
                        $('#update-form').validate().element($(this));
                    }
                }
            },
            pick: function() {
                $('.text-danger').remove();
                // var control = $(this);
                // var hour_control = $(control).attr('data-control');
                // var date = $(control).datepicker('getDate', true);
                // if (!hour_control.includes('edit')) {

                //     $.ajax({
                //         type: 'GET',
                //         url: '/available/hours',
                //         data: {
                //             date: date
                //         },
                //         success: function(response) {
                //             if ((response.data.length > 0 && response.data.length < 19) || $('#' + hour_control).children('option').length < 19) {
                //                 $('#' + hour_control).empty();
                //                 $.each(response.data, function(i, el) {
                //                     var option = $('<option value="' + el + '">' + el + '</option>');
                //                     $('#' + hour_control).append(option);
                //                 });
                //                 $('#' + hour_control).selectpicker("refresh");
                //             } else {
                //                 $('#' + hour_control).val('default').selectpicker("refresh");
                //             }
                //         },
                //         error: function(xhr) {
                //             console.log(xhr.responseText);
                //         }
                //     });
                // } else {
                //     $.ajax({
                //         type: 'GET',
                //         url: '/iavailable/hours',
                //         data: {
                //             date: date,
                //             hour: global_json.hor_cit
                //         },
                //         success: function(response) {
                //             if (response.data.length > 0 && response.data.length < 19) {
                //                 $('#' + hour_control).empty();
                //                 $.each(response.data, function(i, el) {
                //                     var option = $('<option value="' + el + '">' + el + '</option>');
                //                     $('#' + hour_control).append(option);
                //                 });
                //                 if (date === global_json.fec_cit) {
                //                     $('#' + hour_control).selectpicker('val', global_json.hor_cit);
                //                 }

                //                 $('#' + hour_control).selectpicker("refresh");

                //             } else {
                //                 if (date === global_json.fec_cit) {
                //                     $('#' + hour_control).selectpicker('val', global_json.hor_cit);
                //                     $('#' + hour_control).selectpicker("refresh");
                //                 } else {
                //                     $('#' + hour_control).val('default').selectpicker("refresh");
                //                 }
                //             }
                //         },
                //         error: function(xhr) {
                //             console.log(xhr.responseText);
                //         }
                //     });
                // }
            }
        });
    }

    $.each(arr_autonumeric, function(i, el) {
        if ($('#' + el).length > 0) {
            if ($('#' + el).hasClass('porcentaje')) {
                new AutoNumeric('#' + el, {
                    emptyInputBehavior: "zero",
                    maximumValue: "100",
                    minimumValue: "0",
                    modifyValueOnWheel: false,
                    suffixText: "%",
                    unformatOnSubmit: true
                });
            } else {
                new AutoNumeric('#' + el, {
                    emptyInputBehavior: "zero",
                    minimumValue: "0",
                    modifyValueOnWheel: false,
                    unformatOnSubmit: true
                });
            }
        }
        if ($('#' + el + '_edit').length > 0) {
            if ($('#' + el).hasClass('porcentaje')) {
                new AutoNumeric('#' + el + '_edit', {
                    emptyInputBehavior: "zero",
                    maximumValue: "100",
                    minimumValue: "0",
                    modifyValueOnWheel: false,
                    suffixText: "%",
                    unformatOnSubmit: true
                });
            } else {
                new AutoNumeric('#' + el + '_edit', {
                    emptyInputBehavior: "zero",
                    minimumValue: "0",
                    modifyValueOnWheel: false,
                    unformatOnSubmit: true
                });
            }
        }
    });

    if ($('#aplica_interes').length > 0) {
        $('#aplica_interes').off('click').on('click', function() {
            if ($(this).is(':checked')) {
                $('#span_aplica_interes').html('SI');
                $(this).val(1);
            } else {
                $('#span_aplica_interes').html('NO');
                $(this).val(0);
            }
        });

        $('#aplica_interes_edit').off('click').on('click', function() {
            if ($(this).is(':checked')) {
                $('#span_aplica_interes_edit').html('SI');
                $(this).val(1);
            } else {
                $('#span_aplica_interes_edit').html('NO');
                $(this).val(0);
            }
        });
    }

    if ($('#capital').length > 0) {
        $('#capital').off('click').on('click', function() {
            if ($(this).is(':checked')) {
                $('#span_capital').html('SI');
                $(this).val(1);
            } else {
                $('#span_capital').html('NO');
                $(this).val(0);
            }
        });

        $('#capital_edit').off('click').on('click', function() {
            if ($(this).is(':checked')) {
                $('#span_capital_edit').html('SI');
                $(this).val(1);
            } else {
                $('#span_capital_edit').html('NO');
                $(this).val(0);
            }
        });
    }

    if ($('#interes').length > 0) {
        $('#interes').off('click').on('click', function() {
            if ($(this).is(':checked')) {
                $('#span_interes').html('SI');
                $(this).val(1);
            } else {
                $('#span_interes').html('NO');
                $(this).val(0);
            }
        });

        $('#interes_edit').off('click').on('click', function() {
            if ($(this).is(':checked')) {
                $('#span_interes_edit').html('SI');
                $(this).val(1);
            } else {
                $('#span_interes_edit').html('NO');
                $(this).val(0);
            }
        });
    }

    if ($("#create-form").length > 0) {
        $('#create-form').validate().settings.ignore = '';
        $('#create-form').validate().settings.errorPlacement = function(error, element) {
            if (element.hasClass('selectpicker')) {
                element.next().after(error);
            } else if (element.hasClass('withadon')) {
                element.parent().after(error);
            } else {
                error.insertAfter(element);
            }
        };
    }

    if ($("#update-form").length > 0) {
        $('#update-form').validate().settings.ignore = '';
        $('#update-form').validate().settings.errorPlacement = function(error, element) {
            if (element.hasClass('selectpicker')) {
                element.next().after(error);
            } else if (element.hasClass('withadon')) {
                element.parent().after(error);
            } else {
                error.insertAfter(element);
            }
        };
    }

    if ($('.nofocus').length > 0) {
        $('.nofocus').off('focus').on('focus', function() {
            $(this).blur();
        });
    }

    $('.buttonTareas a').bind('click', function(evt) {
        evt.preventDefault();
    });

    if($('#exoneracion_desde').length > 0) {
        $('#exoneracion_desde').off('keyup blur change').on('keyup blur change', function() {
            if($(this).val().length === 4) {
                if($('#exoneracion_hasta').val().length === 4) {
                    var validatorCreate = $("#create-form").validate();
                    validatorCreate.resetForm();
                    $.each($('.has-success'), function(i, el) {
                        $(el).removeClass('has-success');
                    });
                    $.each($('.has-error'), function(i, el) {
                        $(el).removeClass('has-error');
                    });
                    $('#create-form').validate().element($('#exoneracion_hasta'));
                }
            }
        });
        $('#exoneracion_hasta').off('keyup blur change').on('keyup blur change', function() {
            if($(this).val().length === 4) {
                if($('#exoneracion_desde').val().length === 4) {
                    $('#create-form').validate().element($('#exoneracion_desde'));
                    $('#exoneracion_desde').trigger('blur');
                }
            }
        });
        $('#exoneracion_desde_edit').off('keyup blur change').on('keyup blur change', function() {
            if($(this).val().length === 4) {
                if($('#exoneracion_hasta_edit').val().length === 4) {
                    var validatorUpdate = $("#update-form").validate();
                    validatorUpdate.resetForm();
                    $.each($('.has-success'), function(i, el) {
                        $(el).removeClass('has-success');
                    });
                    $.each($('.has-error'), function(i, el) {
                        $(el).removeClass('has-error');
                    });
                    $('#update-form').validate().element($('#exoneracion_hasta_edit'));
                }
            }
        });
        $('#exoneracion_hasta_edit').off('keyup blur change').on('keyup blur change', function() {
            if($(this).val().length === 4) {
                if($('#exoneracion_desde_edit').val().length === 4) {
                    $('#update-form').validate().element($('#exoneracion_desde_edit'));
                    $('#exoneracion_desde_edit').trigger('blur');
                }
            }
        });
    }

    if($('#id_predio.select2').length > 0) {
        $('#id_predio.select2').select2({
            language: "es",
            placeholder: "Buscar...",
            allowClear: true,
            minimumInputLength: 3,
            ajax: {
                url: global_url_autocomplete_predio,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });

        $('#id_predio.select2').on('select2:select', function (e) {
            if ($('#id_predio.select2').closest('form').length > 0) {
                if ($('#id_predio.select2').closest('form').attr('id') === 'create-form') {
                    $('#create-form').validate().element($('#id_predio.select2'));
                }
            }
            else {
                if($('#id_predio.select2').hasClass('json')) {
                    getPredio($('#id_predio.select2').val());
                }
            }
        });

        $('#id_predio.select2').on('select2:clear', function (e) {
            global_json_predio = null;
            if ($('#id_predio.select2').closest('form').length > 0) {
                if ($('#id_predio.select2').closest('form').attr('id') === 'create-form') {
                    $('#create-form').validate().element($('#id_predio.select2'));
                }
            }
            else {
                if($('#id_predio.select2').hasClass('json')) {
                    $('.predio_row').remove();
                }
            }
        });
    }

    if($('#id_predio_edit.select2').length > 0) {
        $('#id_predio_edit.select2').select2({
            language: "es",
            placeholder: "Buscar...",
            allowClear: true,
            minimumInputLength: 3,
            ajax: {
                url: global_url_autocomplete_predio,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
                },
                processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                    more: (params.page * 30) < data.total_count
                    }
                };
                },
                cache: true
            },
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });

        $('#id_predio_edit.select2').on('select2:select', function (e) {
            global_json_predio = null;
            if ($('#id_predio_edit.select2').closest('form').length > 0) {
                if ($('#id_predio_edit.select2').closest('form').attr('id') === 'update-form') {
                    $('#update-form').validate().element($('#id_predio_edit.select2'));
                }
            }
        });

        $('#id_predio_edit.select2').on('select2:clear', function (e) {
            if ($('#id_predio_edit.select2').closest('form').length > 0) {
                if ($('#id_predio_edit.select2').closest('form').attr('id') === 'update-form') {
                    $('#update-form').validate().element($('#id_predio_edit.select2'));
                }
            }
        });
    }

});

function setEditRow(initDataTable) {
    if ($('.edit_row').length > 0) {
        $('.edit_row').off('click').on('click', function() {
            var row = $(this).parent('tr');
            if (!$(row).hasClass('disabled')) {
                var jsonObj = JSON.parse($(row).attr('json-data'));
                global_json = jsonObj;
                if(global_json.prescrito === undefined || Number(global_json.prescrito) < 1) {
                    $('.result').empty();
                    if ($(row).hasClass('descuento_row')) {
                        $('#porcentaje_edit').prop('readonly', false);
                        $('#fecha_inicio_edit').prop('readonly', true);
                        $('#fecha_fin_edit').prop('readonly', true);
                        $('#fecha_fin_edit').datepicker('destroy');

                        if (moment($('#fecha_oculta').val()) <= moment(jsonObj.fecha_fin) && moment($('#fecha_oculta').val()) > moment(jsonObj.fecha_inicio)) {
                            $('#porcentaje_edit').prop('readonly', true);
                            $('#fecha_fin_edit').prop('readonly', false);
                            $('#fecha_fin_edit').datepicker({
                                language: 'es-ES',
                                format: 'yyyy-mm-dd',
                                startDate: moment($('#fecha_oculta').val()), // Or '02/14/2014'
                                hide: function() {
                                    if ($("#create-form").length > 0) {
                                        if ($('#' + $(this).attr('id') + '-error').length > 0)
                                            $('#' + $(this).attr('id') + '-error').remove();

                                        $('#create-form').validate().element($(this));
                                    }
                                    if ($("#update-form").length > 0) {
                                        if ($('#' + $(this).attr('id') + '-error').length > 0)
                                            $('#' + $(this).attr('id') + '-error').remove();

                                        $('#update-form').validate().element($(this));
                                    }
                                },
                                pick: function() {
                                    $('.text-danger').remove();
                                }
                            });
                        }

                        //     var hour_control = $(row).attr('data-control');
                        //     $.ajax({
                        //         type: 'GET',
                        //         url: '/iavailable/hours',
                        //         data: {
                        //             date: jsonObj.fec_cit,
                        //             hour: jsonObj.hor_cit
                        //         },
                        //         success: function(response) {
                        //             if (response.data.length > 0 && response.data.length < 19) {
                        //                 $('#' + hour_control).empty();
                        //                 $.each(response.data, function(i, el) {
                        //                     var option = $('<option value="' + el + '">' + el + '</option>');
                        //                     $('#' + hour_control).append(option);
                        //                 });
                        //                 $('#' + hour_control).selectpicker("refresh");
                        //                 setData(jsonObj);
                        //             } else {
                        //                 $('#' + hour_control).val('default').selectpicker("refresh");
                        //                 setData(jsonObj);
                        //             }
                        //         },
                        //         error: function(xhr) {
                        //             console.log(xhr.responseText);
                        //             setData(jsonObj);
                        //         }
                        //     });
                    } //else {

                    setData(jsonObj);
                    // }
                }
            }
        });

        if(initDataTable) {
            $('#myTable').DataTable({
                "destroy": true,
                "ordering": false,
                "order": [],
                "lengthChange": false,
                "info": false,
                "pageLength": 5,
                "select": false,
                "autoWidth": false,
                "language": {
                    "url": ROOT_URL + "/theme/plugins/bower_components/datatables/spanish.json"
                }
            });
        }
    }
}

function setModifyRow() {
    if ($('.modify_row').length > 0) {
        $('.modify_row').off('click').on('click', function(evt) {
            $(this).closest('tr').find('td:eq(0)').trigger('click');
        });
    }
}

function setDeleteRow() {
    if ($('.delete_row').length > 0) {
        $('.delete_row').off('click').on('click', function(evt) {
            var btn = $(this);
            var msg = "¿Está seguro/a que desea eliminar el registro?";
            if ($(btn).is('[msg]')) {
                msg = $(btn).attr('msg');
            }
            swal({
                title: "Atención",
                text: msg,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si",
                cancelButtonText: "No",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {
                    $('#input_delete').val($(btn).attr('ide'));
                    if ($(btn).attr('req_res') !== undefined) {
                        $('#txt_operacion_resolucion').html('<span class="text-danger">Operaci&oacute;n:&nbsp;</span>Anulaci&oacuten de predio');
                        global_form_to_send = 'form_delete';
                        $('#modal-resolucion').modal('show');
                    } else {
                        $('#form_delete').first().submit();
                    }
                }
            });
        });
    }
}

function setDownloadRow() {
    if ($('.download_row').length > 0) {
        $('.download_row').off('click').on('click', function(evt) {
            var btn = $(this);

            $(btn).attr('disabled', true);

            $.toast({
                heading: 'Atención',
                text: 'Iniciando ejecución de cálculo predial. Espere un momento por favor.',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'warning',
                hideAfter: 4000,
                stack: 6
            });

            setTimeout(function() {
                if ($('#iframe_reporte').length > 0) {
                    $('#iframe_reporte').remove();
                }
                var iframe = $('<iframe id="iframe_reporte" style="display:none;"></iframe>');
                iframe.attr('src', $(btn).attr('url'));
                $('body').append(iframe);
                $(btn).attr('disabled', false);
            }, 1000);

            // setTimeout(function() {
            //     $.toast({
            //         heading: 'Información',
            //         text: 'El cálculo predial ha sido ejecutado satisfactoriamente. Inicia descarga de factura.',
            //         position: 'top-right',
            //         loaderBg: '#fff',
            //         icon: 'success',
            //         hideAfter: 3000,
            //         stack: 6
            //     });
            //     setTimeout(function() {
            //         if ($('#iframe_reporte').length > 0) {
            //             $('#iframe_reporte').remove();
            //         }
            //         var iframe = $('<iframe id="iframe_reporte" style="display:none;"></iframe>');
            //         iframe.attr('src', $(btn).attr('url'));
            //         $('body').append(iframe);
            //         $(btn).attr('disabled', false);
            //     }, 2000);
            // }, 2000);
        });
    }
}

function getPredio(id_predio) {
    var jsonObj = {};
    jsonObj.id_predio = id_predio;
    $.ajax({
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: 'json',
        url: '/get_predio',
        data: {
            form: JSON.stringify(jsonObj)
        },
        success: function(response) {
            $('#myTable').find('tbody').empty();
            if (response.length > 0) {
                var opcion = JSON.parse($('#opcion').val());
                var predio = response[0];
                var classBtn = 'btn-warning';
                var disabledBtnEdita = '';
                var disabledBtnPrescribe = '';
                var disabledBtnCalculo = '';
                var disabledBtnElimina = '';
                var tr = $('<tr style="cursor: pointer;" id="tr_predio_' + predio.id + '" json-data=\'' + JSON.stringify(predio) + '\' class="predio_row"></tr>');
                var td_1 = $('<td class="edit_row cell_center">' + predio.codigo_predio + '</td>');
                if(Number(predio.prescrito) > 0) {
                    td_1.append('&nbsp;&nbsp;<span class="tips" style="color: #25ca59;" title="Prescrito hasta ' + predio.prescribe_hasta + '"><i class="fa fa-info-circle"></i></span>');
                    classBtn = 'btn-default tips';
                    disabledBtnPrescribe = 'disabled="disabled"';
                    disabledBtnCalculo = 'disabled="disabled"';
                    disabledBtnEdita = 'disabled="disabled"';
                    disabledBtnElimina = 'disabled="disabled"';
                }
                // if(Number(global_json_predio.tiene_pago) === 0) {
                //     disabledBtnCalculo = 'disabled="disabled"';
                // }
                var td_2 = $('<td class="edit_row cell_center">' + predio.direccion + '</td>');
                var td_3 = $('<td class="edit_row cell_center">' + predio.propietarios + '</td>');
                var td_4 = $('<td class="cell_center"></td>');

                var htmlBotones = '<button type="button" ide="' + predio.id + '" class="modify_row btn btn-info" req_res="' + opcion.resolucion_edita + '" ' + disabledBtnEdita + '><i class="fa fa-pencil-square"></i></button>' +
                                  '&nbsp;&nbsp;' +
                                  '<button type="button" ide="' + predio.id + '" class="prescribe_row btn ' + classBtn + '" ' + disabledBtnPrescribe + '><i class="fa fa-clock-o"></i></button>' +
                                  '&nbsp;&nbsp;' +
                                  '<button type="button" ide="' + predio.id + '" class="download_row btn btn-success" url="/generate_factura_pdf/' + predio.id + '" msg="¿Está seguro/a que desea ejecutar el cálculo?" ' + disabledBtnCalculo + '><i class="fa fa-cogs"></i></button>' +
                                  '&nbsp;&nbsp;' +
                                  '<button type="button" ide="' + predio.id + '" class="delete_row btn btn-inverse" req_res="' + opcion.resolucion_elimina + '" msg="¿Está seguro/a que desea anular el predio?" ' + disabledBtnElimina + '><i class="fa fa-trash-o"></i></button>';

                td_4.html(htmlBotones);
                tr.append(td_1).append(td_2).append(td_3).append(td_4);
                $('#myTable').find('tbody').append(tr);
                setTimeout(function() {
                    setEditRow(false);
                    setModifyRow();
                    setDeleteRow();
                    setDownloadRow();
                    setPrescribeRow();
                    $('.tips').powerTip({
                        placement: 's' // north-east tooltip position
                    });
                }, 500);
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

function setPrescribeRow() {
    if ($('.prescribe_row').length > 0) {

        $('.prescribe_row').off('click').on('click', function(evt) {
            var btn = $(this);
            $('#input_prescribe').val($(btn).attr('ide'));
            $('#txt_operacion_resolucion').html('<span class="text-danger">Operaci&oacute;n:&nbsp;</span>Prescripci&oacute;n de predio');
            global_form_to_send = 'form_prescribe';
            $('#modal-prescripciones').modal({ backdrop: 'static', keyboard: false }, 'show');
        });

        $('#modal-prescripciones').on('hidden.bs.modal', function() {
            $('#form-predios-prescripcion')[0].reset();
            clear_form_elements("#form-predios-prescripcion");
            validatorPrescripciones.resetForm();
        });
        $('#modal-prescripciones').on('shown.bs.modal', function() {
            $('#prescribe_hasta').focus();
        });

        $('#save_prescripcion').off('click').on('click', function() {
            var form = $("#form-predios-prescripcion");
            if (form.valid()) {
                var input_prescribe_hasta = $('<input class="datohidden" id="prescribe_hasta" name="prescribe_hasta" type="hidden" value="' + $('#prescribe_hasta_modal').val() + '"  />');
                $('#' + global_form_to_send).prepend(input_prescribe_hasta);
                $('#modal-resolucion').modal('show');
                $('#modal-prescripciones').modal('hide');
            }
        });

        var validatorPrescripciones = $("#form-predios-prescripcion").validate({
            rules: {
                prescribe_hasta_modal: "required"
                    /*email: {
                        required: true,
                        email: true
                    }*/
            },
            messages: {
                prescribe_hasta_modal: "A&ntilde;o prescripci&oacute;n requerido."
                    /*email: {
                        required: "We need your email address to contact you",
                        email: "Your email address must be in the format of name@domain.com"
                    }*/
            }
        });
    }
}

function formatRepo (repo) {
    if (repo.loading) {
      return repo.text;
    }

    var $container = $(
      "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__avatar'><img src='data:image/png;base64,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' /></div>" +
        //"<div class='select2-result-repository__avatar'>" + repo.text + "</div>" +
        "<div class='select2-result-repository__meta'>" +
          "<div class='select2-result-repository__title'></div>" +
          "<div class='select2-result-repository__description'></div>" +
           "<div class='select2-result-repository__statistics'>" +
             "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> </div>" +
        //     "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> </div>" +
        //     "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> </div>" +
           "</div>" +
        "</div>" +
      "</div>"
    );

    $container.find(".select2-result-repository__title").text(repo.text);
    $container.find(".select2-result-repository__description").text(repo.codigo_predio);
    $container.find(".select2-result-repository__forks").append(repo.propietarios);

    //$container.find(".select2-result-repository__title").text(repo.full_name);
    // $container.find(".select2-result-repository__description").text(repo.description);
    // $container.find(".select2-result-repository__forks").append(repo.forks_count + " Forks");
    // $container.find(".select2-result-repository__stargazers").append(repo.stargazers_count + " Stars");
    // $container.find(".select2-result-repository__watchers").append(repo.watchers_count + " Watchers");

    return $container;
}

function formatRepoSelection (repo) {
    global_json_predio = repo;
    return repo.codigo_predio || repo.text;
}

function setData(jsonObj) {
    $('#div_table').fadeOut(function() {
        $.each(jsonObj, function(i, el) {
            if ($('#' + i + '_edit').length > 0) {
                if ($('#' + i + '_edit').hasClass('selectpicker')) {
                    $('#' + i + '_edit').selectpicker('val', el);
                    $('#' + i + '_edit').attr('prev-val', el);
                } else {
                    if (el === '.00') {
                        if ($.inArray(i, arr_autonumeric) >= 0) {
                            AutoNumeric.set('#' + i + '_edit', 0);
                        } else {
                            $('#' + i + '_edit').val('0');
                        }
                        $('#' + i + '_edit').attr('prev-val', '0');
                    } else {
                        if ($.inArray(i, arr_autonumeric) >= 0) {
                            AutoNumeric.set('#' + i + '_edit', Number(el));
                            $('#' + i + '_edit').attr('prev-val', Number(el));
                        } else {
                            $('#' + i + '_edit').val(el);
                            $('#' + i + '_edit').attr('prev-val', el);
                            if ($('#' + i + '_edit').is(':checkbox')) {
                                if (Number(el) > 0) {
                                    if (!$('#' + i + '_edit').is(':checked')) {
                                        $('#' + i + '_edit').trigger('click');
                                    }
                                } else {
                                    if ($('#' + i + '_edit').is(':checked')) {
                                        $('#' + i + '_edit').trigger('click');
                                    }
                                }
                            }
                        }
                    }
                }

                if ($('#h1_' + i + '_edit').length > 0) {
                    $('#h1_' + i + '_edit').text(el);
                }
                if ($('#' + i + '_edit_confirmation').length > 0) {
                    $('#' + i + '_edit_confirmation').val(el);
                }
            }
        });

        // if ($('#div_est_usu_tmp_edit').length > 0) {
        //     if ($('#est_usu_edit').val() === 'A') {
        //         $('#div_est_usu_tmp_edit').trigger('click');
        //     }
        // }

        $('.selectpicker').selectpicker('refresh');
        $('#div_edit_form').fadeIn();

        if ($('#codigo_predio').length > 0) {
            if(jsonObj.prescrito > 0) {
                $('#span_prescribe_hasta').html(jsonObj.prescribe_hasta);
                $('#span_prescribe_hasta').parent().fadeIn();
            }
            else {
                $('#span_prescribe_hasta').empty();
                $('#span_prescribe_hasta').parent().fadeOut();
            }
            addButtonsPredios();
        }

    });
}

function clear_form_elements(ele) {
    $(ele).find(':input').each(function() {
        switch (this.type) {
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
            case 'textarea':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
        }

        if ($('#' + $(this).attr('id') + '_edit').is('[prev-val]')) {
            $('#' + $(this).attr('id') + '_edit').removeAttr('prev-val');
        }
    });

    if($(ele).find('.select2').length > 0) {
        $(ele).find('.select2').val(null).trigger('change');
        $(ele).find('.select2').find('option').remove();
    }

    $.each(arr_autonumeric, function(i, el) {
        if ($(ele).find('#' + el).length > 0) {
            AutoNumeric.set('#' + el, 0);
        }
        if ($(ele).find('#' + el + '_edit').length > 0) {
            AutoNumeric.set('#' + el + '_edit', 0);
            if ($(ele).find('#' + el + '_edit').is('[prev-val]')) {
                $(ele).find('#' + el + '_edit').removeAttr('prev-val');
            }
        }
    });

    $.each($(ele).find('.selectpicker'), function(i, el) {
        $(el).selectpicker('val', '');
        $(el).selectpicker('refresh');
        if ($('#' + $(el).attr('id') + '_edit').is('[prev-val]')) {
            $('#' + $(el).attr('id') + '_edit').removeAttr('prev-val');
        }
    });
    $.each($(ele).find('.selectpicker-noval'), function(i, el) {
        $(el).selectpicker('val', '');
        $(el).selectpicker('refresh');
    });
}

function calcEditLabels() {
    if($('#codigo_predio_edit').val().length < 16) {
        $('.codigo_15_edit').css('display', '');
        $('.codigo_25_edit').css('display', 'none');
        $('.codigo_25_edit').find('input').val('');
        //TIPO
        if ($('#codigo_predio_edit').val().substr(0, 2) !== undefined && $('#codigo_predio_edit').val().substr(0, 2).length > 0) {
            $('#tipo_edit').val($('#codigo_predio_edit').val().substr(0, 2));
            $('#span_tipo_edit').text($('#tipo_edit').val());
            $('#div_tipo_edit').css('opacity', 1);
        } else {
            $('#tipo_edit').val('');
            $('#span_tipo_edit').text('');
            $('#div_tipo_edit').css('opacity', 0);
        }
        //SECTOR
        if ($('#codigo_predio_edit').val().substr(2, 2) !== undefined && $('#codigo_predio_edit').val().substr(2, 2).length > 0) {
            $('#sector_edit').val($('#codigo_predio_edit').val().substr(2, 2));
            $('#span_sector_edit').text($('#sector_edit').val());
            $('#div_sector_edit').css('opacity', 1);
        } else {
            $('#sector_edit').val('');
            $('#span_sector_edit').text('');
            $('#div_sector_edit').css('opacity', 0);
        }
        //MANZANA
        if ($('#codigo_predio_edit').val().substr(4, 4) !== undefined && $('#codigo_predio_edit').val().substr(4, 4).length > 0) {
            $('#manzana_edit').val($('#codigo_predio_edit').val().substr(4, 4));
            $('#span_manzana_edit').text($('#manzana_edit').val());
            $('#div_manzana_edit').css('opacity', 1);
        } else {
            $('#manzana_edit').val('');
            $('#span_manzana_edit').text('');
            $('#div_manzana_edit').css('opacity', 0);
        }
        //PREDIO
        if ($('#codigo_predio_edit').val().substr(8, 4) !== undefined && $('#codigo_predio_edit').val().substr(8, 4).length > 0) {
            $('#predio_edit').val($('#codigo_predio_edit').val().substr(8, 4));
            $('#span_predio_edit').text($('#predio_edit').val());
            $('#div_predio_edit').css('opacity', 1);
        } else {
            $('#predio_edit').val('');
            $('#span_predio_edit').text('');
            $('#div_predio_edit').css('opacity', 0);
        }
        //MEJORA
        if ($('#codigo_predio_edit').val().substr(12) !== undefined && $('#codigo_predio_edit').val().substr(12).length > 0) {
            $('#mejora_edit').val($('#codigo_predio_edit').val().substr(12));
            $('#span_mejora_edit').text($('#mejora_edit').val());
            $('#div_mejora_edit').css('opacity', 1);
        } else {
            $('#mejora_edit').val('');
            $('#span_mejora_edit').text('');
            $('#div_mejora_edit').css('opacity', 0);
        }
    }
    else {
        $('.codigo_15_edit').css('display', 'none');
        $('.codigo_15_edit').find('input').val('');
        $('.codigo_25_edit').css('display', '');
        //ZONA
        if ($('#codigo_predio_edit').val().substr(0, 2) !== undefined && $('#codigo_predio_edit').val().substr(0, 2).length > 0) {
            $('#zona_edit').val($('#codigo_predio_edit').val().substr(0, 2));
            $('#span_zona_edit').text($('#zona_edit').val());
            $('#div_zona_edit').css('opacity', 1);
        } else {
            $('#zona_edit').val('');
            $('#span_zona_edit').text('');
            $('#div_zona_edit').css('opacity', 0);
        }
        //SECTOR
        if ($('#codigo_predio_edit').val().substr(2, 2) !== undefined && $('#codigo_predio_edit').val().substr(2, 2).length > 0) {
            $('#sector_edit').val($('#codigo_predio_edit').val().substr(2, 2));
            $('#span_sector_edit').text($('#sector_edit').val());
            $('#div_sector_edit').css('opacity', 1);
        } else {
            $('#sector_edit').val('');
            $('#span_sector_edit').text('');
            $('#div_sector_edit').css('opacity', 0);
        }
        //COMUNA
        if ($('#codigo_predio_edit').val().substr(4, 2) !== undefined && $('#codigo_predio_edit').val().substr(4, 2).length > 0) {
            $('#comuna_edit').val($('#codigo_predio_edit').val().substr(4, 2));
            $('#span_comuna_edit').text($('#comuna_edit').val());
            $('#div_comuna_edit').css('opacity', 1);
        } else {
            $('#comuna_edit').val('');
            $('#span_comuna_edit').text('');
            $('#div_comuna_edit').css('opacity', 0);
        }
        //BARRIO
        if ($('#codigo_predio_edit').val().substr(6, 2) !== undefined && $('#codigo_predio_edit').val().substr(6, 2).length > 0) {
            $('#barrio_edit').val($('#codigo_predio_edit').val().substr(6, 2));
            $('#span_barrio_edit').text($('#barrio_edit').val());
            $('#div_barrio_edit').css('opacity', 1);
        } else {
            $('#barrio_edit').val('');
            $('#span_barrio_edit').text('');
            $('#div_barrio_edit').css('opacity', 0);
        }
        //MANZANA
        if ($('#codigo_predio_edit').val().substr(8, 4) !== undefined && $('#codigo_predio_edit').val().substr(8, 4).length > 0) {
            $('#manzana_edit').val($('#codigo_predio_edit').val().substr(8, 4));
            $('#span_manzana_edit').text($('#manzana_edit').val());
            $('#div_manzana_edit').css('opacity', 1);
        } else {
            $('#manzana_edit').val('');
            $('#span_manzana_edit').text('');
            $('#div_manzana_edit').css('opacity', 0);
        }
        //TERRENO
        if ($('#codigo_predio_edit').val().substr(12, 4) !== undefined && $('#codigo_predio_edit').val().substr(12, 4).length > 0) {
            $('#terreno_edit').val($('#codigo_predio_edit').val().substr(12, 4));
            $('#span_terreno_edit').text($('#terreno_edit').val());
            $('#div_terreno_edit').css('opacity', 1);
        } else {
            $('#terreno_edit').val('');
            $('#span_terreno_edit').text('');
            $('#div_terreno_edit').css('opacity', 0);
        }
        //CONDICION
        if ($('#codigo_predio_edit').val().substr(16, 1) !== undefined && $('#codigo_predio_edit').val().substr(16, 1).length > 0) {
            $('#condicion_edit').val($('#codigo_predio_edit').val().substr(16, 1));
            $('#span_condicion_edit').text($('#condicion_edit').val());
            $('#div_condicion_edit').css('opacity', 1);
        } else {
            $('#condicion_edit').val('');
            $('#span_condicion_edit').text('');
            $('#div_condicion_edit').css('opacity', 0);
        }
        //EDIFICIO/TORRE
        if ($('#codigo_predio_edit').val().substr(17, 2) !== undefined && $('#codigo_predio_edit').val().substr(17, 2).length > 0) {
            $('#edificio_torre_edit').val($('#codigo_predio_edit').val().substr(17, 2));
            $('#span_edificio_torre_edit').text($('#edificio_torre_edit').val());
            $('#div_edificio_torre_edit').css('opacity', 1);
        } else {
            $('#edificio_torre_edit').val('');
            $('#span_edificio_torre_edit').text('');
            $('#div_edificio_torre_edit').css('opacity', 0);
        }
        //PISO
        if ($('#codigo_predio_edit').val().substr(19, 2) !== undefined && $('#codigo_predio_edit').val().substr(19, 2).length > 0) {
            $('#piso_edit').val($('#codigo_predio_edit').val().substr(19, 2));
            $('#span_piso_edit').text($('#piso_edit').val());
            $('#div_piso_edit').css('opacity', 1);
        } else {
            $('#piso_edit').val('');
            $('#span_piso_edit').text('');
            $('#div_piso_edit').css('opacity', 0);
        }
        //PROPIEDAD
        if ($('#codigo_predio_edit').val().substr(21, 4) !== undefined && $('#codigo_predio_edit').val().substr(21, 4).length > 0) {
            $('#propiedad_edit').val($('#codigo_predio_edit').val().substr(21, 4));
            $('#span_propiedad_edit').text($('#propiedad_edit').val());
            $('#div_propiedad_edit').css('opacity', 1);
        } else {
            $('#propiedad_edit').val('');
            $('#span_propiedad_edit').text('');
            $('#div_propiedad_edit').css('opacity', 0);
        }
    }
}

function addButtonsPredios() {
    $('.buttonTareas').css('display', '');
    calcEditLabels();
    getJsonPrediosDatos();
}

function checkSaveResolucion(form, desc_operacion) {
    var show_resoluciones_modal = false;
    if ($('.resolucion_validate_form_level-' + $(form).attr('id')).length > 0) { // Validacion a nivel de formulario
        $.each($('.res-validate'), function(i, el) {
            if (!$(el).is("div")) {
                if (!$(el).hasClass('selectpicker')) {
                    if ($.inArray($(el).attr('id').replace('_edit', ''), arr_autonumeric) >= 0) {
                        if (Number($(el).attr('prev-val')) !== AutoNumeric.getNumber('#' + $(el).attr('id'))) {
                            show_resoluciones_modal = true;
                            return false;
                        }
                    } else if ($(el).attr('prev-val') !== $(el).val()) {
                        show_resoluciones_modal = true;
                        return false;
                    }
                } else {
                    if ($(el).attr('prev-val') !== $(el).selectpicker('val')) {
                        show_resoluciones_modal = true;
                        return false;
                    }
                }
            }
        });
    }
    else if ($('.resolucion_validate_field_level-' + $(form).attr('id')).length > 0) { // Validacion a nivel de campos individuales
        $.each($('.resolucion_validate_field_level-' + $(form).attr('id')), function(i, el) {
            if ($('#' + $(el).attr('field')).attr('prev-val') !== $('#' + $(el).attr('field')).val()) {
                show_resoluciones_modal = true;
                return false;
            }
        });
    }

    if (show_resoluciones_modal) {
        if($(form).attr('id').includes('create')) {
            $('#txt_operacion_resolucion').html('<span class="text-danger">Operaci&oacute;n:&nbsp;</span>Creaci&oacuten de ' + desc_operacion);
        }
        else {
            $('#txt_operacion_resolucion').html('<span class="text-danger">Operaci&oacute;n:&nbsp;</span>Actualizaci&oacuten de ' + desc_operacion);
        }
        global_form_to_send = $(form).attr('id');
        $('#modal-resolucion').modal('show');
    } else {
        if ($('.resolucion_validate_field_level-' + $(form).attr('id')).length === 0 && $('.resolucion_validate_form_level-' + $(form).attr('id')).length === 0) {
            $('#' + $(form).attr('id')).first().submit();
        }
    }
}
