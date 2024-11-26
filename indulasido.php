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

        #datePicker{
            margin-left: 45%;
            font-size: 1rem;
            background-color: #fbfbfb;
            color: #211717;
            border: 1px solid #fff;
        } 
/*--------------------------------------------------------------------------------------------------------HEADER END-----------------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------------------CSS - OTHER PARTS----------------------------------------------------------------------------------------------*/
        .route-container {
            display: inline;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            padding: 2rem;
            max-width: 1000px;
            margin: 0 auto;
        }

        .route-card {
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

        .start-time-card {
            margin: 5px 0;
        }

        .route-card:hover{
            color: 000;
            background: #E9E8E8;
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .routeCon{
            background: #fbfbfb;
            width: 97.5%;
            margin-bottom: 5px;
            padding: 20px;
        }

        .route-number {
            background: #b30000;
            display: flex;
            width: 3%;
            height: 60%;
            font-size: 2.5rem;
            font-weight: bold;
            border-radius: 5px;
            padding-left: 20px;
            padding-right: 15px;
            color: var(--text-light);
            margin-left: 16%;
        }

        .route-name{
            display: inline;
            color: #636363;
            font-size: 1.5rem;
            font-weight: bold;
            margin-left: 16%;
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

        .route-details {
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

            .route-container {
                grid-template-columns: 1fr;
                padding: 1rem;
            }

            .route-card{
                width: 340px;
            }

            .route-number{
                margin-left: 0;
                padding-right: 60px;
            }

            .route-name{
                margin-left: 0;
            }

            .routeCon{
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
            <button class="backBtn" id=backBtn><i class="fa-solid fa-chevron-left"></i></button>
            <h1><i class="fas fa-bus"></i> Kaposvár Helyi Járatok</h1> 
            <input type="date" id="datePicker" require />
        </div>

        <div id="routeNumCon" class="routeCon"></div>
        <div id="routeNameCon" class="routeCon"></div>


        <div id="routeContainer" class="route-container"></div>

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
        const today = new Date();
        document.getElementById("datePicker").value = today.toISOString().split("T")[0];
        document.getElementById("datePicker").min = today.toISOString().split("T")[0];

        const busRoutesIdo = [
            {
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "nameBack": "Laktanya - Sopron u. - Helyi autóbusz-állomás",
                "start": ["05:00","05:30","05:55","06:10","06:30","07:05","07:30","09:90","10:00","10:35","11:00","12:30","13:00"
                ,"13:30","14:20","15:00","15:45","16:00","16:30","16:45","17:00","17:15","17:30","19:00","20:30"],
                "startBack": ["04:45","05:15","05:45","06:10","06:45","07:20","07:45","08:10","09:15","10:15","10:50","11:15"
                ,"12:45","13:15","13:30","13:45","14:35","15:15","16:15","16:45","17:15","17:45","19:15","19:40","20:45"],
                "startWeekend": [],
                "startWeekendBack": [],
                "goesBack": true,
            },
            {
                "number": "13",
                "name": "Helyi autóbusz-állomás - Kecelhegy - Helyi autóbusz-állomás",
                "start": ["06:10","07:10","08:10","09:10","12:10","13:25","14:10","15:40","16:10","17:10","19:10"],
                "startWeekend": ["06:20","08:10","09:10","10:10","11:10","13:10","15:10","19:10"],
                "goesBack": false,
            },
            {
                "number": "20",
                "name": "Raktár u. - Laktanya - Videoton",
                "nameBack": "Videoton - Laktanya - Raktár u.",
                "start": ["06:15","06:40","08:00","10:00","13:05","14:15","16:20","21:10"],
                "startBack": ["05:15","06:40","07:10","08:30","10:30","13:05","15:35","16:15","17:10","22:15"],
                "startWeekend": [],
                "startWeekendBack": [],
                "goesBack": true,
            },
            {
                "number": "21",
                "name": "Raktár u. - Videoton",
                "nameBack": "Videoton - Raktár u.",
                "start": ["05:20","07:00","17:40"],
                "startBack": ["06:15","14:15","18:05"],
                "startSat": [],
                "startSatBack": ["06:15"],
                "goesBack": true,
            },
            {
                "number": "23",
                "name": "Kaposfüred forduló - Füredi csp. - Kaposvári Egyetem",
                "nameBack": "Kaposvári Egyetem - Füredi csp. - Kaposfüred forduló",
                "start": ["05:00","06:55","07:10","07:20","12:55"],
                "startBack": ["12:50","14:15","14:35","16:10","22:10"],
                "startWeekend": [],
                "startWeekendBack": [],
                "goesBack": true,
            },
            {
                "number": "26",
                "name": "Kaposfüred forduló - Losonc köz - Videoton - METYX",
                "nameBack": "METYX - Videoton - Losonc köz - Kaposfüred forduló",
                "start": ["05:05"],
                "startBack": ["14:10"],
                "startWeekend": [],
                "startWeekendBack": [],
                "goesBack": true,
            },
            {
                "number": "27",
                "name": "Laktanya - Füredi u. csp. - KOMÉTA",
                "nameBack": "KOMÉTA - Füredi u. csp. - Laktanya",
                "start": ["04:55","07:10","13:00"],
                "startBack": ["14:20","15:50","22:20"],
                "startWeekend": [],
                "startWeekendBack": [],
                "goesBack": true,
            },
            {
                "number": "31",
                "name": "Helyi autóbusz-állomás - Egyenesi u. forduló",
                "nameBack": "Egyenesi u. forduló - Helyi autóbusz-állomás",
                "start": ["05:40","06:20","06:40","07:00","07:30","09:00","12:00","13:00","14:00","15:00","16:00","17:00"
                ,"18:00","19:20"],
                "startBack": ["05:53","06:33","06:53","07:13","07:43","09:13","12:13","13:13","14:13","15:13","16:13"
                ,"17:13","18:13","19:33"],
                "startWeekend": ["05:50","06:40","08:00","09.00","14:00","17:00"],
                "startWeekendBack": ["06:03","06:53","08:13","09:13","14:13","17:13"],
                "goesBack": true,
            },
            {
                "number": "32",
                "name": "Helyi autóbuszállomás - Kecelhegy - Helyi autóbusz-állomás",
                "start": ["05:30","06:30","06:45","07:15","07:40","10:30","13:30","15:30"],
                "startWeekend": ["07:15","07:40","14:30","20:40"],
                "goesBack": false,
            },
            {
                "number": "33",
                "name": "Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.",
                "start": ["04:30","05:00","09:30","11:30","12:30","14:35","16:30","17:30","18:20","20:00","20:40","22:30"],
                "startWeekend": ["05:00","10:00","11:40","12:30","22:30"],
                "goesBack": false,
            },
            {
                "number": "40",
                "name": "Koppány vezér u - 67-es út - Raktár u.",
                "nameBack": "Raktár u. - 67-es út - Koppány vezér u",
                "start": ["05:55","07:40","14:35","18:15"],
                "startBack": ["04:40","06:20","08:50","13:15","15:00","16:45","20:30"],
                "startWeekend": [],
                "startWeekendBack": [],
                "goesBack": true,
            },
            {
                "number": "41",
                "name": "Koppány vezér u - Bartók B. u. - Raktár u.",
                "nameBack": "Raktár u. - Bartók B. u. - Koppány vezér u",
                "start": ["05:05","06:20","06:45","07:10","09:15","10:55","12:50","13:40","15:25","16:30","17:10","19:55","20:55"],
                "startBack": ["05:30","06:45","07:15","08:00","09:40","11:20","14:10","16:05","17:10","17:40","18:40","22:10"],
                "startWeekend": ["05:05","05:55","06:45","08:05","10:05","10:55","11:45","13:10","14:35","16:30","18:05","09:55"],
                "startWeekendBack": ["05:30","06:20","07:10","09:20","10:30","11:20","12:10","14:10","15:00","16:55","17:40"
                ,"18:40","20:30"],
                "goesBack": true,
            },
            {
                "number": "42",
                "name": "Töröcske forduló - Kórház - Laktanya",
                "nameBack": "Laktanya - Kórház - Töröcske forduló",
                "start": ["04:50","06:10","06:25","06:45","07:15","07:30","08:10","08:50","10:10","11:30","12:50","13:30","14:10"
                ,"15:20","15:40","16:10","16:45","17:40","18:20","19:00","20:50","22:10"],
                "startBack": ["05:30","06:25","06:50","07:10","07:20","08:10","09:30","10:10","10:50","12:10","13:30"
                ,"14:20","15:00","15:30","16:05","16:20","17:00","17:30","18:20","19:10","21:00","22:10"],
                "startWeekend": ["04:50","06:10","07:40","09:00","10:20","11:40","13:00","14:20","16:15","17:00","18:20","20:50"],
                "startWeekendBack": ["05:30","06:40","08:20","09:40","11:00","12:20","13:40","15:00","17:40","19:15","22:10"],
                "goesBack": true,
            },
            {
                "number": "43",
                "name": "Helyi autóbusz-állomás - Kórház- Laktanya - Raktár utca - Helyi autóbusz-állomás",
                "start": ["08:50","11:20"],
                "goesBack": false,
            },
            {
                "number": "44",
                "name": "Helyi autóbusz-állomás - Raktár utca - Laktanya -Arany János tér - Helyi autóbusz-állomás",
                "start": ["08:30","11:35","13:20"],
                "goesBack": false,
            },
            {
                "number": "45",
                "name": "Helyi autóbusz-állomás - 67-es út - Koppány vezér u.",
                "nameBack": "Koppány vezér u. - 67-es út - Helyi autóbusz-állomás",
                "start": ["04:35","10:45","12:00","12:40","19:45"],
                "startBack": ["08:00","10:05","11:45","19:05"],
                "startWeekend": [],
                "startWeekendBack": [],
                "goesBack": true,
            },
            {
                "number": "46",
                "name": "Helyi autóbusz-állomás - Töröcske forduló",
                "nameBack": "Töröcske forduló - Helyi autóbusz-állomás",
                "start": ["06:10","06:30","13:15","20:35"],
                "startBack": ["10:50","17:00","19:50"],
                "startWeekend": [],
                "startWeekendBack": [],
                "goesBack": true,
            },
            {
                "number": "47",
                "name": "Koppány vezér u.- Kórház - Kaposfüred forduló",
                "nameBack": "Kaposfüred forduló - Koppány vezér u.- Kórház",
                "start": ["04:45","06:00","06:15","08:30","12:10"],
                "startBack": ["05:20","06:50"],
                "startWeekend": ["04:45"],
                "startWeekendBack": ["05:20"],
                "goesBack": true,
            },
            {
                "number": "51",
                "name": "Laktanya - Sopron u. - Rómahegy",
                "nameBack": "Rómahegy - Sopron u. - Laktanya",
                "startWeekend": ["04:45","05:20","06:30","07:30","08:30","09:30","10:30","11:30","12:30","13:30","14:30"
                ,"16:45","17:50","18:30","20:30","22:20"],
                "startWeekendBack": ["04:50","05:50","07:00","08:00","10:00","11:00","12:00","13:00","14:00","15:00"
                ,"16:15","18:00","20:00","22:00"],
                "goesBack": true,
            },
            {
                "number": "61",
                "name": "Helyi- autóbuszállomás - Béla király u.",
                "nameBack": "Béla király u. - Helyi- autóbuszállomás",
                "start": ["04:45","06:10","09:10","11:10","13:45","14:25","14:25","15:30","16:20","17:20","17:50","19:55"
                ,"20:50","22:30"],
                "startBack": ["04:55","06:20","06:50","07:15","07:35","10:20","12:20","13:10","20:05","21:00","22:35"],
                "startWeekend": ["07:10","08:10","09:05","10:50","12:10","14:25","19:55"],
                "startWeekendBack": ["07:20","08:20","10:00","13:20","14:35","20.05"],
                "goesBack": true,
            },
            {
                "number": "62",
                "name": "Helyi autóbusz-állomás - Városi fürdő - Béla király u.",
                "nameBack": "Béla király u. - Városi fürdő - Helyi autóbusz-állomás",
                "start": ["06:40","07:05","07:25","10:10","12:10","13:00"],
                "startBack": ["09:18","11:18","13:53","14:33","15:38","16:28","17:28","17:58"],
                "startWeekend": ["09:50","13:10"],
                "startWeekendBack": ["09:15","11:00","12:20"],
                "goesBack": true,
            },
            {
                "number": "70",
                "name": "Helyi autóbusz-állomás - Kaposfüred",
                "nameBack": "Kaposfüred - Helyi autóbusz-állomás",
                "start": ["04:25","06:45","07:05","09:40","10:20","11:35","13:45","15:25","21:45"],
                "startBack": ["07:45","08:05","08:40","09:25","14:45","15:25","16:25","17:55","22:45"],
                "startWeekend": ["09:55"],
                "startWeekendBack": ["10:35","15:20","22:45"],
                "goesBack": true,
            },
            {
                "number": "71",
                "name": "Kaposfüred forduló - Kaposszentjakab forduló",
                "nameBack": "Kaposszentjakab forduló - Kaposfüred forduló",
                "start": ["05:30","06:05","07:05","07:25","09:05","10:40","11:20","13:15","14:25","16:40","17:10","20:20"
                ,"22:05"],
                "startBack": ["05:30","06:00","07:10","07:30","08:05","10:45","12:40","14:50","15:50","16:05","17:20"
                ,"18:25","19:45","20:30"],
                "startWeekend": ["04:35","06:00","06:35","07:20","07:50","09:10","10:15","12:50","14:05","17:35","20:30","22.05"],
                "startWeekendBack": ["06:00","07:15","10:00","10:55","12:15","13:30","14:45","16:00","17:00","18:30","19:55","21:10","22:15"],
                "goesBack": true,
            },
            {
                "number": "72",
                "name": "Kaposfüred forduló - Hold u. - Kaposszentjakab forduló",
                "nameBack": "Kaposszentjakab forduló - Hold u. - Kaposfüred forduló",
                "start": ["10:00","11:55","14:05","15:05","15:50","19:00"],
                "startBack": ["04:50","08:45"],
                "startWeekend": ["11:30","16:35","19:05"],
                "startWeekendBack": ["05:15","06:40","08:30"],
                "goesBack": true,
            },
            {
                "number": "73",
                "name": "Kaposfüred forduló - KOMÉTA - Kaposszentjakab forduló",
                "nameBack": "Kaposszentjakab forduló - KOMÉTA - Kaposfüred forduló",
                "start": ["04:45","06:40","12:45","21:00"],
                "startBack": ["13:45","14:10","16:35","22:10"],
                "startWeekend": [],
                "startWeekendBack": [],
                "goesBack": true,
            },
            {
                "number": "74",
                "name": "Hold utca - Helyi autóbusz-állomás",
                "start": [],
                "goesBack": false,
            },
            {
                "number": "75",
                "name": "Helyi autóbusz-állomás - Kaposszentjakab",
                "nameBack": "Kaposszentjakab - Helyi autóbusz-állomás",
                "start": ["04:35","06:55","08:30","13:30","15:50","18:10","20:15"],
                "startBack": ["06:45","07:45","10:05","11:20","12:00","13:30","15:10","17:50","21:00","22:45"],
                "startWeekend": ["05:45"],
                "startWeekendBack": ["17:20","22:45"],
                "goesBack": true,
            },
            {
                "number": "81",
                "name": "Helyi autóbusz-állomás - Hősök temploma - Toponár forduló",
                "nameBack": "Toponár forduló - Hősök temploma - Helyi autóbusz-állomás",
                "start": ["06:25","07:10","10:35","11:35","13:10","15:05","17:00"],
                "startBack": ["06:47","07:32","10:57","11:57","13:32","15:27","17:22"],
                "startWeekend": [],
                "startWeekendBack": [],
                "goesBack": true,
            },
            {
                "number": "82",
                "name": "Helyi autóbusz-állomás - Kórház - Toponár Szabó P. u.",
                "nameBack": "Toponár Szabó P. u. - Kórház - Helyi autóbusz-állomás",
                "start": ["05:35","06:05","06:35","07:25","08:10","09:35","10:05","11:05","12:50","13:35","14:05","14:40"
                ,"15:30","16:45","17:45"],
                "startBack": ["06:00","06:30","07:00","07:25","07:50","08:35","10:00","10:30","11:30","13:15","14:00"
                ,"14:30","15:05","15:55","17:10","18:10"],
                "startWeekend": [],
                "startWeekendBack": [],
                "goesBack": true,
            },
            {
                "number": "83",
                "name": "Helyi autóbusz-állomás - Szabó P. u. - Toponár forduló",
                "nameBack": "Toponár forduló - Szabó P. u. - Helyi autóbusz-állomás",
                "start": ["04:25","05:05","09:05","12:05","16:00","17:20","18:25","19:05","19:55","20:35","21:20","22:30"],
                "startBack": ["04:46","05:30","09.30","12:30","16:30","17:45","18:50","19:30","20:20","21:00","22:05"],
                "startWeekend": ["04:40","05:35","06:35","07:25","08:45","10:35","11:35","12:25","13:35","14:35","15:55"
                ,"17:20","18:15","19:05","21:20","22:30"],
                "startWeekendBack": ["05:05","06:00","07:00","07:50","09:10","11:00","12:00","12:50","14:00","15:00"
                ,"16:20","17:45","18:40","19:30","21:55","22:50"],
                "goesBack": true,
            },
            {
                "number": "84",
                "name": "Helyi autóbusz-állomás - Toponár, forduló - Répáspuszta",
                "nameBack": "Répáspuszta - Toponár, forduló - Helyi autóbusz-állomás",
                "start": ["06:40","14:20","16:25"],
                "startBack": ["07:05","14:45","16:50"],
                "startWeekend": [],
                "startWeekendBack": [],
                "goesBack": true,
            },
            {
                "number": "85",
                "name": "Helyi autóbusz-állomás - Kisgát- Helyi autóbusz-állomás",
                "start": ["07:00","07:20"],
                "goesBack": false,
            },
            {
                "number": "86",
                "name": "Helyi autóbusz-állomás - METYX - Szennyvíztelep",
                "nameBack": "Szennyvíztelep - METYX - Helyi autóbusz-állomás",
                "start": ["05:20","05:30","06:50","13:55"],
                "startBack": ["14:15","15:00","16:00"],
                "startWeekend": [],
                "startWeekendBack": [],
                "goesBack": true,
            },
            {
                "number": "87",
                "name": "Helyi autóbusz állomás - Videoton - METYX",
                "nameBack": "METYX - Videoton - Helyi autóbusz állomás",
                "start": ["07:15","13:20","13:27","21:20","21:30"],
                "startBack": ["06:10","07:30","16:20","22:10"],
                "startWeekend": ["05:30"],
                "startWeekendBack": ["06:10","14:05"],
                "goesBack": true,
            },
            {
                "number": "88",
                "name": "Helyi autóbusz-állomás - Videoton",
                "nameBack": "Videoton - Helyi autóbusz-állomás",
                "start": ["05:03","05:10","15:20"],
                "startBack": ["06:25","14:05","14:10","22:10"],
                "startWeekend": ["13:20"],
                "startWeekendBack": [],
                "goesBack": true,
            },
            {
                "number": "89",
                "name": "Helyi autóbusz-állomás - Kaposvári Egyetem",
                "nameBack": "Kaposvári Egyetem - Helyi autóbusz-állomás",
                "start": ["05:15","05:25","07:30","07:40","09:20","13:05","13:40","15:50","21:55"],
                "startBack": ["07:45","09:37","12:50","13:55","14:00","14:15","14:25","15:55","16:10"],
                "startWeekend": [],
                "startWeekendBack": [],
                "goesBack": true,
            },
            {
                "number": "90",
                "name": "Helyi autóbusz-állomás - Rómahegy",
                "nameBack": "Rómahegy - Helyi autóbusz-állomás",
                "start": ["09:35","21:55","22:30"],
                "startBack": ["08:10","14:15","22:10"],
                "startWeekend": [],
                "startWeekendBack": [],
                "goesBack": true,
            },
            {
                "number": "91",
                "name": "Rómahegy - Pázmány P u. - Füredi u. csp.",
                "nameBack": "Füredi u. csp. - Pázmány P u. - Rómahegy",
                "start": ["04:50","05:50","06:50","07:10","07:50","08:50","09:50","10:50","11:50","12:50","14:05","15:00"
                ,"16:00","17:00","18:00","19:00","20:00","21:00"],
                "startBack": ["04:55","06:20","06:40","07:20","07:40","08:20","10:20","11:20","12:20","13:20","13:45"
                ,"14:30","15:30","16:30","17:30","18:30","19:30","20:30"],
                "goesBack": true,
            }

        ];

        // Parse the query string to get the route number and dayGoes
        const urlParams = new URLSearchParams(window.location.search);
        const routeNumber = urlParams.get('routeNumber');
        const routeName = urlParams.get('routeName');
        const dayGoes = urlParams.get('dayGoes');

        // Find the route by its number
        const route = busRoutesIdo.find(r => r.number === routeNumber);

        // Helper function to check if the selected date is a weekend
        function isWeekend(date) {
            const day = date.getDay(); // 0 is Sunday, 6 is Saturday
            return day === 0 || day === 6;
        }

        // Function to render the start times for the route
        function renderStartTimes(route, selectedDate) {
            const routeContainer = document.getElementById('routeContainer');

            // Clear the container
            routeContainer.innerHTML = "";

            // Check if the selected day matches the dayGoes parameter or is a weekend
            if (route) {
                const selectedDay = selectedDate.toLocaleString('en-US', { weekday: 'long' }).toLowerCase();
                if (isWeekend(selectedDate)) {
                    // If it's a weekend, display the `startWeekend` times
                    if (route.startWeekend) {
                        route.startWeekend.forEach((time) => {
                            const startCard = document.createElement('div');
                            startCard.className = 'route-card';
                            startCard.innerHTML = `<div class="start-time-card">${time}</div>`;
                            routeContainer.appendChild(startCard);
                        });
                    }
                } else if (dayGoes && dayGoes.toLowerCase().includes(selectedDay)) {
                    // If it's not a weekend, display the `start` times only if the day matches
                    route.start.forEach((time) => {
                        const startCard = document.createElement('div');
                        startCard.className = 'route-card';
                        startCard.innerHTML = `<div class="start-time-card">${time}</div>`;
                        routeContainer.appendChild(startCard);
                    });
                }
            }
        }

        // Initial render based on the current date in the datePicker
        const datePicker = document.getElementById('datePicker');
        if (datePicker) {
            const initialDate = new Date(datePicker.value);
            renderStartTimes(route, initialDate);

            // Update the displayed times when the datePicker value changes
            datePicker.addEventListener('change', (event) => {
                const selectedDate = new Date(event.target.value);
                renderStartTimes(route, selectedDate);
            });
        }

        // Display route details
        if (route) {
            document.getElementById('routeNumCon').innerHTML = `
                <div class="route-number">${routeNumber}</div>
            `;
            document.getElementById('routeNameCon').innerHTML = `
                <div class="route-name">
                    ${routeName}
                    <span class="switchBtn">
                        <button id="switchBtn" onclick="swicth()">
                            <img src="switch.png" alt="Switch" style="width: 40px; height: 25px; max-width: 40px; max-width: 20px;">
                        </button>
                    </span>
                </div>
                
            `;
        }

        // Global flag to toggle between showing forward/backward times
        let showBackTimes = false;

        function swicth() {
            // Find the route object based on the current routeNumber
            const route = busRoutesIdo.find(r => r.number === routeNumber);
            if (!route) {
                console.error("Route not found!");
                return;
            }

            // If the route can go back, toggle the name and nameBack
            if (route.goesBack) {
                [route.name, route.nameBack] = [route.nameBack, route.name];
            }

            // Toggle between showing forward or backward times
            showBackTimes = !showBackTimes;

            // Get the currently selected date from the datePicker
            const selectedDate = new Date(datePicker.value);
            const selectedDay = selectedDate.toLocaleString('en-US', { weekday: 'long' }).toLowerCase();

            // Update the route name in the DOM based on the current state (name or nameBack)
            const routeNameCon = document.getElementById('routeNameCon');
            routeNameCon.innerHTML = `
                <div class="route-name">${showBackTimes ? route.nameBack : route.name}</div>
                <div class="switchBtn">
                    <button id="switchBtn" onclick="swicth()">
                        <img src="switch.png" alt="Switch" style="width: 40px; height: 25px; max-width: 40px; max-width: 20px;">
                    </button>
                </div>
            `;

            // Get the correct start times based on the selected day and showBackTimes
            const routeContainer = document.getElementById('routeContainer');
            routeContainer.innerHTML = ""; // Clear previous route cards

            // Determine which times to display (weekend or weekday)
            let times = [];
            if (isWeekend(selectedDate)) {
                // Use weekend times (startWeekend or startWeekendBack)
                times = showBackTimes ? route.startWeekendBack : route.startWeekend;
            } else if (dayGoes && dayGoes.toLowerCase().includes(selectedDay)) {
                // Use weekday times (start or startBack)
                times = showBackTimes ? route.startBack : route.start;
            }

            // If no times are available for the selected day, log a warning
            if (times.length === 0) {
                console.warn("No times available for the selected day!");
            } else {
                // Render the times as route cards
                times.forEach(time => {
                    const startCard = document.createElement('div');
                    startCard.className = 'route-card';
                    startCard.innerHTML = `<div class="start-time-card">${time}</div>`;
                    routeContainer.appendChild(startCard);
                });
            }

            // Disable the switch button if goesBack is false
            const switchBtn = document.getElementById('switchBtn');
            if (!route.goesBack) {
                switchBtn.disabled = true;
            } else {
                switchBtn.disabled = false;
            }
        }

        // Helper function to check if the selected date is a weekend
        function isWeekend(date) {
            const day = date.getDay(); // 0 is Sunday, 6 is Saturday
            return day === 0 || day === 6;
        }

        // Mobilbarát menü
        function setupMobileMenu() {
            const header = document.querySelector('header');
            const filterButtons = document.getElementById('filterButtons');
            
            let lastScroll = 0;
            window.addEventListener('scroll', () => {
                const currentScroll = window.pageYOffset;
                
                if (currentScroll > lastScroll && currentScroll > 100) {
                    header.style.transform = 'translateY(-100%)';
                } else {
                    header.style.transform = 'translateY(0)';
                }
                lastScroll = currentScroll;
            });
        }

        setupMobileMenu();

        document.getElementById('backBtn').addEventListener('click', function() {
            window.location.href = 'jaratok.php'; // Redirect to jaratok.php
        });

    </script>
</body>
</html>