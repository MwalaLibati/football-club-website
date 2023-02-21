$(document).ready(function () {
  $("#categoryUploadForm").submit(function (event) {
    event.preventDefault();
    $(".categoryUploadMsg").html(
      '<i class="fas fa-spinner fa-spin" style="color:black;"></i>'
    );

    $.ajax({
      type: "post",
      url: "../db/categoryUpload_db.php",
      data: $("#categoryUploadForm").serialize(),

      success: function (result) {
        console.log(result);
        if (result === "success") {
          $(".categoryUploadMsg").text("Category Created Successfully");
          $(".categoryUploadMsg").css("color", "#5cd65c"); //text-green
          $("#categoryUploadForm").trigger("reset");
          $(".submitBtncategoryUpload").css("background-color", "#4d4d4d");
          $(".submitBtncategoryUpload").prop("disabled", true);
          setTimeout(function () {
            location.reload();
            // $(".categoryUploadMsg").html('');
            // $(".categoryUploadMsg").text('');
          }, 3000);
        } else {
          if (result.includes("<br />")) {
            // $(".categoryUploadMsg").text(result);
            $(".categoryUploadMsg").text(
              "System Error! Reload Page & Try Again"
            );
          } else {
            $(".categoryUploadMsg").text(result);
          }
          $(".categoryUploadMsg").css("color", "#ff8080"); //text-red
        }
        $(".categoryUploadMsg").fadeIn();
      },
      error: function (error) {
        console.log(error);
        $(".categoryUploadMsg").text("Error! Try Again");
        $(".categoryUploadMsg").css("color", "#ff8080"); //text-red
        $(".categoryUploadMsg").fadeIn();
      },
    });
  });
});
