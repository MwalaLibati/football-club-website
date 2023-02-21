$(document).ready(function () {
  //initialize tooltip
  $('[data-toggle="tooltip"]').tooltip();

  $(".categoryControlBtn").click(function () {
    $(".toast2").hide();
    let btn = $(this);
    let val = btn.val();
    let id = val.split("_")[0];
    let type = val.split("_")[1];

    let oldText = btn.html();
    btn.html('<i class="fas fa-spinner fa-spin text-white"></i>');

    if (type === "disable" || type === "enable") {
      //disable category----------------------------------------
      $.ajax({
        type: "post",
        url: "../db/categoryControl_db.php",
        data: { type: type, id: id },
        success: function (result) {
          console.log(result);
          if (result === "success") {
            //////////////////////////
            if (type === "disable") {
              btn.val(id + "_enable");
              btn.text("Enable");
              btn.removeClass("btn-light");
              btn.addClass("btn-success");
              $(".categoryStatus" + id).html(
                "<span class='text-danger bold'>Offline</span>"
              );
              btn
                .tooltip("hide")
                .attr(
                  "data-original-title",
                  "Enable Category And Make It Visible To All Users"
                )
                .tooltip("show");
              $(".toast-body").text("Category Is Now Offline");
              $(".toast-body").css("color", "green");

              //////////////////////////
            } else if (type === "enable") {
              btn.val(id + "_disable");
              btn.text("Disable");
              btn.removeClass("btn-success");
              btn.addClass("btn-light");
              $(".categoryStatus" + id).html(
                "<span class='text-success bold'>Online</span>"
              );
              btn
                .tooltip("hide")
                .attr(
                  "data-original-title",
                  "Disable And Hide All Category Products From Users"
                )
                .tooltip("show");
              $(".toast-body").text("Category Is Now Online");
              $(".toast-body").css("color", "green");
            }
          } else {
            $(".toast-body").text("Action Failed. Try Again");
            $(".toast-body").css("color", "red");
          }
          btn.html(oldText);
          $(".toast2").slideDown();
        },
        error: function (error) {
          console.log(error);
          $(".toast-body").text("Action Failed. Try Again");
          $(".toast-body").css("color", "red");
          $(".toast2").slideDown();
          btn.html(oldText);
        },
      });
    } else if (type === "empty") {
      //empty category----------------------------------------
      $.ajax({
        type: "post",
        url: "../db/categoryControl_db.php",
        data: { type: type, id: id },
        success: function (result) {
          console.log(result);
          if (result === "success") {
            $(".toast-body").text("Category Has Been Emptied Successfully");
            $(".toast-body").css("color", "green");
            btn.tooltip("hide");
            btn.attr("disabled", true);
            $(".productCount" + id).text("0");
          } else {
            $(".toast-body").text("Action Failed. Try Again");
            $(".toast-body").css("color", "red");
          }
          btn.html(oldText);
          $(".toast2").slideDown();
        },
        error: function (error) {
          console.log(error);
          $(".toast-body").text("Action Failed. Try Again");
          $(".toast-body").css("color", "red");
          $(".toast2").slideDown();
          btn.html(oldText);
        },
      });
    } else if (type === "delete") {
      //delete category----------------------------------------
      $.ajax({
        type: "post",
        url: "../db/categoryControl_db.php",
        data: { type: type, id: id },
        success: function (result) {
          console.log(result);
          if (result === "success") {
            $(".toast-body").text("Category Has Been Deleted Successfully");
            $(".toast-body").css("color", "green");
            btn.tooltip("hide");
            $(".row" + id).hide(); //hide row
          } else {
            $(".toast-body").text("Action Failed. Try Again");
            $(".toast-body").css("color", "red");
          }
          btn.html(oldText);
          $(".toast2").slideDown();
        },
        error: function (error) {
          console.log(error);
          $(".toast-body").text("Action Failed. Try Again");
          $(".toast-body").css("color", "red");
          $(".toast2").slideDown();
          btn.html(oldText);
        },
      });
    } else {
      $(".toast-body").text("Action Failed. Reload Page & Try Again");
      $(".toast-body").css("color", "red");
      $(".toast2").slideDown();
    }
  });

  //Edit category name-----------------------------------------------------------
  let preCategoryName;
  let postCategoryName;
  $(document).on("focusin", 'input[name="categoryNameEditField"]', function () {
    preCategoryName = $(this).val();
  });
  $(document).on(
    "focusout",
    'input[name="categoryNameEditField"]',
    function () {
      let inputField = $(this);
      postCategoryName = inputField.val();
      let id = inputField.data("id");

      if (preCategoryName == postCategoryName) {
        toastMe("No changes made", "neutral", 10);
        return;
      }
      toastMe(
        '<i class="fas fa-spinner fa-spin text-dark"></i>',
        "neutral",
        10
      );
      $.ajax({
        type: "post",
        url: "../db/categoryControl_db.php",
        data: {
          type: "categoryNameEditField",
          newCategoryName: postCategoryName,
          id: id,
        },
        success: function (result) {
          console.log(result);
          if (result === "success") {
            toastMe("Edit Successful", "success", 10);
          } else {
            if (result.includes("<br />")) {
              toastMe("System Error! Reload Page & Try Again", "error", 10);
            } else {
              toastMe(result, "error", 10);
            }
          }
        },
        error: function (error) {
          console.log(error);
          toastMe(error, "Error! Try Again", 10);
        },
      });
    }
  );
});
