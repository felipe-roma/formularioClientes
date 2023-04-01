<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado</title>
</head>

<body>
    <header>
        <?php
        include('header.php');
        ?>
    </header>
    <section>
        <div align="center">
            <form class="d-flex p-3 w-50" role="search" method="POST" action="estado.php">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Estado</span>
                    <select class="form-select" aria-label="Default select example" name="estado" required>
                        <option value="" selected>Selecione</option>
                        <?php
                        try {
                            $st = $conexao->prepare("SELECT * FROM estados ORDER BY nome_estado ASC");
                            if ($st->execute()) {
                                while ($rs = $st->fetch(PDO::FETCH_OBJ)) {
                                    echo "<option value='" . $rs->id . "'>" . $rs->nome_estado . " (" . $rs->uf . ")</option>";
                                }
                            }
                        } catch (PDOException $erro) {
                            echo "Erro: " . $erro->getMessage();
                        }
                        ?>
                    </select>
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
                        $estado = $_POST['estado'];
                        try {
                            
                            $st = $conexao->prepare("SELECT c.*, v.nome_vendedor,v.codigo, m.nome_cidade
                            FROM cliente AS c 
                            INNER JOIN vendedor AS v
                            INNER JOIN cidades AS m
                            ON c.fk_vendedor = v.id
                            AND c.fk_cidade = m.id 
                            WHERE fk_estado = {$estado}");
                            
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
                            echo "Erro: " . $erro->getMessage();
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>