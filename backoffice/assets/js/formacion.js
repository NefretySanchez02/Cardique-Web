/**
 * Maneja las peticiones Ajax
 */
var current_page = 1;
var messagesClient = {
  init: function () {
    messagesClient.list();
    setInterval(() => {
      messagesClient.list();
    }, 30000);
  },

  /**
   * Obtiene mediante consulta un arreglo con todos los mensajes en BD
   */
  list: function () {
    $.ajax({
      method: "GET",
      url: application.service_url + "negocios_verdes.php",
      data: { action: "list" },
    }).done(function (msg) {
      if (msg.length != 0) {
        application.log(msg);

        let data = application.parseJson(msg);

        if (data.success == 1) {
          messagesUIManager.drawList(data, current_page);
        }
      }
    });
  },

  /**
   * Obtiene mediante consulta un mensajes desde BD
   */
  get: function (item_id, callback) {
    $.ajax({
      method: "GET",
      url: application.service_url + "negocios_verdes.php",
      data: {
        action: "get",
        slug: item_id,
      },
    }).done(function (msg) {
      application.log(msg);

      let data = application.parseJson(msg);

      if (data.success == 1) {
        callback(data.news_item);
      }
    });
  },

  /**
   * Eliminar una noticia en la BD
   */

  deleteNews: function (item_id, callback) {
    $.ajax({
      method: "POST",
      url: application.service_url + "negocios_verdes.php",
      data: {
        action: "delete",
        id_item: item_id,
      },
    }).done(function (msg) {
      console.log(msg);
    });
  },

  /**
   * Editar una noticia en la BD
   */

  updateImageNews: function (foto) {
    var formData = new FormData();
    formData.append("image", foto);
    formData.append("action", "updateFiles");
    if (typeof formData.get("image") == "object") {
      $.ajax({
        url: application.service_url + "negocios_verdes.php",
        type: "POST",
        data: formData,
        mimeType: "multipart/form-data",
        dataType: "html",
        contentType: false,
        processData: false,
        success: function (msg, textStatus, jqXHR) {
          console.log(msg);
        },
        error: function (jqXHR, textStatus, errorThrown) {},
      });
    }

    /*  */
  },
  updateImageCourse: function (foto) {
    var formData = new FormData();
    formData.append("image", foto);
    formData.append("action", "updateImage");
    if (typeof formData.get("image") == "object") {
      $.ajax({
        url: application.service_url + "negocios_verdes.php",
        type: "POST",
        data: formData,
        mimeType: "multipart/form-data",
        dataType: "html",
        contentType: false,
        processData: false,
        success: function (msg, textStatus, jqXHR) {
          console.log(msg);
        },
        error: function (jqXHR, textStatus, errorThrown) {},
      });
    }

    /*  */
  },
};

/**
 * Maneja el comportamiento de los elementos en pantalla
 */

