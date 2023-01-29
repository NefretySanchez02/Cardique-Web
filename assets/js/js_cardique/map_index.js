function click_map(id) {
  document.getElementById("view-directory-" + id).style.display = "flex";
  localStorage.setItem("id_map", id);
}

document.addEventListener("mousemove", remove_info);

function remove_info() {
  let id_info = localStorage.getItem("id_map");
  if (id_info !== null) {
    document.getElementById("view-directory-" + id_info).style.display = "none";
  }
}
