<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <h3 class="text-lg font-semibold text-gray-900 text-center">Manajemen Konten Saya</h3>
                    <p class="mt-1 text-sm text-gray-600 text-center">Edit atau hapus produk/kebutuhan hanya melalui halaman ini.</p>
                    <div class="mt-4 flex items-center justify-center gap-3">
                        <a href="{{ route('products.mine') }}" class="px-4 py-2 rounded-lg bg-indigo-600 text-white shadow hover:bg-indigo-500">Produk Saya</a>
                        <a href="{{ route('needs.mine') }}" class="px-4 py-2 rounded-lg bg-white border text-gray-900 shadow-sm hover:bg-gray-50">Kebutuhan Saya</a>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
