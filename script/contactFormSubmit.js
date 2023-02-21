$(document).ready(function () {
  $("#contactForm").submit(function (event) {
    event.preventDefault();

    $(".contactFormMsg").html(
      '<i class="fas fa-spinner fa-spin text-dark"></i>'
    );

    $.ajax({
      type: "post",
      url: "db/contact_db.php",
      data: $(this).serialize(),

      success: function (result) {
        console.log(result);
        if (result === "success") {
          $(".contactFormMsg").html(
            "Thank You For Getting In Touch With Us.<br>We Will Get Back To You Real Soon"
          );
          $(".contactFormMsg").css("color", "#5cd65c"); //text-green
          $("#contactForm").trigger("reset");
          $(".submitBtnContact").css("background-color", "#4d4d4d");
          $(".submitBtnContact").prop("disabled", true);
          setTimeout(function () {
            $(".submitBtnContact").prop("disabled", false);
            $(".contactFormMsg").html("");
          }, 10000);
        } else {
          if (result.includes("<br />")) {
            // $(".contactFormMsg").text(result);
            $(".contactFormMsg").text("System Error! Reload Page & Try Again");
          } else {
            $(".contactFormMsg").text(result);
          }
          $(".contactFormMsg").css("color", "#ff8080"); //text-red
        }
        $(".contactFormMsg").fadeIn();
      },
      error: function (error) {
        console.log(error);
        $(".contactFormMsg").text("Error! Try Again");
        $(".contactFormMsg").css("color", "#ff8080"); //text-red
        $(".contactFormMsg").fadeIn();
      },
    });
  });

});
