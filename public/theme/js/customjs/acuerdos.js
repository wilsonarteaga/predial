var DTAcuerdos = null;
var DTAcuerdoDetalle = null;
var PAGE_LENGTH = 5;
var MAX_FILE_SIZE = 10;
var ROOT_URL = window.location.protocol + "//" + window.location.host;
var global_acuerdo = null;
var modalTableInitialized = false;
var selectedCuotasString = '';
var selectedCuotasIds = [];
var selectedCuotasNumbers = [];

$(document).ready(function() {
    getJsonAcuerdos();

    DTAcuerdoDetalle = $("#acuerdoDetalleTable").DataTable({
        initComplete: function(settings, json) {
            //$("#acuerdosTable").css("display", "");
        },
        destroy: true,
        ordering: false,
        //"filter": false,
        order: [],
        lengthChange: false,
        info: true,
        pageLength: PAGE_LENGTH * 2,
        select: false,
        autoWidth: false,
        language: {
            url: ROOT_URL +
                "/theme/plugins/bower_components/datatables/spanish.json",
        },
        data: [],
        columns: [
            {
                data: "id",
                title: "id",
                visible: false,
            },
            {
                title: "Sel...",
                render: function(data, type, row, meta) {
                    if (row.factura_pago === null) {
                        return '<input type="checkbox" class="cuota-checkbox" data-id="' + row.id + '" data-cuota="' + row.cuota_numero + '">';
                    } else {
                        if (row.file_factura) {
                            return '<a data-toggle="tooltip" data-placement="top" title="Descargar factura ' + row.factura_pago + '" class="download-factura-pagada" data-id="' + row.id + '" href="/downloadFileAcuerdo/' + row.file_factura + '" target="_blank" style="color: red;"><i class="fa fa-file-pdf-o"></i></a>';
                        } else {
                            return '<a data-toggle="tooltip" data-placement="top" title="Descargar factura ' + row.factura_pago + '" class="download-factura-reprocesar" href="/regenerate_factura_acuerdo_pdf/' + row.id + '" target="_blank" style="color: red;"><i class="fa fa-file-pdf-o"></i></a>';
                        }
                    }
                }
            },
            {
                data: "cuota_numero",
                title: "N&uacute;mero<br />cuota",
            },
            {
                // data: "valor_cuota",
                title: "Valor<br />cuota",
                render: function(data, type, row, meta) {
                    return accounting.formatMoney(Number(row.valor_cuota), "$ ", 0, ".", ",");
                }
            },
            {
                data: "fecha_pago",
                title: "Fecha<br />pago",
            },
            {
                data: "pagado",
                title: "Pagado"
            },
            {
                data: "banco",
                title: "Banco"
            },
            {
                // data: "valor_concepto1",
                title: "Predial",
                render: function(data, type, row, meta) {
                    return accounting.formatMoney(Number(row.valor_concepto1), "$ ", 0, ".", ",");
                }
            },
            {
                // data: "valor_concepto2",
                title: "Interes<br />Predial",
                render: function(data, type, row, meta) {
                    return accounting.formatMoney(Number(row.valor_concepto2), "$ ", 0, ".", ",");
                }
            },
            {
                // data: "valor_concepto3",
                title: "CAR",
                render: function(data, type, row, meta) {
                    return accounting.formatMoney(Number(row.valor_concepto3), "$ ", 0, ".", ",");
                }
            },
            {
                // data: "valor_concepto4",
                title: "Interes<br />CAR",
                render: function(data, type, row, meta) {
                    return accounting.formatMoney(Number(row.valor_concepto4), "$ ", 0, ".", ",");
                }
            },
            {
                // data: "valor_concepto5",
                title: "Interes<br />financiaci&oacute;n",
                render: function(data, type, row, meta) {
                    return accounting.formatMoney(Number(row.valor_concepto5), "$ ", 0, ".", ",");
                }
            },
            {
                // data: "valor_concepto18",
                title: "Otros",
                render: function(data, type, row, meta) {
                    return accounting.formatMoney(Number(row.valor_concepto18), "$ ", 0, ".", ",");
                }
            },
        ],
        createdRow: function (row, data, dataIndex) {
            if (data.factura_pago === null) {
                $(row).addClass('detalle-row');
            }
        },
        drawCallback: function(settings) {
            $(".detalle-row")
                .off("click")
                .on("click", function (e) {
                    // Only trigger checkbox if clicking on unpaid row and not on the PDF icon or checkbox itself
                    if (!$(e.target).closest('.download-factura-pagada').length &&
                        !$(e.target).hasClass('cuota-checkbox') &&
                        !$(e.target).closest('.cuota-checkbox').length) {
                        var checkbox = $(this).find(".cuota-checkbox");
                        if (checkbox.length > 0) {
                            checkbox.prop("checked", !checkbox.prop("checked")).trigger("change");
                        }
                    }
                });

            // Handle checkbox selection
            $(".cuota-checkbox")
                .off("change")
                .on("change", function() {
                    var checkbox = $(this);
                    var cuotaId = checkbox.data('id');
                    var cuotaNumber = checkbox.data('cuota');

                    checkbox.closest('tr').toggleClass('detalle-row-selected', checkbox.is(':checked'));

                    if (checkbox.is(':checked')) {
                        // Add to selected list if not already present
                        if (selectedCuotasIds.indexOf(cuotaId) === -1) {
                            selectedCuotasIds.push(cuotaId);
                        }
                        if (selectedCuotasNumbers.indexOf(cuotaNumber) === -1) {
                            selectedCuotasNumbers.push(cuotaNumber);
                        }
                    } else {
                        // Remove from selected list
                        var index = selectedCuotasIds.indexOf(cuotaId);
                        if (index > -1) {
                            selectedCuotasIds.splice(index, 1);
                        }
                        var numberIndex = selectedCuotasNumbers.indexOf(cuotaNumber);
                        if (numberIndex > -1) {
                            selectedCuotasNumbers.splice(numberIndex, 1);
                        }
                    }

                    // Update global variable with comma-separated string
                    selectedCuotasString = selectedCuotasNumbers.join(',');
                    console.log('Selected cuotas:', selectedCuotasString);

                    // Calculate total of selected cuotas
                    var totalSeleccionado = 0;
                    selectedCuotasIds.forEach(function(id) {
                        var rowData = DTAcuerdoDetalle.rows().data().toArray().find(function(row) {
                            return row.id == id;
                        });
                        if (rowData) {
                            totalSeleccionado += parseFloat(rowData.valor_cuota || 0);
                        }
                    });

                    // Show/hide the label and button based on selection
                    if (selectedCuotasIds.length > 0) {
                        $('#valor_total_seleccionado').html(accounting.formatMoney(totalSeleccionado, "$ ", 0, ".", ","));
                        $('#lbl_total_seleccionado').css('opacity', '1');
                        $('#btn_generar_factura_ap').css('opacity', '1');
                    } else {
                        $('#lbl_total_seleccionado').css('opacity', '0');
                        $('#btn_generar_factura_ap').css('opacity', '0');
                    }
                });

            $(".download-factura-reprocesar")
                .off("click")
                .on("click", function(e) {
                    e.stopPropagation(); // Prevent row click
                    downloadFacturaRowReprocesar(this);
                });
        },
        columnDefs: [
            { className: "text-center", targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12] },
            // { className: "text-center acuerdo-noclick-row", targets: [4, 7] },
            //{ className: 'text-center', "targets": [6] },
            //{ className: 'text-right money', targets: [1, 2] },
            //{ className: 'text-center stock_selected', targets: [4] },
            //, { "visible": false, "targets": [2] }
        ],
    });

    DTAcuerdos = $("#acuerdosTable").DataTable({
        initComplete: function(settings, json) {
            //$("#acuerdosTable").css("display", "");
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
                data: "codigo_predio",
                title: "C&oacute;digo predio",
            },
            {
                data: "numero_acuerdo",
                title: "N&uacute;mero"
            },
            {
                data: "fecha_acuerdo",
                title: "Fecha",
            },
            {
                data: "cuotas_acuerdo",
                title: "Cuotas"
            },
            {
                title: "Resoluci&oacute;n",
                render: function (data, type, row, meta) {
                    if (row.file_name) {
                        return '<a data-toggle="tooltip" title="Descargar ' + row.file_name + '" href="/downloadFileResolucion/' + row.file_name + '" style="color: red;"><i style="color: red;" class="fa fa-file-pdf-o"></i></a>';
                    } else {
                        return '&nbsp;';
                    }
                },
            },
            {
                title: "Usuario creaci&oacute;n",
                render: function (data, type, row, meta) {
                    return `${row.nombres} ${row.apellidos}`;
                },
            },
            {
                data: "created_at",
                title: "Fecha creaci&oacute;n",
            },
        ],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass('acuerdo-row');
        },
        drawCallback: function(settings) {
            $(".deleteAcuerdo")
                .off("click")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var data = DTAcuerdos.row(tr).data();
                    swal({
                        title: "Atención",
                        text: '¿Está seguro que desea eliminar la información del acuerdo de pago?',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Si",
                        cancelButtonText: "No",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    }, function(isConfirm) {
                        if (isConfirm) {
                            saveEliminarAcuerdo(data.id);
                        }
                        $('[data-toggle="tooltip"]').tooltip();
                    });
                });

            $(".acuerdo-row")
                .off("click")
                .on("click", function () {
                    $('.result').empty();
                    var tr = $(this).closest("tr");
                    var data = DTAcuerdos.row(tr).data();
                    global_acuerdo = JSON.parse(JSON.stringify(data));
                    getJsonAcuerdoAnios(global_acuerdo.id, global_acuerdo.anio_inicial_acuerdo, global_acuerdo.anio_final_acuerdo);
                    setData(global_acuerdo);
                    $('#total_acuerdo_edit').attr('data-total', parseFloat(global_acuerdo.total_acuerdo) + parseFloat(global_acuerdo.abono_inicial_acuerdo));
                    $('#btn_generar_factura_ap').attr('data-id', global_acuerdo.id);
                });

            $('.print_factura').off("click").on("click", function() {
                var tr = $(this).closest("tr");
                var data = DTAcuerdos.row(tr).data();
                // console.log('📌 - acuerdos.js:151 - data:', data);
                var btn = $(this);
                startImpresion($(btn).attr('url') + data.id_predio + '/0/' + data.anio + '/-/1/-1/0', 'Generación de factura informativa de impuesto predial. Espere un momento por favor.', 'success', '');
            });
        },
        columnDefs: [
            { className: "text-center", targets: [1, 2, 3, 4, 5, 6, 7] },
            // { className: "text-center acuerdo-noclick-row", targets: [4, 7] },
            //{ className: 'text-center', "targets": [6] },
            //{ className: 'text-right money', targets: [1, 2] },
            //{ className: 'text-center stock_selected', targets: [4] },
            //, { "visible": false, "targets": [2] }
        ],
    });

    if($('#print_acuerdos').length) {
        $('#print_acuerdos').off('click').on('click', function() {
            var validatorInforme = $("#form-impresion-informe").validate({
                rules: {
                    fecha_min_acuerdos: "required",
                    fecha_max_acuerdos: "required",
                },
                messages: {
                    fecha_min_acuerdos: "Fecha m&iacute;nima requerida",
                    fecha_max_acuerdos: "Fecha m&aacute;xima requerida",
                }
            });
            $('#modal-impresion').modal({ backdrop: 'static', keyboard: false }, 'show');
            // $('#modal-impresion').off('shown.bs.modal').on('shown.bs.modal', function() {
            // });

            $('#modal-impresion').off('hidden.bs.modal').on('hidden.bs.modal', function() {
                $('#form-impresion-informe')[0].reset();
                clear_form_elements("#form-impresion-informe");
                validatorInforme.resetForm();
                $('#fecha_min_acuerdos').removeClass('error');
                $('#fecha_max_acuerdos').removeClass('error');
            });
        });

        $('#fecha_min_acuerdos').on('pick.datepicker', function (e) {
            $('#fecha_min_acuerdos').removeClass('error');
        });
        $('#fecha_max_acuerdos').on('pick.datepicker', function (e) {
            $('#fecha_max_acuerdos').removeClass('error');
            if (e.date !== null) {
                if ($('#fecha_max_acuerdos').datepicker('getDate') < $('#fecha_min_acuerdos').datepicker('getDate')) {
                    $('#fecha_min_acuerdos').datepicker('setDate', '');
                    $('#fecha_min_acuerdos').val('');
                }
            }
        });
    }

    // if($('#generar_informe_acuerdos').length) {
    //     $('#generar_informe_acuerdos').off('click').on('click', function() {
    //         var btn = $(this);
    //         var form = $("#form-impresion-informe");
    //         if (form.valid()) {
    //             $('.btn_pdf').attr('disabled', true);
    //             startImpresion($(btn).attr('url') + $('#fecha_min_prescripcion').val() + '/' + $('#fecha_max_prescripcion').val(), 'Iniciando generación de listado de acuerdos de pago. Espere un momento por favor.', 'warning', 'modal-impresion');
    //         }
    //     });
    // }

    if ($('#calcular_intereses').length > 0) {
        $('#calcular_intereses').val('1');
        $('#calcular_intereses').attr('checked', true);
    }

    if ($('#cuotas_acuerdo').length > 0) {
        $('#cuotas_acuerdo').val('1');
        $('#cuotas_acuerdo').off('keyup').on('keyup', function() {
            var cuotas = $(this).val();
            if (cuotas.length == 0) {
                $(this).val('1');
            }
        });

        $('#cuotas_acuerdo').off('focus click').on('focus click', function() {
            $(this).select();
        });
    }

    if ($('#cuotas_acuerdo_edit').length > 0) {
        $('#cuotas_acuerdo_edit').val('1');
        $('#cuotas_acuerdo_edit').off('keyup').on('keyup', function() {
            var cuotas = $(this).val();
            if (cuotas.length == 0) {
                $(this).val('1');
            }
        });

        $('#cuotas_acuerdo_edit').off('focus click').on('focus click', function() {
            $(this).select();
        });
    }

    if ($('#fecha_acuerdo').length > 0) {
        // Create a date object from a date string
        var today = new Date();
        // Get year, month, and day part from the date
        var year = today.toLocaleString("default", { year: "numeric" });
        var month = today.toLocaleString("default", { month: "2-digit" });
        var day = today.toLocaleString("default", { day: "2-digit" });
        // Generate yyyy-mm-dd date string
        var formattedDate = year + "-" + month + "-" + day;
        $('#fecha_acuerdo').datepicker('setDate', formattedDate);
        // $('#fecha_acuerdo').datepicker('setStartDate', formattedDate);

        $('#fecha_acuerdo').off('keyup').on('keyup', function() {
            var fecha = $(this).val();
            if (fecha.length == 0) {
                // Create a date object from a date string
                var today = new Date();
                // Get year, month, and day part from the date
                var year = today.toLocaleString("default", { year: "numeric" });
                var month = today.toLocaleString("default", { month: "2-digit" });
                var day = today.toLocaleString("default", { day: "2-digit" });
                // Generate yyyy-mm-dd date string
                var formattedDate = year + "-" + month + "-" + day;
                $('#fecha_acuerdo').datepicker('setDate', formattedDate);
            }
        });
    }

    if ($('#fecha_acuerdo_edit').length > 0) {
        // Create a date object from a date string
        var today = new Date();
        // Get year, month, and day part from the date
        var year = today.toLocaleString("default", { year: "numeric" });
        var month = today.toLocaleString("default", { month: "2-digit" });
        var day = today.toLocaleString("default", { day: "2-digit" });
        // Generate yyyy-mm-dd date string
        var formattedDate = year + "-" + month + "-" + day;
        $('#fecha_acuerdo_edit').datepicker('setDate', formattedDate);
        // $('#fecha_acuerdo_edit').datepicker('setStartDate', formattedDate);

        $('#fecha_acuerdo_edit').off('keyup').on('keyup', function() {
            var fecha = $(this).val();
            if (fecha.length == 0) {
                // Create a date object from a date string
                var today = new Date();
                // Get year, month, and day part from the date
                var year = today.toLocaleString("default", { year: "numeric" });
                var month = today.toLocaleString("default", { month: "2-digit" });
                var day = today.toLocaleString("default", { day: "2-digit" });
                // Generate yyyy-mm-dd date string
                var formattedDate = year + "-" + month + "-" + day;
                $('#fecha_acuerdo_edit').datepicker('setDate', formattedDate);
            }
        });
    }

    if ($('#fecha_inicial_acuerdo').length > 0) {
        // Create a date object from a date string
        var today = new Date();
        // Get year, month, and day part from the date
        var year = today.toLocaleString("default", { year: "numeric" });
        var month = today.toLocaleString("default", { month: "2-digit" });
        var day = today.toLocaleString("default", { day: "2-digit" });
        // Generate yyyy-mm-dd date string
        var formattedDate = year + "-" + month + "-" + day;
        $('#fecha_inicial_acuerdo').datepicker('setDate', formattedDate);
        // $('#fecha_inicial_acuerdo').datepicker('setStartDate', formattedDate);

        $('#fecha_inicial_acuerdo').off('keyup').on('keyup', function() {
            var fecha = $(this).val();
            if (fecha.length == 0) {
                // Create a date object from a date string
                var today = new Date();
                // Get year, month, and day part from the date
                var year = today.toLocaleString("default", { year: "numeric" });
                var month = today.toLocaleString("default", { month: "2-digit" });
                var day = today.toLocaleString("default", { day: "2-digit" });
                // Generate yyyy-mm-dd date string
                var formattedDate = year + "-" + month + "-" + day;
                $('#fecha_inicial_acuerdo').datepicker('setDate', formattedDate);
            }
        });
    }

    if ($('#fecha_inicial_acuerdo_edit').length > 0) {
        // Create a date object from a date string
        var today = new Date();
        // Get year, month, and day part from the date
        var year = today.toLocaleString("default", { year: "numeric" });
        var month = today.toLocaleString("default", { month: "2-digit" });
        var day = today.toLocaleString("default", { day: "2-digit" });
        // Generate yyyy-mm-dd date string
        var formattedDate = year + "-" + month + "-" + day;
        $('#fecha_inicial_acuerdo_edit').datepicker('setDate', formattedDate);
        // $('#fecha_inicial_acuerdo_edit').datepicker('setStartDate', formattedDate);

        $('#fecha_inicial_acuerdo_edit').off('keyup').on('keyup', function() {
            var fecha = $(this).val();
            if (fecha.length == 0) {
                // Create a date object from a date string
                var today = new Date();
                // Get year, month, and day part from the date
                var year = today.toLocaleString("default", { year: "numeric" });
                var month = today.toLocaleString("default", { month: "2-digit" });
                var day = today.toLocaleString("default", { day: "2-digit" });
                // Generate yyyy-mm-dd date string
                var formattedDate = year + "-" + month + "-" + day;
                $('#fecha_inicial_acuerdo_edit').datepicker('setDate', formattedDate);
            }
        });
    }

    if ($('#btn_descargar_excel_acuerdos')) {
        $('#btn_descargar_excel_acuerdos').off('click').on('click', function() {
            var btn = $(this);
            var form = $("#form-impresion-informe");
            if (form.valid()) {
                $('.btn_excel').attr('disabled', true);
                var tipo = $(btn).attr('tipo');
                var fecha_inicial = $('#fecha_min_acuerdos').val();
                var fecha_final = $('#fecha_max_acuerdos').val();

                $.blockUI({
                    message: `Generando archivo EXCEL con reporte de ${tipo} desde ${fecha_inicial} hasta ${fecha_final}.<br />Espere un momento.`,
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff',
                        zIndex: 9999
                    },
                    overlayCSS:  {
                        zIndex: 1100
                    },
                });
                fetch(`/export-excel-${tipo}/${fecha_inicial}/${fecha_final}`)
                .then(resp => resp.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    // the filename you want
                    a.download = `reporte-${tipo}-a-facturas-${fecha_inicial}_${fecha_final}.xlsx`;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    $.unblockUI();
                    $('.btn_excel').attr('disabled', false);
                })
                .catch((err) => {
                    $.unblockUI();
                    $('.btn_excel').attr('disabled', false);
                    console.log(err);
                });
            }
        });
    }

    if ($('#porcentaje_inicial_acuerdo').length) {
        $('#porcentaje_inicial_acuerdo').off('change').on('change', function() {
            var porcentaje = AutoNumeric.getNumber('#porcentaje_inicial_acuerdo');
            var total_acuerdo = Number($('#total_acuerdo').attr('data-total'));
            var valor_abono_inicial = (total_acuerdo * porcentaje) / 100;
            var new_total = total_acuerdo - valor_abono_inicial;
            $('#total_acuerdo').html(accounting.formatMoney(new_total, "$ ", 2, ".", ", "));
            AutoNumeric.set('#abono_inicial_acuerdo', valor_abono_inicial);
        });
    }

    if ($('#porcentaje_inicial_acuerdo_edit').length) {
        $('#porcentaje_inicial_acuerdo_edit').off('change').on('change', function() {
            var porcentaje = AutoNumeric.getNumber('#porcentaje_inicial_acuerdo_edit');
            var total_acuerdo = Number($('#total_acuerdo_edit').attr('data-total'));
            var valor_abono_inicial = (total_acuerdo * porcentaje) / 100;
            var new_total = total_acuerdo - valor_abono_inicial;
            $('#total_acuerdo_edit').html(accounting.formatMoney(new_total, "$ ", 2, ".", ", "));
            AutoNumeric.set('#abono_inicial_acuerdo_edit', valor_abono_inicial);
        });
    }

    if($('#anio_inicial_acuerdo').length) {
        $('#anio_inicial_acuerdo').off('change').on('change', function() {
            if ($('#anio_inicial_acuerdo').val().length > 0) {
                if(Number($('#anio_inicial_acuerdo').val()) > Number($('#anio_final_acuerdo').val())) {
                    $('#anio_final_acuerdo').val('');
                } else {
                    if($('#anio_inicial_acuerdo').val().length > 0 && $('#anio_final_acuerdo').val().length > 0) {
                        var anios = global_anios.filter(el => parseInt(el.ultimo_anio) >= parseInt($('#anio_inicial_acuerdo').val()) && parseInt(el.ultimo_anio) <= parseInt($('#anio_final_acuerdo').val()));
                        var total_acuerdo = 0;
                        for (var anio of anios) {
                            total_acuerdo += Number(anio.total_calculo);
                        }
                        $('#total_acuerdo').attr('data-total', total_acuerdo);
                        $('#total_acuerdo').html(accounting.formatMoney(total_acuerdo - AutoNumeric.getNumber('#abono_inicial_acuerdo'), "$ ", 2, ".", ", "));
                        if (AutoNumeric.getNumber('#abono_inicial_acuerdo') > 0) {
                            var abono = AutoNumeric.getNumber('#abono_inicial_acuerdo');
                            if (total_acuerdo > 0) {
                                var valor_porcentaje_inicial_acuerdo = (100 * abono) / total_acuerdo;
                                AutoNumeric.set('#porcentaje_inicial_acuerdo', valor_porcentaje_inicial_acuerdo);
                            } else {
                                AutoNumeric.set('#porcentaje_inicial_acuerdo', 0);
                            }
                        }
                    }
                }
            } else {
                $('#total_acuerdo').attr('data-total', '0');
                $('#total_acuerdo').html(accounting.formatMoney(0, "$ ", 2, ".", ", "));
                AutoNumeric.set('#porcentaje_inicial_acuerdo', 0);
            }
        });
    }

    if($('#anio_inicial_acuerdo_edit').length) {
        $('#anio_inicial_acuerdo_edit').off('change').on('change', function() {
            if ($('#anio_inicial_acuerdo_edit').val().length > 0) {
                if(Number($('#anio_inicial_acuerdo_edit').val()) > Number($('#anio_final_acuerdo_edit').val())) {
                    $('#anio_final_acuerdo_edit').val('');
                } else {
                    if($('#anio_inicial_acuerdo_edit').val().length > 0 && $('#anio_final_acuerdo_edit').val().length > 0) {
                        var anios = global_anios.filter(el => parseInt(el.ultimo_anio) >= parseInt($('#anio_inicial_acuerdo_edit').val()) && parseInt(el.ultimo_anio) <= parseInt($('#anio_final_acuerdo_edit').val()));
                        var total_acuerdo = 0;
                        for (var anio of anios) {
                            total_acuerdo += Number(anio.total_calculo);
                        }
                        $('#total_acuerdo_edit').attr('data-total', total_acuerdo);
                        $('#total_acuerdo_edit').html(accounting.formatMoney(total_acuerdo - AutoNumeric.getNumber('#abono_inicial_acuerdo_edit'), "$ ", 2, ".", ", "));
                        if (AutoNumeric.getNumber('#abono_inicial_acuerdo_edit') > 0) {
                            var abono = AutoNumeric.getNumber('#abono_inicial_acuerdo_edit');
                            if (total_acuerdo > 0) {
                                var valor_porcentaje_inicial_acuerdo = (100 * abono) / total_acuerdo;
                                AutoNumeric.set('#porcentaje_inicial_acuerdo_edit', valor_porcentaje_inicial_acuerdo);
                            } else {
                                AutoNumeric.set('#porcentaje_inicial_acuerdo_edit', 0);
                            }
                        }
                    }
                }
            } else {
                $('#total_acuerdo_edit').attr('data-total', '0');
                $('#total_acuerdo_edit').html(accounting.formatMoney(0, "$ ", 2, ".", ", "));
                AutoNumeric.set('#porcentaje_inicial_acuerdo_edit', 0);
            }
        });
    }

    if($('#anio_final_acuerdo').length) {
        $('#anio_final_acuerdo').off('change').on('change', function() {
            if ($('#anio_final_acuerdo').val().length > 0) {
                if(Number($('#anio_final_acuerdo').val()) < Number($('#anio_inicial_acuerdo').val())) {
                    $('#anio_inicial_acuerdo').val('');
                } else {
                    if($('#anio_inicial_acuerdo').val().length > 0 && $('#anio_final_acuerdo').val().length > 0) {
                        var anios = global_anios.filter(el => parseInt(el.ultimo_anio) >= parseInt($('#anio_inicial_acuerdo').val()) && parseInt(el.ultimo_anio) <= parseInt($('#anio_final_acuerdo').val()));
                        var total_acuerdo = 0;
                        for (var anio of anios) {
                            total_acuerdo += Number(anio.total_calculo);
                        }
                        $('#total_acuerdo').attr('data-total', total_acuerdo);
                        $('#total_acuerdo').html(accounting.formatMoney(total_acuerdo - AutoNumeric.getNumber('#abono_inicial_acuerdo'), "$ ", 2, ".", ", "));
                        if (AutoNumeric.getNumber('#abono_inicial_acuerdo') > 0) {
                            var abono = AutoNumeric.getNumber('#abono_inicial_acuerdo');
                            if (total_acuerdo > 0) {
                                var valor_porcentaje_inicial_acuerdo = (100 * abono) / total_acuerdo;
                                AutoNumeric.set('#porcentaje_inicial_acuerdo', valor_porcentaje_inicial_acuerdo);
                            } else {
                                AutoNumeric.set('#porcentaje_inicial_acuerdo', 0);
                            }
                        }
                    }
                }
            } else {
                $('#total_acuerdo').attr('data-total', '0');
                $('#total_acuerdo').html(accounting.formatMoney(0, "$ ", 2, ".", ", "));
                AutoNumeric.set('#porcentaje_inicial_acuerdo', 0);
            }
        });
    }

    if($('#anio_final_acuerdo_edit').length) {
        $('#anio_final_acuerdo_edit').off('change').on('change', function() {
            if ($('#anio_final_acuerdo_edit').val().length > 0) {
                if(Number($('#anio_final_acuerdo_edit').val()) < Number($('#anio_inicial_acuerdo_edit').val())) {
                    $('#anio_inicial_acuerdo_edit').val('');
                } else {
                    if($('#anio_inicial_acuerdo_edit').val().length > 0 && $('#anio_final_acuerdo_edit').val().length > 0) {
                        var anios = global_anios.filter(el => parseInt(el.ultimo_anio) >= parseInt($('#anio_inicial_acuerdo_edit').val()) && parseInt(el.ultimo_anio) <= parseInt($('#anio_final_acuerdo_edit').val()));
                        var total_acuerdo = 0;
                        for (var anio of anios) {
                            total_acuerdo += Number(anio.total_calculo);
                        }
                        $('#total_acuerdo_edit').attr('data-total', total_acuerdo);
                        $('#total_acuerdo_edit').html(accounting.formatMoney(total_acuerdo - AutoNumeric.getNumber('#abono_inicial_acuerdo_edit'), "$ ", 2, ".", ", "));
                        if (AutoNumeric.getNumber('#abono_inicial_acuerdo_edit') > 0) {
                            var abono = AutoNumeric.getNumber('#abono_inicial_acuerdo_edit');
                            if (total_acuerdo > 0) {
                                var valor_porcentaje_inicial_acuerdo = (100 * abono) / total_acuerdo;
                                AutoNumeric.set('#porcentaje_inicial_acuerdo_edit', valor_porcentaje_inicial_acuerdo);
                            } else {
                                AutoNumeric.set('#porcentaje_inicial_acuerdo_edit', 0);
                            }
                        }
                    }
                }
            } else {
                $('#total_acuerdo_edit').attr('data-total', '0');
                $('#total_acuerdo_edit').html(accounting.formatMoney(0, "$ ", 2, ".", ", "));
                AutoNumeric.set('#porcentaje_inicial_acuerdo_edit', 0);
            }
        });
    }

    if ($('#abono_inicial_acuerdo').length) {
        $('#abono_inicial_acuerdo').off('change').on('change', function() {
            var abono = AutoNumeric.getNumber('#abono_inicial_acuerdo');
            if ($('#total_acuerdo').attr('data-total').length > 0 && $('#total_acuerdo').attr('data-total') !== '0') {
                var total_acuerdo = Number($('#total_acuerdo').attr('data-total'));
                var valor_porcentaje_inicial_acuerdo = (100 * abono) / total_acuerdo;
                var new_total = total_acuerdo - abono;
                $('#total_acuerdo').html(accounting.formatMoney(new_total, "$ ", 2, ".", ", "));
                AutoNumeric.set('#porcentaje_inicial_acuerdo', valor_porcentaje_inicial_acuerdo);
            } else {
                AutoNumeric.set('#porcentaje_inicial_acuerdo', 0);
            }
        });
    }

    if ($('#abono_inicial_acuerdo_edit').length) {
        $('#abono_inicial_acuerdo_edit').off('change').on('change', function() {
            var abono = AutoNumeric.getNumber('#abono_inicial_acuerdo_edit');
            if ($('#total_acuerdo_edit').attr('data-total').length > 0 && $('#total_acuerdo_edit').attr('data-total') !== '0') {
                var total_acuerdo_edit = Number($('#total_acuerdo_edit').attr('data-total'));
                var valor_porcentaje_inicial_acuerdo_edit = (100 * abono) / total_acuerdo_edit;
                var new_total = total_acuerdo_edit - abono;
                $('#total_acuerdo_edit').html(accounting.formatMoney(new_total, "$ ", 2, ".", ", "));
                AutoNumeric.set('#porcentaje_inicial_acuerdo_edit', valor_porcentaje_inicial_acuerdo_edit);
            } else {
                AutoNumeric.set('#porcentaje_inicial_acuerdo_edit', 0);
            }
        });
    }

    if ($('#btn_generar_factura_ap').length > 0) {
        $('#btn_generar_factura_ap').off('click').on('click', function(evt) {
            var btn = $(this);
            swal({
                title: "Atención",
                text: '¿Está seguro de que desea generar la factura para las cuotas de acuerdo de pago seleccionadas?',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si",
                cancelButtonText: "No",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {
                    downloadFacturaRowProcesar(btn);
                }
            });
        });
    }
});

