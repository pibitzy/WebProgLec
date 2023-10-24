CREATE TABLE user (
    id_user INT(10) AUTO_INCREMENT,
    fname_user VARCHAR(50) NOT NULL,
    lname_user VARCHAR (50),
    username_user VARCHAR(50) NOT NULL,
    email_user VARCHAR(255) NOT NULL,
    password_user VARCHAR(255) NOT NULL,
    bday DATETIME NOT NULL,
    jeniskelamin VARCHAR(50) NOT NULL,
    role VARCHAR(50),
    PRIMARY KEY (id_user)
);

CREATE TABLE menu (
  id_menu INT(10) NOT NULL,
  foto_menu LONGBLOB NOT NULL,
  foto_type VARCHAR(50) NOT NULL,
  nama_menu VARCHAR(50) NOT NULL,
  deskripsi_menu LONGTEXT NOT NULL,
  harga_menu VARCHAR(50) NOT NULL,
  kategori_menu VARCHAR(50) NOT NULL,
  PRIMARY KEY(id_menu)
);

CREATE TABLE pesanan (
    id_pesanan INT AUTO_INCREMENT PRIMARY KEY,
    id_menu INT,
    jumlah_pesanan INT,
    status CHAR(1)
);
