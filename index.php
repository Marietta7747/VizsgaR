<?php
session_start();
require_once 'config.php';

// Debug információ
error_log("Session tartalma: " . print_r($_SESSION, true));

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['user_id'])) {
    error_log("Nincs bejelentkezve, átirányítás a login.php-ra");
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professzionális Útvonal Kiválasztása</title>
    <script>
        function displayRouteInfo() {
            const routeSelect = document.getElementById('routeSelect');
            const selectedRoute = routeSelect.value;
            const routeDetails = document.getElementById('route-details');

            if (selectedRoute) {
                routeDetails.innerHTML = `Kiválasztott útvonal: <strong>${selectedRoute}</strong>`;
            } else {
                routeDetails.innerHTML = 'Kérjük, válasszon egy útvonalat.';
            }
        }
    </script>

    <style>
     /* Alapstílusok */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            background: #F5F5F5;
            color: #333;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

    /* Konténerek és layout */
    #map-container {
        position: relative;
        display: flex;
        flex-direction: row;
        height: 100vh;
        border-radius: 8px;
        overflow: hidden;
        background-color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    #map {
        width: 70%;
        height: 100%;
        border-radius: 8px;
        background-color: #ddd;
    }

    #sidebar {
        width: 30%;
        background-color: #ffffff;
        border-left: 1px solid #e5e5e5;
        box-shadow: -4px 0 12px rgba(0, 0, 0, 0.1);
        padding: 25px;
        overflow-y: auto;
        border-radius: 8px 0 0 8px;
    }

    /* Kereső szekció */
    #search-container {
        display: flex;
        margin-bottom: 20px;
        gap: 10px;
    }

    #search-input {
        flex-grow: 1;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 1rem;
        background-color: #f7f7f7;
        transition: border 0.3s ease, background-color 0.3s ease;
    }

    #search-input:focus {
        border-color: #4285f4;
        outline: none;
        background-color: #fff;
    }

    #search-button {
        padding: 12px 20px;
        background-color: #34a853;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #search-button:hover {
        background-color: #2c8c43;
    }

    /* Select mező */
    select {
        width: 100%;
        padding: 12px 15px;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #f7f7f7;
        color: #333;
        transition: border-color 0.3s ease, background-color 0.3s ease;
    }

    select:focus {
        border-color: #4285f4;
        outline: none;
        background-color: #fff;
    }

    /* Input mező */
    input[type="text"], input[type="number"] {
        width: 100%;
        padding: 12px 15px;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #f7f7f7;
        transition: border-color 0.3s ease, background-color 0.3s ease;
    }

    input[type="text"]:focus, input[type="number"]:focus {
        border-color: #4285f4;
        outline: none;
        background-color: #fff;
    }

    /* Útvonal lista */
    .route-list {
        list-style: none;
        padding-left: 0;
        margin-top: 20px;
    }

    .route-item {
        border-bottom: 1px solid #e5e5e5;
        padding: 15px 0;
        display: flex;
        align-items: center;
        transition: background-color 0.3s ease;
        border-radius: 6px;
    }

    .route-item:hover {
        background-color: #f5f5f5; /* Világos szürke hover hatás */
    }

    .route-icon {
        margin-right: 15px;
        color: #fbbc05;
        font-size: 1.5rem;
    }

    .route-details {
        flex-grow: 1;
    }

    .route-name {
        font-weight: 600;
        font-size: 1.1rem;
        color: #333;
    }

    .route-info {
        color: #70757a;
        font-size: 0.9rem;
    }

    /* Gombok */
    button {
        padding: 12px 20px;
        background-color: #1a73e8; /* Kék gomb */
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #1558b0; /* Sötétebb kék hover */
    }

    button:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    /* Reszponzív dizájn */
    @media (max-width: 768px) {
        #map-container {
            flex-direction: column;
            height: auto;
        }

        #map, #sidebar {
            width: 100%;
            height: 50%;
            border-radius: 8px;
        }

        #search-container {
            flex-direction: column;
            align-items: stretch;
        }

        #search-input {
            margin-bottom: 10px;
        }

        select, input[type="text"], input[type="number"] {
            margin-bottom: 10px;
        }
    }

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
            color: var(--accent-color);
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
        .header {
            position: relative;
            background: var(--primary-color);
            color: var(--text-light);
            box-shadow: var(--shadow);
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
            background-color: var(--text-light);
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
            box-shadow: var(--shadow);
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
   
<div id="map-container">
    <div id="map"></div>
    <div id="sidebar">
    <div class="route-selector">
        <label for="routeSelect">Válasszon útvonalat:</label>
        <select id="routeSelect" onchange="displayRouteInfo()">
            <option value=""></option>
            <option value="12">12 - Helyi autóbusz-állomás - Sopron u. - Laktanya</option>
<option value="12 vissza">12 vissza - Laktanya - Sopron u. - Helyi autóbusz-állomás</option>
<option value="13">13 - Helyi autóbusz-állomás - Kecelhegy - Helyi autóbusz-állomás</option>
<option value="13 vissza">13 vissza - Helyi autóbusz-állomás - Kecelhegy - Helyi autóbusz-állomás</option>
<option value="20">20 - Raktár u. - Laktanya - Videoton</option>
<option value="20 vissza">20 vissza - Videoton - Laktanya - Raktár u.</option>
<option value="21">21 - Raktár u. - Videoton</option>
<option value="21 vissza">21 vissza - Videoton - Raktár u.</option>
<option value="23">23 - Kaposfüred forduló - Füredi csp. - Kaposvári Egyetem</option>
<option value="23 vissza">23 vissza - Kaposvári Egyetem - Füredi csp. - Kaposfüred forduló</option>
<option value="26">26 - Kaposfüred forduló - Losonc köz - Videoton - METYX</option>
<option value="26 vissza">26 vissza - METYX - Videoton - Losonc köz - Kaposfüred forduló</option>
<option value="27">27 - Laktanya - Füredi u. csp. - KOMÉTA</option>
<option value="27 vissza">27 vissza - KOMÉTA - Füredi u. csp. - Laktanya</option>
<option value="31">31 - Helyi autóbusz-állomás - Egyenesi u. forduló</option>
<option value="31 vissza">31 vissza - Egyenesi u. forduló - Helyi autóbusz-állomás</option>
<option value="32">32 - Helyi autóbuszállomás - Kecelhegy - Helyi autóbusz-állomás</option>
<option value="32 vissza">32 vissza - Helyi autóbusz-állomás - Kecelhegy - Helyi autóbuszállomás</option>
<option value="33">33 - Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.</option>
<option value="33 vissza">33 vissza - Helyi aut. áll. - Kecelhegy - Egyenesi u. - Helyi aut. áll.</option>
<option value="40">40 - Koppány vezér u - 67-es út - Raktár u.</option>
<option value="40 vissza">40 vissza - Raktár u. - 67-es út - Koppány vezér u</option>
<option value="41">41 - Koppány vezér u - Bartók B. u. - Raktár u.</option>
<option value="41 vissza">41 vissza - Raktár u. - Bartók B. u. - Koppány vezér u</option>
<option value="42">42 - Töröcske forduló - Kórház - Laktanya</option>
<option value="42 vissza">42 vissza - Laktanya - Kórház - Töröcske forduló</option>
<option value="43">43 - Helyi autóbusz-állomás - Kórház- Laktanya - Raktár utca - Helyi autóbusz-állomás</option>
<option value="43 vissza">43 vissza - Helyi autóbusz-állomás - Raktár utca - Laktanya - Kórház - Helyi autóbusz-állomás</option>
<option value="44">44 - Helyi autóbusz-állomás - Raktár utca - Laktanya -Arany János tér - Helyi autóbusz-állomás</option>
<option value="44 vissza">44 vissza - Helyi autóbusz-állomás - Arany János tér - Laktanya - Raktár utca - Helyi autóbusz-állomás</option>
<option value="45">45 - Helyi autóbusz-állomás - 67-es út - Koppány vezér u.</option>
<option value="45 vissza">45 vissza - Koppány vezér u. - 67-es út - Helyi autóbusz-állomás</option>
<option value="46">46 - Helyi autóbusz-állomás - Töröcske forduló</option>
<option value="46 vissza">46 vissza - Töröcske forduló - Helyi autóbusz-állomás</option>
<option value="47">47 - Koppány vezér u.- Kórház - Kaposfüred forduló</option>
<option value="47 vissza">47 vissza - Kaposfüred forduló - Kórház - Koppány vezér u.</option>
<option value="61">61 - Helyi- autóbuszállomás - Béla király u.</option>
<option value="61 vissza">61 vissza - Béla király u. - Helyi autóbusz-állomás</option>
<option value="62">62 - Helyi autóbusz-állomás - Városi fürdő - Béla király u.</option>
<option value="62 vissza">62 vissza - Béla király u. - Városi fürdő - Helyi autóbusz-állomás</option>
<option value="70">70 - Helyi autóbusz-állomás - Kaposfüred</option>
<option value="70 vissza">70 vissza - Kaposfüred - Helyi autóbusz-állomás</option>
<option value="71">71 - Kaposfüred forduló - Kaposszentjakab forduló</option>
<option value="71 vissza">71 vissza - Kaposszentjakab forduló - Kaposfüred forduló</option>
<option value="72">72 - Kaposfüred forduló - Hold u. - Kaposszentjakab forduló</option>
<option value="72 vissza">72 vissza - Kaposszentjakab forduló - Hold u. - Kaposfüred forduló</option>
<option value="73">73 - Kaposfüred forduló - KOMÉTA - Kaposszentjakab forduló</option>
<option value="73 vissza">73 vissza - Kaposszentjakab forduló - KOMÉTA - Kaposfüred forduló</option>
<option value="74">74 - Hold utca - Helyi autóbusz-állomás</option>
<option value="74 vissza">74 vissza - Helyi autóbusz-állomás - Hold utca</option>
<option value="75">75 - Helyi autóbusz-állomás - Kaposszentjakab</option>
<option value="75 vissza">75 vissza - Kaposszentjakab - Helyi autóbusz-állomás</option>
<option value="81">81 - Helyi autóbusz-állomás - Hősök temploma - Toponár forduló</option>
<option value="81 vissza">81 vissza - Toponár forduló - Hősök temploma - Helyi autóbusz-állomás</option>
<option value="82">82 - Helyi autóbusz-állomás - Kórház - Toponár Szabó P. u.</option>
<option value="82 vissza">82 vissza - Toponár Szabó P. u. - Kórház - Helyi autóbusz-állomás</option>
<option value="83">83 - Helyi autóbusz-állomás - Szabó P. u. - Toponár forduló</option>
<option value="83 vissza">83 vissza - Toponár forduló - Szabó P. u. - Helyi autóbusz-állomás</option>
<option value="84">84 - Helyi autóbusz-állomás - Toponár, forduló - Répáspuszta</option>
<option value="84 vissza">84 vissza - Répáspuszta - Toponár, forduló - Helyi autóbusz-állomás</option>
<option value="85">85 - Helyi autóbusz-állomás - Kisgát- Helyi autóbusz-állomás</option>
<option value="85 vissza">85 vissza - Helyi autóbusz-állomás - Kisgát- Helyi autóbusz-állomás</option>
<option value="86">86 - Helyi autóbusz-állomás - METYX - Szennyvíztelep</option>
<option value="86 vissza">86 vissza - Szennyvíztelep - METYX - Helyi autóbusz-állomás</option>
<option value="87">87 - Helyi autóbusz állomás - Videoton - METYX</option>
<option value="87 vissza">87 vissza - METYX - Videoton - Helyi autóbusz állomás</option>
<option value="88">88 - Helyi autóbusz-állomás - Videoton</option>
<option value="88 vissza">88 vissza - Videoton - Helyi autóbusz-állomás</option>
<option value="89">89 - Helyi autóbusz-állomás - Kaposvári Egyetem</option>
<option value="89 vissza">89 vissza - Kaposvári Egyetem - Helyi autóbusz-állomás</option>
<option value="90">90 - Helyi autóbusz-állomás - Rómahegy</option>
<option value="90 vissza">90 vissza - Rómahegy - Helyi autóbusz-állomás</option>
<option value="91">91 - Rómahegy - Pázmány P u. - Füredi u. csp</option>
<option value="91 vissza">91 vissza - Rómahegy - Pázmány P u. - Füredi u. csp</option>


        </select>
    </div>

        <ul class="route-list">
            <li class="route-item">
                <div class="route-details">
                    <div class="route-info" id="routeinfo">Menetrend</div>
                </div>
            </li>
            <!-- More route items -->
        </ul>
    </div>
</div>

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
<script>
const routes = {
    "12": {
        number: "12",
        name: "Helyi autóbusz-állomás - Sopron u. - Laktanya",
        stops: [
            { name: "Kaposvár, helyi autóbusz-állomás", "lat": 46.353712944816756, "lng": 17.790623009204865 },
            { name: "Kaposvár, Corso", "lat":  46.355392023023086, "lng": 17.785899639129640 },
            { name: "Kaposvár, Zárda u.", "lat": 46.358837026377685, "lng": 17.787715494632720 },
            { name: "Kaposvár, Honvéd u.", "lat": 46.363140661458800, "lng": 17.787967622280120 },
            { name: "Kaposvár, Arany J. tér", "lat": 46.366823933639840, "lng": 17.788404822349550 },
            { name: "Kaposvár, Sopron u.", "lat": 46.375490674220465, "lng": 17.785727977752686 },
            { name: "Kaposvár, Búzavirág u.", "lat": 46.376005120381800, "lng": 17.781790494918823 },
            { name: "Kaposvár, Laktanya", "lat": 46.378899252341710, "lng": 17.781264781951904 }
        ],
        startTimes: ["05:00", "05:30", "05:55", "06:10", "06:30", "07:05", "07:30", "09:50", "10:00", "10:35", "11:00", "12:30", "13:00"]
    },
    "12 vissza": {
        number: "12 back",
        name: "Helyi autóbusz-állomás - Sopron u. - Laktanya",
        stops: [
            { name: "Kaposvár, helyi autóbusz-állomás", "lat": 46.353712944816756, "lng": 17.790623009204865 },
            { name: "Kaposvár, Corso", "lat": 46.355392023023086, "lng": 17.785899639129640 },
            { name: "Kaposvár, Zárda u.", "lat": 46.358837026377685, "lng": 17.787715494632720 },
            { name: "Kaposvár, Honvéd u.", "lat": 46.363140661458800, "lng": 17.787967622280120 },
            { name: "Kaposvár, Arany J. tér", "lat": 46.366823933639840, "lng": 17.788404822349550 },
            { name: "Kaposvár, Sopron u.", "lat": 46.375490674220465, "lng": 17.785727977752686 },
            { name: "Kaposvár, Búzavirág u.", "lat": 46.376005120381800, "lng": 17.781790494918823 },
            { name: "Kaposvár, Laktanya", "lat": 46.378899252341710, "lng": 17.781264781951904 },
            { name: "Kaposvár, Nagyszeben u.", "lat":46.373155249773944, "lng":17.787109315395355},
            { name: "Kaposvár, Losonc-köz", "lat": 46.369594553108140, "lng":17.787959575653076},
            { name: "Kaposvár, Arany J. tér", "lat": 46.366823933639840, "lng":17.788404822349550},
            { name: "Kaposvár, Szent Imre u. 13", "lat": 46.360230885952110, "lng":17.793844342231750 },
            { name: "Kaposvár, Széchényi tér", "lat": 46.356919254426460, "lng":17.794136703014374 },
            { name: "Kaposvár, Rákóczi tér", "lat": 46.354386039851946, "lng":17.79613917963187 }
        ],
        startTimes: ["04:45", "05:15", "05:45", "06:10", "06:45", "07:20", "07:45", "08:10", "09:15", "10:15", "10:50", "11:15", "12:45", "13:15", "13:30", "13:45", "14:35", "15:15", "16:15", "16:45", "17:15", "17:45", "19:15", "19:40", "20:45"]
    }
};

let map, directionsService, directionsRenderer;

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 46.3592, lng: 17.7960 },
        zoom: 13,
    });

    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer({
        map: map,
        polylineOptions: {
            strokeColor: "#007bff",
            strokeOpacity: 0.8,
            strokeWeight: 5
        }
    });
}

