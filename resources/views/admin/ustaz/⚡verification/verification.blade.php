<div>
    <div class="flex justify-between items-center mb-4">
        <flux:heading size="lg">Menunggu verifikasi</flux:heading>
        
        <flux:button size="sm" icon="plus">Tambah</flux:button>
    </div>
    
    <flux:table>
        @foreach ($ustaz as $u)
            <flux:table.rows>
                <flux:table.row>
                    <flux:table.cell>
                        <div class="flex items-center gap-2 sm:gap-4">
                            <div class="flex flex-col">
                                <flux:heading class="capitalize">{{ $u->roles->first()->name }} {{ $u->name }}<flux:badge size="sm" color="blue" class="ml-1 max-sm:hidden">You</flux:badge></flux:heading>
                                <flux:text class="max-sm:hidden">{{ $u->email }}</flux:text>
                            </div>
                        </div>
                    </flux:table.cell>

                    <flux:table.cell>
                        <div class="flex justify-end items-center gap-x-1">
                            <flux:button as="a" :href="route('admin.ustaz-verification-show', $u)" size="xs" variant="primary" color="sky" icon="document-text" class="shrink-0" />
                            <flux:button size="xs" variant="primary"  color="rose" icon="trash" class="shrink-0" />
                            <flux:button size="xs" variant="primary"  color="emerald" icon="check-circle" class="shrink-0" />
                            
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            </flux:table.rows>
        @endforeach
    </flux:table>
</div>