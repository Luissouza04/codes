<?php
include 'config.php';

$idUniversidade = $_GET['id'];

$sql = "SELECT * FROM Universidade WHERE idUniversidade=$idUniversidade";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Universidade</title>
</head>
<body>
    <h2>Editar Universidade</h2>
    <form action="update.php" method="post">
        <input type="hidden" id="idUniversidade" name="idUniversidade" value="<?php echo $row['idUniversidade']; ?>">
        <label for="nomeUniversidade">Nome da Universidade:</label><br>
        <input type="text" id="nomeUniversidade" name="nomeUniversidade" value="<?php echo $row['nomeUniversidade']; ?>" required><br>
        <label for="endereco">Endereço:</label><br>
        <input type="text" id="endereco" name="endereco" value="<?php echo $row['endereco']; ?>" required><br>
        <label for="siteUniversidade">Site:</label><br>
        <input type="text" id="siteUniversidade" name="siteUniversidade" value="<?php echo $row['siteUniversidade']; ?>"><br><br>
        <input type="submit" value="Atualizar">
    </form>
    <a href="index.php">Voltar</a>
</body>
</html>