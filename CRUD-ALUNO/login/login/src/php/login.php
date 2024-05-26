<?php

session_start();

require_once('../../../../include/connection/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['email']) && !empty($_POST['senha'])) {

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $email = sanitizeInput($email);

        $sql = "SELECT * FROM Aluno WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            $senha = sanitizeInput($_POST['senha']);
            $senha = $senha . $user['salt'];
            if (password_verify($senha, $user['hashSenha'])) {
                $_SESSION['idAluno'] = $user['idAluno'];
                header("Location: ../../../../main/home.php");
                exit();
            } else {
                header("Location: ../../../../index.html?Error=Senha_ou_email_inválidos");
                exit();
            }
        } else {
            header("Location: ../../../../index.html?Error=Usuário_não_encontrado");
            exit();
        }
    }
}

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

?>
