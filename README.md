## Requirement
1. PHP 8.1 (Or u may use docker, sorry for not providing dockerfile due lack of time, i can provide soon if i pass this test)
2. Database Mysql / PostgreSQL

## Instalasi

1. copy .env.example menjadi .env lalu sesuaikan konfigurasi (Database)
2. jalankan `composer install` untuk meng-install dependencies 
3. `php artisan migrate:fresh --seed` untuk melakukan migrasi database sekaligus memberikan data seeder 
4. `php artisan serve` 

## Deployment
Coming soon