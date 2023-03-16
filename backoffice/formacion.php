<?php
require_once 'web-snippets.php';
session_control();
?>

<!doctype html>
<html lang="es">

<head>
  <?php echo html_head() ?>

  <style>
    .hide {
      display: none !important;
    }

    .input-hidden {
      visibility: hidden;
      position: absolute;
      z-index: -1;
    }

    .pendiente {
      background-color: #f1f1f1;
    }
  </style>
  <link href="https://cdn.quilljs.com/1.1.6/quill.snow.css" rel="stylesheet">
</head>

<body>
  <div class="wrapper ">
    <?php echo sidebar("contact") ?>
    <div class="main-panel">
      <!-- Navbar -->
      <?php echo top_bar("Noticias") ?>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <!-- your content here -->

          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-info">
                  <h4 class="card-title ">Directorio de Negocios Verdes</h4>
                  <p class="card-category">Directorio de Negocios Verdes agregadas en el sistema.</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-info">
                        <th class="text-left">Nombre</th>
                        <th class="text-left">Categoria</th>
                        <th class="text-left">Opciones</th>
                      </thead>
                      <tbody id="news-wrapper">

                      </tbody>
                    </table>
                    <div class="text-center">
                      <a href="javascript:prevPage()" class="text-info" id="btn_prev"> <i
                          class="material-icons">arrow_circle_left</i> Anterior</a>
                      <span id="page"></span>
                      <a href="javascript:nextPage()" class="text-info" id="btn_next">Siguiente <i
                          class="material-icons">arrow_circle_right</i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div id="message-datail" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 id="item-message-subject" class="modal-title">Editar Información Negocio</h5>
                  <button type="button" class="close" onclick="messagesUIManager.hideItemUpdateModal()">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form class="mb-4" method="post" action="javascript:void(0);" enctype="multipart/form-data">
                    <div class="row">
                      <input id="id_negocio" type="text" class="d-none" />
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Nombre:</strong></label>
                          <input id="nombre" type="text" class="form-control px-2" name="nombre">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Descripción:</strong></label>
                          <textarea class="form-control px-2" id="descripcion"></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Ubicación:</strong></label>
                          <input id="ubicacion" type="text" class="form-control px-2" name="ubicacion">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group form-file-upload form-file-simple">
                          <label class="text-info"><strong>Logo:</strong></label>
                          <input id="imagen-name" type="text" class="form-control inputFileVisible">
                          <input id="imagen-file" type="file" class="inputFileHidden"
                            accept="image/png, image/jpg, image/jpeg">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Codigo Plus:</strong></label>
                          <input id="codigo-plus" type="text" class="form-control px-2" name="codigo_plus">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Link Ubicacion(Link de Google Maps):</strong></label>
                          <input id="link-ubicacion" type="url" class="form-control px-2" name="codigo_plus">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Categoria:</strong></label>
                          <select name="categoria" class="form-control selectpicker" data-style="btn btn-link"
                            id="categoria">
                            <option value="Bioproductos y servicios sostenibles">Bioproductos y servicios sostenibles
                            </option>
                            <option value="Ecoproductos Industriales">Ecoproductos Industriales</option>
                            <option value="Acción climatica">Acción climatica</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Zona:</strong></label>
                          <input id="zona" type="text" class="form-control px-2" name="zona">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Facebook (Url de Facebook):</strong></label>
                          <input id="facebook" type="url" class="form-control px-2" name="facebook">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Instragram (Url de Instragram):</strong></label>
                          <input id="instragram" type="url" class="form-control px-2" name="instragram">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Whatsapp (Url de Whatsapp):</strong></label>
                          <input id="whatsapp" type="url" class="form-control px-2" name="whatsapp">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Email:</strong></label>
                          <input id="emial" type="email" class="form-control px-2" name="emial">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Pagina Web:</strong></label>
                          <input id="web" type="url" class="form-control px-2" name="web">
                        </div>
                      </div>
                      <div id="submit-button" class="col-12">
                        <button class="btn btn-info" type="buttom" onclick="messagesUIManager.updateNews()">
                          <span>Editar</span>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary"
                    onclick="messagesUIManager.hideItemUpdateModal()">Cerrar</button>
                </div>
              </div>
            </div>
          </div>

          <div id="view-course" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 id="item-message-subject" class="modal-title">Ver Negocio Verde</h5>
                  <button type="button" class="close" onclick="messagesUIManager.hideItemViewModal()">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <label class="d-block">
                    <strong class="text-info">Nombre:</strong> <span id="item-name"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Descripción:</strong> <span id="item-descripcion"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Ubicación:</strong> <span id="item-ubicacion"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Logo:</strong> <span id="item-foto"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Codigo Plus:</strong> <span id="item-codigo_plus"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Link Ubicación:</strong> <span id="item-link_ubicacion"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Categoria:</strong> <span id="item-categoria"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Zona:</strong> <span id="item-zona"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Facebook:</strong> <span id="item-facebook"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Instagram:</strong> <span id="item-instagram"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Whatsapp:</strong> <span id="item-whatsapp"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Correo:</strong> <span id="item-email"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Pagina Web:</strong> <span id="item-web"></span>
                  </label>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary"
                    onclick="messagesUIManager.hideItemViewModal()">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php echo footer() ?>
    </div>
  </div>

  <?php echo scripts() ?>

  <script src="./assets/js/formacion.js"></script>
  <script>
    messagesClient.init();

  </script>
</body>

</html>