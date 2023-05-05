<?php
function city($city){
    //making an api call in open weathermap api
    $url = "https://api.openweathermap.org/data/2.5/weather?q=".$city."&units=metric&appid=200732d1a4c5f987b549a48ac130760a";
    //reads the content of the URL and store in variable data
    $data = file_get_contents($url);
    //deocdes JSON formatted data into PHP array
    $data = json_decode($data, true);
    //connects the sql
    conmysql($data,$city);
}


function conmysql($data,$city){
    //defines the variables for storing data
    $localhost = "localhost";
    $username = "root";
    $password = "";
    $dbname = "weatherdata";
    $mysql = mysqli_connect($localhost, $username, $password, $dbname);
    entry($mysql,$data,$city);
}

function entry($mysql,$data,$city){
    $cityname = $data['name'];
    $temp = $data['main']['temp'];
    $humidity = $data['main']['humidity'];
    $windspeed = $data['wind']['speed'];
    $pressure = $data['main']['pressure'];
    $icon=$data['weather'][0]['icon'];

    //Creates a SQL query to insert weather data into the database
    $sql = "INSERT INTO weather (id, cityname, temp, humidity, windspeed, pressure, icon) VALUES (1, '$cityname', $temp, $humidity, $windspeed, $pressure, '$icon')";
    
    //SQL query to delete all data from the weather table
    $sql2="DELETE FROM weather";

    //SQL query to update the id column in weather table
    $sql3="UPDATE weather SET id = 1";

    // Executes the SQL queries to delete old data, update the ID, and insert new data
    mysqli_query($mysql,$sql2);
    mysqli_query($mysql,$sql3);
    mysqli_query($mysql,$sql);

    // Loops through the previous 7 days to get historical data for the city
    for ($i=1; $i<=7; $i++) {
        $end_date=(new DateTime())->sub(new DateInterval('P'.($i-1).'D'))->format('Y-m-d');
        $start_date = (new DateTime())->sub(new DateInterval('P'.$i.'D'))->format('Y-m-d');
        
        //fetching the 7 days weather data from weatherbit api
        $urlhis="https://api.weatherbit.io/v2.0/history/daily?city=" . $city . "&start_date=".$start_date."&end_date=".$end_date."&key=d9a854948875432f95cb1fab2b757d81";
        $Data = file_get_contents($urlhis);
        $Data = json_decode($Data, true);

        //getting temperature,cityname and date from the historical data
        $temp=$Data['data'][0]['temp'];
        $cityname=$Data['city_name'];
        $datetime=$Data['data'][0]['datetime'];

        //Creating a SQL query to insert the historical data into the weather table
        $sql = "INSERT INTO weather (id, cityname, temp) VALUES ($i+1, '$cityname', $temp)";
        mysqli_query($mysql,$sql);
    }

    //Calling the retrieve function to display the data on the webpage
    retrive($mysql,$data,$Data);
    }

function retrive($mysql,$data,$Data){
    //declares the global variable
    global $city_name1, $temp1, $humidity1, $windspeed1, $pressure1, $icon1, $temp2;

    //retrieveing cityname from first row of weather table
    $sql="SELECT cityname FROM weather WHERE id=1";
    $row=mysqli_fetch_assoc(mysqli_query($mysql, $sql));
    $city_name1=$row['cityname'];

    //retrieveing temp from first row of weather table
    $sql="SELECT temp FROM weather WHERE id=1";
    $row=mysqli_fetch_assoc(mysqli_query($mysql, $sql));
    $temp1=$row['temp'];

    //retrieveing humidity from first row of weather table
    $sql="SELECT humidity FROM weather WHERE id=1";
    $row=mysqli_fetch_assoc(mysqli_query($mysql, $sql));
    $humidity1=$row['humidity'];

    //retrieveing windspeed from first row of weather table
    $sql="SELECT windspeed FROM weather WHERE id=1";
    $row=mysqli_fetch_assoc(mysqli_query($mysql, $sql));
    $windspeed1=$row['windspeed'];

    //retrieveing icon from first row of weather table
    $sql="SELECT icon FROM weather WHERE id=1";
    $row=mysqli_fetch_assoc(mysqli_query($mysql, $sql));
    $icon1=$row['icon'];

    //retrieveing pressure from first row of weather table
    $sql="SELECT pressure FROM weather WHERE id=1";
    $row=mysqli_fetch_assoc(mysqli_query($mysql, $sql));
    $pressure1=$row['pressure'];

    //Loops through the result rows from id=2 to id=8
    for ($i=2;$i<=8;$i++){
        //Selects temp from weather table where id is equal to loop variable $i
        $sql="SELECT temp FROM weather WHERE id=$i";
        // Executes the query and fetches the result row as an associative array
        $row=mysqli_fetch_assoc(mysqli_query($mysql, $sql));
        // Assigns the value of temp from the fetched row to the array $temp2 with index $i-2
        $temp2[$i-2]=$row['temp'];
    }
}

// check if the search button has been clicked
if ( isset($_GET['search-button']) ) 
{
    // get the searched city name from the search button
    $Searched_City_Name = $_GET['search-button'];

    // redirect to the same page with the searched city name as a parameter
    header("Location: MerinaShrestha_2333309.php?passed_city_name=" . urlencode($Searched_City_Name));
    // stop executing the current script
    exit();
}

// check if the passed city name is set in the URL
if (!isset($_GET['passed_city_name'])) {
    // set the default city name
    $cityName = "Basingstoke";
} 
else  {
    // get the passed city name from the URL

    $cityName = $_GET['passed_city_name'];
}
// call the city function with the city name as a parameter
city($cityName);
?>
