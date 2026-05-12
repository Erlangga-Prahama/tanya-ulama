<flux:header sticky container class="bg-green-800 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700 z-50">
    <flux:sidebar.toggle class="lg:hidden text-white!" icon="bars-2" inset="left" />
    <flux:brand href="#" name="Tanya Ulama." color="white" class="max-lg:hidden dark:hidden font-bold" />
    <flux:brand href="#" name="Tanya Ulama." color="white" class="max-lg:hidden !hidden dark:flex font-bold" />
    <flux:navbar class="-mb-px max-lg:hidden text-white!">    
        <flux:dropdown>
            <flux:navbar.item icon:trailing="chat-bubble-bottom-center-text" class="text-white!">Pertanyaan</flux:navbar.item>
            <flux:navmenu>
                <flux:navmenu.item href="{{ route('posts.index') }}">Daftar pertanyaan</flux:navmenu.item>
                @if (!auth()->user()->hasAnyRole(['ustaz', 'ustazah']))
                    <flux:navmenu.item href="{{ route('posts.create') }}">Buat pertanyaan</flux:navmenu.item>
                    <flux:navmenu.item href="{{ route('post.user-posts') }}">Pertanyaan anda</flux:navmenu.item>
                @endif
            </flux:navmenu>
        </flux:dropdown>
    </flux:navbar>
    <flux:spacer />
    <flux:navbar class="flex justify-center lg:hidden">
            <flux:navbar.item href="#" class="text-green-800!">Tanya Ulama.</flux:navbar.item>
    </flux:navbar>
</flux:header>

<flux:sidebar sticky collapsible="mobile" class="lg:hidden bg-slate-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.header>
        <flux:sidebar.brand
            href="#"
            logo=""
            logo:dark=""
            name="Tanya Ulama."
            class="font-alhambra"
        />
        <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
    </flux:sidebar.header>
    <flux:sidebar.nav>
        <flux:sidebar.group expandable icon="chat-bubble-bottom-center-text" heading="Pertanyaan" class="grid">
            <flux:sidebar.item href="{{ route('posts.index') }}">Daftar pertanyaan</flux:sidebar.item>
            @if (!auth()->user()->hasAnyRole(['ustaz', 'ustazah']))
                <flux:sidebar.item href="{{ route('posts.create') }}">Buat pertayaan</flux:sidebar.item>
                <flux:sidebar.item href="{{ route('post.user-posts') }}">Pertanyaan anda</flux:sidebar.item>
            @endif
            {{-- @if (auth()->user()->hasAnyRole(['ustaz', 'ustazah']))
                <flux:sidebar.item href="#">Jawaban Anda</flux:sidebar.item>
            @endif --}}
        </flux:sidebar.group>
    </flux:sidebar.nav>
    <flux:sidebar.spacer />
    <flux:sidebar.nav>
        <flux:modal.trigger name="logout-modal">
            <flux:sidebar.item as="button" icon="arrow-right-start-on-rectangle" class="w-full">
                {{ __('Keluar') }}
            </flux:sidebar.item>
        </flux:modal.trigger>
        <flux:sidebar.item icon="information-circle" href="#">Bantuan</flux:sidebar.item>
    </flux:sidebar.nav>
</flux:sidebar>

<flux:modal name="logout-modal" class="min-w-[18rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Keluar?</flux:heading>
            <flux:text class="mt-2">
                Anda yakin?<br>
            </flux:text>
        </div>
        <div class="flex gap-2">
            <flux:spacer />
            <flux:modal.close>
                <flux:button variant="ghost">Batal</flux:button>
            </flux:modal.close>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <flux:button type="submit" variant="danger">Keluar</flux:button>
            </form>
        </div>
    </div>
</flux:modal>