<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="Estilos/styles.css">

    <script src="Scripts/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="Scripts/busqueda.js"></script>
    <script src="popper/popper.min.js"></script>
    <title>Inventario</title>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#codigo").keyup(function() {
                this.value = (this.value + '').replace(/[^0-9]/g, '');
            });
            $("#autor").keyup(function() {
                this.value = (this.value + '').replace(/[^ a-záéíóúüñ]+/ig, '');
            });
            $("#nombre_libro").keyup(function() {
                this.value = (this.value + '').replace(/[^ a-záéíóúüñ]+/ig, '');
            });
            $("#precio_publico").keyup(function() {
                this.value = (this.value + '').replace(/[^0-9]/g, '');
            });
            $("#precio_interno").keyup(function() {
                this.value = (this.value + '').replace(/[^0-9]/g, '');
            });

            $('#modificar').click(function() {
                //validamos los campos que no esten vacios usamos length para verificar si hay algun caracter escrito en nuestro campo de texto si es menor a 1 entonces 
                //es falso y por lo tanto el campo es vacio
                if ($("#codigo").val().length < 1) {
                    alert("El campo codigo no puede ser vacio")
                    return false;
                } else if ($("#autor").val().length < 1) {
                    alert("El campo Autor no puede ser vacio")
                    return false;
                } else if ($("#nombre_libro").val().length < 1) {
                    alert("El campo Nombre del libro no puede ser vacio")
                    return false;
                } else if ($("#precio_publico").val().length < 1) {
                    alert("El campo Precio publico no puede ser vacio")
                    return false;
                } else if ($("#precio_interno").val().length < 1) {
                    alert("El campo Precio interno  no puede ser vacio")
                    return false;
                }
                var opcion = confirm('Realmente desea modificar el registro');
                if ((parseInt($('#precio_publico').val()) <= parseInt($('#precio_interno').val()))) {
                    alert("El precio publico no puede ser menor al precio interno");
                }
                if (opcion == true) {
                    $.ajax({
                        url: 'php/modificar.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            codigo: $('#codigo').val(),
                            autor: $('#autor').val(),
                            nombre_libro: $('#nombre_libro').val(),
                            fecha_expedicion: $('#fecha_expedicion').val(),
                            disponibilidad: $('#disponibilidad').val(),
                            precio_publico: $('#precio_publico').val(),
                            precio_interno: $('#precio_interno').val(),
                            reservado: $('#reservado').val(),
                            cantidad: $('#cantidad').val(),
                        },
                        //Traemos la respuesta de retorno en caso de que los datos se modifiquen correctamente en formato json
                        success: function(response) {
                            if (response.success == true) {
                                alert(response.message);
                                location.reload();
                            }
                        },
                        error: function(response) {
                            debugger;
                            alert("Verifique el codigo del libro e intente de nuevo");
                        }
                    });

                } else {
                    return false;
                }
            })
        });
    </script>
</head>

<body>
    <div class="container">
        <br>
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="#">Biblioteca</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-item nav-link active" href="index.php">Inicio<span class="sr-only">(current)</span></a>
                        <a class="nav-item nav-link active" href="registro_libro.php">Registro Libro</a>
                        <a class="nav-item nav-link active" href="inventario.php">Inventario</a>
                    </div>
                </div>
            </nav>
        </header>
        <br>
        <br>
    </div>
    <section>
        <div class="container-fluid">
            <div class="background">
                <br>
                <label for="criterio_busqueda">Buscar</label>
                <input type="text" name="criterio_busqueda" class="fs fas-search" id="criterio_busqueda"></input>
                <div class="contenedor">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Código Libro</td>
                                <td>Autor</td>
                                <td>Nombre Libro</td>
                                <td>Fecha Expedición</td>
                                <td>Disponibilidad</td>
                                <td>Precio Publico</td>
                                <td>Precio Interno</td>
                                <td>Reservado</td>
                                <td>Cantidad</td>
                                <td>Eliminar</td>
                                <td>Editar</td>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                        </tbody>
                    </table>
                </div>

                <!-- Modal modificar registro libro-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Modificar el libro seleccionado</h4>
                            </div>
                            <div class="modal-body" class="form-control input-sm">
                                <label for="">Codígo Libro</label>
                                <input type="text" name="" id="codigo" class="form-control input-sm">
                                <label for="">Autor</label>
                                <input type="text" name="" id="autor" class="form-control input-sm">
                                <label for="">Nombre Libro</label>
                                <input type="text" name="" id="nombre_libro" class="form-control input-sm">
                                <label for="">Fecha Expedición</label>
                                <input type="text" name="" id="fecha_expedicion" class="form-control input-sm">
                                <label for="">Disponibilidad</label>
                                <input type="text" name="" id="disponibilidad" class="form-control input-sm">
                                <label for="">Precio Publico</label>
                                <input type="text" name="" id="precio_publico" class="form-control input-sm">
                                <label for="">Precio Interno</label>
                                <input type="text" name="" id="precio_interno" class="form-control input-sm">
                                <label for="">Reservado</label>
                                <input type="text" name="" id="reservado" class="form-control input-sm">
                                <label for="">Cantidad</label>
                                <input type="text" name="" id="cantidad" class="form-control input-sm">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="modificar" class="btn btn-success" data-dismiss="modal">Modificar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <footer></footer>
</body>

</html>