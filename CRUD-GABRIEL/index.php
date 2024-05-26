<?php
include 'config.php';

$sql = "SELECT * FROM Universidade";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Universidades</title>
</head>
<body>
    <h2>Universidades</h2>
    <a href="create_form.html">Adicionar Nova Universidade</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Endereço</th>
            <th>Site</th>
            <th>Ações</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["idUniversidade"]. "</td>
                        <td>" . $row["nomeUniversidade"]. "</td>
                        <td>" . $row["endereco"]. "</td>
                        <td>" . $row["siteUniversidade"]. "</td>
                        <td>
                            <a href='update_form.php?id=" . $row["idUniversidade"]. "'>Editar</a>
                            <a href='delete.php?id=" . $row["idUniversidade"]. "'>Excluir</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nenhuma universidade encontrada</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
