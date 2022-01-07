<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <title>Hello, world!</title>
  </head>
  <body>
   <section class="contact-box">
       <div class="row no-gutters bg-dark">
           <div class="col-xl-5 col-lg-12 register-bg">
            <div class="position-absolute testiomonial p-4">
                <h3 class="font-weight-bold text-light">Centro de Aprendizaje Learclass aaaa</h3>
                <p class="lead text-light">Estudia Sin Limites</p>
            </div>
           </div>
           <div class="col-xl-7 col-lg-12 d-flex">
                <div class="container align-self-center p-6">
                    <h1 class="font-weight-bold mb-3">Inscripción</h1>
                    <form action="{{route('registrar.store')}}" method="POST">
                        @csrf
                        <div class="form-row mb-2">
                            <div class="form-group col-md-4">
                                <input type="text" name="name" class="form-control" placeholder="Tu nombre">
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" name="lastname" class="form-control" placeholder="Tu apellido">
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" name="dni" class="form-control" placeholder="DNI">
                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="form-group col-md-4">
                                <input type="text" name="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" name="phone" class="form-control" placeholder="Celular">
                            </div>
                            <div class="form-group col-md-4">
                                <select class="form-select" name="country">
                                    <option value="PE"selected>Elegir el País</option>
                                    <option value="AR">Argentina</option>
                                    <option value="BO">Bolivia</option>
                                    <option value="CL">Chile</option>                                    <option value="3">Chile</option>
                                    <option value="CO">Colombia</option>
                                    <option value="CR">CR</option>
                                    <option value="EC">Ecuador</option>
                                    <option value="SV">El Salvador</option>
                                    <option value="GT">Guatamala</option>
                                    <option value="HN">Hondura</option>
                                    <option value="NI">Nicaragua</option>
                                    <option value="PA">Panama</option>
                                    <option value="PY">Paraguay</option>
                                    <option value="PE">Peru</option>
                                    <option value="CR">Puerto Rico</option>
                                    <option value="DO">Republica Dominicana</option>
                                    <option value="UY">Uruguay</option>
                                    <option value="VE">Venezuela</option>
                                    <option value="EU">E.E.U.U</option>
                                  </select>
                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="form-group col-md-5">
                                <select class="form-select" name="agente">
                                    <option value="noindico"selected>Banco/Agencia</option>
                                    <option value="AR">Banco de la Nación</option>
                                    <option value="BBVA">BBVA</option>
                                    <option value="BCP">BCP</option>
                                    <option value="Directo Pago">Directo Pago</option>
                                    <option value="Interbank">Interbank</option>
                                    <option value="MoneyGram">MoneyGram</option>
                                    <option value="Paypal">Paypal</option>
                                    <option value="Plim">Plim</option>
                                    <option value="Scotiabank">Scotiabank</option>
                                    <option value="Wester Unión">Wester Unión</option>
                                    <option value="Yape">Yape</option>
                                  </select>
                            </div>
                            <div class="form-group col-md-5">
                                <select class="form-select" name="tipo">
                                    <option value="soles"selected>Elegir Moneda</option>
                                    <option value="soles">Solos</option>
                                    <option value="dolares">Dolares</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="monto" placeholder="soles">
                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="form-group col-md-6">
                                <input type="date" class="form-control" name="fechapago">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="comprobante" placeholder="Numero de Comprobante">
                            </div>
                        </div>
                        <div class="form-group mb-5">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label text-muted">Al seleccionar esta casilla aceptas nuestro aviso de privacidad y los términos y condiciones</label>
                            </div>
                        </div>
                        <button class="btn btn-primary width-100" type="submit">Regístrate</button>
                    </form>
                    <small class="d-inline-block text-muted mt-5">Todos los derechos reservados | ©2022 Learclass</small>
                </div>
           </div>
       </div>
   </section>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>