<?php
$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
class coord {
    var $lat;
    var $lng;
}
$conn = mysql_connect($dbhost, $dbuser, $dbpass);

if(!$conn)
{
    die('Không thể kết nối: ' . mysql_error());
}
$pID = "";

// $sql_place = 'select pID, pName, pSlug, pCenterLat, pCenterLng from tbl_place';
// $sql_coordinate = 'select pcLat, pcLng from tbl_place_coordinates where pID = ' . $pID;
$sql_coordinate_1 = 'select pcLat, pcLng from tbl_place_coordinates where pID = 1';
$sql_coordinate_2 = 'select pcLat, pcLng from tbl_place_coordinates where pID = 2';
$sql_coordinate_4 = 'select pcLat, pcLng from tbl_place_coordinates where pID = 4';
$sql_coordinate_5 = 'select pcLat, pcLng from tbl_place_coordinates where pID = 5';
$sql_coordinate_6 = 'select pcLat, pcLng from tbl_place_coordinates where pID = 6';
mysql_select_db('googlemaps');
$retval = mysql_query( $sql_coordinate_1, $conn );
$retval_2 = mysql_query( $sql_coordinate_2, $conn );
$retval_4 = mysql_query( $sql_coordinate_4, $conn );
$retval_5 = mysql_query( $sql_coordinate_5, $conn );
$retval_6 = mysql_query( $sql_coordinate_6, $conn );
if(! $retval )
{
    die('Không thể lấy dữ liệu: ' . mysql_error());
}

$array = [];
while($row = mysql_fetch_array($retval, MYSQL_ASSOC))
{
    $array[]='{lat:' . $row['pcLat'] . ', lng: ' . $row['pcLng'] . '}';
}

$array2 = [];
while($row = mysql_fetch_array($retval_2, MYSQL_ASSOC))
{
    $array2[]='{lat:' . $row['pcLat'] . ', lng: ' . $row['pcLng'] . '}';
}

$array4 = [];
while($row = mysql_fetch_array($retval_4, MYSQL_ASSOC))
{
    $array4[]='{lat:' . $row['pcLat'] . ', lng: ' . $row['pcLng'] . '}';
}

$array5 = [];
while($row = mysql_fetch_array($retval_5, MYSQL_ASSOC))
{
    $array5[]='{lat:' . $row['pcLat'] . ', lng: ' . $row['pcLng'] . '}';
}
$array6 = [];
while($row = mysql_fetch_array($retval_6, MYSQL_ASSOC))
{
    $array6[]='{lat:' . $row['pcLat'] . ', lng: ' . $row['pcLng'] . '}';
}

mysql_close($conn);
?>

  <!DOCTYPE html>
  <html>

  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Polygon Arrays</title>
    <style>
      #map {
        height: 100%;
      }
      
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
    <!--<script src="js/Javascript.js"></script>-->
  </head>

  <body>
    <div id="map"></div>
    <script>
      var map;
      var infoWindow;
      var BinhThanh = <?php
$_string = str_replace('"','',json_encode($array));
$_string = str_replace(' ','',$_string);
$_string = str_replace('\t','',$_string);
echo $_string; ?>;

      var BinhChanh = <?php
$_string = str_replace('"','',json_encode($array2));
$_string = str_replace(' ','',$_string);
$_string = str_replace('``','',$_string);
$_string = str_replace('\t','',$_string);
echo $_string; ?>;

      var Quan1 = <?php
$_string = str_replace('"','',json_encode($array4));
$_string = str_replace(' ','',$_string);
$_string = str_replace('``','',$_string);
$_string = str_replace('\t','',$_string);
echo $_string; ?>;

      var PhuongCauKho = <?php
$_string = str_replace('"','',json_encode($array5));
$_string = str_replace(' ','',$_string);
$_string = str_replace('``','',$_string);
$_string = str_replace('\t','',$_string);
echo $_string; ?>;

      var PhuongDaKao = <?php
$_string = str_replace('"','',json_encode($array6));
$_string = str_replace(' ','',$_string);
$_string = str_replace('``','',$_string);
$_string = str_replace('\t','',$_string);
echo $_string; ?>;

      var HoChiMinh = [BinhChanh, BinhThanh, Quan1];

      var W_Quan1 = [PhuongCauKho, PhuongDaKao];

      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 11,
          center: {
            lat: 10.801618,
            lng: 106.733319
          },
          mapTypeId: 'terrain'
        });

        for (i = 0; i < HoChiMinh.length; i++) {
          var _Polygon = new google.maps.Polygon({
            paths: HoChiMinh[i],
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 3,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
          });

          _Polygon.setMap(map);
          _Polygon.addListener('click', showWards);
          _Polygon.addListener('mouseover', showInfo);
          infoWindow = new google.maps.InfoWindow;

          function showArrays(event) {
            var vertices = this.getPath();
            var contentString = '<b>Bermuda Triangle polygon</b><br>' +
              'Clicked location: <br>' + event.latLng.lat() + ',' + event.latLng.lng() +
              '<br>';
            infoWindow.setContent(contentString);
            infoWindow.setPosition(event.latLng);
            infoWindow.open(map);
          }

          function showInfo(event) {
            var vertices = this.getPath();
            var contentString = 'Để em test thưa đồng chí';
            infoWindow.setContent(contentString);
            infoWindow.open(map);
          }


        }

      }



      // var bermudaTriangle = new google.maps.Polygon({
      //   paths: BinhThanh,
      //   strokeColor: '#FF0000',
      //   strokeOpacity: 0.8,
      //   strokeWeight: 3,
      //   fillColor: '#FF0000',
      //   fillOpacity: 0.35,
      //   //draggable: true
      // });
      // bermudaTriangle.setMap(map);

      // // Add a listener for the click event.
      // bermudaTriangle.addListener('click', showArrays);

      // infoWindow = new google.maps.InfoWindow;
      function showWards() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: {
            lat: 10.801618,
            lng: 106.733319
          },
          mapTypeId: 'terrain'
        });

        for (i = 0; i < W_Quan1.length; i++) {
          var _Polygon = new google.maps.Polygon({
            paths: W_Quan1[i],
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 3,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
          });

          _Polygon.setMap(map);
          _Polygon.addListener('click', showArrays);
          infoWindow = new google.maps.InfoWindow;

          function showArrays(event) {
            var vertices = this.getPath();
            var contentString = '<b>Bermuda Triangle polygon</b><br>' +
              'Clicked location: <br>' + event.latLng.lat() + ',' + event.latLng.lng() +
              '<br>';
            infoWindow.setContent(contentString);
            infoWindow.setPosition(event.latLng);
            infoWindow.open(map);
          }
        }
      }

      // /** @this {google.maps.Polygon} */
      // function showArrays(event) {
      //   // Since this polygon has only one path, we can call getPath() to return the
      //   // MVCArray of LatLngs.
      //   var vertices = this.getPath();

      //   var contentString = '<b>Bermuda Triangle polygon</b><br>' +
      //     'Clicked location: <br>' + event.latLng.lat() + ',' + event.latLng.lng() +
      //     '<br>';
      //   // Replace the info window's content and position.
      //   infoWindow.setContent(contentString);
      //   infoWindow.setPosition(event.latLng);
      //   infoWindow.open(map);
      // }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3fByx8K4DLCb3SgvDo78DsVSDSUNMGWo&callback=initMap">
    </script>
  </body>

  </html>