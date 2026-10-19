<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi API Data Siswa - Laravel 12 RESTful API</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-body: #0b0f19;
            --bg-sidebar: #0f172a;
            --bg-card: rgba(17, 24, 39, 0.7);
            --bg-code: #030712;
            --border: rgba(255, 255, 255, 0.08);
            --border-hover: rgba(99, 102, 241, 0.4);
            --primary: #6366f1;
            --primary-glow: rgba(99, 102, 241, 0.25);
            --secondary: #ec4899;
            --cyan: #06b6d4;
            --green: #10b981;
            --amber: #f59e0b;
            --red: #ef4444;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --text-dim: #64748b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
            min-height: 100vh;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.12) 0%, transparent 35%),
                radial-gradient(circle at 90% 80%, rgba(236, 72, 153, 0.08) 0%, transparent 40%);
            background-attachment: fixed;
        }

        /* Top Navigation Bar */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(16px);
            background: rgba(11, 15, 25, 0.85);
            border-bottom: 1px solid var(--border);
            padding: 0.85rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: #fff;
            font-weight: 800;
            font-size: 1.15rem;
            letter-spacing: -0.02em;
        }

        .brand-badge {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 0.35rem 0.65rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #fff;
            box-shadow: 0 0 15px var(--primary-glow);
        }

        .nav-search {
            position: relative;
            flex: 1;
            max-width: 420px;
        }

        .nav-search input {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.5rem 1rem 0.5rem 2.4rem;
            color: #fff;
            font-size: 0.875rem;
            outline: none;
            transition: all 0.2s;
        }

        .nav-search input:focus {
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }

        .nav-search svg {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: var(--text-dim);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .nav-btn {
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            color: var(--text-muted);
            padding: 0.45rem 0.85rem;
            border-radius: 8px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .nav-btn:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.06);
        }

        .nav-btn-highlight {
            background: linear-gradient(135deg, var(--primary), #4f46e5);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-btn-highlight:hover {
            opacity: 0.95;
            transform: translateY(-1px);
        }

        /* Layout Container */
        .layout-container {
            display: flex;
            max-width: 1540px;
            margin: 0 auto;
            min-height: calc(100vh - 65px);
        }

        /* Left Sidebar */
        .sidebar {
            width: 290px;
            flex-shrink: 0;
            position: sticky;
            top: 65px;
            height: calc(100vh - 65px);
            overflow-y: auto;
            border-right: 1px solid var(--border);
            padding: 1.5rem 1rem;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
        }

        .sidebar-section-title {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-dim);
            margin: 1.25rem 0 0.5rem 0.65rem;
        }

        .sidebar-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.15s ease;
        }

        .sidebar-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(3px);
        }

        .sidebar-link.active {
            color: #fff;
            background: rgba(99, 102, 241, 0.15);
            border-left: 3px solid var(--primary);
            font-weight: 600;
        }

        /* Main Content */
        .content {
            flex: 1;
            padding: 2.5rem 3rem;
            max-width: 1250px;
            overflow-x: hidden;
        }

        @media (max-width: 1024px) {
            .sidebar {
                display: none;
            }
            .content {
                padding: 1.5rem;
            }
        }

        /* Typography & Headings */
        .hero-doc {
            margin-bottom: 2.5rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--border);
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.3);
            color: #a5b4fc;
            padding: 0.3rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        h1.doc-title {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 0.75rem;
            background: linear-gradient(135deg, #ffffff 40%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .doc-lead {
            font-size: 1.1rem;
            color: var(--text-muted);
            max-width: 820px;
            line-height: 1.7;
        }

        /* Quick Info Callout Cards */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1rem;
            margin: 1.75rem 0 2.5rem 0;
        }

        .info-box {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.25rem;
            backdrop-filter: blur(8px);
        }

        .info-box-title {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-dim);
            margin-bottom: 0.35rem;
        }

        .info-box-value {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--cyan);
            word-break: break-all;
        }

        /* Section Block */
        .doc-section {
            margin-bottom: 3.5rem;
            scroll-margin-top: 85px;
        }

        .doc-section-header {
            margin-bottom: 1.5rem;
        }

        .doc-section-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .doc-section-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-top: 0.35rem;
        }

        /* Endpoint Card */
        .endpoint-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.75rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .endpoint-card:hover {
            border-color: var(--border-hover);
            box-shadow: 0 10px 30px -10px rgba(99, 102, 241, 0.15);
        }

        .endpoint-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .endpoint-title-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .method-badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.25rem 0.65rem;
            border-radius: 6px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .method-get { background: rgba(16, 185, 129, 0.18); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
        .method-post { background: rgba(59, 130, 246, 0.18); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); }
        .method-put { background: rgba(245, 158, 11, 0.18); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); }
        .method-delete { background: rgba(239, 68, 68, 0.18); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); }

        .endpoint-url {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.05rem;
            font-weight: 600;
            color: #fff;
        }

        .copy-url-btn {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--border);
            color: var(--text-muted);
            padding: 0.3rem 0.65rem;
            border-radius: 6px;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .copy-url-btn:hover {
            color: #fff;
            background: var(--primary);
            border-color: var(--primary);
        }

        .endpoint-desc-text {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 1.25rem;
            line-height: 1.6;
        }

        /* Parameter Table */
        .param-table-wrapper {
            margin: 1.25rem 0;
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            background: rgba(3, 7, 18, 0.4);
        }

        .param-table-title {
            padding: 0.65rem 1rem;
            background: rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid var(--border);
            font-size: 0.8rem;
            font-weight: 700;
            color: #cbd5e1;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .param-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            text-align: left;
        }

        .param-table th {
            padding: 0.65rem 1rem;
            background: rgba(255, 255, 255, 0.02);
            color: var(--text-dim);
            font-weight: 600;
            border-bottom: 1px solid var(--border);
        }

        .param-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            color: var(--text-muted);
            vertical-align: top;
        }

        .param-table tr:last-child td {
            border-bottom: none;
        }

        .param-name {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 600;
            color: #f1f5f9;
        }

        .param-type {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem;
            color: var(--cyan);
            background: rgba(6, 182, 212, 0.1);
            padding: 0.15rem 0.45rem;
            border-radius: 4px;
            display: inline-block;
        }

        .param-req {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--red);
        }

        .param-opt {
            font-size: 0.75rem;
            color: var(--text-dim);
        }

        /* Code Tabs & Snippets */
        .code-tabs-wrapper {
            margin-top: 1.5rem;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            background: var(--bg-code);
        }

        .tabs-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid var(--border);
            padding: 0.25rem 0.75rem;
            overflow-x: auto;
        }

        .tabs-nav {
            display: flex;
            gap: 0.25rem;
        }

        .tab-btn {
            background: transparent;
            border: none;
            color: var(--text-dim);
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.5rem 0.85rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .tab-btn:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.04);
        }

        .tab-btn.active {
            color: #fff;
            background: rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
        }

        .tab-copy-btn {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-muted);
            padding: 0.3rem 0.65rem;
            border-radius: 6px;
            font-size: 0.75rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: all 0.2s;
        }

        .tab-copy-btn:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .code-container {
            padding: 1.25rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            line-height: 1.6;
            overflow-x: auto;
            max-height: 480px;
        }

        pre code {
            font-family: inherit;
        }

        /* Syntax Highlight Palette */
        .c-kw { color: #f43f5e; font-weight: 600; } /* keyword */
        .c-fn { color: #38bdf8; } /* function */
        .c-str { color: #34d399; } /* string */
        .c-num { color: #fbbf24; } /* number */
        .c-bool { color: #c084fc; font-weight: 600; } /* boolean */
        .c-cm { color: #64748b; font-style: italic; } /* comment */
        .c-prop { color: #93c5fd; } /* json key */

        /* Playground / Live Console */
        .playground-card {
            background: linear-gradient(145deg, rgba(17, 24, 39, 0.9), rgba(15, 23, 42, 0.8));
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 16px;
            padding: 2rem;
            backdrop-filter: blur(14px);
            box-shadow: 0 20px 45px -15px rgba(0, 0, 0, 0.7);
            margin: 2rem 0;
        }

        .playground-row {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 1.25rem;
        }

        .playground-select {
            background: #030712;
            border: 1px solid var(--border);
            color: #fff;
            padding: 0.65rem 1rem;
            border-radius: 10px;
            font-size: 0.9rem;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            outline: none;
            cursor: pointer;
        }

        .playground-select:focus {
            border-color: var(--primary);
        }

        .playground-input {
            flex: 1;
            min-width: 280px;
            background: #030712;
            border: 1px solid var(--border);
            color: #fff;
            padding: 0.65rem 1rem;
            border-radius: 10px;
            font-size: 0.9rem;
            font-family: 'JetBrains Mono', monospace;
            outline: none;
        }

        .playground-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }

        .btn-run {
            background: linear-gradient(135deg, var(--primary), #4338ca);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 0.65rem 1.5rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-run:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px var(--primary-glow);
        }

        .btn-run:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .body-editor-group {
            margin-bottom: 1.25rem;
            display: none;
        }

        .body-editor-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 0.4rem;
        }

        .body-textarea {
            width: 100%;
            height: 160px;
            background: #030712;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.85rem;
            color: #a5f3fc;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            outline: none;
            resize: vertical;
        }

        .body-textarea:focus {
            border-color: var(--primary);
        }

        .console-output-box {
            background: #030712;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .console-output-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.65rem 1rem;
            background: rgba(255, 255, 255, 0.04);
            border-bottom: 1px solid var(--border);
            font-size: 0.78rem;
            font-family: 'JetBrains Mono', monospace;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
        }

        .status-200 { background: rgba(16, 185, 129, 0.2); color: #34d399; }
        .status-400 { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }
        .status-500 { background: rgba(239, 68, 68, 0.2); color: #f87171; }

        .console-pre {
            padding: 1.25rem;
            color: #e2e8f0;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            max-height: 420px;
            overflow: auto;
            white-space: pre-wrap;
            word-break: break-all;
        }

        /* Status Codes Grid */
        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .status-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.25rem;
        }

        .status-code-num {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 0.35rem;
        }

        /* Toast notification */
        .toast {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: rgba(16, 185, 129, 0.95);
            color: #fff;
            padding: 0.75rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 100;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        /* Footer */
        footer.doc-footer {
            margin-top: 5rem;
            padding-top: 2.5rem;
            border-top: 1px solid var(--border);
            color: var(--text-dim);
            font-size: 0.875rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
    </style>
</head>
<body>

    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        <span id="toastMsg">Kode berhasil disalin ke clipboard!</span>
    </div>

    <!-- Top Navigation -->
    <nav class="navbar">
        <a href="{{ url('/') }}" class="nav-brand">
            <span class="brand-badge">API SISWA</span>
            <span>Dokumentasi Resmi</span>
        </a>

        <div class="nav-search">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" id="quickSearch" placeholder="Cari endpoint (misal: /siswas, NIS, POST, statistik)..." oninput="filterEndpoints(this.value)">
        </div>

        <div class="nav-links">
            <a href="#playground" class="nav-btn">
                🧪 Live Console
            </a>
            <a href="{{ url('/starter-kit/index.html') }}" class="nav-btn">
                🎨 Frontend Demo
            </a>
            <a href="{{ url('/') }}" class="nav-btn nav-btn-highlight">
                ← Kembali ke Beranda
            </a>
        </div>
    </nav>

    <!-- Main Docs Layout -->
    <div class="layout-container">
        <!-- Sticky Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-section-title">Memulai</div>
            <ul class="sidebar-menu">
                <li><a href="#pengantar" class="sidebar-link active">📌 Pengantar & Base URL</a></li>
                <li><a href="#autentikasi" class="sidebar-link">🔓 Autentikasi & Headers</a></li>
                <li><a href="#skema-data" class="sidebar-link">📊 Struktur Skema Data Siswa</a></li>
            </ul>

            <div class="sidebar-section-title">Endpoints Siswa</div>
            <ul class="sidebar-menu" id="endpointNavList">
                <li>
                    <a href="#endpoint-list" class="sidebar-link">
                        <span>Daftar Siswa (Filter & Search)</span>
                        <span class="method-badge method-get" style="font-size:0.65rem; padding: 0.1rem 0.35rem;">GET</span>
                    </a>
                </li>
                <li>
                    <a href="#endpoint-detail" class="sidebar-link">
                        <span>Detail Siswa (ID / NIS)</span>
                        <span class="method-badge method-get" style="font-size:0.65rem; padding: 0.1rem 0.35rem;">GET</span>
                    </a>
                </li>
                <li>
                    <a href="#endpoint-create" class="sidebar-link">
                        <span>Tambah Siswa Baru</span>
                        <span class="method-badge method-post" style="font-size:0.65rem; padding: 0.1rem 0.35rem;">POST</span>
                    </a>
                </li>
                <li>
                    <a href="#endpoint-update" class="sidebar-link">
                        <span>Update Data Siswa</span>
                        <span class="method-badge method-put" style="font-size:0.65rem; padding: 0.1rem 0.35rem;">PUT</span>
                    </a>
                </li>
                <li>
                    <a href="#endpoint-delete" class="sidebar-link">
                        <span>Hapus Data Siswa</span>
                        <span class="method-badge method-delete" style="font-size:0.65rem; padding: 0.1rem 0.35rem;">DEL</span>
                    </a>
                </li>
                <li>
                    <a href="#endpoint-stats" class="sidebar-link">
                        <span>Statistik Dashboard</span>
                        <span class="method-badge method-get" style="font-size:0.65rem; padding: 0.1rem 0.35rem;">GET</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-section-title">Alat & Contoh</div>
            <ul class="sidebar-menu">
                <li><a href="#playground" class="sidebar-link">🧪 Interactive API Console</a></li>
                <li><a href="#status-codes" class="sidebar-link">🚦 Kode Respons HTTP</a></li>
                <li><a href="#tips-praktikum" class="sidebar-link">💡 Tips Praktikum SMK</a></li>
            </ul>
        </aside>

        <!-- Main Content Area -->
        <main class="content">
            <!-- Hero -->
            <div class="hero-doc">
                <div class="hero-badge">
                    <span>✨ Laravel 12 API Documentation</span>
                </div>
                <h1 class="doc-title">Dokumentasi API Data Siswa SMK</h1>
                <p class="doc-lead">
                    Panduan lengkap, spesifikasi parameter, dan contoh kode multi-bahasa untuk mengonsumsi RESTful API Data Siswa. Didesain ramah untuk siswa SMK, guru praktikum, dan pengembang web pemula.
                </p>

                <!-- Quick Info Cards -->
                <div class="info-grid">
                    <div class="info-box">
                        <div class="info-box-title">Base URL API</div>
                        <div class="info-box-value" id="displayBaseUrl">{{ url('/api') }}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-box-title">Format Pertukaran Data</div>
                        <div class="info-box-value" style="color: #a5f3fc;">JSON (application/json)</div>
                    </div>
                    <div class="info-box">
                        <div class="info-box-title">Akses Autentikasi</div>
                        <div class="info-box-value" style="color: #34d399;">Public (Tanpa Token/Auth)</div>
                    </div>
                    <div class="info-box">
                        <div class="info-box-title">CORS Policy</div>
                        <div class="info-box-value" style="color: #c084fc;">* (Diizinkan Semua Origin)</div>
                    </div>
                </div>
            </div>

            <!-- Section 1: Pengantar -->
            <section class="doc-section" id="pengantar">
                <div class="doc-section-header">
                    <h2>📌 1. Pengantar & Konsep RESTful</h2>
                    <p>Memahami bagaimana client (frontend) berkomunikasi dengan server backend melalui protokol HTTP.</p>
                </div>
                <p style="color: var(--text-muted); margin-bottom: 1rem;">
                    REST (Representational State Transfer) API adalah standar arsitektur komunikasi web yang menggunakan metode HTTP baku untuk operasi data:
                </p>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 0.75rem; margin-bottom: 1.5rem;">
                    <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--border); padding: 0.85rem; border-radius: 10px;">
                        <span class="method-badge method-get">GET</span>
                        <div style="margin-top: 0.5rem; font-size: 0.85rem; color: #cbd5e1;"><strong>Membaca Data</strong> tanpa mengubah database.</div>
                    </div>
                    <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--border); padding: 0.85rem; border-radius: 10px;">
                        <span class="method-badge method-post">POST</span>
                        <div style="margin-top: 0.5rem; font-size: 0.85rem; color: #cbd5e1;"><strong>Membuat Data Baru</strong> di dalam database.</div>
                    </div>
                    <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--border); padding: 0.85rem; border-radius: 10px;">
                        <span class="method-badge method-put">PUT / PATCH</span>
                        <div style="margin-top: 0.5rem; font-size: 0.85rem; color: #cbd5e1;"><strong>Memperbarui Data</strong> yang sudah tersimpan.</div>
                    </div>
                    <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--border); padding: 0.85rem; border-radius: 10px;">
                        <span class="method-badge method-delete">DELETE</span>
                        <div style="margin-top: 0.5rem; font-size: 0.85rem; color: #cbd5e1;"><strong>Menghapus Data</strong> dari database.</div>
                    </div>
                </div>
            </section>

            <!-- Section 2: Autentikasi & Header -->
            <section class="doc-section" id="autentikasi">
                <div class="doc-section-header">
                    <h2>🔓 2. Autentikasi & Header HTTP</h2>
                    <p>Header yang direkomendasikan saat mengirimkan request ke server.</p>
                </div>
                <p style="color: var(--text-muted); margin-bottom: 1rem;">
                    Seluruh endpoint di bawah ini berstatus <strong>Public</strong> agar siswa dapat langsung fokus belajar melakukan <code>fetch</code> data tanpa kendala autentikasi token Bearer yang rumit.
                </p>
                <div class="param-table-wrapper">
                    <div class="param-table-title">Header HTTP yang Disarankan</div>
                    <table class="param-table">
                        <thead>
                            <tr>
                                <th>Header Key</th>
                                <th>Nilai (Value)</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="param-name">Accept</td>
                                <td><code style="color: var(--cyan);">application/json</code></td>
                                <td>Memastikan server selalu membalas respons dalam format JSON standar.</td>
                            </tr>
                            <tr>
                                <td class="param-name">Content-Type</td>
                                <td><code style="color: var(--cyan);">application/json</code></td>
                                <td>Wajib disertakan saat mengirim data payload <code>POST</code> atau <code>PUT</code>.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Section 3: Skema Data -->
            <section class="doc-section" id="skema-data">
                <div class="doc-section-header">
                    <h2>📊 3. Struktur Skema Data Siswa</h2>
                    <p>Kamus data atribut yang terdapat pada objek siswa.</p>
                </div>
                <div class="param-table-wrapper">
                    <div class="param-table-title">Atribut Entitas Siswa</div>
                    <table class="param-table">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Tipe Data</th>
                                <th>Wajib (POST)</th>
                                <th>Keterangan & Contoh</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="param-name">id</td>
                                <td><span class="param-type">integer</span></td>
                                <td><span class="param-opt">Otomatis</span></td>
                                <td>Primary Key unik auto-increment. Contoh: <code>1</code></td>
                            </tr>
                            <tr>
                                <td class="param-name">nis</td>
                                <td><span class="param-type">string(10)</span></td>
                                <td><span class="param-req">Wajib (Unik)</span></td>
                                <td>Nomor Induk Siswa. Contoh: <code>"102301001"</code></td>
                            </tr>
                            <tr>
                                <td class="param-name">nama</td>
                                <td><span class="param-type">string(100)</span></td>
                                <td><span class="param-req">Wajib</span></td>
                                <td>Nama lengkap siswa. Contoh: <code>"Ahmad Fauzi Pratama"</code></td>
                            </tr>
                            <tr>
                                <td class="param-name">jenis_kelamin</td>
                                <td><span class="param-type">enum(L,P)</span></td>
                                <td><span class="param-req">Wajib</span></td>
                                <td><code>"L"</code> (Laki-laki) atau <code>"P"</code> (Perempuan)</td>
                            </tr>
                            <tr>
                                <td class="param-name">tempat_lahir</td>
                                <td><span class="param-type">string(100)</span></td>
                                <td><span class="param-req">Wajib</span></td>
                                <td>Kota kelahiran. Contoh: <code>"Surabaya"</code></td>
                            </tr>
                            <tr>
                                <td class="param-name">tanggal_lahir</td>
                                <td><span class="param-type">date</span></td>
                                <td><span class="param-req">Wajib</span></td>
                                <td>Format standar: <code>"YYYY-MM-DD"</code>. Contoh: <code>"2007-04-12"</code></td>
                            </tr>
                            <tr>
                                <td class="param-name">agama</td>
                                <td><span class="param-type">string(30)</span></td>
                                <td><span class="param-req">Wajib</span></td>
                                <td>Contoh: <code>"Islam"</code>, <code>"Kristen"</code>, <code>"Katolik"</code></td>
                            </tr>
                            <tr>
                                <td class="param-name">alamat</td>
                                <td><span class="param-type">text</span></td>
                                <td><span class="param-req">Wajib</span></td>
                                <td>Alamat domisili lengkap siswa.</td>
                            </tr>
                            <tr>
                                <td class="param-name">no_telp</td>
                                <td><span class="param-type">string(15)</span></td>
                                <td><span class="param-opt">Opsional</span></td>
                                <td>Nomor WhatsApp/HP. Contoh: <code>"081234567801"</code></td>
                            </tr>
                            <tr>
                                <td class="param-name">email</td>
                                <td><span class="param-type">string(100)</span></td>
                                <td><span class="param-opt">Opsional</span></td>
                                <td>Email siswa. Contoh: <code>"ahmad.fauzi@smk.sch.id"</code></td>
                            </tr>
                            <tr>
                                <td class="param-name">kelas</td>
                                <td><span class="param-type">string(10)</span></td>
                                <td><span class="param-req">Wajib</span></td>
                                <td>Tingkat kelas. Contoh: <code>"XII RPL 1"</code>, <code>"XI TKJ 2"</code></td>
                            </tr>
                            <tr>
                                <td class="param-name">jurusan</td>
                                <td><span class="param-type">string(100)</span></td>
                                <td><span class="param-req">Wajib</span></td>
                                <td>Contoh: <code>"Rekayasa Perangkat Lunak"</code></td>
                            </tr>
                            <tr>
                                <td class="param-name">tahun_masuk</td>
                                <td><span class="param-type">digits(4)</span></td>
                                <td><span class="param-req">Wajib</span></td>
                                <td>Tahun masuk sekolah. Contoh: <code>2023</code></td>
                            </tr>
                            <tr>
                                <td class="param-name">status</td>
                                <td><span class="param-type">enum</span></td>
                                <td><span class="param-opt">Default: aktif</span></td>
                                <td>Pilihan: <code>aktif</code>, <code>tidak_aktif</code>, <code>lulus</code>, <code>keluar</code></td>
                            </tr>
                            <tr>
                                <td class="param-name">foto</td>
                                <td><span class="param-type">url</span></td>
                                <td><span class="param-opt">Opsional</span></td>
                                <td>URL gambar avatar siswa (otomatis di-generate jika kosong).</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- ================= ENDPOINTS SECTION ================= -->
            <div class="doc-section-header" style="margin-top: 3rem;">
                <h2>🚀 4. Daftar Endpoint API & Contoh Pemanggilan</h2>
                <p>Klik tab bahasa pemrograman untuk melihat contoh pemanggilan menggunakan Fetch JS, Axios, cURL, Python, dan PHP.</p>
            </div>

            <!-- Endpoint 1: GET /api/siswas -->
            <div class="endpoint-card" id="endpoint-list">
                <div class="endpoint-header">
                    <div class="endpoint-title-group">
                        <span class="method-badge method-get">GET</span>
                        <span class="endpoint-url">/api/siswas</span>
                    </div>
                    <button class="copy-url-btn" onclick="copySnippet('{{ url('/api/siswas') }}')">Salin URL 📋</button>
                </div>
                <div class="endpoint-desc-text">
                    Mengambil daftar data siswa. Dilengkapi fitur <strong>Pencarian</strong> (nama/nis), <strong>Filter</strong> (jurusan, kelas, jenis kelamin), <strong>Sorting</strong>, dan <strong>Pagination</strong> atau ambil semua sekaligus dengan <code>?all=true</code>.
                </div>

                <!-- Query Parameters -->
                <div class="param-table-wrapper">
                    <div class="param-table-title">Query Parameters (Opsional)</div>
                    <table class="param-table">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Tipe</th>
                                <th>Default</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="param-name">all</td>
                                <td><span class="param-type">boolean</span></td>
                                <td>false</td>
                                <td>Jika <code>true</code>, mengambil seluruh data tanpa batas pagination (sangat cocok untuk tabel frontend).</td>
                            </tr>
                            <tr>
                                <td class="param-name">search</td>
                                <td><span class="param-type">string</span></td>
                                <td>-</td>
                                <td>Mencari nama atau NIS siswa. Contoh: <code>?search=Fauzi</code></td>
                            </tr>
                            <tr>
                                <td class="param-name">jurusan</td>
                                <td><span class="param-type">string</span></td>
                                <td>-</td>
                                <td>Filter siswa berdasarkan jurusan. Contoh: <code>?jurusan=Rekayasa</code></td>
                            </tr>
                            <tr>
                                <td class="param-name">kelas</td>
                                <td><span class="param-type">string</span></td>
                                <td>-</td>
                                <td>Filter berdasarkan kelas. Contoh: <code>?kelas=XII RPL 1</code></td>
                            </tr>
                            <tr>
                                <td class="param-name">jenis_kelamin</td>
                                <td><span class="param-type">string</span></td>
                                <td>-</td>
                                <td>Filter berdasarkan jenis kelamin: <code>L</code> atau <code>P</code></td>
                            </tr>
                            <tr>
                                <td class="param-name">per_page</td>
                                <td><span class="param-type">integer</span></td>
                                <td>10</td>
                                <td>Jumlah data per halaman untuk pagination.</td>
                            </tr>
                            <tr>
                                <td class="param-name">page</td>
                                <td><span class="param-type">integer</span></td>
                                <td>1</td>
                                <td>Nomor halaman aktif.</td>
                            </tr>
                            <tr>
                                <td class="param-name">sort_by</td>
                                <td><span class="param-type">string</span></td>
                                <td>id</td>
                                <td>Kolom pengurutan: <code>id</code>, <code>nis</code>, <code>nama</code>, <code>kelas</code>, <code>tahun_masuk</code></td>
                            </tr>
                            <tr>
                                <td class="param-name">sort_order</td>
                                <td><span class="param-type">string</span></td>
                                <td>asc</td>
                                <td>Arah pengurutan: <code>asc</code> (naik) atau <code>desc</code> (turun)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Code Tabs -->
                <div class="code-tabs-wrapper">
                    <div class="tabs-header">
                        <div class="tabs-nav" id="tabs-get-list">
                            <button class="tab-btn active" onclick="switchTab(this, 'c-get-fetch')">JavaScript (Fetch)</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-get-axios')">Axios</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-get-curl')">cURL</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-get-python')">Python</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-get-php')">PHP</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-get-response')" style="color: #34d399;">Contoh Response (JSON)</button>
                        </div>
                        <button class="tab-copy-btn" onclick="copyActiveCode('tabs-get-list')">Salin Kode 📋</button>
                    </div>

                    <div class="code-container">
<!-- FETCH -->
<pre id="c-get-fetch"><code><span class="c-cm">// Mengambil seluruh data siswa untuk tabel web</span>
<span class="c-kw">async function</span> <span class="c-fn">ambilDataSiswa</span>() {
  <span class="c-kw">try</span> {
    <span class="c-kw">const</span> response = <span class="c-kw">await</span> <span class="c-fn">fetch</span>(<span class="c-str">'{{ url('/api/siswas?all=true') }}'</span>, {
      method: <span class="c-str">'GET'</span>,
      headers: { <span class="c-str">'Accept'</span>: <span class="c-str">'application/json'</span> }
    });
    <span class="c-kw">const</span> result = <span class="c-kw">await</span> response.<span class="c-fn">json</span>();
    
    <span class="c-kw">if</span> (result.success) {
      console.<span class="c-fn">log</span>(<span class="c-str">'Total siswa:'</span>, result.total);
      console.<span class="c-fn">log</span>(<span class="c-str">'Daftar siswa:'</span>, result.data);
    }
  } <span class="c-kw">catch</span> (error) {
    console.<span class="c-fn">error</span>(<span class="c-str">'Gagal memuat siswa:'</span>, error);
  }
}

<span class="c-fn">ambilDataSiswa</span>();</code></pre>

<!-- AXIOS -->
<pre id="c-get-axios" style="display:none;"><code><span class="c-cm">// Menggunakan Axios dengan parameter filter</span>
axios.<span class="c-fn">get</span>(<span class="c-str">'{{ url('/api/siswas') }}'</span>, {
  params: {
    search: <span class="c-str">'Ahmad'</span>,
    jurusan: <span class="c-str">'Rekayasa Perangkat Lunak'</span>,
    all: <span class="c-bool">true</span>
  }
})
.<span class="c-fn">then</span>(response => {
  console.<span class="c-fn">log</span>(<span class="c-str">'Data Siswa:'</span>, response.data.data);
})
.<span class="c-fn">catch</span>(err => console.<span class="c-fn">error</span>(err));</code></pre>

<!-- CURL -->
<pre id="c-get-curl" style="display:none;"><code>curl -X GET <span class="c-str">"{{ url('/api/siswas?all=true') }}"</span> \
  -H <span class="c-str">"Accept: application/json"</span></code></pre>

<!-- PYTHON -->
<pre id="c-get-python" style="display:none;"><code><span class="c-kw">import</span> requests

url = <span class="c-str">"{{ url('/api/siswas') }}"</span>
params = {<span class="c-str">"all"</span>: <span class="c-str">"true"</span>}

response = requests.<span class="c-fn">get</span>(url, params=params)
data = response.<span class="c-fn">json</span>()

<span class="c-kw">if</span> data.<span class="c-fn">get</span>(<span class="c-str">"success"</span>):
    <span class="c-kw">for</span> siswa <span class="c-kw">in</span> data[<span class="c-str">"data"</span>]:
        <span class="c-fn">print</span>(f<span class="c-str">"{siswa['nis']} - {siswa['nama']} ({siswa['jurusan']})"</span>)</code></pre>

<!-- PHP -->
<pre id="c-get-php" style="display:none;"><code><span class="c-cm">&lt;?php</span>
<span class="c-kw">$url</span> = <span class="c-str">'{{ url('/api/siswas?all=true') }}'</span>;
<span class="c-kw">$response</span> = <span class="c-fn">file_get_contents</span>(<span class="c-kw">$url</span>);
<span class="c-kw">$data</span> = <span class="c-fn">json_decode</span>(<span class="c-kw">$response</span>, <span class="c-bool">true</span>);

<span class="c-kw">if</span> (<span class="c-kw">$data</span>[<span class="c-str">'success'</span>]) {
    <span class="c-kw">foreach</span> (<span class="c-kw">$data</span>[<span class="c-str">'data'</span>] <span class="c-kw">as</span> <span class="c-kw">$siswa</span>) {
        <span class="c-kw">echo</span> <span class="c-kw">$siswa</span>[<span class="c-str">'nama'</span>] . <span class="c-str">" - "</span> . <span class="c-kw">$siswa</span>[<span class="c-str">'kelas'</span>] . PHP_EOL;
    }
}
<span class="c-cm">?&gt;</span></code></pre>

<!-- RESPONSE -->
<pre id="c-get-response" style="display:none;"><code>{
  <span class="c-prop">"success"</span>: <span class="c-bool">true</span>,
  <span class="c-prop">"message"</span>: <span class="c-str">"Daftar semua data siswa berhasil diambil"</span>,
  <span class="c-prop">"total"</span>: <span class="c-num">12</span>,
  <span class="c-prop">"data"</span>: [
    {
      <span class="c-prop">"id"</span>: <span class="c-num">1</span>,
      <span class="c-prop">"nis"</span>: <span class="c-str">"102301001"</span>,
      <span class="c-prop">"nama"</span>: <span class="c-str">"Ahmad Fauzi Pratama"</span>,
      <span class="c-prop">"jenis_kelamin"</span>: <span class="c-str">"L"</span>,
      <span class="c-prop">"tempat_lahir"</span>: <span class="c-str">"Surabaya"</span>,
      <span class="c-prop">"tanggal_lahir"</span>: <span class="c-str">"2007-04-12"</span>,
      <span class="c-prop">"agama"</span>: <span class="c-str">"Islam"</span>,
      <span class="c-prop">"alamat"</span>: <span class="c-str">"Jl. Ketintang No. 45, Surabaya"</span>,
      <span class="c-prop">"no_telp"</span>: <span class="c-str">"081234567801"</span>,
      <span class="c-prop">"email"</span>: <span class="c-str">"ahmad.fauzi@smk.sch.id"</span>,
      <span class="c-prop">"kelas"</span>: <span class="c-str">"XII RPL 1"</span>,
      <span class="c-prop">"jurusan"</span>: <span class="c-str">"Rekayasa Perangkat Lunak"</span>,
      <span class="c-prop">"tahun_masuk"</span>: <span class="c-num">2023</span>,
      <span class="c-prop">"status"</span>: <span class="c-str">"aktif"</span>,
      <span class="c-prop">"foto"</span>: <span class="c-str">"https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=400"</span>
    }
  ]
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Endpoint 2: GET /api/siswas/{id} -->
            <div class="endpoint-card" id="endpoint-detail">
                <div class="endpoint-header">
                    <div class="endpoint-title-group">
                        <span class="method-badge method-get">GET</span>
                        <span class="endpoint-url">/api/siswas/{id}</span>
                    </div>
                    <button class="copy-url-btn" onclick="copySnippet('{{ url('/api/siswas/1') }}')">Salin URL 📋</button>
                </div>
                <div class="endpoint-desc-text">
                    Mencari dan menampilkan detail profil satu siswa. Parameter <code>{id}</code> sangat fleksibel: dapat berupa <strong>ID numerik database (contoh: <code>1</code>)</strong> ATAU <strong>Nomor Induk Siswa (NIS, contoh: <code>102301001</code>)</strong>!
                </div>

                <div class="param-table-wrapper">
                    <div class="param-table-title">Path Parameters</div>
                    <table class="param-table">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="param-name">id</td>
                                <td><span class="param-type">string | integer</span></td>
                                <td><span class="param-req">Wajib</span></td>
                                <td>ID Record (misal: <code>1</code>) atau Nomor Induk Siswa (misal: <code>102301002</code>).</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Code Tabs -->
                <div class="code-tabs-wrapper">
                    <div class="tabs-header">
                        <div class="tabs-nav" id="tabs-get-detail">
                            <button class="tab-btn active" onclick="switchTab(this, 'c-detail-fetch')">JavaScript (Fetch)</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-detail-curl')">cURL</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-detail-response')" style="color: #34d399;">Contoh Response 200</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-detail-404')" style="color: #f87171;">Contoh 404 (Not Found)</button>
                        </div>
                        <button class="tab-copy-btn" onclick="copyActiveCode('tabs-get-detail')">Salin Kode 📋</button>
                    </div>

                    <div class="code-container">
<!-- FETCH -->
<pre id="c-detail-fetch"><code><span class="c-cm">// Cari siswa berdasarkan NIS atau ID</span>
<span class="c-kw">async function</span> <span class="c-fn">ambilDetailSiswa</span>(identifier) {
  <span class="c-kw">const</span> response = <span class="c-kw">await</span> <span class="c-fn">fetch</span>(<span class="c-str">`{{ url('/api/siswas') }}/${identifier}`</span>);
  
  <span class="c-kw">if</span> (response.status === <span class="c-num">404</span>) {
    alert(<span class="c-str">'Siswa tidak ditemukan!'</span>);
    <span class="c-kw">return</span>;
  }
  
  <span class="c-kw">const</span> result = <span class="c-kw">await</span> response.<span class="c-fn">json</span>();
  console.<span class="c-fn">log</span>(<span class="c-str">'Biodata Siswa:'</span>, result.data);
}

<span class="c-fn">ambilDetailSiswa</span>(<span class="c-str">'102301001'</span>); <span class="c-cm">// Menggunakan NIS</span></code></pre>

<!-- CURL -->
<pre id="c-detail-curl" style="display:none;"><code>curl -X GET <span class="c-str">"{{ url('/api/siswas/102301001') }}"</span> \
  -H <span class="c-str">"Accept: application/json"</span></code></pre>

<!-- RESPONSE 200 -->
<pre id="c-detail-response" style="display:none;"><code>{
  <span class="c-prop">"success"</span>: <span class="c-bool">true</span>,
  <span class="c-prop">"message"</span>: <span class="c-str">"Detail data siswa berhasil ditemukan"</span>,
  <span class="c-prop">"data"</span>: {
    <span class="c-prop">"id"</span>: <span class="c-num">1</span>,
    <span class="c-prop">"nis"</span>: <span class="c-str">"102301001"</span>,
    <span class="c-prop">"nama"</span>: <span class="c-str">"Ahmad Fauzi Pratama"</span>,
    <span class="c-prop">"jenis_kelamin"</span>: <span class="c-str">"L"</span>,
    <span class="c-prop">"tempat_lahir"</span>: <span class="c-str">"Surabaya"</span>,
    <span class="c-prop">"tanggal_lahir"</span>: <span class="c-str">"2007-04-12"</span>,
    <span class="c-prop">"agama"</span>: <span class="c-str">"Islam"</span>,
    <span class="c-prop">"alamat"</span>: <span class="c-str">"Jl. Ketintang No. 45, Surabaya"</span>,
    <span class="c-prop">"no_telp"</span>: <span class="c-str">"081234567801"</span>,
    <span class="c-prop">"email"</span>: <span class="c-str">"ahmad.fauzi@smk.sch.id"</span>,
    <span class="c-prop">"kelas"</span>: <span class="c-str">"XII RPL 1"</span>,
    <span class="c-prop">"jurusan"</span>: <span class="c-str">"Rekayasa Perangkat Lunak"</span>,
    <span class="c-prop">"tahun_masuk"</span>: <span class="c-num">2023</span>,
    <span class="c-prop">"status"</span>: <span class="c-str">"aktif"</span>,
    <span class="c-prop">"foto"</span>: <span class="c-str">"https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=400"</span>
  }
}</code></pre>

<!-- RESPONSE 404 -->
<pre id="c-detail-404" style="display:none;"><code>{
  <span class="c-prop">"success"</span>: <span class="c-bool">false</span>,
  <span class="c-prop">"message"</span>: <span class="c-str">"Data siswa tidak ditemukan"</span>
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Endpoint 3: POST /api/siswas -->
            <div class="endpoint-card" id="endpoint-create">
                <div class="endpoint-header">
                    <div class="endpoint-title-group">
                        <span class="method-badge method-post">POST</span>
                        <span class="endpoint-url">/api/siswas</span>
                    </div>
                    <button class="copy-url-btn" onclick="copySnippet('{{ url('/api/siswas') }}')">Salin URL 📋</button>
                </div>
                <div class="endpoint-desc-text">
                    Menambahkan data siswa baru ke dalam sistem. Wajib menyertakan Header <code>Content-Type: application/json</code> dan payload JSON body yang valid.
                </div>

                <!-- Code Tabs -->
                <div class="code-tabs-wrapper">
                    <div class="tabs-header">
                        <div class="tabs-nav" id="tabs-post-create">
                            <button class="tab-btn active" onclick="switchTab(this, 'c-post-fetch')">JavaScript (Fetch)</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-post-axios')">Axios</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-post-curl')">cURL</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-post-python')">Python</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-post-res201')" style="color: #34d399;">Response 201 (Created)</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-post-res422')" style="color: #fbbf24;">Response 422 (Validasi)</button>
                        </div>
                        <button class="tab-copy-btn" onclick="copyActiveCode('tabs-post-create')">Salin Kode 📋</button>
                    </div>

                    <div class="code-container">
<!-- FETCH POST -->
<pre id="c-post-fetch"><code><span class="c-kw">const</span> dataBaru = {
  nis: <span class="c-str">"102301099"</span>,
  nama: <span class="c-str">"Budi Pratama Santoso"</span>,
  jenis_kelamin: <span class="c-str">"L"</span>,
  tempat_lahir: <span class="c-str">"Malang"</span>,
  tanggal_lahir: <span class="c-str">"2007-08-20"</span>,
  agama: <span class="c-str">"Islam"</span>,
  alamat: <span class="c-str">"Jl. Soekarno Hatta No. 88, Malang"</span>,
  no_telp: <span class="c-str">"081299887766"</span>,
  email: <span class="c-str">"budi.santoso@smk.sch.id"</span>,
  kelas: <span class="c-str">"XII RPL 1"</span>,
  jurusan: <span class="c-str">"Rekayasa Perangkat Lunak"</span>,
  tahun_masuk: <span class="c-num">2023</span>,
  status: <span class="c-str">"aktif"</span>
};

<span class="c-fn">fetch</span>(<span class="c-str">'{{ url('/api/siswas') }}'</span>, {
  method: <span class="c-str">'POST'</span>,
  headers: {
    <span class="c-str">'Content-Type'</span>: <span class="c-str">'application/json'</span>,
    <span class="c-str">'Accept'</span>: <span class="c-str">'application/json'</span>
  },
  body: JSON.<span class="c-fn">stringify</span>(dataBaru)
})
.<span class="c-fn">then</span>(res => res.<span class="c-fn">json</span>())
.<span class="c-fn">then</span>(result => {
  <span class="c-kw">if</span> (result.success) {
    alert(<span class="c-str">'Siswa berhasil didaftarkan! ID: '</span> + result.data.id);
  } <span class="c-kw">else</span> {
    console.<span class="c-fn">error</span>(<span class="c-str">'Error Validasi:'</span>, result.errors);
  }
});</code></pre>

<!-- AXIOS POST -->
<pre id="c-post-axios" style="display:none;"><code>axios.<span class="c-fn">post</span>(<span class="c-str">'{{ url('/api/siswas') }}'</span>, {
  nis: <span class="c-str">"102301099"</span>,
  nama: <span class="c-str">"Budi Pratama Santoso"</span>,
  jenis_kelamin: <span class="c-str">"L"</span>,
  tempat_lahir: <span class="c-str">"Malang"</span>,
  tanggal_lahir: <span class="c-str">"2007-08-20"</span>,
  agama: <span class="c-str">"Islam"</span>,
  alamat: <span class="c-str">"Jl. Soekarno Hatta No. 88, Malang"</span>,
  kelas: <span class="c-str">"XII RPL 1"</span>,
  jurusan: <span class="c-str">"Rekayasa Perangkat Lunak"</span>,
  tahun_masuk: <span class="c-num">2023</span>
})
.<span class="c-fn">then</span>(response => console.<span class="c-fn">log</span>(<span class="c-str">'Sukses:'</span>, response.data))
.<span class="c-fn">catch</span>(err => console.<span class="c-fn">error</span>(<span class="c-str">'Error:'</span>, err.response.data));</code></pre>

<!-- CURL POST -->
<pre id="c-post-curl" style="display:none;"><code>curl -X POST <span class="c-str">"{{ url('/api/siswas') }}"</span> \
  -H <span class="c-str">"Content-Type: application/json"</span> \
  -H <span class="c-str">"Accept: application/json"</span> \
  -d <span class="c-str">'{
    "nis": "102301099",
    "nama": "Budi Pratama",
    "jenis_kelamin": "L",
    "tempat_lahir": "Malang",
    "tanggal_lahir": "2007-08-20",
    "agama": "Islam",
    "alamat": "Jl. Soekarno Hatta No. 88",
    "kelas": "XII RPL 1",
    "jurusan": "Rekayasa Perangkat Lunak",
    "tahun_masuk": 2023
  }'</span></code></pre>

<!-- PYTHON POST -->
<pre id="c-post-python" style="display:none;"><code><span class="c-kw">import</span> requests

payload = {
    <span class="c-str">"nis"</span>: <span class="c-str">"102301099"</span>,
    <span class="c-str">"nama"</span>: <span class="c-str">"Budi Pratama"</span>,
    <span class="c-str">"jenis_kelamin"</span>: <span class="c-str">"L"</span>,
    <span class="c-str">"tempat_lahir"</span>: <span class="c-str">"Malang"</span>,
    <span class="c-str">"tanggal_lahir"</span>: <span class="c-str">"2007-08-20"</span>,
    <span class="c-str">"agama"</span>: <span class="c-str">"Islam"</span>,
    <span class="c-str">"alamat"</span>: <span class="c-str">"Jl. Soekarno Hatta No. 88"</span>,
    <span class="c-str">"kelas"</span>: <span class="c-str">"XII RPL 1"</span>,
    <span class="c-str">"jurusan"</span>: <span class="c-str">"Rekayasa Perangkat Lunak"</span>,
    <span class="c-str">"tahun_masuk"</span>: <span class="c-num">2023</span>
}

res = requests.<span class="c-fn">post</span>(<span class="c-str">"{{ url('/api/siswas') }}"</span>, json=payload)
<span class="c-fn">print</span>(res.<span class="c-fn">status_code</span>, res.<span class="c-fn">json</span>())</code></pre>

<!-- RES 201 -->
<pre id="c-post-res201" style="display:none;"><code>{
  <span class="c-prop">"success"</span>: <span class="c-bool">true</span>,
  <span class="c-prop">"message"</span>: <span class="c-str">"Data siswa berhasil ditambahkan"</span>,
  <span class="c-prop">"data"</span>: {
    <span class="c-prop">"id"</span>: <span class="c-num">13</span>,
    <span class="c-prop">"nis"</span>: <span class="c-str">"102301099"</span>,
    <span class="c-prop">"nama"</span>: <span class="c-str">"Budi Pratama Santoso"</span>,
    <span class="c-prop">"jenis_kelamin"</span>: <span class="c-str">"L"</span>,
    <span class="c-prop">"tempat_lahir"</span>: <span class="c-str">"Malang"</span>,
    <span class="c-prop">"tanggal_lahir"</span>: <span class="c-str">"2007-08-20"</span>,
    <span class="c-prop">"agama"</span>: <span class="c-str">"Islam"</span>,
    <span class="c-prop">"alamat"</span>: <span class="c-str">"Jl. Soekarno Hatta No. 88, Malang"</span>,
    <span class="c-prop">"kelas"</span>: <span class="c-str">"XII RPL 1"</span>,
    <span class="c-prop">"jurusan"</span>: <span class="c-str">"Rekayasa Perangkat Lunak"</span>,
    <span class="c-prop">"tahun_masuk"</span>: <span class="c-num">2023</span>,
    <span class="c-prop">"status"</span>: <span class="c-str">"aktif"</span>,
    <span class="c-prop">"foto"</span>: <span class="c-str">"https://ui-avatars.com/api/?name=Budi+Pratama+Santoso&background=4f46e5&color=fff&size=256"</span>
  }
}</code></pre>

<!-- RES 422 -->
<pre id="c-post-res422" style="display:none;"><code>{
  <span class="c-prop">"success"</span>: <span class="c-bool">false</span>,
  <span class="c-prop">"message"</span>: <span class="c-str">"Validasi data gagal"</span>,
  <span class="c-prop">"errors"</span>: {
    <span class="c-prop">"nis"</span>: [
      <span class="c-str">"NIS sudah terdaftar dalam sistem"</span>
    ],
    <span class="c-prop">"nama"</span>: [
      <span class="c-str">"Nama lengkap siswa wajib diisi"</span>
    ]
  }
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Endpoint 4: PUT /api/siswas/{id} -->
            <div class="endpoint-card" id="endpoint-update">
                <div class="endpoint-header">
                    <div class="endpoint-title-group">
                        <span class="method-badge method-put">PUT</span>
                        <span class="endpoint-url">/api/siswas/{id}</span>
                    </div>
                    <button class="copy-url-btn" onclick="copySnippet('{{ url('/api/siswas/1') }}')">Salin URL 📋</button>
                </div>
                <div class="endpoint-desc-text">
                    Memperbarui data siswa yang ada. Masukkan <code>{id}</code> atau NIS siswa pada URL, dan kirimkan field data yang ingin diperbarui dalam format JSON.
                </div>

                <div class="code-tabs-wrapper">
                    <div class="tabs-header">
                        <div class="tabs-nav" id="tabs-put-update">
                            <button class="tab-btn active" onclick="switchTab(this, 'c-put-fetch')">JavaScript (Fetch)</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-put-curl')">cURL</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-put-response')" style="color: #34d399;">Contoh Response 200</button>
                        </div>
                        <button class="tab-copy-btn" onclick="copyActiveCode('tabs-put-update')">Salin Kode 📋</button>
                    </div>

                    <div class="code-container">
<!-- FETCH PUT -->
<pre id="c-put-fetch"><code><span class="c-kw">const</span> updateData = {
  alamat: <span class="c-str">"Jl. Raya Darmo No. 120, Surabaya"</span>,
  no_telp: <span class="c-str">"081299998888"</span>,
  status: <span class="c-str">"lulus"</span>
};

<span class="c-fn">fetch</span>(<span class="c-str">'{{ url('/api/siswas/1') }}'</span>, {
  method: <span class="c-str">'PUT'</span>,
  headers: {
    <span class="c-str">'Content-Type'</span>: <span class="c-str">'application/json'</span>,
    <span class="c-str">'Accept'</span>: <span class="c-str">'application/json'</span>
  },
  body: JSON.<span class="c-fn">stringify</span>(updateData)
})
.<span class="c-fn">then</span>(res => res.<span class="c-fn">json</span>())
.<span class="c-fn">then</span>(result => {
  console.<span class="c-fn">log</span>(<span class="c-str">'Data diperbarui:'</span>, result.data);
});</code></pre>

<!-- CURL PUT -->
<pre id="c-put-curl" style="display:none;"><code>curl -X PUT <span class="c-str">"{{ url('/api/siswas/1') }}"</span> \
  -H <span class="c-str">"Content-Type: application/json"</span> \
  -H <span class="c-str">"Accept: application/json"</span> \
  -d <span class="c-str">'{
    "alamat": "Jl. Raya Darmo No. 120, Surabaya",
    "status": "lulus"
  }'</span></code></pre>

