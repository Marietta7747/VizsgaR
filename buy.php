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
    <title>Számla Generátor</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="betölt.js"></script>

    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        :root {
            --primary-color:linear-gradient(to right, #211717,#b30000);
            --accent-color: #7A7474;
            --text-light: #FFFFFF;

            --shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

/*-----------------------------------------------------------------------------------------------------CSS - HEADER------------------------------------------------------------------------------------------------------*/

        .header {
            position: relative;
            background-color: var(--primary-color);
            color: var(--text-light);
            padding: 16px;
            box-shadow: var(--shadow);
            text-align: center;
            margin-bottom: 20px;
        }

        .header {
    position: relative;
    background: var(--primary-color);
    color: var(--text-light);
    padding: 1rem;
    box-shadow: 0 2px 10px var(--shadow-color);
}

.header h1 {
    margin: 0;
    text-align: center;
    font-size: 2rem;
    padding: 1rem 0;
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

/*-----------------------------------------------------------------------------------------------------HEADER END--------------------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------------------CSS - OTHER PARTS----------------------------------------------------------------------------------------------*/
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: var(--shadow);
        }

        .input-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .input-wrapper {
            flex: 1;
            min-width: 200px;
            padding-right: 30px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: #fff;
        }

        input:focus, select:focus {
            border-color: var(--accent-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.2);
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 25px;
             
        }

        button {
            padding: 12px 25px;
            background-color: var(--accent-color);
            color: var(--text-light);
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #908B8B;
            transform: translateY(-2px);
        }

        #invoice {
            margin-top: 30px;
            padding: 25px;
            border: 2px solid var(--accent-color);
            border-radius: 12px;
            background-color: #fff;
        }

        #invoiceDetails {
            white-space: pre-wrap; /* Ensures that whitespace is preserved */
            font-size: 14px;
        }

        canvas {
            margin-top: 20px;
            border: 1px solid var(--accent-color); /* QR kód keret */
        }

        .section-title {
            font-size: 1.2em;
            font-weight: 600;
            margin: 25px 0 15px;
            color: var(--primary-color);
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 8px;
        }

        .input-label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.9em;
            color: #666;
        }

        input:invalid, select:invalid {
            border-color: var(--error-color);
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.8em;
            margin-top: 5px;
            display: none;
        }

        .price-display {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            text-align: right;
            font-size: 1.3em;
            font-weight: 600;
            color: var(--primary-color);
            margin: 20px 0;
        }     

        #qrcode {
            display: block;
            margin: 20px auto;
            padding: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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

