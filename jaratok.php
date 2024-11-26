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
    <script src="busRoutes.js"></script>

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
            margin-right: 5%;
        }

        .nav-wrapper {
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 1000;
        }

        .nav-container {
            position: relative;
        }

        .menu-btn {
            background: none;
            border: none;
            border-radius: 8px;
            padding: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px var(--shadow-color);
        }

        .menu-btn:hover {
            background: none;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px var(--shadow-color);
        }

        .hamburger {
            position: relative;
            width: 30px;
            height: 20px;
        }

        .hamburger span {
            position: absolute;
            width: 100%;
            height: 3px;
            background: var(--text-light);
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .hamburger span:nth-child(1) { top: 0; }
        .hamburger span:nth-child(2) { top: 50%; transform: translateY(-50%); }
        .hamburger span:nth-child(3) { bottom: 0; }

        .menu-btn.active .hamburger span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .menu-btn.active .hamburger span:nth-child(2) {
            opacity: 0;
        }

        .menu-btn.active .hamburger span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 1rem);
            left: 0;
            background: var(--text-light);
            border-radius: 12px;
            min-width: 280px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-20px);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            box-shadow: 0 10px 30px var(--shadow-color);
            overflow: hidden;
        }

        .dropdown-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .menu-items {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu-items li {
            transform: translateX(-100%);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .dropdown-menu.active .menu-items li {
            transform: translateX(0);
            opacity: 1;
        }

        .menu-items li:nth-child(1) { transition-delay: 0.1s; }
        .menu-items li:nth-child(2) { transition-delay: 0.2s; }
        .menu-items li:nth-child(3) { transition-delay: 0.3s; }
        .menu-items li:nth-child(4) { transition-delay: 0.4s; }
        .menu-items li:nth-child(5) { transition-delay: 0.5s; }

        .menu-items a {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: black;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .menu-items a:hover {
            background: linear-gradient(to right, #211717,#b30000);
            color: white;
            padding-left: 2rem;
        }

        .menu-items a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: darkred;
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .menu-items a:hover::before {
            transform: scaleY(1);
        }

        .menu-items a img {
            width: 24px;
            height: 24px;
            margin-right: 12px;
            transition: transform 0.3s ease;
        }

        .menu-items a:hover img {
            transform: scale(1.2) rotate(5deg);
        }

        .menu-items a span {
            font-size: 17px;
        }


        .menu-items a.active {
            background: white;
            color: black;
            font-weight: 600;
        }

        .menu-items a.active::before {
            transform: scaleY(1);
        }

        @keyframes ripple {
            0% {
                transform: scale(0);
                opacity: 1;
            }
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        .menu-items a::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: gray;
            left: 0;
            top: 0;
            transform: scale(0);
            opacity: 0;
            pointer-events: none;
            transition: all 0.5s ease;
        }

        .menu-items a:active::after {
            animation: ripple 0.6s ease-out;
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
            background: var(--text-light);
            width: 1200px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            padding: 1.5rem;
            transition: var(--transition);
            animation: fadeIn 0.5s ease-out;
            margin: 0 auto;
        }

        .route-card:hover{
            color: 000;
            background: #E9E8E8;
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .route-number {
            background: #b30000;
            display: inline-block;
            width: 3%;
            height: 60%;
            font-size: 1.5rem;
            font-weight: bold;
            border-radius: 5px;
            padding-left: 20px;
            padding-right: 15px;
            color: var(--text-light);
        }

        .route-name{
            display: inline-block;
            color: #636363;
            font-size: 1.5rem;
            font-weight: bold;
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

            #datePicker{
                margin-left: 28%;
            }

            .route-number{
                display: grid;
                padding-right: 40px;
            }

            .route-name{
                display: grid;
            }

            .route-card{
                width: 340px;
            }

            .nav-wrapper{
                left: 0.01rem;
            }
        }
/*--------------------------------------------------------------------------------------------------------@MEDIA END-----------------------------------------------------------------------------------------------------*/
        
    </style>
</head>
<body>
    <div class="header">
        <div class="nav-wrapper">
            <div class="nav-container">
                <button class="menu-btn" id="menuBtn">
                    <div class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
                <nav class="dropdown-menu" id="dropdownMenu">
                    <ul class="menu-items">
                        <li>
                            <a href="index.php" class="active">
                                <img src="placeholder.png" alt="Főoldal">
                                <span>Főoldal</span>
                            </a>
                        </li>
                        <li>
                            <a href="buy.php">
                                <img src="tickets.png" alt="Jegyvásárlás">
                                <span>Jegyvásárlás</span>
                            </a>
                        </li>
                        <li>
                            <a href="menetrend.php">
                                <img src="calendar.png" alt="Menetrend">
                                <span>Menetrend</span>
                            </a>
                        </li>
                        <li>
                            <a href="jaratok.php">
                            <img src="bus.png" alt="Járatok">
                                <span>&nbsp; Járatok</span>
                            </a>
                        </li>
                        <li>
                            <a href="info.php">
                                <img src="information-button.png" alt="Információ">
                                <span>Információ</span>
                            </a>
                        </li>
                        <li>
                            <a href="logout.php">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Kijelentkezés</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
                <h1><i class="fas fa-bus"></i> Kaposvár Helyi Járatok</h1>
                <input type="date" id="datePicker" require /> 
        </div>

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
        document.getElementById('menuBtn').addEventListener('click', function() {
            this.classList.toggle('active');
            document.getElementById('dropdownMenu').classList.toggle('active');
        });

        // Kívülre kattintás esetén bezárjuk a menüt
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('dropdownMenu');
            const menuBtn = document.getElementById('menuBtn');
            
            if (!menu.contains(event.target) && !menuBtn.contains(event.target)) {
                menu.classList.remove('active');
                menuBtn.classList.remove('active');
            }
        });

        // Aktív oldal jelölése
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const menuItems = document.querySelectorAll('.menu-items a');
            
            menuItems.forEach(item => {
                if (item.getAttribute('href') === currentPage) {
                    item.classList.add('active');
                }
            });
        });

        const today = new Date();
        document.getElementById("datePicker").value = today.toISOString().split("T")[0];
        document.getElementById("datePicker").min = today.toISOString().split("T")[0];

        /*const busRoutes = [
            {
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "13",
                "name": "Helyi autóbusz-állomás - Kecelhegy - Helyi autóbusz-állomás",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            },
            {
                "number": "20",
                "name": "Raktár u. - Laktanya - Videoton",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "21",
                "name": "Raktár u. - Videoton",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
            },
            {
                "number": "23",
                "name": "Kaposfüred forduló - Füredi csp. - Kaposvári Egyetem",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "26",
                "name": "Kaposfüred forduló - Losonc köz - Videoton - METYX",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "27",
                "name": "Laktanya - Füredi u. csp. - KOMÉTA",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "31",
                "name": "Helyi autóbusz-állomás - Egyenesi u. forduló",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            },
            {
                "number": "32",
                "name": "Helyi autóbuszállomás - Kecelhegy - Helyi autóbusz-állomás",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            },
            {
                "number": "33",
                "name": "Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            },
            {
                "number": "40",
                "name": "Koppány vezér u - 67-es út - Raktár u.",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "41",
                "name": "Koppány vezér u - Bartók B. u. - Raktár u.",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            },
            {
                "number": "42",
                "name": "Töröcske forduló - Kórház - Laktanya",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            },
            {
                "number": "43",
                "name": "Helyi autóbusz-állomás - Kórház- Laktanya - Raktár utca - Helyi autóbusz-állomás",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "44",
                "name": "Helyi autóbusz-állomás - Raktár utca - Laktanya -Arany János tér - Helyi autóbusz-állomás",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "45",
                "name": "Helyi autóbusz-állomás - 67-es út - Koppány vezér u.",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "46",
                "name": "Helyi autóbusz-állomás - Töröcske forduló",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "47",
                "name": "Koppány vezér u.- Kórház - Kaposfüred forduló",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            },
            {
                "number": "51",
                "name": "Laktanya - Sopron u. - Rómahegy",
                "dayGoes": ["Saturday","Sunday"],
            },
            {
                "number": "61",
                "name": "Helyi- autóbuszállomás - Béla király u.",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            },
            {
                "number": "62",
                "name": "Helyi autóbusz-állomás - Városi fürdő - Béla király u.",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            },
            {
                "number": "70",
                "name": "Helyi autóbusz-állomás - Kaposfüred",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            },
            {
                "number": "71",
                "name": "Kaposfüred forduló - Kaposszentjakab forduló",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            },
            {
                "number": "72",
                "name": "Kaposfüred forduló - Hold u. - Kaposszentjakab forduló",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            },
            {
                "number": "73",
                "name": "Kaposfüred forduló - KOMÉTA - Kaposszentjakab forduló",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "74",
                "name": "Hold utca - Helyi autóbusz-állomás",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "75",
                "name": "Helyi autóbusz-állomás - Kaposszentjakab",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            },
            {
                "number": "81",
                "name": "Helyi autóbusz-állomás - Hősök temploma - Toponár forduló",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "82",
                "name": "Helyi autóbusz-állomás - Kórház - Toponár Szabó P. u.",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "83",
                "name": "Helyi autóbusz-állomás - Szabó P. u. - Toponár forduló",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            },
            {
                "number": "84",
                "name": "Helyi autóbusz-állomás - Toponár, forduló - Répáspuszta",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "85",
                "name": "Helyi autóbusz-állomás - Kisgát- Helyi autóbusz-állomás",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "86",
                "name": "Helyi autóbusz-állomás - METYX - Szennyvíztelep",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "87",
                "name": "Helyi autóbusz állomás - Videoton - METYX",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            },
            {
                "number": "88",
                "name": "Helyi autóbusz-állomás - Videoton",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            },
            {
                "number": "89",
                "name": "Helyi autóbusz-állomás - Kaposvári Egyetem",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "90",
                "name": "Helyi autóbusz-állomás - Rómahegy",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            },
            {
                "number": "91",
                "name": "Rómahegy - Pázmány P u. - Füredi u. csp.",
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            }

        ];*/


        function displayRoutes(filter = "all", selectedDate = new Date()) {
            const routeContainer = document.getElementById('routeContainer');
            routeContainer.innerHTML = "";

            // Get the day of the week for the selected date
            const dayOfWeek = new Date(selectedDate).toLocaleDateString('en-US', { weekday: 'long' });

            // Filter routes based on the selected day
            const filteredRoutes = filter === "all" 
                ? busRoutes.filter(route => route.dayGoes.includes(dayOfWeek))
                : busRoutes.filter(route => route.dayGoes.includes(dayOfWeek));

            // Create route cards
            filteredRoutes.forEach((route, index) => {
                const routeCard = document.createElement('div');
                routeCard.className = 'route-card';
                routeCard.style.animationDelay = `${index * 0.1}s`;

                // Add route details and click event for navigation
                routeCard.innerHTML = `
                    <div id="route-details" class="route-number">
                        ${route.number}
                    </div>&nbsp;&nbsp;
                    <div class="route-name">
                        ${route.name}
                    </div>
                `;
                routeCard.addEventListener('click', () => {
                    // Redirect to indulasIdo.php with route details in the URL
                    const url = new URL('indulasIdo.php', window.location.origin);
                    url.searchParams.append('routeNumber', route.number);
                    url.searchParams.append('routeName', route.name);
                    url.searchParams.append('dayGoes', route.dayGoes);
                    window.location.href = url.toString();
                });

                routeContainer.appendChild(routeCard);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Initial display with today's date
            displayRoutes();

            // Handle changes in the date picker
            const datePicker = document.getElementById('datePicker');
            datePicker.addEventListener('change', (event) => {
                const selectedDate = event.target.value; // Get the selected date
                if (selectedDate) {
                    displayRoutes("all", new Date(selectedDate));
                }
            });
        });



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

        
    </script>
</body>
</html>