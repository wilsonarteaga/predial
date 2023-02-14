var DTPagos = null;
var PAGE_LENGTH = 5;
var MAX_FILE_SIZE = 10;
var global_filtroform_to_send = "";
var bar = $('.bar.one');
var percent = $('.porciento.one');
$(document).ready(function() {
    $('#numero_recibo').bind('keyup', function() {
        if($.trim($(this).val()).length === 9) {
            getInfoPago();
        }
        else {
            $('#btn_save_info').attr('disabled', false);
        }
    });

    $('#upload-asobancaria').off('click').on('click', function() {
        var btn = $(this);
        $(btn).attr('disabled', true);
        $('#modal-carga-archivo-asobancaria').modal({ backdrop: 'static', keyboard: false }, 'show');
        $('#btn_cargar_archivo_asobancaria').attr('disabled', true);

        $('#modal-carga-archivo-asobancaria').on('hidden.bs.modal', function() {
            $('#load-form')[0].reset();
            $('#upload-asobancaria').attr('disabled', false);
            reset_bar(false);
        });

    });

    $("#btn_buscar_pagos").off("click").on("click", function() {
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
        info: true,
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

    $('#load-form').ajaxForm({
        beforeSend: function() {
            $.blockUI({
                message: 'Espere un momento por favor...',
                css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: 0.5,
                    color: '#fff',
                    zIndex: 9999
                }
            });
            $('.btnasobancaria').attr('disabled', true);
            reset_bar(true);
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
        complete: function(xhr) {
            $.unblockUI();
            $('.btnasobancaria').attr('disabled', false);
        },
        success: function(response, statusText, xhr, $form) {
            if (response.message !== undefined) {
                $('#current_filename').html(response.message);
                if(!response.error) {
                    percent.css('color', '#2eb52a');
                    percent.html('Archivo cargado con &eacute;xito');
                }
                else {
                    percent.css('color', 'tomato');
                    percent.html('Error al cargar el archivo');
                }
            }
        }
    });

    $('#fecha_pago').bind('change', function() {
        if(isNaN(Date.parse($('#fecha_pago').val()))) {
            $('#numero_recibo').attr('disabled', true);
            $('#numero_recibo').val('');
            $('#fecha_pago').datepicker('reset');
            $('#create-form')[0].reset();
            $('#id_banco_archivo').val('default').selectpicker("refresh");
        }
    });
    $('#fecha_pago').on('pick.datepicker', function (e) {
        $('#btn_save_info').attr('disabled', false);
        $('#fecha_pago').datepicker('hide');
        $('#numero_recibo').attr('disabled', false);
        $('#numero_recibo').focus();
        $('#id_banco_archivo').val('default').selectpicker("refresh");
        var validatorCreate = $("#create-form").validate();
        validatorCreate.resetForm();
        $.each($('.has-error'), function(i, el) {
            $(el).removeClass('has-error');
        });
    });
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
    jsonObj.fecha_pago = $('#fecha_pago').val();
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
                var prev_valor = response[0].valor_pago;
                $('#id_predio').val(response[0].id_predio);
                $('#codigo_predio').val(response[0].codigo_predio);

                if (prev_valor === '.00'|| prev_valor === null) {
                    prev_valor = '0.00';
                }

                if(Number(prev_valor) > 0) {
                    AutoNumeric.set('#valor_facturado', Number(prev_valor));
                }

                if(response[0].fecha_pago !== null) {
                    $('#fecha_factura').val(response[0].fecha_pago.substr(0, 10));
                }
                else {
                    $('#fecha_factura').val('');
                }

                if(response[0].ultimo_anio !== null) {
                    $('#anio_pago').val(response[0].ultimo_anio);
                }
                else {
                    $('#anio_pago').val('');
                }

                if(response[0].codigo_barras !== null) {
                    $('#codigo_barras').val(response[0].codigo_barras);
                }
                else {
                    $('#codigo_barras').val('');
                }

                if(response[0].id_banco_archivo !== null) {
                    $('#id_banco_archivo').val(response[0].id_banco_archivo).selectpicker("refresh");
                }
                else {
                    $('#id_banco_archivo').val('default').selectpicker("refresh");
                }

                if(response[0].paquete_archivo !== null) {
                    $('#paquete_archivo').val(response[0].paquete_archivo);
                }
                else {
                    $('#paquete_archivo').val('');
                }

                if(Number(response[0].pagado) < 0) {
                    $('#btn_save_info').attr('disabled', true);
                    swal({
                        title: "Atención",
                        text: `El número de factura ${jsonObj.factura_pago} ya posee un pago registrado. Verifique su consulta`,
                        type: "error",
                        showCancelButton: false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Aceptar",
                        closeOnConfirm: true
                    });
                }
            } else {
                swal({
                    title: "Atención",
                    text: `El número de factura ${jsonObj.factura_pago} no fue encontrado en el sistema. Verifique su consulta`,
                    type: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Aceptar",
                    closeOnConfirm: true
                });
                $('#id_predio').val('');
                $('#codigo_predio').val('');
                AutoNumeric.set('#valor_facturado', 0);
                $('#fecha_factura').val('');
                $('#anio_pago').val('');
                $('#codigo_barras').val('');
                $('#id_banco_archivo').val('default').selectpicker("refresh");
                $('#paquete_archivo').val('');
            }
            $.unblockUI();
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
        id_banco: "Banco requerido",
    },
});

function reset_bar(before) {
    var percentVal = '0%';
    bar.width(percentVal);
    percent.html(percentVal);
    percent.css('color', '#000000');
    if (before) {
        percent.css('display', 'inline-block');
    } else {
        percent.css('display', 'none');
    }
    $('#btn_cargar_archivo_asobancaria').attr('disabled', before);
    $('#btn_cargar_archivo_asobancaria').css('display', '');
    $('#current_filename').html('');
}
