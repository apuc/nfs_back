'use strict';

let fv, offCanvasEl;
document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        const formRecord = document.getElementById('record');

        setTimeout(() => {
            const newRecord = document.querySelector('.create-new'),
                editRecord = document.querySelector('.edit-record'),
                offCanvasElement = document.querySelector('#record'),
                dialogTitle = document.querySelector('#modalTitle');

            // To open offCanvas, to add new record
            if (newRecord) {
                newRecord.addEventListener('click', function () {
                    dialogTitle.innerText = 'Создать ТСП';
                    offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);
                    offCanvasEl.show();
                });
            }

            // To open offCanvas, to add new record
            if (editRecord) {
                editRecord.addEventListener('click', function () {
                    dialogTitle.innerText = 'Редактировать ТСП';
                    const record = makeRequest('/api/catalog/partner/view?identifier=' + $(this).data('id'), 'GET');



                    offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);
                    offCanvasEl.show();
                });
            }
        }, 200);

        // Form validation for Add new record
        fv = FormValidation.formValidation(formRecord, {
            fields: {
                partner_name: {
                    validators: {
                        notEmpty: {
                            message: 'Обязательное поле'
                        }
                    }
                },
                partner_occupation: {
                    validators: {
                        notEmpty: {
                            message: 'Обязательное поле'
                        }
                    }
                },
                partner_contacts_email: {
                    validators: {
                        emailAddress: {
                            message: 'Неверный формат'
                        }
                    }
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    // Use this for enabling/changing valid/invalid class
                    // eleInvalidClass: '',
                    eleValidClass: '',
                    rowSelector: '.col-sm-12'
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                autoFocus: new FormValidation.plugins.AutoFocus()
            },
            init: instance => {
                instance.on('plugins.message.placed', function (e) {
                    if (e.element.parentElement.classList.contains('input-group')) {
                        e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                    }
                });
            }
        });
    })();
});

$(function () {
    var dt_basic_table = $('.datatables-basic'),
        dt_basic;
    if (dt_basic_table.length) {
        dt_basic = dt_basic_table.DataTable({
            ajax: '/api/catalog/partner/list',
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'occupation'},
                {data: 'details'},
                {data: 'contacts'},
            ],
            columnDefs: [
                {
                    targets: 5,
                    title: 'Actions',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, full, meta) {
                        return (
                            '<a href="javascript:;" class="btn btn-sm btn-text-secondary rounded-pill btn-icon edit-record" data-id="' + full.id + '"><i class="mdi mdi-square-edit-outline"></i></a>' +
                            '<a href="javascript:;" class="btn btn-sm btn-text-secondary rounded-pill btn-icon text-danger delete-record" data-id="' + full.id + '"><i class="mdi mdi-trash-can-outline"></i></a>'
                        );
                    }
                },
                {
                    // Label
                    targets: 3,
                    render: function (data, type, full, meta) {
                        return (
                            '<b>Банк: </b> ' + full.details.bank + ', ' +
                            '<b>ИНН: </b> ' + full.details.inn + ', ' +
                            '<b>КПП: </b> ' + full.details.kpp + ', ' +
                            '<b>ОГРН: </b> ' + full.details.ogrn + ', ' +
                            '<b>БИК: </b> ' + full.details.bik + ', ' +
                            '<b>Счет: </b> ' + full.details.account_number + ', ' +
                            '<b>Корр. счет: </b> ' + full.details.corr_account_number + ', ' +
                            '<b>Адрес: </b> ' + full.details.address
                        );
                    }
                },
                {
                    // Label
                    targets: 4,
                    render: function (data, type, full, meta) {
                        return (
                            '<b>Телефон: </b> ' + full.contacts.phone_number + ', ' +
                            '<b>Почта: </b> ' + full.contacts.email
                        );
                    }
                },
            ],
            order: [[1, 'desc']],
            language: {
                url: '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json'
            },
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 10,
            lengthMenu: [10, 25, 50, 75, 100],
            buttons: [
                {
                    extend: 'collection',
                    className: 'btn btn-label-primary dropdown-toggle me-2',
                    text: '<i class="mdi mdi-export-variant me-sm-1"></i> <span class="d-none d-sm-inline-block">Экспорт</span>',
                    buttons: [
                        {
                            extend: 'print',
                            text: '<i class="mdi mdi-printer-outline me-1" ></i>Print',
                            className: 'dropdown-item',
                            exportOptions: {
                                // prevent avatar to be display
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            },
                        },
                        {
                            extend: 'csv',
                            text: '<i class="mdi mdi-file-document-outline me-1" ></i>Csv',
                            className: 'dropdown-item',
                            exportOptions: {
                                // prevent avatar to be display
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'excel',
                            text: '<i class="mdi mdi-file-excel-outline me-1"></i>Excel',
                            className: 'dropdown-item',
                            exportOptions: {
                                // prevent avatar to be display
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="mdi mdi-file-pdf-box me-1"></i>Pdf',
                            className: 'dropdown-item',
                            exportOptions: {
                                // prevent avatar to be display
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'copy',
                            text: '<i class="mdi mdi-content-copy me-1" ></i>Copy',
                            className: 'dropdown-item',
                            exportOptions: {
                                // prevent avatar to be display
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        }
                    ]
                },
                {
                    text: '<i class="mdi mdi-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Добавить ТСП</span>',
                    className: 'create-new btn btn-primary'
                }
            ],
        });
    }

    // Add New record
    // ? Remove/Update this code as per your requirements
    var count = 101;
    // On form submit, if form is valid
    fv.on('core.form.valid', function () {
        var $new_name = $('.add-new-record .dt-full-name').val(),
            $new_post = $('.add-new-record .dt-post').val(),
            $new_email = $('.add-new-record .dt-email').val(),
            $new_date = $('.add-new-record .dt-date').val(),
            $new_salary = $('.add-new-record .dt-salary').val();

        if ($new_name != '') {
            dt_basic.row
                .add({
                    id: count,
                    full_name: $new_name,
                    post: $new_post,
                    email: $new_email,
                    start_date: $new_date,
                    salary: '$' + $new_salary,
                    status: 5
                })
                .draw();
            count++;

            // Hide offcanvas using javascript method
            offCanvasEl.hide();
        }
    });

    $('.datatables-basic tbody').on('click', '.delete-record', function () {
        dt_basic.row($(this).parents('tr')).remove().draw();

        makeRequest('/api/catalog/partner/delete?identifier=' + $(this).data('id'), 'DELETE')
    });
});

async function makeRequest(url, method) {
    const response = await fetch(
        url,
        {
            method: method,
            headers: {
                "Content-Type": "application/json",
            },
        });

    return await response.json();
}