function displayRouteInfo() {
    const routeSelect = document.getElementById("routeSelect");
    const routeInfoDiv = document.getElementById("routeinfo");  // Corrected the ID to `routeinfo`
    const selectedRoute = routeSelect.value;

    if (!selectedRoute) {
        routeInfoDiv.innerHTML = "";
        return;
    }

    const route = routes[selectedRoute];
    const stops = route.stops;
    const nextDeparture = getNextDeparture(route.startTimes);

    // Töröljük az összes előző markert
    clearMarkers();

    // Markerek hozzáadása
    addMarkers(stops);

    let html = `
        <h2>Útvonal: ${route.name}</h2>
        <p>Legközelebbi indulás: <strong>${nextDeparture}</strong></p>
        <h3>Megállók:</h3>
        <ul>
            ${stops.map(stop => `<li>${stop.name}</li>`).join('')}
        </ul>
    `;
    routeInfoDiv.innerHTML = html;
}

let markers = [];

function addMarkers(stops) {
    stops.forEach(stop => {
        const marker = new google.maps.Marker({
            position: { lat: stop.lat, lng: stop.lng },
            map: map,
            title: stop.name
        });
        markers.push(marker);
    });
}

function clearMarkers() {
    markers.forEach(marker => marker.setMap(null));
    markers = [];
}

