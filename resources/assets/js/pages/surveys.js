function prepareSurveysTable() {
// Variable declaration for table
    const surveys_table = $('.datatables-items');

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
    if (surveys_table.length) {
        var dt_survey = surveys_table.DataTable({
            processing: false,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            ajax: {
                url: baseUrl + 'resource/surveys'
            },
            columns: [
                // columns according to JSON
                {data: 'receiver_email'},
                {data: 'stakeholder', render: function (data, type, full) {
                        return data.name;
                    }},
                {data: 'school', render: function (data, type, full) {
                        return data.name;
                    }},
                {data: 'status'},
                {data: 'created_at'},
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
}

function tagifyUsersList() {

    var input = document.querySelector('#mailing-list-input'),
        tagify = new Tagify(input, {
            // email address validation (https://stackoverflow.com/a/46181/104380)
            delimiters: ',| ',
        });
    tagify.settings.pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    tagify.settings.trim = false
}

$(".tagify").bind('paste', function(e) {
    var elem = $(this);

    setTimeout(function() {
        // gets the copied text after a specified time (100 milliseconds)
        var text = elem.val();
        console.log("The text is");
    }, 100);
});
