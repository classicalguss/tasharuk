'use strict';

$(function () {
    // Variable declaration for table
    const
        dt_user_table = $('.datatables-items'),
        userView = baseUrl + 'users/';

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
                url: baseUrl + 'users'
            },
            columns: [
                // columns according to JSON
                {data: 'name'},
                {data: 'school'},
                {data: 'roles_all'},
                {data: 'is_active'}
            ],
            columnDefs: [
                {
                    // User full name
                    targets: 0,
                    render: function (data, type, full, meta) {
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
                        if (full.school)
                            return full.school.name;
                        return "";
                    }
                },
                {
                    //Role
                    targets: 2,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        if (full.roles_all && full.roles_all[0])
                            return full.roles_all[0].name
                        return "";
                    }
                },
                {
                    // is active
                    targets: 3,
                    orderable: false,
                    className: 'text-center',
                    render: function (data, type, full, meta) {
                        var $isActive = full['is_active'];
                        return `${
                            $isActive
                                ? '<i class="bx fs-4 bx-check-circle text-success"></i>'
                                : '<i class="bx fs-4 bx-x-circle text-danger" ></i>'
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