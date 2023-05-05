<?php include 'merina2333309.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast app</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="MerinaShrestha_2333309.css?v=<?php echo time();?>">
</head>

<body>
  <!-- define two global variable -->
    <?php global $city_name1, $temp2?>
        <div class="container">
          <div class="Search">
            <!--using HTTP GET method and action attribute for server-side scripting-->
            <form method ="GET" action ="merina2333309.php" class="search-form" id="locationInput">
                <input type="text" class="search" name="search-button" placeholder="Search" />
                <button type="submit" class="submit">
                    <i class='bx bx-search-alt-2'></i>
                </button>
            </form>
          </div>

        <h1 class="current-weather">Weather in <?php echo $city_name1 ?></h1>
               
        <h1 class="temp"> <?php echo $temp1."°C";?></h1>

        <!--attribute for setting the url of icon image-->
        <img src="<?php echo "https://openweathermap.org/img/wn/".$icon1.".png"?>" />
        
        <div class="humidity">Humidity: <?php echo $humidity1. "%"?></div>
                
        <div class="pressure">Pressure: <?php echo $pressure1. "hPa";?></div>

        <div class="wind">Wind speed: <?php echo $windspeed1. "km/h";?></div>
        </div>
      
    <div class="table">
        <p class="historytext"> <?php echo "Past 7 days weather of ".$city_name1?></p>
        <div class="tablecontent">
      <table style="border: 1px solid white;">
        <tr>
          <th style="border: 1px solid white;">Date</th>
          <th style="border: 1px solid white;">Temperature</th>
        </tr>
        <tr>
          <td style="border: 1px solid white;"><?php echo (new DateTime())->sub(new DateInterval('P1D'))->format('Y-m-d');?></td>
          <td style="border: 1px solid white;"><?php echo $temp2[0]."°C";?></td>
        </tr>
        <tr>
        <td style="border: 1px solid white;"><?php echo (new DateTime())->sub(new DateInterval('P2D'))->format('Y-m-d');?></td>
          <td style="border: 1px solid white;"><?php echo $temp2[1]."°C";?></td>
        </tr>
        <tr>
        <td style="border: 1px solid white;"><?php echo (new DateTime())->sub(new DateInterval('P3D'))->format('Y-m-d');?></td>
          <td style="border: 1px solid white;"><?php echo $temp2[2]."°C";?></td>
        </tr>
        <tr>
        <td style="border: 1px solid white;"><?php echo (new DateTime())->sub(new DateInterval('P4D'))->format('Y-m-d');?></td>
          <td style="border: 1px solid white;"><?php echo $temp2[3]."°C";?></td>
        </tr>
        <tr>
        <td style="border: 1px solid white;"><?php echo (new DateTime())->sub(new DateInterval('P5D'))->format('Y-m-d');?></td>
          <td style="border: 1px solid white;"><?php echo $temp2[4]."°C";?></td>
        </tr>
        <tr>
        <td style="border: 1px solid white;"><?php echo (new DateTime())->sub(new DateInterval('P6D'))->format('Y-m-d');?></td>
          <td style="border: 1px solid white;"><?php echo $temp2[5]."°C";?></td>
        </tr>
        <tr>
        <td style="border: 1px solid white;"><?php echo (new DateTime())->sub(new DateInterval('P7D'))->format('Y-m-d');?></td>
          <td style="border: 1px solid white;"><?php echo $temp2[6]."°C";?></td>
        </tr>
        </div>
</table> 
    
   
</body>
</html>