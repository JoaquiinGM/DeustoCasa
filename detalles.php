<?php
include("./template/header.php");
include("./admin/config/db.php"); 

$ID=(isset($_POST['id']))?$_POST['id']:"";

if($ID == null){
    header("Location:index.php");
}

$sentenciaSQL= $connection->prepare("SELECT * FROM viviendas WHERE id_vivienda = :id_vivienda");
$sentenciaSQL->bindParam(':id_vivienda',$ID);
$sentenciaSQL->execute();
$vivienda=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

?>

<img class="img-thumbnail rounded" src="./img/<?php echo $vivienda['imagen']; ?>"  width="1000"></br>

<?php

$sentenciaSQL= $connection->prepare("SELECT * FROM propietarios WHERE id_propietario = :id_propietario");
$sentenciaSQL->bindParam(':id_propietario',$vivienda['id_propietario']);
$sentenciaSQL->execute();
$propietario=$sentenciaSQL->fetch(PDO::FETCH_LAZY);


echo $propietario['id_propietario']."</br>"; 
echo $propietario['nombre']."</br>";


echo($vivienda['precio']."</br>");
echo($vivienda['amueblada']."</br>");
echo($vivienda['id_propietario']);

?>