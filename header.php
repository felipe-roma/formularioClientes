<?php
include('conexao.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
</head>

<body>
    <nav class="navbar bg-body-tertiary fs-5">
        <div class="container-fluid">
            <a href="home.php" class="navbar-brand">
                <img style="width:100px;height: 50px" src="img/Logo.png" alt="Feito por FELIPE ROMA">
            </a>
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="cliente.php">Cliente</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cnpj.php">CNPJ/CPF</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="estado.php">Estado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="vendedor.php">Vendedor</a>
                </li>
            </ul>

            <div class="btn-group dropstart">
                <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Serviços
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="inserirCliente.php">INSERIR NOVO</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Buscar Moto</a></li>
                    <li><a class="dropdown-item" href="#">Entregar Peças</a></li>
                    <li><a class="dropdown-item" href="#">Oficina</a></li>
                </ul>
            </div>

        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>