<div>
    <div class="flex justify-between items-center mb-4">
        <flux:heading size="lg">Menunggu verifikasi</flux:heading>
    </div>

    @if($ustaz->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-700">Semua sudah terverifikasi!</p>
            <p class="text-xs text-slate-400 mt-1">Tidak ada ustaz/ustazah yang menunggu verifikasi.</p>
        </div>
    @else
        <flux:table>
            <flux:table.rows>
                @foreach ($ustaz as $u)
                    <flux:table.row>
                        <flux:table.cell>
                            <div class="flex items-center gap-2 sm:gap-4">
                                <div class="flex flex-col">
                                    <flux:heading class="capitalize">{{ $u->roles->first()->name }} {{ $u->name }}</flux:heading>
                                    <flux:text class="max-sm:hidden">{{ $u->email }}</flux:text>
                                </div>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="flex justify-end items-center gap-x-1">
                                <flux:button as="a" :href="route('admin.ustaz-verification-show', $u)" size="sm" variant="subtle" icon="document-text" class="shrink-0" />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    @endif
</div>