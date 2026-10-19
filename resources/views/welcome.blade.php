<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Server Pembelajaran Data Siswa - Laravel 12</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #0b0f19;
            --bg-secondary: #111827;
            --bg-card: rgba(17, 24, 39, 0.75);
            --border-color: rgba(255, 255, 255, 0.08);
            --accent-primary: #6366f1;
            --accent-secondary: #ec4899;
            --accent-cyan: #06b6d4;
            --accent-green: #10b981;
            --accent-amber: #f59e0b;
            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
            --code-bg: #030712;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-primary);
            color: var(--text-main);
            line-height: 1.6;
            min-height: 100vh;
            background-image: 
                radial-gradient(circle at 15% 15%, rgba(99, 102, 241, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(236, 72, 153, 0.12) 0%, transparent 45%);
            background-attachment: fixed;
        }

        .container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem;
        }

        /* Header */
        header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .badge-status span {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 10px #10b981;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        h1 {
            font-size: 2.75rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            background: linear-gradient(135deg, #ffffff 30%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.75rem;
        }

        .subtitle {
            font-size: 1.15rem;
            color: var(--text-muted);
            max-width: 680px;
            margin: 0 auto 1.5rem auto;
        }

        .meta-tags {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .tag {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            padding: 0.35rem 0.8rem;
            border-radius: 8px;
            font-size: 0.85rem;
            color: #cbd5e1;
        }

        /* Grid Layout */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        @media (max-width: 960px) {
            .main-grid {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.75rem;
            backdrop-filter: blur(12px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
        }

        .card-title {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .card-title svg {
            width: 24px;
            height: 24px;
            color: var(--accent-primary);
        }

        /* Endpoints Table */
        .endpoints-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .endpoint-item {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 0.85rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .endpoint-item:hover {
            border-color: rgba(99, 102, 241, 0.4);
            background: rgba(99, 102, 241, 0.06);
            transform: translateX(4px);
        }

        .endpoint-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            overflow: hidden;
        }

        .method {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.2rem 0.55rem;
            border-radius: 6px;
            text-transform: uppercase;
        }

        .method-get { background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
        .method-post { background: rgba(59, 130, 246, 0.2); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); }
        .method-put { background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); }
        .method-delete { background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); }

        .endpoint-path {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9rem;
            color: #e2e8f0;
        }

        .endpoint-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-align: right;
            white-space: nowrap;
        }

        /* Tester Section */
        .tester-toolbar {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .btn {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 0.55rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn:hover {
            background: var(--accent-primary);
            border-color: var(--accent-primary);
            transform: translateY(-1px);
        }

        .btn-primary {
            background: var(--accent-primary);
            border-color: var(--accent-primary);
        }

        .btn-primary:hover {
            background: #4f46e5;
        }

        .console-box {
            background: var(--code-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.25rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            color: #38bdf8;
            max-height: 420px;
            overflow: auto;
            position: relative;
        }

        .console-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            padding-bottom: 0.5rem;
            margin-bottom: 0.75rem;
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        pre {
            white-space: pre-wrap;
            word-break: break-all;
            color: #a5f3fc;
        }

        /* Live Preview Cards Grid */
        .preview-section {
            margin-top: 1.5rem;
        }

        .students-preview {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.25rem;
            margin-top: 1.5rem;
        }

        .student-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 1.25rem;
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            transition: all 0.25s ease;
        }

        .student-card:hover {
            border-color: rgba(99, 102, 241, 0.5);
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.15);
        }

        .student-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent-primary);
            flex-shrink: 0;
        }

        .student-info h4 {
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.2rem;
        }

        .student-meta {
            font-size: 0.8rem;
            color: var(--text-muted);
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .student-badge {
            display: inline-block;
            align-self: flex-start;
            margin-top: 0.4rem;
            padding: 0.15rem 0.55rem;
            background: rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
            border-radius: 4px;
            font-size: 0.72rem;
            font-weight: 600;
        }

        /* Footer */
        footer {
            text-align: center;
            margin-top: 4rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .doc-link-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: white;
            text-decoration: none;
            padding: 0.75rem 1.75rem;
            border-radius: 10px;
            font-weight: 600;
            margin-top: 1rem;
            transition: opacity 0.2s;
        }

        .doc-link-btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header>
            <div class="badge-status">
                <span></span> API Server Online & Siap Digunakan
            </div>
            <h1>API Data Siswa SMK</h1>
            <p class="subtitle">
                Server RESTful API untuk pembelajaran siswa. Akses data siswa lengkap berformat JSON tanpa autentikasi, siap dihubungkan ke proyek web frontend Anda.
            </p>
            <div class="meta-tags">
                <span class="tag">🚀 Laravel 12</span>
                <span class="tag">🔓 Public Access (Tanpa Token/Auth)</span>
                <span class="tag">🌐 CORS Enabled (* All Origins)</span>
                <span class="tag">📦 Format: JSON Standard</span>
            </div>
            <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                <a href="#tester" class="doc-link-btn">
                    Coba Uji API Langsung (Live Tester) ↓
                </a>
                <a href="{{ url('/starter-kit/index.html') }}" class="doc-link-btn" style="background: linear-gradient(135deg, #10b981, #06b6d4);">
                    Buka Frontend Demo (Starter Kit) 🚀
                </a>
            </div>
        </header>

        <!-- Main Grid: Endpoints Documentation & Live Tester -->
        <div class="main-grid" id="tester">
            <!-- Left: Daftar Endpoint -->
            <div class="card">
                <div class="card-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Daftar Endpoint API
                </div>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.25rem;">
                    Klik salah satu endpoint di bawah untuk langsung menguji responsnya pada panel sebelah kanan:
                </p>

                <div class="endpoints-list">
                    <div class="endpoint-item" onclick="fetchApi('/api/siswas')">
                        <div class="endpoint-left">
                            <span class="method method-get">GET</span>
                            <span class="endpoint-path">/api/siswas</span>
                        </div>
                        <span class="endpoint-desc">Semua Data Siswa</span>
                    </div>

                    <div class="endpoint-item" onclick="fetchApi('/api/siswas/statistik')">
                        <div class="endpoint-left">
                            <span class="method method-get">GET</span>
                            <span class="endpoint-path">/api/siswas/statistik</span>
                        </div>
                        <span class="endpoint-desc">Statistik Dashboard</span>
                    </div>

                    <div class="endpoint-item" onclick="fetchApi('/api/siswas/1')">
                        <div class="endpoint-left">
                            <span class="method method-get">GET</span>
                            <span class="endpoint-path">/api/siswas/{id}</span>
                        </div>
                        <span class="endpoint-desc">Detail Siswa (ID: 1)</span>
                    </div>

                    <div class="endpoint-item" onclick="fetchApi('/api/siswas?jurusan=Rekayasa')">
                        <div class="endpoint-left">
                            <span class="method method-get">GET</span>
                            <span class="endpoint-path">/api/siswas?jurusan=...</span>
                        </div>
                        <span class="endpoint-desc">Filter Jurusan RPL</span>
                    </div>

                    <div class="endpoint-item" onclick="fetchApi('/api/siswas?search=Ahmad')">
                        <div class="endpoint-left">
                            <span class="method method-get">GET</span>
                            <span class="endpoint-path">/api/siswas?search=...</span>
                        </div>
                        <span class="endpoint-desc">Cari Nama/NIS</span>
                    </div>

                    <div class="endpoint-item" onclick="fetchApi('/api/siswas?per_page=3')">
                        <div class="endpoint-left">
                            <span class="method method-get">GET</span>
                            <span class="endpoint-path">/api/siswas?per_page=3</span>
                        </div>
                        <span class="endpoint-desc">Pagination Data</span>
                    </div>
                </div>
            </div>

            <!-- Right: Interactive Live Console Tester -->
            <div class="card">
                <div class="card-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    Live API Console Tester
                </div>

                <div class="tester-toolbar">
                    <button class="btn btn-primary" onclick="fetchApi('/api/siswas')">GET /siswas</button>
                    <button class="btn" onclick="fetchApi('/api/siswas/statistik')">GET /statistik</button>
                    <button class="btn" onclick="fetchApi('/api/siswas/102301002')">Cari by NIS</button>
                    <button class="btn" onclick="clearConsole()">Bersihkan</button>
                </div>

                <div class="console-box" id="console">
                    <div class="console-header">
                        <span id="request-url">STATUS: Siap menguji</span>
                        <span id="response-time">0 ms</span>
                    </div>
                    <pre id="json-output">// Klik tombol di atas atau daftar endpoint di samping untuk melihat respons JSON live.</pre>
                </div>
            </div>
        </div>

        <!-- Live Visual Cards Preview -->
        <div class="card preview-section">
            <div class="card-title">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Visual Preview Siswa (Hasil Fetch Otomatis)
            </div>
            <p style="color: var(--text-muted); font-size: 0.9rem;">
                Komponen di bawah ini dirender secara dinamis oleh JavaScript menggunakan <code>fetch('/api/siswas?all=true')</code>. Ini adalah contoh tampilan kartu yang akan dibuat oleh siswa pada Jobsheet Praktikum.
            </p>

            <div class="students-preview" id="studentsGrid">
                <!-- Siswa cards akan diisi oleh JS -->
                <div style="color: var(--text-muted); font-size: 0.9rem; padding: 1rem;">Memuat data siswa...</div>
            </div>
        </div>

        <!-- Footer -->
        <footer>
            <p><strong>Jobsheet & Dokumentasi Pembelajaran API</strong> — Disiapkan untuk Guru & Siswa SMK / Web Developer Pemula</p>
            <p style="margin-top: 0.5rem; font-size: 0.8rem; color: #64748b;">
                Base URL Server: <code>{{ url('/api') }}</code> | Endpoint Siswa: <code>{{ url('/api/siswas') }}</code>
            </p>
        </footer>
    </div>

    <script>
        async function fetchApi(endpoint) {
            const urlSpan = document.getElementById('request-url');
            const timeSpan = document.getElementById('response-time');
            const pre = document.getElementById('json-output');

            urlSpan.textContent = `FETCHING: ${endpoint}...`;
            timeSpan.textContent = '...';
            pre.textContent = '// Menghubungi server API...';

            const startTime = performance.now();
            try {
                const response = await fetch(endpoint);
                const duration = Math.round(performance.now() - startTime);
                const data = await response.json();

                urlSpan.textContent = `HTTP ${response.status} ${response.statusText} • ${endpoint}`;
                timeSpan.textContent = `${duration} ms`;
                pre.textContent = JSON.stringify(data, null, 2);
            } catch (error) {
                urlSpan.textContent = `ERROR: Gagal menghubungi API`;
                timeSpan.textContent = `0 ms`;
                pre.textContent = `// Error: ${error.message}`;
            }
        }

        function clearConsole() {
            document.getElementById('request-url').textContent = 'STATUS: Siap';
            document.getElementById('response-time').textContent = '0 ms';
            document.getElementById('json-output').textContent = '// Konsol dibersihkan.';
        }

        // Render otomatis kartu siswa saat halaman dimuat
        async function renderStudentCards() {
            const grid = document.getElementById('studentsGrid');
            try {
                const res = await fetch('/api/siswas?all=true');
                const result = await res.json();
                
                if (result.success && result.data.length > 0) {
                    grid.innerHTML = result.data.map(s => `
                        <div class="student-card">
                            <img src="${s.foto || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(s.nama)}" alt="${s.nama}" class="student-avatar" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(s.nama)}'">
                            <div class="student-info">
                                <h4>${s.nama}</h4>
                                <div class="student-meta">
                                    <span><strong>NIS:</strong> ${s.nis}</span>
                                    <span><strong>Kelas:</strong> ${s.kelas}</span>
                                    <span><strong>Kota:</strong> ${s.tempat_lahir}</span>
                                </div>
                                <span class="student-badge">${s.jurusan}</span>
                            </div>
                        </div>
                    `).join('');
                } else {
                    grid.innerHTML = '<div style="color: #f87171;">Tidak ada data siswa ditemukan.</div>';
                }
            } catch (err) {
                grid.innerHTML = `<div style="color: #f87171;">Gagal memuat preview kartu siswa: ${err.message}</div>`;
            }
        }

        // Jalankan saat load
        window.addEventListener('DOMContentLoaded', () => {
            renderStudentCards();
        });
    </script>
</body>
</html>
