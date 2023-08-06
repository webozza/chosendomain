jQuery(document).ready(function ($) {
  // jQuery code to initialize the range slider
  var priceSlider = $(".price-slider")[0];
  var daSlider = $(".da-slider")[0];
  var drSlider = $(".dr-slider")[0];
  var liveRdSlider = $(".live-rd-slider")[0];
  var ageSlider = $(".age-slider")[0];

  noUiSlider.create(priceSlider, {
    start: [0, 10000],
    connect: true,
    range: {
      min: 0,
      max: 10000,
    },
  });

  noUiSlider.create(daSlider, {
    start: [0, 100],
    connect: true,
    range: {
      min: 0,
      max: 100,
    },
  });

  noUiSlider.create(drSlider, {
    start: [0, 100],
    connect: true,
    range: {
      min: 0,
      max: 100,
    },
  });

  noUiSlider.create(liveRdSlider, {
    start: [0, 10000],
    connect: true,
    range: {
      min: 0,
      max: 10000,
    },
  });

  noUiSlider.create(ageSlider, {
    start: [0, 50],
    connect: true,
    range: {
      min: 0,
      max: 50,
    },
  });

  //---------------- accordian slide-----------
  $(".slide-accor .filter-title").on("click", function () {
    // Close all answers
    $(".slide-accor .answer").slideUp();
    $(".slide-accor .filter-title").removeClass("active");

    // Toggle the clicked answer
    let answer = $(this).next();
    if (!answer.is(":visible")) {
      answer.slideDown();
      $(this).addClass("active");
    }
  });

  //---------------- search category------------

  document.addEventListener("DOMContentLoaded", function () {
    var searchInput = document.getElementById("category_search");
    var itemList = document.getElementById("category_checkboxes");
    var items = itemList.getElementsByTagName("label");

    searchInput.addEventListener("keyup", function (e) {
      var searchTerm = e.target.value.toLowerCase();

      for (var i = 0; i < items.length; i++) {
        var itemText = items[i].textContent.toLowerCase();
        if (itemText.includes(searchTerm)) {
          items[i].style.display = "block";
        } else {
          items[i].style.display = "none";
        }
      }
    });
  });

  //---------------- Hide / Show filters ------------
  $(".di-hide-filters").click(async function () {
    $(".domain-inventory-sidebar").toggleClass("hide-it");
    $(".domain-inventory-content").toggleClass("full-width");
    if ($(".domain-inventory-sidebar").hasClass("hide-it")) {
      $(this).text("Show filters");
    } else {
      $(this).text("Hide filters");
    }
  });

  //---------------- Handle for no results ------------
  let noResults = () => {
    let noVisible = $(".product-box.visible").length === 0;
    if (noVisible) {
      $(".no-results-found").fadeIn();
    } else {
      $(".no-results-found").hide();
    }
  };

  //---------------- Reveal domain name ------------
  $(".domain-name-revealer").click(function () {
    let unobscuredDomainName = $(this)
      .closest(".product-box")
      .data("domain-name");

    $(this)
      .closest(".product-box")
      .find(".obscured-domain-name")
      .text(unobscuredDomainName);
  });

  //---------------- Initialize empty arrays ------------
  let selectedCats = [];
  let searchTerm = "";
  let maxPriceFilter = -1;

  //---------------- Price Range Filter ------------
  priceSlider.noUiSlider.on("slide.one", function () {
    let minPrice = $(this)[0].getPositions()[0] * 100;
    let maxPrice = $(this)[0].getPositions()[1] * 100;

    // Set Price
    $(".price-range-min").val(minPrice.toFixed());
    $(".price-range-max").val(maxPrice.toFixed());

    applyFilters(searchTerm); // Call the combined filtering function
  });

  //---------------- DA Range Filter ------------
  daSlider.noUiSlider.on("slide.one", function () {
    let minPrice = $(this)[0].getPositions()[0];
    let maxPrice = $(this)[0].getPositions()[1];

    // Set Price
    $(".da-range-min").val(minPrice.toFixed());
    $(".da-range-max").val(maxPrice.toFixed());

    applyFilters(searchTerm); // Call the combined filtering function
  });

  //---------------- DR Range Filter ------------
  drSlider.noUiSlider.on("slide.one", function () {
    let minPrice = $(this)[0].getPositions()[0];
    let maxPrice = $(this)[0].getPositions()[1];

    // Set Price
    $(".dr-range-min").val(minPrice.toFixed());
    $(".dr-range-max").val(maxPrice.toFixed());

    applyFilters(searchTerm); // Call the combined filtering function
  });

  //---------------- Live RD Range Filter ------------
  liveRdSlider.noUiSlider.on("slide.one", function () {
    let minPrice = $(this)[0].getPositions()[0] * 100;
    let maxPrice = $(this)[0].getPositions()[1] * 100;

    // Set Price
    $(".live-rd-range-min").val(minPrice.toFixed());
    $(".live-rd-range-max").val(maxPrice.toFixed());

    applyFilters(searchTerm); // Call the combined filtering function
  });

  //---------------- Age Range Filter ------------
  ageSlider.noUiSlider.on("slide.one", function () {
    let minPrice = $(this)[0].getPositions()[0] / 2;
    let maxPrice = $(this)[0].getPositions()[1] / 2;

    // Set Price
    $(".age-range-min").val(minPrice.toFixed());
    $(".age-range-max").val(maxPrice.toFixed());

    applyFilters(searchTerm); // Call the combined filtering function
  });

  //---------------- Category Filter ------------
  let catFilter = () => {
    $('[name="category_filter[]"]').change(async function () {
      let cat = $(this);
      let selectedCat = cat.is(":checked");

      if (selectedCat) {
        if (!selectedCats.includes(cat.val())) {
          selectedCats.push(cat.val());
        }
      } else {
        let index = selectedCats.indexOf(cat.val());
        if (index !== -1) {
          selectedCats.splice(index, 1);
        }
      }

      applyFilters(searchTerm); // Call the combined filtering function
    });
  };

  catFilter();

  //---------------- Domain Name Search ------------
  $(".fire-domain-keyword-search").click(function () {
    searchTerm = $('[name="domain-search"]').val().toLowerCase().trim();

    applyFilters(searchTerm); // Call the combined filtering function
  });

  //---------------- Domain Type Filter ------------
  $('[name="domain-type[]"]').change(function () {
    let selection = $(this);
    let selected = selection.is(":checked");

    if (selected && selection.val() === "30") {
      maxPriceFilter = 30;
    } else {
      maxPriceFilter = -1; // Reset filter if not selected
    }

    applyFilters(searchTerm); // Call the combined filtering function
  });

  //---------------- Combined Filtering Function ------------
  let applyFilters = (searchTerm) => {
    let minPrice = parseFloat($(".price-range-min").val());
    let maxPrice = parseFloat($(".price-range-max").val());

    let minDa = parseFloat($(".da-range-min").val());
    let maxDa = parseFloat($(".da-range-max").val());

    let minDr = parseFloat($(".dr-range-min").val());
    let maxDr = parseFloat($(".dr-range-max").val());

    let minLiveRd = parseFloat($(".live-rd-range-min").val());
    let maxLiveRd = parseFloat($(".live-rd-range-max").val());

    let minAge = parseFloat($(".age-range-min").val());
    let maxAge = parseFloat($(".age-range-max").val());

    $(".domain-inventory-content .product-box").each(async function () {
      let domain = $(this);
      let domainCats = domain
        .find(".catgories span")
        .map(function () {
          return $(this).text();
        })
        .get(); // Get an array of category texts
      let price = Number(
        domain.find(".product-card h2").text().replace("$", "")
      );
      let da = Number(domain.find(".da").text());
      let dr = Number(domain.find(".dr").text());
      let liveRd = Number(domain.find(".live-rd").text());
      let age = Number(domain.find(".age").text());
      let domainName = domain.data("domain-name");

      let priceFilter = price >= minPrice && price <= maxPrice;
      let daFilter = da >= minDa && da <= maxDa;
      let drFilter = dr >= minDr && dr <= maxDr;
      let liveRdFilter = liveRd >= minLiveRd && liveRd <= maxLiveRd;
      let ageFilter = age >= minAge && age <= maxAge;

      let catFilter =
        selectedCats.length === 0 ||
        domainCats.some((cat) => selectedCats.includes(cat));
      let searchFilter = domainName.indexOf(searchTerm) !== -1;
      let maxPriceTypeFilter = maxPriceFilter === -1 || price <= maxPriceFilter;

      if (
        priceFilter &&
        catFilter &&
        searchFilter &&
        maxPriceTypeFilter &&
        daFilter &&
        drFilter &&
        liveRdFilter &&
        ageFilter
      ) {
        domain.fadeIn().css("display", "grid");
        domain.addClass("visible");
      } else {
        domain.hide();
        domain.removeClass("visible");
      }
    });

    setTimeout(() => {
      noResults();
    }, 600);
  };
});
