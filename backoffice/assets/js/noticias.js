/**
 * Maneja las peticiones Ajax
 */

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
      url: application.service_url + "boletines.php",
      data: { action: "list" },
    }).done(function (msg) {
      application.log(msg);

      let data = application.parseJson(msg);

      if (data.success == 1) {
        messagesUIManager.drawList(data);
      }
    });
  },

  /**
   * Obtiene mediante consulta un mensajes desde BD
   */
  get: function (item_id, callback) {
    $.ajax({
      method: "GET",
      url: application.service_url + "boletines.php",
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
   * Actualiza el estado del mensaje en BD
   */
  markAsRead: function (item_id, callback) {
    $.ajax({
      method: "POST",
      url: application.service_url + "boletines.php",
      data: {
        action: "markasviewed",
        mid: item_id,
      },
    }).done(function (msg) {
      application.log(msg);

      let data = application.parseJson(msg);

      if (data.success == 1) {
        callback();
      }
    });
  },

  /**
   * Eliminar una noticia en la BD
   */

  deleteNews: function (item_id, callback) {
    $.ajax({
      method: "POST",
      url: application.service_url + "boletines.php",
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

  updateImageBoletin: function (foto) {
    var formData = new FormData();
    formData.append("image", foto);
    formData.append("action", "updatePhoto");
    if (typeof formData.get("image") == "object") {
      $.ajax({
        url: application.service_url + "boletines.php",
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

  updateBoletin: function (file) {
    var formData = new FormData();
    formData.append("file", file);
    formData.append("action", "updateFile");
    if (typeof formData.get("file") == "object") {
      $.ajax({
        url: application.service_url + "boletines.php",
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
  drawList: function (dataset) {
    if (!dataset) {
      return false;
    }

    let messages = dataset.messages;

    let wrapper = document.getElementById("news-wrapper");
    wrapper.innerHTML = "";

    messages.forEach(function (msg) {
      wrapper.appendChild(messagesUIManager.drawItem(msg));
    });
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
    let imagen = itemData.imagen;
    let boletin = itemData.boletin;

    let itemHtml = /*html*/ `        
          <td>
            <span class="service-name">${name}</span>
          </td>
          <td>
            <a class="text-info hover-effect" onclick="messagesUIManager.viewModalItem('${id}')">
              <i class="material-icons">visibility</i>
            </a>
            <a class="text-info hover-effect" onclick="messagesUIManager.editItem('${id}')">
            <i class="material-icons">mode_edit</i>
          </a>
          <a class="text-info hover-effect" onclick="messagesUIManager.viewModalDelete('${id}','${name}')">
            <i class="material-icons">do_not_disturb_alt</i>
          </a>
          
        </td>
         
      `;

    let tr = document.createElement("tr");
    tr.setAttribute("id", "serv-item-" + id);
    tr.setAttribute("class", status);
    tr.innerHTML = itemHtml;

    return tr;
  },

  /**
   * Muestra un modal con el detalle del mensaje y lo marca como leido en la bd
   */
  editItem: function (id) {
    if (!id) {
      return false;
    }

    messagesClient.get(id, function (data) {
      var inputID = $("#id_boletin");
      inputID.val(data.id);
      var inputTitular = $("#edit-nombre");
      inputTitular.val(data.nombre);
      var inputSlug = $("#edit-img");
      inputSlug.val(data.imagen);
      var inputFoto = $("#edit-file");
      inputFoto.val(data.boletin);
      document.getElementById("message-datail").classList.add("d-block");
    });
  },

  viewModalDelete: function (id, name) {
    if (!id) {
      return false;
    }

    document.getElementById("item-news-name").innerText = name;
    document.getElementById("delete-news").classList.add("d-block");
    localStorage.setItem("id_boletin", id);

    /*  messagesClient.deleteNews(id, function (data) {
        console.log(id)
    }); */
  },

  removeItem: function () {
    if (!localStorage.getItem("id_boletin")) {
      return false;
    }
    let id_new = localStorage.getItem("id_boletin");

    messagesClient.deleteNews(id_new, function (data) {});
    document.getElementById("delete-news").classList.remove("d-block");
    window.location.reload();
  },

  viewModalItem: function (id) {
    if (!id) {
      return false;
    }

    messagesClient.get(id, function (data) {
      var inputTitular = $("#item-name");
      inputTitular[0].innerText = data.nombre;
      var inputSlug = $("#item-img");
      inputSlug[0].innerHTML = `<img src="assets/img/services/${data.imagen}" style="width: 100%;" />`;
      var inputFoto = $("#item-file");
      inputFoto[0].innerHTML = `<a href="assets/boletines/${data.boletin}" target="_blank" >${data.boletin}</a>`;
      document.getElementById("view-boletin").classList.add("d-block");
    });
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
    document.getElementById("create-news").classList.remove("d-block");
  },
  hideItemViewModal: function (id) {
    document.getElementById("view-boletin").classList.remove("d-block");
  },
  updateNews: function () {
    if (
      document.getElementById("edit-nombre").value.trim().length === 0 ||
      document.getElementById("edit-img").value.trim().length === 0 ||
      document.getElementById("edit-file").value.trim().length === 0
    ) {
      alert("Debes completar los campos para continuar");
      return false;
    }
    let dataset = {
      id: document.getElementById("id_boletin").value,
      nombre: document.getElementById("edit-nombre").value,
      imagen: document.getElementById("edit-img-file").value,
      boletin: document.getElementById("edit-boletin-file").value,
    };

    if (dataset.imagen == "") {
      dataset.imagen = document.getElementById("edit-img").value;
    } else {
      dataset.imagen = document.getElementById("edit-img-file").files[0];
    }

    if (dataset.boletin == "") {
      dataset.boletin = document.getElementById("edit-file").value;
    } else {
      dataset.boletin = document.getElementById("edit-boletin-file").files[0];
    }

    var dataFoto;
    var dataBoletin;
    if (typeof dataset.imagen == "object") {
      dataFoto = dataset.imagen.name;
    } else {
      dataFoto = dataset.imagen;
    }

    if (typeof dataset.boletin == "object") {
      dataBoletin = dataset.boletin.name;
    } else {
      dataBoletin = dataset.boletin;
    }
    $.ajax({
      method: "POST",
      url: application.service_url + "boletines.php",
      data: {
        action: "update",
        id: dataset.id,
        nombre: dataset.nombre,
        imagen: dataFoto,
        boletin: dataBoletin,
      },
    }).done(function (msg) {
      messagesClient.updateImageBoletin(dataset.imagen);
      messagesClient.updateBoletin(dataset.boletin);
      if (msg.length == 0) {
        alert("Boletin Actualizado");
        window.location.reload();
      } else {
        alert("Error actualizando la noticia, por favor intentar más tarde");
      }
    });
  },
  addServiceItem: function () {
    document.getElementById("create-news").classList.add("d-block");
  },
  addNews: function () {
    if (
      document.getElementById("createNombre").value.trim().length === 0 ||
      document.getElementById("createFoto-name").value.trim().length === 0 ||
      document.getElementById("createBoletin-name").value.trim().length === 0
    ) {
      alert("Debes completar los campos para continuar");
      return false;
    }
    let dataset = {
      nombre: document.getElementById("createNombre").value,
      imagen: document.getElementById("createFoto-file").files[0],
      boletin: document.getElementById("createBoletin-file").files[0],
    };
    $.ajax({
      method: "POST",
      url: application.service_url + "boletines.php",
      data: {
        action: "create",
        nombre: dataset.nombre,
        imagen: dataset.imagen.name,
        boletin: dataset.boletin.name,
      },
    }).done(function (msg) {
      messagesClient.updateImageBoletin(dataset.imagen);
      messagesClient.updateBoletin(dataset.boletin);
      alert("Boletin creado");
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
