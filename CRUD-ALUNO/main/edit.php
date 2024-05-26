<?php

// --------------------------------------

// ERROR:

// Warning: Undefined variable $pdo in C:\xampp\htdocs\CRUD-ALUNO\include\sessionVerify\sessionVerify.php on line 15

// Fatal error: Uncaught Error: Call to a member function prepare() on null in C:\xampp\htdocs\CRUD-ALUNO\include\sessionVerify\sessionVerify.php:15 Stack trace: #0 C:\xampp\htdocs\CRUD-ALUNO\main\edit.php(4): sessionVerify() #1 {main} thrown in C:\xampp\htdocs\CRUD-ALUNO\include\sessionVerify\sessionVerify.php on line 15

// --------------------------------------

// include "../include/sessionVerify/sessionVerify.php";
require_once("C:/xampp/htdocs/CRUD-ALUNO/include/connection/connect.php");
// sessionVerify();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: home.php");
    exit;
}

$idAluno = intval($_GET['id']);

$sql = "SELECT * FROM aluno WHERE idAluno = :idAluno";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':idAluno', $idAluno, PDO::PARAM_INT);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header("Location: home.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = sanitizeInput($_POST['nome']);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $novaSenha = isset($_POST['nova_senha']) ? $_POST['nova_senha'] : '';
    $repitaSenha = isset($_POST['repita_senha']) ? $_POST['repita_senha'] : '';
    $sessao = isset($_POST['sessao']) ? intval($_POST['sessao']) : 0;

    if (empty($nome) || empty($email)) {
        header("Location: update.php?id=$idAluno&error=empty_fields");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: update.php?id=$idAluno&error=invalid_email");
        exit;
    }

    if ($novaSenha != $repitaSenha) {
        header("Location: update.php?id=$idAluno&error=password_mismatch");
        exit;
    }

    if (!empty($novaSenha)) {
        $novoSalt = saltGenerator();
        $novaSenhaHash = password_hash($novaSenha . $novoSalt, PASSWORD_DEFAULT);
    }

    $sql = "UPDATE aluno SET nome = :nome, email = :email, sessao = :sessao";
    if (!empty($novaSenha)) {
        $sql .= ", hashSenha = :hashSenha, salt = :salt";
    }
    $sql .= " WHERE idAluno = :idAluno";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':sessao', $sessao, PDO::PARAM_INT);
    if (!empty($novaSenha)) {
        $stmt->bindParam(':hashSenha', $novaSenhaHash, PDO::PARAM_STR);
        $stmt->bindParam(':salt', $novoSalt, PDO::PARAM_STR);
    }
    $stmt->bindParam(':idAluno', $idAluno, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: home.php");
    exit;
}

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
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
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Usuário</title>
</head>
<body>
    <h1>Atualizar Usuário</h1>
    <form action="" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required><br>
        <label for="nova_senha">Nova Senha:</label>
        <input type="password" id="nova_senha" name="nova_senha"><br>
        <label for="repita_senha">Repita a Nova Senha:</label>
        <input type="password" id="repita_senha" name="repita_senha"><br>
        <label for="sessao">Sessão:</label>
        <select id="sessao" name="sessao">
            <option value="1" <?= $usuario['sessao'] == 1 ? 'selected' : '' ?>>Ativo</option>
            <option value="0" <?= $usuario['sessao'] == 0 ? 'selected' : '' ?>>Inativo</option>
        </select><br>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
