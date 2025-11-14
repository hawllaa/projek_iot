<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deteksi Getaran Gempa (PHP)</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- Variabel Warna Baru yang Senada --- */
        :root {
            --primary-color: #1c3144; /* Deep Navy Blue untuk Header */
            --bg-color: #f5f7fa; /* Light Gray Blue untuk background */
            --card-bg: #ffffff;
            --text-primary: #1a1a1a;
            --text-secondary: #5a5a5a;
            --border-color: #e0e0e0;
            
            /* Warna Status yang Lebih Muted */
            --status-aman-bg: #d0f5e1;
            --status-aman-text: #1e8449;
            --status-waspada-bg: #fff2cc; 
            --status-waspada-text: #a05a00;
            --status-bahaya-bg: #f5d0d0;
            --status-bahaya-text: #b91c1c;
        }

        /* --- Penggunaan Font Poppins --- */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        /* Container Utama */
        .mobile-container {
            width: 100%;
            max-width: 420px; 
            min-height: 100vh;
            background-color: var(--card-bg);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            background-color: var(--primary-color);
            color: white;
            padding: 18px 20px;
            text-align: center;
            font-weight: 600;
        }

        .header h1 {
            margin: 0;
            font-size: 1.25rem;
        }

        /* Konten Utama */
        .content {
            padding: 20px;
            flex-grow: 1;
        }

        /* Kartu Status */
        .status-card {
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); /* Tambah shadow tipis */
        }

        .status-card h2 {
            margin-top: 0;
            margin-bottom: 8px;
            font-size: 0.9rem;
            color: var(--text-secondary);
            font-weight: 600;
        }

        .status-card .status-text {
            margin: 0;
            font-size: 2.8rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* Kelas untuk mengubah warna status */
        .status-aman { background-color: var(--status-aman-bg); color: var(--status-aman-text); border: 1px solid var(--status-aman-text); }
        .status-waspada { background-color: var(--status-waspada-bg); color: var(--status-waspada-text); border: 1px solid var(--status-waspada-text); }
        .status-bahaya { background-color: var(--status-bahaya-bg); color: var(--status-bahaya-text); border: 1px solid var(--status-bahaya-text); }

        /* Kartu Data Sensor */
        .data-card {
            background-color: #f9f9f9;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .data-card h3 { 
            margin-top: 0; 
            margin-bottom: 12px; 
            font-size: 1rem;
            color: var(--text-primary); 
        }

        .data-card .data-value { 
            margin: 0; 
            font-size: 2.25rem; 
            font-weight: 700; 
            color: var(--primary-color); 
        }
        
        .data-card .data-value span { 
            font-size: 1rem; 
            font-weight: 500; 
            color: var(--text-secondary); 
        }

        /* Kartu Info Detail */
        .info-card {
            background-color: #f9f9f9;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 20px;
        }

        .info-card h3 { 
            margin-top: 0; 
            margin-bottom: 16px; 
            border-bottom: 1px solid var(--border-color); 
            padding-bottom: 8px; 
            font-size: 1rem;
        }

        .info-card p {
            margin: 10px 0;
            font-size: 0.9rem;
            color: var(--text-secondary);
            display: flex;
            justify-content: space-between;
        }

        .info-card p strong {
            color: var(--text-primary);
            font-weight: 600;
            margin-right: 10px;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 16px;
            font-size: 0.75rem;
            color: #888;
            border-top: 1px solid var(--border-color);
        }

    </style>
</head>
<body>

    <div class="mobile-container">
        
        <header class="header">
            <h1>Deteksi Getaran Gempa</h1>
        </header>
        
        <main class="content">
            
            <div class="status-card status-aman" id="status-card">
                <h2>STATUS PERINGATAN</h2>
                <p class="status-text" id="status-text">MEMUAT...</p>
            </div>
            
            <div class="data-card">
                <h3>Kekuatan Getaran (Nilai Sensor)</h3>
                <p class="data-value" id="vibration-value">- <span></span></p>
            </div>

            <div class="info-card">
                <h3>DETAIL KEJADIAN</h3>
                <p>
                    <strong>Waktu Kejadian:</strong> 
                    <span id="time-value">--/--/---- --:--:--</span>
                </p>
                <p>
                    <strong>Lokasi Sensor:</strong> 
                    <span id="location-value">--</span>
                </p>
            </div>

        </main>

        <footer class="footer">
            <p>IoT Project Kelompok 9 - © 2025</p>
        </footer>

    </div>

    <script>
        // --- SCRIPT JAVASCRIPT (SAMA SEPERTI SEBELUMNYA) ---
        // Anda harus menyalin kembali fungsi updateData() dan fetchData() 
        // beserta variabel-variabelnya dari jawaban sebelumnya ke sini.

        const statusCard = document.getElementById('status-card');
        const statusText = document.getElementById('status-text');
        const vibrationValue = document.getElementById('vibration-value');
        const timeValue = document.getElementById('time-value');
        const locationValue = document.getElementById('location-value');

        function updateData(status, value, timeString, location) {
            vibrationValue.innerHTML = `${value} <span></span>`;
            const time = new Date(timeString);
            const formattedTime = time.toLocaleString('id-ID', {
                day: '2-digit', month: '2-digit', year: 'numeric',
                hour: '2-digit', minute: '2-digit', second: '2-digit'
            });
            timeValue.textContent = formattedTime;
            locationValue.textContent = location;
            statusText.textContent = status;
            
            statusCard.classList.remove('status-aman', 'status-waspada', 'status-bahaya');

            if (status === "AMAN") {
                statusCard.classList.add('status-aman');
            } else if (status === "WASPADA") {
                statusCard.classList.add('status-waspada');
            } else { // BAHAYA
                statusCard.classList.add('status-bahaya');
            }
        }

        async function fetchData() {
            try {
                // Panggil file data.php (Pastikan data.php sudah ada dan berjalan)
                const response = await fetch('data.php');
                if (!response.ok) {
                    throw new Error('Gagal mengambil data dari server');
                }
                
                const data = await response.json();
                
                // Panggil fungsi updateData dengan data baru dari server
                updateData(data.status, data.value, data.timestamp, data.location);

            } catch (error) {
                console.error('Terjadi kesalahan:', error);
                statusText.textContent = 'ERROR KONEKSI';
                statusCard.classList.remove('status-aman', 'status-waspada');
                statusCard.classList.add('status-bahaya');
            }
        }

        setInterval(fetchData, 3000);
        fetchData();
    </script>
</body>
</html>