var Lim_sup = 14,
    Lim_inf = 0,
    TimeBefore = 12; 
var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

var lineChartData = {
    
    labels : (function() {
                    // generate an array of random data
                    var data = [],
                        time = (new Date()).getTime(),
                        hora = (new Date()).getHours(),
                        pi = 3.14159,
                        i;
                        
    
                    for (i = -12*TimeBefore; i <= 0; i++) {   //para que paresca muestra de un dia, utilizar i= -288
                        data.push(
                            x: time + i * 300000
                            //y: Math.random()*0.5+(-Math.cos((hora+(i*24/288))*pi/12)*0.75)+24.3
                            //y: -Math.cos((hora+(i*24/288))*pi/12)*2
                        );
                    }
                    return data;
                })(),
    datasets : [
        {
            label: "PH",
            fillColor : "rgba(220,220,0,0)",       //Fondo
            strokeColor : "rgba(220,220,0,1)",     //Linea
            pointColor : "rgba(220,220,0,1)",      //Punto
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "rgba(220,220,220,1)",
            data : (function() {
                    // generate an array of random data
                    var data = [],
                        hora = (new Date()).getHours(),
                        pi = 3.14159,
                        i;
                        
    
                    for (i = -12*TimeBefore; i <= 0; i++) {   //para que paresca muestra de un dia, utilizar i= -288
                        data.push(
                            //x: time + i * 300000
                            y: Math.random()*0.5+(-Math.cos((hora+(i*24/288))*pi/12)*0.75)+24.3
                            //y: -Math.cos((hora+(i*24/288))*pi/12)*2
                        );
                    }
                    return data;
                })()
        },
        {
            label: "Limite Superior",
            fillColor: "rgba(151,187,205,0)",
            strokeColor: "rgba(151,187,205,0)",
            pointColor: "rgba(151,187,205,0)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: (function() {
                    // generate an array of random data
                    var data = [],
                            
                    for (i = -12*TimeBefore; i <= 0; i++) {   //para que paresca muestra de un dia, utilizar i= -288
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
                            
                    for (i = -12*TimeBefore; i <= 0; i++) {   //para que paresca muestra de un dia, utilizar i= -288
                        data.push(
                            Lim_sup
                        );
                    }
                    return data;
                })()
        }
    ]

}



function nuevo_dato (Linea){
            
        var a = new Date();
          var months = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
          var month = months[a.getMonth()];
          var date = a.getDate();
          var hour = a.getHours();
          var min = a.getMinutes();
          var sec = a.getSeconds();
          var time = hour + ':' + min ;

    var hora1 = (new Date()).getHours(),
        pi1 = 3.14159,
        y = Math.random()*0.25+(-Math.cos((hora1)*pi1/12)*0.4)+7;
        y = (Math.floor(y*100))/100;
    var new_data1 = randomScalingFactor();
    var new_data2 = "August";
    Linea.addData([ y, Lim_sup, Lim_inf] ,time);
    Linea.removeData();
    setTimeout(function(){
        nuevo_dato(Linea);
    }, 5000);
}

window.onload = function(){
    var ctx = document.getElementById("myChart").getContext("2d");
    var Milinea = new Chart(ctx).Line(lineChartData, {
        animation: true,
        responsive: true
    });
    nuevo_dato (Milinea);
}