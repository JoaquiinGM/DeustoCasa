<?php include("../template/header.php") ?>

<?php

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtPrecio=(isset($_POST['txtPrecio']))?$_POST['txtPrecio']:"";
$txtM2=(isset($_POST['txtM2']))?$_POST['txtM2']:"";
$txtCant_habit=(isset($_POST['txtCant_habit']))?$_POST['txtCant_habit']:"";
$txtF_construc=(isset($_POST['txtF_construc']))?$_POST['txtF_construc']:"";
$txtAmueblada=(isset($_POST['txtAmueblada']))?$_POST['txtAmueblada']:"";
$txtID_propietario=(isset($_POST['txtID_propietario']))?$_POST['txtID_propietario']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$action=(isset($_POST['action']))?$_POST['action']:"";

include("../config/db.php");

switch($action){

    case "Agregar":

        $date = new Datetime();
        $fileName=($txtImagen!="")?$date->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
        
        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

        if($tmpImagen!=""){
            move_uploaded_file($tmpImagen,"../../img/".$fileName);
        }

        $sentenciaSQL= $connection->prepare("INSERT INTO `viviendas`(`id_vivienda`, `precio`, `m2`, `cant_habit`, `f_construc`, `amueblada`, `id_propietario`, `imagen`) VALUES(NULL, :precio, :m2, :cant_habit, :f_construc, :amueblada, :ID_propietario, :imagen);");
        $sentenciaSQL->bindParam(':precio',$txtPrecio);
        $sentenciaSQL->bindParam(':m2',$txtM2);
        $sentenciaSQL->bindParam(':cant_habit',$txtCant_habit);
        $sentenciaSQL->bindParam(':f_construc',$txtF_construc);
        $sentenciaSQL->bindParam(':amueblada',$txtAmueblada);
        $sentenciaSQL->bindParam(':ID_propietario',$txtID_propietario);
        $sentenciaSQL->bindParam(':imagen',$fileName);
        $sentenciaSQL->execute();
        
        header("Location:viviendas.php");
        
        break;
    
    case "Modificar":     
        
        $sentenciaSQL= $connection->prepare("UPDATE viviendas SET precio=:precio, m2=:m2, cant_habit=:cant_habit, f_construc=:f_construc, amueblada=:amueblada, id_propietario=:ID_propietario WHERE id_vivienda = :id_vivienda");
        $sentenciaSQL->bindParam(':precio',$txtPrecio);
        $sentenciaSQL->bindParam(':id_vivienda',$txtID);
        $sentenciaSQL->bindParam(':m2',$txtM2);
        $sentenciaSQL->bindParam(':cant_habit',$txtCant_habit);
        $sentenciaSQL->bindParam(':f_construc',$txtF_construc);
        $sentenciaSQL->bindParam(':amueblada',$txtAmueblada);
        $sentenciaSQL->bindParam(':ID_propietario',$txtID_propietario);
        $sentenciaSQL->execute();

        if($txtImagen!=""){

            $date = new Datetime();
            $fileName=($txtImagen!="")?$date->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
        
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
    
            if($tmpImagen!=""){
                move_uploaded_file($tmpImagen,"../../img/".$fileName);
            }
            $sentenciaSQL= $connection->prepare("SELECT imagen FROM viviendas WHERE id_vivienda = :id_vivienda");
            $sentenciaSQL->bindParam(':id_vivienda',$txtID);
            $sentenciaSQL->execute();
            $vivienda=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
            if( isset($vivienda["imagen"]) && ($vivienda["imagen"]!="imagen.jpg")){
                if(file_exists("../../img/".$vivienda["imagen"])){
                    unlink("../../img/".$vivienda["imagen"]);
                }
            }


            $sentenciaSQL=$connection->prepare("UPDATE viviendas SET imagen=:imagen WHERE id_vivienda = :id_vivienda");
            $sentenciaSQL->bindParam(':imagen',$fileName);
            $sentenciaSQL->bindParam(':id_vivienda',$txtID);
            $sentenciaSQL->execute();
        }

        header("Location:viviendas.php");

        break;

    case "Cancelar":
        
        header("Location:viviendas.php");

        break;

    case "Seleccionar":

        $sentenciaSQL= $connection->prepare("SELECT * FROM viviendas WHERE id_vivienda = :id_vivienda");
        $sentenciaSQL->bindParam(':id_vivienda',$txtID);
        $sentenciaSQL->execute();
        $vivienda=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtID=$vivienda['id_vivienda'];
        $txtPrecio=$vivienda['precio'];
        $txtM2=$vivienda['m2'];
        $txtCant_habit=$vivienda['cant_habit'];
        $txtF_construc=$vivienda['f_construc'];
        $txtAmueblada=$vivienda['amueblada'];
        $txtID_propietario=$vivienda['id_propietario'];
        $txtImagen=$vivienda['imagen'];
        

        break;

    case "Borrar":

        $sentenciaSQL= $connection->prepare("SELECT imagen FROM viviendas WHERE id_vivienda = :id_vivienda");
        $sentenciaSQL->bindParam(':id_vivienda',$txtID);
        $sentenciaSQL->execute();
        $vivienda=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if( isset($vivienda["imagen"]) && ($vivienda["imagen"]!="imagen.jpg")){
            if(file_exists("../../img/".$vivienda["imagen"])){
                unlink("../../img/".$vivienda["imagen"]);
            }
        }


        $sentenciaSQL= $connection->prepare("DELETE FROM viviendas WHERE id_vivienda = :id_vivienda");
        $sentenciaSQL->bindParam(':id_vivienda',$txtID);
        $sentenciaSQL->execute(); 

        header("Location:viviendas.php");

        break;
}

