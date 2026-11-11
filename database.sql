CREATE TABLE tb_kategori (
	kat_id TINYINT(3) NOT NULL AUTO_INCREMENT,
	kat_nama VARCHAR(50) NOT NULL,
	kat_keterangan TEXT DEFAULT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME DEFAULT NULL,
	PRIMARY KEY(kat_id)
);

CREATE TABLE tb_users (
	user_id INT(11) NOT NULL AUTO_INCREMENT,
	user_email VARCHAR(50) NOT NULL,
	user_password VARCHAR(255) NOT NULL,
	user_nama VARCHAR(100) DEFAULT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME DEFAULT NULL,
	PRIMARY KEY(user_id),
	UNIQUE KEY(user_email)
);

CREATE TABLE tb_produk (
	produk_id INT(11) NOT NULL AUTO_INCREMENT,
	produk_id_kat TINYINT(3) NOT NULL,
	produk_id_user INT(11) NOT NULL,
	produk_kode VARCHAR(50) NOT NULL,
	produk_nama VARCHAR(256) NOT NULL,
	produk_hrg BIGINT(20) DEFAULT '0',
	produk_keterangan TEXT DEFAULT NULL,
	produk_stock INT(11) DEFAULT '0',
	produk_photo VARCHAR(100) DEFAULT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME DEFAULT NULL,
	PRIMARY KEY(produk_id),
	UNIQUE KEY(produk_kode),
	FOREIGN KEY(produk_id_kat) REFERENCES tb_kategori(kat_id) ON UPDATE CASCADE ON DELETE RESTRICT,
	FOREIGN KEY(produk_id_user) REFERENCES tb_users(user_id) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE tb_penjualan (
	penjualan_id INT(11) NOT NULL AUTO_INCREMENT,
	tgl_penjualan DATE NOT NULL,
	produk_id INT(11) NOT NULL,
	qty INT(11) NOT NULL DEFAULT 1,
	harga_satuan BIGINT(20) DEFAULT '0',
	total BIGINT(20) DEFAULT '0',
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(penjualan_id),
	KEY produk_id (produk_id),
	FOREIGN KEY(produk_id) REFERENCES tb_produk(produk_id) ON UPDATE CASCADE ON DELETE RESTRICT
);

-- Akun admin praktikum: admin@mail.com / admin123 (bcrypt, diverifikasi dengan password_verify())
INSERT INTO `tb_users` (`user_id`, `user_email`, `user_password`, `user_nama`, `created_at`, `updated_at`) VALUES
(1, 'admin@mail.com', '$2y$10$tC5/G4rYZsQzhr/RCvf18ORb1FmESplYSzPOzU5jk.n8vNqi0v9Ma', 'Administrator', NOW(), NULL);
