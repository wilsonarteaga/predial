var global_json = null;
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

    if ($('.edit_row').length > 0) {
        $('.edit_row').off('click').on('click', function() {
            var row = $(this).parent('tr');
            if (!$(row).hasClass('disabled')) {
                var jsonObj = JSON.parse($(row).attr('json-data'));
                global_json = jsonObj;
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
        });
    }

    if ($('.modify_row').length > 0) {
        $('.modify_row').off('click').on('click', function(evt) {
            $(this).closest('tr').find('td:eq(0)').trigger('click');
        });
    }

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

    // if ($('#generar_reporte').length > 0) {
    //     $('#search_control').attr('placeholder', 'Buscar paciente...');
    //     $('#li_search').fadeIn();
    //
    //     $('#generar_reporte').off('click').on('click', function(evt) {
    //         if ($('#iframe_reporte').length > 0)
    //             $('#iframe_reporte').remove();
    //
    //         var iframe = $('<iframe id="iframe_reporte" style="display:none;"></iframe>');
    //         iframe.attr('src', $(this).attr('url'));
    //         $('body').append(iframe);
    //     });
    //
    //     $('.download_row').off('click').on('click', function(evt) {
    //         if ($('#iframe_reporte').length > 0)
    //             $('#iframe_reporte').remove();
    //
    //         var iframe = $('<iframe id="iframe_reporte" style="display:none;"></iframe>');
    //         iframe.attr('src', $(this).attr('url'));
    //         $('body').append(iframe);
    //     });
    // }

    if ($('.edit_row').length > 0) {
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

    // if ($('#div_est_usu_tmp').length > 0) {
    //     $('#div_est_usu_tmp').off('click').on('click', function() {
    //         if ($('#est_usu_tmp').is(':checked')) {
    //             $('#est_usu').val('A');
    //             $('#label_est_usu').text(' Activo');
    //         } else {
    //             $('#est_usu').val('I');
    //             $('#label_est_usu').text(' Inactivo');
    //         }
    //     });
    // }

    // if ($('#div_est_usu_tmp_edit').length > 0) {
    //     $('#div_est_usu_tmp_edit').off('click').on('click', function() {
    //         if (!$('#est_usu_tmp_edit').is(':checked')) {
    //             $('#est_usu_edit').val('A');
    //             $('#label_est_usu_edit').text(' Activo');
    //             $('#est_usu_tmp_edit').prop('checked', true);
    //         } else {
    //             $('#est_usu_edit').val('I');
    //             $('#label_est_usu_edit').text(' Inactivo');
    //             $('#est_usu_tmp_edit').prop('checked', false);
    //         }
    //     });
    // }

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

    // if($('#matricula').length > 0) {
    //     $('#matricula').inputmask('999-99999999');
    // }

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

        $('#id_predio').select2({
            language: "es",
            placeholder: "Buscar...",
            allowClear: true,
            ajax: {
                url: "/filter_exoneraciones",
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
            //placeholder: 'Search for a repository',
            minimumInputLength: 3,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });
    }
});

