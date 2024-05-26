<?php

session_start();

require_once('../../../../include/connection/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
        
        $nome = sanitizeInput($_POST['nome']);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $email = sanitizeInput($email);

        $sql = "SELECT * FROM Aluno WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch();

        if (!$result) {

            $senha = sanitizeInput($_POST['senha']);

            while (true) {
                $salt = saltGenerator();

                $sql = "SELECT * FROM Aluno WHERE salt = :salt";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':salt', $salt);
                $stmt->execute();
                $result = $stmt->fetch();

                if (!$result) {
                    $senha = $senha . $salt;
                    $password_hash = password_hash($senha, PASSWORD_DEFAULT);

                    $sql = "INSERT INTO Aluno (nome, email, hashSenha, salt, sessao) VALUES (:nome, :email, :password_hash, :salt, 1)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':nome', $nome);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password_hash', $password_hash);
                    $stmt->bindParam(':salt', $salt);
                    $stmt->execute();

                    $user_id = $pdo->lastInsertId();

                    // Ativar depois de entregar trabalho Desenvolvimento web
                    // $sql = "INSERT INTO PolicyUsers (user_id, policy_id) VALUES (:user_id, 1)";
                    // $stmt = $pdo->prepare($sql);
                    // $stmt->bindParam(':user_id', $user_id);
                    // $stmt->execute();

                    $_SESSION['idAluno'] = $user_id;
                    header("Location: ../../../../main/home.php");
                    exit;
                }
            }
        } else {
            header("Location: ../index.php?message=Email_ja_em_uso");
            exit;
        }
    } else {
        header('location: ../index.php?message=Todos_os_campos_são_obrigatórios');
        exit;
    }
}

function saltGenerator(): string {
    $characters = array_merge(
        range('a', 'z'),
        range('A', 'Z'),
        range('0', '9'),
        ['!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '_', '+', '=', '~']
    );

    shuffle($characters);

    $salt = '';
    for ($i = 0; $i < 128; $i++) {
        $value = rand(0, count($characters) - 1);
        $salt .= $characters[$value];
    }

    return $salt;
}

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}
?>