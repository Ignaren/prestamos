
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- importar las librerías de bootstrap -->
    <link rel="stylesheet" href="{{ secure_asset('bootstrap-5.3.3-dist/css/bootstrap.min.css') }}" />

    <!-- importar Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- importar los archivos JavaScript de Bootstrap-->
    <script src="{{ secure_asset('bootstrap-5.3.3-dist/js/bootstrap.min.js') }}" defer></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <link href="{{ secure_asset('DataTables/datatables.min.css') }}" rel="stylesheet"/>
    <script src="{{ secure_asset('DataTables/datatables.min.js') }}" defer></script>

    <link href="{{ secure_asset('assets/style.css') }}" rel="stylesheet" />
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestamos</title>
    <style>
        body {
            /* Fondo acorde a la paleta pastel definida en style.css */
            background: linear-gradient(120deg, #ffd6d6 0%, #ffb3b3 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div class="row g-0" style="min-height: 100vh;">
        <div class="col-2">
            @component('components.sidebar')
            @endcomponent
        </div>
        <div class="col-10" style="background: rgba(255,255,255,0.7);">
            <div class="container py-4">
                @section('content')
                @show
            </div>
        </div>
    </div>
</body>
</html>