function formatRepo (repo) {
    if (repo.loading) {
      return repo.text;
    }

    var $container = $(
      "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__avatar'><img src=' data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABg2lDQ1BJQ0MgcHJvZmlsZQAAKJF9kT1Iw0AcxV9TpSJVBztIcchQO1kQFXGUKhbBQmkrtOpgcukXNGlIUlwcBdeCgx+LVQcXZ10dXAVB8APE0clJ0UVK/F9SaBHjwXE/3t173L0DhGaVqWbPBKBqlpFOxMVcflUMvELAIIAwohIz9WRmMQvP8XUPH1/vYjzL+9yfY0ApmAzwicRzTDcs4g3imU1L57xPHGJlSSE+Jx436ILEj1yXXX7jXHJY4JkhI5ueJw4Ri6UulruYlQ2VeJo4oqga5Qs5lxXOW5zVap2178lfGCxoKxmu0xxFAktIIgURMuqooAoLMVo1UkykaT/u4Q87/hS5ZHJVwMixgBpUSI4f/A9+d2sWpybdpGAc6H2x7Y8xILALtBq2/X1s260TwP8MXGkdf60JzH6S3uhokSNgaBu4uO5o8h5wuQOMPOmSITmSn6ZQLALvZ/RNeWD4Fuhfc3tr7+P0AchSV8s3wMEhEC1R9rrHu/u6e/v3TLu/H1bmcpz7VyktAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH5gIOADAkdZOkTgAAABl0RVh0Q29tbWVudABDcmVhdGVkIHdpdGggR0lNUFeBDhcAAAIlSURBVDjLpZNNSBQBFMd/Mzvu4Izj+LWt7CGo1FxWV1lNPajZh0KGC5467MWjgVDQsWvXSEoSvAXVsUC7hFFaHUpUZNK09BKo+LXq7jrTzuY6HcJCXMPof33v/d7/Pd4TYmaSTMpVZFpaw3cBRoYHb7WHr91wHMcHcMJTeP9BX+8SgJSpuLmpTckr0B9vbSc6AVpaw6dSqR+SaSU7VCU7qes5D/dzDwEikS6fqqnPtrYT9Z7ykjcA63MLnVlZkg2gacrOwED/t4yA7u6eysXltReiKHjzg/6hEV2/JCHQ4M4aSnz+2pbJrbC/g0ikq3Vxee255BJTUnXFuzFVC+9V1AMO4vQYdWZicHdqugnQvN7C9qdPHg0DCI7jcP5yx/XEjtXnluWlZFVg3lD1i06wAdzyrzYpG8H4QNCMvc42ZsrspO3TcpSe0VdD/ULjhav34gnzplvJnjRDQWk2zxPEXwMu10Gv6TTMTuDfXjfUSWM3ZX0P5Wpqr6vkbOCMKArRaE2VOu87XUdZFYji4WFFETw+oum0V9HkhfxodFSW3Yaw6zhMvX9J7Ux8nKLiGo6jjZWJ8YBeW93YhmRaNqWhFlgdO5Az11yJN0cBYHXHovztpz/BomJKQ3WYlp35kACM1U0KYiYAm0n7SDNHAppOeinOVQFYiZvwZenfAItxCzu9B8D6Ef/yV8C5j3PH2qfIf+q3A/+d24IoCMcq2nMcgSvDAPwEi5vDOoBfr5EAAAAASUVORK5CYII=' /></div>" +
        "<div class='select2-result-repository__meta'>" +
          "<div class='select2-result-repository__title'></div>" +
          "<div class='select2-result-repository__description'></div>" +
        //   "<div class='select2-result-repository__statistics'>" +
        //     "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> </div>" +
        //     "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> </div>" +
        //     "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> </div>" +
        //   "</div>" +
        "</div>" +
      "</div>"
    );

    $container.find(".select2-result-repository__title").text(repo.text);
    $container.find(".select2-result-repository__description").text(repo.codigo_predio);

    //$container.find(".select2-result-repository__title").text(repo.full_name);
    // $container.find(".select2-result-repository__description").text(repo.description);
    // $container.find(".select2-result-repository__forks").append(repo.forks_count + " Forks");
    // $container.find(".select2-result-repository__stargazers").append(repo.stargazers_count + " Stars");
    // $container.find(".select2-result-repository__watchers").append(repo.watchers_count + " Watchers");

    return $container;
}

function formatRepoSelection (repo) {
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
    if ($('#codigo_predio_edit').val().substr(0, 2) !== undefined && $('#codigo_predio_edit').val().substr(0, 2).length > 0) {
        $('#tipo_edit').val($('#codigo_predio_edit').val().substr(0, 2));
        $('#span_tipo_edit').text($('#tipo_edit').val());
        $('#div_tipo_edit').css('opacity', 1);
    } else {
        $('#tipo_edit').val('s');
        $('#span_tipo_edit').text('');
        $('#div_tipo_edit').css('opacity', 0);
    }
    if ($('#codigo_predio_edit').val().substr(2, 2) !== undefined && $('#codigo_predio_edit').val().substr(2, 2).length > 0) {
        $('#sector_edit').val($('#codigo_predio_edit').val().substr(2, 2));
        $('#span_sector_edit').text($('#sector_edit').val());
        $('#div_sector_edit').css('opacity', 1);
    } else {
        $('#sector_edit').val('');
        $('#span_sector_edit').text('');
        $('#div_sector_edit').css('opacity', 0);
    }
    if ($('#codigo_predio_edit').val().substr(4, 4) !== undefined && $('#codigo_predio_edit').val().substr(4, 4).length > 0) {
        $('#manzana_edit').val($('#codigo_predio_edit').val().substr(4, 4));
        $('#span_manzana_edit').text($('#manzana_edit').val());
        $('#div_manzana_edit').css('opacity', 1);
    } else {
        $('#manzana_edit').val('');
        $('#span_manzana_edit').text('');
        $('#div_manzana_edit').css('opacity', 0);
    }
    if ($('#codigo_predio_edit').val().substr(8, 4) !== undefined && $('#codigo_predio_edit').val().substr(8, 4).length > 0) {
        $('#predio_edit').val($('#codigo_predio_edit').val().substr(8, 4));
        $('#span_predio_edit').text($('#predio_edit').val());
        $('#div_predio_edit').css('opacity', 1);
    } else {
        $('#predio_edit').val('');
        $('#span_predio_edit').text('');
        $('#div_predio_edit').css('opacity', 0);
    }
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
