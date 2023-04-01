<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNPJ/CPF</title>
</head>

<body>
    <header>
        <?php
        include('header.php');
        ?>
    </header>
    <section>
        <div align="center">
            <form class="d-flex p-3 w-50" role="search" method="POST" action="cnpj.php">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">CNPJ/CPF</span>
                    <input class="form-control" placeholder="Digite somente os números" type="search" aria-label="Search" name="cnpj" required>
                    <button class="btn btn-primary" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </section>
    <section>
        <div class="mx-auto" style="width: 80%;">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">CNPJ/CPF</th>
                        <th scope="col" class="w-75">Cliente</th>
                        <th scope="col" class="w-25">Cidade</th>
                        <th scope="col" class="w-25">Vendedor</th>
                        <th scope="col" class="w-25">Código</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($_POST) {
                        $cnpj = $_POST['cnpj'];
                        try {

                            $st = $conexao->prepare("SELECT c.*, v.nome_vendedor,v.codigo, m.nome_cidade
                            FROM cliente AS c 
                            INNER JOIN vendedor AS v
                            INNER JOIN cidades AS m
                            ON c.fk_vendedor = v.id
                            AND c.fk_cidade = m.id 
                            WHERE cnpj = '$cnpj'");

                            if ($st->execute()) {
                                while ($rs = $st->fetch(PDO::FETCH_OBJ)) {
                                    echo "<tr>";
                                    echo "<td>" . $rs->cnpj . "</td>";
                                    echo "<td>" . $rs->nome_cliente . "</td>";
                                    echo "<td>" . $rs->nome_cidade . "</td>";
                                    echo "<td>" . $rs->nome_vendedor . "</td>";
                                    echo "<td>" . $rs->codigo . "</td>";
                                    echo "<td><a class='btn btn-outline-primary' href='detalhes.php?id=" . $rs->id . "' role='button'>Detalhes</a></td>";
                                    echo "</tr>";
                                }
                            }
                        } catch (PDOException $erro) {
                            echo "<p>CNPJ não encontrado.</p>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>