/*-----------------------------------------------------------------------------------------------------CSS - @MEDIA-------------------------------------------------------------------------------------------------------*/
        @media (max-width: 480px) {
            .input-group {
                flex-direction: column;
            }
            
            .input-wrapper {
                width: 95%;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            button {
                width: 99%;
            }

            nav.active{
                width: 95%;
            }
        }
/*-----------------------------------------------------------------------------------------------------@MEDIA END---------------------------------------------------------------------------------------------------------*/
   
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
            <h1><i class="fas fa-map-marked-alt"></i> Jegy és bérlet vásárlás</h1>
        </div>
    

            </ul>
              
            </button>
          </nav>


        <div class="navh1">
        </div>
    </div>

    <div style="margin-top: 5%;" class="container">
        <form id="invoiceForm" novalidate>
            <div style="font-weight: bold;" class="section-title">Vásárló adatai</div>
            <div class="input-group">
                <div class="input-wrapper">
                    <label class="input-label">Teljes név*</label>
                    <input type="text" id="name" pattern="[A-Za-zÀ-ž\s]{2,50}" 
                           placeholder="pl. Nagy János" required
                           oninput="validateField(this)">
                    <div class="error-message">Kérjük, adjon meg egy érvényes nevet (2-50 karakter)</div>
                </div>
                <div class="input-wrapper">
                    <label class="input-label">E-mail cím*</label>
                    <input type="email" id="email" 
                           placeholder="pelda@email.hu" required
                           oninput="validateField(this)">
                    <div class="error-message">Kérjük, adjon meg egy érvényes email címet</div>
                </div>
            </div>
            <div class="input-group">
                <div class="input-wrapper">
                    <label class="input-label">Telefonszám*</label>
                    <input type="tel" id="phone" 
                           pattern="[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4}" 
                           placeholder="+36 30 123 4567" required
                           oninput="validateField(this)">
                    <div class="error-message">Kérjük, adjon meg egy érvényes telefonszámot</div>
                </div>
                <div class="input-wrapper">
                    <label class="input-label">Adószám</label>
                    <input type="text" id="vatNumber" 
                           pattern="[0-9]{8}-[0-9]{1}-[0-9]{2}"
                           placeholder="12345678-1-12"
                           oninput="validateField(this)">
                    <div class="error-message">Az adószám formátuma: 12345678-1-12</div>
                </div>
            </div>
            <div class="input-wrapper">
                <label class="input-label">Számlázási cím*</label>
                <input type="text" id="address" 
                       placeholder="1234 Város, Példa utca 123." required
                       oninput="validateField(this)">
                <div class="error-message">Kérjük, adja meg a számlázási címet</div>
            </div>

            <div style="font-weight: bold;" class="section-title">Jegy adatai</div>
            <div class="input-group">
                <div class="input-wrapper">
                    <label class="input-label">Jegytípus*</label>
                    <select id="ticketType" required onchange="updatePrice(); validateField(this)">
                        <option value="" disabled selected>Válasszon jegytípust</option>
                        <option value="adult-single" data-price="450">Vonaljegy - Teljes árú (450 Ft)</option>
                        <option value="adult-daily" data-price="1800">Napijegy - Teljes árú (1800 Ft)</option>
                        <option value="adult-monthly" data-price="9500">Havi bérlet - Teljes árú (9500 Ft)</option>
                        <option value="student-monthly" data-price="3450">Havi bérlet - Tanulói (3450 Ft)</option>
                        <option value="senior-monthly" data-price="3450">Havi bérlet - Nyugdíjas (3450 Ft)</option>
                    </select>
                    <div class="error-message">Kérjük, válasszon jegytípust</div>
                </div>
                <div class="input-wrapper">
                    <label class="input-label">Mennyiség*</label>
                    <input type="number" id="quantity" min="1" max="10" value="1" required
                           class="quantity-input" onchange="updatePrice(); validateField(this)">
                    <div class="error-message">A mennyiség 1 és 10 között lehet</div>
                </div>
            </div>
            <div class="input-group">
                <div class="input-wrapper">
                    <label class="input-label">Érvényesség kezdete*</label>
                    <input type="date" id="validFrom" required
                           onchange="updateValidUntil(); validateField(this)">
                    <div class="error-message">Kérjük, válasszon kezdő dátumot</div>
                </div>
                <div class="input-wrapper">
                    <label class="input-label">Érvényesség vége</label>
                    <input type="date" id="validUntil" readonly>
                </div>
            </div>
           

            <div style="font-weight: bold;" class="section-title">Fizetési információk</div>
            <div class="input-group">
                <div class="input-wrapper">
                    <label class="input-label">Fizetési mód*</label>
                    <select id="paymentMethod" required onchange="validateField(this)">
                        <option value="" disabled selected>Válasszon fizetési módot</option>
                        <option value="card">Bankkártya</option>
                        <option value="simplepay">SimplePay</option>
                        <option value="paypal">PayPal</option>
                    </select>
                    <div class="error-message">Kérjük, válasszon fizetési módot</div>
                </div>
            </div>

            <div class="input-wrapper">
                <label class="input-label">Számlaszám*</label>
                <input type="text" id="szamlaszam" placeholder="#### #### #### ####">
            </div>

            <div class="price-display">
                Végösszeg: <span id="totalPrice">0</span> Ft
            </div>

            <div class="button-group">
                <button type="button" onclick="generateInvoice()">Számla generálása</button>
            </div>
        </form>

        <div id="invoice" style="display: none;">
            <h2>Számla előnézet</h2>
            <pre id="invoiceDetails"></pre>
            <canvas id="qrcode"></canvas>
            <div class="button-group">
                <button onclick="downloadPDF()">PDF letöltése</button>
            </div>
        </div>
    </div><br>


<!-----------------------------------------Késések igazolás generálás------------------------------>
<div class="container">
        <form id="kesesigazolas">
            <h1 style="text-align:center">Késés Igazolás</h1>
            <div class="section-title">Utas adatai</div>
            <div class="input-group">
                <div class="input-wrapper">
                    <label class="input-label">Név*</label>
                    <input type="text" id="nev" required>
                </div>
                <div class="input-wrapper">
                    <label class="input-label">Bérletszám / Jegyszám*</label>
                    <input type="text" id="berletszam" required>
                </div>
            </div>

            <div class="section-title">Járat adatai</div>
            <div class="input-group">
                <div class="input-wrapper">
                    <label class="input-label">Járatszám*</label>
                    <input type="text" id="jaratszam" required>
                </div>
                <div class="input-wrapper">
                    <label class="input-label">Dátum*</label>
                    <input type="date" id="datum" required>
                </div>
            </div>

            <div class="input-group">
                <div class="input-wrapper">
                    <label class="input-label">Tervezett indulás*</label>
                    <input type="time" id="tervezett_indulas" value="00:00" required>
                </div>
                <div class="input-wrapper">
                    <label class="input-label">Tényleges indulás*</label>
                    <input type="time" id="tenyleges_indulas" value="00:00" required>
                </div>
            </div>

            <div class="input-group">
                <div class="input-wrapper">
                    <label class="input-label">Felszállás helye*</label>
                    <select type="text" id="felszallas" placeholder="pázmány péter utca 1" required></select>
                </div>
                <div class="input-wrapper">
                    <label class="input-label">Leszállás helye*</label>
                    <select type="text" id="leszallas" placeholder="füredi utcai csomópont" required></select>
                </div>
            </div>

            <div class="button-group">
                <button type="submit">Igazolás generálása</button>
            </div>
        </form>
    </div>
<!-- -----------------------------------------------------------------------------------------------------HTML - FOOTER------------------------------------------------------------------------------------------------ -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h2>Kaposvár közlekedés</h2>
                <p style="font-style: italic">Megbízható közlekedési szolgáltatások<br> az Ön kényelméért már több mint 50 éve.</p><br>
                <div class="social-links">
                    <a style="color: darkblue; padding:1px;" href="https://www.facebook.com/VOLANBUSZ/"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" style="max-width:10px;"><path fill="#00008b" d="M279.1 288l14.2-92.7h-88.9v-60.1c0-25.4 12.4-50.1 52.2-50.1h40.4V6.3S260.4 0 225.4 0c-73.2 0-121.1 44.4-121.1 124.7v70.6H22.9V288h81.4v224h100.2V288z"/></svg></a>
                    <a style="color: lightblue; padding:1px;"href="https://x.com/volanbusz_hu?mx=2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="max-width:15px;"><path fill="#add8e6" d="M459.4 151.7c.3 4.5 .3 9.1 .3 13.6 0 138.7-105.6 298.6-298.6 298.6-59.5 0-114.7-17.2-161.1-47.1 8.4 1 16.6 1.3 25.3 1.3 49.1 0 94.2-16.6 130.3-44.8-46.1-1-84.8-31.2-98.1-72.8 6.5 1 13 1.6 19.8 1.6 9.4 0 18.8-1.3 27.6-3.6-48.1-9.7-84.1-52-84.1-103v-1.3c14 7.8 30.2 12.7 47.4 13.3-28.3-18.8-46.8-51-46.8-87.4 0-19.5 5.2-37.4 14.3-53 51.7 63.7 129.3 105.3 216.4 109.8-1.6-7.8-2.6-15.9-2.6-24 0-57.8 46.8-104.9 104.9-104.9 30.2 0 57.5 12.7 76.7 33.1 23.7-4.5 46.5-13.3 66.6-25.3-7.8 24.4-24.4 44.8-46.1 57.8 21.1-2.3 41.6-8.1 60.4-16.2-14.3 20.8-32.2 39.3-52.6 54.3z"/></svg></a>
                    <a style="color: red; padding:1px;"href="https://www.instagram.com/volanbusz/"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="max-width:15px;"><path fill="#ff0000" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg></a>
                </div>
            </div>
           
            <div  class="footer-section">
                <h3>Elérhetőség</h3>
                <ul class="footer-links">
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="max-width:17px;"><path fill="#ffffff" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg> +36-82/411-850</li>
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="max-width:17px;"><path fill="#ffffff" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg> titkarsag@kkzrt.hu</li>
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" style="max-width:16px;"><path fill="#ffffff" d="M172.3 501.7C27 291 0 269.4 0 192 0 86 86 0 192 0s192 86 192 192c0 77.4-27 99-172.3 309.7-9.5 13.8-29.9 13.8-39.5 0zM192 272c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80z"/></svg> 7400 Kaposvár, Cseri út 16.</li>
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" style="max-width:16px;"><path fill="#ffffff" d="M172.3 501.7C27 291 0 269.4 0 192 0 86 86 0 192 0s192 86 192 192c0 77.4-27 99-172.3 309.7-9.5 13.8-29.9 13.8-39.5 0zM192 272c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80z"/></svg> Áchim András utca 1.</li>
                </ul>
            </div>
        </div>
        <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1);">
            <p>© 2024 Kaposvár közlekedési Zrt. Minden jog fenntartva.</p>
        </div>
    </footer>
