$(document).ready(function() {

    var ROOT_URL = window.location.protocol + "//" + window.location.host;

    if ($('#tab').length > 0) {
        $('#' + $('#tab').val()).trigger('click');
    }

    if ($('#li-section-bar-1').length > 0) {
        $('#li-section-bar-1').bind('click', function() {
            var sfx = $(this).attr('sfx');
            $('.result').empty();
            if ($('#tab').length > 0) {
                $('#tab').val('li-section-bar-1');
            }
            setTimeout(function() {
                $('#btn_cancel_edit-' + sfx).trigger('click');
            }, 300);

            if ($('#update_' + sfx + '-form').length > 0) {
                var validatorUpdate = $('#update_' + sfx + '-form').validate();
                validatorUpdate.resetForm();
                $('#update_' + sfx + '-form')[0].reset();
                if ($('#create_' + sfx + '-form').length > 0) {
                    var validatorCreate = $('#create_' + sfx + '-form').validate();
                    validatorCreate.resetForm();
                    $('#create_' + sfx + '-form')[0].reset();
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
            var sfx = $(this).attr('sfx');
            $('.result').empty();
            if ($('#tab').length > 0) {
                $('#tab').val('li-section-bar-2');
            }

            if ($('#create_' + sfx + '-form').length > 0) {
                var validatorCreate = $('#create_' + sfx + '-form').validate();
                validatorCreate.resetForm();
                $('#create_' + sfx + '-form')[0].reset();
                if ($('#update_' + sfx + '-form').length > 0) {
                    var validatorUpdate = $('#update_' + sfx + '-form').validate();
                    validatorUpdate.resetForm();
                    $('#update_' + sfx + '-form')[0].reset();
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

    if ($('#li-section-bar-3').length > 0) {
        $('#li-section-bar-3').bind('click', function() {
            var sfx = $(this).attr('sfx');
            $('.result').empty();
            if ($('#tab').length > 0) {
                $('#tab').val('li-section-bar-3');
            }
            setTimeout(function() {
                $('#btn_cancel_edit-' + sfx).trigger('click');
            }, 300);

            if ($('#update_' + sfx + '-form').length > 0) {
                var validatorUpdate = $('#update_' + sfx + '-form').validate();
                validatorUpdate.resetForm();
                $('#update_' + sfx + '-form')[0].reset();
                if ($('#create_' + sfx + '-form').length > 0) {
                    var validatorCreate = $('#create_' + sfx + '-form').validate();
                    validatorCreate.resetForm();
                    $('#create_' + sfx + '-form')[0].reset();
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

    if ($('#li-section-bar-4').length > 0) {
        $('#li-section-bar-4').bind('click', function() {
            var sfx = $(this).attr('sfx');
            $('.result').empty();
            if ($('#tab').length > 0) {
                $('#tab').val('li-section-bar-4');
            }

            if ($('#create_' + sfx + '-form').length > 0) {
                var validatorCreate = $('#create_' + sfx + '-form').validate();
                validatorCreate.resetForm();
                $('#create_' + sfx + '-form')[0].reset();
                if ($('#update_' + sfx + '-form').length > 0) {
                    var validatorUpdate = $('#update_' + sfx + '-form').validate();
                    validatorUpdate.resetForm();
                    $('#update_' + sfx + '-form')[0].reset();
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

    if ($('.btn_cancel_edit').length > 0) {
        $('.btn_cancel_edit').off('click').on('click', function() {
            var btn = $(this);
            $(btn).closest('.div_edit_form').fadeOut(function() {
                var sfx = $(btn).attr('sfx');
                if ($('#div_table-' + sfx).length > 0)
                    $('#div_table-' + sfx).fadeIn();

                if ($('#timeline_citas').length > 0)
                    $('#timeline_citas').fadeIn();

                if ($('#div_est_usu_tmp_edit').length > 0) {
                    $('#label_est_usu_edit').text(' Inactivo');
                    $('#est_usu_tmp_edit').prop('checked', false);
                }

                if ($('#create_' + sfx + '-form').length > 0) {
                    var validatorCreate = $('#create_' + sfx + '-form').validate();
                    validatorCreate.resetForm();
                    $.each($('.has-success'), function(i, el) {
                        $(el).removeClass('has-success');
                    });
                    $.each($('.has-error'), function(i, el) {
                        $(el).removeClass('has-error');
                    });
                }

                if ($('#update_' + sfx + '-form').length > 0) {
                    var validatorUpdate = $('#update_' + sfx + '-form').validate();
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
            var sfx = $(row).attr('sfx');
            $('.result').empty();
            $('#div_table-' + sfx).fadeOut(function() {
                var jsonObj = JSON.parse($(row).attr('json-data'));
                $.each(jsonObj, function(i, el) {
                    if ($('#' + i + '_edit').length > 0) {
                        if ($('#' + i + '_edit').hasClass('selectpicker')) {
                            $('#' + i + '_edit').selectpicker('val', el);
                        } else {
                            $('#' + i + '_edit').val(el);
                        }

                        if ($('#h1_' + i + '_edit').length > 0) {
                            $('#h1_' + i + '_edit').text(el);
                        }
                        if ($('#' + i + '_edit_confirmation').length > 0) {
                            $('#' + i + '_edit_confirmation').val(el);
                        }
                    }
                });

                if ($('#div_est_usu_tmp_edit').length > 0) {
                    if ($('#est_usu_edit').val() === 'A') {
                        $('#div_est_usu_tmp_edit').trigger('click');
                    }
                }

                $('.selectpicker').selectpicker('refresh');
                $('#div_edit_form-' + sfx).fadeIn();

            });
        });
    }

    if ($('.btn_update_cit').length > 0) {
        $('.btn_update_cit').off('click').on('click', function() {
            var btn = $(this);
            $('.result').empty();
            $('#timeline_citas').fadeOut(function() {
                var jsonObj = JSON.parse($(btn).attr('json-data'));
                $.each(jsonObj, function(i, el) {
                    if ($('#' + i + '_edit').length > 0) {
                        if ($('#' + i + '_edit').hasClass('selectpicker')) {
                            $('#' + i + '_edit').selectpicker('val', el);
                        } else {
                            $('#' + i + '_edit').val(el);
                        }
                    }
                });

                $('.selectpicker').selectpicker('refresh');
                $('#div_edit_form').fadeIn();

            });
        });
    }

    if ($('.modify_row').length > 0) {
        $('.modify_row').off('click').on('click', function(evt) {
            $(this).closest('tr').find('td:eq(0)').trigger('click');
        });
    }

    if ($('.delete_row').length > 0) {
        $('.delete_row').off('click').on('click', function(evt) {
            var row = $(this);
            var pfx = $(row).attr('pfx');
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
                    $('#' + pfx + '-input_delete').val($(row).attr('ide'));
                    $('#' + pfx + '-form').first().submit();
                }
            });
        });
    }

    if ($('#generar_reporte').length > 0) {
        $('#search_control').attr('placeholder', 'Buscar paciente...');
        $('#li_search').fadeIn();

        $('#generar_reporte').off('click').on('click', function(evt) {
            if ($('#iframe_reporte').length > 0)
                $('#iframe_reporte').remove();

            var iframe = $('<iframe id="iframe_reporte" style="display:none;"></iframe>');
            iframe.attr('src', $(this).attr('url'));
            $('body').append(iframe);
        });

        $('.download_row').off('click').on('click', function(evt) {
            if ($('#iframe_reporte').length > 0)
                $('#iframe_reporte').remove();

            var iframe = $('<iframe id="iframe_reporte" style="display:none;"></iframe>');
            iframe.attr('src', $(this).attr('url'));
            $('body').append(iframe);
        });
    }

    if ($('.myTable').length > 0) {
        $('.myTable').DataTable({
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

    if ($('#div_est_usu_tmp').length > 0) {
        $('#div_est_usu_tmp').off('click').on('click', function() {
            if ($('#est_usu_tmp').is(':checked')) {
                $('#est_usu').val('A');
                $('#label_est_usu').text(' Activo');
            } else {
                $('#est_usu').val('I');
                $('#label_est_usu').text(' Inactivo');
            }
        });
    }

    if ($('#div_est_usu_tmp_edit').length > 0) {
        $('#div_est_usu_tmp_edit').off('click').on('click', function() {
            if (!$('#est_usu_tmp_edit').is(':checked')) {
                $('#est_usu_edit').val('A');
                $('#label_est_usu_edit').text(' Activo');
                $('#est_usu_tmp_edit').prop('checked', true);
            } else {
                $('#est_usu_edit').val('I');
                $('#label_est_usu_edit').text(' Inactivo');
                $('#est_usu_tmp_edit').prop('checked', false);
            }
        });
    }

    $('.selectpicker').selectpicker();

    $('.selectpicker').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
        var sel = $(this);
        var sfx = $(sel).attr('sfx');
        if ($('#create_' + sfx + '-form').length > 0) {
            $('#create_' + sfx + '-form').validate().element($(sel));
        }
        if ($('#update_' + sfx + '-form').length > 0) {
            $('#update_' + sfx + '-form').validate().element($(sel));
        }
    });

    $('.datepicker').datepicker({
        language: 'es-ES',
        format: 'yyyy-mm-dd',
        startDate: ($('#fec_cit').length > 0) ? moment($('#fer_cit').val()) : null, // Or '02/14/2014'
        hide: function() {
            var inp = $(this);
            var sfx = $(inp).attr('sfx');
            if ($('#create_' + sfx + '-form').length > 0) {
                if ($('#' + $(inp).attr('id') + '-error').length > 0)
                    $('#' + $(inp).attr('id') + '-error').remove();

                $('#create_' + sfx + '-form').validate().element($(inp));
            }
            if ($('#update_' + sfx + '-form').length > 0) {
                if ($('#' + $(inp).attr('id') + '-error').length > 0)
                    $('#' + $(inp).attr('id') + '-error').remove();

                $('#update_' + sfx + '-form').validate().element($(inp));
            }
        }
    });

    if ($("#create_pac-form").length > 0) {
        $('#create_pac-form').validate().settings.ignore = '';
        $('#create_pac-form').validate().settings.errorPlacement = function(error, element) {
            if (element.hasClass('selectpicker')) {
                element.next().after(error);
            } else if (element.hasClass('withadon')) {
                element.parent().after(error);
            } else {
                error.insertAfter(element);
            }
        };
    }

    if ($("#update_pac-form").length > 0) {
        $('#update_pac-form').validate().settings.ignore = '';
        $('#update_pac-form').validate().settings.errorPlacement = function(error, element) {
            if (element.hasClass('selectpicker')) {
                element.next().after(error);
            } else if (element.hasClass('withadon')) {
                element.parent().after(error);
            } else {
                error.insertAfter(element);
            }
        };
    }

    if ($("#create_asoc-form").length > 0) {
        $('#create_asoc-form').validate().settings.ignore = '';
        $('#create_asoc-form').validate().settings.errorPlacement = function(error, element) {
            if (element.hasClass('selectpicker')) {
                element.next().after(error);
            } else if (element.hasClass('withadon')) {
                element.parent().after(error);
            } else {
                error.insertAfter(element);
            }
        };
    }

    if ($("#update_asoc-form").length > 0) {
        $('#update_asoc-form').validate().settings.ignore = '';
        $('#update_asoc-form').validate().settings.errorPlacement = function(error, element) {
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