<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Export Buttons -->
<div class="mb-6 flex gap-3">
    <a href="/admin/dashboard/export-excel" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
        <i class="fas fa-file-excel mr-2"></i>
        Download Excel
    </a>
    <a href="/admin/dashboard/export-pdf" class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
        <i class="fas fa-file-pdf mr-2"></i>
        Download PDF
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Feedback -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="bg-blue-100 rounded-full p-3">
                <i class="fas fa-comments text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Kritik & Saran</p>
                <p class="text-2xl font-bold text-gray-900"><?= $feedbackTotal ?></p>
            </div>
        </div>
    </div>

    <!-- Total Guest Book -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="bg-green-100 rounded-full p-3">
                <i class="fas fa-book-open text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Buku Tamu</p>
                <p class="text-2xl font-bold text-gray-900"><?= $guestBookTotal ?></p>
            </div>
        </div>
    </div>

    <!-- Total Pengunjung Laki-laki -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="bg-cyan-100 rounded-full p-3">
                <i class="fas fa-male text-cyan-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Pengunjung Laki-laki</p>
                <p class="text-2xl font-bold text-gray-900" data-stat="laki-laki"><?= $visitorStats['laki_laki'] ?></p>
            </div>
        </div>
    </div>

    <!-- Total Pengunjung Perempuan -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="bg-pink-100 rounded-full p-3">
                <i class="fas fa-female text-pink-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Pengunjung Perempuan</p>
                <p class="text-2xl font-bold text-gray-900" data-stat="perempuan"><?= $visitorStats['perempuan'] ?></p>
            </div>
        </div>
    </div>

    <!-- Today's Feedback -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="bg-yellow-100 rounded-full p-3">
                <i class="fas fa-calendar-day text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Kritik & Saran Hari Ini</p>
                <p class="text-2xl font-bold text-gray-900">
                    <?php
                    $todayFeedback = 0;
                    foreach ($feedbackDaily as $daily) {
                        if ($daily['date'] == date('Y-m-d')) {
                            $todayFeedback = $daily['count'];
                            break;
                        }
                    }
                    echo $todayFeedback;
                    ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Today's Guest Book -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="bg-purple-100 rounded-full p-3">
                <i class="fas fa-users text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Buku Tamu Hari Ini</p>
                <p class="text-2xl font-bold text-gray-900">
                    <?php
                    $todayGuestBook = 0;
                    foreach ($guestBookDaily as $daily) {
                        if ($daily['date'] == date('Y-m-d')) {
                            $todayGuestBook = $daily['count'];
                            break;
                        }
                    }
                    echo $todayGuestBook;
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Daily Statistics Chart -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Harian (30 Hari Terakhir)</h3>
        <div class="relative" style="height: 300px;">
            <canvas id="dailyChart"></canvas>
        </div>
    </div>

    <!-- Visitor Gender Distribution Chart -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Pengunjung (Laki-laki vs Perempuan)</h3>
        <div class="relative" style="height: 300px;">
            <canvas id="visitorGenderChart"></canvas>
        </div>
    </div>
</div>

<!-- Daily Visitor Statistics Chart -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Grafik Pengunjung Harian</h3>
    <div class="relative" style="height: 300px;">
        <canvas id="dailyVisitorChart"></canvas>
    </div>
</div>

<!-- Monthly Visitor Statistics Chart -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Grafik Pengunjung Per Bulan (real time)</h3>
    <div class="relative" style="height: 300px;">
        <canvas id="monthlyVisitorChart"></canvas>
    </div>
</div>

