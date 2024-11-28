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
        const busTime = [
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
             {
                "start": "06:10",
                "number": "13",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u.", "forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"]",
                "stopsTime": ["06:10", "06:12", "06:14", "06:17", "06:18", "06:19", "06:20", "06:22", "06:24", "06:25", "06:27", "06:28", "06:30", "06:31", "06:32", "06:33", "06:34", "06:37", "06:39"],
            }",
                        {
                "start": "7:10",
                "number": "13",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u.", "forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"]",
                "stopsTime": ["07:10", "07:12", "07:14", "07:17", "07:18", "07:19", "07:20", "07:22", "07:24", "07:25", "07:27", "07:28", "07:30", "07:31", "07:32", "07:33", "07:34", "07:37", "07:39"]",
            }",
             {
                "start": "8:10",
                "number": "13",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u.", "forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"]",
                "stopsTime": ["08:10", "08:12", "08:14", "08:17", "08:18", "08:19", "08:20", "08:22", "08:24", "08:25", "08:27", "08:28", "08:30", "08:31", "08:32", "08:33", "08:34", "08:37", "08:39"]",
            }",
             {
                "start": "9:10",
                "number": "13",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u.", "forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"]",
                "stopsTime": ["09:10", "09:12", "09:14", "09:17", "09:18", "09:19", "09:20", "09:22", "09:24", "09:25", "09:27", "09:28", "09:30", "09:31", "09:32", "09:33", "09:34", "09:37", "09:39"]",
            }",
                {
                "start": "12:10",
                "number": "13",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u.", "forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"]",
                "stopsTime": ["12:10", 12:12", 12:14", 12:17", 12:18", 12:19", 12:20", 12:22", 12:24", 12:25", 12:27", 12:28", 12:30", 12:31", 12:32", 12:33", 12:34", 12:37", 12:39"]",
            }",
                    {
                "start": "13:25",
                "number": "13",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u.", "forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"]",
                "stopsTime": ["13:25", 13:27", 13:29", 13:32", 13:33", 13:34", 13:35", 13:37", 13:39", 13:40", 13:42", 13:43", 13:45", 13:46", 13:47", 13:48", 13:49", 13:52", 13:54"]",
            }",
            {
                "start": "14:10",
                "number": "13",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u.", "forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"]",
                "stopsTime": ["14:10", 14:12", 14:14", 14:17", 14:18", 14:19", 14:20", 14:22", 14:24", 14:25", 14:27", 14:28", 14:30", 14:31", 14:32", 14:33", 14:34", 14:37", 14:39"]",
            }",
                   {
                "start": "15:40",
                "number": "13",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u.", "forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"]",
                "stopsTime": ["15:40", "15:42", "15:44", "15:47", "15:48", "15:49", "15:50", 15:52", 15:54", 15:55", 15:57", 15:58", 16:00", 16:01", 16:02", 16:03", 16:04", 16:07", 16:09"]",
            }",
                      {
                "start": "16:10",
                "number": "13",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u.", "forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"]",
                "stopsTime": ["16:10", "16:12", "16:14", "16:17", "16:18", "16:19", "16:20", "16:22", "16:24", "16:25", "16:27", "16:28", "16:30", "16:31", "16:32", "16:33", v16:34", "16:37", "16:39"]",                         
            }",
                      {
                "start": "17:10",
                "number": "13",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u.", "forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"]",
                "stopsTime": ["17:10", "17:12", "17:14", "17:17", "17:18", "17:19", "17:20", "17:22", "17:24", "17:25", "17:27", "17:28", "17:30", "17:31", "17:32", "17:33", "17:34", "17:37", "17:39"]",            
            }",
                       {
                "start": "19:10",
                "number": "13",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró", "Berzsenyi u. 30.", "Füredi úti csomópont", "Városi könyvtár", "Vasútköz", "Hajnóczy u. csp.", "Mátyás k. u.", "forduló", "Kecelhegyalja u.", "Kőrösi Cs. S. u.", "Kecelhegyi iskola", "Bethlen G. u.", "Magyar Nobel-díjasok tere", "Eger u.", "Állatkórház", "Kölcsey u.", "Tompa M. u.", "Berzsenyi u. felüljáró", "Helyi autóbusz-állomás"]",
                "stopsTime": ["19:10", 19:12", 19:14", 19:17", 19:18", 19:19", 19:20", 19:22", 19:24", 19:25", 19:27", 19:28", 19:30", 19:31", 19:32", 19:33", 19:34", 19:37", 19:39"],

                          
            },
            {
                "start": "06:15",
                "number": "20",
                "name": "Raktár u. - Laktanya - Videoton", 
                "stops": ["Raktár u.","Jutai u. 45.","Tóth Á. u.","Jutai u. 24.","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Toldi lakónegyed","Kinizsi ltp.","Búzavirág u."
                ,"Laktanya","Laktanya","Búzavirág u.","Nagyszeben u.","Losonc-köz","Arany J. tér","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Kenyérgyár u. 1.","Videoton"],
                "stopsTime": ["06:15","06:16","06:17","06:18","06:19","06:20","06:21","06:22","06:23","06:24","06:25","06:26","06:27","06:28","06:29","06:31","06:32","06:33"
                ,"06:35","06:36","06:37","06:38","06:39","06:40"],
            },
        ];

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
