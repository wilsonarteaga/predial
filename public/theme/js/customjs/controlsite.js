var global_json = null;
$(document).ready(function() {

    var ROOT_URL = window.location.protocol + "//" + window.location.host;

    if ($('#tab').length > 0) {
        $('#' + $('#tab').val()).trigger('click');
    }

    if ($('#li-section-bar-1').length > 0) {
        $('#li-section-bar-1').bind('click', function() {
            $('.result').empty();
            if ($('#tab').length > 0) {
                $('#tab').val('li-section-bar-1');
            }
            setTimeout(function() {
                $('#btn_cancel_edit').trigger('click');
            }, 300);

            if ($("#update-form").length > 0) {
                var validatorUpdate = $("#update-form").validate();
                validatorUpdate.resetForm();
                $("#update-form")[0].reset();
                if ($("#create-form").length > 0) {
                    var validatorCreate = $("#create-form").validate();
                    validatorCreate.resetForm();
                    $("#create-form")[0].reset();
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
        });
    }

    if ($('#li-section-bar-2').length > 0) {
        $('#li-section-bar-2').bind('click', function() {
            $('.result').empty();
            if ($('#tab').length > 0) {
                $('#tab').val('li-section-bar-2');
            }

            if ($("#create-form").length > 0) {
                var validatorCreate = $("#create-form").validate();
                validatorCreate.resetForm();
                $("#create-form")[0].reset();
                if ($("#update-form").length > 0) {
                    var validatorUpdate = $("#update-form").validate();
                    validatorUpdate.resetForm();
                    $("#update-form")[0].reset();
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

        });
    }

    if ($('#btn_cancel_edit').length > 0) {
        $('#btn_cancel_edit').off('click').on('click', function() {
            $('#div_edit_form').fadeOut(function() {
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
            var jsonObj = JSON.parse($(row).attr('json-data'));
            global_json = jsonObj;
            $('.result').empty();

            // if ($(row).hasClass('cita_row')) {
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
            // } else {
            setData(jsonObj);
            // }
        });
    }

    // if ($('.btn_update_cit').length > 0) {
    //     $('.btn_update_cit').off('click').on('click', function() {
    //         var btn = $(this);
    //         $('.result').empty();
    //         $('#timeline_citas').fadeOut(function() {
    //             var jsonObj = JSON.parse($(btn).attr('json-data'));
    //             $.each(jsonObj, function(i, el) {
    //                 if ($('#' + i + '_edit').length > 0) {
    //                     if ($('#' + i + '_edit').hasClass('selectpicker')) {
    //                         $('#' + i + '_edit').selectpicker('val', el);
    //                     } else {
    //                         $('#' + i + '_edit').val(el);
    //                     }
    //                 }
    //             });

    //             $('.selectpicker').selectpicker('refresh');
    //             $('#div_edit_form').fadeIn();

    //         });
    //     });
    // }

    if ($('.modify_row').length > 0) {
        $('.modify_row').off('click').on('click', function(evt) {
            $(this).closest('tr').find('td:eq(0)').trigger('click');
        });
    }

    if ($('.delete_row').length > 0) {
        $('.delete_row').off('click').on('click', function(evt) {
            var row = $(this);
            swal({
                title: "Atención",
                text: "¿Está seguro/a que desea eliminar el registro?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si",
                cancelButtonText: "No",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {
                    $('#input_delete').val($(row).attr('ide'));
                    $('#form_delete').first().submit();
                }
            });
        });
    }

    // if ($('#generar_reporte').length > 0) {
    //     $('#search_control').attr('placeholder', 'Buscar paciente...');
    //     $('#li_search').fadeIn();

    //     $('#generar_reporte').off('click').on('click', function(evt) {
    //         if ($('#iframe_reporte').length > 0)
    //             $('#iframe_reporte').remove();

    //         var iframe = $('<iframe id="iframe_reporte" style="display:none;"></iframe>');
    //         iframe.attr('src', $(this).attr('url'));
    //         $('body').append(iframe);
    //     });

    //     $('.download_row').off('click').on('click', function(evt) {
    //         if ($('#iframe_reporte').length > 0)
    //             $('#iframe_reporte').remove();

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

                $('#create-form').validate().element($(this));
            }
            if ($("#update-form").length > 0) {
                if ($('#' + $(this).attr('id') + '-error').length > 0)
                    $('#' + $(this).attr('id') + '-error').remove();

                $('#update-form').validate().element($(this));
            }
        }
    });

    if ($('.datelimite').length > 0) {
        $('.datelimite').datepicker({
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

    if ($('#porcentaje').length > 0) {
        new AutoNumeric('#porcentaje', {
            emptyInputBehavior: "zero",
            maximumValue: "100",
            minimumValue: "0",
            modifyValueOnWheel: false,
            suffixText: "%",
            unformatOnSubmit: true
        });
        new AutoNumeric('#porcentaje_edit', {
            emptyInputBehavior: "zero",
            maximumValue: "100",
            minimumValue: "0",
            modifyValueOnWheel: false,
            suffixText: "%",
            unformatOnSubmit: true
        });
    }

    if ($('#capital').length > 0) {
        new AutoNumeric('#capital', {
            emptyInputBehavior: "zero",
            minimumValue: "0",
            modifyValueOnWheel: false,
            unformatOnSubmit: true
        });
        new AutoNumeric('#capital_edit', {
            emptyInputBehavior: "zero",
            minimumValue: "0",
            modifyValueOnWheel: false,
            unformatOnSubmit: true
        });
    }

    if ($('#minimo_urbano').length > 0) {
        new AutoNumeric('#minimo_urbano', {
            emptyInputBehavior: "zero",
            minimumValue: "0",
            modifyValueOnWheel: false,
            unformatOnSubmit: true
        });
        new AutoNumeric('#minimo_urbano_edit', {
            emptyInputBehavior: "zero",
            minimumValue: "0",
            modifyValueOnWheel: false,
            unformatOnSubmit: true
        });
    }

    if ($('#minimo_rural').length > 0) {
        new AutoNumeric('#minimo_rural', {
            emptyInputBehavior: "zero",
            minimumValue: "0",
            modifyValueOnWheel: false,
            unformatOnSubmit: true
        });
        new AutoNumeric('#minimo_rural_edit', {
            emptyInputBehavior: "zero",
            minimumValue: "0",
            modifyValueOnWheel: false,
            unformatOnSubmit: true
        });
    }

    if ($('#interes').length > 0) {
        new AutoNumeric('#interes', {
            emptyInputBehavior: "zero",
            //maximumValue: "100",
            minimumValue: "0",
            modifyValueOnWheel: false,
            //suffixText: "%",
            unformatOnSubmit: true
        });
        new AutoNumeric('#interes_edit', {
            emptyInputBehavior: "zero",
            //maximumValue: "100",
            minimumValue: "0",
            modifyValueOnWheel: false,
            //suffixText: "%",
            unformatOnSubmit: true
        });
    }

    if ($('#aplica_interes_check').length > 0) {
        $('#aplica_interes_check').off('click').on('click', function() {
            if ($(this).is(':checked')) {
                $('#span_aplica_interes').html('SI');
                $('#interes').attr('disabled', false);
                $(this).val(1);
                $('#aplica_interes').val(1);
                //$('#interes').closest('div').removeClass('has-success');
                //$('#interes').closest('div').removeClass('has-error');
            } else {
                $('#span_aplica_interes').html('NO');
                $('#interes').attr('disabled', true);
                $(this).val(0);
                $('#aplica_interes').val(0);
                //$('#interes').closest('div').removeClass('has-success');
                //$('#interes').closest('div').removeClass('has-error');
            }

            //$('#interes').valid();
            $("#create-form").validate().element('#interes');
        });
    }

    if ($('#aplica_interes_edit').length > 0) {
        $('#aplica_interes_edit').off('click').on('click', function() {
            if ($(this).is(':checked')) {
                $('#span_aplica_interes_edit').html('SI');
                $('#interes_edit').attr('disabled', false);
                $(this).val(1);
                //$('#interes_edit').closest('div').removeClass('has-success');
                //$('#interes_edit').closest('div').removeClass('has-error');
            } else {
                console.log($('#interes_edit'));
                $('#span_aplica_interes_edit').html('NO');
                $('#interes_edit').attr('disabled', true);
                $(this).val(0);
                //$('#interes_edit').closest('div').removeClass('has-success');
                //$('#interes_edit').closest('div').removeClass('has-error');
            }

            //$('#interes_edit').valid();
            $("#update-form").validate().element('#interes_edit');
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
});


function setData(jsonObj) {
    $('#div_table').fadeOut(function() {
        $.each(jsonObj, function(i, el) {
            if ($('#' + i + '_edit').length > 0) {
                if ($('#' + i + '_edit').hasClass('selectpicker')) {
                    $('#' + i + '_edit').selectpicker('val', el);
                } else {
                    if (el === '.00') {
                        $('#' + i + '_edit').val('0');
                    } else {
                        $('#' + i + '_edit').val(el);
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

    });
}