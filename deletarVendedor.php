<?php
$id = $_GET['id'];
include('conexao.php');
$stmt = $conexao->prepare('DELETE FROM vendedor WHERE id = :id');
$stmt->bindParam(':id', $id);
$stmt->execute();
echo '<script>alert("Vendedor removido com sucesso!");</script>';
echo "<script>window.location='inserirVendedor.php';</script>";
?>