function getNextDeparture(startTimes) {
    const now = new Date();
    const currentTime = now.toLocaleTimeString('hu-HU', { hour: '2-digit', minute: '2-digit' });
    
    const sortedDepartures = startTimes
        .filter(time => time >= currentTime)
        .sort();

    return sortedDepartures.length > 0 ? sortedDepartures[0] : "Nincs több járat ma.";
}
</script>

<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArXtWdllsylygVw5t_k-22sXUJn-jMU8k&libraries=places&callback=initMap&loading=async">
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
</body>
</html>

<!--
https://maps.googleapis.com/maps/api/js?key=AIzaSyArXtWdllsylygVw5t_k-22sXUJn-jMU8k&libraries=places&callback=initMap&loading=async
<script src="mapinit.js"></script>
<script>
const busStations = [

"12   Helyi autóbusz-állomás - Sopron u. - Laktanya",
"13   Helyi autóbusz-állomás - Kecelhegy - Helyi autóbusz-állomás",
"20   Raktár u. - Laktanya - Videoton",
"21   Raktár u. - Videoton",
"23   Kaposfüred forduló - Füredi csp. - Kaposvári Egyetem",
"26   Kaposfüred forduló - Losonc köz - Videoton - METYX",
"27   Laktanya - Füredi u. csp. - KOMÉTA",
"31   Helyi autóbusz-állomás - Egyenesi u. forduló",
"32   Helyi autóbuszállomás - Kecelhegy - Helyi autóbusz-állomás",
"33   Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.",
"40   Koppány vezér u - 67-es út - Raktár u.",
"41   Koppány vezér u - Bartók B. u. - Raktár u.",
"42   Töröcske forduló - Kórház - Laktanya",
"43   Helyi autóbusz-állomás - Kórház- Laktanya - Raktár utca - Helyi autóbusz-állomás",
"44   Helyi autóbusz-állomás - Raktár utca - Laktanya -Arany János tér - Helyi autóbusz-állomás",
"45   Helyi autóbusz-állomás - 67-es út - Koppány vezér u.",
"46   Helyi autóbusz-állomás - Töröcske forduló",
"47   Koppány vezér u.- Kórház - Kaposfüred forduló",
"61   Helyi- autóbuszállomás - Béla király u.",
"62   Helyi autóbusz-állomás - Városi fürdő - Béla király u.",
"70   Helyi autóbusz-állomás - Kaposfüred",
"71   Kaposfüred forduló - Kaposszentjakab forduló",
"72   Kaposfüred forduló - Hold u. - Kaposszentjakab forduló",
"73   Kaposfüred forduló - KOMÉTA - Kaposszentjakab forduló",
"74   Hold utca - Helyi autóbusz-állomás",
"75   Helyi autóbusz-állomás - Kaposszentjakab",
"81   Helyi autóbusz-állomás - Hősök temploma - Toponár forduló",
"82   Helyi autóbusz-állomás - Kórház - Toponár Szabó P. u.",
"83   Helyi autóbusz-állomás - Szabó P. u. - Toponár forduló",
"84   Helyi autóbusz-állomás - Toponár, forduló - Répáspuszta",
"85   Helyi autóbusz-állomás - Kisgát- Helyi autóbusz-állomás",
"86   Helyi autóbusz-állomás - METYX - Szennyvíztelep",
"87   Helyi autóbusz állomás - Videoton - METYX",
"88   Helyi autóbusz-állomás - Videoton",
"89   Helyi autóbusz-állomás - Kaposvári Egyetem",
"90   Helyi autóbusz-állomás - Rómahegy",
"91   Rómahegy - Pázmány P u. - Füredi u. csp."
    
];
</script>
<script src="mapinfo.js"></script>

