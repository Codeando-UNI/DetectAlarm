<script>
    $(function(){
        $("#GrafPH").click(function(){
            var data = CargarData (7, 14, 0, 2, 1800);
        var ctx = document.getElementById("myChart").getContext("2d");
        var MyLine = new Chart(ctx).Line(data, {animation: true, responsive: true});
        animar_grafica (MyLine, 7, 14, 0, 1800, 1);
        });
    });

    $(function(){
        $("#GrafTemp").click(function(){
            var data = CargarData (24, 35, 0, 2, 1800);
        var ctx = document.getElementById("myChart").getContext("2d");
        var MyLine = new Chart(ctx).Line(data, {animation: true, responsive: true});
        animar_grafica (MyLine, 24, 35, 0, 1800, 2);
        });
    });
    
    var a = new Date();
    var months = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
    var month = months[a.getMonth()];
    var date = a.getDate();
    var FechaActual = date + ' - ' + month;
    
    $("#fecha").html(FechaActual);

</script>

<div class="col-md-12">
    <blockquote>
        <h2>Estaci&oacute;n CITRAR-UNI.<small id="fecha"></small></h2>
    </blockquote>
</div>
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li role="presentation" class="active"><a href="#home" role="tab" data-toggle="tab" id="GrafPH" >PH</a></li>
    <li role="presentation"><a href="#profile" role="tab" data-toggle="tab" id="GrafTemp" >Temperatura</a></li>
</ul>

<div class="col-md-12">
    <canvas id="myChart"></canvas>
</div>