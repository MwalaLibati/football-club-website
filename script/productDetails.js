$(document).ready(function () {
  //get pre-value on focus in
  let preQuantityVal;
  $(document).on("focusin", ".minicart-quantity-product", function () {
    preQuantityVal = Number($(this).val());
    // console.log("focusin");
  });
  //listen to quantity change from user
  $(document).on("focusout change", ".minicart-quantity-product", function () {
    let max = Number($(this).attr("max"));
    let val = Number($(this).val());
    let originalPrice = $(this).data("originalprice");
    if (val > max) {
      if (preQuantityVal <= max) {
        $(this).val(preQuantityVal);
      }
      toastMe("Max Quality Is: " + max, "error", 10);
    } else {
      //update price
      let integer = isInteger(val);
      let newPrice = Number(originalPrice) * Number(integer);
      $(".newPrice").html(newPrice);
      editPreCartData(val);
      // console.log("focusout", Number(originalPrice), Number(integer));
    }
  });

  // Restricts input to only integers - default quantity = 1
  window.isInteger = function isInteger(val) {
    // console.log("isInteger()", val);
    let isNum = /^\d*\.?\d*$/.test(val);
    let isSpace = /\s/g.test(val);
    if (!isNum || val == "" || toString(val).indexOf(".") != -1 || isSpace) {
      toastMe("Number Required.", "error", 10);
      return preQuantityVal;
    } else if (val == "" || val == 0) {
      return preQuantityVal;
    } else {
      return val;
    }
  };

  window.editPreCartData = function editPreCartData(newUserQuantity) {
    let val = $(".addProdToCartBtn").val();
    // console.log("editPreCartData()", newUserQuantity, val);
    let result = val.split("_____");
    let newProductCartDetails = "",
      i;
    for (i = 0; i < result.length; i++) {
      if (i != result.length - 1) {
        if (i == 5) {
          newProductCartDetails += newUserQuantity + "_____";
        } else if (i == 1) {
          newProductCartDetails += Number($(".newPrice").text()) + "_____";
        } else {
          newProductCartDetails += result[i] + "_____";
        }
      } else if (i == result.length - 1) {
        newProductCartDetails += result[i];
        console.log("newProductCartDetails:", newProductCartDetails);
        $(".addProdToCartBtn").val(newProductCartDetails);
        toastMe("Updated", "success", 3);
      }
    } //end for()
  };
});

window.change_image = function change_image(image) {
  var container = document.getElementById("main-image");
  container.src = image.src;
};