function getJsonAcuerdos() {
    $.blockUI({ message: null });
    $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        url: "/list/acuerdos",
        success: function(response) {
            if (response.acuerdos !== undefined && response.acuerdos !== null) {
                if (response.acuerdos.length > 0) {
                    if (DTAcuerdos !== null) {
                        DTAcuerdos.clear().draw();
                        DTAcuerdos.rows.add(response.acuerdos).draw();
                    }
                } else {
                    DTAcuerdos.clear().draw();
                }
            } else {
                DTAcuerdos.clear().draw();
            }
            $.unblockUI();
        },
        error: function(xhr) {
            $.unblockUI();
            console.log(xhr.responseText);
        },
    });
}

// function saveEliminarAcuerdo(id_acuerdo) {
//     $.blockUI({
//         message: "Ejecutando operaci&oacute;n. Espere un momento.",
//         css: {
//             border: 'none',
//             padding: '15px',
//             backgroundColor: '#000',
//             '-webkit-border-radius': '10px',
//             '-moz-border-radius': '10px',
//             opacity: .5,
//             color: '#fff',
//             zIndex: 9999
//         }
//     });
//     var jsonObj = {};
//     jsonObj.id = id_acuerdo;
//     $.ajax({
//         type: 'POST',
//         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
//         dataType: 'json',
//         url: '/store/acuerdos_delete',
//         data: {
//             form: JSON.stringify(jsonObj)
//         },
//         success: function(response) {
//             if(!response.error) {
//                 if (response.acuerdos !== undefined && response.acuerdos !== null) {
//                     if (response.acuerdos.length > 0) {
//                         if (DTAcuerdos !== null) {
//                             DTAcuerdos.clear().draw();
//                             DTAcuerdos.rows.add(response.acuerdos).draw();
//                         }
//                     } else {
//                         DTAcuerdos.clear().draw();
//                     }
//                 } else {
//                     DTAcuerdos.clear().draw();
//                 }
//             }

