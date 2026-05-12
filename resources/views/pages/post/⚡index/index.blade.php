<div class="mt-4 mx-3 pb-6">

    <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-2 shadow-sm mb-4">
        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
        </svg>
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            placeholder="Cari pertanyaan..."
            class="text-sm text-slate-700 placeholder-slate-400 outline-none bg-transparent flex-1"
        />
        @if($search)
            <button wire:click="$set('search', '')" class="text-slate-300 hover:text-slate-500 transition">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>

    @if(auth()->user()->hasAnyRole(['ustaz', 'ustazah']) && !auth()->user()->is_verified)
        <div class="mb-4 flex gap-3 bg-amber-50 border border-amber-200 rounded-xl p-4">
            <div class="flex-shrink-0 mt-0.5">
                <div class="w-7 h-7 rounded-full bg-amber-100 flex items-center justify-center">
                    <svg class="h-4 w-4 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-sm font-semibold text-amber-800">Verifikasi Sedang Diproses</p>
                <p class="text-xs text-amber-600 mt-0.5 leading-relaxed">Dokumen Anda sedang kami review, membutuhkan waktu hingga <strong>1×24 jam</strong>.</p>
            </div>
        </div>
    @endif

    @if(auth()->user()->is_verified && auth()->user()->hasAnyRole(['ustaz', 'ustazah']) && auth()->user()->verified_at?->gt(now()->subHours(20)))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="mb-4 flex gap-3 bg-green-50 border border-green-200 rounded-xl p-4 relative"
        >
            <div class="flex-shrink-0 mt-0.5">
                <div class="w-7 h-7 rounded-full bg-green-500 flex items-center justify-center">
                    <svg class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-green-800">Akun Anda Telah Diverifikasi!</p>
                <p class="text-xs text-green-600 mt-0.5">Anda kini dapat menjawab pertanyaan dari pengguna.</p>
            </div>
            <button @click="show = false" class="text-green-300 hover:text-green-500 transition">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    @endif

<div class="relative w-full rounded-2xl overflow-hidden mb-6" style="min-height: 180px;">
    <img src="{{ asset('img/home.png') }}" alt="banner" class="absolute inset-0 w-full h-full object-cover">
    
    <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/30 rounded-2xl"></div>

    <div class="relative z-10 flex flex-col justify-center h-full px-5 py-8 md:px-10 md:py-12">
        <p class="text-xs font-medium text-green-300 uppercase tracking-widest mb-1">Tanya Ulama</p>
        <h2 class="text-lg md:text-2xl font-bold text-white leading-snug mb-1">
            Dapatkan Jawaban dari<br>Ustaz Terpercaya
        </h2>
        <p class="text-xs md:text-sm text-white/70 mb-4">Tanyakan apa saja, kami siap membantu.</p>

        @if(!auth()->user()->hasAnyRole(['ustaz', 'ustazah']))
            
            <a href="{{ route('posts.create') }}"
                class="self-start flex items-center gap-2 px-4 py-2 border border-white/50 hover:border-white text-white text-xs md:text-sm font-medium rounded-xl backdrop-blur-sm hover:bg-white/10 transition"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajukan Pertanyaan
            </a>
        @endif
    </div>
</div>

    @if(auth()->user()->isExpert())
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-1 h-4 bg-slate-300 rounded-full"></div>
                <p class="text-sm font-semibold text-slate-700">Menunggu Jawaban</p>
                @if($questionsCanBeAnswered->total() > 0)
                    <span class="ml-auto text-xs font-medium text-green-600 bg-green-50 border border-green-100 px-2 py-0.5 rounded-full">
                        {{ $questionsCanBeAnswered->total() }}
                    </span>
                @endif
            </div>

            @if($questionsCanBeAnswered->count() > 0)
                <div class="space-y-2">
                    @foreach ($questionsCanBeAnswered as $qc)
                        <a href="{{ route('post.show', $qc) }}" class="block group">
                            <div class="bg-white border border-slate-100 rounded-xl px-4 py-3 shadow-sm group-hover:border-green-200 group-hover:shadow-md transition-all duration-200">
                                <p class="text-sm text-slate-700 line-clamp-2 leading-relaxed">{!! $qc->short_content !!}</p>
                                <div class="flex items-center gap-1.5 mt-2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-amber-400"></div>
                                    <p class="text-xs text-slate-400">{{ $qc->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-3">{{ $questionsCanBeAnswered->links() }}</div>
            @else
                <div class="text-center py-8 text-slate-400 text-sm">Tidak ada pertanyaan baru.</div>
            @endif
        </div>
    @endif

    <div>
        <div class="flex items-center gap-2 mb-3">
            <div class="w-1 h-4 bg-green-800 rounded-full"></div>
            <p class="text-sm font-semibold text-slate-700">Pertanyaan Terbaru</p>
            @if($questions->total() > 0)
                <span class="ml-auto text-xs font-medium text-slate-500 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded-full">
                    {{ $questions->total() }}
                </span>
            @endif
        </div>

        @if($questions->count() > 0)
            <div class="space-y-2">
                @foreach ($questions as $q)
                    <a href="{{ route('post.show', $q) }}" class="block group">
                        <div class="bg-white border border-slate-100 rounded-xl px-4 py-3 shadow-sm group-hover:border-slate-200 group-hover:shadow-md transition-all duration-200">
                            <p class="text-sm text-slate-700 line-clamp-2 leading-relaxed">{!! $q->short_content !!}</p>
                            <div class="flex items-center gap-1.5 mt-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-green-800"></div>
                                <p class="text-xs text-slate-400">{{ $q->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-3">{{ $questions->links() }}</div>
        @else
            <div class="text-center py-8 text-slate-400 text-sm">Belum ada pertanyaan yang dijawab.</div>
        @endif
    </div>

</div>