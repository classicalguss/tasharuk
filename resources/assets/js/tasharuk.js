function deleteRecord(el) {
    let url = setResourceURL(el);
    axios({
        method: 'delete',
        url: url
    }).then(function() {
        location.reload();
    })
}

function setUpdateModal() {
    $('#updateModal').on('show.bs.modal', function(e) {
        //get data-id attribute of the clicked element
        var name = $(e.relatedTarget).data('name');
        var id = $(e.relatedTarget).data('id');

        //populate the textbox
        $(e.currentTarget).find('input[name="name"]').val(name);
        $(e.currentTarget).find('form').attr('action', $(e.currentTarget).find('form').attr('action')+`/${id}` )
    });
}
