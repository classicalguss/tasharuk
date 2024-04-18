function deleteRecord(el) {
    let url = setResourceURL(el);
    axios({
        method: 'delete',
        url: url
    }).then(function() {
        location.reload();
    })
}

globalTarget;
function setUpdateModal() {
    $('#updateModal').on('show.bs.modal', function(e) {
        //get data-id attribute of the clicked element
        var name = $(e.relatedTarget).data('name');
        var id = $(e.relatedTarget).data('id');
        console.log("focusing >>>");

        globalTarget = e;

        $(this).find('input[type=text]').focus();
        $(e.currentTarget).find('input[type=text]').focus();
        //populate the textbox
        if (name) {
            $(e.currentTarget).find('input[name="name"]').val(name);
            $(e.currentTarget).find('input[name="name"]').focus();
        }
        if (id)
            $(e.currentTarget).find('form').attr('action', $(e.currentTarget).find('form').attr('action')+`/${id}` )
    });
}

function initSchoolSelect(el)
{
    el.on('change', function() {
        var url = new URL(window.location);
        url.searchParams.delete('school_id');
        if ($(this).val() !== "0") {
            url.searchParams.append('school_id', $(this).val());
        }
        window.location = url;
        return false;
    })
}
function initStakeholdersSelect(el)
{
    el.on('change', function() {
        var url = new URL(window.location);
        url.searchParams.delete('stakeholder_id');
        if ($(this).val() != "0") {
            url.searchParams.append('stakeholder_id', $(this).val());
        }
        window.location = url;
        return false;
    })
}
