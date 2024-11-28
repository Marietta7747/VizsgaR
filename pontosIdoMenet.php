<?php
session_start();

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'volan_app';

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Kapcsolódási hiba: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaposvár Helyi Járatok</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="betolt.js"></script>

    <style>
        :root {
            --primary-color:linear-gradient(to right, #211717,#b30000);
            --accent-color: #FFC107;
            --text-light: #fbfbfb;
            --shadow: 0 2px 4px rgba(0,0,0,0.1);
            --secondary-color: #3498db;
            --hover-color: #2980b9;
            --background-light: #f8f9fa;
            --shadow-color: rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #F5F5F5;
            color: #333;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

/*--------------------------------------------------------------------------------------------------------CSS - HEADER---------------------------------------------------------------------------------------------------*/
        .header {
            position: relative;
            background: var(--primary-color);
            color: var(--text-light);
            padding: 1rem;
            box-shadow: 0 2px 10px var(--shadow-color);
        }

        .header h1 {
            margin-left: 2%;
            text-align: center;
            font-size: 2rem;
            padding: 1rem 0;
            margin-left: 35%;
            display: inline-block;
        }

        .backBtn{
            display: inline-block;
            width: 3%;
            background: #372E2E;
            border: none;
            box-shadow: 0 2px 10px var(--shadow-color);
        }

        .backBtn:hover{
            background: #b40000;
        }

        .backBtn i{
            height: 30px;
            color: var(--text-light);
            padding-top: 20px;
        }
/*--------------------------------------------------------------------------------------------------------HEADER END-----------------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------------------CSS - OTHER PARTS----------------------------------------------------------------------------------------------*/
        .time-container {
            display: inline;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            padding: 2rem;
            max-width: 1000px;
            margin: 0 auto;
        }

        .time-card {
            background: #fbfbfb;
            width: 1200px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            padding: 1.5rem;
            transition: var(--transition);
            animation: fadeIn 0.5s ease-out;
            margin: 0 auto;
            font-size: 1.5rem;
            color: #636363;
        }

        .time-card:hover{
            color: 000;
            background: #E9E8E8;
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .timeCon{
            background: #fbfbfb;
            width: 97.5%;
            height: 60%;
            margin-bottom: 5px;
            padding: 20px;
        }

        .time-number {
            background: #b30000;
            display: inline-block;
            width: 3%;
            height: 60%;
            font-size: 2.5rem;
            font-weight: bold;
            border-radius: 5px;
            padding-left: 20px;
            padding-right: 15px;
            color: var(--text-light);
            margin-left: 17%;
        }

        .time-name{
            display: inline-block;
            color: #636363;
            font-size: 1.5rem;
            font-weight: bold;
            margin-left: 17%;
        }

        .switchBtn{
            display: inline;
            float: right;
            background: #fbfbfb;
            margin-right: 16%;
        }

        .switchBtn:hover{
            background: #E9E8E8;
        }

        .time{
            display: inline-block;
            float: right;
            font-size: 1.5rem;
            font-weight: bold;
            margin-right: 16%;
            margin-top: 1%;
        }

        .time-date{
            display: inline-block;
            float: center;
        }

        #datePicker{
            margin-left: 215%;
            font-size: 1.25rem;
            background-color: #fbfbfb;
            color: #211717;
            border: 1px solid #fff;
        } 

        .time-details {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }       
/*--------------------------------------------------------------------------------------------------------OTHER PARTS END------------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------------------CSS - FOOTER---------------------------------------------------------------------------------------------------*/
        footer {
            text-align: center;
            padding: 10px;
            background-color: var(--primary-color);
            color: var(--text-light);
            border-radius: 10px;
            margin-top: 20px;
            box-shadow: var(--shadow);
            background: var(--primary-color);
            color: var(--text-light);
            padding: 3rem 2rem;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .footer-section h2 {
            margin-bottom: 1rem;
            color: var(--text-light);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: var(--text-light);
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--accent-color);
        }
/*--------------------------------------------------------------------------------------------------------FOOTER END-----------------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------------------CSS - @MEDIA---------------------------------------------------------------------------------------------------*/

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }

        @media (max-width: 480px) {
            .header-content {
                padding: 1rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            .time-container {
                grid-template-columns: 1fr;
                padding: 1rem;
            }

            .time-card{
                width: 340px;
            }

            .time-number{
                margin-left: 0;
                padding-right: 60px;
            }

            .time-name{
                margin-left: 0;
            }

            .timeCon{
                width: 345px;
            }

            .switchBtn{
                margin-right: 0;
            }

            .header h1{
                margin-left: 2%;
            }

            #datePicker{
                margin-left: 28%;
            }

            .backBtn{
                width: 15%;
            }
        }
/*--------------------------------------------------------------------------------------------------------@MEDIA END-----------------------------------------------------------------------------------------------------*/
        
    </style>
</head>
<body>
    <div class="header">
            <button class="backBtn" id=bckBtn><i class="fa-solid fa-chevron-left"></i></button>
            <h1><i class="fas fa-bus"></i> Kaposvár Helyi Járatok</h1> 
            
        </div>

        <div id="timeNumCon" class="timeCon"></div>
        <div id="timeNameCon" class="timeCon"></div>


        <div id="timeContainer" class="time-container"></div>

<!-- -----------------------------------------------------------------------------------------------------HTML - FOOTER------------------------------------------------------------------------------------------------ -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h2>Kaposvár közlekedés</h2>
                <p style="font-style: italic">Megbízható közlekedési szolgáltatások<br> az Ön kényelméért már több mint 50 éve.</p><br>
                <div class="social-links">
                    <a style="color: darkblue;" href="https://www.facebook.com/VOLANBUSZ/"><i class="fab fa-facebook"></i></a>
                    <a style="color: lightblue"href="https://x.com/volanbusz_hu?mx=2"><i class="fab fa-twitter"></i></a>
                    <a style="color: red"href="https://www.instagram.com/volanbusz/"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
           
            <div  class="footer-section">
                <h3>Elérhetőség</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-phone"></i> +36-82/411-850</li>
                    <li><i class="fas fa-envelope"></i> titkarsag@kkzrt.hu</li>
                    <li><i class="fas fa-map-marker-alt"></i> 7400 Kaposvár, Cseri út 16.</li>
                    <li><i class="fas fa-map-marker-alt"></i> Áchim András utca 1.</li>
                </ul>
            </div>
        </div>
        <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1);">
            <p>© 2024 Kaposvár közlekedési Zrt. Minden jog fenntartva.</p>
        </div>
    </footer>
<!-- -----------------------------------------------------------------------------------------------------FOOTER END--------------------------------------------------------------------------------------------------- -->

    <script>
/*---------------------------------------------------------------------------------------------------------JAVASCRIPT - BACK BUTTON--------------------------------------------------------------------------------------*/
        document.getElementById('bckBtn').addEventListener('click', function() {
            window.location.href = 'jaratok.php'; // Redirect to jaratok.php
        });
/*---------------------------------------------------------------------------------------------------------BACK BUTTON END-----------------------------------------------------------------------------------------------*/
        