<!-- -----------------------------------------------------------------------------------------------------FOOTER END--------------------------------------------------------------------------------------------------- -->

    <script>
      
const busStations = [
            "helyi autóbusz állomás", "Berzsenyi u. felűljáró", "Berzsenyi u. 30.", "Ballakúti u.",
            "Lonkahegy forduló", "Nyár", "Berzsenyi u. felűljáró", "Jókai liget", "Szigetvári u. 6.",
            "Szigetvári u. 62.", "Szigetvári u. 139.", "Kaposfüred vá.", "Bersenyi u. 30.", "Füredi u. csp.",
            "Toldi lakónegyed", "Kinizsi ltp.", "Búzavirág u.", "Laktanya", "Volán-telep", "Kaposfüredi u. 12.",
            "Kaposfüredi u. 104.", "Kaposfüred központ", "Állomás u.", "Kaposfüredi u. 244.", "Kaposfüred forduló",
            "Városi könyvtár", "Vasútköz", "Raktár u. forduló", "Mátyás k. u. forduló", "Egyenesi u. forduló",
            "Koppány vezér u. forduló", "Töröcske forduló", "Béla király u. forduló", "Kaposszentjakab forduló",
            "Toponár forduló", "NABI forduló", "Kaposvári Egyetem", "Videoton", "Buzsáki u.", "Aranytér",
            "Sopron u. forduló", "Tóth Árpád u.", "Kométa forduló", "67-es sz. út", "Rózsa u.", "Erdősor u.",
            "Gönczi F. u.", "Városi Fürdő", "Hajnóczy u. csp.", "Jutai u. 24.", "Jutai u. 45.", "Raktár u. 2.",
            "Kecelhegyalja u. 6.", "Kőrösi Cs. S. u. 109.", "Kecelhegyi iskola", "Kőrösi Cs. S. u. 45.",
            "Kenese tér", "Eger u.", "Kapoli A. u.", "Egyenesi u. 42.", "Beszédes J. u.", "Állatkorház", "Kölcsey u.",
            "Tompa M. u.", "Vasútállomás", "Baross G. u.", "Csalogány u.", "Vikár B. u.", "Fő u. 48.", "Fő u. 37-39.",
            "Hársfa u.", "Hősök temploma", "Gyár u.", "Pécsi úti iskola", "Nádasdi u.", "Móricz Zs. u.", "Pécsi u. 227.",
            "Várhegy feljáró", "Nap u", "Hold u.", "Magyar Nobel-díjasok tere", "Bartók B. u.", "Táncsics M. u.",
            "Zichy M. u.", "Aranyeső u.", "Jókai u.", "Szegfű u.", "Gyertyános", "Kertbarát felső", "Kertbarát alsó",
            "Szőlőhegy", "Fenyves u. 37/A", "Fenyves u. 31", "Kórház célgazdaság", "Fenyves u. 63.", "Mező u. csp.",
            "Izzó u.", "Guba S. u. 81.", "Guba S. u. 57.", "Villamossági Gyár", "Toponár posta", "Toponár Orci elágazás",
            "Toponári u. 182.", "Toponári u. 238.", "Erdei F. u.", "Szabó P. u.", "Orci út 14.", "Répáspuszta",
            "Kenyérgyár u. 1.", "Kenyérgyár u. 3.", "Dombóvári u. 4.", "Kaposvári Egyetem forduló", "Virág u.",
            "Pázmány P. u.", "Vöröstelek u.", "Hegyi u.", "Tallián Gy. u. 4.", "Kórház", "Tallián Gy. u. 56.",
            "Tallián Gy. u. 82.", "ÁNTSZ", "Rendőrség", "Szent Imre u. 29.", "Szent Imre u. 13.", "Széchenyi tér",
            "Zárda u.", "Honvéd u.", "Arany J. tér", "Losonc-köz", "Brassó u.", "Nagyszeben u.", "Somssich P. u.",
            "Pázmány P. u.", "Kisgát", "Arany J. u", "Rózsa u.", "Corso"
        ];