<!-- Yearly Visitor Statistics Chart -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Grafik Pengunjung Per Tahun (real time)</h3>
    <div class="relative" style="height: 300px;">
        <canvas id="yearlyVisitorChart"></canvas>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h3>
        <div class="space-y-4 max-h-80 overflow-y-auto">
            <?php if (!empty($recentFeedback) || !empty($recentGuestBook)): ?>
                <?php
                // Combine and sort recent activities
                $recentActivities = [];
                
                foreach ($recentFeedback as $feedback) {
                    $recentActivities[] = [
                        'type' => 'feedback',
                        'type_label' => 'Kritik & Saran',
                        'data' => $feedback['form_data'],
                        'created_at' => $feedback['created_at']
                    ];
                }
                
                foreach ($recentGuestBook as $guestBook) {
                    $recentActivities[] = [
                        'type' => 'guest_book',
                        'type_label' => 'Buku Tamu',
                        'data' => $guestBook['form_data'],
                        'created_at' => $guestBook['created_at']
                    ];
                }
                
                // Sort by created_at descending
                usort($recentActivities, function($a, $b) {
                    return strtotime($b['created_at']) - strtotime($a['created_at']);
                });
                
                // Take only first 10
                $recentActivities = array_slice($recentActivities, 0, 10);
                ?>
                
                <?php foreach ($recentActivities as $activity): ?>
                    <div class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded">
                        <div class="<?= $activity['type'] == 'feedback' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600' ?> rounded-full p-2">
                            <i class="fas <?= $activity['type'] == 'feedback' ? 'fa-comments' : 'fa-book-open' ?> text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">
                                <?= $activity['type_label'] ?>
                            </p>
                            <p class="text-sm text-gray-600 truncate">
                                <?php
                                $data = is_string($activity['data']) ? json_decode($activity['data'], true) : $activity['data'];
                                echo $data['nama_lengkap'] ?? 'Tidak ada nama';
                                ?>
                            </p>
                            <p class="text-xs text-gray-400">
                                <?= date('d/m/Y H:i', strtotime($activity['created_at'])) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500 text-center py-4">Belum ada aktivitas</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prepare data for daily chart
    const feedbackDaily = <?= json_encode($feedbackDaily) ?>;
    const guestBookDaily = <?= json_encode($guestBookDaily) ?>;
    const dailyVisitorStats = <?= json_encode($dailyVisitorStats) ?>;
    const monthlyVisitorStats = <?= json_encode($monthlyVisitorStats) ?>;
    const yearlyVisitorStats = <?= json_encode($yearlyVisitorStats) ?>;
    const visitorStats = <?= json_encode($visitorStats) ?>;
    
    // ===== Daily Statistics Chart =====
    // Create date range for last 30 days
    const dates = [];
    const feedbackData = [];
    const guestBookData = [];
    
    for (let i = 29; i >= 0; i--) {
        const date = new Date();
        date.setDate(date.getDate() - i);
        const dateString = date.toISOString().split('T')[0];
        dates.push(date.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit' }));
        
        // Find data for this date
        const feedbackCount = feedbackDaily.find(d => d.date === dateString)?.count || 0;
        const guestBookCount = guestBookDaily.find(d => d.date === dateString)?.count || 0;
        
        feedbackData.push(feedbackCount);
        guestBookData.push(guestBookCount);
    }
    
    // Create daily chart
    const ctx = document.getElementById('dailyChart').getContext('2d');
    
    if (window.dailyChartInstance) {
        window.dailyChartInstance.destroy();
    }
    
    window.dailyChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Kritik & Saran',
                data: feedbackData,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.1,
                fill: false
            }, {
                label: 'Buku Tamu',
                data: guestBookData,
                borderColor: 'rgb(16, 185, 129)',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Tanggal'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Jumlah'
                    },
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            elements: {
                point: {
                    radius: 3,
                    hoverRadius: 5
                }
            }
        }
    });

    // ===== Visitor Gender Distribution Pie Chart =====
    const genderCtx = document.getElementById('visitorGenderChart').getContext('2d');
    
    if (window.visitorGenderChartInstance) {
        window.visitorGenderChartInstance.destroy();
    }
    
    window.visitorGenderChartInstance = new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [visitorStats.laki_laki, visitorStats.perempuan],
                backgroundColor: [
                    'rgba(6, 182, 212, 0.8)',
                    'rgba(236, 72, 153, 0.8)'
                ],
                borderColor: [
                    'rgb(6, 182, 212)',
                    'rgb(236, 72, 153)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + ' orang';
                        }
                    }
                }
            }
        }
    });

    // ===== Daily Visitor Statistics Line Chart =====
    const dailyVisitorDates = [];
    const dailyVisitorLakiLaki = [];
    const dailyVisitorPerempuan = [];
    
    dailyVisitorStats.forEach(stat => {
        const date = new Date(stat.date);
        dailyVisitorDates.push(date.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit' }));
        dailyVisitorLakiLaki.push(stat.laki_laki);
        dailyVisitorPerempuan.push(stat.perempuan);
    });
    
    const visitorCtx = document.getElementById('dailyVisitorChart').getContext('2d');
    
    if (window.dailyVisitorChartInstance) {
        window.dailyVisitorChartInstance.destroy();
    }
    
    window.dailyVisitorChartInstance = new Chart(visitorCtx, {
        type: 'bar',
        data: {
            labels: dailyVisitorDates,
            datasets: [{
                label: 'Pengunjung Laki-laki',
                data: dailyVisitorLakiLaki,
                backgroundColor: 'rgba(6, 182, 212, 0.8)',
                borderColor: 'rgb(6, 182, 212)',
                borderWidth: 1
            }, {
                label: 'Pengunjung Perempuan',
                data: dailyVisitorPerempuan,
                backgroundColor: 'rgba(236, 72, 153, 0.8)',
                borderColor: 'rgb(236, 72, 153)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            scales: {
                x: {
                    display: true,
                    stacked: false,
                    title: {
                        display: true,
                        text: 'Tanggal'
                    }
                },
                y: {
                    display: true,
                    stacked: false,
                    title: {
                        display: true,
                        text: 'Jumlah Pengunjung'
                    },
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' orang';
                        }
                    }
                }
            }
        }
    });

    // ===== Monthly Visitor Statistics Line Chart =====
    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const monthlyLabels = [];
    const monthlyLakiLaki = [];
    const monthlyPerempuan = [];
    
    monthlyVisitorStats.forEach(stat => {
        // Create label with month name and year
        const monthLabel = monthNames[stat.month - 1] + ' ' + stat.year;
        monthlyLabels.push(monthLabel);
        monthlyLakiLaki.push(stat.laki_laki);
        monthlyPerempuan.push(stat.perempuan);
    });
    
    const monthlyCtx = document.getElementById('monthlyVisitorChart').getContext('2d');
    
    if (window.monthlyVisitorChartInstance) {
        window.monthlyVisitorChartInstance.destroy();
    }
    
    window.monthlyVisitorChartInstance = new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Pengunjung Laki-laki',
                data: monthlyLakiLaki,
                borderColor: 'rgb(6, 182, 212)',
                backgroundColor: 'rgba(6, 182, 212, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }, {
                label: 'Pengunjung Perempuan',
                data: monthlyPerempuan,
                borderColor: 'rgb(236, 72, 153)',
                backgroundColor: 'rgba(236, 72, 153, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Bulan'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Jumlah Pengunjung'
                    },
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' orang';
                        }
                    }
                }
            },
            elements: {
                point: {
                    radius: 4,
                    hoverRadius: 6
                }
            }
        }
    });

    // ===== Yearly Visitor Statistics Bar Chart =====
    const yearlyLabels = [];
    const yearlyLakiLaki = [];
    const yearlyPerempuan = [];
    
    yearlyVisitorStats.forEach(stat => {
        yearlyLabels.push(stat.year);
        yearlyLakiLaki.push(stat.laki_laki);
        yearlyPerempuan.push(stat.perempuan);
    });
    
    const yearlyCtx = document.getElementById('yearlyVisitorChart').getContext('2d');
    
    if (window.yearlyVisitorChartInstance) {
        window.yearlyVisitorChartInstance.destroy();
    }
    
    window.yearlyVisitorChartInstance = new Chart(yearlyCtx, {
        type: 'bar',
        data: {
            labels: yearlyLabels,
            datasets: [{
                label: 'Pengunjung Laki-laki',
                data: yearlyLakiLaki,
                backgroundColor: 'rgba(6, 182, 212, 0.8)',
                borderColor: 'rgb(6, 182, 212)',
                borderWidth: 1
            }, {
                label: 'Pengunjung Perempuan',
                data: yearlyPerempuan,
                backgroundColor: 'rgba(236, 72, 153, 0.8)',
                borderColor: 'rgb(236, 72, 153)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Tahun'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Jumlah Pengunjung'
                    },
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' orang';
                        }
                    }
                }
            }
        }
    });

    // ===== REAL-TIME UPDATE =====
    // Update grafik setiap 10 detik
    setInterval(function() {
        fetch('/admin/dashboard/chart-data-realtime')
            .then(response => response.json())
            .then(data => {
                if (!data.success) return;

                // Update variable data
                dailyVisitorStats = data.dailyVisitorStats;
                monthlyVisitorStats = data.monthlyVisitorStats;
                yearlyVisitorStats = data.yearlyVisitorStats;
                visitorStats = data.visitorStats;

                // Update Daily Visitor Chart
                const dailyVisitorDates = [];
                const dailyVisitorLakiLaki = [];
                const dailyVisitorPerempuan = [];
                
                dailyVisitorStats.forEach(stat => {
                    const date = new Date(stat.date);
                    dailyVisitorDates.push(date.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit' }));
                    dailyVisitorLakiLaki.push(stat.laki_laki);
                    dailyVisitorPerempuan.push(stat.perempuan);
                });
                
                if (window.dailyVisitorChartInstance) {
                    window.dailyVisitorChartInstance.data.labels = dailyVisitorDates;
                    window.dailyVisitorChartInstance.data.datasets[0].data = dailyVisitorLakiLaki;
                    window.dailyVisitorChartInstance.data.datasets[1].data = dailyVisitorPerempuan;
                    window.dailyVisitorChartInstance.update();
                }

                // Update Monthly Visitor Chart
                const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                const monthlyLabels = [];
                const monthlyLakiLaki = [];
                const monthlyPerempuan = [];
                
                monthlyVisitorStats.forEach(stat => {
                    const monthLabel = monthNames[stat.month - 1] + ' ' + stat.year;
                    monthlyLabels.push(monthLabel);
                    monthlyLakiLaki.push(stat.laki_laki);
                    monthlyPerempuan.push(stat.perempuan);
                });
                
                if (window.monthlyVisitorChartInstance) {
                    window.monthlyVisitorChartInstance.data.labels = monthlyLabels;
                    window.monthlyVisitorChartInstance.data.datasets[0].data = monthlyLakiLaki;
                    window.monthlyVisitorChartInstance.data.datasets[1].data = monthlyPerempuan;
                    window.monthlyVisitorChartInstance.update();
                }

                // Update Yearly Visitor Chart
                const yearlyLabels = [];
                const yearlyLakiLaki = [];
                const yearlyPerempuan = [];
                
                yearlyVisitorStats.forEach(stat => {
                    yearlyLabels.push(stat.year);
                    yearlyLakiLaki.push(stat.laki_laki);
                    yearlyPerempuan.push(stat.perempuan);
                });
                
                if (window.yearlyVisitorChartInstance) {
                    window.yearlyVisitorChartInstance.data.labels = yearlyLabels;
                    window.yearlyVisitorChartInstance.data.datasets[0].data = yearlyLakiLaki;
                    window.yearlyVisitorChartInstance.data.datasets[1].data = yearlyPerempuan;
                    window.yearlyVisitorChartInstance.update();
                }

                // Update statistik card
                const lakiLakiCard = document.querySelector('[data-stat="laki-laki"]');
                const perempuanCard = document.querySelector('[data-stat="perempuan"]');
                
                if (lakiLakiCard) {
                    lakiLakiCard.textContent = visitorStats.laki_laki;
                }
                if (perempuanCard) {
                    perempuanCard.textContent = visitorStats.perempuan;
                }
            })
            .catch(error => console.error('Error updating charts:', error));
    }, 10000); // Update setiap 10 detik
});
</script>
<?= $this->endSection() ?>