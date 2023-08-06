jQuery(document).ready(function ($) {
  // jQuery code to initialize the range slider
  var rangeSlider = $(".meta-slider")[0];
  var inputMin = $(".sf-range-min");
  var inputMax = $(".sf-range-max");

  noUiSlider.create(rangeSlider, {
    start: [0, 10000],
    connect: true,
    range: {
      min: 0,
      max: 10000,
    },
  });

  //---------------- accordian slide-----------
  $(".slide-accor .answer").hide();
  $(".slide-accor > h3").on("click", function () {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $(this).siblings(".answer").slideUp(200);
      $(".slide-accor > h3").removeClass("fa-minus").addClass("fa-plus");
    } else {
      $(".slide-accor > h3").removeClass("fa-minus").addClass("fa-plus");
      $(this).find("i").removeClass("fa-plus").addClass("fa-minus");
      $(".slide-accor > h3").removeClass("active");
      $(this).addClass("active");
      $(".answer").slideUp(200);
      $(this).siblings(".answer").slideDown(200);
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
    $(".obscured-domain-name").text(unobscuredDomainName);
  });

  //---------------- Initialize empty arrays ------------
  let selectedCats = [];
  let searchTerm = "";

  //---------------- Price Range Filter ------------
  rangeSlider.noUiSlider.on("slide.one", function () {
    let minPrice = $(this)[0].getPositions()[0] * 100;
    let maxPrice = $(this)[0].getPositions()[1] * 100;

    // Set Price
    $(".sf-range-min").val(minPrice.toFixed());
    $(".sf-range-max").val(maxPrice.toFixed());

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

  //---------------- Combined Filtering Function ------------
  let applyFilters = (searchTerm) => {
    let minPrice = parseFloat($(".sf-range-min").val());
    let maxPrice = parseFloat($(".sf-range-max").val());

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
      let domainName = domain.data("domain-name");

      let priceFilter = price >= minPrice && price <= maxPrice;
      let catFilter =
        selectedCats.length === 0 ||
        domainCats.some((cat) => selectedCats.includes(cat));
      console.log(domainName);
      console.log(searchTerm);
      let searchFilter = domainName.indexOf(searchTerm) !== -1;

      if (priceFilter && catFilter && searchFilter) {
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
