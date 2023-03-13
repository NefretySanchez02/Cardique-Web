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
      url: application.service_url + "noticias.php",
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
      url: application.service_url + "noticias.php",
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
      url: application.service_url + "noticias.php",
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
      url: application.service_url + "noticias.php",
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

  updateImageNews: function (item_id, foto) {
    var formData = new FormData();
    formData.append("image", foto);
    formData.append("action", "updateImage");
    formData.append("id", item_id);
    if (typeof formData.get("image") == "object") {
      $.ajax({
        url: application.service_url + "noticias.php",
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
    let name = itemData.titular;
    let slug = itemData.slug;
    let business = itemData.fecha_publicacion;

    let itemHtml = /*html*/ `        
          <td>
            <span class="service-name">${business}</span>
          </td>
          <td>
            <span class="d-block">${name}</span>
          </td>
          <td>
       
            <a class="text-info hover-effect" href="../view?slug=${slug}">
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
      var inputID = $("#id_news");
      inputID.val(data.id);
      var inputTitular = $("#titular");
      inputTitular.val(data.titular);
      var inputSlug = $("#slug");
      inputSlug.val(data.slug);
      var inputFoto = $("#foto-name");
      inputFoto.val(data.foto);
      quill.clipboard.dangerouslyPasteHTML(0, data.contenido);
      document.getElementById("message-datail").classList.add("d-block");
      var inputAutor = $("#autor");
      inputAutor.val(data.autor);
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
    document.getElementById("create-news").classList.remove("d-block");
  },
  updateNews: function () {
    if (
      document.getElementById("id_news").value.trim().length === 0 ||
      document.getElementById("titular").value.trim().length === 0 ||
      document.getElementById("slug").value.trim().length === 0 ||
      document.getElementById("foto-name").value.trim().length === 0 ||
      document.getElementById("autor").value.trim().length === 0
    ) {
      alert("Debes completar los campos para continuar");
      return false;
    }
    let dataset = {
      id: document.getElementById("id_news").value,
      titular: document.getElementById("titular").value,
      slug: document.getElementById("slug").value,
      foto: document.getElementById("foto-file").value,
      contenido: $("#contenido .ql-editor")[0].innerHTML,
      autor: document.getElementById("autor").value,
    };

    if (dataset.foto == "") {
      dataset.foto = document.getElementById("foto-name").value;
    } else {
      dataset.foto = document.getElementById("foto-file").files[0];
    }

    var dataFoto;
    if (typeof dataset.foto == "object") {
      dataFoto = dataset.foto.name;
    } else {
      dataFoto = dataset.foto;
    }
    $.ajax({
      method: "POST",
      url: application.service_url + "noticias.php",
      data: {
        action: "update",
        id: dataset.id,
        titular: dataset.titular,
        slug: dataset.slug,
        foto: dataFoto,
        contenido: dataset.contenido,
        autor: dataset.autor,
      },
    }).done(function (msg) {
      messagesClient.updateImageNews(dataset.id, dataset.foto);
      if (msg.length == 0) {
        alert("Noticia Actualizada");
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
      document.getElementById("createTitular").value.trim().length === 0 ||
      document.getElementById("createSlug").value.trim().length === 0 ||
      document.getElementById("createFoto-name").value.trim().length === 0 ||
      document.getElementById("createAutor").value.trim().length === 0
    ) {
      alert("Debes completar los campos para continuar");
      return false;
    }
    if ($("#contenidoCreate .ql-editor")[0].innerHTML == "<p><br></p>") {
      alert("Debes completar el campo de contenido para continuar");
      return false;
    }
    let dataset = {
      titular: document.getElementById("createTitular").value,
      slug: document.getElementById("createSlug").value,
      foto: document.getElementById("createFoto-file").files[0],
      contenido: $("#contenidoCreate .ql-editor")[0].innerHTML,
      autor: document.getElementById("createAutor").value,
    };
    $.ajax({
      method: "POST",
      url: application.service_url + "noticias.php",
      data: {
        action: "create",
        titular: dataset.titular,
        slug: dataset.slug,
        foto: dataset.foto.name,
        contenido: dataset.contenido,
        autor: dataset.autor,
      },
    }).done(function (msg) {
      messagesClient.updateImageNews(dataset.id, dataset.foto);
      alert("Noticia creada");
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
