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
  list: function (indexPageFlag = false) {
    $.ajax({
      method: "GET",
      url: application.service_url + "negocios_verdes.php",
      data: { action: "list" },
    }).done(function (msg) {
      //   let data = application.parseJson(msg);
    });
  },

  get: function (slug, callback) {
    $.ajax({
      method: "GET",
      url: application.service_url + "negocios_verdes.php",
      data: {
        action: "getByName",
        id_mapa: slug,
      },
    }).done(function (msg) {
      let data = application.parseJson(msg);
      if (data.success == 1) {
        callback(data.news_item);
      }
    });
  },
};

/**
 * Maneja el comportamiento de los elementos en pantalla
 */
var messagesUIManagerCourse = {
  drawItem: function (id) {
    let itemHTML = "";
    let wrapper = document.getElementById(id);
    newsClientCourse.get(id, function (data) {
      let nombre = data[0].nombre;
      let foto = data[0].foto;
      let descripcion = data[0].descripcion;
      let categortia = data[0].categoria;
      let ubicacion = data[0].ubicacion;
      let codigo = data[0].codigo_plus;
      let facebook = data[0].facebook;
      let instagram = data[0].instagram;
      let whatsapp = data[0].whatsapp;
      let email = data[0].mail;
      let link_maps = data[0].link_ubicacion
      let logo_categoria;
      if (categortia == "Bioproductos y servicios sostenibles") {
        logo_categoria = "Grupo 4128.png";
      } else if (categortia == "Ecoproductos Industriales") {
        logo_categoria = "Grupo 4127.png";
      } else {
        logo_categoria = "Grupo 4126.png";
      }
      if (facebook.length == 0) {
        facebook = "#";
      }
      itemHTML = `<foreignobject
      class="wow-star__text"
      width="70%"
      height="70%"
      transform="translate(-300,30)"
    >
      <body xmlns="http://www.w3.org/1999/xhtml">
        <div class="view-directory d-block" id="view-directory-${id}">
          <div class="clasify">
            <span onclick="remove_modal('${id}')">
              <img
                src="assets/images/img_cardique/Grupo 4162.png"
                alt=""
              />
            </span>
            <p onclick="remove_modal('${id}')">Cerrar</p>
          </div>
          <div class="header-modal">
            <div  class="title">
              <img
              src="logos_mapa/${foto}"
              alt=""
            />
            <h2>${nombre}</h2>
            </div>
            <div>
              <img src="assets/images/img_cardique/${logo_categoria}" alt="">
            </div>
          
          </div>
          <div class="text">
            <p>${descripcion}</p>
          </div>
          <div class="info">
            <div class="row">
              <div class="col-lg-5 col-md-5 col-sm-5">
                <h2>Ubicación</h2>
                <p>${ubicacion}, Bolívar</p>
              </div>
              <div class="col-lg-5 col-md-5 col-sm-5">
                <h2>Código Plus</h2>
                <p><a href="${link_maps}" target="_blank">${codigo}</a></p>
              </div>
            </div>
          </div>
          <div class="services">
            <h2>Nuestros productos/Servicios</h2>
            <div class="services-images">
              <div class="service-block-img"></div>
              <div class="service-block-img"></div>
              <div class="service-block-img"></div>
              <div class="service-block-img"></div>
              <div class="service-block-img"></div>
            </div>
          </div>
          <div class="directory-footer">
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 links-block">
                <span class="facebook">
                    <a href="${facebook}"> 
                        <img src="assets/images/img_cardique/Trazado 7524.png" alt="">
                    </a>
                </span>
                <span class="instagram">
                <a href="${instagram}" target="_blank"> 
                  <img src="assets/images/img_cardique/Trazado 7523.png" alt="">
                 
                </span>
                <span class="whatsapp">
                 <a href="${whatsapp}" target="_blank"> 
                  <img src="assets/images/img_cardique/Grupo 4060.png" alt="">
                   </a>
                </span>
                <span class="email">
                <a href="mailto:${email}" target="_blank"> 
                    <img src="assets/images/img_cardique/Grupo 4059.png" alt="">
                    </a>
                </span>
              </div>
              <div
                class="col-lg-6 col-md-6 col-sm-6 link-products"
              >
                <a role="button" href="${whatsapp}" target="_blank" class="theme-btn-one">
                  <span><i class="fa fa-shopping-cart"></i></span>
                  Adquirir productos/servicios
                </a>
              </div>
            </div>
          </div>
        </div>
      </body>
    </foreignobject> `;
      wrapper.insertAdjacentHTML("beforeend", itemHTML);
    });
  },
};
