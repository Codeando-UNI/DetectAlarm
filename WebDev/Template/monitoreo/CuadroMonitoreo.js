var EstPH = 0,
    EstTemp = 0;
var MyLine,     // Esta es la linea de la grafica que se presenta
    ctx;
//$("#LastData").html("&Uacute;ltimo Valor: "+ArrayDataTime.DataValue[ArrayDataTime.long-1]);
var id_equipo=0,
    id_parametro=0,
    varLimSup=0,
    varLimInf=0,
    lastID=0,
    periodo=1000,
    numData = 20,
    AnimationState=0,    
    IDChart="myChart";
// Variables del cuadro
var fechaText,
    TiempoMuestraBtn,
    limitesText,
    unidMedida,
    varArrow,
    valVar,
    valVarx100,
    valFinal,
    valIni,
    valFace,
    valMax,
    valMedio,
    longData = 0,
    valMin;

$(function(){
    $("#MTemp").click(function(){
        GenerateChart (1, 2, 1000, "myChart",20);
    });
});

function GenerateChart (id_equipo_env, id_parametro_env, periodo_env, IdChart_env,numData_env){
    id_equipo = id_equipo_env;
    id_parametro = id_parametro_env;
    periodo = periodo_env;
    IdChart = IdChart_env;
    numData = numData_env;
    
    if (AnimationState == 0){
    
        var ArrayDataTime = {},
            ChartData = {};

        // Programa Ajax para pedir DataTime
        $parametros = {
            'boton-obtener-data-tiempo' : true,
            'id_equipo' : id_equipo,
            'id_parametro' : id_parametro,
            'size' : numData
        };

        $url = "monitoreo/chart.DataTime2.php";
        $.ajax({
            type: "POST",
            url: $url,
            data: $parametros,
            dataType : "json",
            success: function(data){
                ArrayDataTime = data;
                varLimSup = ArrayDataTime.varLimSup,
                varLimInf = ArrayDataTime.varLimInf,
                lastID = ArrayDataTime.lastID;
                fechaText = ArrayDataTime.fechaText;
                TiempoMuestraBtn = ArrayDataTime.TiempoMuestraBtn;
                limitesText = ArrayDataTime.limitesText;
                unidMedida = ArrayDataTime.unidMedida;
                varArrow = ArrayDataTime.varArrow;
                valVar = ArrayDataTime.valVar;
                valVarx100 = ArrayDataTime.valVarx100;
                valFinal = ArrayDataTime.valFinal;
                valIni = ArrayDataTime.valIni;
                valFace = ArrayDataTime.valFace;
                valMax = ArrayDataTime.valMax;
                valMedio = ArrayDataTime.valMedio;
                valMin = ArrayDataTime.valMin;


                    longData = ArrayDataTime.long;
                    ChartData = CargarData (ArrayDataTime.DataTime,  ArrayDataTime.DataValue);
                    ctx = document.getElementById(IdChart).getContext("2d");
                    MyLine = new Chart(ctx).Line(ChartData, {animation: true, responsive: true});

                GenerateAnimationChart ();      
            }
        });
    } else {
        CambiarGrafica ();
    }
}    


function GenerateAnimationChart (){
    if (AnimationState == 0){
        nuevo_dato ();
        AnimationState = 1;
    }
}
    
function CargarData (labelsDataTime, DatasetDataTime) {
    var longDataTime = labelsDataTime.length;
    
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
            }
        ]
    };
    return data;
}

function nuevo_dato (){
    var ArrayNew = {},
        ArrayNewDataTime = [],
        ArrayNewValues = [],
        LongArrayNew = 0;
    

    $parametros = {
        'boton-obtener-new-data-time' : true,
        'id_equipo' : id_equipo,
        'id_parametro' : id_parametro,
        'lastID' : lastID,
        'size' : numData
    };
    $url = "monitoreo/chart.NewDataTime2.php";
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
            
            //Carga de datos extra
            varLimSup = ArrayNew.varLimSup;
            varLimInf = ArrayNew.varLimInf;
            fechaText = ArrayNew.fechaText;
            TiempoMuestraBtn = ArrayNew.TiempoMuestraBtn;
            limitesText = ArrayNew.limitesText;
            unidMedida = ArrayNew.unidMedida;
            varArrow = ArrayNew.varArrow;
            valVar = ArrayNew.valVar;
            valVarx100 = ArrayNew.valVarx100;
            valFinal = ArrayNew.valFinal;
            valIni = ArrayNew.valIni;
            valFace = ArrayNew.valFace;
            valMax = ArrayNew.valMax;
            valMedio = ArrayNew.valMedio;
            valMin = ArrayNew.valMin;
            
            if(LongArrayNew != 0 ){
                lastID = ArrayNew.lastID;
                var y,x;
                for (var i=0; i<LongArrayNew; i++){
                    y = ArrayNewValues[i];
                    x = ArrayNewDataTime[i];
                    MyLine.addData([y],x);
                    MyLine.removeData();
                }
            }
            ActualizarInformacion();
            setTimeout(function(){ nuevo_dato();}, periodo);
        }
    });
    
}  

