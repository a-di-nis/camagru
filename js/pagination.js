window.onload = function() {
  var pageDivList = document.getElementsByClassName('page');
  var pageButtonList = document.getElementsByClassName('pageButton');

  function changePage(event) {
    var newPageNumber = event.target.value;
    
    for (var i = 0; i < pageDivList.length; i++) {
      if (i == newPageNumber - 1) {
        pageDivList[i].classList.remove('d-none');
      } else {
        pageDivList[i].classList.add('d-none');
      }
    }
  }
  
  for (var i = 0; i < pageButtonList.length; i++) {
    pageButtonList[i].addEventListener('click', changePage, false);
  }
};