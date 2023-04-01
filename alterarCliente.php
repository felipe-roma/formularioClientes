<?php
$id = $_GET['id'];
include("conexao.php");
try {
    $st = $conexao->prepare("SELECT * FROM cliente WHERE id = ?");
    $st->bindParam(1, $id);
    if ($st->execute()) {
        if ($rs = $st->fetch(PDO::FETCH_OBJ)) {
            $nome = $rs->nome_cliente;
            $empresa = $rs->empresa;
            $cnpj = $rs->cnpj;
            $celular = $rs->celular;
            $telefone = $rs->telefone;
            $contato = $rs->contato;
            $fk_vendedor = $rs->fk_vendedor;
            $endereco = $rs->endereco;
            $fk_cidade = $rs->fk_cidade;
            $cep = $rs->cep;
            $observacao = $rs->observacao;
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
    <title>Alterar Cliente</title>
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
                <a class="btn btn-primary w-25" href="inserirCliente.php" role="button">Voltar</a>
            </div>

            <form class="row g-3 d-flex p-3 w-100" action="" method="POST">
                <h1>Alterar Cliente</h1>
                <div class="col-6">
                    <label for="inputAddress" class="form-label">Nome do Cliente</label>
                    <input type="text" class="form-control" id="inputAddress" value="<?php echo $nome ?>" name="nome" required>
                </div>

                <div class="col-md-4">
                    <label for="inputEmail4" class="form-label">CNPJ/CPF</label>
                    <input type="text" class="form-control" id="inputEmail4" value="<?php echo $cnpj ?>" name="cnpj">
                </div>

                <div class="col-2">
                    <label class="form-label">Cadastro</label>
                    <select class="form-select" name="empresa">
                        <option value="">Selecione</option>
                        <?php
                        if ($empresa == "Oliveira") {
                            echo '<option value="Oliveira" selected>Oliveira</option>';
                        } else {
                            echo '<option value="Oliveira">Oliveira</option>';
                        }
                        if ($empresa == "Shopping") {
                            echo '<option value="Shopping" selected>Shopping</option>';
                        } else {
                            echo '<option value="Shopping">Shopping</option>';
                        }
                        if ($empresa == "Ambos") {
                            echo '<option value="Ambos" selected>Ambos</option>';
                        } else {
                            echo '<option value="Ambos">Ambos</option>';
                        }                       
                        ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Celular</label>
                    <input type="text" name="celular" class="form-control" id="celular" value="<?php echo $celular ?>">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Telefone</label>
                    <input type="text" name="telefone" class="form-control" id="telefone" value="<?php echo $telefone ?>">
                </div>

                <div class="col-4">
                    <label for="inputAddress" class="form-label">Contato</label>
                    <input type="text" class="form-control" id="inputAddress" name="contato" value="<?php echo $contato ?>">
                </div>

                <div class="col-md-4">
                    <label for="inputState" class="form-label">Vendedor</label>
                    <select id="option" class="form-select" name="vendedor" required>
                        <!-- <option value="" selected disabled>Selecione</option> -->
                        <?php
                        $selecionado = "false";
                        try {
                            $st = $conexao->prepare("SELECT * FROM vendedor ORDER BY nome_vendedor ASC");
                            if ($st->execute()) {
                                while ($rs = $st->fetch(PDO::FETCH_OBJ)) {
                                    if ($fk_vendedor == $rs->id) {
                                        echo "<option value=" . $rs->id . " selected>" . $rs->nome_vendedor . "</option>";
                                    } else {
                                        echo "<option value=" . $rs->id . ">" . $rs->nome_vendedor . "</option>";
                                    }
                                }
                            }
                        } catch (PDOException $erro) {
                            echo "Erro: " . $erro->getMessage();
                        }
                        ?>
                    </select>
                </div>

                <div class="col-6">
                    <label for="inputAddress" class="form-label">Endereço</label>
                    <input type="text" class="form-control" id="inputAddress" name="endereco" value="<?php echo $endereco ?>">
                </div>

                <div class="col-2">
                    <label for="inputAddress" class="form-label">CEP</label>
                    <input type="text" name="cep" class="form-control" id="cep" value="<?php echo $cep ?>">
                </div>

                <div class="col-md-4">
                    <label for="inputState" class="form-label">Cidade</label>
                    <select id="inputState" class="form-select" name="cidade">
                        <option value="">Selecione</option>
                        <?php
                        try {
                            $st = $conexao->prepare("SELECT c.*,e.uf FROM cidades AS c INNER JOIN estados AS e ON c.id_estado = e.id ORDER BY nome_cidade ASC");
                            if ($st->execute()) {
                                while ($rs = $st->fetch(PDO::FETCH_OBJ)) {
                                    if ($fk_cidade == $rs->id) {
                                        echo "<option value=" . $rs->id . " selected>" . $rs->nome_cidade . " - " . $rs->uf . "</option>";
                                    } else {
                                        echo "<option value=" . $rs->id . ">" . $rs->nome_cidade . " - " . $rs->uf . "</option>";
                                    }
                                }
                            }
                        } catch (PDOException $erro) {
                            echo "Erro: " . $erro->getMessage();
                        }
                        ?>
                    </select>
                </div>

                <div class="col-6 mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Observação</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="observacao"><?php echo $observacao ?></textarea>
                </div>

                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">ALTERAR</button>
                </div>
            </form>
            <?php
            if ($_POST) {
                $nome = strtoupper($_POST['nome']);
                $empresa = $_POST['empresa'];
                $cnpj = $_POST['cnpj'];
                $celular = $_POST['celular'];
                $telefone = $_POST['telefone'];
                $contato = strtoupper($_POST['contato']);
                $fk_vendedor = $_POST['vendedor'];
                $endereco = strtoupper($_POST['endereco']);
                $fk_cidade = $_POST['cidade'];
                $cep = $_POST['cep'];
                $observacao = strtoupper($_POST['observacao']);
                try {
                    $st = $conexao->prepare("SELECT * FROM cidades WHERE id = ?");
                    $st->bindParam(1, $fk_cidade);
                    if ($st->execute()) {
                        while ($rs = $st->fetch(PDO::FETCH_OBJ)) {
                            $estado = $rs->id_estado;
                        }
                    }
                } catch (PDOException $erro) {
                    echo "Erro: " . $erro->getMessage();
                }
                try {
                    $st = $conexao->prepare("UPDATE cliente SET nome_cliente=?, empresa=?, cnpj=?, celular=?, telefone=?, contato=?, fk_vendedor=?, endereco=?, fk_cidade=?, fk_estado=?, cep=?, observacao=? WHERE id=?");
                    $st->bindParam(1, $nome);
                    $st->bindParam(2, $empresa);
                    $st->bindParam(3, $cnpj);
                    $st->bindParam(4, $celular);
                    $st->bindParam(5, $telefone);
                    $st->bindParam(6, $contato);
                    $st->bindParam(7, $fk_vendedor);
                    $st->bindParam(8, $endereco);
                    $st->bindParam(9, $fk_cidade);
                    $st->bindParam(10, $estado);
                    $st->bindParam(11, $cep);
                    $st->bindParam(12, $observacao);
                    $st->bindParam(13, $id);
                    if ($st->execute()) {
                        echo '<script>alert("Cliente alterado com sucesso!");</script>';
                        echo "<script>window.location='inserirCliente.php';</script>";
                    }
                } catch (PDOException $erro) {
                    echo "Erro no SQL." . $erro->getMessage();
                }
            }
            ?>
        </div>
    </section>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    <script type="text/javascript">
        $("#celular").mask("(00) 0 0000-0000");
        $("#telefone").mask("(00) 0000-0000");
        $("#cep").mask("00.000-000");
    </script>
</body>

</html>