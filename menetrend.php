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
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="header.css">
    <style>
        :root {
            --primary-color:linear-gradient(to right, #211717,#b30000);
            --accent-color: #7A7474;
            --text-light: #fbfbfb;
            --secondary-color: #3498db;
            --hover-color: #2980b9;
            --background-light: #f8f9fa;
            --shadow-color: rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
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
            box-shadow: var(--shadow-color);
            display: flex;
            flex-direction: column;
            text-align: center;
            align-items: left;
            gap: 1rem;
            padding: 16px;
        }
        .nav-wrapper {
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 1000;
        }

        .nav-container {
            position: relative;
            width: 100%;
            left: 0; /* Bal oldalon kezdődjön */
            right: 0; /* Jobb oldalon érjen véget */
        }

        .icon {
            background-color: var(--primary-color);
            border: 0;
            cursor: pointer;
            padding: 0;
            position: relative;
            height: 30px;
            width: 30px;
        }

        .icon:hover{
            background-color: var(--primary-color);
        }

        .icon:focus {
            outline: 0;
        }

        .icon .line {
            background-color: #fbfbfb;
            height: 2px;
            width: 20px;
            position: absolute;
            top: 10px;
            left: 5px;
            transition: transform 0.6s linear;
        }

        .icon .line2 {
            top: auto;
            bottom: 10px;
        }

        nav.active .icon .line1 {
            transform: rotate(-765deg) translateY(5.5px);
        }

        nav.active .icon .line2 {
            transform: rotate(765deg) translateY(-5.5px);
        }

        .time {
            text-align: center;
            font-size: 24px;
            color: black;
            background-color: white;
            opacity: 0.4;
            padding: 8px 0;
            border-radius: 20px;
        }

        .search-container {
            width: 100%;
            max-width: 700px;
            min-width: 200px;
            position: relative;
            align-content: center;
            margin: 1rem 0;
        }

        #searchBox {
            width: 80%;
            padding: 16px;
            border: none;
            border-radius: 25px;
            background: white;
            box-shadow: var(--shadow-color);
            font-size: 16px;
            transition: var(--transition);
            align-content: center;
        }

        #searchBox:focus {
            outline: none;
            transform: scale(1.02);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .input-wrapper{
            width: 100%;
        }
        
