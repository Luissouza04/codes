<?php

function sessionVerify() {
    session_start();

    if (!isset($_SESSION['idAluno'])) {
        header("Location: ../logout/logout.php");
        exit;
    } else {
        require_once("C:/xampp/htdocs/CRUD-ALUNO/include/connection/connect.php");

        $idAluno = $_SESSION['idAluno'];

        $sql = "SELECT sessao FROM aluno WHERE idAluno = :idAluno";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idAluno', $idAluno, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // PERMISSÕES DA SESSÃO => (ATIVAR DEPOIS DA APRESENTACAO)
        // if ($result && $result['sessao'] == 1) {
        //     // Recuperar permissões do usuário
        //     $query = "SELECT p.policy_type
        //               FROM Policy p
        //               JOIN PolicyUsers pu ON p.policy_id = pu.policy_id
        //               JOIN Users u ON u.user_id = pu.user_id
        //               WHERE u.user_id = :idAluno";

        //     $stmt = $pdo->prepare($query);
        //     $stmt->bindParam(':idAluno', $idAluno, PDO::PARAM_INT);
        //     $stmt->execute();
        //     $permissions = $stmt->fetch(PDO::FETCH_ASSOC);

        //     $_SESSION['permissions'] = $permissions;

        // } else {
        //     header("Location: ../logout/logout.php");
        //     exit;
        // }
    }
}
?>
