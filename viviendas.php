<?php include("./template/header.php"); ?>
<?php include("./admin/config/db.php"); 

$sentenciaSQL= $connection->prepare("SELECT * FROM viviendas");
$sentenciaSQL->execute();
$listaViviendas=$sentenciaSQL->fetchall(PDO::FETCH_ASSOC);

?>

<div class="row">

<?php foreach($listaViviendas as $vivienda) {?>

<div class="col-3">
    <div class="card">
        <img class="card-img-top" src="./img/<?php echo $vivienda['imagen']; ?>" alt="">
        <div class="card-body">
            <h4 class="card-title"> €<?php echo $vivienda['precio']; ?> </h4>
           
            <form method="post" action="./detalles.php" >
                <button  type="submit" class="btn btn-primary" name="id" value="<?php echo$vivienda['id_vivienda'];?>">Ver Más</button>
            </form>

        </div>
    </div>
</div>

<?php } ?>

</div>

