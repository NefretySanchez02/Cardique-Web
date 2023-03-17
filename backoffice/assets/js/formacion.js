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

  getImages: function (item_id, callback) {
    $.ajax({
      method: "GET",
      url: application.service_url + "imagenes_negocios.php",
      data: {
        action: "getByName",
        id_mapa: item_id,
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
   * Editar una noticia en la BD
   */

  updateLogo: function (foto) {
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

  createImages: function (foto) {
    var formData = foto;

    $.ajax({
      url: application.service_url + "imagenes_negocios.php",
      type: "POST",
      data: formData,
      mimeType: "multipart/form-data",
      dataType: "html",
      contentType: false,
      processData: false,
      success: function (msg, textStatus, jqXHR) {
        alert("Fotos Subidas al sistema");
        window.location.reload();
      },
      error: function (jqXHR, textStatus, errorThrown) {},
    });
    /*  */
  },

  deleteImgs: function (item_id, name, callback) {
    $.ajax({
      method: "POST",
      url: application.service_url + "imagenes_negocios.php",
      data: {
        action: "delete",
        id_item: item_id,
        name_img: name,
      },
    }).done(function (msg) {});
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
    let wrapper = document.getElementById("imgs-wrapper");
    messagesClient.get(id, function (data) {
      var id_mapa = data.id_Mapa;
      var url_img = ` <img src='assets/img/logos_negocios/${data.foto}'  />`;
      var url_link = `<a href="${data.link_ubicacion}" target="_blank">Google Maps</a>`;
      var url_face = `<a href="${data.facebook}" target="_blank">Facebook</a>`;
      var url_inst = `<a href="${data.instagram}" target="_blank">Instagram</a>`;
      var url_wpp = `<a href="${data.whatsapp}" target="_blank">Whatsapp</a>`;
      var url_web = `<a href="${data.web}" target="_blank">Pagina Web</a>`;
      document.getElementById("item-name").innerText = data.nombre;
      document.getElementById("item-descripcion").innerText = data.descripcion;
      document.getElementById("item-ubicacion").innerText = data.ubicacion;
      document.getElementById("item-foto").innerHTML = url_img;
      document.getElementById("item-codigo_plus").innerText = data.codigo_plus;
      document.getElementById("item-link_ubicacion").innerHTML = url_link;
      document.getElementById("item-categoria").innerText = data.categoria;
      document.getElementById("item-zona").innerText = data.zona;
      document.getElementById("item-facebook").innerHTML = url_face;
      document.getElementById("item-instagram").innerHTML = url_inst;
      document.getElementById("item-whatsapp").innerHTML = url_wpp;
      document.getElementById("item-email").innerHTML = data.mail;
      document.getElementById("item-web").innerHTML = url_web;
      messagesClient.getImages(id_mapa, function (info) {
        let messages = info;
        messages.forEach(function (data) {
          let id = data.id;
          let img = data.imagen;
          let itemHtml = /*html*/ `        
              <td>
                <img src="assets/img/img_negocios/${img}" style="width: 200px;"/>
              </td>
              <td>
                <a class="text-info hover-effect" onclick="messagesUIManager.viewModalDelete('${id}', '${img}')">
                <i class="material-icons">do_not_disturb_alt</i>
              </a>
            </td>
          `;
          let tr = document.createElement("tr");
          tr.innerHTML = itemHtml;
          wrapper.appendChild(tr);
        });
      });
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
      var inputID = $("#id_negocio");
      inputID.val(data.id);
      var inputTitular = $("#nombre");
      inputTitular.val(data.nombre);
      var textareaDesc = $("#descripcion");
      textareaDesc.val(data.descripcion);
      var inpuIntensidad = $("#ubicacion");
      inpuIntensidad.val(data.ubicacion);
      var inputModalidad = $("#imagen-name");
      inputModalidad.val(data.foto);
      var inputFoto = $("#codigo-plus");
      inputFoto.val(data.codigo_plus);
      var inputImg = $("#link-ubicacion");
      inputImg.val(data.link_ubicacion);
      var selectCategoria = $("#categoria");
      selectCategoria.val(data.categoria);
      var inputZona = $("#zona");
      inputZona.val(data.zona);
      var inputface = $("#facebook");
      inputface.val(data.facebook);
      var inputInsta = $("#instragram");
      inputInsta.val(data.instagram);
      var inputWpp = $("#whatsapp");
      inputWpp.val(data.whatsapp);
      var inputMail = $("#emial");
      inputMail.val(data.mail);
      var inputWeb = $("#web");
      inputWeb.val(data.web);
      var inputIdMap = $("#id_mapa");
      inputIdMap.val(data.id_Mapa);
      document.getElementById("message-datail").classList.add("d-block");
    });
  },

  removeItem: function () {
    if (!localStorage.getItem("id_img_delete")) {
      return false;
    }
    if (!localStorage.getItem("name_img_delete")) {
      return false;
    }
    let id_new = localStorage.getItem("id_img_delete");
    let name_img = localStorage.getItem("name_img_delete");

    messagesClient.deleteImgs(id_new, name_img, function (data) {});
    window.location.reload();
  },

  viewModalDelete: function (id, name) {
    if (!id) {
      return false;
    }
    messagesUIManager.hideItemViewModal();
    document.getElementById("delete-img").classList.add("d-block");
    localStorage.setItem("id_img_delete", id);
    localStorage.setItem("name_img_delete", name);
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
  hideItemViewModal: function (id) {
    document.getElementById("view-course").classList.remove("d-block");
    document.getElementById("imgs-wrapper").innerHTML = "";
  },
  hideItemDeleteModal: function (id) {
    document.getElementById("delete-img").classList.remove("d-block");
  },
  updateNews: function () {
    let dataset = {
      id: document.getElementById("id_negocio").value,
      nombre: document.getElementById("nombre").value,
      descripcion: document.getElementById("descripcion").value,
      ubicacion: document.getElementById("ubicacion").value,
      logo: document.getElementById("imagen-file").value,
      codigo_plus: document.getElementById("codigo-plus").value,
      link_ubicacion: document.getElementById("link-ubicacion").value,
      categoria: document.getElementById("categoria").value,
      zona: document.getElementById("zona").value,
      facebook: document.getElementById("facebook").value,
      instagram: document.getElementById("instragram").value,
      whatsapp: document.getElementById("whatsapp").value,
      email: document.getElementById("emial").value,
      web: document.getElementById("web").value,
    };
    if (dataset.logo == "") {
      dataset.logo = document.getElementById("imagen-name").value;
    } else {
      dataset.logo = document.getElementById("imagen-file").files[0];
    }
    var dataFoto;
    if (typeof dataset.logo == "object") {
      dataFoto = dataset.logo.name;
    } else {
      dataFoto = dataset.logo;
    }
    $.ajax({
      method: "POST",
      url: application.service_url + "negocios_verdes.php",
      data: {
        action: "update",
        id: dataset.id,
        nombre: dataset.nombre,
        descripcion: dataset.descripcion,
        ubicacion: dataset.ubicacion,
        foto: dataFoto,
        codigo_plus: dataset.codigo_plus,
        link_ubicacion: dataset.link_ubicacion,
        categoria: dataset.categoria,
        zona: dataset.zona,
        facebook: dataset.facebook,
        instagram: dataset.instagram,
        whatsapp: dataset.whatsapp,
        email: dataset.email,
        web: dataset.web,
      },
    }).done(function (msg) {
      messagesClient.updateLogo(dataset.logo);
      if (msg.length == 0) {
        alert("Informacion de Negocio Actualizada");
        window.location.reload();
      } else {
        alert("Error actualizando la noticia, por favor intentar más tarde");
      }
    });
  },

  //Funciones para la carga de imagenes
  createImgs: function () {
    var form_data = new FormData();
    var totalfiles = document.getElementById("img-files").files.length;
    var id_mapa = document.getElementById("id_mapa").value;
    if (totalfiles > 5) {
      alert("Solo se pueden subir maximo 5 fotos al sistema por negocio");
      return false;
    }
    for (var index = 0; index < totalfiles; index++) {
      form_data.append(
        "files[]",
        document.getElementById("img-files").files[index]
      );
    }
    form_data.append("action", "create");
    form_data.append("id_mapa", id_mapa);
    messagesClient.createImages(form_data);
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

$(
  ".form-file-multiple .inputFileVisible, .form-file-multiple .input-group-btn"
).click(function () {
  $(this).parent().parent().find(".inputFileHidden").trigger("click");
  $(this).parent().parent().addClass("is-focused");
});

$(".form-file-multiple .inputFileHidden").change(function () {
  var names = "";
  for (var i = 0; i < $(this).get(0).files.length; ++i) {
    if (i < $(this).get(0).files.length - 1) {
      names += $(this).get(0).files.item(i).name + ",";
    } else {
      names += $(this).get(0).files.item(i).name;
    }
  }
  $(this).siblings(".input-group").find(".inputFileVisible").val(names);
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
