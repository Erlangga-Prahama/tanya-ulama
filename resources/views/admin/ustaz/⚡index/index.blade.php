<div>
    <div class="flex justify-between items-center mb-4">
        <flux:heading size="lg">Daftar ustaz dan ustazah</flux:heading>
        
        <flux:button size="sm" icon="plus">Tambah</flux:button>
    </div>
    
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
                            <div class="flex justify-end items-center">
                                <flux:tooltip content="Dokumen pendidikan">
                                    <flux:button as="a" :href="route('admin.ustaz-verification-show', $u)" size="sm" variant="subtle" icon="document-text" class="shrink-0" />
                                </flux:tooltip>
                                <flux:modal.trigger name="delete-modal">
                                    <flux:tooltip content="Hapus">
                                        <flux:button wire:click="confirmDelete({{ $u->id }})" as="button" size="xs" variant="primary" color="rose" icon="trash" class="shrink-0" />
                                    </flux:tooltip>
                                </flux:modal.trigger>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
    </flux:table>

    <flux:modal name="delete-modal" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Hapus ustaz?</flux:heading>
                <flux:text class="mt-2">
                    Anda yakin?<br>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>

                <flux:button wire:click="delete" variant="danger">Hapus</flux:button>
            </div>
        </div>
    </flux:modal>
</div>