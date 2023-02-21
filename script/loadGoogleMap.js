// Initialize and add the map
function initMap() {
  // The location of pitch
  var pitch = { lat: -12.6722513, lng: 28.0836835 };
  // The map, centered at pitch
  var map = new google.maps.Map(document.getElementById("map"), {
    zoom: 7,
    center: pitch,
  });
  // The marker, positioned at pitch
  var marker = new google.maps.Marker({
    position: pitch,
    map: map,
    label: {
      color: 'white',
      fontWeight: "bold",
      fontSize: "1.3em",
      text: "Our Football Pitch",
    },
  });
}
