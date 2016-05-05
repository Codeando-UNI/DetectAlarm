<?php
$id_equipo = 1;
$id_parametro = 1;
?>

<script>
var EstPH = 0,
    EstTemp = 0;
var MyLine,     // Esta es la linea de la grafica que se presenta
    ctx;
    
function GenerateChart (id_equipo, id_parametro, periodo, IdChart, parametro){
    var ArrayDataTime = {},
        ChartData = {};
    
    // Programa Ajax para pedir DataTime
    $parametros = {
            'boton-obtener-data-tiempo' : true,
            'id_equipo' : id_equipo,
            'id_parametro' : id_parametro
        };
        
    $url = "monitoreo/chart.DataTime.php";
    $.ajax({
        type: "POST",
        url: $url,
        data: $parametros,
        dataType : "json",
        success: function(data){
            ArrayDataTime = data;
            var LimSup = ArrayDataTime.LimSup,
                LimInf = ArrayDataTime.LimInf,
                lastID = ArrayDataTime.lastID;
            
            ChartData = CargarData (ArrayDataTime.DataTime,  ArrayDataTime.DataValue, LimSup, LimInf);
            $("#LastData").html("&Uacute;ltimo Valor: "+ArrayDataTime.DataValue[ArrayDataTime.long-1]);
            ctx = document.getElementById(IdChart).getContext("2d");
            //MyLine = new Chart(ctx).Line(ChartData, {animation: true, responsive: true});
            MyLine = new Chart(ctx).Line(ChartData, {animation: true, responsive: true});
            GenerateAnimationChart (id_equipo, id_parametro, LimSup, LimInf, periodo, lastID, parametro);      
        }
    });
}    


function GenerateAnimationChart (id_equipo, id_parametro, superior, inferior, periodo, lastID, parametro){
    
    if (parametro == 1 && EstPH == 0 ){
        EstPH = 1;
        EstTemp = 0;
        nuevo_dato (id_equipo, id_parametro, superior, inferior, periodo, lastID ,parametro);
    }
    
    if (parametro == 2 && EstTemp == 0){
        EstPH = 0;
        EstTemp = 1;
        nuevo_dato (id_equipo, id_parametro, superior, inferior, periodo, lastID, parametro);
    }
    
}
    
function CargarData (labelsDataTime, DatasetDataTime, superior, inferior) {
    var LimSup = superior,
        LimInf = inferior,
        longDataTime = labelsDataTime.length;
    
    var data = {
        labels: labelsDataTime,
        datasets: [
            {
                label: "Parametro",
                fillColor : "rgba(220,220,0,0)",       //Fondo
                strokeColor : "rgba(220,220,0,1)",     //Linea
                pointColor : "rgba(220,220,0,1)",      //Punto
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(220,220,220,1)",
                data: DatasetDataTime
            }/*,
            {
                label: "Limite Superior",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,0)",
                pointColor: "rgba(151,187,205,0)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: (function() {
                        var data = [];
                        for (var i = 0; i < longDataTime; i++) {
                            data.push( LimSup );
                        }
                        return data;
                    })()
            },
            {
                label: "Limite Inferior",
                fillColor: "rgba(151,187,205,0)",
                strokeColor: "rgba(151,187,205,0)",
                pointColor: "rgba(151,187,205,0)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: (function() {
                        var data = [];
                        for (var i = 0; i < longDataTime; i++) {
                            data.push( LimInf );
                        }
                        return data;
                    })()
            }*/
        ]
    };
    return data;
}

function nuevo_dato (id_equipo, id_parametro, superior, inferior, periodo , lastID, parametro){
    var bucle = 1,
        ArrayNew = {},
        ArrayNewDataTime = [],
        ArrayNewValues = [],
        LongArrayNew = 0,
        id_monitoreo = lastID,
        LimSup = superior,
        LimInf = inferior;
    //alert(id_monitoreo);
    
    if (parametro == 1){
        if (EstPH == 0) {bucle = 0;}
    }
    if (parametro == 2){
        if (EstTemp == 0) {bucle = 0;}
    }
    if (bucle == 1){
        
        $parametros = {
            'boton-obtener-new-data-time' : true,
            'id_equipo' : id_equipo,
            'id_parametro' : id_parametro,
            'lastID' : id_monitoreo
        };
        $url = "monitoreo/chart.NewDataTime.php";
        $.ajax({
            type: "POST",
            url: $url,
            data: $parametros,
            dataType : "json",
            success: function(data){
                ArrayNew = data;
                ArrayNewDataTime = ArrayNew.DataTime;
                ArrayNewValues = ArrayNew.DataValue;
                LongArrayNew = ArrayNew.long;
                if(LongArrayNew != 0 ){
                    id_monitoreo = ArrayNew.lastID;
                    var y,x;
                    for (var i=0; i<LongArrayNew; i++){
                        y = ArrayNewValues[i];
                        x = ArrayNewDataTime[i];
                        MyLine.addData([ y, LimSup, LimInf] ,x);
                        MyLine.removeData();
                    }
                    $("#LastData").html("&Uacute;ltimo valor: "+ArrayNewValues[LongArrayNew-1]);
                }
                setTimeout(function(){ nuevo_dato (id_equipo, id_parametro, superior, inferior, periodo, id_monitoreo, parametro);}, periodo);
            }
        });
    }
}  

</script>