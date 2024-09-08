<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include("./template/header.php"); ?>
    <?php include("./admin/config/db.php"); ?>

<div class="container mt-5">
     <div class="col-12">
         <div class="row">
             <div class="col-12 grid-margin">
                 <div class="card">
                     <div class="card-body">
                         <h4 class="card-title">Buscador</h4>

                         <form id="form2" name="form2"  method="POST" action="filtro.php">
                             <div class="col-12 row">
                                 <div class="mb-3">
                                     <label class="form-label">Nombre a buscar</label>
                                     <input type="text" class="form-control" id="buscar" name="buscar" value="<?php echo (isset($_POST["buscar"])? :"" ); ?>">
                                 </div>
                                 <div class="col-11">
                                     <table class="table">
                                         <thead>
                                             <tr class="filters">
                                                <th>
                                                 DEPARTAMENTO
                                                   <select id="assigned-tutor-filter" id="buscadepartamento" name="buscadepartamento" class="form-control mt-2" style="border: #bababa 1px solid; color:#000000;">
                                                   <?php if($_POST["buscadepartamento"] != ''){ ?>
                                                     <option value="<?php echo $_POST["buscadepartamento"]; ?>"><?php echo $_POST["buscadepartamento"]; ?></option>
                                                     <?php } ?>
                                                     <option value="Todos">Todos</option>
                                                     <option value="Compras">Compras</option>
                                                     <option value="Ventas">Ventas</option>
                                                     <option value="Alquileres">Alquileres</option>
                                                   </select>
                                                 </div>
                                                </th>
                                                <th>
                                                    Fecha desde:
                                                    <input type="date" id="buscafechadesde" name="buscafechadesde" class="form-control mt-2" value="<?php echo $_POST["buscafechadesde"]; ?>" style="border: #bababa 1px solid; color:#000000;">
                                                </th>
                                                <th>
                                                    Fecha hasta:
                                                    <input type="date" id="buscafechahasta" name="buscafechahasta" class="form-control mt-2" value="<?php echo $_POST["buscafechahasta"]; ?>" style="border: #bababa 1px solid; color:#000000;">
                                                </th>
                                                <th>
                                                    Color
                                                    <select id="subjet-filter" id="color" name="color" class="form-control mt-2" style="border: #bababa 1px solid; color:#000000;">
                                                        <?php if($_POST["color"] != ""){ ?>
                                                            <option value="<?php echo $_POST["color"]; ?>"><?php echo $_POST["color"]; ?></option>
                                                        <?php } ?>
                                                     <option value="Todos">Todos</option>
                                                     <option value="Azul">Azul</option>
                                                     <option value="Rojo">Rojo</option>
                                                     <option value="Amarillo">Amarillo</option>
                                                    </select>
                                                </th>
                                             </tr>
                                         </thead>
                                    </table>
                                 </div>
                                 <div class="col-1">
                                     <input type="submit" class="btn btn-success" value="Ver" style="margin-top: 38px;">
                                 </div>
                             </div>
                             <?php
                                if($_POST["buscar"] == '' AND $_POST["buscadepartamento"] == 'Todos' AND $_POST["buscafechadesde"] == '' AND $_POST["color"] == 'Todos'){$filtro='';}else{
                                    if($_POST["buscar"] != '' AND $_POST["buscadepartamento"] == 'Todos' AND $_POST["buscafechadesde"] == '' AND $_POST["color"] == 'Todos'){ $filtro= " WHERE nombre LIKE '%".$_POST["buscar"]."%'";}
                                    if($_POST["buscar"] == '' AND $_POST["buscadepartamento"] != 'Todos' AND $_POST["buscafechadesde"] == '' AND $_POST["color"] == 'Todos'){ $filtro= " WHERE departamento = '".$_POST["buscadepartamento"]."' ";}
                                    if($_POST["buscar"] != '' AND $_POST["buscadepartamento"] != 'Todos' AND $_POST["buscafechadesde"] == '' AND $_POST["color"] == 'Todos'){$filtro= " WHERE nombre LIKE '%".$_POST["buscar"]."%' AND departamento = '".$_POST["buscadepartamento"]."' ";}
                                    if($_POST["buscar"] == '' AND $_POST["buscadepartamento"] != 'Todos' AND $_POST["buscafechadesde"] != '' AND $_POST["color"] == 'Todos'){$filtro= " WHERE departamento = '".$_POST["buscadepartamento"]."' AND fecha BETWEEN '".$_POST["buscafechadesde"]."' AND '".$_POST["buscafechahasta"]."'";}
                                    if($_POST["buscar"] != '' AND $_POST["buscadepartamento"] != 'Todos' AND $_POST["buscafechadesde"] != '' AND $_POST["color"] == 'Todos'){$filtro= " WHERE nombre LIKE '%".$_POST["buscar"]."%' AND departamento = '".$_POST["buscadepartamento"]."' AND fecha BETWEEN '".$_POST["buscafechadesde"]."' AND '".$_POST["buscafechahasta"]."' ";}
                                    if($_POST["buscar"] == '' AND $_POST["buscadepartamento"] != 'Todos' AND $_POST["buscafechadesde"] != '' AND $_POST["color"] != 'Todos'){$filtro= " WHERE departamento = '".$_POST["buscadepartamento"]."' AND fecha BETWEEN '".$_POST["buscafechadesde"]."' AND '".$_POST["buscafechahasta"]."' AND color = '".$_POST["color"]."' ";}
                                    if($_POST["buscar"] != '' AND $_POST["buscadepartamento"] != 'Todos' AND $_POST["buscafechadesde"] != '' AND $_POST["color"] != 'Todos'){$filtro= " WHERE nombre LIKE '%".$_POST["buscar"]."%' AND departamento = '".$_POST["buscadepartamento"]."' AND fecha BETWEEN '".$_POST["buscafechadesde"]."' AND '".$_POST["buscafechahasta"]."' AND color = '".$_POST["color"]."'";}
                                    if($_POST["buscar"] == '' AND $_POST["buscadepartamento"] == 'Todos' AND $_POST["buscafechadesde"] != '' AND $_POST["color"] == 'Todos'){$filtro= " WHERE fecha BETWEEN '".$_POST["buscafechadesde"]."' AND '".$_POST["buscafechahasta"]."'";}
                                    if($_POST["buscar"] != '' AND $_POST["buscadepartamento"] == 'Todos' AND $_POST["buscafechadesde"] != '' AND $_POST["color"] == 'Todos'){$filtro= " WHERE nombre LIKE '%".$_POST["buscar"]."%' AND departamento = '".$_POST["buscadepartamento"]."' AND fecha BETWEEN '".$_POST["buscafechadesde"]."' AND '".$_POST["buscafechahasta"]."'";}
                                    if($_POST["buscar"] == '' AND $_POST["buscadepartamento"] == 'Todos' AND $_POST["buscafechadesde"] != '' AND $_POST["color"] != 'Todos'){$filtro= " WHERE fecha BETWEEN '".$_POST["buscafechadesde"]."' AND '".$_POST["buscafechahasta"]."' AND color = '".$_POST["color"]."' ";}
                                    if($_POST["buscar"] != '' AND $_POST["buscadepartamento"] == 'Todos' AND $_POST["buscafechadesde"] != '' AND $_POST["color"] != 'Todos'){$filtro= " WHERE nombre LIKE '%".$_POST["buscar"]."%' AND fecha BETWEEN '".$_POST["buscafechadesde"]."' AND '".$_POST["buscafechahasta"]."' AND color = '".$_POST["color"]."' ";}
                                    if($_POST["buscar"] == '' AND $_POST["buscadepartamento"] != 'Todos' AND $_POST["buscafechadesde"] == '' AND $_POST["color"] != 'Todos'){$filtro= " WHERE nombre LIKE '%".$_POST["buscar"]."%' AND departamento = '".$_POST["buscadepartamento"]."' AND color = '".$_POST["color"]."' ";}
                                    if($_POST["buscar"] != '' AND $_POST["buscadepartamento"] != 'Todos' AND $_POST["buscafechadesde"] == '' AND $_POST["color"] != 'Todos'){$filtro= " WHERE nombre LIKE '%".$_POST["buscar"]."%' AND departamento = '".$_POST["buscadepartamento"]."' AND color = '".$_POST["color"]."' ";}
                                    if($_POST["buscar"] != '' AND $_POST["buscadepartamento"] == 'Todos' AND $_POST["buscafechadesde"] != '' AND $_POST["color"] == 'Todos'){$filtro=  " WHERE nombre LIKE '%".$_POST["buscar"]."%' AND fecha BETWEEN '".$_POST["buscafechadesde"]."' AND '".$_POST["buscafechahasta"]."'";}
                                    if($_POST["buscar"] == '' AND $_POST["buscadepartamento"] == 'Todos' AND $_POST["buscafechadesde"] == '' AND $_POST["color"] != 'Todos'){$filtro=  " WHERE color = '".$_POST["color"]."'";}
                                    if($_POST["buscar"] != '' AND $_POST["buscadepartamento"] == 'Todos' AND $_POST["buscafechadesde"] == '' AND $_POST["color"] != 'Todos'){$filtro=  " WHERE nombre LIKE '%".$_POST["buscar"]."%' AND color = '".$_POST["color"]."' ";}                           

                                    
                                }
                                
                                $sentenciaSQL= $connection->prepare("SELECT * FROM datos $filtro");
                                $sentenciaSQL->execute();
                                $numeroSql = $sentenciaSQL->fetchall(PDO::FETCH_ASSOC);
                             ?>
                             <p style="font-weight: bold; color:green;"><i class="mdi mdi-file-document"></i> Resultados encontrados <?php if ($numeroSql == null){echo(": 0");} ?></p>
                         </form>
                         <div class="table-responsive">
                             <table class="table">
                                 <thead>
                                     <tr style="backround-color: #00695c; color:#FFFFF">
                                        <th style=" text-align: center;">Nombre</th>
                                        <th style=" text-align: center;">Depertamento</th>
                                        <th style=" text-align: center;">Color</th>
                                        <th style=" text-align: center;">Fecha</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                    <?php 

                                       foreach($numeroSql as $rowSql){
                                    ?>
                                    <tr>
                                        <td style="text-align: center";><?php echo $rowSql["nombre"]; ?></td>
                                        <td style="text-align: center";><?php echo $rowSql["departamento"]; ?></td>
                                        <td style="text-align: center";><?php echo $rowSql["color"]; ?></td>
                                        <td style="text-align: center";><?php echo $rowSql["fecha"]; ?></td>

                                    </tr>
                                    <?php } ?>
                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
</div>
</body>
</html>