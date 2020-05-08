<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 14.04.2020
 * Time: 20:43
 */

// подключаем файл для работы с БД и объектом Product
include_once 'API/Config/database.php';
include_once 'API/objects/car.php';


function GetStringAfterSecondSlashInURL($the_url)
{
    $parts = explode("/",$the_url,3);

    if(isset($parts[2]))
        return $parts[2];
}

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$parking = new Skud($db);

$str = $_SERVER['REQUEST_URI'];
$id = GetStringAfterSecondSlashInURL($str);

// установим id свойства товара для редактирования
$parking->id = $id;
$parking->readOne();


?>

<style>
    body {
        margin: 0;
        padding: 0;
        /*  Background fallback in case of IE8 & down, or in case video doens't load, such as with slower connections  */
        background: #333;
        background-attachment: fixed;
        background-size: cover;
    }

    /* The only rule that matters */
    #video-background {
        /*  making the video fullscreen  */
        position: fixed;
        right: 0;
        bottom: 0;
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        z-index: -100;
    }

    /* These just style the content */
    article {
        /*  just a fancy border  */
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border: 10px solid rgba(255, 255, 255, 0.5);
        margin: 10px;
    }

    h1 {
        position: absolute;
        top: 40%;
        width: 100%;
        font-size: 36px;
        letter-spacing: 3px;
        color: #fff;
        font-family: Oswald, sans-serif;
        text-align: center;
    }

    h1 span {
        font-family: sans-serif;
        letter-spacing: 0;
        font-weight: 300;
        font-size: 16px;
        line-height: 24px;
    }
    #importantColor {
        color: red;
        top: 40%;
        font-size: 124px;
        font-weight: bold;
    }

    h1 span a {
        color: #fff;
    }
</style>
<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>

<!--  Content  -->
<article>
    <h1>КОЛИЧЕСТВО МЕСТ НА ПАРКОВКЕ<br/></h1>
    <br>
    <h1 id="importantColor"><?php echo  $parking->emptyPlaces;?><br/></h1>
</article>

<script>
    if(typeof(EventSource) !== "undefined") {
        var source = new EventSource("http://localhost/API/webSocket.php/<?php echo $parking->id?>");
        // source.onmessage = function(event) {
        //     document.getElementById("importantColor").innerHTML = event.data + "<br>";
        //     Console.log(event.data);
        // };
        source.addEventListener('join', event => {
            alert(`${event.data} зашёл`);
        });

        source.onmessage = function(e) {
            console.log("Сообщение: " + e.data);
            document.getElementById("importantColor").innerHTML = e.data ;
        };

        source.addEventListener('leave', event => {
            alert(`${event.data} вышел`);
        });

        source.onopen = function() {
            console.log("Connection to server opened.");
        };
    } else {
        document.getElementById("importantColor").innerHTML = "Извините нет данных";
    }
</script>