<!-- RES PUT -->
<pre id="c-put-response" style="display:none;"><code>{
  <span class="c-prop">"success"</span>: <span class="c-bool">true</span>,
  <span class="c-prop">"message"</span>: <span class="c-str">"Data siswa berhasil diperbarui"</span>,
  <span class="c-prop">"data"</span>: {
    <span class="c-prop">"id"</span>: <span class="c-num">1</span>,
    <span class="c-prop">"nis"</span>: <span class="c-str">"102301001"</span>,
    <span class="c-prop">"nama"</span>: <span class="c-str">"Ahmad Fauzi Pratama"</span>,
    <span class="c-prop">"alamat"</span>: <span class="c-str">"Jl. Raya Darmo No. 120, Surabaya"</span>,
    <span class="c-prop">"status"</span>: <span class="c-str">"lulus"</span>
  }
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Endpoint 5: DELETE /api/siswas/{id} -->
            <div class="endpoint-card" id="endpoint-delete">
                <div class="endpoint-header">
                    <div class="endpoint-title-group">
                        <span class="method-badge method-delete">DELETE</span>
                        <span class="endpoint-url">/api/siswas/{id}</span>
                    </div>
                    <button class="copy-url-btn" onclick="copySnippet('{{ url('/api/siswas/1') }}')">Salin URL 📋</button>
                </div>
                <div class="endpoint-desc-text">
                    Menghapus satu data siswa dari database secara permanen berdasarkan ID atau NIS.
                </div>

                <div class="code-tabs-wrapper">
                    <div class="tabs-header">
                        <div class="tabs-nav" id="tabs-delete">
                            <button class="tab-btn active" onclick="switchTab(this, 'c-del-fetch')">JavaScript (Fetch)</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-del-curl')">cURL</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-del-response')" style="color: #34d399;">Contoh Response 200</button>
                        </div>
                        <button class="tab-copy-btn" onclick="copyActiveCode('tabs-delete')">Salin Kode 📋</button>
                    </div>

                    <div class="code-container">
