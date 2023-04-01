<?php
$id = $_GET['id'];
include("conexao.php");
try {
    $st = $conexao->prepare("SELECT * FROM vendedor WHERE id = ?");
    $st->bindParam(1, $id);
    if ($st->execute()) {
        if ($rs = $st->fetch(PDO::FETCH_OBJ)) {
            $nome = $rs->nome_vendedor;
            $codigo = $rs->codigo;
        }
    }
} catch (PDOException $erro) {
    echo "Erro no SQL." . $erro->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Vendedor</title>
</head>

<body>
    <header>
        <?php
        include('header.php');
        ?>
    </header>
    <section>
        <div class="container">

            <div class="d-grid p-3 gap-2">
                <a class="btn btn-primary w-25" href="inserirVendedor.php" role="button">Voltar</a>
            </div>

            <form action="" method="POST" class="row g-3 d-flex p-3 w-75">
                <h1>Inserir Vendedor</h1>

                <div class="col-md-6">
                    <label class="form-label">Nome do Vendedor</label>
                    <input type="text" class="form-control" value="<?php echo $nome ?>" name="nome" required>
                </div>

                <div class="col-md-2">

                    <label class="form-label">Código</label>
                    <input type="text" class="form-control" value="<?php echo $codigo ?>" name="codigo" required>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">ALTERAR</button>
                </div>
            </form>
        </div>
        <?php
        
        if ($_POST) {
            $nome = $_POST['nome'];
            $codigo = $_POST['codigo'];
            try {
                $st = $conexao->prepare("UPDATE vendedor SET nome_vendedor=?, codigo=? WHERE id=?");
                $st->bindParam(1, $nome);
                $st->bindParam(2, $codigo);
                $st->bindParam(3, $id);
                if ($st->execute()) {
                    echo '<script>alert("Vendedor alterado com sucesso!");</script>';
                    echo "<script>window.location='inserirVendedor.php';</script>";
                }
            } catch (PDOException $erro) {
                echo "Erro no SQL." . $erro->getMessage();
            }
        }
        ?>
    </section>
</body>

</html>