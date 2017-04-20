function posterSwap(img) {
  var imgs = document.querySelectorAll('.poster-img img.main-img');
  imgs.forEach(function(e,i){
    if (!e.complete) {

        e.addEventListener('load',loadEvent);
    } else {

        loadEvent(e);
    }
  });

  function loadEvent(img) {
    var theImg;
    if(img.target) {
      theImg = img.target
    } else {
      theImg = img;
    }
    theImg.removeEventListener('load',loadEvent);

    var parent = theImg.parentNode;
    theImg.style.visibility = 'visible';
    var preloader = parent.querySelectorAll('img.preload')[0];
    parent.removeChild(preloader);
  }

}
