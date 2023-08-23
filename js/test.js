// Sample data array
var dataArray = [];

// Select all product-box elements
var productBoxes = document.querySelectorAll(".product-box");

// Loop through each product-box element and extract data
productBoxes.forEach(function (productBox) {
  var domainName = productBox.getAttribute("data-domain-name");
  var domainExtension = JSON.parse(
    productBox.getAttribute("data-domain-extension")
  );
  var domainType = productBox.getAttribute("data-domain-type");
  var authBacklinks = JSON.parse(
    productBox.getAttribute("data-auth-backlinks")
  );
  var languages = JSON.parse(productBox.getAttribute("data-languages"));
  var useCases = JSON.parse(productBox.getAttribute("data-use-cases"));

  // Extract other relevant data from nested elements
  var imageUrl = productBox
    .querySelector(".product-img img")
    .getAttribute("src");
  var da = productBox.querySelector(".da").textContent;
  var pa = productBox.querySelector(".pa").textContent;
  var liveRD = productBox.querySelector(".live-rd").textContent;
  var histRD = productBox.querySelector(".hist-rd").textContent;
  var price = productBox.querySelector(".product-card h2").textContent;
  var addToCartLink = productBox
    .querySelector(".product-card a[data-quantity]")
    .getAttribute("href");
  var moreDataLink = productBox
    .querySelector(".product-card a[href]")
    .getAttribute("href");

  // Construct data object
  var item = {
    domainName: domainName,
    domainExtension: domainExtension,
    domainType: domainType,
    authBacklinks: authBacklinks,
    languages: languages,
    useCases: useCases,
    imageUrl: imageUrl,
    da: da,
    pa: pa,
    liveRD: liveRD,
    histRD: histRD,
    price: price,
    addToCartLink: addToCartLink,
    moreDataLink: moreDataLink,
    productCategories: ["Category 1", "Category 2"],
  };

  // Push the object into the dataArray
  dataArray.push(item);
});

// Now you can use the dataArray with the pagination script
console.log(dataArray); // Display the extracted data for verification

var itemsPerPage = 5; // Number of items to show per page
var cP = 1; // Current page number
var proCont = document.getElementById("product-container");
var pagCont = document.getElementById("pagination-container");

