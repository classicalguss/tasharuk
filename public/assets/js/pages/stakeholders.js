'use strict';

$(function () {
    // Variable declaration for table
    const
        dt_user_table = $('.datatables-items'),
        userView = baseUrl + 'resource/stakeholders/';

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
            paging: false,
            info: false,
            processing: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            searching: false,
            ajax: {
                url: baseUrl + 'resource/stakeholders'
            },
            columns: [
                // columns according to JSON
                {data: 'name'},
                {data: null},
            ],
            columnDefs: [
                {
                    // Actions
                    targets: 1,
                    width: "10%",
                    title: 'Actions',
                    render: function (data, type, full, meta) {
                        return renderActions(data,  full);
                    }
                }
            ],
            ordering: false,
            order: [],
            language: {
                sLengthMenu: '_MENU_',
                search: '',
                searchPlaceholder: 'Search..'
            },
        });
    }
});

function renderActions(data, full) {
    return (
        '<div class="d-inline-block text-nowrap">' +
        `<button title="Edit" class="btn btn-sm btn-icon edit-record" data-id="${full['id']}" data-bs-toggle="modal" data-bs-target="#updateModal" data-name="${full['name']}"><i class="bx bx-edit"></i></button>` +
        `<button title="Delete" class="btn btn-sm btn-icon delete-record" onclick="deleteRecord(this)" data-id="${full['id']}"><i class="bx bx-trash"></i></button>` +
        `<a href="/capabilities?stakeholder_id=${full['id']}" title="Override Capabilities" class="btn btn-sm btn-icon delete-record"><i class="bx bx-color"></i></a>` +
        '</div>'
    );
}

function setResourceURL(el) {
    return `/resource/stakeholders/${el.dataset['id']}`
}