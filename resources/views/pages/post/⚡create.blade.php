<?php

use Livewire\Component;
use Livewire\Attributes\Validate; 
use Livewire\Attributes\Layout;
use App\Models\Question;

new #[Layout('layouts::user')] class extends Component
{

    #[Validate('required')]
    public $content = '';

    public function save()
    {
        $this->validate();

        Question::create([
            'user_id' => auth()->id(),
            'content' => $this->content,
        ]);

        return $this->redirect('/pertanyaan', navigate: true);
    }
};
?>

<div class="min-h-screen bg-slate-50 flex flex-col">
    <div class="mx-4 mt-6 flex-1">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-xl font-bold text-slate-800">Buat Pertanyaan</h1>
            <p class="text-sm text-slate-400 mt-0.5">Tanyakan apa saja, kami akan bantu carikan jawabannya.</p>
        </div>

        {{-- Form --}}
        <form wire:submit="save">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

                {{-- Textarea --}}
                <textarea
                    wire:model="content"
                    placeholder="Tulis pertanyaanmu di sini..."
                    rows="8"
                    class="w-full px-4 pt-4 pb-2 text-sm text-slate-700 placeholder-slate-300 outline-none resize-none bg-transparent"
                ></textarea>

                {{-- Footer form --}}
                <div class="flex items-center justify-between px-4 py-3 border-t border-slate-100 bg-slate-50">
                    <p class="text-xs text-slate-400">Pertanyaan bersifat anonim</p>
                    <button
                        type="submit"
                        class="flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-xl transition"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Kirim
                    </button>
                </div>
            </div>

            @error('content')
                <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p>
            @enderror
        </form>

        {{-- Tips --}}
        <div class="mt-4 bg-emerald-50 border border-emerald-100 rounded-xl p-4">
            <p class="text-xs font-semibold text-emerald-700 mb-2">Tips bertanya yang baik</p>
            <ul class="space-y-1">
                <li class="text-xs text-emerald-600 flex items-start gap-1.5">
                    <span class="mt-0.5">•</span> Jelaskan konteks pertanyaan dengan detail
                </li>
                <li class="text-xs text-emerald-600 flex items-start gap-1.5">
                    <span class="mt-0.5">•</span> Gunakan bahasa yang sopan dan jelas
                </li>
                <li class="text-xs text-emerald-600 flex items-start gap-1.5">
                    <span class="mt-0.5">•</span> Pastikan pertanyaan berkaitan dengan agama Islam
                </li>
            </ul>
        </div>

    </div>
</div>