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
                "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
            },
            {
                "start": "11:00",
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
            },
            {
                "start": "12:30",
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
            },
            {
                "start": "13:00",
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
            },
            {
                "start": "13:30",
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
            },
            {
                "start": "14:20",
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
            },
            {
                "start": "15:00",
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
            },
            {
                "start": "15:45",
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
            },
            {
                "start": "16:00",
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
            },
            {
                "start": "16:30",
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
            },
            {
                "start": "16:45",
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
            },
            {
                "start": "17:00",
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
            },
            {
                "start": "17:15",
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
            },
            {
                "start": "17:30",
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
            },
            {
                "start": "19:00",
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
            },
            {
                "start": "20:30",
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
            },
            {
                "start": "06:10",
                "number": "13",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "stopsTime": ["07:30","07:31","07:34","07:36","07:38","07:40","07:41","07:42","07:43","07:45"],
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
