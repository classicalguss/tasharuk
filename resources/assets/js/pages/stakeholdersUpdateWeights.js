function fetchWeights (schoolId) {
    const dt_stakeholder_weights_table = $('.datatables-items');

    if (dt_stakeholder_weights_table.length) {
        dt_stakeholder_weights_table.DataTable({
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
                url: baseUrl + 'schools/'+schoolId+'/update-stakeholder-weights'
            },
            columns: [
                // columns according to JSON
                {data: 'name'},
                {data: 'weight'},
            ],
            columnDefs: [
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
function updateWeights() {
    let payloadArray = {};
    for (let i = 0; i < allSliders.length; i++) {
        payloadArray[parseInt(allSliders[i].dataset.reference)] = parseInt(allSliders[i].dataset.weight);
    }
    let url = '/schools/'+schoolId+'/store-stakeholderufw status-weights'
    axios({
        method: 'post',
        url: url,
        data: {
            weights: payloadArray,
            school_id: schoolId
        }
    }).then(function() {
        let weightsButton = $('#updateWeightsButton');
        weightsButton.addClass('d-none');
        weightsButtonShown = false;
    });
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
