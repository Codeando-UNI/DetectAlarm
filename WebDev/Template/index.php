<!DOCTYPE html>
<html lang="es">

<head>
    <title>WAPOSAT</title>
    
    <?php  include_once("../include/head.default.php");?>
    
    <!-- Especific CSS -->
    <link href="monitoreo/style.monitoreo.css" rel="stylesheet">
    
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    
    <!-- Especific JS -->
    <?php  //include_once("monitoreo/maps.scriptJS.php"); ?>
    <script src="../js/Chart.js"></script>
    <script src="DemostrationLAN/DemostrationLAN.js"></script>
    <!-- <script src="monitoreo/GenericChart.js"></script> -->
    <script src="monitoreo/CuadroMonitoreo.js"></script>
    <script>
        window.onload = function(){
           CargarCuadroGraficas ();
        }
    </script>
    
</head>

<body>
    
    <!-- Navigation -->
    <?php include_once("../include/navbar.default.php"); ?>
    
    <!-- Body -->
    <div class="tab-content">
        <!-- Container -->
        <div id="container" class="col-xs-12 col-md-12">
            <div id="information"  >
                
            </div> <!-- information -->
        </div> <!-- /Container -->
    </div> <!-- /Body -->
    
    <!-- Footer -->
    <?php include_once("../include/footer.default.php"); ?>
    
    
</body>
    
</html>