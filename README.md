Cara menjalankan Project:
- clone project dari github (https://github.com/MSholiudin/magang.git) atau ekstrak dari file zip
- install depedensi laravel 
    composer instal
- salin dan sesuaikan file konfigurasi .env dari .env.example
- pastikan xampp keadaan menyala
- jalankan migrasi database
    php arisan migrate
- jalankan seeder (opsional)

- Setelah konfigurasi selesai, jalankan program dengan perintah berikut di lokal
    php artisan serve
- akses di browser melaluli link : http://127.0.0.1:8000

STRUKTUR FOLDER
├── app/                   # Folder utama untuk business logic (models, controllers)
│   ├── Http/Controllers/  # Tempat controller
│   └── Models/            # Tempat model
├── resources/
│   ├── views/             # Semua file blade (HTML + Laravel)
├── routes/
│   └── web.php            # Routing aplikasi web
├── public/                # Akses publik (image/file yang diupload, index.php)
│   └── storage/  
│       └── uploads/       # Folder untuk file upload
├── database/
│   ├── migrations/        # File migrasi database
│   └── seeders/           # Seeder dummy data
├── .env                   # File konfigurasi environment (DB, mail, dll)
└── artisan                # CLI Laravel


Tidak ada sample login, silahkan register terlebih dahulu
