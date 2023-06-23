'use strict';

$(function () {
    // Variable declaration for table
    const
        dt_user_table = $('.datatables-items'),
        userView = baseUrl + 'resource/users/';

    $.extend($.fn.dataTableExt.oStdClasses, {
        "sFilterInput": "form-control",
        "sLengthSelect": "form-control"
    });
    // ajax setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // ajax setup
    if (dt_user_table.length) {
        var dt_user = dt_user_table.DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            ajax: {
                url: baseUrl + 'resource/users'
            },
            columns: [
                // columns according to JSON
                {data: 'name'},
                {data: 'school'},
                {data: 'roles_all'},
                {data: 'email_verified_at'}
            ],
            columnDefs: [
                {
                    // User full name
                    targets: 0,
                    render: function (data, type, full, meta) {
                        console.log("hmmm");
                        // Creates full output for row
                        return '<div class="d-flex justify-content-start align-items-center">' +
                            '<div class="avatar-wrapper">' +
                            '<div class="avatar avatar-sm me-3">' +
                            avatar(full) +
                            '</div>' +
                            '</div>' +
                            '<div class="d-flex flex-column">' +
                            '<a href="' +
                            userView + full['id'] +
                            '" class="text-body text-truncate"><span class="fw-semibold">' +
                            full['name'] +
                            '</span></a>' +
                            '<small class="text-muted">'+full['email']+'</small>' +
                            '</div>' +
                            '</div>';
                    }
                },
                {
                    //School
                    targets: 1,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return full.school.name;
                    }
                },
                {
                    //Role
                    targets: 2,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return full.roles_all[0].name
                    }
                },
                {
                    // email verify
                    targets: 3,
                    orderable: false,
                    className: 'text-center',
                    render: function (data, type, full, meta) {
                        var $verified = full['email_verified_at'];
                        return `${
                            $verified
                                ? '<i class="bx fs-4 bx-check-shield text-success"></i>'
                                : '<i class="bx fs-4 bx-shield-x text-danger" ></i>'
                        }`;
                    }
                },
            ],
            order: [],
            language: {
                sLengthMenu: '_MENU_',
                search: '',
                searchPlaceholder: 'Search..'
            },
        });
    }
});