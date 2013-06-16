
<?php
    include_once("back.php");
?>
<!DOCTYPE html>
<script type="text/javascript">function showAddress(address) {
      if (geocoder) {
        geocoder.getLatLng(
          address,
          function(point) {
            if (!point) {
              alert(address + " not found");
            } else {
              map.setCenter(point, 15);
              var marker = new GMarker(point, {draggable: true});
              map.addOverlay(marker);
              GEvent.addListener(marker, "dragend", function() {
                marker.openInfoWindowHtml(marker.getLatLng().toUrlValue(6));
              });
              GEvent.addListener(marker, "click", function() {
                marker.openInfoWindowHtml(marker.getLatLng().toUrlValue(6));
              });
          GEvent.trigger(marker, "click");
            }
          }
        );
      }
    }
    </script>

<html>
<head>
    <title>Geo</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=geometry"></script>
    <link rel='stylesheet' type='text/css' href='css/reset.css'>
    <link rel='stylesheet' type='text/css' href='css/styles.css'>
    <meta charset="UTF-8">
    
</head>

<body>
  
    <section class="form">
        

        <form action="post.php" method="post"> 
            <label for="title">Title: </label>  <br>
            <input type="text" name="title"  maxlength="80"><br> 
            <label for="email">Category: </label><br>
          <?php
              $ong = new sQuery();
              $sql = "select * from category_tbl";
              $result = $ong -> executeQuery($sql);
          
              
            if ($row = mysql_fetch_array($result)){ 
                echo '<select name= "nombreDelCombo">';
          
                }
                do { 
                       echo '<option value= "'.$row["category_id"].'">'.$row["name"].'</option>';
                } while ($row = mysql_fetch_array($result)); 
                echo '</select>';

          

            ?> 
            <label for="email">Upload  </label><br>
            <input type="text" name="telefono" size="15%" maxlength="60"><br>
        
    
            <input type="submit" class="btn_send" name="!post" value="!post">
        </form>

   

    </section>
    


</body>
</html>