/*---------------------------------------------------------------------------------------------------------JAVASCRIPT - BUS TIME-----------------------------------------------------------------------------------------*/
    const busTime = [
    /*-----------------------------------------------------12------------------------------------------------------*/
                {
                    "start": "05:00",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["05:00","05:01","05:04","05:06","05:08","05:10","05:11","05:12","05:13","05:15"],
                },
                {
                    "start": "05:30",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["05:30","05:31","05:34","05:36","05:38","05:40","05:41","05:42","05:43","05:45"],
                },
                {
                    "start": "05:55",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["05:55","05:56","06:59","06:01","06:03","06:05","06:06","06:07","06:08","06:10"],
                },
                {
                    "start": "06:10",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["06:10","06:11","06:14","06:16","06:18","06:20","06:21","06:22","06:23","06:25"],
                },
                {
                    "start": "06:30",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["06:30","06:31","06:34","06:36","06:38","06:40","06:41","06:42","06:43","06:45"],
                },
                {
                    "start": "07:05",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["07:05","07:06","07:09","07:11","07:13","07:15","07:16","07:17","07:18","07:20"],
                },
                {
                    "start": "07:30",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
                },
                {
                    "start": "09:00",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["09:00","09:01","09:04","09:06","09:08","09:10","09:11","09:12","09:13","09:15"],
                },
                {
                    "start": "10:00",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["10:00","10:01","10:04","10:06","10:08","10:10","10:11","10:12","10:13","10:15"],
                },
                {
                    "start": "10:35",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["10:35","10:36","10:39","10:41","10:43","10:45","10:46","10:47","10:48","10:50"],
                },
                {
                    "start": "11:00",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["11:00","11:01","11:04","11:06","11:08","11:10","11:11","11:12","11:13","11:15"],
                },
                {
                    "start": "12:30",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["12:30","12:31","12:34","12:36","12:38","12:40","12:41","12:42","12:43","12:45"],
                },
                {
                    "start": "13:00",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["13:00","13:01","13:04","13:06","13:08","13:10","13:11","13:12","13:13","13:15"],
                },
                {
                    "start": "13:30",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["13:30","13:31","13:34","13:36","13:38","13:40","13:41","13:42","13:43","13:45"],
                },
                {
                    "start": "14:20",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["14:20","14:21","14:24","14:26","14:28","14:30","14:31","14:32","14:33","14:35"],
                },
                {
                    "start": "15:00",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["15:00","15:01","15:04","15:06","15:08","15:10","15:11","15:12","15:13","15:15"],
                },
                {
                    "start": "15:45",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["15:45","15:46","15:49","15:51","15:53","15:55","15:56","15:57","15:58","16:00"],
                },
                {
                    "start": "16:00",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["16:00","16:01","16:04","16:06","16:08","16:10","16:11","16:12","16:13","16:15"],
                },
                {
                    "start": "16:30",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["16:30","16:31","16:34","16:36","16:38","16:40","16:41","16:42","16:43","16:45"],
                },
                {
                    "start": "16:45",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["16:45","16:46","16:49","16:51","16:53","16:55","16:56","16:57","16:58","17:00"],
                },
                {
                    "start": "17:00",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["17:00","17:01","17:04","17:06","17:08","17:10","17:11","17:12","17:13","17:15"],
                },
                {
                    "start": "17:15",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["17:15","17:16","17:19","17:21","17:23","17:25","17:26","17:27","17:28","17:30"],
                },
                {
                    "start": "17:30",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["17:30","17:31","17:34","17:36","17:38","17:40","17:41","17:42","17:43","17:45"],
                },
                {
                    "start": "19:00",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["19:00","19:01","19:04","19:06","19:08","19:10","19:11","19:12","19:13","19:15"],
                },
                {
                    "start": "20:30",
                    "number": "12",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                    "stopsTime": ["20:30","20:31","20:34","20:36","20:38","20:40","20:41","20:42","20:43","20:45"],
                },
    /*-----------------------------------------------------12 END------------------------------------------------------*/
    /*-----------------------------------------------------13------------------------------------------------------*/
                {
                    "start": "06:10",
                    "number": "13",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u. forduló"
                    , "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró"
                    , "Helyi autóbusz-állomás"],
                    "stopsTime": ["06:10", "06:12", "06:14", "06:17", "06:18", "06:19", "06:20", "06:22", "06:24", "06:25", "06:27", "06:28", "06:30", "06:31", "06:32", "06:33", "06:34", "06:37", "06:39"],
                },
                {
                    "start": "7:10",
                    "number": "13",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u. forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["07:10", "07:12", "07:14", "07:17", "07:18", "07:19", "07:20", "07:22", "07:24", "07:25", "07:27", "07:28", "07:30", "07:31", "07:32", "07:33", "07:34", "07:37", "07:39"],
                },
                {
                    "start": "8:10",
                    "number": "13",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u. forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["08:10", "08:12", "08:14", "08:17", "08:18", "08:19", "08:20", "08:22", "08:24", "08:25", "08:27", "08:28", "08:30", "08:31", "08:32", "08:33", "08:34", "08:37", "08:39"],
                },
                {
                    "start": "9:10",
                    "number": "13",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u. forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["09:10", "09:12", "09:14", "09:17", "09:18", "09:19", "09:20", "09:22", "09:24", "09:25", "09:27", "09:28", "09:30", "09:31", "09:32", "09:33", "09:34", "09:37", "09:39"],
                },
                {
                    "start": "12:10",
                    "number": "13",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u. forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["12:10", "12:12", "12:14", "12:17", "12:18", "12:19", "12:20", "12:22", "12:24", "12:25", "12:27", "12:28", "12:30", "12:31", "12:32", "12:33", "12:34", "12:37", "12:39"],
                },
                {
                    "start": "13:25",
                    "number": "13",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u. forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["13:25", "13:27", "13:29", "13:32", "13:33", "13:34", "13:35", "13:37", "13:39", "13:40", "13:42", "13:43", "13:45", "13:46", "13:47", "13:48", "13:49", "13:52", "13:54"],
                },
                {
                    "start": "14:10",
                    "number": "13",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u. forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["14:10", "14:12", "14:14", "14:17", "14:18", "14:19", "14:20", "14:22", "14:24", "14:25", "14:27", "14:28", "14:30", "14:31", "14:32", "14:33", "14:34", "14:37", "14:39"],
                },
                {
                    "start": "15:40",
                    "number": "13",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u. forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["15:40", "15:42", "15:44", "15:47", "15:48", "15:49", "15:50", "15:52", "15:54", "15:55", "15:57", "15:58", "16:00", "16:01", "16:02", "16:03", "16:04", "16:07", "16:09"],
                },
                {
                    "start": "16:10",
                    "number": "13",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u. forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["16:10", "16:12", "16:14", "16:17", "16:18", "16:19", "16:20", "16:22", "16:24", "16:25", "16:27", "16:28", "16:30", "16:31", "16:32", "16:33", "16:34", "16:37", "16:39"],                         
                },
                {
                    "start": "17:10",
                    "number": "13",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u. forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["17:10", "17:12", "17:14", "17:17", "17:18", "17:19", "17:20", "17:22", "17:24", "17:25", "17:27", "17:28", "17:30", "17:31", "17:32", "17:33", "17:34", "17:37", "17:39"],            
                },
                {
                    "start": "19:10",
                    "number": "13",
                    "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u. forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["19:10", "19:12", "19:14", "19:17", "19:18", "19:19", "19:20", "19:22", "19:24", "19:25", "19:27", "19:28", "19:30", "19:31", "19:32", "19:33", "19:34", "19:37", "19:39"],
                },
    /*-----------------------------------------------------13 END------------------------------------------------------*/
    /*-----------------------------------------------------20------------------------------------------------------*/
                {
                    "start": "06:15",
                    "number": "20",
                    "name": "Raktár u. - Laktanya - Videoton", 
                    "stops": ["Raktár u.","Jutai u. 45.","Tóth Á. u.","Jutai u. 24.","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Toldi lakónegyed","Kinizsi ltp.","Búzavirág u."
                    ,"Laktanya","Laktanya","Búzavirág u.","Nagyszeben u.","Losonc-köz","Arany J. tér","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Kenyérgyár u. 1.","Videoton"],
                    "stopsTime": ["06:15","06:16","06:17","06:18","06:19","06:20","06:21","06:22","06:23","06:24","06:25","06:26","06:27","06:28","06:29","06:31","06:32","06:33"
                    ,"06:35","06:36","06:37","06:38","06:39","06:40"],
                },
                {
                    "start": "06:40",
                    "number": "20",
                    "name": "Raktár u. - Laktanya - Videoton", 
                    "stops": ["Raktár u.","Jutai u. 45.","Tóth Á. u.","Jutai u. 24.","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Toldi lakónegyed","Kinizsi ltp.","Búzavirág u."
                    ,"Laktanya","Laktanya","Búzavirág u.","Nagyszeben u.","Losonc-köz","Arany J. tér","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Kenyérgyár u. 1.","Videoton"],
                    "stopsTime": ["06:40","06:41","06:42","06:43","06:44","06:45","06:46","06:47","06:48","06:49","06:50","06:51","06:52","06:53","06:54","06:56","06:58","07:00"
                    ,"07:02","07:03","07:04","07:06","06:39","07:08"],
                },
                {
                    "start": "08:00",
                    "number": "20",
                    "name": "Raktár u. - Laktanya - Videoton", 
                    "stops": ["Raktár u.","Jutai u. 45.","Tóth Á. u.","Jutai u. 24.","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Toldi lakónegyed","Kinizsi ltp.","Búzavirág u."
                    ,"Laktanya","Laktanya","Búzavirág u.","Nagyszeben u.","Losonc-köz","Arany J. tér","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Kenyérgyár u. 1.","Videoton"],
                    "stopsTime": ["08:00","08:01","08:02","08:03","08:04","08:05","08:06","08:07","08:08","08:09","08:10","08:11","08:12","08:13","08:14","08:16","08:17","08:18"
                    ,"08:20","08:22","08:23","08:24","08:26","08:28"],
                },
                {
                    "start": "10:00",
                    "number": "20",
                    "name": "Raktár u. - Laktanya - Videoton", 
                    "stops": ["Raktár u.","Jutai u. 45.","Tóth Á. u.","Jutai u. 24.","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Toldi lakónegyed","Kinizsi ltp.","Búzavirág u."
                    ,"Laktanya","Laktanya","Búzavirág u.","Nagyszeben u.","Losonc-köz","Arany J. tér","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Kenyérgyár u. 1.","Videoton"],
                    "stopsTime": ["10:00","10:01","10:02","10:03","10:04","10:05","10:06","10:07","10:08","10:09","10:10","10:11","10:12","10:13","10:14","10:16","10:17","10:18"
                    ,"10:20","10:22","10:2","10:24","10:26","10:28"],
                },
                {
                    "start": "13:05",
                    "number": "20",
                    "name": "Raktár u. - Laktanya - Videoton", 
                    "stops": ["Raktár u.","Jutai u. 45.","Tóth Á. u.","Jutai u. 24.","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Toldi lakónegyed","Kinizsi ltp.","Búzavirág u."
                    ,"Laktanya","Laktanya","Búzavirág u.","Nagyszeben u.","Losonc-köz","Arany J. tér","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Kenyérgyár u. 1.","Videoton"],
                    "stopsTime": ["13:05","13:06","13:07","13:08","13:09","13:10","13:11","13:12","13:13","13:14","13:15","13:16","13:17","13:18","13:19","13:21","13:22","13:23"
                    ,"13:25","13:27","13:28","13:29","13:31","13:33"],
                },
                {
                    "start": "14:15",
                    "number": "20",
                    "name": "Raktár u. - Laktanya - Videoton", 
                    "stops": ["Raktár u.","Jutai u. 45.","Tóth Á. u.","Jutai u. 24.","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Toldi lakónegyed","Kinizsi ltp.","Búzavirág u."
                    ,"Laktanya","Laktanya","Búzavirág u.","Nagyszeben u.","Losonc-köz","Arany J. tér","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Kenyérgyár u. 1.","Videoton"],
                    "stopsTime": ["14:15","14:16","14:17","14:18","14:19","14:20","14:21","14:22","14:23","14:24","14:25","14:26","14:27","14:28","14:29","14:31","14:32","14:33"
                    ,"14:35","14:37","14:38","14:39","14:41","14:43"],
                },
                {
                    "start": "16:20",
                    "number": "20",
                    "name": "Raktár u. - Laktanya - Videoton", 
                    "stops": ["Raktár u.","Jutai u. 45.","Tóth Á. u.","Jutai u. 24.","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Toldi lakónegyed","Kinizsi ltp.","Búzavirág u."
                    ,"Laktanya","Laktanya","Búzavirág u.","Nagyszeben u.","Losonc-köz","Arany J. tér","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Kenyérgyár u. 1.","Videoton","Dombóvári u. 4.","METYX"],
                    "stopsTime": ["16:20","16:21","16:22","16:23","16:24","16:25","16:26","16:27","16:29","16:30","16:31","16:32","16:33","16:34","16:35","16:37","16:38","16:39"
                    ,"16:41","16:42","16:44","16:45","16:46","16:47","16:48","16:49"],
                },
                {
                    "start": "21:10",
                    "number": "20",
                    "name": "Raktár u. - Laktanya - Videoton", 
                    "stops": ["Raktár u.","Jutai u. 45.","Tóth Á. u.","Jutai u. 24.","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Toldi lakónegyed","Kinizsi ltp.","Búzavirág u."
                    ,"Laktanya","Laktanya","Búzavirág u.","Nagyszeben u.","Losonc-köz","Arany J. tér","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Kenyérgyár u. 1.","Videoton"],
                    "stopsTime": ["21:10","21:11","21:12","21:13","21:14","21:15","21:16","21:17","21:18","21:19","21:20","21:21","21:22","21:23","21:24","21:26","21:27","21:28"
                    ,"21:30","21:32","21:33","21:34","21:36","21:38"],
                },
    /*-----------------------------------------------------20 END------------------------------------------------------*/
    /*-----------------------------------------------------21------------------------------------------------------*/
                {
                    "start": "05:20",
                    "number": "21",
                    "name": "Raktár u. - Videoton",
                    "stops": ["Raktár u.", "Raktár u. 2.", "Jutai u. 45.", "Tóth Á. u.", "Jutai u. 24.", "Hajnóczy u. csp.", "Vasútköz", "Városi könyvtár", "Füredi úti csomópont", "ÁNTSZ", "Pázmány P. u.", "Kisgát", "Mező u. csp.", "Kenyérgyár u. 1.", "Videoton"],
                    "stopsTime": ["05:20", "05:21", "05:22", "05:23", "05:24", "05:25", "05:26", "05:27", "05:28", "05:30", "05:32", "05:34", "05:35", "05:36", "05:38"]
                },
                {
                    "start": "7:00",
                    "number": "21",
                    "name": "Raktár u. - Videoton",
                    "stops": ["Raktár u.", "Raktár u. 2.", "Jutai u. 45.", "Tóth Á. u.", "Jutai u. 24.", "Hajnóczy u. csp.", "Vasútköz", "Városi könyvtár", "Füredi úti csomópont", "ÁNTSZ", "Pázmány P. u.", "Kisgát", "Mező u. csp.", "Kenyérgyár u. 1.", "Videoton"],
                    "stopsTime": ["07:00", "07:01", "07:02", "07:03", "07:04", "07:05", "07:06", "07:07", "07:08", "07:10", "07:12", "07:14", "07:15", "07:16", "07:18"]
                },
                {
                    "start": "17:40",
                    "number": "21",
                    "name": "Raktár u. - Videoton",
                    "stops": ["Raktár u.", "Raktár u. 2.", "Jutai u. 45.", "Tóth Á. u.", "Jutai u. 24.", "Hajnóczy u. csp.", "Vasútköz", "Városi könyvtár", "Füredi úti csomópont", "ÁNTSZ", "Pázmány P. u.", "Kisgát", "Mező u. csp.", "Kenyérgyár u. 1.", "Videoton"],
                    "stopsTime": ["17:40", "17:41", "17:42", "17:43", "17:44", "17:45", "17:46", "17:47", "17:48", "17:50", "17:52", "17:54", "17:55", "17:56", "17:58"]
                },
    /*-----------------------------------------------------21 END------------------------------------------------------*/
    /*-----------------------------------------------------23------------------------------------------------------*/
                {
                    "start": "05:00",
                    "number": "23",
                    "name": "KaposFüred forduló - Füredi csp. - Kaposvári Egyetem", 
                    "stops": ["Kaposfüred, forduló","Kaposfüredi u. 244.","Kaposfüred, központ","Állomás u.","Kaposfüred, vá.","Kaposfüredi u. 104.","Kaposfüredi u. 12.","Volán-telep","Laktanya","Búzavirág u.","Kinizsi ltp."
                    ,"Toldi lakónegyed","Füredi utcai csomópont","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Izzó u.","Guba S. u. 57.","Guba S. u. 81.","Villamossági Gyár","Kaposvári Egyetem"],
                    "stopsTime": ["05:00","05:01","05:02","05:04","05:06","05:08","05:10","05:11","05:12","05:14","05:16","05:17","05:18","05:19","05:21","05:22","05:24","05:25","05:27","05:28","05:29","05:30","05:31","05:32"],
                },
                {
                    "start": "06:55",
                    "number": "23",
                    "name": "KaposFüred forduló - Füredi csp. - Kaposvári Egyetem", 
                    "stops": ["Kaposfüred, forduló","Kaposfüredi u. 244.","Kaposfüred, központ","Állomás u.","Kaposfüred, vá.","Kaposfüredi u. 104.","Kaposfüredi u. 12.","Volán-telep","Laktanya","Búzavirág u.","Kinizsi ltp."
                    ,"Toldi lakónegyed","Füredi utcai csomópont","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Izzó u.","Guba S. u. 57.","Guba S. u. 81.","Villamossági Gyár","Kaposvári Egyetem"],
                    "stopsTime": ["06:55","06:56","06:57","06:59","07:01","07:03","07:05","07:06","07:07","07:09","07:11","07:12","07:13","07:14","07:16","07:17","07:19","07:20","07:22","07:23","07:24","07:25","07:26","07:27"],
                },
                {
                    "start": "07:10",
                    "number": "23",
                    "name": "KaposFüred forduló - Füredi csp. - Kaposvári Egyetem", 
                    "stops": ["Kaposfüred, forduló","Kaposfüredi u. 244.","Kaposfüred, központ","Állomás u.","Kaposfüred, vá.","Kaposfüredi u. 104.","Kaposfüredi u. 12.","Volán-telep","Laktanya","Búzavirág u.","Kinizsi ltp."
                    ,"Toldi lakónegyed","Füredi utcai csomópont","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Izzó u.","Guba S. u. 57.","Guba S. u. 81.","Villamossági Gyár","Kaposvári Egyetem"],
                    "stopsTime": ["07:10","07:11","07:12","07:14","07:16","07:18","07:20","07:21","07:22","07:24","07:26","07:27","07:28","07:29","07:31","07:32","07:34","07:35","07:37","07:38","07:39","07:40","07:41","07:42"],
                },
                {
                    "start": "07:20",
                    "number": "23",
                    "name": "KaposFüred forduló - Füredi csp. - Kaposvári Egyetem", 
                    "stops": ["Kaposfüred, forduló","Kaposfüredi u. 244.","Kaposfüred, központ","Állomás u.","Kaposfüred, vá.","Kaposfüredi u. 104.","Kaposfüredi u. 12.","Volán-telep","Laktanya","Búzavirág u.","Kinizsi ltp."
                    ,"Toldi lakónegyed","Füredi utcai csomópont","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Izzó u.","Guba S. u. 57.","Guba S. u. 81.","Villamossági Gyár","Kaposvári Egyetem"],
                    "stopsTime": ["07:20","07:21","07:22","07:24","07:26","07:28","07:30","07:31","07:32","07:34","07:36","07:37","07:38","07:39","07:41","07:42","07:44","07:45","07:47","07:48","07:49","07:50","07:51","07:52"],
                },
                {
                    "start": "12:55",
                    "number": "23",
                    "name": "KaposFüred forduló - Füredi csp. - Kaposvári Egyetem", 
                    "stops": ["Kaposfüred, forduló","Kaposfüredi u. 244.","Kaposfüred, központ","Állomás u.","Kaposfüred, vá.","Kaposfüredi u. 104.","Kaposfüredi u. 12.","Volán-telep","Laktanya","Búzavirág u.","Kinizsi ltp."
                    ,"Toldi lakónegyed","Füredi utcai csomópont","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Izzó u.","Guba S. u. 57.","Guba S. u. 81.","Villamossági Gyár","Kaposvári Egyetem"],
                    "stopsTime": ["12:55","12:56","12:57","12:59","13:01","13:03","13:05","13:06","13:07","13:09","13:11","13:12","13:13","13:14","13:16","13:17","13:19","13:20","13:22","13:23","13:24","13:25","13:26","13:27"],
                },
    /*-----------------------------------------------------23 END------------------------------------------------------*/
    /*-----------------------------------------------------26------------------------------------------------------*/
                {
                    "start": "05:05",
                    "number": "26",
                    "name": "Kaposfüred forduló - Losonc köz - Videoton - METYX",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Losonc-köz", "Arany J. tér", "ÁNTSZ", "Pázmány P. u.", "Kisgát", "Mező u. csp.", "Kenyérgyár u. 1.", "Videoton", "Dombóvári u. 4.", "METYX"],
                    "stopsTime": ["05:05", "05:06", "05:07", "05:09", "05:11", "05:13", "05:15", "05:16", "05:17", "05:19", "05:21", "05:22", "05:23", "05:24", "05:26", "05:27", "05:29", "05:30", "05:32", "05:33", "05:35", "05:37", "05:39"]
                },
    /*-----------------------------------------------------26 END------------------------------------------------------*/
    /*-----------------------------------------------------27------------------------------------------------------*/
                {
                    "start": "04:55",
                    "number": "27",
                    "name": "Laktanya - Füredi u. csp. - KOMÉTA",
                    "stops": ["Laktanya","Búzavirág u.","Kinizsi ltp.","Toldi lakónyegyed","Füredi utcai csomópont","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp."
                    ,"Hősök temploma","Gyár u.","Pécsi úti iskola","Kométa, forduló"],
                    "stopsTime": ["04:55", "04:56", "04:57", "04:58", "05:00", "05:02", "05:04", "05:06", "05:07", "05:08", "05:09", "05:10", "05:11"]
                },
                {
                    "start": "07:10",
                    "number": "27",
                    "name": "Laktanya - Füredi u. csp. - KOMÉTA",
                    "stops": ["Laktanya","Búzavirág u.","Kinizsi ltp.","Toldi lakónyegyed","Füredi utcai csomópont","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp."
                    ,"Hősök temploma","Gyár u.","Pécsi úti iskola","Kométa, forduló"],
                    "stopsTime": ["07:10", "07:11", "07:12", "07:13", "07:15", "07:17", "07:19", "07:21", "07:22", "07:23", "07:24", "07:25", "07:26"]
                },
                {
                    "start": "13:00",
                    "number": "27",
                    "name": "Laktanya - Füredi u. csp. - KOMÉTA",
                    "stops": ["Laktanya","Búzavirág u.","Kinizsi ltp.","Toldi lakónyegyed","Füredi utcai csomópont","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp."
                    ,"Hősök temploma","Gyár u.","Pécsi úti iskola","Kométa, forduló"],
                    "stopsTime": ["13:00", "13:01", "13:02", "13:03", "13:05", "13:07", "13:09", "13:11", "13:12", "13:13", "13:14", "13:15", "13:16"]
                },
    /*-----------------------------------------------------27 END------------------------------------------------------*/
    /*-----------------------------------------------------31------------------------------------------------------*/
                {
                    "start": "05:40",
                    "number": "31",
                    "name": "Helyi autóbusz-állomás - Egyenesi u. forduló",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló"],
                    "stopsTime": ["05:40", "05:42", "05:45", "05:46", "05:47", "05:48", "05:49", "05:50", "05:51", "05:53"]
                },
                {
                    "start": "06:20",
                    "number": "31",
                    "name": "Helyi autóbusz-állomás - Egyenesi u. forduló",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló"],
                    "stopsTime": ["06:20", "06:22", "06:25", "06:26", "06:27", "06:28", "06:29", "06:30", "06:31", "06:33"]
                },
                {
                    "start": "06:40",
                    "number": "31",
                    "name": "Helyi autóbusz-állomás - Egyenesi u. forduló",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló"],
                    "stopsTime": ["06:40", "06:42", "06:45", "06:46", "06:47", "06:48", "06:49", "06:50", "06:51", "06:53"]
                },
                {
                    "start": "07:00",
                    "number": "31",
                    "name": "Helyi autóbusz-állomás - Egyenesi u. forduló",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló"],
                    "stopsTime": ["07:00", "07:02", "07:05", "07:06", "07:07", "07:08", "07:09", "07:10", "07:11", "07:13"]
                },
                {
                    "start": "07:30",
                    "number": "31",
                    "name": "Helyi autóbusz-állomás - Egyenesi u. forduló",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló"],
                    "stopsTime": ["07:30", "07:32", "07:35", "07:36", "07:37", "07:38", "07:39", "07:40", "07:41", "07:43"]
                },
                {
                    "start": "09:00",
                    "number": "31",
                    "name": "Helyi autóbusz-állomás - Egyenesi u. forduló",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló"],
                    "stopsTime": ["09:00", "09:02", "09:05", "09:06", "09:07", "09:08", "09:09", "09:10", "09:11", "09:13"]
                },
                {
                    "start": "12:00",
                    "number": "31",
                    "name": "Helyi autóbusz-állomás - Egyenesi u. forduló",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló"],
                    "stopsTime": ["12:00", "12:02", "12:05", "12:06", "12:07", "12:08", "12:09", "12:10", "12:11", "12:13"]
                },
                {
                    "start": "13:00",
                    "number": "31",
                    "name": "Helyi autóbusz-állomás - Egyenesi u. forduló",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló"],
                    "stopsTime": ["13:00", "13:02", "13:05", "13:06", "13:07", "13:08", "13:09", "13:10", "13:11", "13:13"]
                },
                {
                    "start": "14:00",
                    "number": "31",
                    "name": "Helyi autóbusz-állomás - Egyenesi u. forduló",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló"],
                    "stopsTime": ["14:00", "14:02", "14:05", "14:06", "14:07", "14:08", "14:09", "14:10", "14:11", "14:13"]
                },
                {
                    "start": "15:00",
                    "number": "31",
                    "name": "Helyi autóbusz-állomás - Egyenesi u. forduló",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló"],
                    "stopsTime": ["15:00", "15:02", "15:05", "15:06", "15:07", "15:08", "15:09", "15:10", "15:11", "15:13"]
                },
                {
                    "start": "16:00",
                    "number": "31",
                    "name": "Helyi autóbusz-állomás - Egyenesi u. forduló",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló"],
                    "stopsTime": ["16:00", "16:02", "16:05", "16:06", "16:07", "16:08", "16:09", "16:10", "16:11", "16:13"]
                },
                {
                    "start": "17:00",
                    "number": "31",
                    "name": "Helyi autóbusz-állomás - Egyenesi u. forduló",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló"],
                    "stopsTime": ["17:00", "17:02", "17:05", "17:06", "17:07", "17:08", "17:09", "17:10", "17:11", "17:13"]
                },
                {
                    "start": "18:00",
                    "number": "31",
                    "name": "Helyi autóbusz-állomás - Egyenesi u. forduló",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló"],
                    "stopsTime": ["18:00", "18:02", "18:05", "18:06", "18:07", "18:08", "18:09", "18:10", "18:11", "18:13"]
                },
                {
                    "start": "19:20",
                    "number": "31",
                    "name": "Helyi autóbusz-állomás - Egyenesi u. forduló",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló"],
                    "stopsTime": ["19:20", "19:22", "19:25", "19:26", "19:27", "19:28", "19:29", "19:30", "19:31", "19:33"]
                },
    /*-----------------------------------------------------31 END------------------------------------------------------*/
    /*-----------------------------------------------------32------------------------------------------------------*/
                {
                    "start": "05:30",
                    "number": "32",
                    "name": "Helyi autóbuszállomás - Kecelhegy - Helyi autóbusz-állomás",
                    "stops": ["Helyi autóbuszállomás","Berzsenyi u. felüljáró","Tompa M. u.","Kölcsey u.","Állatkórház","Eger u.","Magyar Nobel-díjasok tere","Bethlen G. u.","Kecelhegyi iskola","Kőrösi Cs. S. u."
                    ,"Kecelheygalja u.","Mátyás k. u., forduló","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Berzsenyi u. 30.","Berzsenyi u. felüljáró","Heyi autóbusz-állomás"],
                    "stopsTime": ["05:30","05:32","05:35","05:36","05:38","05:39","05:40","05:41","05:42","05:44","05:45","05:47","05:49","05:50","05:51","05:53","05:55","05:57","05:59"]
                },
                {
                    "start": "06:30",
                    "number": "32",
                    "name": "Helyi autóbuszállomás - Kecelhegy - Helyi autóbusz-állomás",
                    "stops": ["Helyi autóbuszállomás","Berzsenyi u. felüljáró","Tompa M. u.","Kölcsey u.","Állatkórház","Eger u.","Magyar Nobel-díjasok tere","Bethlen G. u.","Kecelhegyi iskola","Kőrösi Cs. S. u."
                    ,"Kecelheygalja u.","Mátyás k. u., forduló","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Berzsenyi u. 30.","Berzsenyi u. felüljáró","Heyi autóbusz-állomás"],
                    "stopsTime": ["06:30","06:32","06:35","06:36","06:38","06:39","06:40","06:41","06:42","06:44","06:45","06:47","06:49","06:50","06:51","06:53","06:55","06:57","06:59"]
                },
                {
                    "start": "06:45",
                    "number": "32",
                    "name": "Helyi autóbuszállomás - Kecelhegy - Helyi autóbusz-állomás",
                    "stops": ["Helyi autóbuszállomás","Berzsenyi u. felüljáró","Tompa M. u.","Kölcsey u.","Állatkórház","Eger u.","Magyar Nobel-díjasok tere","Bethlen G. u.","Kecelhegyi iskola","Kőrösi Cs. S. u."
                    ,"Kecelheygalja u.","Mátyás k. u., forduló","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Berzsenyi u. 30.","Berzsenyi u. felüljáró","Heyi autóbusz-állomás"],
                    "stopsTime": ["06:45","06:47","06:50","06:51","06:53","06:54","06:55","06:56","06:57","06:59","07:00","07:02","07:04","07:05","07:06","07:08","07:10","07:12","07:14"]
                },
                {
                    "start": "07:15",
                    "number": "32",
                    "name": "Helyi autóbuszállomás - Kecelhegy - Helyi autóbusz-állomás",
                    "stops": ["Helyi autóbuszállomás","Berzsenyi u. felüljáró","Tompa M. u.","Kölcsey u.","Állatkórház","Eger u.","Magyar Nobel-díjasok tere","Bethlen G. u.","Kecelhegyi iskola","Kőrösi Cs. S. u."
                    ,"Kecelheygalja u.","Mátyás k. u., forduló","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Berzsenyi u. 30.","Berzsenyi u. felüljáró","Heyi autóbusz-állomás"],
                    "stopsTime": ["07:15","07:17","07:20","07:21","07:23","07:24","07:25","07:26","07:27","07:29","07:30","07:32","07:34","07:35","07:36","07:38","07:40","07:42","07:44"]
                },
                {
                    "start": "07:40",
                    "number": "32",
                    "name": "Helyi autóbuszállomás - Kecelhegy - Helyi autóbusz-állomás",
                    "stops": ["Helyi autóbuszállomás","Berzsenyi u. felüljáró","Tompa M. u.","Kölcsey u.","Állatkórház","Eger u.","Magyar Nobel-díjasok tere","Bethlen G. u.","Kecelhegyi iskola","Kőrösi Cs. S. u."
                    ,"Kecelheygalja u.","Mátyás k. u., forduló","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Berzsenyi u. 30.","Berzsenyi u. felüljáró","Heyi autóbusz-állomás"],
                    "stopsTime": ["07:40","07:42","07:45","07:46","07:48","07:49","07:50","07:51","07:52","07:54","07:55","07:57","07:59","08:00","08:01","08:03","08:05","08:07","08:09"]
                },
                {
                    "start": "10:30",
                    "number": "32",
                    "name": "Helyi autóbuszállomás - Kecelhegy - Helyi autóbusz-állomás",
                    "stops": ["Helyi autóbuszállomás","Berzsenyi u. felüljáró","Tompa M. u.","Kölcsey u.","Állatkórház","Eger u.","Magyar Nobel-díjasok tere","Bethlen G. u.","Kecelhegyi iskola","Kőrösi Cs. S. u."
                    ,"Kecelheygalja u.","Mátyás k. u., forduló","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Berzsenyi u. 30.","Berzsenyi u. felüljáró","Heyi autóbusz-állomás"],
                    "stopsTime": ["10:30","10:32","10:35","10:36","10:38","10:39","10:40","10:41","10:42","10:44","10:45","10:47","10:49","10:50","10:51","10:53","10:55","10:57","10:59"]
                },
                {
                    "start": "13:30",
                    "number": "32",
                    "name": "Helyi autóbuszállomás - Kecelhegy - Helyi autóbusz-állomás",
                    "stops": ["Helyi autóbuszállomás","Berzsenyi u. felüljáró","Tompa M. u.","Kölcsey u.","Állatkórház","Eger u.","Magyar Nobel-díjasok tere","Bethlen G. u.","Kecelhegyi iskola","Kőrösi Cs. S. u."
                    ,"Kecelheygalja u.","Mátyás k. u., forduló","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Berzsenyi u. 30.","Berzsenyi u. felüljáró","Heyi autóbusz-állomás"],
                    "stopsTime": ["13:30","13:32","13:35","13:36","13:38","13:39","13:40","13:41","13:42","13:44","13:45","13:47","13:49","13:50","13:51","13:53","13:55","13:57","13:59"]
                },
                {
                    "start": "15:30",
                    "number": "32",
                    "name": "Helyi autóbuszállomás - Kecelhegy - Helyi autóbusz-állomás",
                    "stops": ["Helyi autóbuszállomás","Berzsenyi u. felüljáró","Tompa M. u.","Kölcsey u.","Állatkórház","Eger u.","Magyar Nobel-díjasok tere","Bethlen G. u.","Kecelhegyi iskola","Kőrösi Cs. S. u."
                    ,"Kecelheygalja u.","Mátyás k. u., forduló","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Berzsenyi u. 30.","Berzsenyi u. felüljáró","Heyi autóbusz-állomás"],
                    "stopsTime": ["15:30","15:32","15:35","15:36","15:38","15:39","15:40","15:41","15:42","15:44","15:45","15:47","15:49","15:50","15:51","15:53","15:55","15:57","15:59"]
                },
    /*-----------------------------------------------------32 END------------------------------------------------------*/
    /*-----------------------------------------------------33------------------------------------------------------*/
                {
                    "start": "04:30",
                    "number": "33",
                    "name": "Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló", "Beszédes J. u.", "Egyenesi u. 42.", "Kapoli A. u.", "Magyar Nobel-díjasok tere", "Bethlen G. u.", "Kecelhegyi iskola", "Kőrösi Cs. S. u.", "Kecelhegyalja u.", "Mátyás k. u., forduló", "Hajnóczy u. csp.", "Vasútköz", "Városi könyvtár", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["04:30", "04:32", "04:34", "04:35", "04:36", "04:37", "04:38", "04:39", "04:40", "04:41", "04:42", "04:43", "04:44", "04:45", "04:46", "04:48", "04:50", "04:51", "04:52", "04:53", "04:54", "04:55", "04:56", "04:57", "04:59", "05:00"]
                },
                {
                    "start": "05:00",
                    "number": "33",
                    "name": "Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló", "Beszédes J. u.", "Egyenesi u. 42.", "Kapoli A. u.", "Magyar Nobel-díjasok tere", "Bethlen G. u.", "Kecelhegyi iskola", "Kőrösi Cs. S. u.", "Kecelhegyalja u.", "Mátyás k. u., forduló", "Hajnóczy u. csp.", "Vasútköz", "Városi könyvtár", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["05:00", "05:02", "05:04", "05:05", "05:06", "05:07", "05:08", "05:09", "05:10", "05:11", "05:12", "05:13", "05:14", "05:15", "05:16", "05:18", "05:20", "05:21", "05:22", "05:23", "05:24", "05:25", "05:26", "05:27", "05:29", "05:30"]

                },
                {
                    "start": "09:30",
                    "number": "33",
                    "name": "Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló", "Beszédes J. u.", "Egyenesi u. 42.", "Kapoli A. u.", "Magyar Nobel-díjasok tere", "Bethlen G. u.", "Kecelhegyi iskola", "Kőrösi Cs. S. u.", "Kecelhegyalja u.", "Mátyás k. u., forduló", "Hajnóczy u. csp.", "Vasútköz", "Városi könyvtár", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["09:30", "09:32", "09:35", "09:36", "09:37", "09:38", "09:39", "09:40", "09:41", "09:42", "09:43", "09:44", "09:45", "09:46", "09:47", "09:49", "09:50", "09:51", "09:52", "09:54", "09:56", "09:57", "09:59", "10:00", "10:02", "10:04"]
                },
                {
                    "start": "11:30",
                    "number": "33",
                    "name": "Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló", "Beszédes J. u.", "Egyenesi u. 42.", "Kapoli A. u.", "Magyar Nobel-díjasok tere", "Bethlen G. u.", "Kecelhegyi iskola", "Kőrösi Cs. S. u.", "Kecelhegyalja u.", "Mátyás k. u., forduló", "Hajnóczy u. csp.", "Vasútköz", "Városi könyvtár", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["11:30", "11:32", "11:35", "11:36", "11:37", "11:38", "11:39", "11:40", "11:41", "11:42", "11:43", "11:44", "11:45", "11:46", "11:47", "11:49", "11:50", "11:51", "11:52", "11:54", "11:56", "11:57", "11:59", "12:00", "12:02", "12:04"]

                },
                {
                    "start": "12:30",
                    "number": "33",
                    "name": "Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló", "Beszédes J. u.", "Egyenesi u. 42.", "Kapoli A. u.", "Magyar Nobel-díjasok tere", "Bethlen G. u.", "Kecelhegyi iskola", "Kőrösi Cs. S. u.", "Kecelhegyalja u.", "Mátyás k. u., forduló", "Hajnóczy u. csp.", "Vasútköz", "Városi könyvtár", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["12:30", "12:32", "12:35", "12:36", "12:37", "12:38", "12:39", "12:40", "12:41", "12:42", "12:43", "12:44", "12:45", "12:46", "12:47", "12:49", "12:50", "12:51", "12:52", "12:54", "12:56", "12:57", "12:59", "13:00", "13:02", "13:04"]
                },
                {
                    "start": "14:35",
                    "number": "33",
                    "name": "Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló", "Beszédes J. u.", "Egyenesi u. 42.", "Kapoli A. u.", "Magyar Nobel-díjasok tere", "Bethlen G. u.", "Kecelhegyi iskola", "Kőrösi Cs. S. u.", "Kecelhegyalja u.", "Mátyás k. u., forduló", "Hajnóczy u. csp.", "Vasútköz", "Városi könyvtár", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["14:35", "14:37", "14:40", "14:41", "14:42", "14:43", "14:44", "14:45", "14:46", "14:47", "14:48", "14:49", "14:50", "14:51", "14:52", "14:54", "14:55", "14:56", "14:57", "14:59", "15:01", "15:02", "15:04", "15:05", "15:07", "15:09"]
                },
                {
                    "start": "16:30",
                    "number": "33",
                    "name": "Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló", "Beszédes J. u.", "Egyenesi u. 42.", "Kapoli A. u.", "Magyar Nobel-díjasok tere", "Bethlen G. u.", "Kecelhegyi iskola", "Kőrösi Cs. S. u.", "Kecelhegyalja u.", "Mátyás k. u., forduló", "Hajnóczy u. csp.", "Vasútköz", "Városi könyvtár", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["16:30", "16:32", "16:35", "16:36", "16:37", "16:38", "16:39", "16:40", "16:41", "16:42", "16:43", "16:44", "16:45", "16:46", "16:47", "16:49", "16:50", "16:51", "16:52", "16:54", "16:56", "16:57", "16:59", "17:00", "17:02", "17:04"]
                },
                {
                    "start": "17:30",
                    "number": "33",
                    "name": "Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló", "Beszédes J. u.", "Egyenesi u. 42.", "Kapoli A. u.", "Magyar Nobel-díjasok tere", "Bethlen G. u.", "Kecelhegyi iskola", "Kőrösi Cs. S. u.", "Kecelhegyalja u.", "Mátyás k. u., forduló", "Hajnóczy u. csp.", "Vasútköz", "Városi könyvtár", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["17:30", "17:32", "17:35", "17:36", "17:37", "17:38", "17:39", "17:40", "17:41", "17:42", "17:43", "17:44", "17:45", "17:46", "17:47", "17:49", "17:50", "17:51", "17:52", "17:54", "17:56", "17:57", "17:59", "18:00", "18:02", "18:04"]
                },
                {
                    "start": "18:20",
                    "number": "33",
                    "name": "Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló", "Beszédes J. u.", "Egyenesi u. 42.", "Kapoli A. u.", "Magyar Nobel-díjasok tere", "Bethlen G. u.", "Kecelhegyi iskola", "Kőrösi Cs. S. u.", "Kecelhegyalja u.", "Mátyás k. u., forduló", "Hajnóczy u. csp.", "Vasútköz", "Városi könyvtár", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["18:20", "18:22", "18:25", "18:26", "18:27", "18:28", "18:29", "18:30", "18:31", "18:32", "18:33", "18:34", "18:35", "18:36", "18:37", "18:39", "18:40", "18:41", "18:42", "18:44", "18:46", "18:47", "18:49", "18:50", "18:52", "18:54"]
                },
                {
                    "start": "20:00",
                    "number": "33",
                    "name": "Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló", "Beszédes J. u.", "Egyenesi u. 42.", "Kapoli A. u.", "Magyar Nobel-díjasok tere", "Bethlen G. u.", "Kecelhegyi iskola", "Kőrösi Cs. S. u.", "Kecelhegyalja u.", "Mátyás k. u., forduló", "Hajnóczy u. csp.", "Vasútköz", "Városi könyvtár", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["20:00", "20:02", "20:05", "20:06", "20:07", "20:08", "20:09", "20:10", "20:11", "20:12", "20:13", "20:14", "20:15", "20:16", "20:17", "20:19", "20:20", "20:21", "20:22", "20:24", "20:26", "20:27", "20:29", "20:30", "20:32", "20:34"]
                },
                {
                    "start": "20:40",
                    "number": "33",
                    "name": "Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló", "Beszédes J. u.", "Egyenesi u. 42.", "Kapoli A. u.", "Magyar Nobel-díjasok tere", "Bethlen G. u.", "Kecelhegyi iskola", "Kőrösi Cs. S. u.", "Kecelhegyalja u.", "Mátyás k. u., forduló", "Hajnóczy u. csp.", "Vasútköz", "Városi könyvtár", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["20:40", "20:42", "20:45", "20:46", "20:47", "20:48", "20:49", "20:50", "20:51", "20:52", "20:53", "20:54", "20:55", "20:56", "20:57", "20:59", "21:00", "21:01", "21:02", "21:04", "21:06", "21:07", "21:09", "21:10", "21:12", "21:14"]
                },
                {
                    "start": "22:30",
                    "number": "33",
                    "name": "Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Tompa M. u.", "Kölcsey u.", "Állatkórház", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Egyenesi u. forduló", "Beszédes J. u.", "Egyenesi u. 42.", "Kapoli A. u.", "Magyar Nobel-díjasok tere", "Bethlen G. u.", "Kecelhegyi iskola", "Kőrösi Cs. S. u.", "Kecelhegyalja u.", "Mátyás k. u., forduló", "Hajnóczy u. csp.", "Vasútköz", "Városi könyvtár", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"],
                    "stopsTime": ["22:30", "22:31", "22:32", "22:33", "22:34", "22:35", "22:36", "22:37", "22:38", "22:39", "22:40", "22:41", "22:42", "22:43", "22:44", "22:45", "22:46", "22:47", "22:48", "22:49", "22:50", "22:51", "22:52", "22:53", "22:54", "22:55"]

                },
    /*-----------------------------------------------------33 END------------------------------------------------------*/
    /*-----------------------------------------------------40------------------------------------------------------*/
                {
                    "start": "05:55",
                    "number": "40",
                    "name": "Koppány vezér u - 67-es út - Raktár u.",
                    "stops": ["Koppány vezér u.","Erdősor u.","Rózsa u.","67-es sz. út","Berzsenyi u. felüljáró","Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Berzsenyi u. 30.","Füredi utcai csomópont","Városi könyvtár"
                    ,"Vasútköz","Hajnóczy u. csp.","Jutai u. 24.","Tóth Á. u.","Jutai u. 45.","Raktár u. 2.","Raktár u."],
                    "stopsTime": ["05:55","05:56","05:58","05:59","06:03","06:05","06:07","06:09","06:12","06:13","06:14","06:15","06:16","06:17","06:18","06:19","06:20"]
                },
                {
                    "start": "07:40",
                    "number": "40",
                    "name": "Koppány vezér u - 67-es út - Raktár u.",
                    "stops": ["Koppány vezér u.","Erdősor u.","Rózsa u.","67-es sz. út","Berzsenyi u. felüljáró","Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Berzsenyi u. 30.","Füredi utcai csomópont","Városi könyvtár"
                    ,"Vasútköz","Hajnóczy u. csp.","Jutai u. 24.","Tóth Á. u.","Jutai u. 45.","Raktár u. 2.","Raktár u."],
                    "stopsTime": ["07:40","07:41","07:43","07:44","07:48","07:50","07:52","07:54","07:57","07:58","07:59","08:00","08:01","08:02","08:03","08:04","08:05"]
                },
                {
                    "start": "14:35",
                    "number": "40",
                    "name": "Koppány vezér u - 67-es út - Raktár u.",
                    "stops": ["Koppány vezér u.","Erdősor u.","Rózsa u.","67-es sz. út","Berzsenyi u. felüljáró","Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Berzsenyi u. 30.","Füredi utcai csomópont","Városi könyvtár"
                    ,"Vasútköz","Hajnóczy u. csp.","Jutai u. 24.","Tóth Á. u.","Jutai u. 45.","Raktár u. 2.","Raktár u."],
                    "stopsTime": ["14:35","14:36","14:38","14:39","14:43","14:45","14:47","14:49","14:52","14:53","14:54","14:55","14:56","14:57","14:58","14:59","15:00"]
                },
                {
                    "start": "18:15",
                    "number": "40",
                    "name": "Koppány vezér u - 67-es út - Raktár u.",
                    "stops": ["Koppány vezér u.","Erdősor u.","Rózsa u.","67-es sz. út","Berzsenyi u. felüljáró","Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Berzsenyi u. 30.","Füredi utcai csomópont","Városi könyvtár"
                    ,"Vasútköz","Hajnóczy u. csp.","Jutai u. 24.","Tóth Á. u.","Jutai u. 45.","Raktár u. 2.","Raktár u."],
                    "stopsTime": ["18:15","18:16","18:18","18:19","18:23","18:25","18:27","18:29","18:32","18:33","18:34","18:35","18:36","18:37","18:38","18:39","18:40"]
                },
    /*-----------------------------------------------------40 END------------------------------------------------------*/
    /*-----------------------------------------------------41------------------------------------------------------*/
                {
                    "start": "05:05",
                    "number": "41",
                    "name": "Koppány vezér u. - Raktár u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["05:05", "05:06", "05:09", "05:10", "05:11", "05:13", "05:15", "05:17", "05:19", "05:22", "05:23", "05:24", "05:25", "05:26", "05:27", "05:28", "05:29", "05:30"]
                },
                {
                    "start": "06:20",
                    "number": "41",
                    "name": "Koppány vezér u. - Raktár u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["06:20", "06:21", "06:24", "06:25", "06:26", "06:28", "06:30", "06:32", "06:34", "06:37", "06:38", "06:39", "06:40", "06:41", "06:42", "06:43", "06:44", "06:45"]
                },
                {
                    "start": "06:45",
                    "number": "41",
                    "name": "Koppány vezér u. - Raktár u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["06:45", "06:46", "06:49", "06:50", "06:51", "06:53", "06:55", "06:57", "06:59", "07:02", "07:03", "07:04", "07:05", "07:06", "07:07", "07:08", "07:09", "07:10"]
                },
                {
                    "start": "07:10",
                    "number": "41",
                    "name": "Koppány vezér u. - Raktár u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["07:10", "07:11", "07:14", "07:15", "07:16", "07:18", "07:20", "07:22", "07:24", "07:27", "07:28", "07:29", "07:30", "07:31", "07:32", "07:33", "07:34", "07:35"]

                },
                {
                    "start": "09:15",
                    "number": "41",
                    "name": "Koppány vezér u. - Raktár u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["09:15", "09:16", "09:19", "09:20", "09:21", "09:23", "09:25", "09:27", "09:29", "09:32", "09:33", "09:34", "09:35", "09:36", "09:37", "09:38", "09:39", "09:40"]
                },
                {
                    "start": "10:55",
                    "number": "41",
                    "name": "Koppány vezér u. - Raktár u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["10:55", "10:56", "10:59", "11:00", "11:01", "11:03", "11:05", "11:07", "11:09", "11:12", "11:13", "11:14", "11:15", "11:16", "11:17", "11:18", "11:19", "11:20"]
                },
                {
                    "start": "12:50",
                    "number": "41",
                    "name": "Koppány vezér u. - Raktár u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["12:50", "12:51", "12:54", "12:55", "12:56", "12:58", "13:00", "13:02", "13:04", "13:07", "13:08", "13:09", "13:10", "13:11", "13:12", "13:13", "13:14", "13:15"]
                },
                {
                    "start": "13:40",
                    "number": "41",
                    "name": "Koppány vezér u. - Raktár u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["13:40", "13:41", "13:44", "13:45", "13:46", "13:48", "13:50", "13:52", "13:54", "13:57", "13:58", "13:59", "14:00", "14:01", "14:02", "14:03", "14:04", "14:05"]

                },
                {
                    "start": "15:25",
                    "number": "41",
                    "name": "Koppány vezér u. - Raktár u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["15:25", "15:26", "15:29", "15:30", "15:31", "15:33", "15:35", "15:37", "15:39", "15:42", "15:43", "15:44", "15:45", "15:46", "15:47", "15:48", "15:49", "15:50"]
                },
                {
                    "start": "16:30",
                    "number": "41",
                    "name": "Koppány vezér u. - Raktár u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["16:30", "16:31", "16:34", "16:35", "16:36", "16:38", "16:40", "16:42", "16:44", "16:47", "16:48", "16:49", "16:50", "16:51", "16:52", "16:53", "16:54", "16:55"]
                },
                {
                    "start": "17:10",
                    "number": "41",
                    "name": "Koppány vezér u. - Raktár u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["17:10", "17:11", "17:14", "17:15", "17:16", "17:18", "17:20", "17:22", "17:24", "17:27", "17:28", "17:29", "17:30", "17:31", "17:32", "17:33", "17:34", "17:35"]
                },
                {
                    "start": "19:55",
                    "number": "41",
                    "name": "Koppány vezér u. - Raktár u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["19:55", "19:56", "19:59", "20:00", "20:01", "20:03", "20:05", "20:07", "20:09", "20:12", "20:13", "20:14", "20:15", "20:16", "20:17", "20:18", "20:19", "20:20"]
                },
                {
                    "start": "20:55",
                    "number": "41",
                    "name": "Koppány vezér u. - Raktár u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["20:55", "20:56", "20:59", "21:00", "21:01", "21:03", "21:05", "21:07", "21:09", "21:12", "21:13", "21:14", "21:15", "21:16", "21:17", "21:18", "21:19", "21:20"]
                },
    /*-----------------------------------------------------41 END------------------------------------------------------*/
    /*-----------------------------------------------------43------------------------------------------------------*/
                {
                    "start": "08:50",
                    "number": "43",
                    "name": "Helyi autóbusz-áll.-Kórház-Raktár u.-Helyi autóbusz-áll.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["08:50", "08:51", "08:53", "08:54", "08:55", "08:56", "09:00", "09:01", "09:02", "09:03", "09:05", "09:06", "09:08", "09:09", "09:10", "09:12", "09:13", "09:18"]
                },
                {
                    "start": "11:20",
                    "number": "43",
                    "name": "Helyi autóbusz-áll.-Kórház-Raktár u.-Helyi autóbusz-áll.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["11:20", "11:21", "11:23", "11:24", "11:25", "11:26", "11:30", "11:31", "11:32", "11:33", "11:35", "11:36", "11:38", "11:39", "11:40", "11:42", "11:43", "11:48"]
                },
    /*-----------------------------------------------------43 END------------------------------------------------------*/
    /*-----------------------------------------------------44------------------------------------------------------*/
                {
                    "start": "08:30",
                    "number": "44",
                    "name": "Helyi autóbusz-állomás - Raktár utca - Laktanya -Arany János tér - Helyi autóbusz-állomás",
                    "stops": ["Helyi autóbusz-állomás", "Kapostüskevár","Jutai u. 24.","Tóth Á. u.","Jutai u. 45.","Raktár u. 2.","Raktár u.","Laktanya","Búzavirág u.","Nagyszeben u."
                    ,"Losonc-köz","Arany J. tér","Buzsáki u.","Rendőrség","Szent Imre u. 29","Szent Imre u. 13.","Széchényi tér","Rákóczi tér","Helyi autóbusz-állomás"],
                    "stopsTime": ["08:30","08:32","08:33","08:34","08:35","08:37","08:39","08:40","08:42","08:43","08:45","08:46","08:49","08:50","08:51","08:52","08:53","08:54","08:55"]
                },
                {
                    "start": "11:35",
                    "number": "44",
                    "name": "Helyi autóbusz-állomás - Raktár utca - Laktanya -Arany János tér - Helyi autóbusz-állomás",
                    "stops": ["Helyi autóbusz-állomás", "Kapostüskevár","Jutai u. 24.","Tóth Á. u.","Jutai u. 45.","Raktár u. 2.","Raktár u.","Laktanya","Búzavirág u.","Nagyszeben u."
                    ,"Losonc-köz","Arany J. tér","Buzsáki u.","Rendőrség","Szent Imre u. 29","Szent Imre u. 13.","Széchényi tér","Rákóczi tér","Helyi autóbusz-állomás"],
                    "stopsTime": ["11:35","11:37","11:38","11:39","11:40","11:42","11:44","11:45","11:47","11:48","11:50","11:51","11:54","11:55","11:56","11:57","11:58","11:59","12:00"]
                },
                {
                    "start": "13:20",
                    "number": "44",
                    "name": "Helyi autóbusz-állomás - Raktár utca - Laktanya -Arany János tér - Helyi autóbusz-állomás",
                    "stops": ["Helyi autóbusz-állomás", "Kapostüskevár","Jutai u. 24.","Tóth Á. u.","Jutai u. 45.","Raktár u. 2.","Raktár u.","Laktanya","Búzavirág u.","Nagyszeben u."
                    ,"Losonc-köz","Arany J. tér","Buzsáki u.","Rendőrség","Szent Imre u. 29","Szent Imre u. 13.","Széchényi tér","Rákóczi tér","Helyi autóbusz-állomás"],
                    "stopsTime": ["13:20","13:22","13:23","13:24","13:25","13:27","13:29","13:30","13:32","13:33","13:35","13:36","13:39","13:40","13:41","13:42","13:43","13:44","13:45"]
                },
    /*-----------------------------------------------------44 END------------------------------------------------------*/
    /*-----------------------------------------------------45------------------------------------------------------*/
                {
                    "start": "04:35",
                    "number": "45",
                    "name": "Helyi autóbusz-állomás - Koppány vezér u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["04:35", "04:37", "04:39", "04:40", "04:42", "04:43"]
                },
                {
                    "start": "04:35",
                    "number": "45",
                    "name": "Helyi autóbusz-állomás - Koppány vezér u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["10:45", "10:47", "10:49", "10:50", "10:52", "10:53"]
                },
                {
                    "start": "04:35",
                    "number": "45",
                    "name": "Helyi autóbusz-állomás - Koppány vezér u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["12:00", "12:02", "12:04", "12:05", "12:07", "12:08"]

                },
                {
                    "start": "12:40",
                    "number": "45",
                    "name": "Helyi autóbusz-állomás - Koppány vezér u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["12:40", "12:42", "12:44", "12:45", "12:47", "12:48"]
                },
                {
                    "start": "12:40",
                    "number": "45",
                    "name": "Helyi autóbusz-állomás - Koppány vezér u.",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Szegfű u.", "Jókai u.", "Bartók B. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Jutai u. 24.", "Tóth Á. u.", "Jutai u. 45.", "Raktár u. 2.", "Raktár u."],
                    "stopsTime": ["19:45", "19:47", "19:49", "19:50", "19:52", "19:53"]
                },
    /*-----------------------------------------------------45 END------------------------------------------------------*/
    /*-----------------------------------------------------46------------------------------------------------------*/
                {
                    "start": "06:10",
                    "number": "46",
                    "name": "Helyi autóbusz-állomás - Töröcske forduló",
                    "stops": ["Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Bartók B. u.","Táncsics M. u.","Zichy u.","Aranyeső u.","Harangvirág u."
                    ,"Gyertányos","Kertbarát felső","Kertbarát alsó","Szőlőhegy","Fenyves u. 37/A","Fenyves u. 31.","Töröcske, forduló"],
                    "stopsTime": ["06:10","06:12","06:14","06:15","06:16","06:17","06:18","06:19","06:20","06:21","06:22","06:23","06:24","06:25"]
                },
                {
                    "start": "06:30",
                    "number": "46",
                    "name": "Helyi autóbusz-állomás - Töröcske forduló",
                    "stops": ["Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Bartók B. u.","Táncsics M. u.","Zichy u.","Aranyeső u.","Harangvirág u."
                    ,"Gyertányos","Kertbarát felső","Kertbarát alsó","Szőlőhegy","Fenyves u. 37/A","Fenyves u. 31.","Töröcske, forduló"],
                    "stopsTime": ["06:30","06:32","06:34","06:35","06:36","06:37","06:38","06:39","06:40","06:41","06:42","06:43","06:44","06:45"]
                },
                {
                    "start": "13:15",
                    "number": "46",
                    "name": "Helyi autóbusz-állomás - Töröcske forduló",
                    "stops": ["Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Bartók B. u.","Táncsics M. u.","Zichy u.","Aranyeső u.","Harangvirág u."
                    ,"Gyertányos","Kertbarát felső","Kertbarát alsó","Szőlőhegy","Fenyves u. 37/A","Fenyves u. 31.","Töröcske, forduló"],
                    "stopsTime": ["13:15","13:17","13:19","13:20","13:21","13:22","13:23","13:24","13:25","13:26","13:27","13:28","13:29","13:30"]
                },
                {
                    "start": "20:35",
                    "number": "46",
                    "name": "Helyi autóbusz-állomás - Töröcske forduló",
                    "stops": ["Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Bartók B. u.","Táncsics M. u.","Zichy u.","Aranyeső u.","Harangvirág u."
                    ,"Gyertányos","Kertbarát felső","Kertbarát alsó","Szőlőhegy","Fenyves u. 37/A","Fenyves u. 31.","Töröcske, forduló"],
                    "stopsTime": ["20:35","20:37","20:39","20:40","20:41","20:42","20:43","20:44","20:45","20:46","20:47","20:48","20:49","20:50"]
                },
    /*-----------------------------------------------------46 END------------------------------------------------------*/
    /*-----------------------------------------------------47------------------------------------------------------*/
                {
                    "start": "04:45",
                    "number": "47",
                    "name": "Koppány vezér u.- Kórház - Kaposfüred forduló",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Rózsa u.", "67-es sz. út", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Tallián Gy. u. 4.", "Kórház", "Tallián Gy. u. 56.", "Tallián Gy. u. 82.", "ÁNTSZ", "Füredi úti csomópont", "Toldi lakónegyed", "Kinizsi ltp.", "Búzavirág u.", "Laktanya", "Volán-telep", "Kaposfüredi u. 12.", "Kaposfüredi u. 104.", "Kaposfüred, központ", "Kaposfüredi u. 244.", "Kaposfüred, forduló"],
                    "stopsTime": ["04:45", "04:46", "04:48", "04:49", "04:51", "04:53", "04:55", "04:57", "04:58", "05:00", "05:01", "05:03", "05:05", "05:06", "05:07", "05:08", "05:10", "05:12", "05:14", "05:15", "05:17", "05:18", "05:20"]
                },
                {
                    "start": "06:00",
                    "number": "47",
                    "name": "Koppány vezér u.- Kórház - Kaposfüred forduló",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Rózsa u.", "67-es sz. út", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Tallián Gy. u. 4.", "Kórház", "Tallián Gy. u. 56.", "Tallián Gy. u. 82.", "ÁNTSZ", "Füredi úti csomópont", "Toldi lakónegyed", "Kinizsi ltp.", "Búzavirág u.", "Laktanya", "Volán-telep", "Kaposfüredi u. 12.", "Kaposfüredi u. 104.", "Kaposfüred, központ", "Kaposfüredi u. 244.", "Kaposfüred, forduló"],
                    "stopsTime": ["06:00", "06:01", "06:03", "06:04", "06:06", "06:08", "06:10", "06:12", "06:13", "06:15", "06:16", "06:18", "06:20", "06:21", "06:22", "06:23", "06:25", "06:27", "06:29", "06:30", "06:32", "06:33", "06:35"]
                },
                {
                    "start": "06:15",
                    "number": "47",
                    "name": "Koppány vezér u.- Kórház - Kaposfüred forduló",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Rózsa u.", "67-es sz. út", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Tallián Gy. u. 4.", "Kórház", "Tallián Gy. u. 56.", "Tallián Gy. u. 82.", "ÁNTSZ", "Füredi úti csomópont", "Toldi lakónegyed", "Kinizsi ltp.", "Búzavirág u.", "Laktanya", "Volán-telep", "Kaposfüredi u. 12.", "Kaposfüredi u. 104.", "Kaposfüred, központ", "Kaposfüredi u. 244.", "Kaposfüred, forduló"],
                    "stopsTime": ["06:15", "06:16", "06:18", "06:19", "06:21", "06:23", "06:25", "06:27", "06:28", "06:30", "06:31", "06:33", "06:35", "06:36", "06:37", "06:38", "06:40", "06:42", "06:44", "06:45", "06:47", "06:48", "06:50"]
                },
                {
                    "start": "08:30",
                    "number": "47",
                    "name": "Koppány vezér u.- Kórház - Kaposfüred forduló",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Rózsa u.", "67-es sz. út", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Tallián Gy. u. 4.", "Kórház", "Tallián Gy. u. 56.", "Tallián Gy. u. 82.", "ÁNTSZ", "Füredi úti csomópont", "Toldi lakónegyed", "Kinizsi ltp.", "Búzavirág u.", "Laktanya", "Volán-telep", "Kaposfüredi u. 12.", "Kaposfüredi u. 104.", "Kaposfüred, központ", "Kaposfüredi u. 244.", "Kaposfüred, forduló"],
                    "stopsTime": ["08:30", "08:31", "08:33", "08:34", "08:36", "08:38", "08:40", "08:42", "08:43", "08:45", "08:46", "08:48", "08:50", "08:51", "08:52", "08:53", "08:55", "08:57", "08:59", "09:00", "09:02", "09:03", "09:05"]

                },
                {
                    "start": "12:10",
                    "number": "47",
                    "name": "Koppány vezér u.- Kórház - Kaposfüred forduló",
                    "stops": ["Koppány vezér u.", "Gönczi F. u.", "Rózsa u.", "67-es sz. út", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Tallián Gy. u. 4.", "Kórház", "Tallián Gy. u. 56.", "Tallián Gy. u. 82.", "ÁNTSZ", "Füredi úti csomópont", "Toldi lakónegyed", "Kinizsi ltp.", "Búzavirág u.", "Laktanya", "Volán-telep", "Kaposfüredi u. 12.", "Kaposfüredi u. 104.", "Kaposfüred, központ", "Kaposfüredi u. 244.", "Kaposfüred, forduló"],
                    "stopsTime": ["12:10", "12:11", "12:13", "12:14", "12:16", "12:18", "12:20", "12:22", "12:23", "12:25", "12:26", "12:28", "12:30", "12:31", "12:32", "12:33", "12:35", "12:37", "12:39", "12:40", "12:42", "12:43", "12:45"]
                },
    /*-----------------------------------------------------47 END------------------------------------------------------*/
    /*-----------------------------------------------------62------------------------------------------------------*/
                {
                    "start": "06:40",
                    "number": "62",
                    "name": "Helyi autóbusz-állomás - Béla király u.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Városi fürdő", "Csalogány u.", "Vikár B. u.", "Béla király u."],
                    "stopsTime": ["06:40", "06:43", "06:45", "06:48", "06:49", "06:50"]
                },
                {
                    "start": "07:05",
                    "number": "62",
                    "name": "Helyi autóbusz-állomás - Béla király u.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Városi fürdő", "Csalogány u.", "Vikár B. u.", "Béla király u."],
                    "stopsTime": ["07:05", "07:08", "07:10", "07:13", "07:14", "07:15"]
                },
                {
                    "start": "07:25",
                    "number": "62",
                    "name": "Helyi autóbusz-állomás - Béla király u.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Városi fürdő", "Csalogány u.", "Vikár B. u.", "Béla király u."],
                    "stopsTime": ["07:25", "07:28", "07:30", "07:33", "07:34", "07:35"]
                },
                {
                    "start": "10:10",
                    "number": "62",
                    "name": "Helyi autóbusz-állomás - Béla király u.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Városi fürdő", "Csalogány u.", "Vikár B. u.", "Béla király u."],
                    "stopsTime": ["10:10", "10:13", "10:15", "10:18", "10:19", "10:20"]

                },
                {
                    "start": "12:10",
                    "number": "62",
                    "name": "Helyi autóbusz-állomás - Béla király u.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Városi fürdő", "Csalogány u.", "Vikár B. u.", "Béla király u."],
                    "stopsTime": ["12:10", "12:13", "12:15", "12:18", "12:19", "12:20"]
                },
                {
                    "start": "13:00",
                    "number": "62",
                    "name": "Helyi autóbusz-állomás - Béla király u.",
                    "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Városi fürdő", "Csalogány u.", "Vikár B. u.", "Béla király u."],
                    "stopsTime": ["13:00", "13:03", "13:05", "13:08", "13:09", "13:10"]
                },
    /*-----------------------------------------------------62 END------------------------------------------------------*/
    /*-----------------------------------------------------71------------------------------------------------------*/
                {
                    "start": "05:30",
                    "number": "71",
                    "name": "Kaposfüred, forduló - Kaposszentjakab, forduló",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["05:30", "05:32", "05:34", "05:36", "05:37", "05:38", "05:40", "05:41", "05:42", "05:44", "05:45", "05:46", "05:47", "05:48", "05:49", "05:51", "05:52", "05:53", "05:55", "05:56", "05:58", "05:59", "06:00", "06:01", "06:02", "06:04", "06:06", "06:08", "06:09", "06:10"]
                },
                {
                    "start": "06:05",
                    "number": "71",
                    "name": "Kaposfüred, forduló - Kaposszentjakab, forduló",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["06:05", "06:07", "06:09", "06:11", "06:12", "06:13", "06:15", "06:16", "06:17", "06:19", "06:20", "06:21", "06:22", "06:23", "06:24", "06:26", "06:27", "06:28", "06:30", "06:31", "06:33", "06:34", "06:35", "06:36", "06:37", "06:39", "06:41", "06:43", "06:44", "06:45"]
                },
                {
                    "start": "07:05",
                    "number": "71",
                    "name": "Kaposfüred, forduló - Kaposszentjakab, forduló",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["07:05", "07:07", "07:09", "07:11", "07:12", "07:13", "07:15", "07:16", "07:17", "07:19", "07:20", "07:21", "07:22", "07:23", "07:24", "07:26", "07:27", "07:28", "07:30", "07:31", "07:33", "07:34", "07:35", "07:36", "07:37", "07:39", "07:41", "07:43", "07:44", "07:45"]

                },
                {
                    "start": "07:25",
                    "number": "71",
                    "name": "Kaposfüred, forduló - Kaposszentjakab, forduló",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["07:25", "07:27", "07:29", "07:31", "07:32", "07:33", "07:35", "07:36", "07:37", "07:39", "07:40", "07:41", "07:42", "07:43", "07:44", "07:46", "07:47", "07:48", "07:50", "07:51", "07:53", "07:54", "07:55", "07:56", "07:57", "07:59", "08:01", "08:03", "08:04", "08:05"]
                },
                {
                    "start": "09:05",
                    "number": "71",
                    "name": "Kaposfüred, forduló - Kaposszentjakab, forduló",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["09:05", "09:07", "09:09", "09:11", "09:12", "09:13", "09:15", "09:16", "09:17", "09:19", "09:20", "09:21", "09:22", "09:23", "09:24", "09:26", "09:27", "09:28", "09:30", "09:31", "09:33", "09:34", "09:35", "09:36", "09:37", "09:39", "09:41", "09:43", "09:44", "09:45"]

                },
                {
                    "start": "10:40",
                    "number": "71",
                    "name": "Kaposfüred, forduló - Kaposszentjakab, forduló",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["10:40", "10:42", "10:44", "10:46", "10:47", "10:48", "10:50", "10:51", "10:52", "10:54", "10:55", "10:56", "10:57", "10:58", "10:59", "11:01", "11:02", "11:03", "11:05", "11:06", "11:08", "11:09", "11:10", "11:11", "11:12", "11:14", "11:16", "11:18", "11:19", "11:20"]
                },
                {
                    "start": "11:20",
                    "number": "71",
                    "name": "Kaposfüred, forduló - Kaposszentjakab, forduló",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["11:20", "11:22", "11:24", "11:26", "11:27", "11:28", "11:30", "11:31", "11:32", "11:34", "11:35", "11:36", "11:37", "11:38", "11:39", "11:41", "11:42", "11:43", "11:45", "11:46", "11:48", "11:49", "11:50", "11:51", "11:52", "11:54", "11:56", "11:58", "11:59", "12:00"]
                },
                {
                    "start": "13:15",
                    "number": "71",
                    "name": "Kaposfüred, forduló - Kaposszentjakab, forduló",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["13:15", "13:17", "13:19", "13:21", "13:22", "13:23", "13:25", "13:26", "13:27", "13:29", "13:30", "13:31", "13:32", "13:33", "13:34", "13:36", "13:37", "13:38", "13:40", "13:41", "13:43", "13:44", "13:45", "13:46", "13:47", "13:49", "13:51", "13:53", "13:54", "13:55"]
                },
                {
                    "start": "16:40",
                    "number": "71",
                    "name": "Kaposfüred, forduló - Kaposszentjakab, forduló",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["16:40", "16:42", "16:44", "16:46", "16:47", "16:48", "16:50", "16:51", "16:52", "16:54", "16:55", "16:56", "16:57", "16:58", "16:59", "17:01", "17:02", "17:03", "17:05", "17:06", "17:08", "17:09", "17:10", "17:11", "17:12", "17:14", "17:16", "17:18", "17:19", "17:20"]
                },
                {
                    "start": "17:10",
                    "number": "71",
                    "name": "Kaposfüred, forduló - Kaposszentjakab, forduló",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["17:10", "17:12", "17:14", "17:16", "17:17", "17:18", "17:20", "17:21", "17:22", "17:24", "17:25", "17:26", "17:27", "17:28", "17:29", "17:31", "17:32", "17:33", "17:35", "17:36", "17:38", "17:39", "17:40", "17:41", "17:42", "17:44", "17:46", "17:48", "17:49", "17:50"]
                },
                {
                    "start": "20:20",
                    "number": "71",
                    "name": "Kaposfüred, forduló - Kaposszentjakab, forduló",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["20:20", "20:22", "20:24", "20:26", "20:27", "20:28", "20:30", "20:31", "20:32", "20:34", "20:35", "20:36", "20:37", "20:38", "20:39", "20:41", "20:42", "20:43", "20:45", "20:46", "20:48", "20:49", "20:50", "20:51", "20:52", "20:54", "20:56", "20:58", "20:59", "21:00"]
                },
                {
                    "start": "22:05",
                    "number": "71",
                    "name": "Kaposfüred, forduló - Kaposszentjakab, forduló",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["22:05", "22:07", "22:09", "22:11", "22:12", "22:13", "22:15", "22:16", "22:17", "22:19", "22:20", "22:21", "22:22", "22:23", "22:24", "22:26", "22:27", "22:28", "22:30", "22:31", "22:33", "22:34", "22:35", "22:36", "22:37", "22:39", "22:41", "22:43", "22:44", "22:45"]
                },

    /*-----------------------------------------------------71 END------------------------------------------------------*/
    /*-----------------------------------------------------73------------------------------------------------------*/
                {
                    "start": "04:45",
                    "number": "73",
                    "name": "Kaposfüred, forduló - Kaposszentjakab, forduló",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["04:45", "04:47", "04:48", "04:50", "04:51", "04:52", "04:54", "04:55", "04:56", "04:58", "04:59", "05:00", "05:02", "05:03", "05:04", "05:06", "05:07", "05:09", "05:11", "05:12", "05:13", "05:14", "05:15", "05:16", "05:17", "05:19", "05:21", "05:23", "05:25", "05:27", "05:28"]
                },
                {
                    "start": "06:40",
                    "number": "73",
                    "name": "Kaposfüred, forduló - Kaposszentjakab, forduló",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["06:40", "06:42", "06:43", "06:45", "06:46", "06:47", "06:49", "06:50", "06:51", "06:53", "06:54", "06:55", "06:57", "06:58", "06:59", "07:01", "07:02", "07:04", "07:06", "07:07", "07:08", "07:09", "07:10", "07:11", "07:12", "07:14", "07:16", "07:18", "07:20", "07:22", "07:23"]

                },
                {
                    "start": "12:45",
                    "number": "73",
                    "name": "Kaposfüred, forduló - Kaposszentjakab, forduló",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["12:45", "12:47", "12:48", "12:50", "12:51", "12:52", "12:54", "12:55", "12:56", "12:58", "12:59", "13:00", "13:02", "13:03", "13:04", "13:06", "13:07", "13:09", "13:11", "13:12", "13:13", "13:14", "13:15", "13:16", "13:17", "13:19", "13:21", "13:23", "13:25", "13:27", "13:28"]
                },
    /*-----------------------------------------------------73 END------------------------------------------------------*/
    /*-----------------------------------------------------75------------------------------------------------------*/
                {
                    "start": "04:35",
                    "number": "75",
                    "name": "Helyi autóbusz-állomás - Kaposszentjakab",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["04:35", "04:37", "04:39", "04:40", "04:41", "04:42", "04:44", "04:45", "04:47", "04:48", "04:49", "04:50"]
                },
                {
                    "start": "06:55",
                    "number": "75",
                    "name": "Helyi autóbusz-állomás - Kaposszentjakab",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["06:55", "06:57", "06:59", "07:00", "07:01", "07:02", "07:04", "07:05", "07:07", "07:08", "07:09", "07:10"]
                },
                {
                    "start": "08:30",
                    "number": "75",
                    "name": "Helyi autóbusz-állomás - Kaposszentjakab",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["08:30", "08:32", "08:34", "08:35", "08:36", "08:37", "08:39", "08:40", "08:42", "08:43", "08:44", "08:45"]

                },
                {
                    "start": "13:30",
                    "number": "75",
                    "name": "Helyi autóbusz-állomás - Kaposszentjakab",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["13:30", "13:32", "13:34", "13:35", "13:36", "13:37", "13:39", "13:40", "13:42", "13:43", "13:44", "13:45"]
                },
                {
                    "start": "15:50",
                    "number": "75",
                    "name": "Helyi autóbusz-állomás - Kaposszentjakab",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["15:50", "15:52", "15:54", "15:55", "15:56", "15:57", "15:59", "16:00", "16:02", "16:03", "16:04", "16:05"]
                },
                {
                    "start": "18:10",
                    "number": "75",
                    "name": "Helyi autóbusz-állomás - Kaposszentjakab",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["18:10", "18:12", "18:14", "18:15", "18:16", "18:17", "18:19", "18:20", "18:22", "18:23", "18:24", "18:25"]
                },
                {
                    "start": "20:15",
                    "number": "75",
                    "name": "Helyi autóbusz-állomás - Kaposszentjakab",
                    "stops": ["Kaposfüred, forduló", "Kaposfüredi u. 244.", "Kaposfüred, központ", "Állomás u.", "Kaposfüred, vá.", "Állomás u.", "Kaposfüred, központ", "Kaposfüredi u. 104.", "Kaposfüredi u. 12.", "Volán-telep", "Zöld Fűtőmű", "Laktanya", "Búzavirág u.", "Kinizsi ltp.", "Toldi lakónegyed", "Füredi úti csomópont", "Berzsenyi u. 30.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás", "Vasútállomás", "Fő u. 48", "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.", "Várhegy feljáró", "Kaposszentjakab, forduló"],
                    "stopsTime": ["20:15", "20:17", "20:19", "20:20", "20:21", "20:22", "20:24", "20:25", "20:27", "20:28", "20:29", "20:30"]
                },
    /*-----------------------------------------------------75 END------------------------------------------------------*/
    ];
