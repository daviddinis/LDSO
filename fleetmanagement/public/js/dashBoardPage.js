function enableListView() {
    var icon = document.querySelectorAll('#gridViewToggle');
    var contentGrid = document.querySelectorAll('#gridView');
    var contentList = document.querySelectorAll('#listView');
  
    icon[0].classList.remove("fa-th");
    icon[0].classList.add("fa-list");
    contentGrid[0].classList.toggle("d-none");
    contentList[0].classList.toggle("d-none");
  }
  
  function enableGridView() {
    var icon = document.querySelectorAll('#gridViewToggle');
    var contentGrid = document.querySelectorAll('#gridView');
    var contentList = document.querySelectorAll('#listView');
  
  
    icon[0].classList.add("fa-th");
    icon[0].classList.remove("fa-list");
    contentGrid[0].classList.toggle("d-none");
    contentList[0].classList.toggle("d-none");
  }
  
  function gridViewToggle() {
    var icon = document.querySelectorAll('#gridViewToggle');
    if (icon[0].classList.contains("fa-list")) {
      enableGridView()
    } else {
      enableListView()
    }
  }
