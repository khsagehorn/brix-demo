window.onload = function(){
  var floorplans = document.getElementsByClassName('location-section');
  if (floorplans){
    var details = document.getElementById('details');
    var images = document.getElementById('images');
    var i;

    details.firstElementChild.classList.add('active');
    images.firstElementChild.classList.add('active');
    details.addEventListener('click', function(){
    });
  }

  function getEventTarget(e) {
      e = e || window.event;
      return e.target || e.srcElement;
  }
}
