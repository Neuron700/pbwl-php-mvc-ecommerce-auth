<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
    <div>
        <h1 class="h3 fw-bold mb-1">Dashboard</h1>
        <p class="text-muted mb-0">Ringkasan toko &amp; panduan singkat.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo URL; ?>/produk/input" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Input Produk</a>
        <a href="<?php echo URL; ?>/penjualan" class="btn btn-outline-primary"><i class="bi bi-receipt"></i> Penjualan</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <i class="bi bi-tags text-primary" style="font-size: 2rem"></i>
                <h5 class="card-title mt-2">Kelola Kategori</h5>
                <p class="card-text text-muted">Tambah &amp; ubah kategori produk yang tersedia.</p>
                <a href="<?php echo URL; ?>/kategori" class="btn btn-sm btn-outline-primary">Buka Kategori</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <i class="bi bi-box-seam text-primary" style="font-size: 2rem"></i>
                <h5 class="card-title mt-2">Kelola Produk</h5>
                <p class="card-text text-muted">Kelola daftar produk, stok, harga, dan foto produk.</p>
                <a href="<?php echo URL; ?>/produk" class="btn btn-sm btn-outline-primary">Buka Produk</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <i class="bi bi-receipt text-primary" style="font-size: 2rem"></i>
                <h5 class="card-title mt-2">Catat Penjualan</h5>
                <p class="card-text text-muted">Setiap produk terjual otomatis mengurangi stok.</p>
                <a href="<?php echo URL; ?>/penjualan/input" class="btn btn-sm btn-outline-primary">Catat Penjualan</a>
            </div>
        </div>
    </div>
</div>
