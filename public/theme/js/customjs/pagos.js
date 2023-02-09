var DTPagos = null;
var PAGE_LENGTH = 3;
var MAX_FILE_SIZE = 10;
var global_filtroform_to_send = "";
var bar = $('.bar.one');
var percent = $('.porciento.one');
$(document).ready(function() {
    $('#numero_recibo').bind('keyup', function() {
        if($.trim($(this).val()).length === 9) {
            getInfoPago();
        }
    });

    $('#upload-asobancaria').off('click').on('click', function() {
        var btn = $(this);
        $(btn).attr('disabled', true);
        $('#modal-carga-archivo-asobancaria').modal({ backdrop: 'static', keyboard: false }, 'show');
        $('#btn_cargar_archivo_asobancaria').attr('disabled', true);
    });

    $('#modal-carga-archivo-asobancaria').on('hidden.bs.modal', function() {
        $('#load-form')[0].reset();
        $('#upload-asobancaria').attr('disabled', false);
    });

    // $('#codigo_barras').bind('keyup', function() {
    //     if($(this).val().length === 72) {
    //         if(!$('#numero_recibo').attr('readonly')) {
    //             $('#numero_recibo').attr('readonly', true);
    //             $('#valor_facturado').attr('readonly', true);
    //             $('#fecha_factura').attr('readonly', true);
    //             $('.datepicker').datepicker({
    //                 language: 'es-ES',
    //                 format: 'yyyy-mm-dd',
    //                 hide: function() {
    //                     if ($("#create-form").length > 0) {
    //                         if ($('#' + $(this).attr('id') + '-error').length > 0)
    //                             $('#' + $(this).attr('id') + '-error').remove();

    //                         if ($('#create-form').is(':visible')) {
    //                             $('#create-form').validate().element($(this));
    //                         }
    //                     }
    //                     if ($("#update-form").length > 0) {
    //                         if ($('#' + $(this).attr('id') + '-error').length > 0)
    //                             $('#' + $(this).attr('id') + '-error').remove();

    //                         if ($('#update-form').is(':visible')) {
    //                             $('#update-form').validate().element($(this));
    //                         }
    //                     }
    //                 }
    //             });
    //             $('#anio_pago').attr('readonly', true);
    //         }
    //         var section_1 = $(this).val().substr(0, 15); // 15 caracteres
    //         var section_2 = $(this).val().substr(16, 28); // 28 caracteres
    //         var section_3 = $(this).val().substr(44, 18); // 18 caracteres
    //         var section_4 = $(this).val().substr(62); // 10 caracteres
    //         $('#numero_recibo').val(Number(section_2.substr(4))).attr('readonly', true);
    //         AutoNumeric.set('#valor_facturado', Number(section_3.substr(4)));
    //         $('#valor_facturado').attr('readonly', true);
    //         $('#fecha_factura').datepicker('setDate', stringToDate(section_4.substr(2))).attr('readonly', true);
    //         $('#fecha_factura').datepicker('destroy');
    //         $('#anio_pago').val(Number(section_4.substr(2).substr(0, 4))).attr('readonly', true);
    //     }
    //     else {
    //         $('#numero_recibo').val('').attr('readonly', false);
    //         $('#valor_facturado').attr('readonly', false);
    //         AutoNumeric.set('#valor_facturado', 0);
    //         $('#fecha_factura').attr('readonly', false);
    //         $('.datepicker').datepicker({
    //             language: 'es-ES',
    //             format: 'yyyy-mm-dd',
    //             hide: function() {
    //                 if ($("#create-form").length > 0) {
    //                     if ($('#' + $(this).attr('id') + '-error').length > 0)
    //                         $('#' + $(this).attr('id') + '-error').remove();

    //                     if ($('#create-form').is(':visible')) {
    //                         $('#create-form').validate().element($(this));
    //                     }
    //                 }
    //                 if ($("#update-form").length > 0) {
    //                     if ($('#' + $(this).attr('id') + '-error').length > 0)
    //                         $('#' + $(this).attr('id') + '-error').remove();

    //                     if ($('#update-form').is(':visible')) {
    //                         $('#update-form').validate().element($(this));
    //                     }
    //                 }
    //             }
    //         });
    //         $('#anio_pago').attr('readonly', false);
    //     }
    // });

    $("#btn_buscar_pagos")
        .off("click")
        .on("click", function() {
            var form = $("#pagos-filtro-form");
            if (form.valid()) {
                var input_fecha_pago_listar = $(
                    '<input class="datohidden" id="fecha_pago" name="fecha_pago" type="hidden" value="' +
                    $("#fecha_pago_listar").val() +
                    '"  />'
                );
                $("#" + global_filtroform_to_send).prepend(
                    input_fecha_pago_listar
                );

                var input_banco_pago_listar = $(
                    '<input class="datohidden" id="banco_pago" name="banco_pago" type="hidden" value="' +
                    $("#id_banco").val() +
                    '"  />'
                );
                $("#" + global_filtroform_to_send).prepend(
                    input_banco_pago_listar
                );

                $("#" + global_filtroform_to_send)
                    .first()
                    .submit();
            }

            getJsonPagos();
        });

    DTPagos = $("#pagosTable").DataTable({
        initComplete: function(settings, json) {
            //$("#pagosTable").css("display", "");
        },
        destroy: true,
        ordering: false,
        //"filter": false,
        order: [],
        lengthChange: false,
        info: false,
        pageLength: PAGE_LENGTH,
        select: false,
        autoWidth: false,
        language: {
            url: ROOT_URL +
                "/theme/plugins/bower_components/datatables/spanish.json",
        },
        data: [],
        columns: [{
                data: "id",
                title: "id",
                visible: false,
            },
            {
                data: "numero_recibo",
                title: "N&uacute;mero recibo",
                defaultContent: "",
            },
            {
                data: "valor_facturado",
                title: "Valor facturado",
                defaultContent: "",
            },
            {
                data: "anio_pago",
                title: "A&ntilde;o pago",
            },
            {
                data: "fecha_factura",
                title: "Fecha factura",
            },
            {
                data: "banco",
                title: "Banco",
            },
            // {
            //     title: "Acción",
            //     render: function (data, type, row, meta) {
            //         return '<a href="#" data-toggle="tooltip" data-placement="top" title="Editar propietario" class="editPropietario"> <i class="fa fa-edit"></i> </a>';
            //     },
            // },
        ],
        drawCallback: function(settings) {
            // $(".editPropietario")
            //     .off("click")
            //     .on("click", function () {
            //         var tr = $(this).closest("tr");
            //         var data = DTPropietarios.row(tr).data();
            //         $(".datohidden").remove();
            //         setFormData("form-predios-datos-propietarios", data);
            //         $("#jerarquia").val(data.jerarquia);
            //         $("#form-predios-datos-propietarios")
            //             .find("#span_jerarquia")
            //             .html(data.jerarquia);
            //         $("#span_de_jererquia").html(
            //             " de " + DTPropietarios.rows().data().length
            //         );
            //         $("#new_dp").css("display", "");
            //         $("#cancel_dp").css("display", "none");
            //         DTPropietarios.$(".row-selected").toggleClass(
            //             "row-selected"
            //         );
            //         $(tr).addClass("row-selected");
            //         idx_update = DTPropietarios.row(tr).index();
            //         var info = DTPropietarios.page.info();
            //         current_page = info.page;
            //         $("#text_page_propietarios").html(
            //             "Edici&oacute;n<br />P&aacute;gina: " +
            //                 (current_page + 1)
            //         );
            //         var row =
            //             (idx_update + 1) % PAGE_LENGTH === 0
            //                 ? PAGE_LENGTH
            //                 : (idx_update + 1) % PAGE_LENGTH;
            //         $("#text_row_propietarios").html("Fila: " + row);
            //     });
        },
        columnDefs: [
            { className: "text-center", targets: [1, 2, 3, 4, 5] },
            //{ className: 'text-center', "targets": [6] },
            //{ className: 'text-right money', targets: [1, 2] },
            //{ className: 'text-center stock_selected', targets: [4] },
            //, { "visible": false, "targets": [2] }
        ],
    });

    $('#btn_cargar_archivo_asobancaria').off('click').on('click', function() {
        $('#load-form').submit();
    });

    $('#file').bind('change', function() {
        reset_bar(false);
        // clearImageLoader();
        var filesize = this.files[0].size; // On older browsers this can return NULL.
        var filesizeMB = (filesize / (1024 * 1024)).toFixed(2);

        if (filesizeMB <= MAX_FILE_SIZE) {
            // Allow the form to be submitted here.
            $('#btn_cargar_archivo_asobancaria').attr('disabled', false);
            $('#error_fileupload').fadeOut();
        } else {
            // Don't allow submission of the form here.
            $('#btn_cargar_archivo_asobancaria').attr('disabled', true);
            $('#error_fileupload').fadeIn();
        }
    });

    // $('#load-form').ajaxForm({
    //     beforeSend: function() {
    //         $.blockUI({
    //             message: 'Espere un momento por favor...',
    //             css: {
    //                 border: 'none',
    //                 padding: '15px',
    //                 backgroundColor: '#000',
    //                 '-webkit-border-radius': '10px',
    //                 '-moz-border-radius': '10px',
    //                 opacity: 0.5,
    //                 color: '#fff'
    //             }
    //         });

    //         reset_bar(true);
    //     },
    //     uploadProgress: function(event, position, total, percentComplete) {
    //         var percentVal = percentComplete + '%';
    //         bar.width(percentVal);
    //         percent.html(percentVal);
    //     },
    //     complete: function(xhr) {
    //         $.unblockUI();
    //     },
    //     success: function(response, statusText, xhr, $form) {
    //         if (response.filename !== undefined) {
    //             $('#current_filename').html('<b>Archivo cargado:</b> ' + response.filename);
    //             //$('#btn_analysis').attr('data-filename', response.filename);
    //             //$('#btn_analysis').attr('data-fileid', response.id);
    //             $('#filename').val(response.filename);
    //             $('#fileid').val(response.id);
    //             percent.css('color', '#2eb52a');
    //             percent.html('Archivo cargado satisfactoriamente');

    //             //$('#div_radios').fadeIn();
    //             // $('#btn_analysis').css('display', '');
    //             // $('#btn_upload').css('display', 'none');

    //             // var isview = true;
    //             // var file = response.file;
    //             // var t = $('#myTable').DataTable();
    //             // var folder = file.folder;
    //             // var html_btn = '<button type="button" data-filename="' + file.name + '" data-fileid="' + file.id + '" data-resultdiv="div_images_result" data-objectscroll="div_images_result" class="btn_analysis btn btn-inverse">Analyze</button>';
    //             // if (folder === null) {
    //             //     html_btn = '<button type="button" data-filename="' + file.name + '" data-fileid="' + file.id + '" data-resultdiv="div_images_result" data-objectscroll="div_images_result" class="btn_setfolder btn btn-warning">Set folder</button>';
    //             //     folder = 'No folder';
    //             //     isview = false;
    //             // }
    //             // t.row.add([
    //             //     file.id,
    //             //     file.name,
    //             //     folder,
    //             //     statuses[file.analyzed],
    //             //     file.created_at,
    //             //     file.updated_at,
    //             //     html_btn
    //             // ]).draw(false);

    //             // if (isview) {
    //             //     $('.btn_view').off('click').on('click', view);
    //             // } else {
    //             //     $('.btn_setfolder').off('click').on('click', function() {
    //             //         setFolder($(this).attr('data-fileid'), $(this).attr('data-filename'));
    //             //     });
    //             // }

    //         } else {
    //             $('#current_filename').html('<b>Error:</b> ' + response.error);
    //         }
    //     }
    // });
});