/*--------------------------------------------------------------------------------------------------------HEADER END-----------------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------------------CSS - OTHER PARTS----------------------------------------------------------------------------------------------*/
        #weekbtn{
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to right, #211717, #b30000);
            color: white; 
            border-radius: 40px;
            padding: 8px 16px; 
            border: none;
            font-size: 16px; 
            width: auto; 
            max-width: 90%; 
            margin-left: 10%;
            margin-right: 10%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                
        }
        #weekendbtn{
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to right, #211717, #b30000);
            color: white; 
            border-radius: 40px;
            padding: 8px 16px; 
            border: none;
            font-size: 16px; 
            width: auto;
            margin-right: 10%;
            margin-left: 10%; 
            max-width: 90%; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                
        }

        .route-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        #odaBtn, #visszaBtn{
            width: 100px;
            height: 40px;
            text-align: center;
            margin-top: 2%;
            margin-right: 14%;
        }

        .route-button {
            padding: 12px 28px;
            background-color: var(--accent-color);
            color: var(--primary-color);
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.2s, background-color 0.2s;
            display: flex;
            float: right;
            margin-right: 10px;
        }

        .route-button:hover {
            background-color: #FFD700;
            transform: translateY(-2px);
        }

        .route-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow-color);
            padding: 1.5rem;
            transition: var(--transition);
            animation: fadeIn 0.5s ease-out;
        }

        .route-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .route-number {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .bus-icon {
            color: var(--accent-color);
            font-size: 1.5rem;
            animation: bounce 2s infinite;
        }

        .route-details {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .next-departure, {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
        }

        .show-stops {
            color: var(--accent-color);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 10px;
            transition: var(--transition);
            text-align: center;
            margin-top: 1rem;
        }

        .show-stops:hover {
            background: rgba(0, 31, 63, 0.1);
        }

        .stops-list {
            display: none;
            margin-top: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
            line-height: 1.6;
            color: #000;
        }

        .live-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        background: darkgreen;
        color: white;
        font-weight: bold;
        padding: 5px 12px;
        margin: 0 auto;
        border-radius: 30px;
        font-size: 15px;
        animation: pulse 2s infinite;
        width: 200px; 
        height: 40px;
    }

/*--------------------------------------------------------------------------------------------------------OTHER PARTS END------------------------------------------------------------------------------------------------*/

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

        @media (max-width: 768px) {
            #weekbtn, #weekendbtn, {
                font-size: 15px; 
                padding: 8px 24px; 
                max-width: 100%; 
            }
        }

        @media (max-width: 480px) {
            .header-content {
                padding: 1rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            .filter-button {
                padding: 0.5rem 0.8rem;
                font-size: 0.8rem;
            }

            .route-container {
                grid-template-columns: 1fr;
                padding: 1rem;
            }

            #weekbtn #weekendbtn {
                font-size: 15px;
                padding: 6px 16px;
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
                            <img src="bus.png" alt="járatok">
                            <span>Járatok</span>
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
    
             <div id="toggle"></div>
                <h1><i class="fas fa-bus"></i> Kaposvár Helyi Járatok</h1>
                <div class="live-indicator">
                    <i class="fas fa-circle"></i>&nbsp Következő indulás
                </div>
                <div style="margin-right: 50%;margin-left: 35%; width: 30%;" id="time" class="time"></div>
                <div style="margin: 0 auto; align-items: center" class="search-container">
                <input type="text" id="searchBox" placeholder="Keress járatszám vagy útvonal alapján..." />
                <div>
                </div>
            </div>    
            </div ><br>
    <div style="display: flex;justify-content: center;"><br>
      <button id="weekbtn"  onclick="week()" >Hétköznap</button>
        <button id="weekendbtn" onclick="weekend()">Hétvége</button>       
    </div> 


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
// Next Bus Route find 
function findNextBusDeparture(routes) {
    console.log("Routes received:", routes); // Diagnosztikai napló

    const currentDate = new Date();
    const currentDay = currentDate.toLocaleDateString('en-US', { weekday: 'long' });
    const currentTimeString = currentDate.toLocaleTimeString('hu-HU', { 
        hour: '2-digit', 
        minute: '2-digit', 
        hour12: false 
    });

    console.log("Current day:", currentDay);
    console.log("Current time:", currentTimeString);

    return routes.map(route => {
        // Ellenőrizzük, hogy a route objektum tartalmazza-e a szükséges mezőket
        if (!route || !route.dayGoes || !route.start) {
            console.warn("Hiányos route objektum:", route);
            return { ...route, nextBus: 'Érvénytelen járat' };
        }

        // Ellenőrizzük, hogy a járat közlekedik-e az adott napon
        if (!route.dayGoes.includes(currentDay)) {
            return { ...route, nextBus: 'Nincs ma indulás' };
        }

        // Használjuk a végső start tömböt (ha több van)
        const startTimes = route.start;

        // Érvényes időpontok szűrése
        const validTimes = startTimes.filter(time => {
            const [hours, minutes] = time.split(':');
            const isValid = hours >= '00' && hours < '24' && minutes >= '00' && minutes < '60';
            if (!isValid) {
                console.warn(`Érvénytelen időpont: ${time} a(z) ${route.number} járaton`);
            }
            return isValid;
        }).sort();

        // Következő indulás meghatározása
        const nextDeparture = validTimes.find(time => time > currentTimeString) 
            || validTimes[0]; // Ha nincs későbbi indulás, vegyük az első időpontot

        console.log(`Útvonal ${route.number}: Következő indulás ${nextDeparture}`);

        return {
            ...route,
            nextBus: nextDeparture
        };
    });
}


function updateRouteDetails(routes, filter = "all", selectedDate = new Date()) {
    const container = document.querySelector('.route-container');
    if (!container) {
        console.error("Nem található a .route-container elem");
        return;
    }

    const dayOfWeek = new Date(selectedDate).toLocaleDateString('en-US', {weekday : 'long'});

    const filteredRoutes = filter === "all"
        ? routes.filter(route => route.dayGoes.includes(dayOfWeek))
        : routes.filter(route => route.dayGoes.includes(dayOfWeek));
    
    container.innerHTML = ''; // Delete Actual Content


    
    filteredRoutes.forEach(route => {
        const routeElement = document.createElement('div');
        routeElement.classList.add('route-card');

        routeElement.innerHTML = `
            <div class="route-number">${route.number}</div>
            <div class="route-name">${route.name}</div>
            <div class="next-departure">
                <i class="far fa-clock"></i>
                &nbsp;Következő indulás: ${route.nextBus} <span style="font-weight: bold;font-size:40px;margin-left:3%">→</span>
            </div>
             <div class="show-stops" onclick="toggleStops(this)">
                            <i class="fas fa-map-marker-alt"></i>
                            Megállók megjelenítése
                        </div>
                        <div class="stops-list">
                            ${route.stops.map((stop, i) => 
                                `<div><i class="fas fa-stop"></i> ${stop}</div>`
                            ).join('')}
                    </div>
        `;

        container.appendChild(routeElement);
    });
}


function updateBusRoutes() {
    // KKzrt. bus routes, number, start,  
    const busRoutes = [
            {
                "number": "12",
                "name": "Helyi autóbusz-állomás - Sopron u. - Laktanya",
                "stops": ["Helyi autóbusz-állomás","Corso","Zárda u.","Honvéd u.","Arany J. tér","Losonc-köz","Brassó u.","Sopron u.","Búzavirág u.","Laktanya"],
                "reverseRoute": ["Laktanya","Búzavirág u.","Nagyszeben u.","Losonc-köz","Arany J. tér","Honvéd u.","Somssich P. u.","Szent Imre u. 13","Széchényi tér","Rákóczi tér","Helyi autóbusz-állomás"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "start": ["05:00","05:30","05:55","06:10","06:30","07:05","07:30","09:50","10:00","10:35","11:00","12:30","13:00"
                ,"13:30","14:20","15:00","15:45","16:00","16:30","16:45","17:00","17:15","17:30","19:00","20:30"],
                "goesBack": true
            },
            {
                "number": "13",
                "name": "Helyi autóbusz-állomás - Kecelhegy - Helyi autóbusz-állomás",
                "stops": ["Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Berzsenyi u. 30.","Füredi utcai csomópont","Városi könyvtár","Vasútköz","Hajnóczy u. csp.","Mátyás k. u., forduló","Kecelhegyalja u.","Kőrösi Cs. S. u.","Kecelhegyi iskola"
                ,"Bethlen G. u.","Magyar Nobel-díjasok tere","Eger u.","Állatkórház","Kölcsey u.","Tompa M. u.","Berzsenyi u. felüljáró","Helyi autóbusz-állomás"],
                "start": ["06:10","07:10","08:10","09:10","12:10","13:25","14:10","15:40","16:10","17:10","19:10"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                "start": ["06:15","06:40","08:00","10:00","13:05","14:15","16:20","21:10"],
                "startWeekend": ["06:20","08:10","09:10","10:10","11:10","13:10","15:10","19:10"],
                "goesBack": false
            },
            {
                "number": "20",
                "name": "Raktár u. - Laktanya - Videoton",
                "stops": ["Raktár u.","Jutai u. 45.","Tóth Á. u.","Jutai u. 24.","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Toldi lakónegyed","Kinizsi ltp.","Búzavirág u."
                ,"Laktanya","Laktanya","Búzavirág u.","Nagyszeben u.","Losonc-köz","Arany J. tér","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Kenyérgyár u. 1.","Videoton"],
                "reverseRoute": ["Videoton","Kenyérgyár u. 3.","Kenyérgyár u. 1.","Mező u. csp.","Kisgát","Pázmány P. u.","ÁNTSZ","Arany J. tér","Losonc-köz","Brassó u.","Sopron u."
                ,"Búzavirág u.","Laktanya","Laktanya","Búzavirág u.","Kinizsi ltp.","Toldi lakónegyed","Füredi utcai csomópont","Városi könyvtár","Vasútköz","Hajnóczy u. csp.","Jutai u. 24."
                ,"Tóth Á. u.","Jutai u. 45.","Raktár u. 2.","Raktár u."],
                "start": ["05:20","07:00","17:40"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "goesBack": true
            },
            {
                "number": "21",
                "name": "Raktár u. - Videoton",
                "stops": ["Raktár u.","Raktár u. 2.","Jutai u. 45.","Tóth Á. u.","Jutai u. 24.","Hajnóczy u. csp.","Vasútköz"
                ,"Városi könyvtár","Füredi utcai csomópont","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Kenyérgyár u. 1.","Videoton"],
                "reverseRoute": ["Videoton","Kenyérgyár u. 3.","Kenyérgyár u. 1.","Mező u. csp.","Kisgát","Pázmány P. u.","ÁNTSZ","Füredi utcai csomópont","Városi könyvtár","Vasútköz","Hajnóczy u. csp.","Jutai u. 24."
                ,"Tóth Á. u.","Jutai u. 45.","Raktár u. 2.","Raktár u."],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
                "start": ["05:00","06:55","07:10","07:20","12:55"],
                "goesBack": true
            },
            {
                "number": "23",
                "name": "Kaposfüred forduló - Füredi csp. - Kaposvári Egyetem",
                "stops": ["Kaposfüred, forduló","Kaposfüredi u. 244.","Kaposfüred, központ","Állomás u.","Kaposfüred, vá.","Kaposfüredi u. 104.","Kaposfüredi u. 12.","Volán-telep","Laktanya","Búzavirág u.","Kinizsi ltp."
                ,"Toldi lakónegyed","Füredi utcai csomópont","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Izzó u.","Guba S. u. 57.","Guba S. u. 81.","Villamossági Gyár","Kaposvári Egyetem"],
                "reverseRoute": ["Kaposvári Egyetem","Villamossági Gyár","Guba S. u. 81.","Guba S. u. 57.","Izzó u.","Mező u. csp.","Kisgát","Pázmány P. u.","ÁNTSZ","Füredi utcai csomópont","Toldi lakónegyed","Kinizsi ltp."
                ,"Búzavirág u.","Laktanya","Volán-telep","Kaposfüredi u. 12.","Kaposfüredi u. 104.","Kaposfüred, központ","Állomás u.","Kaposfüred vá.","Állomás u.","Kaposfüred, központ","Kaposfüredi u. 244.","Kaposfüred, forduló"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "start": ["05:00","06:55","07:10","07:20","12:55"],
                "goesBack": true
            },
            {
                "number": "26",
                "name": "Kaposfüred forduló - Losonc köz - Videoton - METYX",
                "stops": ["Kaposfüred, forduló","Kaposfüredi u. 244","Kaposfüred, központ","Állomás u.","Kaposfüred, vá.","Állomás u.","Kaposfüred, központ","Kaposfüredi u. 104.","Kaposfüredi u. 12.","Volán-telep","Laktanya","Búzavirág u."
                ,"Kinizsi ltp.","Losonc-köz","Arany J. tér","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp.","Kenyérgyár u. 1.","Kenyérgyár u. 3","Videoton","Dombovári u. 4.","METYX"],
                "reverseRoute": ["METYX","Dombóvári u. 4.","Videoton","Kenyérgyár u. 3.","Kenyérgyár u. 1.","Mező u. csp.","Kisgát","Pázmány P. u.","ÁNTSZ","Arany J. tér","Losonc-köz","Kinizsi ltp."
                ,"Búzavirág u.","Laktanya","Volán-telep","Kaposfüredi u. 12.","Kaposfüredi u. 104.","Kaposfüred, központ","Állomás u.","Kaposfüred vá.","Kaposfüred, központ","Kaposfüredi u. 244.","Kaposfüred, forduló"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "start": ["05:05"],
                "goesBack": true
            },
            {
                "number": "27",
                "name": "Laktanya - Füredi u. csp. - KOMÉTA",
                "stops": ["Laktanya","Búzavirág u.","Kinizsi ltp.","Toldi lakónyegyed","Füredi utcai csomópont","ÁNTSZ","Pázmány P. u.","Kisgát","Mező u. csp."
                ,"Hősök temploma","Gyár u.","Pécsi úti iskola","Kométa, forduló"],
                "reverseRoute": ["Kométa, forduló","Pécsi úti iskola","Gyár u.","Hősök temploma","Mező u. csp.","Kisgát","Pázmány P. u.","ÁNTSZ","Füredi utcai csomópont"
                ,"Toldi lakónyegyed","Kinizsi ltp.","Búzavirág u.","Laktanya"],
                "start": ["04:55","07:10","13:00"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "goesBack": true
            },
            {
                "number": "31",
                "name": "Helyi autóbusz-állomás - Egyenesi u. forduló",
                "stops": ["Helyi autóbusz-állomás", "Berzsenyi u. felüljáró","Tompa M. u.","Kölcsey u.","Állatkórház","Eger u.","Kapoli A. u.","Egyenesi u. 42.","Beszédes J. u.","Egyenesi u. forduló"],
                "reverseRoute": ["Egyenesi u. forduló","Beszédes J. u.","Egyenesi u. 42.","Kapoli A. u.","Eger u.","Állatkórház","Kölcsey u.","Tompa M. u.","Berzsenyi u. felüljáró","Helyi autóbusz-állomás"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                "start": ["05:40","06:20","06:40","07:00","07:30","09:00","12:00","13:00","14:00","15:00","16:00","17:00"
                ,"18:00","19:20"],
                "startWeekend": ["05:50","06:40","08:00","09.00","14:00","17:00"],
                "goesBack": true
            },
            {
                "number": "32",
                "name": "Helyi autóbuszállomás - Kecelhegy - Helyi autóbusz-állomás",
                "stops": ["Helyi autóbuszállomás","Berzsenyi u. felüljáró","Tompa M. u.","Kölcsey u.","Állatkórház","Eger u.","Magyar Nobel-díjasok tere","Bethlen G. u.","Kecelhegyi iskola","Kőrösi Cs. S. u."
                ,"Kecelheygalja u.","Mátyás k. u., forduló","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Berzsenyi u. 30.","Berzsenyi u. felüljáró","Heyi autóbusz-állomás"],
                "start": ["05:30","06:30","06:45","07:15","07:40","10:30","13:30","15:30"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                "startWeekend": ["07:15","07:40","14:30","20:40"],
                "goesBack": false
            },
            {
                "number": "33",
                "name": "Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.",
                "stops": ["Helyi autóbuszállomás","Berzsenyi u. felüljáró","Tompa M. u.","Kölcsey u.","Állatkórház","Eger u.","Kapoli A. u.","Egyenesi u. 42.","Beszédes J. u.","Egyenesi u. forduló","Beszédes J. u."
                ,"Egyenesi u. 42.","Kapoli A. u.","Magyar Nobel-díjasok tere","Bethlen G. u.","Kecelhegyi iskola","Kőrösi Cs. S. u.","Kecelhegyalja u.","Mátyás k. u., forduló","Hajnóczy u. csp."
                ,"Vasútköz","Városi könyvtár","Füredi utcai csomópont","Berzsenyi u. 30.","Berzsenyi u. felüljáró","Heyi autóbusz-állomás"],
                "start": ["04:30","05:00","09:30","11:30","12:30","14:35","16:30","17:30","18:20","20:00","20:40","22:30"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                "startWeekend": ["05:00","10:00","11:40","12:30","22:30"],
                "goesBack": false
            },
            {
                "number": "40",
                "name": "Koppány vezér u - 67-es út - Raktár u.",
                "stops": ["Koppány vezér u.","Erdősor u.","Rózsa u.","67-es sz. út","Berzsenyi u. felüljáró","Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Berzsenyi u. 30.","Füredi utcai csomópont","Városi könyvtár"
                ,"Vasútköz","Hajnóczy u. csp.","Jutai u. 24.","Tóth Á. u.","Jutai u. 45.","Raktár u. 2.","Raktár u."],
                "reverseRoute": ["Raktár u.","Raktár u. 2.","Jutai u. 45.","Tóth Á. u.","Jutai u. 24.","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Berzsenyi u. 30","Berzsenyi u. felüljáró","Helyi autóbusz-állomás"
                ,"Berzsenyi u. felüljáró","67-es sz. út","Rózsa u.","Erdősor u.","Koppány vezér u."],
                "start": ["05:55","07:40","14:35","18:15"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "goesBack": true
            },
            {
                "number": "41",
                "name": "Koppány vezér u - Bartók B. u. - Raktár u.",
                "stops": ["Koppány vezér u.","Erdősor u.","Rózsa u.","Szegfű u.","Jókai u.","Bartók B. u.","Berzsenyi u. felüljáró","Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Berzsenyi u. 30.","Füredi utcai csomópont","Városi könyvtár"
                ,"Vasútköz","Hajnóczy u. csp.","Jutai u. 24.","Tóth Á. u.","Jutai u. 45.","Raktár u. 2.","Raktár u."],
                "reverseRoute": ["Raktár u.","Raktár u. 2.","Jutai u. 45.","Tóth Á. u.","Jutai u. 24.","Hajnóczy u. csp.","Vasútköz","Városi könyvtár","Füredi utcai csomópont","Berzsenyi u. 30","Berzsenyi u. felüljáró","Helyi autóbusz-állomás"
                ,"Berzsenyi u. felüljáró","Bartók B. u.","Jókai u.","Szegfű u.","Rózsa u.","Erdősor u.","Koppány vezér u."],
                "start": ["05:05","06:20","06:45","07:10","09:15","10:55","12:50","13:40","15:25","16:30","17:10","19:55","20:55"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                "startWeekend": ["05:05","05:55","06:45","08:05","10:05","10:55","11:45","13:10","14:35","16:30","18:05","09:55"],
                "goesBack": true
            },
            {
                "number": "42",
                "name": "Töröcske forduló - Kórház - Laktanya",
                "stops": ["Töröcske, forduló","Fenyves u. 31.","Fenyves u. 37/A","Szőlőhegy","Kertbarát alsó","Kertbarát felső","Gyertyános","Harangvirág u.","Aranyeső u.","Zichy u.","Táncsics M. u.","Bartók B. u.","Berzsenyi u. felüljáró"
                ,"Helyi autóbusz-állomás","Vasútállomás","Tallián Gy. u. 4.","Kórház","Tallián Gy. u. 56.","Tallián Gy. u. 82.","ÁNTSZ","Füredi utcai csomópont","Toldi lakónegyed","Kinizsi ltp.","Búzavirág u.","Laktanya"],
                "reverseRoute": ["Laktanya","Búzavirág u.","Kinizsi ltp.","Toldi lakónegyed","Füredi utcai csomópont","ÁNTSZ","Rendőrség","Szent Imre u. 29."
                ,"Szent Imre u. 13.","Széchényi tér","Rákóczi tér","Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Bartók B. u.","TáncsicsM. u.","Zichy u.","Aranyeső u.","Harangvirág u.","Gyertyános","Kertbarát felső","Kertbarát alsó","Szőlőhegy"],
                "start": ["04:50","06:10","06:25","06:45","07:15","07:30","08:10","08:50","10:10","11:30","12:50","13:30","14:10"
                ,"15:20","15:40","16:10","16:45","17:40","18:20","19:00","20:50","22:10"],
                "startWeekend": ["04:50","06:10","07:40","09:00","10:20","11:40","13:00","14:20","16:15","17:00","18:20","20:50"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                "goesBack": true
            },
            {
                "number": "43",
                "name": "Helyi autóbusz-állomás - Kórház- Laktanya - Raktár utca - Helyi autóbusz-állomás",
                "stops": ["Helyi autóbusz-állomás", "Vasútállomás","Tallián Gy. u. 4","Kórház","Tallián Gy. u. 56","Tallián Gy. u. 82","Buzsáki u.","Losonc-köz","Brassó u.","Sopron u."
                ,"Búzavirág u.","Laktanya","Raktár u.","Raktár u. 2.","Jutai u. 45.","Tóth Á. u.","Jutai u. 24.","Helyi autóbusz-állomás"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "start": ["08:50","11:20"],
                "goesBack": false
            },
            {
                "number": "44",
                "name": "Helyi autóbusz-állomás - Raktár utca - Laktanya -Arany János tér - Helyi autóbusz-állomás",
                "stops": ["Helyi autóbusz-állomás", "Kapostüskevár","Jutai u. 24.","Tóth Á. u.","Jutai u. 45.","Raktár u. 2.","Raktár u.","Laktanya","Búzavirág u.","Nagyszeben u."
                ,"Losonc-köz","Arany J. tér","Buzsáki u.","Rendőrség","Szent Imre u. 29","Szent Imre u. 13.","Széchényi tér","Rákóczi tér","Helyi autóbusz-állomás"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "start": ["08:30","11:35","13:20"],
                "goesBack": false
            },
            {
                "number": "45",
                "name": "Helyi autóbusz-állomás - 67-es út - Koppány vezér u.",
                "stops": ["Helyi autóbusz-állomás","Berzsenyi u. felüljáró","67-es sz. út","Rózsa u.","Gönczi F. u.","Koppány vezér u."],
                "reverseRoute": ["Koppány vezér u.","Gönczi F. u.","Rózsa u.","67-es sz. út","Berzsenyi u. felüljáró","Helyi autóbusz-állomás"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "start": ["04:35","10:45","12:00","12:40","19:45"],
                "goesBack": true
            },
            {
                "number": "46",
                "name": "Helyi autóbusz-állomás - Töröcske forduló",
                "stops": ["Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Bartók B. u.","Táncsics M. u.","Zichy u.","Aranyeső u.","Harangvirág u."
                ,"Gyertányos","Kertbarát felső","Kertbarát alsó","Szőlőhegy","Fenyves u. 37/A","Fenyves u. 31.","Töröcske, forduló"],
                "reverseRoute": ["Töröcske, forduló","Fenyves u. 31.","Fenyves u. 37/A","Szőlőhegy","Kertbarát alsó","Kertbarát felső"
                ,"Gyertyános","Harangvirág u.","Aranyeső u.","Zichy u.","Táncsics M. u.","Bartók B. u.","Berzsenyi u. felüljáró","Helyi autóbusz-állomás"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "start": ["06:10","06:30","13:15","20:35"],
                "goesBack": true
            },
            {
                "number": "47",
                "name": "Koppány vezér u.- Kórház - Kaposfüred forduló",
                "stops": ["Koppány vezér u.","Gönczi F. u.","Rózsa u.","67-es sz. út","Berzsenyi u. felüljáró","Helyi autóbusz-állomás","Vasútállomás","Tallián Gy. u. 4.","Kórház","Tallián Gy. u. 56."
                ,"Tallián Gy. u. 82.","ÁNTSZ","Füredi utcai csomópont","Toldi lakónegyed","Kinizsi ltp.","Búzavirág u.","Laktanya","Volán-telep","Kaposfüredi u. 12.","Kaposfüredi u. 104.","Kaposfüred, központ","Kaposfüred, forduló"],
                "reverseRoute": ["Kaposfüred, forduló","Kaposfüredi u. 244.","Kaposfüred, központ","Állomás u.","Kaposfüred vá.","Állomás u.","Kaposfüred, központ","Kaposfüredi u. 104.","Kaposfüredi u. 12.","Volán-telep"
                ,"Laktanya","Búzavirág u.","Kinizsi ltp.","Toldi lakónegyed","Füredi utcai csomópont","ÁNTSZ","Rendőrség","Szent Imre u. 29."
                ,"Szent Imre u. 13.","Széchényi tér","Rákóczi tér","Helyi autóbusz-állomás","Berzsenyi u. felüljáró","67-es sz. út","Rózsa u.","Erdősor u.","Koppány vezér u."],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                "start": ["04:45","06:00","06:15","08:30","12:10"],
                "startWeekend": ["04:45"],
                "goesBack": true
            },
        
            {
                "number": "61",
                "name": "Helyi- autóbuszállomás - Béla király u.",
                "stops": ["Helyi autóbusz-állomás","Baross G. u.","Csalogány u.","Vikár B.u.","Béla király u."],
                "reverseRoute": ["Béla király u.","Vikár B.u.","Csalogány u.","Baross G. u.","Helyi autóbusz-állomás"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                "start": ["04:45","06:10","09:10","11:10","13:45","14:25","14:25","15:30","16:20","17:20","17:50","19:55"
                ,"20:50","22:30"],
                "startWeekend": ["07:10","08:10","09:05","10:50","12:10","14:25","19:55"],
                "goesBack": true
            },
            {
                "number": "62",
                "name": "Helyi autóbusz-állomás - Városi fürdő - Béla király u.",
                "stops": ["Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Városi fürdő","Csalogány u.","Vikár B. u.","Béla király u."],
                "reverseRoute": ["Béla király u.","Vikár B.u.","Csalogány u.","Városi fürdő","Berzsenyi u. felüljáró","Helyi autóbusz-állomás"],
                "start": ["06:40","07:05","07:25","10:10","12:10","13:00"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                "startWeekend": ["09:50","13:10"],
                "goesBack": true
            },
            {
                "number": "70",
                "name": "Helyi autóbusz-állomás - Kaposfüred",
                "stops": ["Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Berzsenyi u. 30.","Füredi utcai csomópont","Toldi lakónegyed"
                ,"Kinizsi ltp.","Búzavirág u.","Laktanya","Zöld fűtőmű","Volán-telep","Kaposfüredi u. 12.","Kaposfüredi u. 104.","Kaposfüred, központ","Kaposfüredi u. 244.","Kaposfüred, forduló"],
                "reverseRoute": ["Kaposfüred, forduló","Kaposfüredi u. 244.","Kaposfüred, központ","Állomás u.","Kaposfüred vá.","Állomás u.","Kaposfüred, központ","Kaposfüredi u. 104.","Kaposfüredi u. 12.","Volán-telep"
                ,"Zöld Fűtőmű","Laktanya","Búzavirág u.","Kinizsi ltp.","Toldi lakónegyed","Füredi utcai csomópont","Berzsenyi u. 30.","Berzsenyi u. felüljáró","Helyi autóbusz-állomás"],
                "start": ["04:25","06:45","07:05","09:40","10:20","11:35","13:45","15:25","21:45"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                "startWeekend": ["09:55"],
                "goesBack": true
            },
            {
                "number": "71",
                "name": "Kaposfüred forduló - Kaposszentjakab forduló",
                "stops": ["Kaposfüred, forduló","Kaposfüredi u. 244.","Kaposfüred, központ","Kaposfüredi u. 104.","Kaposfüredi u. 12.","Volán-telep","Zöld fűtőmű","Laktanya"
                ,"Búzavirág u.","Kinizsi ltp.","Toldi lakónegyed","Füredi utcai csomópont","Berzsenyi u. 30.","Berzsenyi u. felüljáró","Helyi autóbusz-állomás","Rákóczi tér","Fő u. 37-39."
                ,"Hársfa u.","Hősök temploma","Gyár u.","Pécsi úti iskola","Nádasdi u.","Móricz Zs. u.","Pécsi u. 227.","Várhegy feljáró","Kaposszentjakab, forduló"],
                "reverseRoute": ["Kaposszentjakab, forduló","Várhegy feljáró","Pécsi u. 277.","Móricz Zs. u.","Nádasdi u.","Pécsi úti iskola","Gyár u.","Hősök temploma"
                ,"Hársfa u.","Fő u. 37-39.","Rákóczi tér","Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Berzsenyi u. 30.","Füredi utcai csomópont"
                ,"Toldi lakónyegyed","Kinizsi ltp.","Búzavirág u.","Laktanya","Zöld Fűtőmű","Volán-telep","Kaposfüredi u. 12.","Kaposfüredi u. 104.","Kaposfüred, központ","Kaposfüredi u. 244.","Kaposfüred, forduló"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                "start": ["05:30","06:05","07:05","07:25","09:05","10:40","11:20","13:15","14:25","16:40","17:10","20:20"
                ,"22:05"],
                "startWeekend": ["04:35","06:00","06:35","07:20","07:50","09:10","10:15","12:50","14:05","17:35","20:30","22.05"],
                "goesBack": true
            },
            {
                "number": "72",
                "name": "Kaposfüred forduló - Hold u. - Kaposszentjakab forduló",
                "stops": ["Kaposfüred, forduló","Kaposfüredi u. 244.","Kaposfüred, központ","Állomás u.","Kaposfüred, vá.","Állomás u.","Kaposfüred, központ","Kaposfüredi u. 104.","Kaposfüredi u. 12.","Volán-telep","Zöld fűtőmű","Laktanya"
                ,"Búzavirág u.","Kinizsi ltp.","Toldi lakónegyed","Füredi utcai csomópont","Berzsenyi u. 30.","Berzsenyi u. felüljáró","Helyi autóbusz-állomás","Vasútállomás","Fő u. 48.","Hársfa u.","Hősök temploma","Gyár u.","Pécsi úti iskola"
                ,"Nádasdi u.","Nap u.","Hold u.","Nádasdi u.","Móricz Zs. u.","Pécsi u. 227.","Várhegy feljáró","Kaposzsentjakab, forduló"],
                "reverseRoute": ["Kaposszentjakab, forduló","Várhegy feljáró","Pécsi u. 277.","Móricz Zs. u.","Nádasdi u.","Nap u.","Hold u.","Nádasdi u.","Pécsi úti iskola","Gyár u.","Hősök temploma"
                ,"Hársfa u.","Fő u. 37-39.","Rákóczi tér","Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Berzsenyi u. 30.","Füredi utcai csomópont"
                ,"Toldi lakónyegyed","Kinizsi ltp.","Búzavirág u.","Laktanya","Zöld Fűtőmű","Volán-telep","Kaposfüredi u. 12.","Kaposfüredi u. 104.","Kaposfüred, központ","Kaposfüredi u. 244.","Kaposfüred, forduló"],
                "start": ["10:00","11:55","14:05","15:05","15:50","19:00"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                "startWeekend": ["11:30","16:35","19:05"],
                "goesBack": true
            },
            {
                "number": "73",
                "name": "Kaposfüred forduló - KOMÉTA - Kaposszentjakab forduló",
                "stops": ["Kaposfüred, forduló","Kaposfüredi u. 244.","Kaposfüred, központ","Kaposfüredi u. 104.","Kaposfüredi u. 12.","Volán-telep","Zöld fűtőmű","Laktanya"
                ,"Búzavirág u.","Kinizsi ltp.","Toldi lakónegyed","Füredi utcai csomópont","Berzsenyi u. 30.","Berzsenyi u. felüljáró","Helyi autóbusz-állomás","Rákóczi tér","Fő u. 37-39."
                ,"Hársfa u.","Hősök temploma","Gyár u.","Pécsi úti iskola","Kométa, forduló","Nádasdi u.","Móricz Zs. u.","Pécsi u. 227.","Várhegy feljáró","Kaposszentjakab, forduló"],
                "reverseRoute": ["Kaposszentjakab, forduló","Várhegy feljáró","Pécsi u. 277.","Móricz Zs. u.","Nádasdi u.","Kométa, forduló","Pécsi úti iskola","Gyár u.","Hősök temploma"
                ,"Hársfa u.","Fő u. 37-39.","Rákóczi tér","Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Berzsenyi u. 30.","Füredi utcai csomópont"
                ,"Toldi lakónyegyed","Kinizsi ltp.","Búzavirág u.","Laktanya","Zöld Fűtőmű","Volán-telep","Kaposfüredi u. 12.","Kaposfüredi u. 104.","Kaposfüred, központ","Kaposfüredi u. 244.","Kaposfüred, forduló"],
                "start": ["04:45","06:40","12:45","21:00"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "goesBack": true
            },
           // {
            //   "number": "74",
            //  "name": "Hold utca - Helyi autóbusz-állomás",
            //   "stops": ["Hold u.","Nap u.","Nádasdi u.","Pécsi úti iskola","Gyár u.","Hősök temploma","Hásrfa u.","Fő u. 37-39.","Rákóczi tér","Helyi autóbusz-állomás"],
            //    "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            //    "start": [""],
            //    "goesBack": false
            //},
            {
                "number": "75",
                "name": "Helyi autóbusz-állomás - Kaposszentjakab",
                "stops": ["Helyi autóbusz-állomás","Rákóczi tér","Fő u. 37-39.","Hársfa u.","Hősök temploma","Gyár u.","Pécsi úti iskola","Nádasdi u.","Móricz Zs. u.","Pécsi u. 227.","Várhegy feljáró","Kaposszentjakab, forduló"],
                "reverseRoute": ["Kaposszentjakab, forduló","Várhegy feljáró","Pécsi u. 277.","Móricz Zs. u.","Nádasdi u.","Pécsi úti iskola","Gyár u.","Hősök temploma"
                ,"Hársfa u.","Fő u. 37-39.","Rákóczi tér","Helyi autóbusz-állomás"],
                "start": ["04:35","06:55","08:30","13:30","15:50","18:10","20:15"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                "startWeekend": ["05:45"],
                "goesBack": true
            },
            {
                "number": "81",
                "name": "Helyi autóbusz-állomás - Hősök temploma - Toponár forduló",
                "stops": ["Helyi autóbusz-állomás","Vasútálomás","Hársfa u.","Hősök temploma","Mező u. csp.","Izzó u.","Guba S. u. 57","Guba S. u. 81.","Villamossági Gyár","Kaposvári Egyetem"
                ,"Toponár, posta","Toponár, Orci elágazás","Toponári u. 182.","Toponári u. 238.","Toponár, forduló"],
                "reverseRoute": ["Toponár, forduló","Toponári u. 238.","Toponári u. 182.","Toponár, Orci elágazás","Toponár, posta","Kaposvári Egyetem","Villamossági Gyár","Guba S. u. 81."
                ,"Guba S. u. 57.","Izzó u.","Mező u. csp.","Hősök temploma","Hársfa u.","Fő u. 37-39.","Rákóczi tér","Helyi autóbusz-állomás"],
                "start": ["06:25","07:10","10:35","11:35","13:10","15:05","17:00"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "goesBack": true
            },
            {
                "number": "82",
                "name": "Helyi autóbusz-állomás - Kórház - Toponár Szabó P. u.",
                "stops": ["Helyi autóbusz-állomás","Vasútálomás","Tallián Gy. u. 4","Kórház","Tallián Gy. u. 56.","Tallián Gy. u. 82.","Pázmány P. u.","Kisgát","Mező u. csp."
                ,"Izzó u.","Guba S. u. 57","Guba S. u. 81.","Villamossági Gyár","Kaposvári Egyetem","Toponár, posta","Toponár, Orci elágazás","Toponár, Orci út","Toponár, Szabó P. u."],
                "reverseRoute": ["Toponár, Szabó P. u.","Toponár, Erdei F. u.","Toponár, Orci út","Toponár, Orci elágazás","Toponár, posta","Kaposvári Egyetem","Villamossági Gyár","Guba S. u. 81."
                ,"Guba S. u. 57.","Izzó u.","Mező u. csp.","Kisgát","Pázmány P. u.","Rendőrség","Szent Imre u. 29.","Szent Imre u. 13.","Széchényi tér","Rákóczi tér","Helyi autóbusz-állomás"],
                "start": ["05:35","06:05","06:35","07:25","08:10","09:35","10:05","11:05","12:50","13:35","14:05","14:40"
                ,"15:30","16:45","17:45"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "goesBack": true
            },
            {
                "number": "83",
                "name": "Helyi autóbusz-állomás - Szabó P. u. - Toponár forduló",
                "stops": ["Helyi autóbusz-állomás","Vasútálomás","Fő u. 48.","Hársfa u.","Hősök temploma","Mező u. csp.","Izzó u.","Guba S. u. 57","Guba S. u. 81.","Villamossági Gyár","Kaposvári Egyetem"
                ,"Toponár, posta","Toponár, Orci elágazás","Toponár, Orci út","Toponár, Szabó P. u.","Toponár, Erdei F. u.","Toponár, Orci út","Toponár, Orci elágazás","Toponári u. 182.","Toponári u. 238.","Toponár, forduló"],
                "reverseRoute": ["Toponár, forduló","Toponári u. 238.","Toponári u. 182.","Toponár, Orci elágazás","Toponár, posta","Kaposvári Egyetem","Villamossági Gyár","Guba S. u. 81."
                ,"Guba S. u. 57.","Izzó u.","Mező u. csp.","Hősök temploma","Hársfa u.","Fő u. 37-39.","Rákóczi tér","Helyi autóbusz-állomás"],
                "start": ["04:25","05:05","09:05","12:05","16:00","17:20","18:25","19:05","19:55","20:35","21:20","22:30"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                "startWeekend": ["04:40","05:35","06:35","07:25","08:45","10:35","11:35","12:25","13:35","14:35","15:55"],
                "goesBack": true
            },
            {
                "number": "84",
                "name": "Helyi autóbusz-állomás - Toponár, forduló - Répáspuszta",
                "stops": ["Helyi autóbusz-állomás","Vasútálomás","Fő u. 48.","Hársfa u.","Hősök temploma","Mező u. csp.","Izzó u.","Guba S. u. 57","Guba S. u. 81.","Villamossági Gyár","Kaposvári Egyetem"
                ,"Toponár, posta","Toponár, Orci elágazás","Toponári u. 182.","Toponári u. 238.","Toponár, forduló","Répáspuszta","Répáspuszta, forduló"],
                "reverseRoute": ["Répáspuszta, forduló","Toponár, forduló","Toponári u. 238.","Toponári u. 182.","Toponár, Orci elágazás","Toponár, posta","Kaposvári Egyetem","Villamossági Gyár","Guba S. u. 81."
                ,"Guba S. u. 57.","Izzó u.","Mező u. csp.","Hősök temploma","Hársfa u.","Fő u. 37-39.","Rákóczi tér","Helyi autóbusz-állomás"],
                "start": ["06:40","14:20","16:25"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "goesBack": true
            },
            {
                "number": "85",
                "name": "Helyi autóbusz-állomás - Kisgát- Helyi autóbusz-állomás",
                "stops": ["Helyi autóbusz-állomás","Vasútálomás","Rákóczi tér","Fő u. 48.","Hársfa u.","Hősök temploma","Mező u. csp.","Kisgát","Pázmány P. u."
                ,"Rendőrség","Szent Imre u. 29","Szent Imre u. 13.","Széchényi tér","Helyi autóbusz-állomás"],
                "start": ["07:00","07:20"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "goesBack": false
            },
            {
                "number": "86",
                "name": "Helyi autóbusz-állomás - METYX - Szennyvíztelep",
                "stops": ["Helyi autóbusz-állomás","Vasútálomás","Fő u. 48.","Hársfa u.","Hősök temploma","Mező u. csp.","Kenyérgyár u. 1.","Videoton","Dombóvári u. 4.","METYX","Cabero","Sennyvíztelep"],
                "reverseRoute": ["Szennyvíztelep","Cabero","METYX","Dombóvári u. 4.","Videoton","Kenyérgyár u. 3.","Kenyérgyár u. 1.","Mező u. csp.","Hősök temploma","Hársfa u.","Fő u. 37-39.","Rákóczi tér","Helyi autóbusz-állomás"],
                "start": ["05:20","05:30","06:50","13:55"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "goesBack": true
            },
            {
                "number": "87",
                "name": "Helyi autóbusz állomás - Videoton - METYX",
                "stops": ["Helyi autóbusz-állomás","Vasútálomás","Fő u. 48.","Hársfa u.","Hősök temploma","Mező u. csp.","Kenyérgyár u. 1.","Videoton","Dombóvári u. 4.","METYX"],
                "reverseRoute": ["METYX","Dombóvári u. 4.","Videoton","Kenyérgyár u. 3.","Kenyérgyár u. 1.","Mező u. csp.","Hősök temploma","Hársfa u.","Fő u. 37-39.","Rákóczi tér","Helyi autóbusz-állomás"],
                "start": ["07:15","13:20","13:27","21:20","21:30"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                "startWeekend": ["05:30"],
                "goesBack": true
            },
            {
                "number": "88",
                "name": "Helyi autóbusz-állomás - Videoton",
                "stops": ["Helyi autóbusz-állomás","Vasútálomás","Fő u. 48.","Hársfa u.","Hősök temploma","Mező u. csp.","Kenyérgyár u. 1.","Videoton"],
                "reverseRoute": ["Videoton","Kenyérgyár u. 3.","Kenyérgyár u. 1.","Mező u. csp.","Hősök temploma","Hársfa u.","Fő u. 37-39.","Rákóczi tér","Helyi autóbusz-állomás"],
                "start": ["05:03","05:10","15:20"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
                "startWeekend": ["13:20"],
                "goesBack": true
            },
            {
                "number": "89",
                "name": "Helyi autóbusz-állomás - Kaposvári Egyetem",
                "stops": ["Helyi autóbusz-állomás","Vasútálomás","Fő u. 48.","Hársfa u.","Hősök temploma","Mező u. csp.","Izzó u.","Guba S. u. 57","Guba S. u. 81.","Villamossági Gyár","Kaposvári Egyetem"],
                "reverseRoute": ["Kaposvári Egyetem","Villamossági Gyár","Guba S. u. 81.","Guba S. u. 57.","Izzó u.","Mező u. csp.","Hősök temploma","Hársfa u.","Fő u. 37-39.","Rákóczi tér","Helyi autóbusz-állomás"],
                "start": ["05:15","05:25","07:30","07:40","09:20","13:05","13:40","15:50","21:55"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "goesBack": true
            },
            {
                "number": "90",
                "name": "Helyi autóbusz-állomás - Rómahegy",
                "stops": ["Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Jókai liget","Szigetvári u. 6.","Szigetvári u. 62.","Ballakúti u.","Szigetvári u. 139.","Nyár u.","Rómahegy"],
                "reverseRoute": ["Rómahegy","Nyár u.","Szigetvári u. 139.","Ballakúti u.","Szigetvári u. 62.","Szigetvári u. 6.","Jókai liget","Berzsenyi u. felüljáró","Helyi autóbusz-állomás"],
                "start": ["09:35","21:55","22:30"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "goesBack": true
            },
            {
                "number": "91",
                "name": "Rómahegy - Pázmány P u. - Füredi u. csp.",
                "stops": ["Rómahegy","Nyár u.","Szigetvári u. 139.","Ballakúti u.","Szigetvári u. 62.","Szigetvári u. 6.","Jókai liget","Berzsenyi u. felüljáró","Helyi autóbusz-állomás","Vasútálomás","Fő u. 48.","Hársfa u."
                ,"Virág u.","Pázmány P. u. 1.","Vöröstelek u.","Hegyi u.","Buzsáki u.","Arany J. tér","Füredi utcai csomópont"],
                "reverseRoute": ["Füredi utcai csomópont","Arany J. u.","Arany J. tér","Buzsáki u.","Hegyi u.","Vöröstelek u.","Pázmány P. u. 1.","Virág u.","Hársfa u."
                ,"Fő u. 37-39.","Rákóczi tér","Helyi autóbusz-állomás","Berzsenyi u. felüljáró","Jókai liget","Szigetvári u. 6.","Szigetvári u. 62.","Ballakúti u.","Szigetvári u. 139.","Nyár u.","Rómahegy"],
                "dayGoes": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "start": ["04:50","05:50","06:50","07:10","07:50","08:50","09:50","10:50","11:50","12:50","14:05","15:00"
                ,"16:00","17:00","18:00","19:00","20:00","21:00"],
                "goesBack": true
            }
    ];

    console.log("Útvonalak betöltése:", busRoutes);

      // Function to get the next bus departure based on current time
      function getNextBusDeparture(startTimes) {
            const currentTime = new Date();
            const currentTimeStr = currentTime.toTimeString().slice(0, 5); // Format as HH:MM
            const upcomingTimes = startTimes.filter(time => time > currentTimeStr);
            return upcomingTimes.length > 0 ? upcomingTimes[0] : "Nincs több indulás ma"; // Returns "No more departures today" if no upcoming times
        }

        // Function to check if a route runs on weekdays
        function isWeekdayRoute(route) {
            const weekdays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
            return route.dayGoes.some(day => weekdays.includes(day));
        }

        // Function to check if a route runs on weekends
        function isWeekendRoute(route) {
            const weekends = ["Saturday", "Sunday"];
            return route.dayGoes.some(day => weekends.includes(day));
        }

        // Main function to render routes
        function renderRoutes(filteredRoutes) {
            const container = document.getElementById('routeContainer');
            container.innerHTML = ''; // Clear existing routes

            filteredRoutes.forEach(route => {
                const routeElement = document.createElement('div');
                routeElement.classList.add('route-card');

                routeElement.innerHTML = `
                    <div class="route-number">${route.number}</div>
                    <div class="route-name">${route.name}</div>
                    <div class="next-departure">
                        <i class="far fa-clock"></i>
                        &nbsp;Következő indulás: ${getNextBusDeparture(route.start)} 
                        <span style="font-weight: bold; font-size: 40px; margin-left: 3%;">→</span>
                    </div>
                    <div class="show-stops" onclick="toggleStops(this)">
                        <i class="fas fa-map-marker-alt"></i>
                        Megállók megjelenítése
                    </div>
                    <div class="stops-list">
                        ${route.stops.map(stop => 
                            `<div><i class="fas fa-stop"></i> ${stop}</div>`
                        ).join('')}
                    </div>
                `;

                container.appendChild(routeElement);
            });
        }

        // Toggle stops visibility function
        function toggleStops(element) {
            const stopsList = element.nextElementSibling;
            stopsList.classList.toggle('active');
        }

        // Filter routes for all days
     

        // Filter routes for weekdays
        function week() {
            const weekdayRoutes = busRoutes.filter(isWeekdayRoute);
            renderRoutes(weekdayRoutes);
        }

        // Filter routes for weekends
        function weekend() {
            const weekendRoutes = busRoutes.filter(isWeekendRoute);
            renderRoutes(weekendRoutes);
        }

       

        
        document.getElementById('weekbtn').addEventListener('click', week);
        document.getElementById('weekendbtn').addEventListener('click', weekend);
    
    // Útvonalak frissítése 
    const updatedRoutes = findNextBusDeparture(busRoutes);
    
    // Útvonal részletek frissítése a DOM-ban
    updateRouteDetails(updatedRoutes);
}

// Frissítés oldal betöltéskor
document.addEventListener('DOMContentLoaded', () => {
    console.log("DOM betöltve, útvonalak frissítése");
    updateBusRoutes();
});

// Opcionális: útvonalak rendszeres frissítése (pl. percenként)
setInterval(updateBusRoutes, 60000);
        // next busroute 

      

        // Time 1 sec update//
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('hu-HU');
            document.getElementById('time').textContent = timeString;
        }

        setInterval(updateTime, 1000);
        updateTime();


        //dropdown togglestop show (visible)//

        function toggleStops(element) {
            const stopsList = element.nextElementSibling;
            const isVisible = stopsList.style.display === "block";
            
            stopsList.style.display = isVisible ? "none" : "block";
            element.innerHTML = isVisible
                ? '<i class="fas fa-map-marker-alt"></i> Megállók megjelenítése'
                : '<i class="fas fa-map-marker-alt"></i> Megállók elrejtése';
        }

        

            

        // Search function
        const searchBox = document.getElementById('searchBox');
        searchBox.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const routeCards = document.querySelectorAll('.route-card');
            
            routeCards.forEach(card => {
                const routeText = card.textContent.toLowerCase();
                if (routeText.includes(searchTerm)) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeIn 0.5s ease-out';
                } else {
                    card.style.display = 'none';
                }
            });
        });


        // Responsive mobile menu

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



       //  dark mode button//

       
        
        function addThemeToggle() {
            const themeBtn = document.createElement('button');
            themeBtn.className = 'filter-button';
            themeBtn.innerHTML = '<i class="fas fa-moon"></i>';
            themeBtn.style.position = 'fixed';
            themeBtn.style.bottom = '20px';
            themeBtn.style.right = '20px';
            themeBtn.style.zIndex = '1000';
            
            let isDark = false;
            themeBtn.addEventListener('click', () => {
                isDark = !isDark;
                document.body.style.background = isDark ? '#1a1a1a' : 'linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%)';
                document.body.style.color = isDark ? '#fff' : '#333';
                themeBtn.innerHTML = isDark ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
                
                const cards = document.querySelectorAll('.route-card');
                cards.forEach(card => {
                    card.style.background = isDark ? '#2d2d2d' : 'white';
                    card.style.color = isDark ? '#fff' : '#333';
                });
            });
            
            document.body.appendChild(themeBtn);
        }

        addThemeToggle();
    </script>
    
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


    </script>
<script>


function week() {
    // Your logic to show only weekday routes
    console.log("Displaying weekday routes.");
}

function weekend() {
    // Your logic to show only weekend routes
    console.log("Displaying weekend routes.");
}


</script>
</body>
</html>
