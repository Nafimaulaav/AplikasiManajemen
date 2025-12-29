 <!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Karsadia Management</title>

   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   <script type="module" src="{{ asset('js/app.js') }}"></script>
    


   <link rel="stylesheet" href="{{ asset('css/header.css') }}">
   <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
   <link rel="stylesheet" href="{{ asset('css/content.css') }}">
   <link rel="stylesheet" href="{{ asset('css/greenhouse.css') }}">
   <link rel="stylesheet" href="{{ asset('css/laporan.css') }}">
   <link rel="stylesheet" href="{{ asset('css/detailgh.css') }}">
   <link rel="stylesheet" href="{{ asset('css/panen.css') }}">
 </head>

 @if (session('success'))
 <div class="modal fade" id="successModal" tabindex="-1">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center">
         <div class="modal-body p-4">
            <i class="bi bi-check-circle-fill text-success fs-1 mb-6"></i>
            <h4 class="fw-bold mt-4">Berhasil</h4>
            <p>{{ session('success') }}</p>
            <button class="btn btn-success mt-3" data-bs-dismiss="modal">
               OK
            </button>
         </div>
      </div>
   </div>
 </div>
 
 @endif
 
 <body>
   <div class="layout-wrapper">
      @include('partials.header')

      <div class="layout-main">
         @include('partials.sidebar')

         <div class="content">
            @yield('content')
         </div>
      </div>
   </div>
 </body>
 <script>
   document.addEventListener('DOMContentLoaded', function() {
      const successModal = document.getElementById('successModal');
      if(successModal){
         const modal = new bootstrap.Modal(successModal);
         modal.show();
      }

   });
 </script>
 </html>