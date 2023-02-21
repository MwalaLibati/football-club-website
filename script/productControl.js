$(document).ready(function () {
  //out of stock alert
  $(".outOfStock").click(function () {
    toastMe("Product Is Currently Unavailable", "error", 10);
  });

  //delete item btn
  $(".deleteProductBtn").click(function () {
    let btn = $(this);
    let prodId = btn.val();

    btn.html('<i class="fas fa-spinner fa-spin text-white"></i>');

    $.ajax({
      type: "post",
      url: "../db/deleteProduct_db.php",
      data: { prodId: prodId },
      success: function (result) {
        console.log(result);
        if (result === "success") {
          $(".deleteProductRow" + prodId).hide();
          toastMe("Item Deleted Successfully", "success", 10);
        } else {
          toastMe(
            "Item Could Not Be Deleted. Reload The Page And Try Again",
            "error",
            10
          );
        }
        btn.html("Delete");
      },
      error: function (error) {
        console.log(error);
        toastMe(
          "Item Could Not Be Deleted<br>Reload The Page And Try Again",
          "error",
          10
        );
        btn.html("Delete");
      },
    });
  });

  //in and out of stock btn----------------------------------------------------------------------------------------------------
  $(document).on("click", ".availableProductBtn", function () {
    let btn = $(this);
    let prodId = btn.val();
    var title = btn.attr("data-original-title");

    let oldText = btn.html();
    btn.html('<i class="fas fa-spinner fa-spin text-white"></i>');

    if (title === "Mark As Unavailable") {
      //------------------------------
      $.ajax({
        type: "post",
        url: "../db/productAvailable_db.php",
        data: { data: "markOut", prodId: prodId },
        success: function (result) {
          console.log(result);
          if (result === "success") {
            $(".productBadgeCover" + prodId).html(
              '<span class="badge badge-danger m-1">Unavailable</span>'
            );

            toastMe("Product Marked As Unavailable", "success", 10);
            btn
              .removeClass("btn-danger")
              .addClass("btn-success")
              .html("Enable")
              .tooltip("hide")
              .attr("data-original-title", "Mark As Available")
              .tooltip("show");
          } else {
            toastMe("Action Failed. Try Again", "error", 10);
          }
          // btn.html(oldText);
        },
        error: function (error) {
          console.log(error);
          toastMe("Action Failed. Try Again", "error", 10);
          // btn.html(oldText);
        },
      });
    } else if (title === "Mark As Available") {
      //------------------------------
      $.ajax({
        type: "post",
        url: "../db/productAvailable_db.php",
        data: { data: "markIn", prodId: prodId },
        success: function (result) {
          console.log(result);
          if (result === "success") {
            $(".productBadgeCover" + prodId).html(
              '<span class="badge badge-success m-1">Available</span>'
            );

            toastMe("Product Marked As Available", "success", 10);
            btn
              .addClass("btn-danger")
              .removeClass("btn-success")
              .html("Disable")
              .tooltip("hide")
              .attr("data-original-title", "Mark As Unavailable")
              .tooltip("show");
          } else if (result === "quantityFail") {
            toastMe("Product Quantity is Zero (0)", "error", 10);
          } else {
            toastMe("Action Failed. Try Again", "error", 10);
          }
          $(".toast").slideDown();
          // btn.html(oldText);
        },
        error: function (error) {
          console.log(error);
          toastMe("Action Failed. Try Again", "error", 10);
          // btn.html(oldText);

        },
      });
    }
  });
  //in and out of stock btn----------------------------------------------------------------------------------------------------
});
