<?php
$id_equipo = 1;
$id_cliente = 1;
$NameEstation = "Estaci&oacute;n de PRUEBA";
?>

<script>
  
  function PutDate(){
    var a = new Date();
    var months = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
    var month = months[a.getMonth()];
    var date = a.getDate();
    var FechaActual = date + ' - ' + month;
    
    $("#fecha").html(FechaActual);
  }
  
  $(function(){
        $("#MPH").click(function(){
            GenerateChart (1, 1, 5000, "myChart", 1);
        });
    });

    $(function(){
        $("#MTemp").click(function(){
            GenerateChart (1, 2, 5000, "myChart", 2);
        });
    });
  
    /*$(function () {
        $('#myTab a:last').tab('show')
    })*/
  PutDate();
    
</script>

<div class="col-md-12">
    <blockquote>
        <h2><?php echo $NameEstation; ?><small id="fecha"></small></h2>
        <div id="LastData"> </div>
    </blockquote>
</div>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist" id="myTab">
  <li role="presentation" class="active" id="MPH"><a href="#PH" aria-controls="PH" role="tab" data-toggle="tab">PH</a></li>
  <li role="presentation" id="MTemp" ><a href="#Temperatura" aria-controls="Temperatura" role="tab" data-toggle="tab">Temperatura</a></li>
</ul>
<!--
<div class="tab-content">
  <div role="tabpanel" class="tab-pane col-md-12" id="PH">PH <br> <canvas id="ChartPH"></canvas></div>
  <div role="tabpanel" class="tab-pane col-md-12" id="Temperatura">temperatura <br> <canvas id="ChartTemp"></canvas></div>
</div>
-->
<div class="col-md-10 col-md-offset-1">
    <canvas id="myChart" height="50%"></canvas>
</div>

