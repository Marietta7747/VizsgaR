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

            .time{
                margin-right: 0%;
                margin-top: 4%;
            }

            .time-name{
                display: inline-block;
                margin-left: 0;
                font-size: 1.25rem;
                max-width: 90%;
            }

            .timeCon{
                width: 371px;
            }

            .switchBtn{
                margin-right: 0;
                margin-top: 5%;
                display: inline-block;
            }

            .header h1{
                margin-left: 2%;
            }

            #datePicker{
                margin-left: 3%;
            }

            .backBtn{
                width: 15%;
            }
        }

        @media (max-width: 380px) {
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
                width: 330px;
            }

            .time-number{
                margin-left: 0;
                padding-right: 45px;
                padding-left: 10px;
            }

            .time{
                margin-right: 0%;
                margin-top: 4%;
            }

            .time-name{
                display: inline-block;
                margin-left: 0;
                font-size: 1.25rem;
                max-width: 73%;
            }

            .timeCon{
                width: 335px;
            }

            .switchBtn{
                margin-right: 0;
                margin-top: 5%;
                display: inline-block;
            }

            .header h1{
                margin-left: 2%;
            }

            #datePicker{
                margin-left: 4%;
                font-size: 1.15rem;
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
 


        // Utility function to remove comments from JSONC
        function preprocessJSONC(jsoncString) {
            return jsoncString.replace(/\/\/.*|\/\*[\s\S]*?\*\//g, ''); // Removes both line and block comments
        }

        // Load and preprocess JSONC file
        fetch('/busTime.jsonc') // Replace with your file's correct path
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok " + response.statusText);
                }
                return response.text(); // Get the file as a text string
            })
            .then(jsoncString => {
                const jsonString = preprocessJSONC(jsoncString); // Remove comments
                const data = JSON.parse(jsonString); // Parse the cleaned JSON
                const busTime = data.busTime;

                // Start of your existing logic

                // Parse the query string to get the time number and dayGoes
                const urlParams = new URLSearchParams(window.location.search);
                const timeNumber = urlParams.get('timeNumber');
                const timeName = urlParams.get('timeName');
                const timeTime = urlParams.get('startTime');
                const showBackTimes = urlParams.get('showBack');
                const dayGoes = urlParams.get('dayGoes');

                if (showBackTimes) {
                    if (dayGoes !== "weekday") {
                        const timeBackWeekend = busTime.find(r => r.numberWeekendBack === timeNumber);
                        if (timeBackWeekend) {
                            displayWeekendBackData(timeBackWeekend);
                        } else {
                            console.error("No weekend back time data found.");
                        }
                    } else {
                        const timeBack = busTime.find(r => r.numberBack === timeNumber);
                        if (timeBack) {
                            displayBackData(timeBack);
                        } else {
                            console.error("No back time data found.");
                        }
                    }
                } else if (dayGoes !== "weekday") {
                    const timeWeekend = busTime.find(r => r.numberWeekend === timeNumber);
                    if (timeWeekend) {
                        displayWeekendData(timeWeekend);
                    }
                } else {
                    const time = busTime.find(r => r.number === timeNumber);
                    if (time) {
                        displayRegularData(time, timeName, timeTime);
                    }
                }

                // Functions to handle different data rendering
                function displayBackData(timeBack) {
                    document.getElementById('timeNumCon').innerHTML = `
                        <div class="time-number">${timeNumber}</div>
                        <div class="time">${timeBack.startBack}</div>
                    `;
                    document.getElementById('timeNameCon').innerHTML = `
                        <div class="time-name">${timeBack.nameBack}</div>
                    `;
                    displayBackTimeTable([timeBack]);
                }

                function displayWeekendBackData(timeBackWeekend) {
                    document.getElementById('timeNumCon').innerHTML = `
                        <div class="time-number">${timeNumber}</div>
                        <div class="time">${timeBackWeekend.startWeekendBack}</div>
                    `;
                    document.getElementById('timeNameCon').innerHTML = `
                        <div class="time-name">${timeBackWeekend.nameWeekendBack}</div>
                    `;
                    displayWeekendBackTimeTable([timeBackWeekend]);
                }

                function displayWeekendData(timeWeekend) {
                    document.getElementById('timeNumCon').innerHTML = `
                        <div class="time-number">${timeNumber}</div>
                        <div class="time">${timeWeekend.startWeekend}</div>
                    `;
                    document.getElementById('timeNameCon').innerHTML = `
                        <div class="time-name">${timeWeekend.nameWeekend}</div>
                    `;
                    displayWeekendTimeTable([timeWeekend]);
                }

                function displayRegularData(time, timeName, timeTime) {
                    document.getElementById('timeNumCon').innerHTML = `
                        <div class="time-number">${timeNumber}</div>
                        <div class="time">${timeTime}</div>
                    `;
                    document.getElementById('timeNameCon').innerHTML = `
                        <div class="time-name">${timeName}</div>
                    `;
                    displayTimeTable([time]);
                }

                // Display helper functions (unchanged from your original code)
                function displayBackTimeTable(time) {
                    const timeContainer = document.getElementById('timeContainer');
                    timeContainer.innerHTML = ""; // Clear previous content
                    time.forEach((timeItem) => {
                        timeItem.stopsBack.forEach((stop, index) => {
                            const timeCard = document.createElement('div');
                            timeCard.className = 'time-card';
                            timeCard.innerHTML = `
                                <div class="time-stop" style="font-weight: bold;">${stop}</div>
                                <div class="time-time">${timeItem.stopsTimeBack[index]}</div>
                            `;
                            timeContainer.appendChild(timeCard);
                        });
                    });
                }

                function displayWeekendBackTimeTable(time) {
                    const timeContainer = document.getElementById('timeContainer');
                    timeContainer.innerHTML = ""; // Clear previous content
                    time.forEach((timeItem) => {
                        timeItem.stopsWeekendBack.forEach((stop, index) => {
                            const timeCard = document.createElement('div');
                            timeCard.className = 'time-card';
                            timeCard.innerHTML = `
                                <div class="time-stop" style="font-weight: bold;">${stop}</div>
                                <div class="time-time">${timeItem.stopsTimeWeekendBack[index]}</div>
                            `;
                            timeContainer.appendChild(timeCard);
                        });
                    });
                }

                function displayWeekendTimeTable(time) {
                    const timeContainer = document.getElementById('timeContainer');
                    timeContainer.innerHTML = ""; // Clear previous content
                    time.forEach((timeItem) => {
                        timeItem.stopsWeekend.forEach((stop, index) => {
                            const timeCard = document.createElement('div');
                            timeCard.className = 'time-card';
                            timeCard.innerHTML = `
                                <div class="time-stop" style="font-weight: bold;">${stop}</div>
                                <div class="time-time">${timeItem.stopsTimeWeekend[index]}</div>
                            `;
                            timeContainer.appendChild(timeCard);
                        });
                    });
                }

                function displayTimeTable(time) {
                    const timeContainer = document.getElementById('timeContainer');
                    timeContainer.innerHTML = ""; // Clear previous content
                    time.forEach((timeItem) => {
                        timeItem.stops.forEach((stop, index) => {
                            const timeCard = document.createElement('div');
                            timeCard.className = 'time-card';
                            timeCard.innerHTML = `
                                <div class="time-stop" style="font-weight: bold;">${stop}</div>
                                <div class="time-time">${timeItem.stopsTime[index]}</div>
                            `;
                            timeContainer.appendChild(timeCard);
                        });
                    });
                }
            })
            .catch(error => {
                console.error('Error processing the JSONC file:', error);
            });

    </script>
</body>
</html>
