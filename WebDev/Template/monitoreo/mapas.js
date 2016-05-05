var map, marker;
  function initialize() {
    var posicion = new google.maps.LatLng(-12.010915, -77.050718);
    var mapOptions = {
      zoom: 17,
      center: posicion,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    var iconoMarcador = "../img/PointSensor.png";
    marker = new google.maps.Marker({
      position: posicion,
      icon: iconoMarcador,
      map: map,
      title:"EMT1-CITRAR_UNI",
      animation: google.maps.Animation.DROP
    });
    google.maps.event.addListener(marker, 'click', mostrarInfo);
      google.maps.event.addListener(marker, 'click', MostrarCuadroEMT);
      
        function mostrarInfo() {
    var infowindow = new google.maps.InfoWindow({
      content: 'Estacion',
    });
    infowindow.open(map, marker);
    setTimeout(function () { infowindow.close(); }, 5000);
  }

    function MostrarCuadroEMT () {
        $( "#map-canvas" ).removeClass( "col-md-12" ).addClass( "col-md-6" );
        $( "#container" ).removeClass( "col-md-12" ).addClass( "col-md-6" );
        map.setCenter(marker.getPosition());
        CargarCuadroGraficas ();
        
    }
      
  }

  

google.maps.event.addDomListener(window, 'load', initialize);
