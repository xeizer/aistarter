# xeizer/aistarter

AI coding guidelines dan skill untuk proyek Laravel, dipasang lewat [Laravel Boost](https://laravel.com/docs/boost).

Isi:

- **Guideline** (`resources/boost/guidelines/core.blade.php`): standar kerja AI agent — workflow approval, anti-halusinasi, database, security, UX, testing.
- **Skill** `livewire-crud-ux` (`resources/boost/skills/livewire-crud-ux/SKILL.md`): pola UX dan keamanan untuk CRUD Livewire, dimuat on-demand.

## Instalasi

```bash
composer require xeizer/aistarter --dev
php artisan boost:install
```

Saat `boost:install`, pilih `xeizer/aistarter` di daftar third-party guidelines/skills. Package ini otomatis ikut memasang `laravel/boost`.

> Pemilihan package hanya muncul di mode interaktif. Jalankan perintah di atas langsung di terminal, bukan lewat script Composer.

## Update

```bash
composer update xeizer/aistarter
php artisan boost:update
```

Opsional, supaya `boost:update` otomatis jalan setiap `composer update`, tambahkan ke `composer.json` proyek:

```json
{
    "scripts": {
        "post-update-cmd": [
            "@php artisan boost:update --ansi"
        ]
    }
}
```

## Catatan untuk kontributor

`core.blade.php` dirender oleh Blade. Jangan menulis `{{ }}` atau directive `@...` secara langsung; bungkus contoh kode Blade dengan `@verbatim ... @endverbatim`.

## Kredit

Sebagian aturan keamanan terinspirasi dari [Spatie Secure Coding Guidelines](https://spatie.be/guidelines/secure-coding) dan [Spatie Laravel & PHP Guidelines](https://spatie.be/guidelines/laravel), ditulis ulang dan disesuaikan untuk workflow package ini.

## Lisensi

MIT
