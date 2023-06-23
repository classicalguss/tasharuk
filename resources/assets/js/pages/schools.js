'use strict';

$(function () {
    // Variable declaration for table
    const
        dt_school_table = $('.datatables-items'),
        schoolView = baseUrl + 'app/school/view/account',
        userView = baseUrl + 'app/user/view/account';

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
    if (dt_school_table.length) {
        var dt_school = dt_school_table.DataTable({
            initComplete: function () {
                toolTipTrigger()
            },
            processing: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            ajax: {
                url: baseUrl + 'resource/schools'
            },
            columns: [
                // columns according to JSON
                {data: 'name'},
                {data: 'owner'},
                {data: 'admins'},
            ],
            columnDefs: [
                {
                    // User full name
                    targets: 1,
                    render: function (data, type, full, meta) {
                        // Creates full output for row
                        return '<div class="d-flex justify-content-start align-items-center">' +
                            '<div class="avatar-wrapper">' +
                            '<div class="avatar avatar-sm me-3">' +
                            avatar(data) +
                            '</div>' +
                            '</div>' +
                            '<div class="d-flex flex-column">' +
                            '<a href="' +
                            userView +
                            '" class="text-body text-truncate"><span class="fw-semibold">' +
                            data.name +
                            '</span></a>' +
                            '</div>' +
                            '</div>';
                    }
                },
                {
                    //Admins
                    targets: 2,
                    render: function (data, type, full, meta) {
                        console.log(data);
                        let output = '<ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">\n'
                        data.forEach(user => {
                            output += '' +
                                '<li ' +
                                '   data-bs-toggle="tooltip"' +
                                '   data-popup="tooltip-custom" ' +
                                '   data-bs-placement="top"' +
                                '   class="avatar avatar-xs pull-up" ' +
                                '   aria-label="'+user.name+'"' +
                                '   data-bs-original-title="'+user.name+'"' +
                                '>\n' +
                                '   '+avatar(user)+
                                '</li>\n';
                        })
                        output += '</ul>'
                        return output;
                    }
                }
            ],
            language: {
                sLengthMenu: '_MENU_',
                search: '',
                searchPlaceholder: 'Search..'
            },
        });
    }
});