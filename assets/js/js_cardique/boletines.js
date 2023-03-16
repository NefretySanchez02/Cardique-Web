/**
 * Maneja las peticiones Ajax
 */
var newsClientCourse = {
  init: function () {
    newsClientCourse.list();
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


};

/**
 * Maneja el comportamiento de los elementos en pantalla
 */
var messagesUIManager = {
  drawList: function (dataset) {
    if (!dataset) {
      return false;
    }

    let messages = dataset.messages;

    let wrapper = document.getElementById("boletin-wrapper");
    wrapper.innerHTML = "";

    messages.forEach(function (msg) {
      wrapper.appendChild(messagesUIManager.drawItem(msg));
    });
  },

  drawItem: function (itemData) {
    if (!itemData) {
      return false;
    }

    let id = itemData.id;
    let name = itemData.nombre;
    let imagen = itemData.imagen;
    let boletin = itemData.boletin;

    let itemHtml = /*html*/ `    
                <div class="cards-news">
                  <a href="backoffice/assets/boletines/${boletin}" target="_blank">
                    <img src="backoffice/assets/img/services/${imagen}" alt=""
                  /></a>
                </div>
          `;

    let tr = document.createElement("div");
    tr.setAttribute(
      "class",
      "col-lg-4 col-md-4 col-sm-12 wow fadeInLeft animated"
    );
    tr.setAttribute("data-wow-delay", "200ms");
    tr.setAttribute("data-wow-duration", "1500ms");
    tr.innerHTML = itemHtml;

    return tr;
  },
};
