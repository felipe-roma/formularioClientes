<?php
$id = $_GET['id'];
include("conexao.php");
try {
    $st = $conexao->prepare("SELECT c.*, v.* FROM cliente AS c INNER JOIN vendedor AS v ON c.fk_vendedor = v.id WHERE c.id = ?");
    $st->bindParam(1, $id);
    if ($st->execute()) {
        if ($rs = $st->fetch(PDO::FETCH_OBJ)) {
            $nome = $rs->nome_cliente;
            $cnpj = $rs->cnpj;
            $fk_cidade = $rs->fk_cidade;
            $endereco = $rs->endereco;
            $fk_estado = $rs->fk_estado;
            $cep = $rs->cep;
            $celular = $rs->celular;
            $telefone = $rs->telefone;
            $contato = $rs->contato;
            $empresa = $rs->empresa;
            $fk_vendedor = $rs->nome_vendedor;
            $codigo = $rs->codigo;
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
    <title>Detalhes</title>
</head>

<body>
    <header>
        <?php
        include('header.php');
        ?>
    </header>
    <section>
        <div id="tabela" class="container p-3 w-50 fs-4">
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">Nome</th>
                        <td class="w-75"><?php echo $nome; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">CNPJ</th>
                        <td><?php echo $cnpj; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Endereço</th>
                        <td colspan="2"><?php echo $endereco; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">CEP</th>
                        <td colspan="2"><?php echo $cep; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Cidade/UF</th>
                        <td><?php

                            try {
                                $st = $conexao->prepare("SELECT c.*,e.uf FROM cidades AS c INNER JOIN estados AS e ON c.id_estado = e.id WHERE c.id = {$fk_cidade}");
                                if ($st->execute()) {
                                    while ($rs = $st->fetch(PDO::FETCH_OBJ)) {
                                        echo $rs->nome_cidade . " - " . $rs->uf;
                                    }
                                }
                            } catch (PDOException $erro) {
                                echo "Erro: " . $erro->getMessage();
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Estado</th>
                        <td><?php

                            try {
                                $st = $conexao->prepare("SELECT * FROM estados WHERE id = {$fk_estado}");
                                if ($st->execute()) {
                                    while ($rs = $st->fetch(PDO::FETCH_OBJ)) {
                                        echo $rs->nome_estado;
                                    }
                                }
                            } catch (PDOException $erro) {
                                echo "Erro: " . $erro->getMessage();
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Celular</th>
                        <td colspan="2"><?php echo $celular; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Telefone</th>
                        <td colspan="2"><?php echo $telefone; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Contato</th>
                        <td colspan="2"><?php echo $contato; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Cadastro</th>
                        <td colspan="2"><?php echo $empresa; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Vendedor</th>
                        <td colspan="2"><?php echo $fk_vendedor . " (" . $codigo . ")"; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Observação</th>
                        <td><?php echo $observacao; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="d-grid p-1 gap-2 d-flex justify-content-end container w-50 fs-4">
            <a class="btn btn-primary w-25" role="button" onclick="CriaPDF()">Imprimir</a>
        </div>
    </section>
    <script>
        function CriaPDF() {
            var minhaTabela = document.getElementById('tabela').innerHTML;
            var style = "<style>";
            style = style + "body {margin-top: 50px;}";
            style = style + "table {width: 100%;font: 40px Calibri;}";
            style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
            style = style + "padding: 2px 3px;text-align: left;}";
            style = style + "</style>";
            // CRIA UM OBJETO WINDOW
            var win = window.open('', '', 'height=700,width=700');
            win.document.write('<html><head>');
            win.document.write('<title>Shopping Duas Rodas</title>'); // <title> CABEÇALHO DO PDF.
            win.document.write(style); // INCLUI UM ESTILO NA TAB HEAD
            win.document.write('</head>');
            win.document.write('<body>');
            win.document.write(minhaTabela); // O CONTEUDO DA TABELA DENTRO DA TAG BODY
            win.document.write('</body></html>');
            win.document.close(); // FECHA A JANELA
            win.print(); // IMPRIME O CONTEUDO
        }
    </script>
</body>

</html>