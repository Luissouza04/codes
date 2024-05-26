<?php
session_start();

if (isset($_SESSION['idAluno'])) {
    $idAluno = $_SESSION['idAluno'];

    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();

    require_once('../connection/connect.php');
    $sql = "UPDATE aluno SET sessao = 0 WHERE idAluno = :idAluno";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idAluno', $idAluno, PDO::PARAM_INT);
    $stmt->execute();

    $pdo = null;

    header("Location: ../../index.html");
    exit;
} else {
    header("Location: ../../index.html");
    exit;
}
?>