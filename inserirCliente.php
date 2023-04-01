<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Cliente</title>
    <link rel="stylesheet" href="style.css">
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
                <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                <label class="btn btn-outline-primary" for="btnradio1">Inserir Cliente</label>

                <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio2">Inserir Vendedor</label>
            </div>

            <form class="row g-3 d-flex p-3 w-100" action="inserirCliente.php" method="POST">
                <h1>Inserir Cliente</h1>
                <div class="col-6">
                    <label for="inputAddress" class="form-label">Nome do Cliente</label>
                    <input type="text" class="form-control" id="inputAddress" name="nome" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">CNPJ/CPF</label>
                    <input type="text" name="cnpj" class="form-control">
                </div>

                <div class="col-2">
                    <label class="form-label">Cadastro</label>
                    <select id="inputState" class="form-select" name="empresa">
                        <option value="" selected>Selecione</option>
                        <option value="Oliveira">Oliveira</option>
                        <option value="Shopping">Shopping</option>
                        <option value="Ambos">Ambos</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Celular</label>
                    <input type="text" name="celular" placeholder="(xx) x xxxx-xxxx" class="form-control" id="celular">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Telefone</label>
                    <input type="text" name="telefone" placeholder="(xx) xxxx-xxxx" class="form-control" id="telefone">
                </div>

                <div class="col-4">
                    <label for="inputAddress" class="form-label">Contato</label>
                    <input type="text" class="form-control" id="inputAddress" name="contato">
                </div>

                <div class="col-md-4">
                    <label for="inputState" class="form-label">Vendedor</label>
                    <select id="inputState" class="form-select" name="vendedor" required>
                        <option value="" selected disabled>Selecione</option>
                        <?php
                        try {
                            $st = $conexao->prepare("SELECT * FROM vendedor ORDER BY nome_vendedor ASC");
                            if ($st->execute()) {
                                while ($rs = $st->fetch(PDO::FETCH_OBJ)) {
                                    echo "<option value=" . $rs->id . ">" . $rs->nome_vendedor . "</option>";
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
                    <input type="text" class="form-control" id="inputAddress" name="endereco">
                </div>

                <div class="col-2">
                    <label for="inputAddress" class="form-label">CEP</label>
                    <input type="text" placeholder="xx.xxx-xxx" name="cep" class="form-control" id="cep">
                </div>

                <div class="col-md-4">
                    <label for="inputState" class="form-label">Cidade</label>
                    <select id="inputState" class="form-select" name="cidade">
                        <option value="" selected>Selecione</option>
                        <?php
                        try {
                            $st = $conexao->prepare("SELECT c.*,e.uf FROM cidades AS c INNER JOIN estados AS e ON c.id_estado = e.id ORDER BY nome_cidade ASC");
                            if ($st->execute()) {
                                while ($rs = $st->fetch(PDO::FETCH_OBJ)) {
                                    echo "<option value=" . $rs->id . ">" . $rs->nome_cidade . " - " . $rs->uf . "</option>";
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
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="observacao">Nada consta</textarea>
                </div>

                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">INSERIR</button>
                </div>
            </form>
            <?php
            if (isset($_POST['nome'])) {
                $nome = strtoupper($_POST['nome']);
                $cnpj = $_POST['cnpj'];
                $empresa = $_POST['empresa'];
                $celular = $_POST['celular'];
                $telefone = $_POST['telefone'];
                $contato = strtoupper($_POST['contato']);
                $vendedor = $_POST['vendedor'];
                $cidade = $_POST['cidade'];
                $endereco = strtoupper($_POST['endereco']);
                $cep = $_POST['cep'];
                $observacao = strtoupper($_POST['observacao']);
                try {
                    $st = $conexao->prepare("SELECT * FROM cidades WHERE id = ?");
                    $st->bindParam(1, $cidade);
                    if ($st->execute()) {
                        if ($rs = $st->fetch(PDO::FETCH_OBJ)) {
                            $estado = $rs->id_estado;
                        }
                    }
                } catch (PDOException $erro) {
                    echo "Erro: " . $erro->getMessage();
                }
                $st = $conexao->prepare("INSERT INTO cliente (nome_cliente, empresa, cnpj, celular, telefone, contato, fk_vendedor, fk_cidade, fk_estado, cep, observacao, endereco) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                $st->bindParam(1, $nome);
                $st->bindParam(2, $empresa);
                $st->bindParam(3, $cnpj);
                $st->bindParam(4, $celular);
                $st->bindParam(5, $telefone);
                $st->bindParam(6, $contato);
                $st->bindParam(7, $vendedor);
                $st->bindParam(8, $cidade);
                $st->bindParam(9, $estado);
                $st->bindParam(10, $cep);
                $st->bindParam(11, $observacao);
                $st->bindParam(12, $endereco);

                if ($st->execute()) {
                    if ($st->rowCount() > 0) {
                        echo '<script>alert("Cliente inserido com sucesso!");</script>';
                        echo "<script>window.location='inserirCliente.php';</script>";
                    } else {
                        echo 'Erro: nenhuma linha executada';
                    }
                } else {
                    echo 'Erro na execução!';
                }
            }
            ?>
        </div>
    </section>
    <hr>
    <section>
        <div class="mx-auto p-3" style="width: 90%;">
            <div class="d-flex justify-content-end">
                <?php
                echo "Total: ";
                $sql = "SELECT count(*) as t FROM cliente";
                $sql = $conexao->query($sql);
                $sql = $sql->fetch();
                $total = $sql['t'];
                echo $total;
                ?>
            </div>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="w-25">CNPJ</th>
                        <th scope="col" class="w-75">Cliente</th>
                        <th scope="col" class="w-25">Vendedor</th>
                        <th scope="col">Alterar</th>
                        <th scope="col">Remover</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $st = $conexao->prepare("SELECT c.*, v.nome_vendedor FROM cliente AS c INNER JOIN vendedor AS v ON c.fk_vendedor = v.id ORDER BY nome_cliente ASC");
                        if ($st->execute()) {
                            while ($rs = $st->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>";
                                echo "<td>" . $rs->cnpj . "</td>";
                                echo "<td>" . $rs->nome_cliente . "</td>";
                                echo "<td>" . $rs->nome_vendedor . "</td>";
                                echo "<td><a class='btn btn-outline-primary' href='alterarCliente.php?id=" . $rs->id . "' role='button'>Alterar</a></td>";
                                echo "<td><a class='btn btn-outline-danger' href='deletarCliente.php?id=" . $rs->id . "' role='button'>Remover</a></td>";
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
    <a href="#" class="scrollToTop">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
        </svg>
    </a>
    <script src="inserirNovo.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    <script type="text/javascript">
        // MÁSCARA
        $("#celular").mask("(00) 0 0000-0000");
        $("#telefone").mask("(00) 0000-0000");
        $("#cep").mask("00.000-000");

        // REMOVER MASCARA
        // var cpf = "453.458.165-85";
        // cpf = cpf.replace(".", "");
        // cpf = cpf.replace("-", "");
        // var cnpj = "25.589.196/0001-89";
        // cnpj = cnpj.replace(".", "");
        // cnpj = cnpj.replace("-", "");
        // cnpj = cnpj.replace("/", "");

        $(document).ready(function() {

            //Verifica se a Janela está no topo
            $(window).scroll(function() {
                if ($(this).scrollTop() > 100) {
                    $('.scrollToTop').fadeIn();
                } else {
                    $('.scrollToTop').fadeOut();
                }
            });

            //Onde a mágia acontece! rs
            $('.scrollToTop').click(function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });

        });
    </script>
</body>

</html>