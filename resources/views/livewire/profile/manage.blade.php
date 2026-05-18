<div class="mx-auto max-w-3xl space-y-6">
    <x-hotel.page-header :title="__('Profil')" :subtitle="__('Kelola informasi akun dan keamanan.')" />

    <x-hotel.card>
        <livewire:profile.update-profile-information-form />
    </x-hotel.card>

    <x-hotel.card>
        <livewire:profile.update-password-form />
    </x-hotel.card>

    <x-hotel.card>
        <livewire:profile.delete-user-form />
    </x-hotel.card>
</div>
