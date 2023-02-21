"use strict";

$(document).ready(function () {
  $(document).on("click", ".editBannerBtn", function () {
    $("#bannerModel").modal();
    $("#type").val("edit");
    $("#bannerModel .modal-title").html("Edit This Banner");
    $(".fileLabel").html("Change Banner Image"); //get values to be edited

    var bannerId = $("input[type='hidden'][name='bannerId']").val();
    var priority = $("input[type='hidden'][name='priority']").val();
    var description1 = $("input[type='hidden'][name='description1']").val();
    var description2 = $("input[type='hidden'][name='description2']").val(); //pre-populate model form on edit

    $("#bannerId").val(bannerId);
    $("#priority option[value=" + priority + "]").prop("selected", true);
    $("#description1").val(description1);
    $("#description2").val(description2);
  });
  $(document).on("click", ".uploadBannerBtn", function () {
    $("#bannerModel").modal();
    $("#bannerId").val(0);
    $("#type").val("upload");
    $("#bannerModel .modal-title").html("Upload New Banner");
    $(".fileLabel").html("Choose file");
  });
  $(document).on("click", ".closeBannerModel", function () {
    $("#type").val("");
    $("#bannerId").val("");
    $("#bannerModelForm").trigger("reset");
    $("#bannerModel").modal("hide");
  });
  $(document).on("click", ".thumbnailImg", function () {
    var bannerid = $(this).data("bannerid");
    var priority = $(this).data("priority");
    var description1 = $(this).data("description1");
    var description2 = $(this).data("description2");
    var src = $(this).data("src"); //populate hidden fields with values to be edited/deleted later

    $(".deleteBannerBtn").val(bannerid); //what to delete

    $("input[type='hidden'][name='bannerId']").val(bannerid);
    $("input[type='hidden'][name='priority']").val(priority);
    $("input[type='hidden'][name='description1']").val(description1);
    $("input[type='hidden'][name='description2']").val(description2); //set overlay texts

    console.log(description1, description2);

    if (description1.length || description2.length) {
      $(".overlayText").show();
      $(".overlay_description1").html(description1);
      $(".overlay_description2").html(description2);
    } else if (!description1.length && !description2.length) {
      $(".overlayText").hide();
    }

    if ($("input[type='hidden'][name='bannerId']").val() && $("input[type='hidden'][name='priority']").val() && $(".deleteBannerBtn").val() && src.length) {
      $(".editBannerBtn, .deleteBannerBtn").prop("disabled", false);
      $(".deleteBannerBtn").data("src", src); //data setter
    } else {
      toastMe("System Error! Reload Page & Try Again!", "neutral", 10);
    }
  });
  $(document).on("click", ".deleteBannerBtn", function () {
    var btn = $(this);
    var bannerId = btn.val();
    var src = btn.data("src"); //data getter

    if (!src.length) {
      return toastMe("Action Failed. Please select a banner", "error", 10);
    } //ajax call


    $.ajax({
      type: "POST",
      url: "../db/homePageBanners_db.php",
      data: {
        type: "delete",
        bannerId: bannerId
      },
      beforeSend: function beforeSend() {
        btn.html('<i class="fas fa-spinner fa-spin text-danger"></i>');
      },
      success: function success(result) {
        console.log(result);

        if (result === "success") {
          btn.val("");
          btn.data("src", ""); //data setter

          $("img[src$='" + src + "'][name='thumbnailImg']").hide();
          $("img[src$='" + src + "'][name='mainImage']").attr("src", "../images/placeholders/placeholder.png");
          $(".overlayText").html('<h2 class="overlay_description1">Main Heading</h2><p class="overlay_description2">Sub Heading...</p>');
          toastMe("Banner deleted", "success", 10);
        } else {
          if (result.includes("<br />")) {
            toastMe("System Error! Reload Page & Try Again", "neutral", 10);
          } else {
            toastMe(result, "error", 10);
          }
        }

        btn.html('<i class="fas fa-trash"></i>');
      },
      error: function error(_error) {
        console.log(_error);
        toastMe("System Error! Reload Page & Try Again.", "neutral", 10);
        btn.html('<i class="fas fa-trash"></i>');
      }
    });
  });
  $("#bannerModelForm").submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: "POST",
      url: "../db/homePageBanners_db.php",
      data: new FormData(this),
      dataType: "text",
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function beforeSend() {
        $(".bannerModelFormMsg").html('<i class="fas fa-spinner fa-spin text-dark"></i>');
      },
      success: function success(result) {
        console.log(result);

        if (result === "success") {
          $(".bannerModelFormMsg").css("color", "green");
          $(".bannerModelFormMsg").html("Banner Uploaded Successfully");
          $("#bannerModelForm").trigger("reset");
          setTimeout(function () {
            location.reload();
          }, 2000);
        } else {
          if (result.includes("<br />")) {
            $(".bannerModelFormMsg").css("color", "red");
            $(".bannerModelFormMsg").html("System Error! Reload Page & Try Again");
          } else {
            $(".bannerModelFormMsg").css("color", "red");
            $(".bannerModelFormMsg").html(result);
          }
        }
      },
      error: function error(_error2) {
        console.log(_error2);
        $(".bannerModelFormMsg").css("color", "red");
        $(".bannerModelFormMsg").html("System Error! Reload Page & Try Again");
      }
    });
  }); //end
});