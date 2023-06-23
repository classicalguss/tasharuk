'use strict';

// Variable declaration for table
function prepareDataTable() {

    $.extend($.fn.dataTableExt.oStdClasses, {
        "sFilterInput": "form-control",
        "sLengthSelect": "form-control"
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}

function textAreaAdjust(element) {
    element.style.height = "1px";
    element.style.height = (25+element.scrollHeight)+"px";
}

let editingIndicator = false;
let currentValue = "";
let currentEditableDiv = "";
function renderIndicator(data, type, full) {
    let mutedText = "";
    let indicatorWrapperClass = "";
    if (type == "text")
        indicatorWrapperClass = `class="indicator-wrapper"`;
    return `<div ${indicatorWrapperClass} data-visible=${full.is_visible} data-column="${type}" data-id=${full.id}>${data}</div>`
}

function fetchIndicators(subcapabilityId) {

    const dt_capability_table = $('.datatables-items');
    const capabilityView = baseUrl + 'capabilities/%/subcapabilities';

    if (dt_capability_table.length) {
        let table = dt_capability_table.DataTable({
            initComplete: function () {
                setEditable();
            },
            "createdRow": function( row, data, dataIndex ) {
                if (!data.is_visible) {
                    $(row).addClass('text-muted');
                }
            },
            paging: false,
            info: false,
            processing: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            searching: false,
            ordering: false,
            ajax: {
                url: baseUrl + 'resource/subcapabilities/'+subcapabilityId+'/indicators?stakeholder_id='+stakeholderId
            },
            columns: [
                // columns according to JSON
                {
                    data: 'text',
                    className: "highlight indicator",
                    render: function (data, type, full, meta) { return renderIndicator(data, 'text', full); }
                },
                {
                    data: 'highly_effective',
                    render: function (data, type, full, meta) { return renderIndicator(data, 'highly_effective', full); }
                },
                {
                    data: 'effective',
                    render: function (data, type, full, meta) { return renderIndicator(data, 'effective', full); }
                },
                {
                    data: 'satisfactory',
                    render: function (data, type, full, meta) { return renderIndicator(data, 'satisfactory', full); }
                },
                {
                    data: 'needs_improvement',
                    render: function (data, type, full, meta) { return renderIndicator(data, 'needs_improvement', full); }
                },
                {
                    data: 'does_not_meet_standard',
                    render: function (data, type, full, meta) { return renderIndicator(data, 'does_not_meet_standard', full); }
                },
            ],
            language: {
                sLengthMenu: '_MENU_',
                search: '',
                searchPlaceholder: 'Search..'
            },
        });

        $('.datatables-items tbody').on( 'click', 'td', function () {
            if (!editingIndicator) {
                currentEditableDiv = $(this).find('div');
                currentValue = currentEditableDiv.html();
                currentEditableDiv.html($('.cell-actions-wrapper').clone(true).html());

                let textAreaEl = $(currentEditableDiv).children('textarea');
                textAreaEl.val(currentValue);
                textAreaEl.css('height', textAreaEl.prop("scrollHeight")+"px");
                setNonEditable();

                if (this.classList.contains('indicator')) {
                    $('.indicator-action').show();
                } else {
                    $('.indicator-action').hide();
                }
                let visibilityButton = $('.indicator-visibility-action');
                if (currentEditableDiv.attr('data-visible') == 1) {
                    visibilityButton.children('i').removeClass('bx-show-alt');
                    visibilityButton.children('i').addClass('bx-hide');
                } else {
                    visibilityButton.children('i').addClass('bx-show-alt');
                    visibilityButton.children('i').removeClass('bx-hide');
                }
                visibilityButton.attr('data-subcapability-id', subcapabilityId);
                visibilityButton.attr('data-type', 'indicator');
                visibilityButton.attr('data-id', currentEditableDiv.attr('data-id'));
                visibilityButton.attr('data-visible', currentEditableDiv.attr('data-visible'));

                let deleteButton = $('.delete-record');
                deleteButton.attr('data-subcapability-id', subcapabilityId);
                deleteButton.attr('data-id', currentEditableDiv.attr('data-id'));
                deleteButton.attr('data-type', 'indicator');
            }
        });
    }
}

function textareaAutoAdjust(element) {
    element.style.height = "5px";
    element.style.height = (element.scrollHeight)+"px";
}

function saveIndicator(element, subcapabilityId) {
    currentValue = $(element).parent().parent().find('textarea').val();
    currentEditableDiv.html(currentValue);
    resetToEditable();
    let data = {};
    data[currentEditableDiv.data('column')] = currentValue;
    if (stakeholderId)
        data['stakeholder_id'] = stakeholderId;

    axios({
        method: 'put',
        url: '/resource/subcapabilities/'+subcapabilityId+'/indicators/'+currentEditableDiv.data('id'),
        data: data
    });
}

function setNonEditable() {
    editingIndicator = true;
    $('.datatables-items td').css('cursor', 'default');
}

function resetToEditable() {
    currentEditableDiv.html(currentValue);
    editingIndicator = false;
    setEditable();
}

function setEditable() {
    $('.datatables-items td').css('cursor', 'pointer');
}

function fetchSubcapabilities(capabilityId) {

    const dt_capability_table = $('.datatables-items');
    let subcapabilityView = baseUrl + 'subcapabilities/{subcapability}/indicators'
    if (stakeholderId)
        subcapabilityView += '?stakeholder_id='+stakeholderId;
    const indexUrl = baseUrl + "resource/capabilities/{capability}/subcapabilities".replace("{capability}", capabilityId);

    if (dt_capability_table.length) {
        dt_capability_table.DataTable({
            initComplete: function () {
                activateSliders();
            },
            paging: false,
            info: false,
            processing: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            searching: false,
            ajax: {
                url: indexUrl+'?stakeholder_id='+stakeholderId,
            },
            columns: [
                // columns according to JSON
                {data: 'name'},
                {data: 'weight'},
                {data: null},
            ],
            columnDefs: [
                {
                    target: 0,
                    width: "25%",
                    render: function (data, type, full, meta) {
                        return '<a href="' +
                            subcapabilityView.replace('{subcapability}',full['id']) +
                            '" class="text-body text-truncate"><span class="fw-semibold">' +
                            data +
                            '</span></a>';
                    }
                },
                {
                    target: 1,
                    render: function (data, type, full, meta) {
                        let slider = document.getElementById('slider-wrapper').cloneNode(true);
                        slider.classList.remove('hide');
                        let children = slider.children;
                        children[0].dataset.weight = data;
                        children[0].dataset.reference = full.id;
                        return slider.outerHTML;
                    }
                },
                {
                    // Actions
                    targets: 2,
                    width: "10%",
                    title: 'Actions',
                    render: function (data, type, full, meta) {
                        return renderActions(data, 'subcapability', full);
                    }
                }
            ],
            order: [[1, 'desc']],
            language: {
                sLengthMenu: '_MENU_',
            },
        });
    }
}

function renderActions(data, type, full) {
    let visibilityIcon = full['is_visible'] ? 'bx-show' : 'bx-hide';
    let dataCapabilityId=""
    if (type == "subcapability")
        dataCapabilityId=`data-capability-id="${full['capability_id']}"`;
    let actions = (
        '<div class="d-inline-block text-nowrap">' +
        `<button title="Edit" class="btn btn-sm btn-icon edit-record" data-id="${full['id']}" data-bs-toggle="modal" data-bs-target="#updateModal" data-name="${full['name']}"><i class="bx bx-edit"></i></button>` +
        `<button ${dataCapabilityId} data-type="${type}" data-id=${full['id']} data-visible=${full['is_visible']} onclick="toggleVisibility(this)" title="Toggle visibility" class="btn btn-sm btn-icon">` +
        `<i class="bx ${visibilityIcon}"></i></button>`
    );
    if (!stakeholderId) {
       actions += `<button ${dataCapabilityId} data-type="${type}" title="Delete" class="btn btn-sm btn-icon delete-record" onclick="deleteRecord(this)" data-id="${full['id']}"><i class="bx bx-trash"></i></button>`
    }
    actions += (
        '</div>'
    );
    return actions;
}

function fetchCapabilities() {

    const dt_capability_table = $('.datatables-items');
    let capabilityView = baseUrl + 'capabilities/%/subcapabilities';
    if (stakeholderId)
        capabilityView += '?stakeholder_id='+stakeholderId;

    if (dt_capability_table.length) {
        dt_capability_table.DataTable({
            initComplete: function () {
                activateSliders();
            },
            paging: false,
            info: false,
            processing: true,
            serverSide: true,
            responsive: true,
            fixedColumns: true,
            searching: false,
            ordering: false,
            ajax: {
                url: baseUrl + 'resource/capabilities?stakeholder_id='+stakeholderId,
            },
            columns: [
                // columns according to JSON
                {data: 'name'},
                {data: 'weight'},
                {data: null}
            ],
            columnDefs: [
                {
                    target: 0,
                    width: "25%",
                    render: function (data, type, full, meta) {
                        return '<a href="' +
                            capabilityView.replace('%',full['id']) +
                            '" class="text-body text-truncate"><span class="fw-semibold">' +
                            data +
                            '</span></a>';
                    }
                },
                {
                    target: 1,
                    render: function (data, type, full, meta) {
                        let slider = document.getElementById('slider-wrapper').cloneNode(true);
                        slider.classList.remove('hide');
                        let children = slider.children;
                        children[0].dataset.weight = data;
                        children[0].dataset.reference = full.id;
                        return slider.outerHTML;
                    }
                },
                {
                    // Actions
                    targets: 2,
                    width: "10%",
                    title: 'Actions',
                    render: function (data, type, full, meta) {
                        console.log(full);
                        return renderActions(data, 'capability', full);
                    }
                }
            ],
            order: [[1, 'desc']],
            language: {
                sLengthMenu: '_MENU_',
                search: '',
                searchPlaceholder: 'Search..'
            },
        });
    }
}

let weightsButtonShown = false;
function showWeightsButton() {
    let weightsButton = $('#updateWeightsButton');
    if (!weightsButtonShown) {
        weightsButton.removeClass('d-none');
    }
    weightsButton.prop('disabled', currentSum < 100);
    weightsButtonShown = true;
}

function updateWeights(modelType) {
    let payloadArray = {};
    for (let i = 0; i < allSliders.length; i++) {
        payloadArray[parseInt(allSliders[i].dataset.reference)] = parseInt(allSliders[i].dataset.weight);
    }
    let url;
    if (modelType === 'capabilities') {
        url = `/resource/capabilities/updateWeights`
    } else {
        url = `/resource/subcapabilities/updateWeights`
    }
    axios({
        method: 'post',
        url: url,
        data: {
            weights: payloadArray,
            stakeholder_id: stakeholderId
        }
    }).then(function() {
        let weightsButton = $('#updateWeightsButton');
        weightsButton.addClass('d-none');
        weightsButtonShown = false;
    });
}

function setResourceURL(el) {
    let type = el.dataset['type'];
    if (type === 'capability')
        return `/resource/capabilities/${el.dataset['id']}`
    else if (type === 'subcapability')
        return `/resource/capabilities/${el.dataset['capabilityId']}/subcapabilities/${el.dataset['id']}`
    else
        return `/resource/subcapabilities/${el.dataset['subcapabilityId']}/indicators/${el.dataset['id']}`
}

function toggleVisibility(el) {
    el.dataset.visible = el.dataset.visible == 1 ? 0 : 1;
    let url = setResourceURL(el);
    let type = el.dataset['type'];
    if (type == 'indicator') {
        if (el.dataset.visible == 1) {
            $(el).parents('tr').removeClass('text-muted');
            $(el).parents('.indicator-wrapper').attr('data-visible', el.dataset.visible);
        }
        else {
            $(el).parents('tr').addClass('text-muted');
            $(el).parents('.indicator-wrapper').attr('data-visible',el.dataset.visible);
        }
    }
    axios({
        method: 'put',
        url: url,
        data: {
            is_visible:  Boolean(parseInt(el.dataset.visible)),
            stakeholder_id: stakeholderId
        }
    })
    let currentIcon = $(el).find('i');
    if (currentIcon.hasClass('bx-show')) {
        currentIcon.removeClass('bx-show');
        currentIcon.addClass('bx-hide');
    } else {
        currentIcon.removeClass('bx-hide');
        currentIcon.addClass('bx-show');
    }
}

let allSliders = [];
let currentSum = 0;
function activateSliders() {
    let sliders = document.getElementsByClassName('slider-dynamic');

    for (let i = 0; i < sliders.length; i++) {
        //Calculating the current sum to know how much should the range be
        let weight = sliders[i].dataset.weight;
        if (weight)
            currentSum += parseInt(sliders[i].dataset.weight);
    }
    for (let i = 0; i < sliders.length; i++) {
        let dynamicSlider = sliders[i];
        let weight = dynamicSlider.dataset.weight;
        if (weight) {
            noUiSlider.cssClasses.target = currentSum == 100 ? 'success' : 'target'
            noUiSlider.create(dynamicSlider, {
                start: dynamicSlider.dataset.weight,
                connect: [true, false],
                direction: isRtl ? 'rtl' : 'ltr',
                step: 1,
                // padding: [0, 40],
                range: {
                    min: 0,
                    max: parseInt(dynamicSlider.dataset.weight) + (100 - currentSum)
                },
                tooltips: true,
            });

            dynamicSlider.noUiSlider.on('change', function (values, handle) {
                //Confirm by putting it in the dataset
                let oldWeight = dynamicSlider.dataset.weight;
                let newWeight = values[0];
                let difference = newWeight - oldWeight;
                currentSum += difference;

                showWeightsButton();
                if (currentSum > 100) {
                    dynamicSlider.noUiSlider.set(dynamicSlider.dataset.weight);
                }
                else {
                    dynamicSlider.dataset.weight = values[0];
                }
                for (let i = 0; i < allSliders.length; i++) {
                    allSliders[i].noUiSlider.updateOptions({
                        range: {
                            min: 0,
                            max: parseInt(allSliders[i].dataset.weight) + (100 - currentSum)
                        }
                    })
                    if (currentSum === 100) {
                        allSliders[i].classList.remove('noUi-target');
                        allSliders[i].classList.add('noUi-success');
                    } else {
                        allSliders[i].classList.remove('noUi-success');
                        allSliders[i].classList.add('noUi-target');
                    }
                }
            });
            allSliders.push(dynamicSlider);
        }
    }
}