//             swal({
//                 title: "Atención",
//                 text: response.message,
//                 type: "warning",
//                 confirmButtonColor: "#DD6B55",
//                 confirmButtonText: "Aceptar",
//                 closeOnConfirm: true
//             });

//             $.unblockUI();
//         },
//         error: function(xhr) {
//             console.log(xhr.responseText);
//             $.unblockUI();
//         }
//     });
// }

function cleanAcuerdos() {
    $('#load_resolucion').css('display', 'none');
    $('#valores_acuerdo').css('display', 'none');
    $('#no_acuerdo').css('display', 'none');
    $('#ya_acuerdo').css('display', 'none');
    $('#btn_save_create').attr('disabled', true);
}

function getJsonAcuerdoAnios(id_acuerdo, inicial, final) {
    var jsonObj = {};
    jsonObj.id_acuerdo = id_acuerdo;
    $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        url: "/list/acuerdo-anios",
        data: jsonObj,
        success: function(response) {
            console.log('Response received:', response);

            try {
                // Verificar que los elementos select existan
                var $anioInicial = $('#anio_inicial_acuerdo_edit');
                var $anioFinal = $('#anio_final_acuerdo_edit');

                if ($anioInicial.length === 0 || $anioFinal.length === 0) {
                    console.error('Select elements not found in DOM');
                    return;
                }

                // Usar setTimeout para asegurar que DOM esté listo
                setTimeout(function() {
                    if (response.anios !== undefined && response.anios !== null) {
                        if (response.anios.length > 0) {
                            console.log('Populating selects with server data, count:', response.anios.length);

                            $anioInicial.empty().append('<option value="">Seleccione</option>');
                            $anioFinal.empty().append('<option value="">Seleccione</option>');

                            $.each(response.anios, function(i, el) {
                                if (el && el.ultimo_anio) {
                                    var optionHtml = '<option value="' + el.ultimo_anio + '">' + el.ultimo_anio + '</option>';
                                    $anioInicial.append(optionHtml);
                                    $anioFinal.append(optionHtml);
                                }
                            });

                            // Establecer valores después de poblar
                            setTimeout(function() {
                                if (inicial) $anioInicial.val(inicial);
                                if (final) $anioFinal.val(final);
                            }, 50);

                        } else {
                            console.log('No server data available, using global_acuerdo data');
                            $anioInicial.empty();
                            $anioFinal.empty();

                            if (global_acuerdo && global_acuerdo.anio_inicial_acuerdo) {
                                $anioInicial.append('<option value="' + global_acuerdo.anio_inicial_acuerdo + '">' + global_acuerdo.anio_inicial_acuerdo + '</option>');
                                $anioInicial.val(global_acuerdo.anio_inicial_acuerdo);
                            }
                            if (global_acuerdo && global_acuerdo.anio_final_acuerdo) {
                                $anioFinal.append('<option value="' + global_acuerdo.anio_final_acuerdo + '">' + global_acuerdo.anio_final_acuerdo + '</option>');
                                $anioFinal.val(global_acuerdo.anio_final_acuerdo);
                            }
                        }
                    } else {
                        console.log('Response.anios is undefined or null, using global_acuerdo data');
                        $anioInicial.empty();
                        $anioFinal.empty();

                        if (global_acuerdo && global_acuerdo.anio_inicial_acuerdo) {
                            $anioInicial.append('<option value="' + global_acuerdo.anio_inicial_acuerdo + '">' + global_acuerdo.anio_inicial_acuerdo + '</option>');
                            $anioInicial.val(global_acuerdo.anio_inicial_acuerdo);
                        }
                        if (global_acuerdo && global_acuerdo.anio_final_acuerdo) {
                            $anioFinal.append('<option value="' + global_acuerdo.anio_final_acuerdo + '">' + global_acuerdo.anio_final_acuerdo + '</option>');
                            $anioFinal.val(global_acuerdo.anio_final_acuerdo);
                        }
                    }

                    // Forzar actualización del DOM y trigger change events
                    $anioInicial.trigger('change');
                    $anioFinal.trigger('change');

                    // Llamar getJsonAcuerdoDetalle después de actualizar los selects
                    setTimeout(function() {
                        getJsonAcuerdoDetalle(id_acuerdo);
                    }, 100);

                }, 10);

            } catch (error) {
                console.error('Error processing response:', error);
            }
        },
        error: function(xhr) {
            console.log('AJAX Error:', xhr.responseText);
        },
    });
}

