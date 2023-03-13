function onclick_map(id) {
  let openModal = $("foreignObject");
  if (openModal.length != 0) {
    openModal[0].remove();
    messagesUIManagerCourse.drawItem(id);
  } else {
    messagesUIManagerCourse.drawItem(id);
  }
}

function remove_modal(id) {
  var element = document.getElementById("view-directory-" + id);
  element.classList.remove("d-block");
  $(`#${id} foreignObject`)[0].remove();
}
