<flux:header container class="bg-green-600 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.toggle class="lg:hidden text-white!" icon="bars-2" inset="left" />
    <flux:brand href="#" name="Tanya Ulama." color="white" class="max-lg:hidden dark:hidden font-bold" />
    <flux:brand href="#" name="Tanya Ulama." color="white" class="max-lg:hidden !hidden dark:flex font-bold" />
    <flux:navbar class="-mb-px max-lg:hidden text-white!">
        <flux:navbar.item icon="chat-bubble-bottom-center-text" variant="solid" href="#" current class="text-white!">Pertanyaan</flux:navbar.item>
    </flux:navbar>
    <flux:spacer />
    <flux:navbar class="me-4">
        <flux:navbar.item icon="magnifying-glass" href="#" label="Search" />
        <flux:navbar.item class="max-lg:hidden" icon="cog-6-tooth" href="#" label="Settings" />
        <flux:navbar.item class="max-lg:hidden" icon="information-circle" href="#" label="Help" />
    </flux:navbar>
    {{-- <flux:dropdown position="top" align="start" class="text-white!">
        <flux:profile avatar="https://fluxui.dev/img/demo/user.png" class="text-white! dark:text-white!"  />
        <flux:menu>
            <flux:menu.radio.group class="text-white!">
                <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                <flux:menu.radio>Truly Delta</flux:menu.radio>
            </flux:menu.radio.group>
            <flux:menu.separator />
            <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
        </flux:menu>
    </flux:dropdown> --}}
</flux:header>

<flux:sidebar sticky collapsible="mobile" class="lg:hidden bg-slate-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.header>
        <flux:sidebar.brand
            href="#"
            logo=""
            logo:dark=""
            name="Tanya Ulama."
        />
        <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
    </flux:sidebar.header>
    <flux:sidebar.nav>
        <flux:sidebar.group expandable icon="chat-bubble-bottom-center-text" heading="Pertanyaan" class="grid">
            <flux:sidebar.item href="{{ route('post.index') }}">Daftar Pertanyaan</flux:sidebar.item>
            <flux:sidebar.item href="{{ route('post.create') }}">Buat Pertayaan</flux:sidebar.item>
            <flux:sidebar.item href="#">Pertanyaan Anda</flux:sidebar.item>
        </flux:sidebar.group>
    </flux:sidebar.nav>
    <flux:sidebar.spacer />
    <flux:sidebar.nav>
        <flux:sidebar.item icon="cog-6-tooth" href="#">Settings</flux:sidebar.item>
        <flux:sidebar.item icon="information-circle" href="#">Help</flux:sidebar.item>
    </flux:sidebar.nav>
</flux:sidebar>