$(document).ready(function () {
    // jQuery code to initialize the range slider
    var rangeSlider = $('.meta-slider')[0];
    var inputMin = $('.sf-range-min');
    var inputMax = $('.sf-range-max');

    noUiSlider.create(rangeSlider, {
        start: [0, 10000],
        connect: true,
        range: {
            'min': 0,
            'max': 10000
        }
    });

    rangeSlider.noUiSlider.on('update', function (values, handle) {
        var value = values[handle];
        if (handle) {
            inputMax.val(value);
        } else {
            inputMin.val(value);
        }
    });

    inputMin.on('change', function () {
        rangeSlider.noUiSlider.set([this.value, null]);
    });

    inputMax.on('change', function () {
        rangeSlider.noUiSlider.set([null, this.value]);
    });

    const priceSlider = document.querySelector('.meta-slider');

    noUiSlider.create(priceSlider, {
        start: [0, 10000],
        connect: true,
        range: {
            'min': 0,
            'max': 10000
        }
});