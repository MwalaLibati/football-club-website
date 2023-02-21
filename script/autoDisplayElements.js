//AUTO-DISPLAY MANAGER-------------------------------------------------------
$(document).ready(function () {
  let autoDisplayElement = localStorage.getItem("autoDisplayElement");
  if (autoDisplayElement !== null) {
    if (autoDisplayElement == "login") {
      localStorage.setItem("autoDisplayModel", "");
      $("#ritekhelamodalcenter").modal();
    } else if (localStorage.getItem("autoDisplayModel") == "signup") {
      //...
    }
  }
});
