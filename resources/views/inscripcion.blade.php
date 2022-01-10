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
    <style>
        .btn-primary {
            color: #fff;
            background-color: #ff1053;
            border-color: #ff1053;
            font-size: x-large;
        }
        .form-control {
            color: white;
        }
        input#search {
    background: white;
    border: 2px solid var(--color-dark-xx);
    border-radius: 1rem;
    padding: 15px;
    font-family: cursive;
    font-size: larger;
    color : #495057;
}
    </style>
    <title>LearClass</title>
  </head>
  <body>
   <section class="contact-box">
       <div class="row no-gutters bg-dark">
           <div class="col-xl-5 col-lg-12 register-bg">
            <div class="position-absolute testiomonial p-4">
                <h3 class="font-weight-bold text-light"><!--titulo--></h3>
                <p class="lead text-light"><!--descripcion--></p>
            </div>
           </div>
           @livewire('consultar-inscripcion')
           @livewireScripts
       </div>
   </section>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    @if (session('crear') == 'Se Inscribio Correctamente')
    <script>
    Swal.fire(
    '!Felicidades¡',
    'Su Inscripción se realizo Correctamente',
    'Visitanos : https://learclass.com'
    )
    </script>
     @endif
    @if (session('crear') == 'actualización')
    <script>
    Swal.fire(
    '!Felicidades¡',
    'Su actualizo su Inscripcion',
    'Visitanos : https://learclass.com'
    )
    </script>
    @endif
   <script>
       $('.formulario-inscripcion').submit(function(e){
            e.preventDefault();
            Swal.fire({
  title: 'Confirmar su Inscripción',
  imageUrl: '../images/confirmar.jpg',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Confirmar'
}).then((result) => {
  if (result.isConfirmed) {
    this.submit();
  }
})
       });
       
   </script>
</body>
</html>