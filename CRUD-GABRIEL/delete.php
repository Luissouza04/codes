<?php
include 'config.php';

$idUniversidade = $_GET['id'];

$sql = "DELETE FROM Universidade WHERE idUniversidade=$idUniversidade";
if ($conn->query($sql) === TRUE) {
    echo "Registro deletado com sucesso";
} else {
    echo "Erro ao deletar o registro: " . $conn->error;
}
$conn->close();
?>