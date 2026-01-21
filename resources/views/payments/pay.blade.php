<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">Pembayaran Pesanan #{{ $order->id }}</h2>
            <div class="text-sm font-semibold bg-emerald-50 text-emerald-700 px-3 py-1 rounded">Total Rp {{ number_format($order->total) }}</div>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-xl shadow ring-1 ring-gray-100 p-6">
                <h3 class="text-lg font-semibold">Pilih Metode</h3>
                <form class="mt-4 space-y-4" action="{{ route('payments.start', $order) }}" method="POST">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Metode</label>
                        <select name="method" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" required>
                            <option value="bank_transfer">Transfer Bank</option>
                            <option value="e_wallet">E-Wallet</option>
                            <option value="qris">QRIS</option>
                        </select>
                        @error('method') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Provider</label>
                        <select name="provider" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600" required>
                            <optgroup label="Bank">
                                <option>BCA</option>
                                <option>Mandiri</option>
                                <option>BNI</option>
                                <option>BRI</option>
                            </optgroup>
                            <optgroup label="E-Wallet">
                                <option>OVO</option>
                                <option>GoPay</option>
                                <option>DANA</option>
                                <option>ShopeePay</option>
                            </optgroup>
                            <optgroup label="QRIS">
                                <option>QRIS</option>
                            </optgroup>
                        </select>
                        @error('provider') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button class="px-4 py-2 rounded-lg bg-indigo-600 !text-white shadow">Lanjut</button>
                </form>
            </div>
            <div class="bg-white rounded-xl shadow ring-1 ring-gray-100 p-6">
                <div class="text-sm text-gray-600">Ringkasan</div>
                <div class="mt-3 space-y-2">
                    @foreach($order->items as $i)
                        <div class="flex items-center justify-between text-sm">
                            <div>Item #{{ $i->id }}</div>
                            <div>Rp {{ number_format($i->price * $i->quantity) }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 border-t pt-3 flex items-center justify-between">
                    <div class="font-medium">Total</div>
                    <div class="font-bold">Rp {{ number_format($order->total) }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

