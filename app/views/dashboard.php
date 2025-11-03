<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Pegawai</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css">
</head>
<body>
    <div class="navbar">
        <h1>Sistem Pegawai</h1>
        <div class="user-info">
            <span>Halo, <?php echo $_SESSION['user_name']; ?></span>
            <a href="/logout" class="logout-btn">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                echo $_SESSION['success']; 
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>
        
        <h1 class="page-title">Dashboard Overview</h1>
        
        <div class="stats">
            <div class="stat-card">
                <div class="stat-icon blue">
                    👥
                </div>
                <div class="stat-content">
                    <h3>Total Pegawai</h3>
                    <div class="number"><?php echo $statistik['total_pegawai']; ?></div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon green">
                    👨
                </div>
                <div class="stat-content">
                    <h3>Laki-laki</h3>
                    <div class="number"><?php echo $statistik['total_laki']; ?></div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon pink">
                    👩
                </div>
                <div class="stat-content">
                    <h3>Perempuan</h3>
                    <div class="number"><?php echo $statistik['total_perempuan']; ?></div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon orange">
                    💼
                </div>
                <div class="stat-content">
                    <h3>Total Jabatan</h3>
                    <div class="number"><?php echo $totalJabatan; ?></div>
                </div>
            </div>
        </div>
        
        <div class="chart-grid">
            <div class="card">
                <div class="card-header">
                    <h2>📈 Pegawai per Jabatan</h2>
                </div>
                <?php 
                $maxJumlah = max(array_column($byJabatan, 'jumlah'));
                foreach ($byJabatan as $item): 
                    $percentage = $maxJumlah > 0 ? ($item['jumlah'] / $maxJumlah) * 100 : 0;
                ?>
                <div class="chart-bar">
                    <div class="chart-label">
                        <span class="name"><?php echo htmlspecialchars($item['nama_jabatan']); ?></span>
                        <span class="value"><?php echo $item['jumlah']; ?> orang</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo $percentage; ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h2>👤 Pegawai Terbaru</h2>
                </div>
                <ul class="recent-list">
                    <?php foreach ($recentPegawai as $p): ?>
                    <li class="recent-item">
                        <?php if ($p['foto']): ?>
                            <?php 
                                $fotoSrc = (strpos($p['foto'], 'http://') === 0 || strpos($p['foto'], 'https://') === 0) 
                                    ? $p['foto'] 
                                    : '/' . $p['foto']; 
                                ?>
                                <img src="<?php echo $fotoSrc; ?>" alt="Foto" class="foto-pegawai">
                        <?php else: ?>
                            <div class="recent-avatar">
                                <?php echo strtoupper(substr($p['nama_pegawai'], 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                        <div class="recent-info">
                            <div class="name"><?php echo htmlspecialchars($p['nama_pegawai']); ?></div>
                            <div class="position"><?php echo htmlspecialchars($p['nama_jabatan']); ?></div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>