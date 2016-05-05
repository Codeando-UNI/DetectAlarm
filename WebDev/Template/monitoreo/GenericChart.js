var EstPH = 0,
    EstTemp = 0;


function CargarData (MPoint, superior, inferior, tiempoAntes, Periodo) {
    var Lim_sup = superior,
        Lim_inf = inferior,
        TimeBefore = tiempoAntes,     //horas
        Tmuestreo = Periodo,   //segundos
        PuntoMedio = MPoint;
    var data = {
        labels: (function() {
                        // generate an array of random data
                        var data = [],
                            time = (new Date()).getTime(),
                            i;

                        for (i = -12*TimeBefore; i <= 0; i++) {
                            var newTime = (time + (i * 1800000)),
                                dateB = new Date(newTime),
                                hourB = dateB.getHours(),
                                minuteB = dateB.getMinutes(),
                                timeB = hourB + ':' + minuteB;
                            data.push(
                                timeB
                            );
                        }
                        return data;
                    })(),
        datasets: [
            {
                label: "PH",
                fillColor : "rgba(220,220,0,0)",       //Fondo
                strokeColor : "rgba(220,220,0,1)",     //Linea
                pointColor : "rgba(220,220,0,1)",      //Punto
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(220,220,220,1)",
                data: (function() {
                        // generate an array of random data
                        var data = [],
                            hora = (new Date()).getHours(),
                            pi = 3.14159,
                            i;

                        for (i = -12*TimeBefore; i <= 0; i++) {
                            var y = Math.random()*0.5+(-Math.cos((hora+(i*24/288))*pi/12)*0.75)+PuntoMedio;
                            y = (Math.floor(y*100))/100;
                            data.push(
                                y
                            );
                        }
                        return data;
                    })()
            },
            {
                label: "Limite Superior",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,0)",
                pointColor: "rgba(151,187,205,0)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: (function() {
                        // generate an array of random data
                        var data = [],
                            i;
                        for (i = -12*TimeBefore; i <= 0; i++) {
                            data.push(
                                Lim_sup
                            );
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
                        // generate an array of random data
                        var data = [],
                            i;
                        for (i = -12*TimeBefore; i <= 0; i++) {
                            data.push(
                                Lim_inf
                            );
                        }
                        return data;
                    })()
            }
        ]
    };
    
    return data;
}


function animar_grafica (Linea, MPoint, Lim_sup, Lim_inf, frecuencia ,parametro){
    if (parametro == 1 && EstPH == 0 ){
        EstPH = 1;
        EstTemp = 0;
        nuevo_dato (Linea, MPoint, Lim_sup, Lim_inf, frecuencia ,parametro);
    }
    
    if (parametro == 2 && EstTemp == 0){
        EstPH = 0;
        EstTemp = 1;
        nuevo_dato (Linea, MPoint, Lim_sup, Lim_inf, frecuencia ,parametro);
    }
}


function nuevo_dato (Linea, MPoint, Lim_sup, Lim_inf, frecuencia ,parametro){
            
        var a = new Date(),
            hour = a.getHours(),
            min = a.getMinutes(),
            //sec = a.getSeconds(),
            //time = hour + ':' + min+ ':'+ sec ,
            time = hour + ':' + min,
            bucle = 1,
            pi = 3.14159,
        y = Math.random()*0.25+(-Math.cos((hour)*pi/12)*0.4)+ MPoint;
        y = (Math.floor(y*100))/100;
    
    if (parametro == 1){
        if (EstPH == 0) {bucle = 0;}
    }
    
    if (parametro == 2){
        if (EstTemp == 0) {bucle = 0;}
    }
    if (bucle == 1){
        Linea.addData([ y, Lim_sup, Lim_inf] ,time);
        Linea.removeData();
        setTimeout(function(){
            nuevo_dato (Linea, MPoint, Lim_sup, Lim_inf, frecuencia ,parametro);
        }, frecuencia);
    }
}