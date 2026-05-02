<div>
    <div class="flex justify-between items-center mb-4">
        <flux:heading size="lg">Menunggu verifikasi</flux:heading>
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
                            <div class="flex justify-end items-center gap-x-1">
                                <flux:button as="a" :href="route('admin.ustaz-verification-show', $u)" size="sm" variant="subtle" icon="document-text" class="shrink-0" />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
    </flux:table>
</div>