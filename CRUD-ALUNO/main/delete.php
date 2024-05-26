<?php
include "../include/sessionVerify/sessionVerify.php";
sessionVerify();

require_once("../include/connection/connect.php");

if (isset($_GET['id'])) {
    $idAluno = intval($_GET['id']);

    // Deletar o usuário
    $sql = "DELETE FROM aluno WHERE idAluno = :idAluno";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idAluno', $idAluno, PDO::PARAM_INT);
    $stmt->execute();


    header("Location: ./home.php");
    exit;
} else {
    header("Location: ./home.php");
    exit;
}
?>
