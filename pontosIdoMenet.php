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
            display: inline-block;
            color: #636363;
            font-size: 1.5rem;
            font-weight: bold;
            margin-left: 16%;
        }

        .switchBtn{
            display: inline-block;
            float: right;
            background: #fbfbfb;
            margin-right: 19%;
        }

        .route-time{
            display: inline-block;
            float: right;
            margin-right: 19%;
        }

        .route-date{
            display: inline-block;
            float: center;
        }

        #datePicker{
            margin-left: 45%;
            font-size: 1rem;
            background-color: #fbfbfb;
            color: #211717;
            border: 1px solid #fff;
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
        }
/*--------------------------------------------------------------------------------------------------------@MEDIA END-----------------------------------------------------------------------------------------------------*/
        
    </style>
</head>
<body>
    <div class="header">
            <button class="backBtn" id=backBtn><i class="fa-solid fa-chevron-left"></i></button>
            <h1><i class="fas fa-bus"></i> Kaposvár Helyi Járatok</h1> 
            
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

        const busIdo = [
            {
                "start": "5:00",
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "stopsTime": ["05:00","05:01","05:04","05:06","05:08","05:10","05:11","05:12","05:13","05:15"],
            },
        ];

        // Parse the query string to get the route number and dayGoes
        const urlParams = new URLSearchParams(window.location.search);
        const routeNumber = urlParams.get('routeNumber');
        const routeName = urlParams.get('routeName');
        const routeTime = urlParams.get('routeTime');

        // Find the route by its number
        const route = busIdo.find(r => r.number === routeNumber);

        // Display route details
        if (route) {
            document.getElementById('routeNumCon').innerHTML = `
                <div class="route-number">${routeNumber}</div>
                <div class="route-date"><input type="date" id="datePicker" disabled /></div>
                <div class="route-time">${routeTime}</div>
            `;
            document.getElementById('routeNameCon').innerHTML = `
                <div class="route-name">${routeName}</div>
                <div class="switchBtn">
                    <button id="switchBtn" disabled">
                        <img src="switch.png" alt="Switch" style="width: 40px; height: 25px; max-width: 40px; max-width: 20px;">
                    </button>
                </div>
            `;
        }

        function displayRoutes(filter = "all") {
            const routeContainer = document.getElementById('routeContainer');
            routeContainer.innerHTML = "";

            // Create route cards
            busRoutes.forEach((route, index) => {
                const routeCard = document.createElement('div');
                routeCard.className = 'route-card';
                routeCard.style.animationDelay = `${index * 0.1}s`;

                routeCard.innerHTML = `
                    <div class="route-megallo">${route.megallo}</div>
                    <div class="time-card">${time}</div>
                `;

                    routeContainer.appendChild(routeCard);
                });
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