<!-- FETCH DEL -->
<pre id="c-del-fetch"><code><span class="c-kw">async function</span> <span class="c-fn">hapusSiswa</span>(id) {
  <span class="c-kw">if</span> (!confirm(<span class="c-str">'Yakin ingin menghapus siswa ini?'</span>)) <span class="c-kw">return</span>;
  
  <span class="c-kw">const</span> response = <span class="c-kw">await</span> <span class="c-fn">fetch</span>(<span class="c-str">`{{ url('/api/siswas') }}/${id}`</span>, {
    method: <span class="c-str">'DELETE'</span>,
    headers: { <span class="c-str">'Accept'</span>: <span class="c-str">'application/json'</span> }
  });
  <span class="c-kw">const</span> result = <span class="c-kw">await</span> response.<span class="c-fn">json</span>();
  alert(result.message);
}

<span class="c-fn">hapusSiswa</span>(<span class="c-num">1</span>);</code></pre>

<!-- CURL DEL -->
<pre id="c-del-curl" style="display:none;"><code>curl -X DELETE <span class="c-str">"{{ url('/api/siswas/1') }}"</span> \
  -H <span class="c-str">"Accept: application/json"</span></code></pre>

<!-- RES DEL -->
<pre id="c-del-response" style="display:none;"><code>{
  <span class="c-prop">"success"</span>: <span class="c-bool">true</span>,
  <span class="c-prop">"message"</span>: <span class="c-str">"Data siswa berhasil dihapus"</span>
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Endpoint 6: GET /api/siswas/statistik -->
            <div class="endpoint-card" id="endpoint-stats">
                <div class="endpoint-header">
                    <div class="endpoint-title-group">
                        <span class="method-badge method-get">GET</span>
                        <span class="endpoint-url">/api/siswas/statistik</span>
                    </div>
                    <button class="copy-url-btn" onclick="copySnippet('{{ url('/api/siswas/statistik') }}')">Salin URL 📋</button>
                </div>
                <div class="endpoint-desc-text">
                    Menyediakan rekap agregasi data untuk komponen Dashboard / Widget praktikum: jumlah total siswa, rasio jenis kelamin (laki-laki / perempuan), pengelompokan per jurusan, dan pengelompokan per kelas.
                </div>

                <div class="code-tabs-wrapper">
                    <div class="tabs-header">
                        <div class="tabs-nav" id="tabs-stats">
                            <button class="tab-btn active" onclick="switchTab(this, 'c-stat-fetch')">JavaScript (Fetch)</button>
                            <button class="tab-btn" onclick="switchTab(this, 'c-stat-response')" style="color: #34d399;">Contoh Response JSON</button>
                        </div>
                        <button class="tab-copy-btn" onclick="copyActiveCode('tabs-stats')">Salin Kode 📋</button>
                    </div>

                    <div class="code-container">
<pre id="c-stat-fetch"><code><span class="c-fn">fetch</span>(<span class="c-str">'{{ url('/api/siswas/statistik') }}'</span>)
  .<span class="c-fn">then</span>(res => res.<span class="c-fn">json</span>())
  .<span class="c-fn">then</span>(result => {
    <span class="c-kw">const</span> stats = result.data;
    console.<span class="c-fn">log</span>(<span class="c-str">'Total Siswa:'</span>, stats.total_siswa);
    console.<span class="c-fn">log</span>(<span class="c-str">'Laki-laki:'</span>, stats.jenis_kelamin.laki_laki);
    console.<span class="c-fn">log</span>(<span class="c-str">'Perempuan:'</span>, stats.jenis_kelamin.perempuan);
    console.<span class="c-fn">log</span>(<span class="c-str">'Statistik Jurusan:'</span>, stats.per_jurusan);
  });</code></pre>

<pre id="c-stat-response" style="display:none;"><code>{
  <span class="c-prop">"success"</span>: <span class="c-bool">true</span>,
  <span class="c-prop">"message"</span>: <span class="c-str">"Statistik data siswa berhasil dihitung"</span>,
  <span class="c-prop">"data"</span>: {
    <span class="c-prop">"total_siswa"</span>: <span class="c-num">12</span>,
    <span class="c-prop">"jenis_kelamin"</span>: {
      <span class="c-prop">"laki_laki"</span>: <span class="c-num">6</span>,
      <span class="c-prop">"perempuan"</span>: <span class="c-num">6</span>
    },
    <span class="c-prop">"per_jurusan"</span>: [
      { <span class="c-prop">"jurusan"</span>: <span class="c-str">"Rekayasa Perangkat Lunak"</span>, <span class="c-prop">"total"</span>: <span class="c-num">4</span> },
      { <span class="c-prop">"jurusan"</span>: <span class="c-str">"Teknik Komputer dan Jaringan"</span>, <span class="c-prop">"total"</span>: <span class="c-num">3</span> },
      { <span class="c-prop">"jurusan"</span>: <span class="c-str">"Desain Komunikasi Visual"</span>, <span class="c-prop">"total"</span>: <span class="c-num">3</span> },
      { <span class="c-prop">"jurusan"</span>: <span class="c-str">"Manajemen Perkantoran"</span>, <span class="c-prop">"total"</span>: <span class="c-num">2</span> }
    ],
    <span class="c-prop">"per_kelas"</span>: [
      { <span class="c-prop">"kelas"</span>: <span class="c-str">"XII RPL 1"</span>, <span class="c-prop">"total"</span>: <span class="c-num">4</span> },
      { <span class="c-prop">"kelas"</span>: <span class="c-str">"XI TKJ 2"</span>, <span class="c-prop">"total"</span>: <span class="c-num">3</span> }
    ]
  }
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- ================= INTERACTIVE PLAYGROUND ================= -->
            <section class="doc-section" id="playground">
                <div class="doc-section-header">
                    <h2>🧪 5. Interactive API Playground (Live Console)</h2>
                    <p>Uji coba langsung respons API server saat ini tanpa perlu menginstall Postman atau cURL!</p>
                </div>

                <div class="playground-card">
                    <div class="playground-row">
                        <select id="playMethod" class="playground-select" onchange="toggleBodyEditor()">
                            <option value="GET">GET</option>
                            <option value="POST">POST</option>
                            <option value="PUT">PUT</option>
                            <option value="DELETE">DELETE</option>
                        </select>
                        <input type="text" id="playEndpoint" class="playground-input" value="/api/siswas?all=true">
                        <button class="btn-run" id="btnRunRequest" onclick="executePlayground()">
                            <span>Kirim Request</span>
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                    <!-- Quick Preset Buttons -->
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1.25rem;">
                        <button class="copy-url-btn" onclick="setPreset('GET', '/api/siswas?all=true')">GET Semua Siswa</button>
                        <button class="copy-url-btn" onclick="setPreset('GET', '/api/siswas/statistik')">GET Statistik</button>
                        <button class="copy-url-btn" onclick="setPreset('GET', '/api/siswas/1')">GET Detail ID 1</button>
                        <button class="copy-url-btn" onclick="setPreset('GET', '/api/siswas?jurusan=Rekayasa')">GET Filter RPL</button>
                        <button class="copy-url-btn" onclick="setPreset('POST', '/api/siswas', samplePostJson)">POST Siswa Baru</button>
                    </div>

                    <!-- Body JSON Editor for POST / PUT -->
                    <div class="body-editor-group" id="bodyEditorGroup">
                        <div class="body-editor-label">
                            <span>Request Payload JSON Body (Content-Type: application/json):</span>
                            <button class="copy-url-btn" style="padding: 0.15rem 0.5rem;" onclick="loadSampleBody()">Muat Format Default Siswa</button>
                        </div>
                        <textarea id="playBody" class="body-textarea"></textarea>
                    </div>

                    <!-- Output Box -->
                    <div class="console-output-box">
                        <div class="console-output-header">
                            <span id="resStatusBadge" class="status-badge status-200">STATUS: SIAP</span>
                            <span id="resTime" style="color: var(--text-dim);">Latency: 0 ms</span>
                        </div>
                        <pre id="playOutput" class="console-pre">// Klik tombol "Kirim Request" di atas untuk mengeksekusi endpoint live.</pre>
                    </div>
                </div>
            </section>

            <!-- Section 6: Status Codes -->
            <section class="doc-section" id="status-codes">
                <div class="doc-section-header">
                    <h2>🚦 6. Kode Status Respons HTTP</h2>
                    <p>Arti dari status code yang dikembalikan oleh API server:</p>
                </div>

                <div class="status-grid">
                    <div class="status-card">
                        <div class="status-code-num" style="color: #34d399;">200 OK</div>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">Request berhasil dieksekusi (GET, PUT, DELETE). Data dikembalikan dengan benar.</p>
                    </div>
                    <div class="status-card">
                        <div class="status-code-num" style="color: #38bdf8;">201 Created</div>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">Data baru berhasil disimpan ke database melalui request POST.</p>
                    </div>
                    <div class="status-card">
                        <div class="status-code-num" style="color: #f87171;">404 Not Found</div>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">Data siswa atau URL endpoint yang diminta tidak ditemukan di database.</p>
                    </div>
                    <div class="status-card">
                        <div class="status-code-num" style="color: #fbbf24;">422 Unprocessable</div>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">Gagal validasi data input (misalnya NIS duplikat atau ada kolom wajib yang kosong).</p>
                    </div>
                    <div class="status-card">
                        <div class="status-code-num" style="color: #ef4444;">500 Server Error</div>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">Terjadi kesalahan konfigurasi server atau kegagalan koneksi database.</p>
                    </div>
                </div>
            </section>

            <!-- Section 7: Tips Praktikum -->
            <section class="doc-section" id="tips-praktikum">
                <div class="doc-section-header">
                    <h2>💡 7. Tips Praktikum Pemrograman Web SMK</h2>
                    <p>Panduan bagi siswa saat menghubungkan API ke tugas atau proyek frontend:</p>
                </div>

                <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border); border-radius: 14px; padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                    <div>
                        <strong style="color: #38bdf8;">1. Cara Mengatasi Error CORS</strong>
                        <p style="font-size: 0.9rem; color: var(--text-muted); margin-top: 0.25rem;">
                            Server ini sudah dilengkapi middleware <code>cors</code> dengan header <code>Access-Control-Allow-Origin: *</code>. Anda bisa memanggil API dari file HTML lokal (misal: <code>file:///C:/proyek/index.html</code>) maupun melalui Live Server VS Code (<code>http://127.0.0.1:5500</code>) tanpa kendala CORS.
                        </p>
                    </div>
                    <div>
                        <strong style="color: #34d399;">2. Gunakan Inspect Element (F12) Network Tab</strong>
                        <p style="font-size: 0.9rem; color: var(--text-muted); margin-top: 0.25rem;">
                            Jika data tidak tampil di web Anda, buka Developer Tools (tekan <code>F12</code>) lalu klik tab <strong>Network</strong> & <strong>Console</strong>. Periksa apakah request berstatus merah (404/500/Failed) dan lihat response payload-nya.
                        </p>
                    </div>
                    <div>
                        <strong style="color: #c084fc;">3. Trik Menampilkan Gambar Avatar Otomatis</strong>
                        <p style="font-size: 0.9rem; color: var(--text-muted); margin-top: 0.25rem;">
                            Jika siswa tidak memiliki link foto, gunakan layanan gratis <a href="https://ui-avatars.com" target="_blank" style="color: #a5b4fc;">UI Avatars</a> seperti:
                            <code style="color: var(--cyan);">https://ui-avatars.com/api/?name=${encodeURIComponent(siswa.nama)}</code>.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="doc-footer">
                <div>
                    <strong>API Server Pembelajaran Data Siswa SMK</strong> — Dibuat dengan Laravel 12
                </div>
                <div>
                    <a href="{{ url('/') }}" style="color: var(--text-muted); text-decoration: none; margin-right: 1rem;">Beranda</a>
                    <a href="{{ url('/starter-kit/index.html') }}" style="color: var(--text-muted); text-decoration: none; margin-right: 1rem;">Starter Kit</a>
                    <a href="#pengantar" style="color: var(--primary); text-decoration: none;">Kembali ke Atas ↑</a>
                </div>
            </footer>
        </main>
    </div>

    <!-- Script Logic -->
    <script>
        const samplePostJson = JSON.stringify({
            nis: "1023010" + Math.floor(100 + Math.random() * 900),
            nama: "Siswa Baru Uji Coba",
            jenis_kelamin: "L",
            tempat_lahir: "Surabaya",
            tanggal_lahir: "2007-05-15",
            agama: "Islam",
            alamat: "Jl. Pemuda No. 10, Surabaya",
            no_telp: "081234567899",
            email: "siswa.baru@smk.sch.id",
            kelas: "XII RPL 1",
            jurusan: "Rekayasa Perangkat Lunak",
            tahun_masuk: 2023,
            status: "aktif"
        }, null, 2);

        // Switch Code Tabs
        function switchTab(btn, targetId) {
            const nav = btn.parentElement;
            nav.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const container = nav.closest('.code-tabs-wrapper').querySelector('.code-container');
            container.querySelectorAll('pre').forEach(p => p.style.display = 'none');

            const targetPre = document.getElementById(targetId);
            if (targetPre) targetPre.style.display = 'block';
        }

        // Copy Active Code
        function copyActiveCode(navId) {
            const nav = document.getElementById(navId);
            const activeBtn = nav.querySelector('.tab-btn.active');
            const targetOnClick = activeBtn.getAttribute('onclick');
            const targetIdMatch = targetOnClick.match(/'([^']+)'/);
            if (targetIdMatch) {
                const pre = document.getElementById(targetIdMatch[1]);
                if (pre) copySnippet(pre.innerText);
            }
        }

        // Copy text helper
        function copySnippet(text) {
            navigator.clipboard.writeText(text).then(() => {
                showToast('Berhasil disalin ke clipboard! 📋');
            }).catch(err => {
                showToast('Gagal menyalin teks: ' + err);
            });
        }

        function showToast(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2500);
        }

        // Playground
        function toggleBodyEditor() {
            const method = document.getElementById('playMethod').value;
            const editor = document.getElementById('bodyEditorGroup');
            if (method === 'POST' || method === 'PUT') {
                editor.style.display = 'block';
                if (!document.getElementById('playBody').value.trim()) {
                    loadSampleBody();
                }
            } else {
                editor.style.display = 'none';
            }
        }

        function loadSampleBody() {
            document.getElementById('playBody').value = samplePostJson;
        }

        function setPreset(method, endpoint, body = '') {
            document.getElementById('playMethod').value = method;
            document.getElementById('playEndpoint').value = endpoint;
            toggleBodyEditor();
            if (body) {
                document.getElementById('playBody').value = body;
            }
            executePlayground();
        }

        async function executePlayground() {
            const method = document.getElementById('playMethod').value;
            let endpoint = document.getElementById('playEndpoint').value.trim();
            const btn = document.getElementById('btnRunRequest');
            const output = document.getElementById('playOutput');
            const statusBadge = document.getElementById('resStatusBadge');
            const timeMeter = document.getElementById('resTime');

            if (!endpoint.startsWith('http')) {
                if (!endpoint.startsWith('/')) endpoint = '/' + endpoint;
                endpoint = window.location.origin + endpoint;
            }

            btn.disabled = true;
            btn.innerHTML = '<span>Mengirim...</span>';
            output.textContent = '// Menghubungi server API...';
            statusBadge.className = 'status-badge status-400';
            statusBadge.textContent = 'CONNECTING...';

            const headers = { 'Accept': 'application/json' };
            const options = { method, headers };

            if (method === 'POST' || method === 'PUT') {
                headers['Content-Type'] = 'application/json';
                const bodyText = document.getElementById('playBody').value.trim();
                try {
                    options.body = bodyText ? JSON.stringify(JSON.parse(bodyText)) : '{}';
                } catch (e) {
                    output.textContent = '// JSON Body tidak valid: ' + e.message;
                    btn.disabled = false;
                    btn.innerHTML = '<span>Kirim Request</span>';
                    statusBadge.textContent = 'JSON INVALID';
                    return;
                }
            }

            const startTime = performance.now();
            try {
                const response = await fetch(endpoint, options);
                const duration = Math.round(performance.now() - startTime);
                timeMeter.textContent = `Latency: ${duration} ms`;

                const data = await response.json();
                statusBadge.textContent = `HTTP ${response.status} ${response.statusText}`;
                if (response.ok) {
                    statusBadge.className = 'status-badge status-200';
                } else if (response.status === 422 || response.status === 404) {
                    statusBadge.className = 'status-badge status-400';
                } else {
                    statusBadge.className = 'status-badge status-500';
                }

                output.textContent = JSON.stringify(data, null, 2);
            } catch (err) {
                timeMeter.textContent = 'Latency: 0 ms';
                statusBadge.className = 'status-badge status-500';
                statusBadge.textContent = 'NETWORK ERROR';
                output.textContent = '// Gagal menghubungi server:\n' + err.message;
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<span>Kirim Request</span> <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>';
            }
        }

        // Quick filter endpoints
        function filterEndpoints(query) {
            const q = query.toLowerCase().trim();
            const cards = document.querySelectorAll('.endpoint-card');
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(q) ? 'block' : 'none';
            });
        }

        // Auto highlight active sidebar item on scroll
        const sections = document.querySelectorAll('.doc-section, .endpoint-card');
        const navLinks = document.querySelectorAll('.sidebar-link');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const top = section.offsetTop - 120;
                if (window.pageYOffset >= top) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (current && link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });

        // Set base URL dynamically
        window.addEventListener('DOMContentLoaded', () => {
            const displayBase = document.getElementById('displayBaseUrl');
            if (displayBase) {
                displayBase.textContent = window.location.origin + '/api';
            }
        });
    </script>
</body>
</html>