function initializeDropdowns() {
    const startSelect = document.getElementById('felszallas');
    const endSelect = document.getElementById('leszallas');
    
    busStations.forEach(station => {
        const startOption = new Option(station, station);
        startSelect.add(startOption);
        
        const endOption = new Option(station, station);
        endSelect.add(endOption);
    });
}

function switchStations() {
    const startSelect = document.getElementById('start');
    const endSelect = document.getElementById('end');
    
    const tempValue = startSelect.value;
    startSelect.value = endSelect.value;
    endSelect.value = tempValue;
}

document.addEventListener('DOMContentLoaded', initializeDropdowns);

        const today = new Date();
        document.getElementById("validFrom").value = today.toISOString().split("T")[0];
        document.getElementById("validFrom").min = today.toISOString().split("T")[0];
        const delay = new Date();
        document.getElementById("datum").value = today.toISOString().split("T")[0];
        document.getElementById("datum").min = today.toISOString().split("T")[0];


        document.getElementById("validUntil").min = today.toISOString().split("T")[0];

        function updatePrice() {
            const ticketSelect = document.getElementById('ticketType');
            const quantity = document.getElementById('quantity').value;
            const selectedOption = ticketSelect.options[ticketSelect.selectedIndex];
            
            if (selectedOption.value) {
                const basePrice = parseInt(selectedOption.dataset.price);
                const total = basePrice * quantity;
                document.getElementById('totalPrice').textContent = total.toLocaleString();

                // Update validUntil date based on ticket type
                const validFrom = new Date(document.getElementById('validFrom').value);
                if (selectedOption.value.includes('monthly')) {
                    const validUntil = new Date(validFrom);
                    validUntil.setMonth(validUntil.getMonth() + 1);
                    document.getElementById('validUntil').value = validUntil.toISOString().split('T')[0];
                } else {
                    const validUntil = new Date(validFrom);
                    validUntil.setDate(validUntil.getDate() + 1);
                    document.getElementById('validUntil').value = validUntil.toISOString().split('T')[0];
                }
            }
        }

        document.getElementById('ticketType').addEventListener('change', updatePrice);
        document.getElementById('quantity').addEventListener('change', updatePrice);
        document.getElementById('validFrom').addEventListener('change', updatePrice);

        function generateRandomId() {
            return 'TKT-' + Date.now().toString(36) + Math.random().toString(36).substr(2, 5);
        }

        function generateInvoice() {
            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                vatNumber: document.getElementById('vatNumber').value,
                address: document.getElementById('address').value,
                ticketType: document.getElementById('ticketType').options[document.getElementById('ticketType').selectedIndex].text,
                quantity: document.getElementById('quantity').value,
                validFrom: document.getElementById('validFrom').value,
                validUntil: document.getElementById('validUntil').value,
                paymentMethod: document.getElementById('paymentMethod').value,
                totalPrice: document.getElementById('totalPrice').textContent,
                szamlaszam: document.getElementById('szamlaszam').value,
                invoiceId: generateRandomId(),
                invoiceDate: new Date().toLocaleDateString('hu-HU')
            };

            
            if (!formData.name || !formData.email || !formData.phone || !formData.address || 
                !formData.ticketType || !formData.paymentMethod || !formData.szamlaszam) {
                alert("Kérjük, töltse ki az összes kötelező mezőt!");
                return;
            }

            
            const invoiceDetails = `Számla
            
----------------------------------------------------------------------------------------            
Számlaszám: ${formData.szamlaszam}
Kiállítás dátuma: ${formData.invoiceDate}


Név: ${formData.name}
${formData.vatNumber ? 'Adószám: ' + formData.vatNumber : ''}
Cím: ${formData.address}
E-mail: ${formData.email}
Telefon: ${formData.phone}

Termék részletei:

Megnevezés: ${formData.ticketType}
Mennyiség: ${formData.quantity} db
Érvényesség kezdete: ${formData.validFrom}
Érvényesség vége: ${formData.validUntil}

Fizetési indormációk:

Fizetési mód: ${formData.paymentMethod}
Végösszeg: ${formData.totalPrice} Ft

Egyedi azonosító: ${formData.invoiceId}
----------------------------------------------------------------------------------------`;

            document.getElementById('invoiceDetails').innerText = invoiceDetails;
            document.getElementById('invoice').style.display = 'block';

            // Generate QR code
            const qrCode = new QRious({
                element: document.getElementById('qrcode'),
                value: formData.invoiceId,
                size: 150
            });
            
        }

       function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    try {
        // Alapbeállítások
        const margin = 20;
        const pageWidth = 210;
        const contentWidth = pageWidth - (2 * margin);

        // Színek definíciója
        const colors = {
            primary: [0, 31, 63],    // Sötétkék
            secondary: [245, 245, 245], // Világosszürke
            accent: [230, 230, 230],    // Középszürke
            text: [51, 51, 51],        // Sötétszürke
            lightText: [102, 102, 102]  // Világosabb szürke
        };

        // Fejléc
        doc.setFillColor(...colors.secondary);
        doc.rect(0, 0, pageWidth, 45, 'F');

        // Cég logó helye (ha van)
        try {
            const logoBase64 = document.getElementById('logo')?.src;
            if (logoBase64) {
                doc.addImage(logoBase64, 'SVG', margin, 10, 30, 30);
            }
        } catch (error) {
            console.warn('Logo betöltése sikertelen:', error);
        }

        // Cégnév és számlainformációk a fejlécben
        doc.setTextColor(...colors.primary);
        doc.setFontSize(22);
        doc.setFont('helvetica', 'bold');
        doc.text('Kaposvári Közlekedési Zrt.', margin + 35, 25);

        doc.setFontSize(10);
        doc.setFont('helvetica', 'normal');
        doc.text([
            'Adószám: 12345678-2-14',
            'Cégjegyzékszám: 01-10-123456',
            'Bankszámlaszám: 11111111-22222222-33333333',
            'Székhely: 7400 Kaposvár'
        ], margin + 35, 30, { lineHeightFactor: 1.2 });

        // Számla cím szakasz
        doc.setFillColor(...colors.accent);
        doc.rect(0, 45, pageWidth, 15, 'F');
        doc.setTextColor(...colors.text);
        doc.setFontSize(16);
        doc.setFont('helvetica', 'bold');
        doc.text('SZÁMLA', pageWidth/2, 55, { align: 'center' });

        // Form adatok beszerzése
        const formData = {
            szamlaszam: document.getElementById('szamlaszam').value,
            invoiceDate: new Date().toLocaleDateString('hu-HU'),
            name: document.getElementById('name').value,
            vatNumber: document.getElementById('vatNumber').value,
            address: document.getElementById('address').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            ticketType: document.getElementById('ticketType').options[document.getElementById('ticketType').selectedIndex].text,
            quantity: document.getElementById('quantity').value,
            validFrom: document.getElementById('validFrom').value,
            validUntil: document.getElementById('validUntil').value,
            paymentMethod: document.getElementById('paymentMethod').value,
            totalPrice: document.getElementById('totalPrice').textContent,
            invoiceId: generateRandomId()
        };

        let y = 70;

        // Számla alapadatok box
        doc.setFillColor(...colors.secondary);
        doc.roundedRect(margin, y, contentWidth/2 - 5, 40, 3, 3, 'F');
        doc.setFontSize(10);
        doc.setTextColor(...colors.text);
        
        // Bal oldali adatok
        doc.setFont('helvetica', 'bold');
        doc.text('Számlaszám:', margin + 5, y + 10);
        
        doc.setFont('helvetica', 'normal');
        doc.text(formData.szamlaszam, margin + 30, y + 10);
        doc.text(formData.invoiceDate, margin + 5, y + 20);

        // QR kód a jobb felső sarokban
        try {
            const qrCanvas = document.getElementById('qrcode');
            const qrBase64 = qrCanvas.toDataURL('image/png');
            doc.addImage(qrBase64, 'PNG', pageWidth - margin - 35, y, 35, 35);
        } catch (error) {
            console.warn('QR kód betöltése sikertelen:', error);
        }

        y += 45;

        // Vevő adatok szakasz
        doc.setFillColor(149, 6, 6);
        doc.setTextColor(255, 255, 255);
        doc.rect(margin, y, contentWidth, 8, 'F');
        doc.setFontSize(12);
        doc.setFont('helvetica', 'bold');
        doc.text('Adatok', margin + 5, y + 6);

        y += 15;
        doc.setTextColor(...colors.text);
        doc.setFontSize(11);

        function addField(label, value, yPos, leftMargin = margin) {
            doc.setFont('helvetica', 'bold');
            doc.text(label, leftMargin, yPos);
            doc.setFont('helvetica', 'normal');
            doc.text(value || '', leftMargin + 45, yPos);
            return yPos + 8;
        }

        y = addField('Név:', formData.name, y);
        if (formData.vatNumber) {
            y = addField('Adószám:', formData.vatNumber, y);
        }
        y = addField('Cím:', formData.address, y);
        y = addField('E-mail:', formData.email, y);
        y = addField('Telefon:', formData.phone, y);

        y += 10;

        const quantity = parseInt(formData.quantity);
        const unitPrice = parseInt(formData.totalPrice) / quantity;
        const netPrice = unitPrice * quantity;
        const vat = netPrice * 0.27; // 27% ÁFA
        const grossPrice = netPrice + vat;

        // Lábléc
        y = 270;
        doc.setFillColor(...colors.accent);
        doc.rect(0, y, pageWidth, 27, 'F');
        doc.setFontSize(9);
        doc.setTextColor(...colors.lightText);

        const footer = [
            'Ez a számla elektronikusan került kiállításra és hitelesítésre.',
            `Egyedi azonosító: ${formData.invoiceId}`,
            'Köszönjük, hogy szolgáltatásainkat választotta!'
        ];

        footer.forEach((line, i) => {
            doc.text(line, pageWidth/2, y + 6 + (i * 5), { align: 'center' });
        });

        // PDF mentése
        const cleanName = formData.name
            ? formData.name.replace(/[^a-zA-Z0-9]/g, '_').toLowerCase()
            : 'szamla';
        const filename = `szamla_${cleanName}_${formData.invoiceId}.pdf`;
        doc.save(filename);

    } catch (error) {
        console.error('Hiba a PDF generálása során:', error);
        alert(`Hiba történt a PDF generálása során: ${error.message}`);
    }
}