function getJsonAcuerdoDetalle(id_acuerdo) {
    // Clear selected cuotas when loading new data
    selectedCuotasIds = [];
    selectedCuotasNumbers = [];
    selectedCuotasString = '';

    // Hide the label and button
    $('#lbl_total_seleccionado').css('opacity', '0');
    $('#btn_generar_factura_ap').css('opacity', '0');

    // $.blockUI({ message: null });
    var jsonObj = {};
    jsonObj.id_acuerdo = id_acuerdo;
    $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        url: "/list/acuerdo-detalle",
        data: jsonObj,
        success: function(response) {
            try {
                if (response.acuerdo_detalle !== undefined && response.acuerdo_detalle !== null) {
                    if (response.acuerdo_detalle.length > 0) {
                        DTAcuerdoDetalle.clear();
                        DTAcuerdoDetalle.rows.add(response.acuerdo_detalle);
                        DTAcuerdoDetalle.draw();

                        // Force column adjustment after data load
                        setTimeout(function() {
                            DTAcuerdoDetalle.columns.adjust();
                        }, 100);
                    } else {
                        DTAcuerdoDetalle.clear().draw();
                    }
                } else {
                    DTAcuerdoDetalle.clear().draw();
                }
            } catch (error) {
                console.error('Error updating modal DataTable:', error);
            }
            // $.unblockUI();
        },
        error: function(xhr) {
            // $.unblockUI();
            console.log('AJAX Error:', xhr.responseText);
        },
    });
}

function downloadFacturaRowProcesar(btn) {
    var url_download = $(btn).attr('url');
    var id_acuerdo = $(btn).attr('data-id');
    var tmp = 0;
    global_url_print = url_download;
    $(btn).attr('disabled', true);
    startImpresion(global_url_print + '/' + id_acuerdo + '/' + tmp + '/' + selectedCuotasString, 'Generación de factura cuota(s) acuerdo de pago. Espere un momento por favor.', 'success', '', getJsonAcuerdoAnios(global_acuerdo.id, global_acuerdo.anio_inicial_acuerdo, global_acuerdo.anio_final_acuerdo));
    $(btn).attr('disabled', false);
}

function downloadFacturaRowReprocesar(btn) {
    var url_download = $(btn).attr('url');
    global_url_print = url_download;
    $(btn).attr('disabled', true);
    startImpresion(global_url_print, 'Generación de factura cuota(s) acuerdo de pago. Espere un momento por favor.', 'success', '', getJsonAcuerdoAnios(global_acuerdo.id, global_acuerdo.anio_inicial_acuerdo, global_acuerdo.anio_final_acuerdo));
    $(btn).attr('disabled', false);
}
