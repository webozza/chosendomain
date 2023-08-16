jQuery(document).ready(function ($) {
  // jQuery code to initialize the range slider
  var priceSlider = $(".price-slider")[0];
  var daSlider = $(".da-slider")[0];
  var drSlider = $(".dr-slider")[0];
  var liveRdSlider = $(".live-rd-slider")[0];
  var ageSlider = $(".age-slider")[0];
  var paSlider = $(".pa-slider")[0];

  const curPath = window.location.pathname;

  if (curPath !== "/premium-domain/") {
    let runUiSlider = (id, max) => {
      noUiSlider.create(id, {
        start: [0, max],
        connect: true,
        range: {
          min: 0,
          max: max,
        },
      });
    };

    runUiSlider(ageSlider, 50);
    runUiSlider(liveRdSlider, 10000);
    runUiSlider(drSlider, 100);
    runUiSlider(daSlider, 100);
    runUiSlider(priceSlider, 10000);
  }

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

  //---------------- search checkboxes ------------
  function setupSearchFilter(searchInputSelector, itemListSelector) {
    var searchInput = $(searchInputSelector);
    var itemList = $(itemListSelector);
    var items = itemList.find("label");

    searchInput.on("keyup", function () {
      var searchTerm = $(this).val().toLowerCase();

      items.each(function () {
        var itemText = $(this).text().toLowerCase();
        if (itemText.includes(searchTerm)) {
          $(this).css("display", "block");
        } else {
          $(this).css("display", "none");
        }
      });
    });
  }

  setupSearchFilter("#category_search", "#category_checkboxes");
  setupSearchFilter("#extension_search", "#extension_checkboxes");
  setupSearchFilter(
    "#auhtority_backlinks_search",
    "#auhtority_backlinks_checkboxes"
  );
  setupSearchFilter("#languages_search", "#languages_checkboxes");

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

  //---------------- Initialize empty arrays ------------
  let selectedCats = [];
  let selectedExtensions = [];
  let selectedBacklinks = [];
  let selectedLanguages = [];
  let selectedUses = [];
  let searchTerm = "";
  let maxPriceFilter = -1;
  let selectedDomainType = "";

  const filtersState = {
    price: {
      filtersApplied: 0,
      hasBeenIncremented: false,
    },
    da: {
      filtersApplied: 0,
      hasBeenIncremented: false,
    },
    pa: {
      filtersApplied: 0,
      hasBeenIncremented: false,
    },
    dr: {
      filtersApplied: 0,
      hasBeenIncremented: false,
    },
    liveRd: {
      filtersApplied: 0,
      hasBeenIncremented: false,
    },
    age: {
      filtersApplied: 0,
      hasBeenIncremented: false,
    },
  };

  const updateCombinedFiltersAppliedUI = () => {
    let combinedFiltersApplied = 0;

    for (const filter in filtersState) {
      const filterState = filtersState[filter];
      combinedFiltersApplied += filterState.filtersApplied; // Summing up filtersApplied values
    }

    // Update UI for the combined filters
    const filterSpan = $(".reset-filters span");
    const filterBtn = $(".reset-filters button");

    if (combinedFiltersApplied !== 0) {
      filterBtn.removeAttr("disabled");
      filterBtn.css("color", "#08104d");
    }

    let newCFA =
      combinedFiltersApplied + Number($(".reset-filters span").data("cfa"));
    filterSpan.text(`${newCFA} filter(s) applied`);

    filterSpan.attr("data-cfa", newCFA);
    $(".reset-filters button").css("color", "#08104d");
  };

  const updateFiltersApplied = (filter, minPrice, maxPrice, maximum) => {
    const filterState = filtersState[filter];

    if (
      !filterState.hasBeenIncremented &&
      (minPrice !== 0 || maxPrice !== maximum)
    ) {
      filterState.filtersApplied++;
      filterState.hasBeenIncremented = true;
      updateCombinedFiltersAppliedUI(); // Update the combined filters count in UI
    }
  };

  $('.domain-section input[type="checkbox"]:not(.script-ignore)').change(
    function () {
      let combinedFilters = parseInt($(".reset-filters span").attr("data-cfa"));
      let newCombinedFilters;

      let checkbox = $(this);
      if (checkbox.is(":checked")) {
        newCombinedFilters = combinedFilters + 1;
      } else {
        newCombinedFilters = combinedFilters - 1;
      }

      $(".reset-filters span").text(`${newCombinedFilters} filter(s) applied`);
      $(".reset-filters span").attr("data-cfa", newCombinedFilters);

      const filterBtn = $(".reset-filters button");

      if (newCombinedFilters !== 0) {
        filterBtn.removeAttr("disabled");
        filterBtn.css("color", "#08104d");
      }
    }
  );

  $(".reset-filters button").click(function () {
    window.location.reload();
  });

  //---------------- Price Range Filter ------------
  if (curPath !== "/premium-domain/") {
    priceSlider.noUiSlider.on("slide.one", function () {
      let minPrice = $(this)[0].getPositions()[0] * 100;
      let maxPrice = $(this)[0].getPositions()[1] * 100;

      // Set Price
      $(".price-range-min").val(minPrice.toFixed());
      $(".price-range-max").val(maxPrice.toFixed());

      applyFilters(searchTerm); // Call the combined filtering function
      updateFiltersApplied("price", minPrice, maxPrice, 10000);
    });
  }

  $(".price-range-min").on("keyup", function () {
    let newMinPrice = parseFloat($(this).val());
    let newMaxPrice = parseFloat($(".price-range-max").val());

    // Update slider positions
    priceSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
    applyFilters(searchTerm);
    updateFiltersApplied("price", newMinPrice, newMaxPrice, 10000);
  });

  $(".price-range-max").on("keyup", function () {
    let newMinPrice = parseFloat($(".price-range-min").val());
    let newMaxPrice = parseFloat($(this).val());
    // Update slider positions
    priceSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
    applyFilters(searchTerm);
    updateFiltersApplied("price", newMinPrice, newMaxPrice, 10000);
  });

  //---------------- DA Range Filter ------------
  if (curPath !== "/premium-domain/") {
    daSlider.noUiSlider.on("slide.one", function () {
      let minPrice = $(this)[0].getPositions()[0];
      let maxPrice = $(this)[0].getPositions()[1];

      // Set Price
      $(".da-range-min").val(minPrice.toFixed());
      $(".da-range-max").val(maxPrice.toFixed());

      applyFilters(searchTerm); // Call the combined filtering function
      updateFiltersApplied("da", minPrice, maxPrice, 100);
    });
  }

  $(".da-range-min").on("keyup", function () {
    let newMinPrice = parseFloat($(this).val());
    let newMaxPrice = parseFloat($(".da-range-max").val());

    // Update slider positions
    daSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
    applyFilters(searchTerm);
    updateFiltersApplied("da", newMinPrice, newMaxPrice, 100);
  });

  $(".da-range-max").on("keyup", function () {
    let newMinPrice = parseFloat($(".da-range-min").val());
    let newMaxPrice = parseFloat($(this).val());
    // Update slider positions
    daSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
    applyFilters(searchTerm);
    updateFiltersApplied("da", newMinPrice, newMaxPrice, 100);
  });

  // ------------------ Pa Range Filter --------------------

  // paSlider.noUiSlider.on("slide.one", function () {
  //   let minPrice = $(this)[0].getPositions()[0];
  //   let maxPrice = $(this)[0].getPositions()[1];

  //   // Set Price
  //   $(".pa-range-min").val(minPrice.toFixed());
  //   $(".pa-range-max").val(maxPrice.toFixed());

  //   applyFilters(searchTerm); // Call the combined filtering function
  //   updateFiltersApplied("pa", minPrice, maxPrice, 100);
  // });

  // $(".pa-range-min").on("keyup", function () {
  //   let newMinPrice = parseFloat($(this).val());
  //   let newMaxPrice = parseFloat($(".pa-range-max").val());

  //   // Update slider positions
  //   paSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
  //   applyFilters(searchTerm);
  //   updateFiltersApplied("pa", newMinPrice, newMaxPrice, 100);
  // });

  // $(".pa-range-max").on("keyup", function () {
  //   let newMinPrice = parseFloat($(".pa-range-min").val());
  //   let newMaxPrice = parseFloat($(this).val());
  //   // Update slider positions
  //   paSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
  //   applyFilters(searchTerm);
  //   updateFiltersApplied("pa", newMinPrice, newMaxPrice, 100);
  // });

  //---------------- PA Range Filter ------------
  if (curPath !== "/premium-domain/") {
    drSlider.noUiSlider.on("slide.one", function () {
      let minPrice = $(this)[0].getPositions()[0];
      let maxPrice = $(this)[0].getPositions()[1];

      // Set Price
      $(".dr-range-min").val(minPrice.toFixed());
      $(".dr-range-max").val(maxPrice.toFixed());

      applyFilters(searchTerm); // Call the combined filtering function
      updateFiltersApplied("dr", minPrice, maxPrice, 100);
    });
  }

  $(".dr-range-min").on("keyup", function () {
    let newMinPrice = parseFloat($(this).val());
    let newMaxPrice = parseFloat($(".dr-range-max").val());

    // Update slider positions
    drSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
    applyFilters(searchTerm);
    updateFiltersApplied("dr", newMinPrice, newMaxPrice, 100);
  });

  $(".dr-range-max").on("keyup", function () {
    let newMinPrice = parseFloat($(".dr-range-min").val());
    let newMaxPrice = parseFloat($(this).val());
    // Update slider positions
    drSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
    applyFilters(searchTerm);
    updateFiltersApplied("dr", newMinPrice, newMaxPrice, 100);
  });

  //---------------- Live RD Range Filter ------------
  if (curPath !== "/premium-domain/") {
    liveRdSlider.noUiSlider.on("slide.one", function () {
      let minPrice = $(this)[0].getPositions()[0] * 100;
      let maxPrice = $(this)[0].getPositions()[1] * 100;

      // Set Price
      $(".live-rd-range-min").val(minPrice.toFixed());
      $(".live-rd-range-max").val(maxPrice.toFixed());

      applyFilters(searchTerm); // Call the combined filtering function
      updateFiltersApplied("liveRd", minPrice, maxPrice, 10000);
    });
  }

  $(".live-rd-range-min").on("keyup", function () {
    let newMinPrice = parseFloat($(this).val());
    let newMaxPrice = parseFloat($(".live-rd-range-max").val());

    // Update slider positions
    liveRdSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
    applyFilters(searchTerm);
    updateFiltersApplied("da", newMinPrice, newMaxPrice, 1000);
  });

  $(".live-rd-range-max").on("keyup", function () {
    let newMinPrice = parseFloat($(".live-rd-range-min").val());
    let newMaxPrice = parseFloat($(this).val());
    // Update slider positions
    liveRdSlider.noUiSlider.set([newMinPrice, newMaxPrice]);
    applyFilters(searchTerm);
    updateFiltersApplied("liveRd", newMinPrice, newMaxPrice, 1000);
  });

  //---------------- Age Range Filter ------------
  if (curPath !== "/premium-domain/") {
    ageSlider.noUiSlider.on("slide.one", function () {
      let minPrice = $(this)[0].getPositions()[0] / 2;
      let maxPrice = $(this)[0].getPositions()[1] / 2;

      // Set Price
      $(".age-range-min").val(minPrice.toFixed());
      $(".age-range-max").val(maxPrice.toFixed());

      applyFilters(searchTerm); // Call the combined filtering function
      updateFiltersApplied("age", minPrice, maxPrice, 50);
    });
  }

  //---------------- Category Filter ------------
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

  //---------------- Domain Extension Filter ------------
  $('[name="extension_filter[]"]').change(async function () {
    let extension = $(this);
    let selectedExtension = extension.is(":checked");

    if (selectedExtension) {
      if (!selectedExtensions.includes(extension.val())) {
        selectedExtensions.push(extension.val());
      }
    } else {
      let index = selectedExtensions.indexOf(extension.val());
      if (index !== -1) {
        selectedExtensions.splice(index, 1);
      }
    }

    applyFilters(searchTerm); // Call the combined filtering function
  });

  //---------------- Authority Backlinks Filter ------------
  $('[name="auhtority_backlinks_filter[]"]').change(async function () {
    let backlink = $(this);
    let selectedBacklink = backlink.is(":checked");

    if (selectedBacklink) {
      if (!selectedBacklinks.includes(backlink.val())) {
        selectedBacklinks.push(backlink.val());
      }
    } else {
      let index = selectedBacklinks.indexOf(backlink.val());
      if (index !== -1) {
        selectedBacklinks.splice(index, 1);
      }
    }

    applyFilters(searchTerm); // Call the combined filtering function
  });

  //---------------- Languages Filter ------------
  $('[name="languages_filter[]"]').change(async function () {
    let lang = $(this);
    let selectedLanguage = lang.is(":checked");

    if (selectedLanguage) {
      if (!selectedLanguages.includes(lang.val())) {
        selectedLanguages.push(lang.val());
      }
    } else {
      let index = selectedLanguages.indexOf(lang.val());
      if (index !== -1) {
        selectedLanguages.splice(index, 1);
      }
    }

    applyFilters(searchTerm); // Call the combined filtering function
  });

  //---------------- Domain Name Search ------------
  $(".fire-domain-keyword-search").click(function () {
    searchTerm = $('[name="domain-search"]').val().toLowerCase().trim();

    applyFilters(searchTerm); // Call the combined filtering function
  });

  //---------------- Domain Type Filter ------------
  $('[name="domain-type[]"]').change(function () {
    let selection = $(this);
    let selected = selection.is(":checked");

    if (selected && selection.val() === "Premium") {
      selectedDomainType = "Premium Domain";
    } else if (selected && selection.val() === "Budget") {
      selectedDomainType = "Budget Domain";
    } else if (selected && selection.val() === "30") {
      selectedDomainType = "30";
    } else if (!selected) {
      selectedDomainType = "";
    }

    applyFilters(searchTerm);
  });

  //---------------- Use Case Filter ------------
  $('[name="use_case_filter[]"]').change(async function () {
    let use = $(this);
    let selectedUse = use.is(":checked");

    if (selectedUse) {
      if (!selectedUses.includes(use.val())) {
        selectedUses.push(use.val());
      }
    } else {
      let index = selectedUses.indexOf(use.val());
      if (index !== -1) {
        selectedUses.splice(index, 1);
      }
    }

    applyFilters(searchTerm); // Call the combined filtering function
  });

  //---------------- Use Case Filter ------------
  let resetFilters = () => {
    let checkboxContainers = $(".cd-checkboxes");
    checkboxContainers.each(function () {});
  };

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
      let domainExtensions = domain.data("domain-extension");
      let authBacklinks = domain.data("auth-backlinks");
      let languages = domain.data("languages");
      let uses = domain.data("use-cases");

      let price = Number(
        domain.find(".product-card h2").text().replace("$", "")
      );
      let da = Number(domain.find(".da").text());
      let dr = Number(domain.find(".dr").text());
      let liveRd = Number(domain.find(".live-rd").text());
      let age = Number(domain.find(".age").text());
      let domainName = domain.data("domain-name");
      let domainType = domain.data("domain-type");

      let priceFilter = price >= minPrice && price <= maxPrice;
      let daFilter = da >= minDa && da <= maxDa;
      let drFilter = dr >= minDr && dr <= maxDr;
      let liveRdFilter = liveRd >= minLiveRd && liveRd <= maxLiveRd;
      let ageFilter = age >= minAge && age <= maxAge;

      let catFilter =
        selectedCats.length === 0 ||
        domainCats.some((cat) => selectedCats.includes(cat));

      let useCaseFilter =
        selectedUses.length === 0 ||
        uses.some((use) => selectedUses.includes(use));

      let extensionFilter =
        selectedExtensions.length === 0 ||
        domainExtensions.some((extension) => {
          let extensionIncluded = selectedExtensions.includes(extension);
          return extensionIncluded;
        });

      let authorityBacklinksFilter =
        selectedBacklinks.length === 0 ||
        authBacklinks.some((backlink) => {
          let backlinksIncluded = selectedBacklinks.includes(backlink);
          return backlinksIncluded;
        });

      let languageFilter =
        selectedLanguages.length === 0 ||
        languages.some((lang) => {
          let languagesIncluded = selectedLanguages.includes(lang);
          return languagesIncluded;
        });

      let searchFilter = domainName.indexOf(searchTerm) !== -1;
      let domainTypeFilter =
        selectedDomainType === "" || selectedDomainType == domainType;

      if (curPath !== "/premium-domain/") {
        if (
          priceFilter &&
          catFilter &&
          searchFilter &&
          //maxPriceTypeFilter &&
          daFilter &&
          drFilter &&
          liveRdFilter &&
          ageFilter &&
          extensionFilter &&
          domainTypeFilter &&
          authorityBacklinksFilter &&
          languageFilter &&
          useCaseFilter
        ) {
          domain.fadeIn().css("display", "grid");
          domain.addClass("visible");
        } else {
          domain.hide();
          domain.removeClass("visible");
        }
      } else {
        if (catFilter) {
          domain.fadeIn().css("display", "grid");
          domain.addClass("visible");
        } else {
          domain.hide();
          domain.removeClass("visible");
        }
      }
    });

    setTimeout(() => {
      noResults();
    }, 600);
  };

  //---------------- Reveal domain name ------------
  $(".domain-name-revealer").click(function () {
    let isLoggedIn = $("body").hasClass("logged-in");

    let unobscuredDomainName = $(this)
      .closest(".product-box")
      .data("domain-name");

    if (isLoggedIn) {
      $(this)
        .closest(".product-box")
        .find(".obscured-domain-name")
        .text(unobscuredDomainName);
    } else {
      $(".ast-account-action-login").click();
    }
  });
});
