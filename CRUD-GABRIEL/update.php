<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idUniversidade = $_POST['idUniversidade'];
    $nomeUniversidade = $_POST['nomeUniversidade'];
    $endereco = $_POST['endereco'];
    $siteUniversidade = $_POST['siteUniversidade'];

    $sql = "UPDATE Universidade SET nomeUniversidade='$nomeUniversidade', endereco='$endereco', siteUniversidade='$siteUniversidade' WHERE idUniversidade=$idUniversidade";
    if ($conn->query($sql) === TRUE) {
        echo "Registro atualizado com sucesso";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>