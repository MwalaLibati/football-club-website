$(document).ready(function () {
  //activate membership for user
  $(document).on("click", ".activateMembershipAdminBtn", function () {
    let btn = $(this);
    let token = $(this).val();
    let tempHtml = btn.html();
    btn.html('<i class="fas fa-spinner fa-spin text-white"></i>');
    $.ajax({
      type: "post",
      url: "../db/activateMemberAdminControl_db.php",
      data: { token: token },
      success: function (result) {
        console.log(result);
        if (result === "success") {
          btn.tooltip("hide");
          $(".paidBadgeRow" + token).html(
            '<span class="badge badge-success">Paid</span>'
          );
          $(".activateMembershipAdminBtnRow" + token).html(
            '<button class="btn btn-sm btn-success m-0" disabled>Active</button>'
          );
          toastMe("Membership Activated Successfully", "success", 10);
        } else {
          toastMe("Action Failed. Try Again", "error", 10);
        }
        btn.html(tempHtml);
      },
      error: function (error) {
        console.log(error);
        toastMe("Action Failed.. Try Again", "error", 10);
        btn.html(tempHtml);
      },
    });
  });
});
