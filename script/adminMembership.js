$(document).ready(function () {
  $(document).on("click", ".viewProfileAdminBtn", function () {
    let user = $(this).val();
    let from = $(this).data("from");
    window.location.href =
      "user_profile.php?breadcrumb=" + from + "&user=" + user;
  });
});