function ActualizarInformacion(){
    $("#fecha-text").html(fechaText);
    $("#TiempoMuestraBtn").html(TiempoMuestraBtn);
    $("#limites-text").html(limitesText);
    $("#var-lim-sup").html(varLimSup);
    $("#var-lim-inf").html(varLimInf);
    $("#unid-medida-sup").html(unidMedida);
    $("#unid-medida-inf").html(unidMedida);
    $("#val-var").html(valVar);
    $("#val-varx100").html(valVarx100);
    $("#val-final").html(valFinal);
    $("#val-ini").html(valIni);
    $("#val-max").html(valMax);
    $("#val-medio").html(valMedio);
    $("#val-min").html(valMin);
    // Cambiando las figuras
    
    if (varArrow == 1){
        $( "#var-arrow-down" ).hide();
        $( "#var-arrow-up" ).show();
    } else {
        $( "#var-arrow-up" ).hide();
        $( "#var-arrow-down" ).show();
    }
    
    $( "#face-cuadro" ).removeClass("btn-success btn-danger");
    
    if (valFace == 0){
        $( "#val-face-bad" ).hide();
        $( "#val-face-good" ).show();
        $( "#face-cuadro" ).addClass("btn-success");
    } else {
        $( "#val-face-good" ).hide();
        $( "#val-face-bad" ).show();
        $( "#face-cuadro" ).addClass("btn-danger");
    }
    
    $( "#extremos-cuadro" ).removeClass("btn-success btn-danger");
    
    if (valMax < varLimSup && valMin > varLimInf){
        $( "#extremos-cuadro" ).addClass("btn-success");
    } else {
        $( "#extremos-cuadro" ).addClass("btn-danger");
    }
        
}

function CambiarNumData (newNumData){
    numData = newNumData;
    GenerateChart (id_equipo, id_parametro, periodo, IdChart,numData);
}

function CambiarGrafica (){
    var ArrayDataTime = {},
        ChartData = {},
        longDataTmp = longData;
    // Programa Ajax para pedir DataTime
    $parametros = {
        'boton-obtener-data-tiempo' : true,
        'id_equipo' : id_equipo,
        'id_parametro' : id_parametro,
        'size' : numData
    };
        
    $url = "monitoreo/chart.DataTime2.php";
    $.ajax({
        type: "POST",
        url: $url,
        data: $parametros,
        dataType : "json",
        success: function(data){
            
            ArrayDataTime = data;
            ArrayNewDataTime = ArrayDataTime.DataTime;
            ArrayNewValues = ArrayDataTime.DataValue;
            varLimSup = ArrayDataTime.varLimSup,
            varLimInf = ArrayDataTime.varLimInf,
            lastID = ArrayDataTime.lastID;
            fechaText = ArrayDataTime.fechaText;
            TiempoMuestraBtn = ArrayDataTime.TiempoMuestraBtn;
            limitesText = ArrayDataTime.limitesText;
            unidMedida = ArrayDataTime.unidMedida;
            varArrow = ArrayDataTime.varArrow;
            valVar = ArrayDataTime.valVar;
            valVarx100 = ArrayDataTime.valVarx100;
            valFinal = ArrayDataTime.valFinal;
            valIni = ArrayDataTime.valIni;
            valFace = ArrayDataTime.valFace;
            valMax = ArrayDataTime.valMax;
            valMedio = ArrayDataTime.valMedio;
            valMin = ArrayDataTime.valMin;
            longData = ArrayDataTime.long;
            lastID = ArrayDataTime.lastID;
            
            var y,x;
            for (var i=0; i<longData; i++){
                y = ArrayNewValues[i];
                x = ArrayNewDataTime[i];
                MyLine.addData([y],x);
            }
            
            for (var i=0; i<longDataTmp; i++){
                    MyLine.removeData();
            }
            
            GenerateAnimationChart ();      
        }
    });
}
