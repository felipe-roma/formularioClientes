<?php
$id = $_GET['id'];
include('conexao.php');
$stmt = $conexao->prepare('DELETE FROM cliente WHERE id = :id');
$stmt->bindParam(':id', $id);
$stmt->execute();
echo '<script>alert("Cliente removido com sucesso!");</script>';
echo "<script>window.location='inserirCliente.php';</script>";
?>