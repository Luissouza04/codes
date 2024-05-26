<?php
include "../include/sessionVerify/sessionVerify.php";
sessionVerify();

require_once("../include/connection/connect.php");

$sql = "SELECT idAluno, nome, email, sessao FROM aluno";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .ativo {
            color: green;
        }
        .inativo {
            color: red;
        }
        .btn {
            padding: 5px 10px;
            margin: 5px;
            text-decoration: none;
            border: none;
            color: white;
            cursor: pointer;
        }
        .btn-edit {
            background-color: blue;
        }
        .btn-delete {
            background-color: red;
        }
    </style>
</head>
<body>
    <h1>Bem-vindo à Página Principal</h1>
    <a href="../include/logout/logout.php">X</a>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Sessão</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['nome']) ?></td>
                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                    <td class="<?= $usuario['sessao'] ? 'ativo' : 'inativo' ?>">
                        <?= $usuario['sessao'] ? 'Ativo' : 'Inativo' ?>
                    </td>
                    <td>
                        <a href="edit.php?id=<?= $usuario['idAluno'] ?>" class="btn btn-edit">Editar</a>
                        <a href="delete.php?id=<?= $usuario['idAluno'] ?>" class="btn btn-delete" onclick="return confirm('Tem certeza que deseja deletar este usuário?');">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
