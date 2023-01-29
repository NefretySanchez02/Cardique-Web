function importData() {
  let input = document.createElement("input");
  let name_file = document.getElementById("name-file")
 
  input.type = "file";
  input.name = "files_products"
  input.required = ""
  input.onchange = (_) => {
    // you can use this method to get file and perform respective operations
    let files = Array.from(input.files);
    console.log(files);
    name_file.textContent = files[0].name;
  };
  input.click();
  
}
