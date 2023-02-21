$(document).ready(function () {
  // console.log("jdslk");
  $(".toast-close").click(function () {
    $(".toast").hide();
    $(".toast2").hide();
    $(".toast-body").text("");
  });

  $(".comingSoon").click(function () {
    toastMe("Feature Coming Soon", "neutral", 10);
  });

  //close toast msg
  window.toastClose = function toastClose() {
    $(".toast,.toast2").hide();
    $(".toast-body").html("");
    // console.log("toastClose()");
  };

  // types = success, error, neutral
  window.toastMe = function toastMe(msg, type, sec) {
    toastClose();
    $(".toast,.toast2").fadeIn();
    $(".toast-body").html(msg);
    // $(".toast-body").animate({ fontSize: "1.1em" });
    // $(".toast-body").animate({ fontSize: "1em" });
    if (type == "success") {
      $(".toast-body").css("color", "green");
    } else if (type == "error") {
      $(".toast-body").css("color", "red");
    } else if (type == "neutral") {
      $(".toast-body").css("color", "#4d4d4d");
    } else {
      $(".toast-body").css("color", "white");
    }

    /* setTimeout(function () {
      toastClose();
    }, sec * 1000); */
    // console.log("Toast:", msg, sec);
  }; //end toastMe()
});
