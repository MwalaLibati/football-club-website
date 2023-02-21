$(document).ready(function () {
  let cartArray = new Array();
  initializeCart();
  function initializeCart() {
    // console.log("initializeCart()");
    //initialize cart array from localStorage
    if (localStorage.getItem("cartArray") === null) {
      localStorage.setItem("cartArray", JSON.stringify(["cartArray"]));
      // console.log("localStorage", localStorage.getItem("cartArray"));
    } else {
      cartArray = JSON.parse(localStorage.getItem("cartArray"));
      if (cartArray.length <= 0) {
        localStorage.setItem("cartArray", JSON.stringify(["cartArray"]));
        // console.log("localStorage", cartArray.length);
      }
      //preset cart UI
      presetCartUI(cartArray);
      loadCartTable(cartArray);
    }
    // show payment btn if cart has something in it
    if (cartArray.length > 1) {
      $(".makeCartPaymentBtn").show();
    } else if (cartArray.length <= 1) {
      $(".makeCartPaymentBtn").hide();
    }
    $(".cartBoxCover").show();
    $(".makePaymentTable").show();
    // console.log("localStorage", localStorage.getItem("cartArray"));
  } //end initializeCart()

  window.cartDBManager = function cartDBManager() {
    cartArray.forEach((cartData, index, result_array) => {
      if (index !== 0) {
        $.ajax({
          type: "post",
          url: "db/cartDBManager_db.php",
          data: { cartData: cartData },
          dataType: "json",
          success: function (response) {
            console.log(response.msg);
            if (response.actionRemove == "remove") {
              removeOneItemFromCart(cartData.prodId, cartData.itemType, true); //requested to remove/delete said item from cart
            } else if (response.actionOther != "") {
              updateCartItemIfActive(response.result, false); //request to update/apply new changes on said cart item
            }
          },
          error: function (error) {
            console.log(error);
            toastMe("Action Failed.<br>Cart Could Not Be Updated", "error", 10);
          },
        });
      } //end if()
    }); //end loop
  }; //end cartDBManager()

  //Open Cart
  jQuery("a.ritekhela-open-cart").on("click", function () {
    cartDBManager();
    jQuery(".ritekhela-cart-box").slideToggle("slow");
    return false;
  });

  function animateCartQuantity() {
    $(".minicart-quantity,.minicart-quantity-product").addClass(
      "border-darkish-2"
    );
    setTimeout(function () {
      $(".minicart-quantity,.minicart-quantity-product").removeClass(
        "border-darkish-2"
      );
    }, 10000);
  } //end animateCartQuantity()

  $(document).mouseup(function (e) {
    var container = $(".ritekhela-cart-box");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) {
      container.fadeOut();
    }
  });
  // jQuery('html').on("click", function() { jQuery(".ritekhela-cart-box").fadeOut(); });

  //add to cart btn
  $(".addToCartBtn").click(function () {
    let val = $(this).val();
    updateCartItemIfActive(val, true);
  });

  //buy btn
  $(document).on("click", ".buyBtn", function () {
    let val = $(this).val();
    updateCartItemIfActive(val, false);
    window.location.href = "makePayment.php";
  });

  //empty cart
  $(document).on("click", ".emptyCart", function () {
    emptyCart();
  });

  //empty cart
  window.emptyCart = function emptyCart() {
    // console.log("emptyCart()");
    localStorage.clear();
    cartArray = [];
    presetCartUI(cartArray);
    loadCartTable(cartArray);
    // toastMe("Cart Is Empty", "neutral", 10);
    initializeCart();
  }; //end emptyCart()

  //remove from cart
  $(document).on("click", ".cartRemove", function () {
    let val = $(this).val();
    let itemtype = $(this).data("itemtype");
    removeOneItemFromCart(val, itemtype, true);
  });

  //remove One Item From Cart
  window.removeOneItemFromCart = function removeOneItemFromCart(
    prodId,
    itemType,
    alertUser
  ) {
    let found = false;
    cartArray.forEach((result, index, result_array) => {
      if (
        (result.prodId == prodId && result.itemType == itemType) ||
        (itemType == "membership" && result.itemType == "membership")
      ) {
        found = true;
        cartArray.splice(index, 1);
        localStorage.setItem("cartArray", JSON.stringify(cartArray));
        presetCartUI(cartArray);
        loadCartTable(cartArray);
        if (alertUser) {
          toastMe("Item Removed From Cart", "neutral", 10);
        }
        if (index === result_array.length - 1 && found) {
          initializeCart();
        }
      }
    }); //end loop
  }; //end removeOneItemFromCart()

  //update new price and quantity
  window.updateItemData = function updateItemData(what, prodId, newVal) {
    // console.log("updateItemData()");
    let found = false;
    let itemIndex = 0;
    cartArray.forEach((result, index, result_array) => {
      if (result.prodId == prodId) {
        found = true;
        itemIndex = index;
      }
      if (index === result_array.length - 1 && found) {
        if (what === "myQuantity") {
          if (cartArray[itemIndex].myQuantity != newVal) {
            //update new price and quantity
            cartArray[itemIndex].myQuantity = newVal;
            let productAns =
              Number(cartArray[itemIndex].myQuantity) *
              Number(cartArray[itemIndex].originalPrice);
            cartArray[itemIndex].price =
              Math.round((productAns + Number.EPSILON) * 100) / 100;
            toastMe("Cart Updated", "success", 3);
          }
        }
        localStorage.setItem("cartArray", JSON.stringify(cartArray));
        presetCartUI(cartArray);
        loadCartTable(cartArray);
      } else if (index === result_array.length - 1 && !found) {
        toastMe("Update Failed. Reload page and try again", "error", 10);
      }
    }); //end loop
  }; //end updateItemData()

  //add or delete or replace item in cart
  window.updateCartItemIfActive = function updateCartItemIfActive(
    val,
    alertUser
  ) {
    let result = val.split("_____");
    let prodId = result[3];
    let active = result[7];
    let itemType = result[8];

    if (active == 1) {
      //active: 1 means add to cart (replace if exists)
      removeOneItemFromCart(prodId, itemType, alertUser); //but first remove item if already exists in cart
      saveCartItem(val, alertUser); //then add it to cart
      presetCartUI(cartArray); // then display it in cart UI
      loadCartTable(cartArray); // and also in cart table in (makePayments.php)
    } else if (active == 0) {
      //active: 0 means DO NOT add to cart, & if exists then REMOVE immediately
      removeOneItemFromCart(prodId, itemType, alertUser);
      if (alertUser) {
        toastMe("Product Is Currently Unavailable", "error", 10);
      }
    }
  }; //end updateCartItemIfActive()

  //save cart in localStorage
  window.saveCartItem = function saveCartItem(val, alertUser) {
    // console.log("saveCartItem()");
    initializeCart();
    let result = val.split("_____");
    let name = result[0]; //name of item
    let price = result[1]; //total price (quantity*pricePerItem)
    let path = result[2]; //path to item's image in directory
    let prodId = result[3]; //product ID in db table
    let quantity = result[4]; //original quantity set by admin
    let myQuantity = result[5]; //user set quantity (always less than or equal to Original quantity)
    let originalPrice = result[6]; //price per each item set by admin
    let active = result[7]; //if(active==1){add to cart} else //if(active==1){do not add to cart or remove from cart if already exists in cart}
    let itemType = result[8]; //items added to cart can be [product][membership][tickets][ect...]
    let myPromise = new Promise((resolve, reject) => {
      let notFound = 0;
      let found = 0;
      if (cartArray.length === 1) {
        resolve();
      } else {
        cartArray.forEach((result, index, result_array) => {
          if (result.prodId !== prodId) {
            notFound++;
          } else if (result.prodId === prodId) {
            found++;
          }

          //end of loop
          if (index === result_array.length - 1) {
            if (notFound === result_array.length && found === 0) {
              //add
              resolve();
            } else if (found > 0) {
              //don't add
              reject(name);
            } else {
              resolve();
            }
          }
        }); //end loop
      }
    });

    myPromise
      .then(() => {
        //add item
        cartArray.push({
          name: name,
          price: price,
          path: path,
          prodId: prodId,
          quantity: quantity,
          myQuantity: myQuantity,
          originalPrice: originalPrice,
          active: active,
          itemType: itemType,
        });
        localStorage.setItem("cartArray", JSON.stringify(cartArray));
        presetCartUI(cartArray);
        loadCartTable(cartArray);
        if (alertUser) {
          toastMe(
            "Item Added To Cart<br><a href='makePayment.php' class='btn btn-sm btn-success mt-3'>Buy Now</a>",
            "success",
            30
          );
        } //end if()
      })
      .catch((name) => {
        //don't add item
        // toastMe("<b>" + name + "</b> Already Exists In Cart", "neutral", 10);
        // console.log(name + " Already Exists In Cart");
      });
  }; //end saveCartItem()

  //set Cart UI on Page Load
  function presetCartUI(cartArray) {
    // console.log("presetCartUI()");
    $(".cartItemCover").html("");
    if (cartArray.length > 1) {
      $(".cartItemCover").html(
        '<p class="emptyCart hand text-center text-dark p-2 mb-3">Empty My Cart</p>'
      );
      cartArray.forEach((result, index, result_array) => {
        if (index !== 0) {
          $(".cartItemCover").append(
            loadCartItemUI(
              result.name,
              result.price,
              result.path,
              result.prodId,
              result.quantity,
              result.myQuantity,
              result.originalPrice,
              result.active,
              result.itemType
            )
          );
        }
      }); //end loop
      //count cart items
      $(".cartCount").text(cartArray.length - 1);
      $(".cartPayBtnCover").html(
        '<a href="makePayment.php" class="ritekhela-cartbox-btn box-shadow cartPayBtn">Make Payment</a>'
      );
    } else {
      $(".cartCount").text("0");
      $(".cartTotal").text("K 0.00");
      $(".cartTotalHidden").val(0);
      $(".cartPayBtnCover").html("");
      $(".cartItemCover").html(
        '<p class="cartIsEmpty text-dark text-center">Your Cart Is Empty</p>'
      );
    }

    //calculate cart total price
    calculateCartTotal(cartArray);
  } //end presetCartUI()

  function calculateCartTotal(cartArray) {
    // console.log("calculateCartTotal()");
    let cartTotal = 0;
    cartArray.forEach((result, index, result_array) => {
      if (index !== 0) {
        cartTotal += Number(result.price);
      }
    }); //end loop'

    $(".cartTotal").text("K " + cartTotal);
    $(".cartTotalHidden").val(cartTotal);

    //auto populate hidden field in makePayment.php
    cartArray = JSON.parse(localStorage.getItem("cartArray"));
    $("#cartArrayInputFieldId").val(JSON.stringify(cartArray));
  } // end calculateCartTotal()

  //dynamic cart UI
  function loadCartItemUI(
    name,
    price,
    path,
    prodId,
    quantityNum,
    myQuantity,
    originalPrice,
    active,
    itemType
  ) {
    if (
      myQuantity === undefined ||
      myQuantity === null ||
      quantityNum === undefined ||
      quantityNum === null
    ) {
      removeOneItemFromCart(prodId, itemType, true);
    } else {
      // console.log("loadCartItemUI()");
      let quantity =
        '<input class="minicart-quantity border-1 border-darkish m-0" data-toggle="tooltip" title="Enter Quantity" max="' +
        quantityNum +
        '" data-minicart-idx="0" name="quantity_1" type="text" data-prodid="' +
        prodId +
        '" pattern="[0-9]*" value="' +
        myQuantity +
        '" autocomplete="off"><span title="Max = ' +
        quantityNum +
        '" class="font-small ml-1 text-gray-light">/ ' +
        quantityNum +
        "</span>";
      let itemUI =
        '<li class="cartItem mb-2 p-2">' +
        '<figure><img class="cartImg" style="height: 80px; width: 80px" src="' +
        getImgIfExists(path) +
        '" alt=""></figure>' +
        '<div class="ritekhela-cartbox-text">' +
        '<h6 class="pt-1">' +
        name +
        "</h6>" +
        '<button class="fa fa-trash text-dark btn btn-link cartRemove mr-3 hand" data-itemtype="' +
        itemType +
        '" data-toggle="tooltip" title="Remove" value="' +
        prodId +
        '"></button>' +
        '<h6 class="pt-1">' +
        '<i class="quantityLabel">Quantity: </i>' +
        quantity +
        "</h6>" +
        '<span data-toggle="tooltip" title="K' +
        originalPrice +
        ' Each" class="ritekhela-cartbox-price ritekhela-color-two pt-1 cartPrice">' +
        "K " +
        price +
        "" +
        "</span>" +
        "</div>" +
        "</li>";
      return itemUI;
    }
  } //end loadCartItemUI()

  //get pre-value on focus in
  let preQuantityVal;
  $(document).on("focusin", ".minicart-quantity", function () {
    preQuantityVal = Number($(this).val());
  });
  //listen to quantity change from user
  $(document).on("focusout", ".minicart-quantity", function () {
    let max = Number($(this).attr("max"));
    let val = Number($(this).val());
    let prodId = $(this).data("prodid");
    if (val > max) {
      if (preQuantityVal <= max) {
        $(this).val(preQuantityVal);
      }
      toastMe("Max Quality Is: " + max, "error", 10);
    } else {
      //update quantity in localStorage
      let integer = isInteger($(this).val());
      updateItemData("myQuantity", prodId, integer);
      $(this).val(integer);
    }
  });

  // Restricts input to only integers - default quantity = 1
  window.isInteger = function isInteger(val) {
    // console.log("isInteger()");
    let isNum = /^\d*\.?\d*$/.test(val);
    let isSpace = /\s/g.test(val);
    if (!isNum || val == "" || toString(val).indexOf(".") != -1 || isSpace) {
      toastMe("Number Required", "error", 10);
      return preQuantityVal;
    } else if (val == "" || val == 0) {
      return preQuantityVal;
    } else {
      return val;
    }
  };

  //----------------------------------------------Render Table In  makePayment.php------------------------------------------------------------------------
  //load table content in makePayment.php-----------------------------------------------------------------------------------------------------------------
  function loadCartTable(cartArray) {
    // console.log("loadCartTable()");
    $(".makePaymentTable tbody").html("");
    if (cartArray.length > 1) {
      cartArray.forEach((result, index, result_array) => {
        if (index !== 0) {
          $(".makePaymentTable tbody").append(
            loadCartTableItems(
              index,
              result.name,
              result.price,
              result.path,
              result.prodId,
              result.quantity,
              result.myQuantity,
              result.originalPrice,
              result.active,
              result.itemType
            )
          );
        }
      }); //end loop
      //count cart items
    } else {
      // console.log("Your Cart Is Empty");
    }

    //calculate cart total price
    calculateCartTotal(cartArray);
  } //end loadCartTable()

  //dynamic cart UI
  function loadCartTableItems(
    index,
    name,
    price,
    path,
    prodId,
    maxQuantity,
    userQuantity,
    originalPrice,
    active,
    itemType
  ) {
    if (
      maxQuantity === undefined ||
      maxQuantity === null ||
      userQuantity === undefined ||
      userQuantity === null
    ) {
      removeOneItemFromCart(prodId, itemType, true);
    } else {
      let quantity =
        '<input class="minicart-quantity border-1 border-darkish m-0" data-toggle="tooltip" title="Enter Quantity" max="' +
        maxQuantity +
        '" data-minicart-idx="0" name="quantity_1" type="text" data-prodid="' +
        prodId +
        '" pattern="[0-9]*" value="' +
        userQuantity +
        '" autocomplete="off"><span title="Max = ' +
        maxQuantity +
        '" class="font-small ml-1 text-gray-light">/ ' +
        maxQuantity +
        "</span>";

      let itemUI =
        '<tr class="paymentTableRow' +
        prodId +
        '">' +
        "<td>" +
        index +
        ".</td>" +
        '<td style="text-align: center; margin:auto;"> <a target="_blank" data-fancybox-group="group" href="' +
        getImgIfExists(path) +
        '" class="fancybox"> <img src="' +
        getImgIfExists(path) +
        '" alt="image"> </a> </td>' +
        "<td>" +
        name +
        "</td>" +
        "<td>" +
        quantity +
        "</td>" +
        "<td data-toggle='tooltip' title='K" +
        originalPrice +
        " Each'>K " +
        price +
        "</td>" +
        '<td> <button value="' +
        prodId +
        '" class="cartRemove btn btn-link fa fa-trash hand text-dark" style="position:relative;" data-itemtype="' +
        itemType +
        '" data-toggle="tooltip" title="Remove"></button> </td>' +
        "</tr>";
      return itemUI;
    }
  } //end loadCartItemUI()

  function getImgIfExists(path) {
    // return path;
    if (path) {
      var req = new XMLHttpRequest();
      req.open("GET", path, false);
      req.send();
      if (req.status == 200) {
        return path;
      } else {
        return "images/placeholders/product-placeholder.png";
      }
    } else {
      return "images/placeholders/product-placeholder.png";
    }
  } //end getImgIfExists()

  /* end */
}); //end document.ready()
