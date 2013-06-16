
<?php
    include_once("back.php");
?>
<!DOCTYPE html>


<html>
<head>
    <title>Geo</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=geometry"></script>
    <link rel='stylesheet' type='text/css' href='css/reset.css'>
    <link rel='stylesheet' type='text/css' href='css/styles.css'>
    <meta charset="UTF-8">

        <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAjU0EJWnWPMv7oQ-jjS7dYxSPW5CJgpdgO_s4yyMovOaVh_KvvhSfpvagV18eOyDWu7VytS6Bi1CWxw"
      type="text/javascript"></script>
    <script type="text/javascript">

    var map = null;
    var geocoder = null;
    var lat;
    var lng;

    function initialize() {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(37.4419, -122.1419), 1);
        map.setUIToDefault();
        geocoder = new GClientGeocoder();
      }
    }

    function showAddress(address) {
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
              lat=marker.getLatLng().lat();
              lng=marker.getLatLng().lng();
              alert(marker.getLatLng().lat()+","+marker.getLatLng().lng());
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
    
</head>

<body onload="initialize()">
  
    <section class="form">
        


        <form action="post.php" method="post" enctype="multipart/form-data"> 
            <label for="title">Description: </label>  <br>
            <input type="text" name="description"  maxlength="140"><br>
            <label for="title">Title: </label>  <br>
            <input type="text" name="title"  maxlength="80"><br> 
            <label for="category">Category: </label><br>
          <?php
              $ong = new sQuery();
              $sql = "select * from category_tbl";
              $result = $ong -> executeQuery($sql);
          
              
            if ($row = mysql_fetch_array($result)){ 
                echo '<select name= "category">';
          
                }
                do { 
                       echo '<option value= "'.$row["category_id"].'">'.$row["name"].'</option>';
                } while ($row = mysql_fetch_array($result)); 
                echo '</select>';

                function makedir(){
                
                    if (file_exists("upload/")) {
                        upload();
                    }else {
                        mkdir("upload/", 0777);
                        upload();
                    }
                }
                //upload function
                function upload(){
            
                // prevent files which are not png jpg
                if (!(($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg"))){
                 echo 'invalid file';
                //100KB max file size
                }elseif($_FILES["file"]["size"] > 103000){
                 echo 'too big';
                //everything is OK
                 }else{
                   if ($_FILES["file"]["error"] > 0)
                     {
                     echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
                     }
                   else
                     {
                      //save extension of file
                      $exts = explode(".", $_FILES["file"]["name"]) ;
                      $n = count($exts)-1;
                      $exts = $exts[$n];

                     //characters that will be needed to renaming file after upload
                     $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                     //generate random string with minimum 5 and maximum of 10 characters
                     $str = substr( str_shuffle( $chars ), 0, 10);
                     //add extension to file
                     $name=$str.".".$exts;
                     //check if file exist (there is almost 0 possibility )
                     if (file_exists("upload/" . $name))
                       {
                        die("please try again");
                        //move uploaded file to right directory
                       }else{
                       move_uploaded_file($_FILES["file"]["tmp_name"], "upload/". $name);
                       echo "Stored in: " . "upload/" .  $name;
                       }
                     }
                   }
                }

                if(isset($_POST['submit'])){
                //after submiting execute this function
                makedir();
                }

          

            ?> 
            <br>
             <p>
            <input type="text" style="width:350px" name="address" value="243 parnassus,san francisco,ca" />
           
            </p>
            <div id="map_canvas" style="width: 600px; height: 400px; display:none;"></div>
            <input type="submit" class="btn_send" name="!post" onsubmit="showAddress(this.address.value);"  value="!post">
        </form>
        
        <form method="post" enctype="multipart/form-data">
         <label for="file">Filename:</label>
         <input type="file" name="file" id="file" />
         <br />
         <input type="submit" name="submit"  value="Submit" />
         </form>


        <!--
         <form action="#" onsubmit="showAddress(this.address.value); return false">
   
          <p>
            <input type="text" style="width:350px" name="address" value="243 parnassus,san francisco,ca" />
            <input type="submit" value="Go!" />
          </p>
          <div id="map_canvas" style="width: 600px; height: 400px; display:none;"></div>
         
        </form>
        -->
       

    </section>
    


</body>
</html>