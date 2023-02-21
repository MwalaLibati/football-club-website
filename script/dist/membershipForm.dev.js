"use strict";

$(document).ready(function () {
  $(document).on("click", 'a[href="#finish"]', function (event) {
    if ($(".membershipForm").length) {
      $(".membershipForm").submit();
    }
  });
  $(".membershipForm").submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: "POST",
      url: "db/membershipForm_db.php",
      data: new FormData(this),
      dataType: "text",
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function beforeSend() {
        $('a[href="#finish"]').html('<i class="fas fa-spinner fa-spin text-white"></i>');
      },
      success: function success(result) {
        // console.log(result);
        if (result.indexOf("_____") !== -1) {
          // toastMe("Form Submitted Successfully", "success", 60);
          $('a[href="#finish"]').hide();
          $('a[href="#previous"]').hide();
          $('ul[role="tablist"]').hide();
          var membershipPrice = $(".membershipPrice").val(); //get price

          var appliedForMemberType = $(".appliedForMemberType").val(); //get membership applying for

          $(".membershipMsg").html('<h6 class="font-weight-bold text-success">Thank you for applying!</h6><p class="mb-4" id="business-type">Pay a subscription fee of K ' + membershipPrice + " to complete your <b>" + appliedForMemberType + '</b> membership application</p><br><button value="' + result + '" class="btn btn-success buyBtn">Pay Now</button><a href="index.php" class="btn btn-dark ml-2">Pay Later</a>');
        } else {
          if (result.includes("<br />")) {
            toastMe("System Error! Reload Page & Try Again...", "neutral", 10);
          } else {
            toastMe(result, "error", 10);
          }

          $('a[href="#finish"]').html("Finish");
        }
      },
      error: function error(_error) {
        console.log(_error);
        toastMe("System Error! Reload Page & Try Again.", "neutral", 10);
        $('a[href="#finish"]').html("Finish");
      }
    });
  });
  $(".membershipAdminForm").submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: "POST",
      url: "../db/membershipFormAdmin_db.php",
      data: new FormData(this),
      dataType: "text",
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function beforeSend() {
        $(".adminAddMemberSubmitBtn").html('<i class="fas fa-spinner fa-spin text-white"></i>');
      },
      success: function success(result) {
        console.log(result);

        if (result === "success") {
          toastMe("Form Submitted Successfully", "success", 60);
          $(".adminAddMemberSubmitBtn").prop("disabled", true);
          setTimeout(function () {
            window.location.replace("view_users.php");
          }, 3000);
        } else {
          if (result.includes("<br />")) {
            toastMe("System Error! Reload Page & Try Again...", "neutral", 10);
          } else {
            toastMe(result, "error", 10);
          }
        }

        $(".adminAddMemberSubmitBtn").html("Submit");
      },
      error: function error(_error2) {
        console.log(_error2);
        toastMe("System Error! Reload Page & Try Again.", "neutral", 10);
        $(".adminAddMemberSubmitBtn").html("Submit");
      }
    });
  });
});

window.previewImg = function previewImg(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $("#membershipProfilePic").attr("src", e.target.result);
    };

    reader.readAsDataURL(input.files[0]);
  } // end if()

}; //end previewImg()