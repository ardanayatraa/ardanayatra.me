<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


---

## Tridanta FastRead

**URL**: `/fastread` - Baca cepat, dapat ilmu yang berguna

### Citation Management System

Fitur **Daftar Pustaka** telah ditambahkan untuk artikel news. Setiap artikel dapat memiliki multiple citations/referensi yang diformat menggunakan APA style.

#### Database Structure

**Table: citations**
- `news_id` - Foreign key ke tabel news
- `author` - Nama penulis
- `title` - Judul artikel/buku
- `source` - Nama jurnal/penerbit
- `year` - Tahun publikasi
- `volume`, `issue`, `pages` - Detail publikasi jurnal
- `doi` - Digital Object Identifier
- `url` - URL sumber
- `type` - Tipe referensi (journal, book, website, conference)
- `order` - Urutan tampilan

#### Features

1. **Admin Panel**: Tambah/edit citations saat membuat/edit artikel
2. **Auto-formatting**: Citations otomatis diformat sesuai APA style berdasarkan tipe
3. **Multiple Types**: Support untuk jurnal, buku, website, dan conference papers
4. **Public Display**: Daftar pustaka ditampilkan di akhir artikel

#### Usage

```php
// Menambahkan citation ke artikel
$news->citations()->create([
    'author' => 'Smith, J.',
    'title' => 'Research Title',
    'source' => 'Journal Name',
    'year' => '2024',
    'type' => 'journal',
]);

// Mendapatkan formatted citation
$citation->formatted_citation; // Returns APA formatted string
```

#### Migration

```bash
php artisan migrate
php artisan db:seed --class=NewsSeeder
```

---

## My Song

**URL**: `/song` - Daftar lagu ciptaan original yang belum terdaftar di agregator manapun

### About

Halaman ini menampilkan karya-karya original **I Made Ardana Yatra** sebagai pencipta lagu dan arranger yang belum pernah didaftarkan ke agregator musik manapun (Spotify, Apple Music, dll). Semua lagu dilindungi hak cipta.

### Features

- **Embedded Audio Player** - Lagu bisa langsung diputar di halaman tanpa perlu buka Google Drive
- **Copyright Protection** - Badge copyright dan pemberitahuan hak cipta di setiap lagu
- **Original Badge** - Menandakan lagu adalah karya original
- **Auto-detect Google Drive URL** - Support berbagai format URL Google Drive
- **Download Button** - Tombol download langsung dari Google Drive
- Admin panel untuk CRUD lagu
- Responsive design dengan card layout

### Database Structure

**Table: songs**
- `title` - Judul lagu
- `artist` - Nama artis
- `audio_file` - Path file audio di Cloudflare R2
- `cover_image` - Path cover image di Cloudflare R2
- `views` - Jumlah views

### Routes

**Public:**
- `GET /song` - Halaman daftar lagu

**Admin:**
- `GET /admin/songs` - Daftar lagu (admin)
- `GET /admin/songs/create` - Form tambah lagu
- `POST /admin/songs` - Simpan lagu baru
- `GET /admin/songs/{id}/edit` - Form edit lagu
- `PUT /admin/songs/{id}` - Update lagu
- `DELETE /admin/songs/{id}` - Hapus lagu

### Google Drive URL Format

Model otomatis mendeteksi dan convert berbagai format URL Google Drive:
- `https://drive.google.com/file/d/FILE_ID/view`
- `https://drive.google.com/open?id=FILE_ID`
- `https://drive.google.com/uc?id=FILE_ID`

**Penting:** File di Google Drive harus di-set ke "Anyone with the link can view" agar bisa di-embed.

### Cloudflare R2 Setup

1. **Install AWS SDK:**
```bash
composer require league/flysystem-aws-s3-v3 "^3.0"
```

2. **Configure `.env`:**
```env
R2_ACCESS_KEY_ID=your_access_key
R2_SECRET_ACCESS_KEY=your_secret_key
R2_BUCKET=your_bucket_name
R2_ENDPOINT=https://your_account_id.r2.cloudflarestorage.com
R2_PUBLIC_URL=https://your_public_domain.com
```

3. **Run Migration:**
```bash
php artisan migrate
php artisan db:seed --class=SongSeeder
```

### Usage

```php
// Audio URL (R2 or Google Drive fallback)
$song->audio_url

// Cover image URL
$song->cover_url

// Google Drive embed (fallback)
$song->embed_url
```

### Upload Limits
- Audio: MP3, WAV, OGG, M4A (max 50MB)
- Cover: JPG, PNG (max 2MB)