<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArXtWdllsylygVw5t_k-22sXUJn-jMU8k&libraries=places&callback=initMap&loading=async"></script>
<script src="startstop.js"></script>
<script>
    // Route planning and mapping functionality for Kaposvár local buses

// Global variables to store map and route-related information
let map;
let directionsService;
let directionsRenderer;

// Bus route data (extracted from the existing busStations array)
const busRoutes = {
    "12": {
        name: "Helyi autóbusz-állomás - Sopron u. - Laktanya",
        stops: [
            "Helyi autóbusz-állomás",
            "Sopron utca",
            "Laktanya"
        ]
    },
    "13": {
        name: "Helyi autóbusz-állomás - Kecelhegy - Helyi autóbusz-állomás",
        stops: [
            "Helyi autóbusz-állomás",
            "Kecelhegy",
            "Helyi autóbusz-állomás"
        ]
    }
    // Add more routes as needed
};

// Function to initialize the route planning system
function initRoutePlanning() {
    const routeBtn = document.getElementById('routeBtn');
    const startSelect = document.getElementById('start');
    const endSelect = document.getElementById('end');

    // Populate dropdown with bus stations
    const busStations = [
        "Helyi autóbusz-állomás",
        "Kórház",
        "Kaposvári Egyetem",
        "Videoton",
        "Kecelhegy",
        "Kaposfüred",
        "Toponár",
        "Laktanya",
        "Sopron utca"
        // Add more stations as needed
    ];

    busStations.forEach(station => {
        const startOption = new Option(station, station);
        const endOption = new Option(station, station);
        startSelect.add(startOption);
        endSelect.add(endOption);
    });

    // Add event listener for route search
    routeBtn.addEventListener('click', searchRoute);
}

