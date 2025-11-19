<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        
        if (!$user) {
            $this->command->error('No user found. Please create a user first.');
            return;
        }

        $newsCategory = Category::firstOrCreate(
            ['slug' => 'news'],
            ['name' => 'News']
        );

        $techCategory = Category::firstOrCreate(
            ['slug' => 'technology'],
            ['name' => 'Technology']
        );

        $musicCategory = Category::firstOrCreate(
            ['slug' => 'music'],
            ['name' => 'Music']
        );

        $articles = [
            [
                'title' => 'Perkembangan Teknologi AI di Indonesia Tahun 2025',
                'excerpt' => 'Artificial Intelligence semakin berkembang pesat di Indonesia dengan berbagai inovasi dan implementasi di berbagai sektor.',
                'content' => "Teknologi Artificial Intelligence (AI) mengalami perkembangan yang sangat pesat di Indonesia pada tahun 2025. Berbagai perusahaan teknologi lokal mulai mengadopsi AI untuk meningkatkan efisiensi bisnis mereka.\n\nPemerintah Indonesia juga aktif mendukung pengembangan AI melalui berbagai program dan inisiatif. Hal ini terlihat dari meningkatnya jumlah startup AI yang bermunculan di berbagai kota besar.\n\nDi sektor pendidikan, AI mulai digunakan untuk personalisasi pembelajaran dan membantu guru dalam mengevaluasi kemampuan siswa. Sementara di sektor kesehatan, AI membantu dalam diagnosis penyakit dan manajemen rumah sakit.\n\nPara ahli memprediksi bahwa AI akan terus berkembang dan menjadi bagian integral dari kehidupan sehari-hari masyarakat Indonesia dalam beberapa tahun ke depan.",
                'category_id' => $techCategory->id,
                'status' => 'published',
                'published_at' => now()->subDays(1),
                'views' => 245,
            ],
            [
                'title' => 'Festival Musik Tradisional Bali Menarik Ribuan Pengunjung',
                'excerpt' => 'Festival musik tradisional Bali yang digelar di Denpasar berhasil menarik ribuan pengunjung dari berbagai daerah.',
                'content' => "Festival Musik Tradisional Bali yang digelar di Taman Budaya Denpasar pada akhir pekan lalu berhasil menarik perhatian ribuan pengunjung. Acara ini menampilkan berbagai pertunjukan musik tradisional Bali yang memukau.\n\nPara seniman dari berbagai daerah di Bali turut berpartisipasi dalam festival ini. Mereka menampilkan berbagai jenis musik tradisional seperti gamelan, gong kebyar, dan angklung.\n\nKepala Dinas Kebudayaan Bali menyatakan bahwa festival ini bertujuan untuk melestarikan budaya musik tradisional Bali dan memperkenalkannya kepada generasi muda.\n\nAcara ini juga dihadiri oleh wisatawan mancanegara yang tertarik dengan keunikan musik tradisional Bali. Festival ini direncanakan akan menjadi agenda tahunan untuk terus mempromosikan budaya Bali.",
                'category_id' => $musicCategory->id,
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'views' => 189,
            ],
            [
                'title' => 'Startup Indonesia Raih Pendanaan 10 Juta Dollar',
                'excerpt' => 'Sebuah startup teknologi asal Indonesia berhasil mendapatkan pendanaan sebesar 10 juta dollar dari investor internasional.',
                'content' => "Kabar gembira datang dari dunia startup Indonesia. Sebuah perusahaan teknologi lokal berhasil meraih pendanaan sebesar 10 juta dollar AS dari investor internasional.\n\nPendanaan ini akan digunakan untuk ekspansi bisnis ke negara-negara Asia Tenggara lainnya. CEO perusahaan menyatakan bahwa dana ini juga akan digunakan untuk pengembangan produk dan perekrutan talenta terbaik.\n\nInvestor yang terlibat dalam pendanaan ini berasal dari Singapura dan Jepang. Mereka melihat potensi besar dari model bisnis yang ditawarkan oleh startup ini.\n\nKeberhasilan ini diharapkan dapat menginspirasi startup-startup lain di Indonesia untuk terus berinovasi dan berkembang di pasar global.",
                'category_id' => $techCategory->id,
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'views' => 312,
            ],
            [
                'title' => 'Konser Musik Indie Lokal Sukses Digelar di Jakarta',
                'excerpt' => 'Konser musik indie yang menampilkan band-band lokal sukses digelar di Jakarta dengan antusiasme tinggi dari penonton.',
                'content' => "Konser musik indie yang digelar di Jakarta pada Sabtu malam lalu sukses besar. Acara ini menampilkan lebih dari 10 band indie lokal yang sudah memiliki basis penggemar kuat.\n\nPara penonton yang hadir sangat antusias menyaksikan penampilan dari band-band favorit mereka. Suasana konser sangat meriah dengan berbagai aktivitas menarik.\n\nPenyelenggara acara menyatakan bahwa konser ini bertujuan untuk memberikan panggung bagi musisi indie lokal untuk menunjukkan karya mereka. Mereka berharap acara seperti ini dapat terus digelar secara rutin.\n\nBeberapa band yang tampil mendapat sambutan luar biasa dari penonton. Mereka berhasil membawakan lagu-lagu hits mereka dengan energi yang tinggi.",
                'category_id' => $musicCategory->id,
                'status' => 'published',
                'published_at' => now()->subDays(4),
                'views' => 156,
            ],
            [
                'title' => 'Aplikasi Mobile Banking Terbaru Diluncurkan',
                'excerpt' => 'Bank digital terkemuka meluncurkan aplikasi mobile banking dengan fitur-fitur canggih dan keamanan tingkat tinggi.',
                'content' => "Sebuah bank digital terkemuka di Indonesia baru saja meluncurkan aplikasi mobile banking terbarunya. Aplikasi ini dilengkapi dengan berbagai fitur canggih dan sistem keamanan berlapis.\n\nFitur-fitur unggulan yang ditawarkan antara lain transfer instan, pembayaran tagihan, investasi, dan manajemen keuangan pribadi. Semua fitur dirancang dengan antarmuka yang user-friendly.\n\nSistem keamanan aplikasi ini menggunakan teknologi biometrik dan enkripsi end-to-end untuk melindungi data pengguna. Bank juga menjamin keamanan transaksi dengan sistem monitoring 24/7.\n\nPeluncuran aplikasi ini mendapat sambutan positif dari masyarakat. Dalam seminggu pertama, aplikasi ini sudah diunduh lebih dari 100 ribu kali.",
                'category_id' => $techCategory->id,
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'views' => 278,
            ],
            [
                'title' => 'Workshop Produksi Musik Digital Untuk Pemula',
                'excerpt' => 'Workshop produksi musik digital digelar untuk membantu pemula belajar membuat musik menggunakan software modern.',
                'content' => "Workshop produksi musik digital untuk pemula sukses digelar di Jakarta. Acara ini diikuti oleh puluhan peserta yang ingin belajar membuat musik menggunakan software modern.\n\nInstruktur workshop adalah produser musik profesional yang sudah berpengalaman lebih dari 10 tahun. Mereka mengajarkan dasar-dasar produksi musik mulai dari recording, mixing, hingga mastering.\n\nPeserta workshop sangat antusias belajar dan banyak yang berhasil membuat track musik pertama mereka. Mereka juga mendapat kesempatan untuk berkonsultasi langsung dengan instruktur.\n\nPenyelenggara berencana mengadakan workshop lanjutan untuk peserta yang ingin mendalami produksi musik lebih lanjut.",
                'category_id' => $musicCategory->id,
                'status' => 'published',
                'published_at' => now()->subDays(6),
                'views' => 134,
            ],
            [
                'title' => 'Pemerintah Luncurkan Program Digitalisasi UMKM',
                'excerpt' => 'Program digitalisasi UMKM diluncurkan untuk membantu pelaku usaha kecil menengah go digital dan meningkatkan penjualan.',
                'content' => "Pemerintah Indonesia meluncurkan program digitalisasi UMKM untuk membantu pelaku usaha kecil menengah bertransformasi digital. Program ini menyediakan pelatihan dan bantuan teknologi gratis.\n\nRibuan UMKM di seluruh Indonesia sudah mendaftar untuk mengikuti program ini. Mereka akan mendapat pelatihan tentang e-commerce, digital marketing, dan manajemen bisnis online.\n\nMenteri Koperasi dan UKM menyatakan bahwa program ini sangat penting untuk meningkatkan daya saing UMKM di era digital. Pemerintah berkomitmen untuk terus mendukung pelaku UMKM.\n\nProgram ini diharapkan dapat membantu UMKM meningkatkan penjualan dan memperluas jangkauan pasar mereka hingga ke mancanegara.",
                'category_id' => $newsCategory->id,
                'status' => 'published',
                'published_at' => now()->subDays(7),
                'views' => 421,
            ],
            [
                'title' => 'Album Baru Musisi Indonesia Trending di Spotify',
                'excerpt' => 'Album terbaru dari musisi Indonesia berhasil trending di Spotify dan mendapat sambutan positif dari pendengar.',
                'content' => "Album terbaru dari seorang musisi Indonesia berhasil trending di Spotify Indonesia. Album ini berisi 12 lagu dengan berbagai genre yang menarik.\n\nMusisi tersebut mengaku sangat senang dengan sambutan positif dari pendengar. Album ini merupakan hasil kerja keras selama satu tahun penuh.\n\nBeberapa lagu dari album ini juga masuk dalam playlist populer di berbagai platform streaming musik. Hal ini membuktikan kualitas musik yang dihasilkan.\n\nPara kritikus musik memberikan review positif terhadap album ini. Mereka memuji kreativitas dan keunikan dari setiap lagu yang ada.",
                'category_id' => $musicCategory->id,
                'status' => 'published',
                'published_at' => now()->subDays(8),
                'views' => 298,
            ],
        ];

        foreach ($articles as $article) {
            $news = News::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($article['title'])],
                array_merge($article, ['author_id' => $user->id])
            );

            // Add sample citations for tech articles
            if ($article['category_id'] === $techCategory->id) {
                $news->citations()->createMany([
                    [
                        'author' => 'Smith, J., & Johnson, M.',
                        'title' => 'Artificial Intelligence in Modern Business',
                        'source' => 'Journal of Technology Management',
                        'year' => '2024',
                        'volume' => '15',
                        'issue' => '3',
                        'pages' => '245-260',
                        'doi' => '10.1234/jtm.2024.15.3.245',
                        'type' => 'journal',
                        'order' => 0,
                    ],
                    [
                        'author' => 'Brown, A.',
                        'title' => 'Digital Transformation in Southeast Asia',
                        'source' => 'Tech Publishers',
                        'year' => '2023',
                        'type' => 'book',
                        'order' => 1,
                    ],
                ]);
            }

            // Add sample citations for music articles
            if ($article['category_id'] === $musicCategory->id) {
                $news->citations()->createMany([
                    [
                        'author' => 'Wijaya, I. K.',
                        'title' => 'Preserving Traditional Balinese Music',
                        'source' => 'Asian Music Studies',
                        'year' => '2024',
                        'volume' => '8',
                        'issue' => '2',
                        'pages' => '112-128',
                        'type' => 'journal',
                        'order' => 0,
                    ],
                ]);
            }
        }

        $this->command->info('News seeded successfully!');
    }
}
