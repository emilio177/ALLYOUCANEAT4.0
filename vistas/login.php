<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/login.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 100px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: #A5C9CA;
        }

        .card-header {
            background-color: #526D82;
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            color: white;
        }

        a {
            display: inline-block;
            padding: 15px 30px;
            text-decoration: none;
            color: #fff;
            background-color: #009688;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #00796b;
        }

        .btn-primary {
            background-color: #343a40;
            border-color: #343a40;
        }

        .btn-primary:hover {
            background-color: #495057;
            border-color: #495057;
        }

        .btn-primary:active {
            background-color: #212529;
            border-color: #212529;
        }



        .card {
            animation: cardEnter 0.8s ease-out;
        }
    </style>
</head>

<body>
    <!--Login-->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Iniciar Sesión</h3>
                    </div>
                    <div class="card-body">
                        <form id="forming" method="post">
                            <div class="form-group">
                                <label for="correo">Correo Electrónico:</label>
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese su correo">
                            </div>
                            <div class="form-group">
                                <label for="contrasena">Contraseña:</label>
                                <input type="password" class="form-control" id="contrasena" name="password" placeholder="Ingrese su contraseña">
                            </div>
                            <div class="form-group">
                                <a href="sign up.html" color="black">QUIERO REGISTRARME</a>
                                <a href="../index.php">Menu</a>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block botonlg">Iniciar Sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/login.js"></script>

</body>


</html>