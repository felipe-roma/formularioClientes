<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Vendedor</title>
</head>

<body>
    <header>
        <?php
        include('header.php');
        ?>
    </header>
    <section>
        <div class="container">

            <div class="btn-group p-3" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio1">Inserir Cliente</label>

                <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" checked>
                <label class="btn btn-outline-primary" for="btnradio2">Inserir Vendedor</label>
            </div>

            <form action="inserirVendedor.php" method="POST" class="row g-3 d-flex p-3 w-75">
                <h1>Inserir Vendedor</h1>

                <div class="col-md-6">
                    <label class="form-label">Nome do Vendedor</label>
                    <input type="text" class="form-control" name="nome" required>
                </div>

                <div class="col-md-2">

                    <label class="form-label">Código</label>
                    <input type="text" class="form-control" name="codigo" required>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">INSERIR</button>
                </div>
            </form>
            <div class="d-flex justify-content-end">
                <?php
                echo "Total: ";
                $sql = "SELECT count(*) as t FROM vendedor";
                $sql = $conexao->query($sql);
                $sql = $sql->fetch();
                $total = $sql['t'];
                echo $total;
                ?>
            </div>
        </div>
        <?php
        if (isset($_POST['nome'])) {
            $nome = $_POST['nome'];
            $codigo = $_POST['codigo'];
            $st = $conexao->prepare("INSERT INTO vendedor (nome_vendedor, codigo) VALUES (?,?)");
            $st->bindParam(1, $nome);
            $st->bindParam(2, $codigo);
            if ($st->execute()) {
                if ($st->rowCount() > 0) {
                    echo '<script>alert("Vendedor inserido com sucesso!");</script>';
                    echo "<script>window.location='inserirVendedor.php';</script>";
                } else {
                    echo 'Erro: nenhuma linha executada';
                }
            } else {
                echo 'Erro na execução!';
            }
        }
        ?>
    </section>
    <hr>
    <section>
        <div class="mx-auto p-3" style="width: 60%;">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="w-50">Vendedor</th>
                        <th scope="col" class="w-25">Código</th>
                        <th scope="col">Alterar</th>
                        <th scope="col">Remover</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $st = $conexao->prepare("SELECT * FROM vendedor");
                        if ($st->execute()) {
                            while ($rs = $st->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>";
                                echo "<td>" . $rs->nome_vendedor . "</td>";
                                echo "<td>" . $rs->codigo . "</td>";
                                echo "<td><a class='btn btn-outline-primary' href='alterarVendedor.php?id=" . $rs->id . "' role='button'>Alterar</a></td>";
                                echo "<td><a class='btn btn-outline-danger' href='deletarVendedor.php?id=" . $rs->id . "' role='button'>Remover</a></td>";
                                echo "</tr>";
                            }
                        }
                    } catch (PDOException $erro) {
                        echo "Erro: " . $erro->getMessage();
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <script src="inserirNovo.js"></script>
</body>

</html>