/*---------------------------------------------------------------------------------------------------------BUS TIME END--------------------------------------------------------------------------------------------------*/


        // Parse the query string to get the time number and dayGoes
        const urlParams = new URLSearchParams(window.location.search);
        const timeNumber = urlParams.get('timeNumber');
        const timeName = urlParams.get('timeName');
        const timeTime = urlParams.get('startTime');

        // Find the time by its number
        const time = busTime.find(r => r.number === timeNumber);

        // Display time details
        if (time) {
            document.getElementById('timeNumCon').innerHTML = `
                <div class="time-number">${timeNumber}</div>
                <div class="time-date"><input type="date" id="datePicker" disabled /></div>
                <div class="time">${timeTime}</div>
            `;
            document.getElementById('timeNameCon').innerHTML = `
                <div class="time-name">
                    ${timeName}
                </div>
                <div class="switchBtn">
                    <button id="switchBtn" disabled>
                        <img src="switch.png" alt="Switch" style="width: 40px; height: 25px; max-width: 40px; max-width: 20px;">
                    </button>
                </div>
            `;
            displayTimeTable([time]);
        }

        function displayTimeTable(time) {
            const timeContainer = document.getElementById('timeContainer');
            timeContainer.innerHTML = ""; // Clear previous content

            time.forEach((timeItem) => {
                // Loop through stops and stopTimes arrays
                timeItem.stops.forEach((stop, index) => {
                    const timeCard = document.createElement('div');
                    timeCard.className = 'time-card';

                    // Create the card content with stop and stopTime pair
                    timeCard.innerHTML = `
                        <div class="time-stop"> ${stop}</div>
                        <div class="time-time"> ${timeItem.stopsTime[index]}</div>
                    `;
                    
                    timeContainer.appendChild(timeCard);
                });
            });
        }
/*--------------------------------------------------------------------------------------------------------JAVASCRIPT - DATE PICKER---------------------------------------------------------------------------------------*/
    const today = new Date();
    document.getElementById("datePicker").value = today.toISOString().split("T")[0];
    document.getElementById("datePicker").min = today.toISOString().split("T")[0];
/*--------------------------------------------------------------------------------------------------------DATE PICKER END------------------------------------------------------------------------------------------------*/


    </script>
</body>
</html>