$sentenciaSQL= $connection->prepare("SELECT * FROM viviendas");
$sentenciaSQL->execute();
$listaViviendas=$sentenciaSQL->fetchall(PDO::FETCH_ASSOC);


$sentenciaSQL= $connection->prepare("SELECT * FROM propietarios");
$sentenciaSQL->execute();
$listaPropietarios=$sentenciaSQL->fetchall(PDO::FETCH_ASSOC);

?>

<div class="row">

    <div class="col-md-5">

        <div class="card">
            <div class="card-header">
                Datos de la vivienda
            </div>

            <div class="card-body">

            <form method="POST" enctype="multipart/form-data" >

        <div class = "form-group">
        <label for="txtID">ID:</label>
        <input type="text" required readonly  class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
        </div>

        <div class = "form-group">
        <label for="txtPrecio">Precio:</label>
        <input type="text" required class="form-control" value="<?php echo $txtPrecio; ?>" name="txtPrecio" id="txtPrecio" placeholder="Precio">
        </div>

        <div class = "form-group">
        <label for="txtM2">Metros Cuadrados:</label>
        <input type="text" class="form-control" value="<?php echo $txtM2; ?>" name="txtM2" id="txtM2" placeholder="Metros Cuadrados">
        </div>

        <div class = "form-group">
        <label for="txtCant_habit">Cantidad de habitaciones:</label>
        <input type="text" class="form-control" value="<?php echo $txtCant_habit; ?>" name="txtCant_habit" id="txtCant_habit" placeholder="Cantidad de habitaciones">
        </div>

        <div class = "form-group">
        <label for="txtF_construc">Fecha de Construcción</label>
        <input type="date" class="form-control" value="<?php echo $txtF_construc; ?>" name="txtF_construc" id="txtF_construc" placeholder="Fecha de construccion">
        </div>

        <div class = "form-group">
        <label for="txtAmueblada">Amueblada</label>
        <input type="text" required class="form-control" value="<?php echo $txtAmueblada; ?>" name="txtAmueblada" id="txtAmueblada" placeholder="Amueblada">
        </div>

        <div class = "form-group">
        <label for="txtID_propietario">Propietario</label>

        <select name="txtID_propietario" required class="form-control" id="txtID_propietario" placeholder="ID del propietario">
        <?php foreach($listaPropietarios as $propietario) {?>

        <option  value="<?php echo $propietario['id_propietario']; ?>" ><?php echo $propietario['nombre']; ?></option>
        
        <?php } ?>
        </select>    

        </div>

        <div class = "form-group">
        <label for="txtImagen">Imagen:</label>
        
        </br>

        <?php if($txtImagen!=""){ ?>

            <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen; ?>" width="50" alt="" srcset="">
        
        <?php } ?>
        
        
        <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Seleccione una imagen">
        </div>

    <div class="btn-group" role="group" aria-label="">
        <button type="submit" name="action" <?php echo ($action=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-success">Agregar</button>
        <button type="submit" name="action" <?php echo ($action!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
        <button type="submit" name="action" <?php echo ($action!="Seleccionar")?"disabled":""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
    </div>
        </form>


            </div>
        </div>

        
        
        
    </div>

    <div class="col-md-7">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Precio</th>
                    <th>M2</th>
                    <th>Habitaciones</th>
                    <th>Construcción</th>
                    <th>Amueblada</th>
                    <th>Propietario</th>
                    <th>Imagen</th>
                    <th>SELECCIONAR | BORRAR</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($listaViviendas as $vivienda) {?>
                <tr>
                    <td><?php echo $vivienda['id_vivienda']; ?></td>
                    <td><?php echo $vivienda['precio']; ?></td>
                    <td><?php echo $vivienda['m2']; ?></td>
                    <td><?php echo $vivienda['cant_habit']; ?></td>
                    <td><?php echo $vivienda['f_construc']; ?></td>
                    <td><?php echo $vivienda['amueblada']; ?></td>
                    <td><?php echo $vivienda['id_propietario']; ?></td>
                    <td>
                        <img class="img-thumbnail rounded" src="../../img/<?php echo $vivienda['imagen']; ?>" width="50" alt="" srcset="">
                    </td>
                    
                    <td>
                            <form method="post">
                                <input type="hidden" name="txtID" id="txtID" value="<?php echo $vivienda['id_vivienda']; ?>"/>
                                <input type="submit" name="action" value="Seleccionar" class="btn btn-primary"/>
                                <input type="submit" name="action" value="Borrar" class="btn btn-danger"/>
                            </form>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <td scope="row"></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