// Function to search and display route
function searchRoute() {
    const startPoint = document.getElementById('start').value;
    const endPoint = document.getElementById('end').value;

    if (!startPoint || !endPoint) {
        alert('Kérjük válasszon ki mindkét úti célt!');
        return;
    }

    // Find possible routes between start and end points
    const possibleRoutes = findPossibleRoutes(startPoint, endPoint);

    if (possibleRoutes.length === 0) {
        alert('Nem találtunk útvonalat a megadott pontok között.');
        return;
    }

    // Display the first found route on the map
    displayRouteOnMap(possibleRoutes[0]);
}

// Function to find possible routes between two points
function findPossibleRoutes(start, end) {
    const matchedRoutes = [];

    for (const routeNumber in busRoutes) {
        const route = busRoutes[routeNumber];
        const startIndex = route.stops.indexOf(start);
        const endIndex = route.stops.indexOf(end);

        if (startIndex !== -1 && endIndex !== -1 && startIndex < endIndex) {
            matchedRoutes.push({
                routeNumber: routeNumber,
                routeName: route.name,
                stops: route.stops.slice(startIndex, endIndex + 1)
            });
        }
    }

    return matchedRoutes;
}

// Function to display route on the map
function displayRouteOnMap(route) {
    if (!directionsService) {
        directionsService = new google.maps.DirectionsService();
    }
    if (!directionsRenderer) {
        directionsRenderer = new google.maps.DirectionsRenderer();
        directionsRenderer.setMap(map);
    }

    // Create waypoints from the route stops
    const waypoints = route.stops
        .slice(1, -1)
        .map(stop => ({
            location: stop,
            stopover: true
        }));

    const request = {
        origin: route.stops[0],
        destination: route.stops[route.stops.length - 1],
        waypoints: waypoints,
        optimizeWaypoints: false,
        travelMode: google.maps.TravelMode.DRIVING
    };

    directionsService.route(request, (result, status) => {
        if (status === google.maps.DirectionsStatus.OK) {
            directionsRenderer.setDirections(result);
            
            // Update schedule with route details
            updateSchedule(route);
        } else {
            console.error('Útvonaltervezési hiba:', status);
            alert('Nem sikerült megtervezni az útvonalat.');
        }
    });
}

// Function to update the schedule table
function updateSchedule(route) {
    const scheduleBody = document.getElementById('schedule-body');
    scheduleBody.innerHTML = ''; // Clear existing rows

    const row = scheduleBody.insertRow();
    row.insertCell(0).textContent = route.routeNumber;
    row.insertCell(1).textContent = `${route.stops.length - 1} megálló`;
    row.insertCell(2).textContent = 'Helyi busz'; // Generic bus type
    row.insertCell(3).textContent = '0 perc'; // No delay
}

// Event listener to switch start and end points
function switchStations() {
    const startSelect = document.getElementById('start');
    const endSelect = document.getElementById('end');
    
    const tempValue = startSelect.value;
    startSelect.value = endSelect.value;
    endSelect.value = tempValue;
}

// Modify the existing mapinit.js logic to include route planning
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 46.3625, lng: 17.7952 }, // Kaposvár coordinates
        zoom: 12
    });

    // Initialize route planning
    initRoutePlanning();

    // Add event listener for station switching
    const switchBtn = document.getElementById('switchBtn');
    switchBtn.addEventListener('click', switchStations);
}

// Ensure the function is called after Google Maps API loads
window.initMap = initMap;
</script>-->
