<footer class="bg-gray-800 text-white mt-12">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- About -->
            <div>
                <h3 class="text-lg font-semibold mb-4">TanyaJawab.com</h3>
                <p class="text-gray-400 text-sm">
                    Platform tanya jawab dengan expert terverifikasi.
                </p>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    {{-- <li><a href="{{ route('questions.index') }}" class="text-gray-400 hover:text-white">Semua Pertanyaan</a></li> --}}
                    <li><a href="/tentang" class="text-gray-400 hover:text-white">Tentang Kami</a></li>
                    <li><a href="/kontak" class="text-gray-400 hover:text-white">Kontak</a></li>
                    <li><a href="/syarat-ketentuan" class="text-gray-400 hover:text-white">Syarat & Ketentuan</a></li>
                </ul>
            </div>
            
            <!-- For Experts -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Untuk Expert</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('register.expert') }}" class="text-gray-400 hover:text-white">Daftar Jadi Expert</a></li>
                    <li><a href="/panduan-expert" class="text-gray-400 hover:text-white">Panduan Expert</a></li>
                    <li><a href="/syarat-expert" class="text-gray-400 hover:text-white">Syarat Menjadi Expert</a></li>
                </ul>
            </div>
            
            <!-- Social Media -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Ikuti Kami</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879v-6.99h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.99C18.343 21.128 22 16.991 22 12z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 0021.893-11.5c0-.21-.005-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} TanyaJawab.com. All rights reserved.
        </div>
    </div>
</footer>