var messagesUIManager = {
  /**
   * construye la lista de servicios y la inyecta en el DOM
   */
  drawList: function (dataset, page) {
    if (!dataset) {
      return false;
    }

    let messages = dataset.messages;
    var btn_next = document.getElementById("btn_next");
    var btn_prev = document.getElementById("btn_prev");
    let wrapper = document.getElementById("news-wrapper");
    var page_span = document.getElementById("page");
    let numberPages = Math.ceil(messages.length / 10);
    localStorage.setItem("numberPages", numberPages);
    wrapper.innerHTML = "";

    if (page < 1) page = 1;
    if (page > numberPages) page = numberPages;
    for (var i = (page - 1) * 10; i < page * 10; i++) {
      if (messages[i] === undefined) {
        break;
      }
      wrapper.appendChild(messagesUIManager.drawItem(messages[i]));
    }
    /*    messages.slice(-10).forEach(function (msg, i) {
      wrapper.appendChild(messagesUIManager.drawItem(msg));
    }); */
    page_span.innerHTML = `${page} de ${numberPages}`;

    if (page == 1) {
      btn_prev.style.visibility = "hidden";
    } else {
      btn_prev.style.visibility = "visible";
    }

    if (page == numberPages) {
      btn_next.style.visibility = "hidden";
    } else {
      btn_next.style.visibility = "visible";
    }

    /*   messages.forEach(function (msg) {
      wrapper.appendChild(messagesUIManager.drawItem(msg));
    }); */
  },
  /**
   * construye elemento servicio listo para integrar al DOM
   */
  drawItem: function (itemData) {
    if (!itemData) {
      return false;
    }

    let id = itemData.id;
    let name = itemData.nombre;
    let tipo = itemData.categoria;
    let itemHtml = /*html*/ `        
            <td>
              <span class="service-name">${name}</span>
            </td>
            <td>
              <span class="d-block">${tipo}</span>
            </td>
            <td>
              <a class="text-info hover-effect" onclick="messagesUIManager.viewItem('${id}')">
                <i class="material-icons">visibility</i>
              </a>
              <a class="text-info hover-effect" onclick="messagesUIManager.editItem('${id}')">
              <i class="material-icons">mode_edit</i>
            </a>
          </td>
           
        `;

    let tr = document.createElement("tr");
    tr.setAttribute("id", "serv-item-" + id);
    tr.setAttribute("class", status);
    tr.innerHTML = itemHtml;

    return tr;
  },

  viewItem: function (id) {
    if (!id) {
      return false;
    }

    messagesClient.get(id, function (data) {
      var tipo = data.tipo;
      if (tipo == "formacion") {
        tipo = "formacion continua";
      }
      var url_brochure = ` <a href="assets/brochures/${data.brochure}" target="_blank">${data.brochure}</a>`;
      var url_img = ` <img src='assets/img/services/${data.imagen}' style="width: 100%;" />`;
      document.getElementById("item-curse-name").innerText = data.nombre;
      document.getElementById("item-curse-img").innerHTML = url_img;
      document.getElementById("item-curse-hours").innerText = data.intensidad;
      document.getElementById("item-curse-type").innerText = tipo;
      document.getElementById("item-curse-modality").innerText = data.modalidad;
      document.getElementById("item-curse-file").innerHTML = url_brochure;
      document.getElementById("view-course").classList.add("d-block");
    });
  },

  /**
   * Muestra un modal con el detalle del mensaje y lo marca como leido en la bd
   */
  editItem: function (id) {
    if (!id) {
      return false;
    }

    messagesClient.get(id, function (data) {
      var inputID = $("#id_course");
      inputID.val(data.id);
      var inputTitular = $("#nombre");
      inputTitular.val(data.nombre);
      var inpuIntensidad = $("#intensidad");
      inpuIntensidad.val(data.intensidad);
      var inputModalidad = $("#modalidad");
      inputModalidad.val(data.modalidad);
      var inputFoto = $("#brochure-name");
      inputFoto.val(data.brochure);
      var inputImg = $("#imagen-name");
      inputImg.val(data.imagen);
      var selectCategoria = $("#tipo");
      selectCategoria.val(data.tipo);
      document.getElementById("message-datail").classList.add("d-block");
    });
  },

  viewModalDelete: function (id, name) {
    if (!id) {
      return false;
    }

    document.getElementById("item-news-name").innerText = name;
    document.getElementById("delete-news").classList.add("d-block");
    localStorage.setItem("id_news", id);

    /*  messagesClient.deleteNews(id, function (data) {
          console.log(id)
      }); */
  },

  removeItem: function () {
    if (!localStorage.getItem("id_news")) {
      return false;
    }
    let id_new = localStorage.getItem("id_news");

    messagesClient.deleteNews(id_new, function (data) {});
    document.getElementById("delete-news").classList.remove("d-block");
    window.location.reload();
  },

  /**
   * Guarda los cambios del modo edicion en la bd y devueve el elemento al modo solo lectura
   */
  hideItemDetailModal: function (id) {
    document.getElementById("delete-news").classList.remove("d-block");
  },
  hideItemUpdateModal: function (id) {
    document.getElementById("message-datail").classList.remove("d-block");
  },
  hideItemCreateModal: function (id) {
    document.getElementById("create-course").classList.remove("d-block");
  },
  hideItemViewModal: function (id) {
    document.getElementById("view-course").classList.remove("d-block");
  },
  updateNews: function () {
    if (
      document.getElementById("id_course").value.trim().length === 0 ||
      document.getElementById("nombre").value.trim().length === 0 ||
      document.getElementById("imagen-name").value.trim().length === 0 ||
      document.getElementById("intensidad").value.trim().length === 0 ||
      document.getElementById("modalidad").value.trim().length === 0 ||
      document.getElementById("brochure-name").value.trim().length === 0 ||
      document.getElementById("tipo").value.trim().length === 0
    ) {
      alert("Debes completar los campos para continuar");
      return false;
    }
    let dataset = {
      id: document.getElementById("id_course").value,
      nombre: document.getElementById("nombre").value,
      imagen: document.getElementById("imagen-file").value,
      intensidad: document.getElementById("intensidad").value,
      modalidad: document.getElementById("modalidad").value,
      brochure: document.getElementById("brochure-file").value,
      tipo: document.getElementById("tipo").value,
    };

    if (dataset.imagen == "") {
      dataset.imagen = document.getElementById("imagen-name").value;
    } else {
      dataset.imagen = document.getElementById("imagen-file").files[0];
    }

    if (dataset.brochure == "") {
      dataset.brochure = document.getElementById("brochure-name").value;
    } else {
      dataset.brochure = document.getElementById("brochure-file").files[0];
    }

    var dataBrochure;
    if (typeof dataset.brochure == "object") {
      dataBrochure = dataset.brochure.name;
    } else {
      dataBrochure = dataset.brochure;
    }
    var dataFoto;
    if (typeof dataset.imagen == "object") {
      dataFoto = dataset.imagen.name;
    } else {
      dataFoto = dataset.imagen;
    }
    $.ajax({
      method: "POST",
      url: application.service_url + "negocios_verdes.php",
      data: {
        action: "update",
        id: dataset.id,
        nombre: dataset.nombre,
        imagen: dataFoto,
        intensidad: dataset.intensidad,
        modalidad: dataset.modalidad,
        brochure: dataBrochure,
        tipo: dataset.tipo,
      },
    }).done(function (msg) {
      messagesClient.updateImageNews(dataset.brochure);
      messagesClient.updateImageCourse(dataset.imagen);
      if (msg.length == 0) {
        alert("Programa Actualizado");
        window.location.reload();
      } else {
        alert("Error actualizando la noticia, por favor intentar más tarde");
      }
    });
  },
  addServiceItem: function () {
    document.getElementById("create-course").classList.add("d-block");
  },
  addFormation: function () {
    if (
      document.getElementById("createName").value.trim().length === 0 ||
      document.getElementById("createIntensidad").value.trim().length === 0 ||
      document.getElementById("createBrochure-name").value.trim().length ===
        0 ||
      document.getElementById("createFormacion").value.trim().length === 0 ||
      document.getElementById("createImagen-name").value.trim().length === 0 ||
      document.getElementById("createModalidad").value.trim().length === 0
    ) {
      alert("Debes completar los campos para continuar");
      return false;
    }
    let dataset = {
      nombre: document.getElementById("createName").value,
      imagen: document.getElementById("createImagen-file").files[0],
      intensidad: document.getElementById("createIntensidad").value,
      modalidad: document.getElementById("createModalidad").value,
      brochure: document.getElementById("createBrochure-file").files[0],
      tipo: document.getElementById("createFormacion").value,
    };
    $.ajax({
      method: "POST",
      url: application.service_url + "negocios_verdes.php",
      data: {
        action: "create",
        nombre: dataset.nombre,
        imagen: dataset.imagen.name,
        intensidad: dataset.intensidad,
        modalidad: dataset.modalidad,
        brochure: dataset.brochure.name,
        tipo: dataset.tipo,
      },
    }).done(function (msg) {
      messagesClient.updateImageNews(dataset.brochure);
      messagesClient.updateImageCourse(dataset.imagen);
      alert("Programa creado");
      window.location.reload();
    });
  },
};

$(".form-file-simple .inputFileVisible").click(function () {
  $(this).siblings(".inputFileHidden").trigger("click");
});

$(".form-file-simple .inputFileHidden").change(function () {
  var filename = $(this)
    .val()
    .replace(/C:\\fakepath\\/i, "");
  $(this).siblings(".inputFileVisible").val(filename);
});

function prevPage() {
  if (current_page > 1) {
    current_page--;
    messagesClient.list();
  }
}

function nextPage() {
  let numberPages;
  if (localStorage.getItem("numberPages") !== undefined) {
    numberPages = localStorage.getItem("numberPages");
  }
  if (current_page < numberPages) {
    current_page++;
    messagesClient.list();
  }
}
