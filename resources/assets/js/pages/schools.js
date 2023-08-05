'use strict';

$(function () {
    // Variable declaration for table
    const
        dt_school_table = $('.datatables-items'),
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
                url: baseUrl + 'schools'
            },
            columns: [
                // columns according to JSON
                {data: 'name'},
                {data: 'owner'},
                {data: 'admins'},
                {data: null},
            ],
            columnDefs: [
                {
                    // User full name
                    targets: 1,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        // Creates full output for row
                        if (!data)
                            return "";

                        return '<div class="d-flex justify-content-start align-items-center">' +
                            '<div class="avatar-wrapper">' +
                            '<div class="avatar avatar-sm me-3">' +
                            avatar(data) +
                            '</div>' +
                            '</div>' +
                            '<div class="d-flex flex-column">' +
                            '<a href="' +
                            userView + data.id +
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
                    orderable: false,
                    render: function (data, type, full, meta) {
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
                },
                {
                    // Actions
                    targets: 3,
                    width: "10%",
                    title: 'Actions',
                    render: function (data, type, full, meta) {
                        return renderActions(full);
                    }
                }
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

function renderActions(school) {
    return (
        '<div class="d-inline-block text-nowrap">' +
        `<button title="Edit" class="btn btn-sm btn-icon edit-record" data-id="${school.id}" data-bs-toggle="modal" data-bs-target="#updateModal" data-name="${school.name}"><i class="bx bx-edit"></i></button>` +
        `<button data-id="${school.id}" title="Delete" class="btn btn-sm btn-icon delete-record" onclick="deleteRecord(this)"><i class="bx bx-trash"></i></button>` +
        `<a href="schools/${school.id}/report" title="Report" class="btn btn-sm btn-icon generate-report"><i class="bx bxs-report"></i></ah>` +
        '</div>'
    );
}

function setResourceURL(el) {
    return `/schools/${el.dataset['id']}`
}
