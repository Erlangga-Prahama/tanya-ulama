<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            'Apa hukum shalat berjamaah di masjid bagi laki-laki?',
            'Bagaimana cara menghitung zakat penghasilan?',
            'Apakah boleh membaca Al-Quran tanpa wudhu?',
            'Apa hukum puasa bagi ibu hamil?',
            'Bagaimana tata cara shalat jenazah?',
            'Apakah doa qunut wajib dalam shalat subuh?',
            'Apa hukum mendengarkan musik dalam Islam?',
            'Bagaimana cara bertaubat yang benar?',
            'Apakah boleh shalat dengan pakaian yang terkena najis kecil?',
            'Apa hukum merayakan ulang tahun dalam Islam?',
            'Bagaimana hukum asuransi dalam Islam?',
            'Apakah boleh berpuasa sunnah tanpa sahur?',
            'Apa hukum memotong kuku saat haid?',
            'Bagaimana cara menjama shalat dalam perjalanan?',
            'Apakah sah shalat jika lupa membaca surat Al-Fatihah?',
            'Apa hukum makan makanan yang dimasak dengan babi tapi tidak mengandung babi?',
            'Bagaimana hukum bekerja di bank konvensional?',
            'Apakah boleh shalat di atas sajadah yang ada gambar makhluk hidup?',
            'Apa hukum mengucapkan selamat natal kepada non-muslim?',
            'Bagaimana cara menghitung nisab zakat emas?',
            'Apakah boleh membayar zakat fitrah dengan uang?',
            'Apa hukum wanita shalat tanpa mukena?',
            'Bagaimana hukum donor darah dalam Islam?',
            'Apakah boleh berdoa dengan bahasa selain Arab?',
            'Apa hukum tidur setelah shalat subuh?',
        ];

        foreach ($questions as $content) {
            Question::create([
                'user_id' => 1,
                'content' => $content,
                'is_answered' => false,
            ]);
        }
    }
}