<?php
try {
    $conexao = new PDO('mysql:host=localhost;dbname=bd_atacado', 'root', '');
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("set names utf8");
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>

<!-- https://alexandrebbarbosa.wordpress.com/2016/09/04/php-pdo-crud-completo/comment-page-1/ -->