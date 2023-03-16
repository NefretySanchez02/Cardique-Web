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
</head>

<body>
  <div class="wrapper ">
    <?php echo sidebar("news") ?>
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
                  <h4 class="card-title ">Bandeja de boletines</h4>
                  <p class="card-category">Listado de boletines agregadas en el sistema.</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-info">
                        <th class="text-left">Nombre</th>
                        <th class="text-left">Opciones</th>
                      </thead>
                      <tbody id="news-wrapper">

                      </tbody>
                    </table>

                    <div class="text-right">
                      <a id="add-serv" class="text-info text-hover-effect py-4 pr-2" style="float: right;"
                        onclick="messagesUIManager.addServiceItem()">
                        <i class="material-icons">add_circle_outline</i> Agregar boletin
                      </a>
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
                  <h5 id="item-message-subject" class="modal-title">Eliminar Boletin</h5>
                  <button type="button" class="close" onclick="messagesUIManager.hideItemDetailModal()">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>¿Desea eliminar el boletin <span id="item-news-name"></span>?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" onclick="messagesUIManager.removeItem()">Aceptar</button>
                  <button type="button" class="btn btn-info"
                    onclick="messagesUIManager.hideItemDetailModal()">Cancelar</button>
                </div>
              </div>
            </div>
          </div>

          <div id="view-boletin" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 id="item-message-subject" class="modal-title">Mostrar Boletin</h5>
                  <button type="button" class="close" onclick="messagesUIManager.hideItemViewModal()">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <label class="d-block">
                    <strong class="text-info">Nombre:</strong> <span id="item-name"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Imagen:</strong> <span id="item-img"></span>
                  </label>
                  <label class="d-block">
                    <strong class="text-info">Boletin:</strong> <span id="item-file"></span>
                  </label>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-info"
                    onclick="messagesUIManager.hideItemViewModal()">Cerrar</button>
                </div>
              </div>
            </div>
          </div>

          <div id="message-datail" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 id="item-message-subject" class="modal-title">Editar Boletin</h5>
                  <button type="button" class="close" onclick="messagesUIManager.hideItemUpdateModal()">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form class="mb-4" method="post" action="javascript:void(0);" enctype="multipart/form-data">
                    <div class="row">
                      <input id="id_boletin" type="text" class="d-none" />
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group">
                          <label class="text-info"><strong>Nombre:</strong></label>
                          <input id="edit-nombre" type="text" class="form-control px-2" name="titular">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group form-file-upload form-file-simple">
                          <label class="text-info"><strong>Imagen:</strong></label>
                          <input id="edit-img" type="text" class="form-control inputFileVisible">
                          <input id="edit-img-file" type="file" class="inputFileHidden"
                            accept="image/png, image/jpg, image/jpeg">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group form-file-upload form-file-simple">
                          <label class="text-info"><strong>Boletin:</strong></label>
                          <input id="edit-file" type="text" class="form-control inputFileVisible">
                          <input id="edit-boletin-file" type="file" class="inputFileHidden"
                          accept="application/pdf, application/msword">
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
          <div id="create-news" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 id="item-message-subject" class="modal-title">Crear Boletín</h5>
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
                          <input id="createNombre" type="text" class="form-control px-2" name="nombre" required>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group form-file-upload form-file-simple">
                          <label class="text-info"><strong>Imagen:</strong></label>
                          <input id="createFoto-name" type="text" class="form-control inputFileVisible">
                          <input id="createFoto-file" type="file" class="inputFileHidden"
                            accept="image/png, image/jpg, image/jpeg" required>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group bmd-form-group form-file-upload form-file-simple">
                          <label class="text-info"><strong>Boletin:</strong></label>
                          <input id="createBoletin-name" type="text" class="form-control inputFileVisible">
                          <input id="createBoletin-file" type="file" class="inputFileHidden"
                            accept="application/pdf, application/msword" required>
                        </div>
                      </div>
                      <div id="submit-button" class="col-12">
                        <button class="btn btn-info" type="buttom" onclick="messagesUIManager.addNews()">
                          <span>Crear</span>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary"
                    onclick="messagesUIManager.hideItemCreateModal()">Cerrar</button>
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
  <script src="./assets/js/noticias.js"></script>
  <script>
    messagesClient.init();
  </script>
</body>

</html>