$(document).ready(function () {
  let nrc = $(".formatNRC").val();
  let nrcText = $(".formatNRC").text();
  let nrcHtml = $(".formatNRC").html();

  if (!nrc) {
    nrc = nrcText;
    if (!nrc) {
      nrc = nrcHtml;
    }
  }

  if (nrc) {
    if (nrc.length == 9 && !nrc.includes("/")) {
      let position1 = 6;
      let position2 = 9;

      let a = nrc;
      let b = "/";
      let output = [a.slice(0, position1), b, a.slice(position1)].join("");

      a = output;
      output = [a.slice(0, position2), b, a.slice(position2)].join("");

      $(".formatNRC").val(output);
      $(".formatNRC").text(output);
      $(".formatNRC").html(output);
      console.log("format NRC:", output);
    }
  }
});
