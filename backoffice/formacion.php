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
                        <th class="text-left">Tipo de formacíon</th>
                        <th class="text-left">Categoria</th>
                      </thead>
                      <tbody id="news-wrapper">

                      </tbody>
                    </table>
                    <div class="text-center">
                    <a href="javascript:prevPage()" class="text-info" id="btn_prev"> <i class="material-icons">arrow_circle_left</i> Anterior</a>
                    <span id="page"></span>
                    <a href="javascript:nextPage()" class="text-info" id="btn_next">Siguiente  <i class="material-icons">arrow_circle_right</i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div id="delete-news" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 id="item-message-subject" class="modal-title">Eliminar Programa</h5>
                  <button type="button" class="close" onclick="messagesUIManager.hideItemDetailModal()">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>¿Desea cancelar el programa <span id="item-news-name"></span>?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" onclick="messagesUIManager.removeItem()">Aceptar</button>
                  <button type="button" class="btn btn-info"
                    onclick="messagesUIManager.hideItemDetailModal()">Cancelar</button>
                </div>
              </div>
            </div>
          </div>



          <div id="message-datail" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 id="item-message-subject" class="modal-title">Editar Programa</h5>
                  <button type="button" class="close" onclick="messagesUIManager.hideItemUpdateModal()">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form class="mb-4" method="post" action="javascript:void(0);" enctype="multipart/form-data">
                    <div class="row">
                      <input id="id_course" type="text" class="d-none" />
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Nombre:</strong></label>
                          <input id="nombre" type="text" class="form-control px-2" name="nombre">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group form-file-upload form-file-simple">
                          <label class="text-info"><strong>Imagen:</strong></label>
                          <input id="imagen-name" type="text" class="form-control inputFileVisible">
                          <input id="imagen-file" type="file" class="inputFileHidden"
                            accept="image/png, image/jpg, image/jpeg">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Intensidad Horaria:</strong></label>
                          <input id="intensidad" type="text" class="form-control px-2" name="intensidad">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Modalidad:</strong></label>
                          <input id="modalidad" type="text" class="form-control px-2" name="modalidad">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group form-file-upload form-file-simple">
                          <label class="text-info"><strong>Brochure:</strong></label>
                          <input id="brochure-name" type="text" class="form-control inputFileVisible">
                          <input id="brochure-file" type="file" class="inputFileHidden"
                            accept="application/pdf, application/msword">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Tipo de Formacion:</strong></label>
                          <select name="tipo" class="form-control selectpicker" data-style="btn btn-link" id="tipo">
                            <option value="curso">Curso</option>
                            <option value="diplomado">Diplomado</option>
                            <option value="formacion">Formacion Continua</option>
                          </select>
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
          <div id="create-course" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 id="item-message-subject" class="modal-title">Crear Formacion</h5>
                  <button type="button" class="close" onclick="messagesUIManager.hideItemCreateModal()">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form class="mb-4" method="post" action="javascript:void(0);" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Nombre:</strong></label>
                          <input id="createName" type="text" class="form-control px-2" name="name" required>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group form-file-upload form-file-simple">
                          <label class="text-info"><strong>Imagen:</strong></label>
                          <input id="createImagen-name" type="text" class="form-control inputFileVisible">
                          <input id="createImagen-file" type="file" class="inputFileHidden"
                            accept="image/png, image/jpg, image/jpeg" required>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Intensidad Horaria:</strong></label>
                          <input id="createIntensidad" type="int" class="form-control px-2" name="intensidad" required>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group form-file-upload form-file-simple">
                          <label class="text-info"><strong>Modalidad:</strong></label>
                          <input name="modalidad" id="createModalidad" type="text" class="form-control px-2" required>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group form-file-upload form-file-simple">
                          <label class="text-info"><strong>Brochure:</strong></label>
                          <input id="createBrochure-name" type="text" class="form-control inputFileVisible">
                          <input id="createBrochure-file" type="file" class="inputFileHidden"
                            accept="application/pdf, application/msword" required>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Tipo de Formacion:</strong></label>
                          <select name="formacion" class="form-control selectpicker" data-style="btn btn-link"
                            id="createFormacion" required>
                            <option value="curso">Curso</option>
                            <option value="diplomado">Diplomado</option>
                            <option value="formacion">Formacion Continua</option>
                          </select>
                        </div>
                      </div>
                      <div id="submit-button" class="col-12">
                        <button class="btn btn-info" type="buttom" onclick="messagesUIManager.addFormation()">
                          <span>Crear</span>

                        </button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary"
                    onclick="messagesUIManager.hideItemCreateModal()">Cerrar
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div id="view-course" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 id="item-message-subject" class="modal-title">Ver Programa</h5>
                  <button type="button" class="close" onclick="messagesUIManager.hideItemViewModal()">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <label class="d-block">
                    <strong class="text-info">Nombre:</strong> <span id="item-curse-name"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Imagen:</strong> <span id="item-curse-img"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Intensidad Horaria:</strong> <span id="item-curse-hours"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Tipo de Formacion:</strong> <span id="item-curse-type"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Modalidad:</strong> <span id="item-curse-modality"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Brochure:</strong> <span id="item-curse-file"></span>
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