// Meglévő eseménykezelők megtartása
document.getElementById('ticketType').addEventListener('change', updatePrice);
document.getElementById('quantity').addEventListener('change', updatePrice);
document.getElementById('validFrom').addEventListener('change', updatePrice);

// Nav

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
//Nav end

        document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('kesesigazolas');

    function kesesSzamitas(tervezett, tenyleges) {
        try {
            const tervIdopont = new Date(`1970-01-01T${tervezett}`);
            const tenyIdopont = new Date(`1970-01-01T${tenyleges}`);
            
            if (isNaN(tervIdopont.getTime()) || isNaN(tenyIdopont.getTime())) {
                throw new Error('Érvénytelen időformátum');
            }
            
            return Math.round((tenyIdopont - tervIdopont) / (1000 * 60));
        } catch (error) {
            console.error('Hiba a késés számításánál:', error);
            throw error;
        }
    }

    async function loadImage(path) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            img.onload = () => {
                try {
                    const canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    const ctx = canvas.getContext('2d');
                    if (!ctx) {
                        reject(new Error('Nem sikerült létrehozni a canvas kontextust'));
                        return;
                    }
                    ctx.drawImage(img, 0, 0);
                    resolve(canvas.toDataURL('image/png'));
                } catch (error) {
                    reject(error);
                }
            };
            img.onerror = () => reject(new Error(`Nem sikerült betölteni a képet: ${path}`));
            img.src = path;
        });
    }

    async function pdfKeszites(adatok) {
        if (!window.jspdf) {
            alert('A PDF generáló könyvtár nem található. Kérjük, frissítse az oldalt.');
            return;
        }

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        try {
            // Alapbeállítások
            const margin = 25;
            const pageWidth = 210;
            const contentWidth = pageWidth - (2 * margin);

            // Fejléc háttér - világosabb szürke
            doc.setFillColor(245, 245, 245);
            doc.rect(0, 0, pageWidth, 40, 'F');

            // Logo betöltésének megpróbálása
            try {
                const logoBase64 = await loadImage('logo.svg');
                doc.addImage(logoBase64, 'SVG', margin, 10, 15, 15);
            } catch (error) {
                console.warn('Logo betöltése sikertelen:', error);
                // Folytatjuk logo nélkül
            }

            // Fejléc szöveg - sötétszürke
            doc.setTextColor(51, 51, 51);
            doc.setFontSize(20);
            doc.setFont('helvetica', 'bold');
            doc.text('Kaposvári Közlekedési Zrt.', margin + 40, 22);

            // Alcím sáv - középszürke
            doc.setFillColor(230, 230, 230);
            doc.rect(0, 40, pageWidth, 10, 'F');
            doc.setTextColor(51, 51, 51);
            doc.setFontSize(14);
            doc.text('KÉSÉS IGAZOLÁS', pageWidth/2, 47, { align: 'center' });

            // Adatok szakasz
            let y = 65;
            doc.setTextColor(68, 68, 68);
            doc.setFontSize(11);

            function addDataField(label, value, yPos) {
                if (!label || !value) return yPos; // Üres mezők kihagyása
                
                // Háttér minden második sorhoz - nagyon világos szürke
                if ((yPos - 65) / 8 % 2 === 0) {
                    doc.setFillColor(250, 250, 250);
                    doc.rect(margin, yPos - 4, contentWidth, 8, 'F');
                }
                
                // Címke
                doc.setFont('helvetica', 'bold');
                doc.text(label, margin, yPos);
                
                // Érték
                doc.setFont('helvetica', 'normal');
                doc.text(String(value), margin + 50, yPos);
                
                return yPos + 8;
            }

            let kesesPerc;
            try {
                kesesPerc = kesesSzamitas(adatok.tervezett_indulas, adatok.tenyleges_indulas);
            } catch (error) {
                console.error('Hiba a késés számításánál:', error);
                kesesPerc = 'N/A';
            }

            // Adatok megjelenítése
            y = addDataField('Utas neve:', adatok.nev, y);
            y = addDataField('Bérletszám:', adatok.berletszam, y);
            y = addDataField('Járatszám:', adatok.jaratszam, y);
            y = addDataField('Dátum:', adatok.datum, y);
            y = addDataField('Felszállás:', adatok.felszallas, y);
            y = addDataField('Leszállás:', adatok.leszallas, y);
            y = addDataField('Tervezett indulás:', adatok.tervezett_indulas, y);
            y = addDataField('Tényleges indulás:', adatok.tenyleges_indulas, y);

            // Késés kiemelése - modern stílus
            y += 10;
            doc.setFillColor(68, 68, 68);
            doc.rect(margin, y - 4, contentWidth, 12, 'F');
            doc.setFont('helvetica', 'bold');
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(12);
            doc.text(`KÉSÉS MÉRTÉKE: ${kesesPerc} PERC`, pageWidth/2, y + 3, { align: 'center' });

            // Aláírás betöltésének megpróbálása
            y = 160;
            try {
                const signatureBase64 = await loadImage('alairas.svg');
                doc.addImage(signatureBase64, 'SVG', margin, y, 40, 20);
            } catch (error) {
                console.warn('Aláírás betöltése sikertelen:', error);
                // Alternatív megoldás aláírás helyett
                doc.setFont('helvetica', 'italic');
                doc.setFontSize(10);
                doc.setTextColor(68, 68, 68);
                doc.text('Elektronikusan hitelesítve', margin, y + 10);
            }

            // Lábléc vonal
            y = 200;
            doc.setFillColor(200, 200, 200);
            doc.rect(margin, y, contentWidth, 0.5, 'F');

            // Lábléc információk
            y += 10;
            doc.setTextColor(102, 102, 102);
            doc.setFontSize(9);
            doc.setFont('helvetica', 'normal');
            const maiDatum = new Date().toLocaleDateString('hu-HU', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            doc.text(`Kiállítás dátuma: ${maiDatum}`, margin, y);

            // Dokumentum azonosító és generálási információ
            y += 6;
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(8);
            const docId = Math.random().toString(36).substr(2, 9).toUpperCase();
            doc.text('Az igazolást a rendszer automatikusan generálta.', margin, y);
            doc.text(`Dokumentum azonosító: ${docId}`, pageWidth - margin, y, { align: 'right' });

            // Fájlnév generálása biztonságosan
            const tisztaNev = adatok.nev
                ? adatok.nev.replace(/[^a-zA-Z0-9]/g, '_').toLowerCase()
                : 'keses_igazolas';
            const fajlnev = `keses_igazolas_${tisztaNev}_${docId}.pdf`;

            // PDF mentése
            doc.save(fajlnev);

        } catch (error) {
            console.error('Részletes hiba a PDF generálása során:', error);
            alert(`Hiba történt a PDF generálása során: ${error.message}`);
        }
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Adatok validálása
        const required = ['nev', 'jaratszam', 'datum', 'tervezett_indulas', 'tenyleges_indulas'];
        const hianyzo = required.filter(field => !document.getElementById(field)?.value);
        
        if (hianyzo.length > 0) {
            alert(`Kérjük, töltse ki a következő kötelező mezőket: ${hianyzo.join(', ')}`);
            return;
        }
        
        const adatok = {
            nev: document.getElementById('nev').value,
            berletszam: document.getElementById('berletszam').value,
            jaratszam: document.getElementById('jaratszam').value,
            datum: document.getElementById('datum').value,
            tervezett_indulas: document.getElementById('tervezett_indulas').value,
            tenyleges_indulas: document.getElementById('tenyleges_indulas').value,
            felszallas: document.getElementById('felszallas').value,
            leszallas: document.getElementById('leszallas').value
        };
        
        pdfKeszites(adatok).catch(error => {
            console.error('Hiba a form feldolgozása során:', error);
            alert('Váratlan hiba történt. Kérjük, próbálja újra később.');
        });
    });
});
    </script>
</body>
</html>