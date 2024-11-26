const busRoutes = [
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

        ];