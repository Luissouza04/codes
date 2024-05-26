<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeUniversidade = $_POST['nomeUniversidade'];
    $endereco = $_POST['endereco'];
    $siteUniversidade = $_POST['siteUniversidade'];

    $sql = "INSERT INTO Universidade (nomeUniversidade, endereco, siteUniversidade) VALUES ('$nomeUniversidade', '$endereco', '$siteUniversidade')";
    if ($conn->query($sql) === TRUE) {
        echo "Novo registro criado com sucesso";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>