// Function to display items for a specific page
function displayItems(page) {
  var startIndex = (page - 1) * itemsPerPage;
  var endIndex = startIndex + itemsPerPage;
  var itemsToShow = dataArray.slice(startIndex, endIndex);

  proCont.innerHTML = ""; // Clear the container

  itemsToShow.forEach(function (item) {
    var productBox = document.createElement("div");
    productBox.classList.add("product-box");
    productBox.dataset.domainName = item.domainName;
    productBox.dataset.domainExtension = JSON.stringify(item.domainExtension);
    productBox.dataset.domainType = item.domainType;
    productBox.dataset.authBacklinks = JSON.stringify(item.authBacklinks);
    productBox.dataset.languages = JSON.stringify(item.languages);
    productBox.dataset.useCases = JSON.stringify(item.useCases);

    var productDetails = document.createElement("div");
    productDetails.classList.add("product-details");

    var productHead = document.createElement("div");
    productHead.classList.add("product-head");

    var productImg = document.createElement("div");
    productImg.classList.add("product-img");
    var img = document.createElement("img");
    img.src = item.imageUrl;
    img.alt = "product image";
    productImg.appendChild(img);

    var productTitle = document.createElement("div");
    productTitle.classList.add("product-title");
    var titleInput = document.createElement("input");
    titleInput.classList.add("script-ignore");
    titleInput.type = "checkbox";
    titleInput.value = "";
    titleInput.id = "title";
    var obscuredDomainName = document.createElement("span");
    obscuredDomainName.classList.add("obscured-domain-name");
    obscuredDomainName.textContent = item.domainName;
    var descriptionDiv = document.createElement("div");
    descriptionDiv.classList.add("description", "hidden");
    var descriptionAnchor = document.createElement("a");
    descriptionAnchor.href = "javascript:void(0)";
    var descriptionImg = document.createElement("img");
    descriptionImg.src = "/wp-content/uploads/2023/08/heart-love.jpg";
    var descriptionSpan = document.createElement("span");
    descriptionSpan.textContent = item.productDescription;
    descriptionAnchor.appendChild(descriptionImg);
    descriptionDiv.appendChild(descriptionAnchor);
    descriptionDiv.appendChild(descriptionSpan);
    var domainNameRevealer = document.createElement("div");
    domainNameRevealer.classList.add("domain-name-revealer");
    var domainNameIcon = document.createElement("i");
    domainNameIcon.classList.add("flaticon-eye");
    domainNameRevealer.appendChild(domainNameIcon);

    productTitle.appendChild(titleInput);
    productTitle.appendChild(obscuredDomainName);
    productTitle.appendChild(document.createElement("br"));
    productTitle.appendChild(descriptionDiv);
    productTitle.appendChild(domainNameRevealer);

    productHead.appendChild(productImg);
    productHead.appendChild(productTitle);

    var productBody = document.createElement("div");
    productBody.classList.add("product-body");

    var categoriesDiv = document.createElement("div");
    categoriesDiv.classList.add("catgories");
    item.productCategories.forEach(function (category) {
      var categorySpan = document.createElement("span");
      categorySpan.textContent = category;
      categoriesDiv.appendChild(categorySpan);
    });
    var viewLinksAnchor = document.createElement("a");
    viewLinksAnchor.classList.add("hidden");
    viewLinksAnchor.href = item.categoryPermalink;
    viewLinksAnchor.textContent = "View Links";
    categoriesDiv.appendChild(viewLinksAnchor);

    var ul = document.createElement("ul");
    var daLi = document.createElement("li");
    var daSpan = document.createElement("span");
    daSpan.classList.add("da");
    daSpan.textContent = item.da;
    daLi.appendChild(daSpan);
    daLi.appendChild(document.createTextNode(" DA"));
    ul.appendChild(daLi);

    // Similarly, create other list items and append them to the ul

    productBody.appendChild(categoriesDiv);
    productBody.appendChild(ul);

    var productCard = document.createElement("div");
    productCard.classList.add("product-card");
    var h2 = document.createElement("h2");
    h2.textContent = item.price;
    var ulCard = document.createElement("ul");
    var addToCartLi = document.createElement("li");
    var addToCartAnchor = document.createElement("a");
    addToCartAnchor.href = item.addToCartLink;
    addToCartAnchor.dataset.quantity = "1";
    addToCartAnchor.classList.add(
      "button",
      "product_type_simple",
      "add_to_cart_button",
      "ajax_add_to_cart"
    );
    addToCartAnchor.dataset.product_id = item.productId;
    addToCartAnchor.dataset.product_sku = "";
    addToCartAnchor.setAttribute(
      "aria-label",
      'Add "' + item.domainName + '" to your cart'
    );
    addToCartAnchor.setAttribute("rel", "nofollow");
    addToCartAnchor.textContent = "Add to cart";
    addToCartLi.appendChild(addToCartAnchor);
    var moreDataLi = document.createElement("li");
    var moreDataAnchor = document.createElement("a");
    moreDataAnchor.href = item.moreDataLink;
    moreDataAnchor.textContent = "More Data";
    moreDataLi.appendChild(moreDataAnchor);

    ulCard.appendChild(addToCartLi);
    ulCard.appendChild(moreDataLi);
    productCard.appendChild(h2);
    productCard.appendChild(ulCard);

    productDetails.appendChild(productHead);
    productDetails.appendChild(productBody);
    productDetails.appendChild(productCard);

    productBox.appendChild(productDetails);

    // Append the constructed product box to the container
    proCont.appendChild(productBox);
  });
}

// Function to generate pagination links
function generatePaginationLinks() {
  var totalPages = Math.ceil(dataArray.length / itemsPerPage);

  pagCont.innerHTML = "";

  for (var i = 1; i <= totalPages; i++) {
    var listItem = document.createElement("li");
    var link = document.createElement("a");
    link.href = "javascript:void(0)";
    link.textContent = i;
    link.addEventListener("click", function () {
      cP = i;
      displayItems(cP);
    });

    listItem.appendChild(link);
    pagCont.appendChild(listItem);
  }
}

// Initial display
displayItems(cP);
generatePaginationLinks();
