<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>

<style>
    /* Premium Animated Background with Shapes */
    .welcome-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #C8E9F8 0%, #B3D9F2 25%, #D9B8F0 50%, #F0C8F0 75%, #FFE6CC 100%);
        background-size: 200% 200%;
        animation: backgroundShift 25s ease infinite;
        z-index: -2;
        overflow: hidden;
    }

    .welcome-background::before {
        content: '';
        position: absolute;
        width: 200%;
        height: 200%;
        background: 
            radial-gradient(circle at 20% 50%, rgba(255,255,255,0.2) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255,255,255,0.15) 0%, transparent 50%),
            radial-gradient(circle at 40% 10%, rgba(255,255,255,0.18) 0%, transparent 50%);
        animation: moveBackground 20s linear infinite;
    }

    @keyframes backgroundShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes moveBackground {
        0% { transform: translate(0, 0); }
        100% { transform: translate(-50%, -50%); }
    }

    /* Animated Blobs - Enhanced */
    .blob {
        position: fixed;
        z-index: -1;
        opacity: 0.25;
        border-radius: 50%;
        filter: blur(100px);
        animation: blobAnimation 15s ease-in-out infinite;
        mix-blend-mode: screen;
    }

    .blob-1 {
        top: -20%;
        left: -10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, #88D8FF, #5FCDE0);
        animation-duration: 20s;
        animation-delay: 0s;
    }

    .blob-2 {
        top: 20%;
        right: -5%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, #D9A8FF, #C68FFF);
        animation-duration: 22s;
        animation-delay: -5s;
    }

    .blob-3 {
        bottom: -15%;
        left: 10%;
        width: 550px;
        height: 550px;
        background: radial-gradient(circle, #FFBBDD, #FF99CC);
        animation-duration: 24s;
        animation-delay: -10s;
    }

    @keyframes blobAnimation {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(50px, -80px) scale(1.2); }
        50% { transform: translate(-40px, 60px) scale(0.9); }
        75% { transform: translate(80px, 40px) scale(1.1); }
    }

    /* Floating Particles */
    .particle {
        position: fixed;
        pointer-events: none;
        z-index: -1;
        opacity: 0;
        animation: float-particle linear infinite;
    }

    @keyframes float-particle {
        0% {
            opacity: 0;
            transform: translateY(0) translateX(0);
        }
        10% {
            opacity: 0.6;
        }
        90% {
            opacity: 0.6;
        }
        100% {
            opacity: 0;
            transform: translateY(-100vh) translateX(100px);
        }
    }

    /* Content Overlay */
    .content-overlay {
        position: relative;
        z-index: 1;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 30px;
        padding: 3rem;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    /* Floating Animation */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    .float {
        animation: float 3s ease-in-out infinite;
    }

    /* Glow Effect */
    .glow {
        text-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
    }

    /* Service Cards with Glass Effect */
    .service-card {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .service-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }

    .service-card:hover::before {
        left: 100%;
    }

    /* Floating Icons */
    .floating-icon {
        position: relative;
        display: inline-block;
    }

    .floating-icon i {
        animation: float 3s ease-in-out infinite;
    }
</style>

<!-- Animated Background -->
<div class="welcome-background"></div>
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>
<div class="blob blob-3"></div>

<!-- Main Content -->
<div class="relative z-10">
    <!-- Hero Section -->
    <div class="content-overlay mb-10">
        <div class="text-center">
            <div class="mb-6 float">
                <div class="inline-flex items-center justify-center w-28 h-28 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full shadow-2xl">
                    <i class="fas fa-book-reader text-6xl text-white"></i>
                </div>
            </div>
            <h1 class="text-5xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-3 glow">
                Selamat Datang
            </h1>
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">
                Layanan Buku Tamu Digital Perpustakaan
            </h2>
            <p class="text-lg text-gray-600 mb-6">
                Provinsi Jawa Tengah
            </p>
            <div class="h-1 w-24 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 mx-auto rounded-full shadow-lg"></div>
        </div>
    </div>

    <!-- Main Services Section -->
    <div class="mb-12">
        <div class="content-overlay mb-10">
            <div class="text-center mb-10">
                <h3 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-3">
                    Pilih Layanan
                </h3>
                <p class="text-gray-700 text-lg">
                    Silahkan pilih jenis layanan yang Anda butuhkan
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Kritik & Saran Card -->
                <a href="/form/feedback<?= isset($token) ? '?token='.$token : '' ?>" 
                   class="service-card group relative overflow-hidden shadow-2xl hover:shadow-3xl transition-all duration-400">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 transform group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-400" style="background: radial-gradient(circle at 50% 50%, rgba(255,255,255,0.1) 0%, transparent 70%);"></div>
                    <div class="relative p-10 text-white z-10">
                        <div class="mb-6 floating-icon">
                            <div class="inline-flex items-center justify-center w-24 h-24 bg-white bg-opacity-20 rounded-full group-hover:bg-opacity-30 transition-all duration-300 transform group-hover:scale-110 backdrop-blur-sm">
                                <i class="fas fa-comments text-5xl"></i>
                            </div>
                        </div>
                        <h4 class="text-2xl font-bold mb-3">Kritik & Saran</h4>
                        <p class="text-blue-100 text-lg mb-6 leading-relaxed">
                            Berikan masukan Anda untuk meningkatkan kualitas layanan perpustakaan kami
                        </p>
                        <div class="flex items-center text-white font-semibold text-lg">
                            <span>Mulai Sekarang</span>
                            <i class="fas fa-arrow-right ml-3 transform group-hover:translate-x-3 transition-transform duration-300"></i>
                        </div>
                    </div>
                </a>
                
                <!-- Buku Tamu Card -->
                <a href="/form/guest-book<?= isset($token) ? '?token='.$token : '' ?>" 
                   class="service-card group relative overflow-hidden shadow-2xl hover:shadow-3xl transition-all duration-400">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500 via-emerald-600 to-teal-700 transform group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-400" style="background: radial-gradient(circle at 50% 50%, rgba(255,255,255,0.1) 0%, transparent 70%);"></div>
                    <div class="relative p-10 text-white z-10">
                        <div class="mb-6 floating-icon">
                            <div class="inline-flex items-center justify-center w-24 h-24 bg-white bg-opacity-20 rounded-full group-hover:bg-opacity-30 transition-all duration-300 transform group-hover:scale-110 backdrop-blur-sm">
                                <i class="fas fa-book-open text-5xl"></i>
                            </div>
                        </div>
                        <h4 class="text-2xl font-bold mb-3">Buku Tamu</h4>
                        <p class="text-green-100 text-lg mb-6 leading-relaxed">
                            Daftarkan kunjungan Anda dan informasi pengunjung perpustakaan
                        </p>
                        <div class="flex items-center text-white font-semibold text-lg">
                            <span>Mulai Sekarang</span>
                            <i class="fas fa-arrow-right ml-3 transform group-hover:translate-x-3 transition-transform duration-300"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Info Banner -->
            <div class="mt-10 p-6 bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-blue-600 rounded-xl">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-lightbulb text-2xl text-blue-600 mt-1"></i>
                    </div>
                    <div class="ml-4">
                        <h5 class="text-lg font-bold text-gray-800 mb-1">Informasi Penting</h5>
                        <p class="text-gray-700">Kedua layanan di atas dapat Anda gunakan untuk mengirimkan kritik, saran, dan data kunjungan Anda. Pastikan data yang Anda masukkan sudah benar sebelum mengirimkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Divider -->
    <div class="my-10 relative z-10">
        <div class="flex items-center gap-4">
            <div class="flex-1 border-t-2 border-white opacity-30"></div>
            <div class="px-4">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-white text-purple-600 rounded-full font-bold shadow-lg">
                    ATAU
                </div>
            </div>
            <div class="flex-1 border-t-2 border-white opacity-30"></div>
        </div>
    </div>

    <!-- Tracking Section -->
    <div class="rounded-2xl overflow-hidden shadow-2xl mb-12">
        <div class="bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 px-8 py-8 text-white">
            <div class="flex items-center mb-6">
                <div class="inline-flex items-center justify-center w-14 h-14 bg-white bg-opacity-20 rounded-full backdrop-blur-sm">
                    <i class="fas fa-search text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold">Lacak Status Surat Kunjungan</h3>
                    <p class="text-purple-100 mt-1">Periksa status surat kunjungan yang telah Anda ajukan</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-10">
            <form action="/search-guest-book" method="GET" class="max-w-lg mx-auto">
                <div class="space-y-4">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="nama" 
                            placeholder="Masukkan nama lengkap Anda..." 
                            class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-200 transition-all duration-300 text-lg shadow-md"
                            required>
                        <i class="fas fa-user absolute right-4 top-4 text-gray-400 text-xl"></i>
                    </div>
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-4 rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-bold text-lg flex items-center justify-center hover:from-purple-700 hover:to-pink-700">
                        <i class="fas fa-search mr-3"></i>Cari Status Surat Kunjungan
                    </button>
                </div>
                <p class="text-sm text-gray-600 mt-4 text-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Gunakan nama lengkap yang sama saat Anda mengajukan surat kunjungan
                </p>
            </form>
        </div>
    </div>

    <!-- Features Grid -->
    <div class="content-overlay">
        <h3 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-10 text-center">
            Keunggulan Layanan Kami
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Feature 1 -->
            <div class="group p-8 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border-l-4 border-blue-600 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-5xl text-blue-600 mb-4 float">
                    <i class="fas fa-bolt"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-2">Cepat & Mudah</h4>
                <p class="text-gray-700">Proses pendaftaran yang singkat dan sederhana tanpa ribet</p>
            </div>

            <!-- Feature 2 -->
            <div class="group p-8 bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl border-l-4 border-green-600 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-5xl text-green-600 mb-4 float">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-2">Aman & Terpercaya</h4>
                <p class="text-gray-700">Data Anda dijaga dengan sistem keamanan terbaik</p>
            </div>

            <!-- Feature 3 -->
            <div class="group p-8 bg-gradient-to-br from-purple-50 to-pink-100 rounded-xl border-l-4 border-purple-600 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-5xl text-purple-600 mb-4 float">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-2">Responsif</h4>
                <p class="text-gray-700">Dapat diakses dari berbagai perangkat kapan saja</p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