function getJsonPagos() {
    $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        url: "/list/pagos_fecha",
        data: {
            fecha_pago: $("#fecha_pago_listar").val(),
            id_banco_factura: $("#id_banco").selectpicker("val"),
        },
        success: function(response) {
            if (response.pagos !== undefined && response.pagos !== null) {
                if (response.pagos.length > 0) {
                    if (DTPagos !== null) {
                        DTPagos.clear().draw();
                        DTPagos.rows.add(response.pagos).draw();
                    }
                } else {
                    DTPagos.clear().draw();
                }
            } else {
                DTPagos.clear().draw();
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        },
    });
}

function getInfoPago() {
    $('#valor_facturado').attr('readonly', true);
    $.blockUI({ message: null });
    $('#btn_save_info').attr('disabled', false);
    var jsonObj = {};
    jsonObj.factura_pago = $('#numero_recibo').val();
    $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        url: '/get_info_pago',
        data: {
            form: JSON.stringify(jsonObj)
        },
        success: function(response) {
            if (response.length > 0) {
                $('#id_predio').val(response[0].id_predio);
                $('#codigo_predio').val(response[0].codigo_predio);
                var prev_valor = response[0].valor_pago;
                if (prev_valor === '.00') {
                    prev_valor = '0.00';
                }
                if(Number(prev_valor) > 0) {
                    AutoNumeric.set('#valor_facturado', Number(prev_valor));
                }
                else {
                    $('#valor_facturado').attr('readonly', false);
                }
                $('#fecha_factura').val(response[0].fecha_pago.substr(0, 10));
                $('#anio_pago').val(response[0].ultimo_anio);
                if(Number(response[0].pagado) > 0) {
                    $('#btn_save_info').attr('disabled', true);
                    swal({
                        title: "Atención",
                        text: "El número de factura consultado ya posee un pago registrado. Verifique su consulta",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Aceptar",
                        closeOnConfirm: true
                    });
                }
            } else {
                $('#create-form')[0].reset();
            }
            $.unblockUI();
            var validatorCreate = $("#create-form").validate();
            validatorCreate.resetForm();
            $.each($('.has-success'), function(i, el) {
                $(el).removeClass('has-success');
            });
            $.each($('.has-error'), function(i, el) {
                $(el).removeClass('has-error');
            });
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            $.unblockUI();
        },
    });
}

