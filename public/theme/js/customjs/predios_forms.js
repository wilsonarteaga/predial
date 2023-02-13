var DTAbonos = null;
var DTPropietarios = null;
var last_propietario = 0;
var idx_update = 0;
var current_page = 0;
var PAGE_LENGTH = 3;
var nuevo_propietario = false;
$(document).ready(function() {

    $('.tips').powerTip({
        placement: 's' // north-east tooltip position
    });

    $('.codigo_25').css({
        'display': 'none'
    });

    setDownloadFacturaRow();
    setDownloadPazRow();
    setPrescribeRow();

    if ($('#codigo_predio').length > 0) {
        $('#codigo_predio').off('keyup').on('keyup', function() {
            if($('#codigo_predio').val().length < 16) {
                $('.codigo_15').css('display', '');
                $('.codigo_25').css('display', 'none');
                $('.codigo_25').find('input').val('');
                //TIPO
                if ($('#codigo_predio').val().substr(0, 2) !== undefined && $('#codigo_predio').val().substr(0, 2).length > 0) {
                    $('#tipo').val($('#codigo_predio').val().substr(0, 2));
                    $('#span_tipo').text($('#tipo').val());
                    $('#div_tipo').css('opacity', 1);
                } else {
                    $('#tipo').val('s');
                    $('#span_tipo').text('');
                    $('#div_tipo').css('opacity', 0);
                }
                //SECTOR
                if ($('#codigo_predio').val().substr(2, 2) !== undefined && $('#codigo_predio').val().substr(2, 2).length > 0) {
                    $('#sector').val($('#codigo_predio').val().substr(2, 2));
                    $('#span_sector').text($('#sector').val());
                    $('#div_sector').css('opacity', 1);
                } else {
                    $('#sector').val('');
                    $('#span_sector').text('');
                    $('#div_sector').css('opacity', 0);
                }
                //MANZANA
                if ($('#codigo_predio').val().substr(4, 4) !== undefined && $('#codigo_predio').val().substr(4, 4).length > 0) {
                    $('#manzana').val($('#codigo_predio').val().substr(4, 4));
                    $('#span_manzana').text($('#manzana').val());
                    $('#div_manzana').css('opacity', 1);
                } else {
                    $('#manzana').val('');
                    $('#span_manzana').text('');
                    $('#div_manzana').css('opacity', 0);
                }
                //PREDIO
                if ($('#codigo_predio').val().substr(8, 4) !== undefined && $('#codigo_predio').val().substr(8, 4).length > 0) {
                    $('#predio').val($('#codigo_predio').val().substr(8, 4));
                    $('#span_predio').text($('#predio').val());
                    $('#div_predio').css('opacity', 1);
                } else {
                    $('#predio').val('');
                    $('#span_predio').text('');
                    $('#div_predio').css('opacity', 0);
                }
                //MEJORA
                if ($('#codigo_predio').val().substr(12) !== undefined && $('#codigo_predio').val().substr(12).length > 0) {
                    $('#mejora').val($('#codigo_predio').val().substr(12));
                    $('#span_mejora').text($('#mejora').val());
                    $('#div_mejora').css('opacity', 1);
                } else {
                    $('#mejora').val('');
                    $('#span_mejora').text('');
                    $('#div_mejora').css('opacity', 0);
                }
            }
            else {
                $('.codigo_15').css('display', 'none');
                $('.codigo_15').find('input').val('');
                $('.codigo_25').css('display', '');
                //ZONA
                if ($('#codigo_predio').val().substr(0, 2) !== undefined && $('#codigo_predio').val().substr(0, 2).length > 0) {
                    $('#zona').val($('#codigo_predio').val().substr(0, 2));
                    $('#span_zona').text($('#zona').val());
                    $('#div_zona').css('opacity', 1);
                } else {
                    $('#zona').val('s');
                    $('#span_zona').text('');
                    $('#div_zona').css('opacity', 0);
                }
                //SECTOR
                if ($('#codigo_predio').val().substr(2, 2) !== undefined && $('#codigo_predio').val().substr(2, 2).length > 0) {
                    $('#sector').val($('#codigo_predio').val().substr(2, 2));
                    $('#span_sector').text($('#sector').val());
                    $('#div_sector').css('opacity', 1);
                } else {
                    $('#sector').val('');
                    $('#span_sector').text('');
                    $('#div_sector').css('opacity', 0);
                }
                //COMUNA
                if ($('#codigo_predio').val().substr(4, 2) !== undefined && $('#codigo_predio').val().substr(4, 2).length > 0) {
                    $('#comuna').val($('#codigo_predio').val().substr(4, 2));
                    $('#span_comuna').text($('#comuna').val());
                    $('#div_comuna').css('opacity', 1);
                } else {
                    $('#comuna').val('');
                    $('#span_comuna').text('');
                    $('#div_comuna').css('opacity', 0);
                }
                //BARRIO
                if ($('#codigo_predio').val().substr(6, 2) !== undefined && $('#codigo_predio').val().substr(6, 2).length > 0) {
                    $('#barrio').val($('#codigo_predio').val().substr(6, 2));
                    $('#span_barrio').text($('#barrio').val());
                    $('#div_barrio').css('opacity', 1);
                } else {
                    $('#barrio').val('');
                    $('#span_barrio').text('');
                    $('#div_barrio').css('opacity', 0);
                }
                //MANZANA
                if ($('#codigo_predio').val().substr(8, 4) !== undefined && $('#codigo_predio').val().substr(8, 4).length > 0) {
                    $('#manzana').val($('#codigo_predio').val().substr(8, 4));
                    $('#span_manzana').text($('#manzana').val());
                    $('#div_manzana').css('opacity', 1);
                } else {
                    $('#manzana').val('');
                    $('#span_manzana').text('');
                    $('#div_manzana').css('opacity', 0);
                }
                //TERRENO
                if ($('#codigo_predio').val().substr(12, 4) !== undefined && $('#codigo_predio').val().substr(12, 4).length > 0) {
                    $('#terreno').val($('#codigo_predio').val().substr(12, 4));
                    $('#span_terreno').text($('#terreno').val());
                    $('#div_terreno').css('opacity', 1);
                } else {
                    $('#terreno').val('');
                    $('#span_terreno').text('');
                    $('#div_terreno').css('opacity', 0);
                }
                //CONDICION
                if ($('#codigo_predio').val().substr(16, 1) !== undefined && $('#codigo_predio').val().substr(16, 1).length > 0) {
                    $('#condicion').val($('#codigo_predio').val().substr(16, 1));
                    $('#span_condicion').text($('#condicion').val());
                    $('#div_condicion').css('opacity', 1);
                } else {
                    $('#condicion').val('');
                    $('#span_condicion').text('');
                    $('#div_condicion').css('opacity', 0);
                }
                //EDIFICIO/TORRE
                if ($('#codigo_predio').val().substr(17, 2) !== undefined && $('#codigo_predio').val().substr(17, 2).length > 0) {
                    $('#edificio_torre').val($('#codigo_predio').val().substr(17, 2));
                    $('#span_edificio_torre').text($('#edificio_torre').val());
                    $('#div_edificio_torre').css('opacity', 1);
                } else {
                    $('#edificio_torre').val('');
                    $('#span_edificio_torre').text('');
                    $('#div_edificio_torre').css('opacity', 0);
                }
                //PISO
                if ($('#codigo_predio').val().substr(19, 2) !== undefined && $('#codigo_predio').val().substr(19, 2).length > 0) {
                    $('#piso').val($('#codigo_predio').val().substr(19, 2));
                    $('#span_piso').text($('#piso').val());
                    $('#div_piso').css('opacity', 1);
                } else {
                    $('#piso').val('');
                    $('#span_piso').text('');
                    $('#div_piso').css('opacity', 0);
                }
                //PROPIEDAD
                if ($('#codigo_predio').val().substr(21, 4) !== undefined && $('#codigo_predio').val().substr(21, 4).length > 0) {
                    $('#propiedad').val($('#codigo_predio').val().substr(21, 4));
                    $('#span_propiedad').text($('#propiedad').val());
                    $('#div_propiedad').css('opacity', 1);
                } else {
                    $('#propiedad').val('');
                    $('#span_propiedad').text('');
                    $('#div_propiedad').css('opacity', 0);
                }
            }
        });

        $('#codigo_predio_edit').off('keyup').on('keyup', function() {
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
        });
    }

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
    // $('#save_dpa').off('click').on('click', function() {
    //     saveDatosPredio('form-predios-datos-pagos', 'modal-datos-pagos', 'predios_datos_pagos', 'dpa');
    // });
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
        // if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dp') !== undefined) {
        //     var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dp'));
        //     if (objJson.length !== undefined) {
        //         last_propietario = 0;
        //         setFormData('form-predios-datos-propietarios', objJson[last_propietario]);
        //         $('#form-predios-datos-propietarios').find('#span_jerarquia').html(objJson[last_propietario].jerarquia);
        //         $('.control_propietarios').css('display', '');
        //         $('.control_propietarios').attr('disabled', false);
        //         $('#prev_dp').attr('disabled', true);
        //         if (objJson.length < 2) {
        //             $('#next_dp').css('display', 'none');
        //             $('#prev_dp').css('display', 'none');
        //         } else {
        //             $('#span_de_jererquia').html(' de ' + objJson.length);
        //         }
        //     }
        // }
        if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dp') !== undefined) {
            var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dp'));
            if (objJson.length !== undefined) {
                if (objJson.length > 0) {
                    setFormData('form-predios-datos-propietarios', objJson[0]);
                    $('#jerarquia').val(objJson[0].jerarquia);
                    $('#form-predios-datos-propietarios').find('#span_jerarquia').html(objJson[0].jerarquia);
                    $('#span_de_jererquia').html(' de ' + DTPropietarios.rows().data().length);
                }
                $('#new_dp').css('display', '');
                $('#cancel_dp').css('display', 'none');
                if (DTPropietarios !== null) {
                    DTPropietarios.page(0).draw('page');
                    DTPropietarios.search('').columns().search('').draw();
                    DTPropietarios.$('.row-selected').toggleClass('row-selected');
                    if (objJson.length > 0) {
                        var tr = $('#propietariosTable').find('tbody').find('tr:eq(0)');
                        $(tr).addClass('row-selected');
                    }
                }
            }
        }
    });

    $('#modal-datos-propietarios').on('hidden.bs.modal', function() {
        // $('.datohidden').remove();
        // $('.control_propietarios').css('display', 'none');
        // $('#cancel_dp').css('display', 'none');
        // last_propietario = 0;
        // $('#form-predios-datos-propietarios')[0].reset();
        // clear_form_elements("#form-predios-datos-propietarios");
        $('.datohidden').remove();
        $('#form-predios-datos-propietarios')[0].reset();
        clear_form_elements("#form-predios-datos-propietarios");
        idx_update = 0;
        current_page = 0;
        $('#text_page_propietarios').html('Edici&oacute;n<br />P&aacute;gina: 1');
        $('#text_row_propietarios').html('Fila: 1');
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
    // $('#modal-datos-pagos').on('show.bs.modal', function() {
    //     if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dpa') !== undefined) {
    //         var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dpa'));
    //         setFormData('form-predios-datos-pagos', objJson);
    //     }
    // });

    // $('#modal-datos-pagos').on('hidden.bs.modal', function() {
    //     $('.datohidden').remove();
    //     $('#form-predios-datos-pagos')[0].reset();
    //     clear_form_elements("#form-predios-datos-pagos");
    // });

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
                if (objJson.length > 0) {
                    setFormData('form-predios-datos-abonos', objJson[0]);
                }
                $('#new_da').css('display', '');
                $('#cancel_da').css('display', 'none');
                if (DTAbonos !== null) {
                    DTAbonos.page(0).draw('page');
                    DTAbonos.search('').columns().search('').draw();
                    DTAbonos.$('.row-selected').toggleClass('row-selected');
                    if (objJson.length > 0) {
                        var tr = $('#abonosTable').find('tbody').find('tr:eq(0)');
                        $(tr).addClass('row-selected');
                    }
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
        $('#text_page_abonos').html('Edici&oacute;n<br />P&aacute;gina: 1');
        $('#text_row_abonos').html('Fila: 1');
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
        // $('.datohidden').remove();
        // $('.control_propietarios').css('display', 'none');
        // $('#cancel_dp').css('display', '');
        // $('#form-predios-datos-propietarios')[0].reset();
        // clear_form_elements("#form-predios-datos-propietarios");
        nuevo_propietario = true;
        $('#div_set_jerarquia').fadeOut(function() {
            $('#div_jerarquia').fadeIn();
        });
        if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dp') !== undefined) {
            var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dp'));
            if (objJson.length !== undefined) {
                $('#form-predios-datos-propietarios').find('#jerarquia').val(objJson.length + 1);
                $('#form-predios-datos-propietarios').find('#span_jerarquia').html(String(objJson.length + 1).padStart(3, '0'));
                $('#span_de_jererquia').html('');
            }
        }
        $('.datohidden').remove();
        $(this).css('display', 'none');
        $('#cancel_dp').css('display', '');
        $('.info_propietarios').css('display', 'none');
        $('#form-predios-datos-propietarios')[0].reset();
        clear_form_elements("#form-predios-datos-propietarios");
        $('#divPropietariosTable').css('display', 'none');
        if (DTPropietarios !== null) {
            DTPropietarios.$('.row-selected').toggleClass('row-selected');
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
        // $('.control_propietarios').css('display', '');
        // if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dp') !== undefined) {
        //     var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dp'));
        //     if (objJson.length !== undefined) {
        //         setFormData('form-predios-datos-propietarios', objJson[last_propietario]);
        //         $('#form-predios-datos-propietarios').find('#span_jerarquia').html(objJson[last_propietario].jerarquia);
        //         if (objJson.length < 2) {
        //             $('#next_dp').css('display', 'none');
        //             $('#prev_dp').css('display', 'none');
        //         } else {
        //             $('#span_de_jererquia').html(' de ' + objJson.length);
        //         }
        //     }
        // }
        // $('#cancel_dp').css('display', 'none');
        $('#new_dp').css('display', '');
        $(this).css('display', 'none');
        $('.info_propietarios').css('display', '');
        if (DTPropietarios !== null) {
            var data = DTPropietarios.rows().data();
            //if (data.length > 1) {
                if (idx_update >= 0) {
                    DTPropietarios.page(current_page).draw('page');
                    DTPropietarios.$('tr:eq(' + idx_update + ')').toggleClass('row-selected');
                    DTPropietarios.$('tr:eq(' + idx_update + ')').find('.editPropietario').trigger('click');
                }
                $('#divPropietariosTable').css('display', '');
            //}
        } else {
            if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dp') !== undefined) {
                var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dp'));
                if (objJson.length !== undefined) {
                    setFormData('form-predios-datos-propietarios', objJson[0]);
                }
            }
        }
    });

    $('#cancel_da').off('click').on('click', function() {
        $('#new_da').css('display', '');
        $(this).css('display', 'none');
        $('.info_abonos').css('display', '');
        if (DTAbonos !== null) {
            var data = DTAbonos.rows().data();
            //if (data.length > 1) {
                if (idx_update >= 0) {
                    DTAbonos.page(current_page).draw('page');
                    DTAbonos.$('tr:eq(' + idx_update + ')').toggleClass('row-selected');
                    DTAbonos.$('tr:eq(' + idx_update + ')').find('.editAbono').trigger('click');
                }
                $('#divAbonosTable').css('display', '');
            //}
        } else {
            if ($('#tr_predio_' + $('#id_edit').val()).attr('data-da') !== undefined) {
                var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-da'));
                if (objJson.length !== undefined) {
                    setFormData('form-predios-datos-abonos', objJson[0]);
                }
            }
        }
    });

    // $('#next_dp').off('click').on('click', function() {
    //     if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dp') !== undefined) {
    //         var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dp'));
    //         last_propietario++;
    //         if (objJson[last_propietario] !== undefined) {
    //             if (objJson.length !== undefined) {
    //                 setFormData('form-predios-datos-propietarios', objJson[last_propietario]);
    //                 $('#form-predios-datos-propietarios').find('#span_jerarquia').html(objJson[last_propietario].jerarquia);
    //                 if (objJson.length === (last_propietario + 1)) {
    //                     $('#next_dp').attr('disabled', true);
    //                 }
    //                 $('#prev_dp').attr('disabled', false);
    //             }
    //         } else {
    //             last_propietario--;
    //         }
    //     }
    // });

    // $('#prev_dp').off('click').on('click', function() {
    //     if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dp') !== undefined) {
    //         var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dp'));
    //         last_propietario--;
    //         if (objJson[last_propietario] !== undefined) {
    //             if (objJson.length !== undefined) {
    //                 setFormData('form-predios-datos-propietarios', objJson[last_propietario]);
    //                 $('#form-predios-datos-propietarios').find('#span_jerarquia').html(objJson[last_propietario].jerarquia);
    //                 if (last_propietario === 0) {
    //                     $('#prev_dp').attr('disabled', true);
    //                 }
    //                 $('#next_dp').attr('disabled', false);
    //             }
    //         } else {
    //             last_propietario++;
    //         }
    //     }
    // });

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
                $('#text_page_abonos').html('Edici&oacute;n<br />P&aacute;gina: ' + (current_page + 1));
                var row = ((idx_update + 1) % PAGE_LENGTH) === 0 ? PAGE_LENGTH : (idx_update + 1) % PAGE_LENGTH;
                $('#text_row_abonos').html('Fila: ' + row);
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

    DTPropietarios = $('#propietariosTable').DataTable({
        initComplete: function(settings, json) {
            $('#divPropietariosTable').css('display', '');
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
            data: 'jerarquia',
            title: 'N&uacute;mero',
            defaultContent: ''
        }, {
            data: 'identificacion',
            title: 'Identificaci&oacute;n',
            defaultContent: ''
        }, {
            data: 'nombre',
            title: 'Nombre'
        }, {
            title: 'Acción',
            "render": function(data, type, row, meta) {
                return '<a href="#" data-toggle="tooltip" data-placement="top" title="Editar propietario" class="editPropietario"> <i class="fa fa-edit"></i> </a>';
            }
        }],
        drawCallback: function(settings) {
            $('.editPropietario').off('click').on('click', function() {
                var tr = $(this).closest('tr');
                var data = DTPropietarios.row(tr).data();
                $('.datohidden').remove();
                setFormData('form-predios-datos-propietarios', data);

                $('#jerarquia').val(data.jerarquia);
                $('#form-predios-datos-propietarios').find('#span_jerarquia').html(data.jerarquia);
                $('#span_de_jererquia').html(' de ' + DTPropietarios.rows().data().length);

                $('#new_dp').css('display', '');
                $('#cancel_dp').css('display', 'none');
                DTPropietarios.$('.row-selected').toggleClass('row-selected');
                $(tr).addClass('row-selected');
                idx_update = DTPropietarios.row(tr).index();
                var info = DTPropietarios.page.info();
                current_page = info.page;
                $('#text_page_propietarios').html('Edici&oacute;n<br />P&aacute;gina: ' + (current_page + 1));
                var row = ((idx_update + 1) % PAGE_LENGTH) === 0 ? PAGE_LENGTH : (idx_update + 1) % PAGE_LENGTH;
                $('#text_row_propietarios').html('Fila: ' + row);
                $('#div_set_jerarquia').fadeOut(function() {
                    $('#div_jerarquia').fadeIn();
                });
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

    $('#div_jerarquia').off('click').on('click', function() {
        if(DTPropietarios.rows().data().length > 1 && !nuevo_propietario) {
            $('#val_jerarquia').val($('#span_jerarquia').text());
            $('#val_jerarquia').attr('max', DTPropietarios.rows().data().length);
            $('#div_jerarquia').fadeOut(function() {
                $('#div_set_jerarquia').fadeIn(function() {
                    $('#val_jerarquia').focus();
                });
            });

            $('#val_jerarquia').off('keyup').on('keyup', function() {
                if(Number($(this).val() > Number($(this).attr('max'))) || $(this).val().length < $(this).attr('maxlength')) {
                    $('#save_jerarquia').attr('disabled', true);
                }
                else {
                    $('#save_jerarquia').attr('disabled', false);
                }
            });
        }
    });

    $('#save_jerarquia').off('click').on('click', function() {
        if($('#jerarquia').val() !== $('#val_jerarquia').val()) {
            saveJerarquiaPredio($('#id_predio').val(), $('#jerarquia').val(), $('#val_jerarquia').val());
        }
        else {
            $('#div_set_jerarquia').fadeOut(function() {
                $('#div_jerarquia').fadeIn(function() {
                    $('#val_jerarquia').val('');
                });
            });
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
                    //$('#' + modal).modal('hide');
                    if (response.obj !== undefined) {
                        //var objJson = null;
                        // var arr = [];
                        // if (suffix === 'dp') {
                        //     if ($('#tr_predio_' + $('#id_edit').val()).attr('data-dp') !== undefined) {
                        //         objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dp'));
                        //         if (objJson.length !== undefined) {
                        //             if (jsonObj.id !== undefined) {
                        //                 objJson[last_propietario] = response.obj;
                        //             } else {
                        //                 objJson.push(response.obj);
                        //             }

                        //             $('#tr_predio_' + $('#id_edit').val()).attr('data-' + suffix, JSON.stringify(objJson));
                        //             $('#span_de_jererquia').html(' de ' + objJson.length);
                        //         }
                        //     } else {
                        //         arr.push(response.obj);
                        //         $('#tr_predio_' + $('#id_edit').val()).attr('data-' + suffix, JSON.stringify(arr));
                        //     }
                        // } else {
                        $('#tr_predio_' + $('#id_edit').val()).attr('data-' + suffix, JSON.stringify(response.obj));
                        var info = null;
                        var last_row = null;
                        if (suffix === 'dp') {
                            if (DTPropietarios !== null) {
                               //DTPropietarios.clear().draw();
                                DTPropietarios.rows.add(response.obj).draw();
                                if (jsonObj.id !== undefined) { // actualizando reg
                                    if (idx_update >= 0) {
                                        DTPropietarios.page(current_page).draw('page');
                                        DTPropietarios.$('tr:eq(' + idx_update + ')').toggleClass('row-selected');
                                    }
                                } else {
                                    info = DTPropietarios.page.info();
                                    DTPropietarios.page(info.pages - 1).draw('page');
                                    last_row = DTPropietarios.row(':last').index();
                                    DTPropietarios.$('tr:eq(' + last_row + ')').toggleClass('row-selected');
                                    DTPropietarios.$('tr:last').find('.editPropietario').trigger('click');
                                    $('#divPropietariosTable').css('display', '');
                                    $('#new_dp').css('display', '');
                                    $('#cancel_dp').css('display', 'none');
                                    $('.info_propietarios').css('display', '');
                                }
                            }
                            nuevo_propietario = false;
                        } else if (suffix === 'da') {
                            if (DTAbonos !== null) {
                                //DTAbonos.clear().draw();
                                DTAbonos.rows.add(response.obj).draw();
                                if (jsonObj.id !== undefined) { // actualizando reg
                                    if (idx_update >= 0) {
                                        DTAbonos.page(current_page).draw('page');
                                        DTAbonos.$('tr:eq(' + idx_update + ')').toggleClass('row-selected');
                                    }
                                } else {
                                    info = DTAbonos.page.info();
                                    DTAbonos.page(info.pages - 1).draw('page');
                                    last_row = DTAbonos.row(':last').index();
                                    DTAbonos.$('tr:eq(' + last_row + ')').toggleClass('row-selected');
                                    DTAbonos.$('tr:last').find('.editAbono').trigger('click');
                                    $('#divAbonosTable').css('display', '');
                                    $('#new_da').css('display', '');
                                    $('#cancel_da').css('display', 'none');
                                    $('.info_abonos').css('display', '');
                                }
                            }
                        }
                        //}
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

            if (response.predio_propietarios !== undefined && response.predio_propietarios !== null) {
                // if (response.predio_propietario.length > 0) {
                //     $('#tr_predio_' + $('#id_edit').val()).attr('data-dp', JSON.stringify(response.predio_propietarios));
                // }
                $('#tr_predio_' + $('#id_edit').val()).attr('data-dp', JSON.stringify(response.predio_propietarios));
                //if (response.predio_propietarios.length > 1) {
                    if (DTPropietarios !== null) {
                        DTPropietarios.clear().draw();
                        DTPropietarios.rows.add(response.predio_propietarios).draw();
                    }
                //}
            }

            if (response.predio_calculo !== undefined && response.predio_calculo !== null) {
                $('#tr_predio_' + $('#id_edit').val()).attr('data-dc', JSON.stringify(response.predio_calculo));
            }

            ///
            $('.datohidden').remove();
            $('#acuerdo_pago').attr('disabled', false);
            $('#form-predios-datos-pagos')[0].reset();
            clear_form_elements("#form-predios-datos-pagos");
            $('#span_acuerdo_pago').html('NO');
            if (response.predio_pago !== undefined && response.predio_pago !== null) {
                $('#tr_predio_' + $('#id_edit').val()).attr('data-dpa', JSON.stringify(response.predio_pago));
                var objJson = JSON.parse($('#tr_predio_' + $('#id_edit').val()).attr('data-dpa'));
                setFormData('form-predios-datos-pagos', objJson);
            }
            $('#acuerdo_pago').attr('disabled', true);

            if (response.predio_acuerdo_pago !== undefined && response.predio_acuerdo_pago !== null) {
                $('#tr_predio_' + $('#id_edit').val()).attr('data-dap', JSON.stringify(response.predio_acuerdo_pago));
            }

            if (response.predio_abonos !== undefined && response.predio_abonos !== null) {
                $('#tr_predio_' + $('#id_edit').val()).attr('data-da', JSON.stringify(response.predio_abonos));
                //if (response.predio_abonos.length > 1) {
                    if (DTAbonos !== null) {
                        DTAbonos.clear().draw();
                        DTAbonos.rows.add(response.predio_abonos).draw();
                    }
                //}
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
                    if ($.inArray(i, arr_autonumeric) >= 0 || i === 'valor_pago') {
                        if(i === 'valor_pago') {
                            $('#valor_pago').val(accounting.formatMoney(Number(el), "$ ", 2, ",", "."));
                        }
                        else {
                            new AutoNumeric('#' + i, {
                                emptyInputBehavior: "zero",
                                minimumValue: "0",
                                modifyValueOnWheel: false,
                                unformatOnSubmit: true
                            });
                            AutoNumeric.set('#' + i, Number(el));
                        }
                    } else {
                        $('#' + form).find('#' + i).val(el);
                        if ($('#' + form).find('#' + i).is(':checkbox')) {
                            if (Number(el) > 0 || Number(el) === -1) {
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

function saveJerarquiaPredio(id_predio, jerarquia_anterior, jerarquia_nueva) {
    $('.modal').css('z-index', 1040);
    $.blockUI({
        message: "Ejecutando operaci&oacute;n. Espere un momento.",
        css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
            color: '#fff',
            zIndex: 9999
        }
    });
    var jsonObj = {};
    jsonObj.id_predio = id_predio;
    jsonObj.jerarquia_anterior = jerarquia_anterior;
    jsonObj.jerarquia_nueva = jerarquia_nueva;
    $.ajax({
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: 'json',
        url: '/store/predios_propietarios_jerarquia',
        data: {
            form: JSON.stringify(jsonObj)
        },
        success: function(response) {
            if (DTPropietarios !== null) {
                $('#tr_predio_' + $('#id_edit').val()).attr('data-dp', JSON.stringify(response.data));
                DTPropietarios.clear().draw();
                DTPropietarios.rows.add(response.data).draw();
                DTPropietarios.page(0).draw('page');
                var first_row = DTPropietarios.row(':first').index();
                DTPropietarios.$('tr:eq(' + first_row + ')').toggleClass('row-selected');
                DTPropietarios.$('tr:first').find('.editPropietario').trigger('click');
            }
            $('#div_set_jerarquia').fadeOut(function() {
                $('#div_jerarquia').fadeIn(function() {
                    $('#val_jerarquia').val('');
                    $.unblockUI();
                    $('.modal').css('z-index', 1041);
                });
            });
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            $.unblockUI();
            $('.modal').css('z-index', 1041);
        }
    });
}
