<?php  
require_once ("../../require/conexion_class.php");
require_once ("../../require/RelacionEquipo_class.php");
require_once ("../../require/parametros_class.php");

$id_equipo = $_POST["id_equipo"];

$RelacionEquipo = new RelacionEquipo();
$parametros = new parametros();
$primerParametro = 0;

?>

<div class="col-md-12">
    
    <!-- Cabecera de Parametros del Cuadro -->
    <div class="col-md-12 col-xs-12" id="HeaderCuadro" >
        <ul class="nav nav-tabs" role="tablist" id="MyTab">
<?php 
$RelacionEquipo->mostrar_valores($id_equipo);

while($valores = $RelacionEquipo->retornar_SELECT()){
    $id_parametro = $valores["id_parametro"];
    if($id_parametro<$primerParametro or $primerParametro == 0){
        $primerParametro = $id_parametro;
    }
    $val = $parametros->ObtenerParametro($id_parametro);
?>            
            <li role="presentation" onclick="verGraf(<?php echo $id_parametro;?>)" >
                <a href="#" aria-controls="<?php echo $val["Nombre"];?>" role="tab" data-toggle="tab"><?php echo $val["Nombre"];?></a>
            </li>
<?php
}
?>
        </ul>
    </div>
    <!-- Fin de Cabecera -->
    
    <!-- Tablero de Configuracion del Cuadro -->
    <div class="col-md-12 col-xs-12" id="ConfiguracionCuadro" >
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" >
                  <img src="../img/logos/Gota_Waposat_117x147.png" alt="Brand" height="100%">
              </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse text-center" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li>
                    <p class="navbar-text" id="fecha-text">
                        Día: 31-Abr 18h
                    </p>
                </li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><p id="TiempoMuestraBtn">1hora</p><span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#" onclick="CambiarNumData (10);" >10puntos</a></li>
                    <li><a href="#" onclick="CambiarNumData (20);" >20puntos</a></li>
                    <li><a href="#" onclick="CambiarNumData (25);" >25puntos</a></li>
                    <li class="divider"></li>
                    <li><a href="#" onclick="CambiarNumData (50);" >50puntos</a></li>
                    <li><a href="#"  onclick="CambiarNumData (100);" >100puntos</a></li>  
                  </ul>
                </li>
                <li>
                    <p class="navbar-text" id="limites-text">
                        Límites: 0-14
                    </p>
                </li>
                <li>
                  <a href="#" class="dropdown-toggle" data-toggle="modal" role="button" data-target="#myModal"><i class="fa fa-cog"></i></a>
                </li>  
              </ul>      
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
        
        <!-- Ventana de Configuracion -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Configuración de los Limites</h4>
              </div>
              <div class="modal-body">
                  <!-- Contenido Ventana -->
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Limite Sup.</span>
                    <input type="text" class="form-control" id="var-lim-sup" placeholder="14" aria-describedby="basic-addon1">
                    <span class="input-group-addon" id="unid-medida-sup">g/ml</span>  
                  </div>
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Limite Inf. </span>
                    <input type="text" class="form-control" id="var-lim-inf" placeholder="0" aria-describedby="basic-addon1">
                    <span class="input-group-addon" id="unid-medida-inf">g/ml</span>
                  </div>
                  <!-- Fin del Contenido Ventana -->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar Cambios</button>
              </div>
            </div>
          </div>
        </div> <!-- Fin de la Ventana de Configuracion -->
        
    </div>
    <!-- Fin del Tablero de Configuracion -->
    
    <!-- Zona de Avisos del Cuadro -->
    <div class="col-md-12 col-xs-12" >
        <p>Limites máximos establecidos por la Organización Mundial de la Salud.</p>
    </div>
    <div class="col-md-12 col-xs-12" id="AvisosCuadro">
        
    </div>
    <!-- Fin de la Zona de Avisos -->
    
    <!-- Tablero de Informacion -->
    <div class="col-md-12 col-xs-12" id="InformacionCuadro" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row btn-grup">
                    <div class="col-xs-12 col-md-4 btn btn-default">
                        <div class="media">
                          <div class="media-center col-md-5 col-xs-4">
                            <div id="var-arrow-down"><i class="fa fa-arrow-circle-down fa-5x "></i>
                            </div>
                            <div id="var-arrow-up" ><i class="fa fa-arrow-circle-up fa-5x "></i></div>  
                          </div>
                          <div class=" text-left col-md-7 col-xs-8 ">
                            
                            <h4 class="col-md-12 col-xs-12"><strong id="val-var">0.15</strong></h4>
                            <h4 class="col-md-12 col-xs-12"><strong id="val-varx100">0.11%</strong></h4>
                          </div>
                        </div>
                    </div>
                    <div id="face-cuadro" class="col-xs-6 col-md-4 text-center btn btn-success">
                        <p>Última Medida:<small><strong id="val-final">7.45</strong></small></p>
                        <p>Medida Inicial:<small><strong id="val-ini">7.21</strong></small></p>
                        <p><i id="val-face-good" class="fa fa-smile-o fa-2x"></i><i id="val-face-bad"class="fa fa-frown-o fa-2x"></i></p>
                    </div>
                    <div id="extremos-cuadro" class="col-xs-6 col-md-4 text-center btn btn-default">
                        <p>Máximo:<small><strong id="val-max">7.80</strong></small></p>
                        <p>Media:<small><strong id="val-medio">7.53</strong></small></p>
                        <p>Mínimo:<small><strong id="val-min">7.10</strong></small></p>
                    </div>
                </div>
            </div>
            <div class="panel-body col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1" >
                <canvas id="myChart" class="col-md-12 col-xs-10"></canvas>
            </div>
        </div>
    </div>
    <!-- Fin Tablero de Informacion -->    
</div>

<script>
    var id_equipo_rec = <?php echo $id_equipo;?>;
    function verGraf(id_parametro){
       GenerateChart (id_equipo_rec , id_parametro, 1000, "myChart",20); 
    }
    
    $( document ).ready(function() {
        verGraf(<?php echo $primerParametro;?>);
    });
</script>