function stringToDate(str_date) {
    let return_date = '';
    if(str_date.length === 8) {
        return_date = `${str_date.substr(0, 4)}-${str_date.substr(4, 2)}-${str_date.substr(6)}`;
    }
    else {
        const date = new Date();
        let day = date.getDate();
        let month = date.getMonth() + 1;
        let year = date.getFullYear();
        return_date = `${year}-${month}-${day}`;
    }
    return return_date;
}

var validatorFiltro = $("#pagos-filtro-form").validate({
    rules: {
        fecha_pago_listar: "required",
        id_banco: "required",
    },
    messages: {
        fecha_pago_listar: "Fecha de pago requerido",
        id_banco: "Fecha de pago requerido",
    },
});

function reset_bar(before) {
    // reset_bar2(false);
    var percentVal = '0%';
    bar.width(percentVal);
    percent.html(percentVal);
    percent.css('color', '#000000');
    if (before) {
        percent.css('display', 'inline-block');
        $('#btn_cargar_archivo_asobancaria').attr('disabled', true);
    } else {
        percent.css('display', 'none');
    }
    // $('#btn_analysis').css('display', 'none');
    // $('#btn_analysis').attr('disabled', false);
    // $('#btn_analysis').removeClass('btn-default');
    // $('#btn_analysis').addClass('btn-success');

    $('#btn_cargar_archivo_asobancaria').css('display', '');
    $('#current_filename').html('');
    // $('#div_images').fadeOut(function() {
    //     $('#div_images').find('div:eq(1)').empty();
    //     $('.file_model').empty();
    // });
    // from_tab = false;
}
