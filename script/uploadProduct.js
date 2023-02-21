$(document).ready(function () {
  $("#productUploadForm").submit(function (event) {
    event.preventDefault();
    $.ajax({
      type: "POST",
      url: "../db/productUpload_db.php",
      data: new FormData(this),
      dataType: "text",
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function () {
        $(".productUploadSubmitBtn").html(
          '<i class="fas fa-spinner fa-spin text-white"></i>'
        );
      },
      success: function (result) {
        console.log(result);
        if (result === "success") {
          toastMe("Product Uploaded Successfully", "success", 60);
          $("#productUploadForm").trigger("reset");
        } else {
          if (result.includes("<br />")) {
            toastMe("System Error! Reload Page & Try Again", "neutral", 10);
          } else {
            toastMe(result, "error", 10);
          }
        }
        $(".productUploadSubmitBtn").html("Submit");
      },
      error: function (error) {
        console.log(error);
        toastMe("System Error! Reload Page & Try Again.", "neutral", 10);
        $(".productUploadSubmitBtn").html("Submit");
      },
    });
  });
});
