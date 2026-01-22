<script>
    window.regionHandler = function() {
        return {
            provinces: [],
            regencies: [],
            districts: [],
            villages: [],
            
            selectedProvinceId: '',
            selectedRegencyId: '',
            selectedDistrictId: '',
            selectedVillageId: '',
            
            streetAddress: '',
            postalCode: '',
            savedLocationStr: '',
            initialized: false,

            initLocation(savedLocation, savedAddress) {
                // Fetch Provinces on Init
                fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
                    .then(response => response.json())
                    .then(data => this.provinces = data)
                    .catch(err => console.error('Error fetching provinces:', err));
                
                if (savedAddress) {
                    this.streetAddress = savedAddress; 
                }
                if (savedLocation) {
                    this.savedLocationStr = savedLocation;
                }
                setTimeout(() => this.applySavedSelection(), 300);
            },

            fetchRegencies() {
                if (!this.selectedProvinceId) return;
                return fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${this.selectedProvinceId}.json`)
                    .then(response => response.json())
                    .then(data => {
                        this.regencies = data;
                        this.selectedRegencyId = '';
                        this.districts = [];
                        this.villages = [];
                    })
                    .catch(err => console.error('Error fetching regencies:', err));
            },

            fetchDistricts() {
                if (!this.selectedRegencyId) return;
                return fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${this.selectedRegencyId}.json`)
                    .then(response => response.json())
                    .then(data => {
                        this.districts = data;
                        this.selectedDistrictId = '';
                        this.villages = [];
                    })
                    .catch(err => console.error('Error fetching districts:', err));
            },

            fetchVillages() {
                if (!this.selectedDistrictId) return;
                return fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${this.selectedDistrictId}.json`)
                    .then(response => response.json())
                    .then(data => {
                        this.villages = data;
                        this.selectedVillageId = '';
                    })
                    .catch(err => console.error('Error fetching villages:', err));
            },
            
            getProvinceName() {
                let prov = this.provinces.find(p => p.id === this.selectedProvinceId);
                return prov ? prov.name : '';
            },

            getRegencyName() {
                let reg = this.regencies.find(r => r.id === this.selectedRegencyId);
                return reg ? reg.name : '';
            },

            getDistrictName() {
                let dist = this.districts.find(d => d.id === this.selectedDistrictId);
                return dist ? dist.name : '';
            },

            getVillageName() {
                let vil = this.villages.find(v => v.id === this.selectedVillageId);
                return vil ? vil.name : '';
            },

            getLocationString() {
                let city = this.getRegencyName();
                let prov = this.getProvinceName();
                return city && prov ? `${city}, ${prov}` : '';
            },
            
            getLocationEffective() {
                const computed = this.getLocationString();
                return computed !== '' ? computed : (this.savedLocationStr || '');
            },

            getFullAddress() {
                let parts = [this.streetAddress];
                let vil = this.getVillageName();
                let dist = this.getDistrictName();
                
                if (vil) parts.push(`Kel. ${vil}`);
                if (dist) parts.push(`Kec. ${dist}`);
                if (this.postalCode) parts.push(`Kode Pos ${this.postalCode}`);
                
                return parts.filter(p => p).join(', ');
            },
            
            applySavedSelection() {
                if (this.initialized) return;
                const loc = (this.savedLocationStr || '').trim();
                const addr = (this.streetAddress || '').trim();
                if (!loc && !addr) return;
                const parts = loc.split(',').map(s => s.trim());
                const savedCity = parts[0] || '';
                const savedProv = parts[1] || '';
                const findByName = (list, name) => {
                    const target = (name || '').toLowerCase();
                    return list.find(it => {
                        const n = (it.name || '').toLowerCase();
                        return n === target || n.includes(target);
                    });
                };
                const parseAddr = (txt) => {
                    let vMatch = txt.match(/Kel\.?\s*([^,]+)/i) || txt.match(/Desa\.?\s*([^,]+)/i) || txt.match(/Kelurahan\.?\s*([^,]+)/i);
                    let dMatch = txt.match(/Kec\.?\s*([^,]+)/i) || txt.match(/Kecamatan\.?\s*([^,]+)/i);
                    let pMatch = txt.match(/Kode\s*Pos\s*([0-9]+)/i);
                    return {
                        village: vMatch ? vMatch[1].trim() : '',
                        district: dMatch ? dMatch[1].trim() : '',
                        postal: pMatch ? pMatch[1].trim() : ''
                    };
                };
                const adr = parseAddr(addr);
                if (savedProv) {
                    const p = findByName(this.provinces, savedProv);
                    if (p) {
                        this.selectedProvinceId = p.id;
                        this.fetchRegencies()?.then(() => {
                            if (savedCity) {
                                const r = findByName(this.regencies, savedCity);
                                if (r) {
                                    this.selectedRegencyId = r.id;
                                    this.fetchDistricts()?.then(() => {
                                        if (adr.district) {
                                            const d = findByName(this.districts, adr.district);
                                            if (d) {
                                                this.selectedDistrictId = d.id;
                                                this.fetchVillages()?.then(() => {
                                                    if (adr.village) {
                                                        const v = findByName(this.villages, adr.village);
                                                        if (v) {
                                                            this.selectedVillageId = v.id;
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
                if (adr.postal) {
                    this.postalCode = adr.postal;
                }
                this.initialized = true;
            }
        }
    }
</script>

<section class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
    <header class="mb-8 border-b border-gray-100 pb-4">
        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
            <i class='bx bx-user-circle text-2xl text-indigo-600'></i>
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui informasi profil akun dan alamat email Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Bagian Informasi Dasar -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-span-1 md:col-span-2">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Data Diri</h3>
            </div>

            <div class="col-span-1 md:col-span-1">
                <x-input-label for="name" :value="__('Nama Lengkap')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="col-span-1 md:col-span-1">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-sm text-gray-800">
                            {{ __('Email Anda belum diverifikasi.') }}
                            <button form="send-verification" class="underline text-sm text-indigo-600 hover:text-indigo-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="col-span-1 md:col-span-2" x-data="window.regionHandler()" x-init="initLocation({{ json_encode($user->location) }}, {{ json_encode($user->address) }})">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4 mt-2">Alamat Lengkap</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Provinsi -->
                    <div class="col-span-1">
                        <x-input-label for="province" :value="__('Provinsi')" />
                        <select id="province" class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" x-model="selectedProvinceId" @change="fetchRegencies()">
                            <option value="">-- Pilih Provinsi --</option>
                            <template x-for="prov in provinces" :key="prov.id">
                                <option :value="prov.id" x-text="prov.name"></option>
                            </template>
                        </select>
                        <input type="hidden" name="province_name" :value="getProvinceName()">
                    </div>

                    <!-- Kota/Kabupaten -->
                    <div class="col-span-1">
                        <x-input-label for="city" :value="__('Kota/Kabupaten')" />
                        <select id="city" class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" x-model="selectedRegencyId" @change="fetchDistricts()" :disabled="!selectedProvinceId">
                            <option value="">-- Pilih Kota/Kabupaten --</option>
                            <template x-for="reg in regencies" :key="reg.id">
                                <option :value="reg.id" x-text="reg.name"></option>
                            </template>
                        </select>
                        <!-- Sync to location field -->
                        <input type="hidden" name="location" :value="getLocationEffective()">
                    </div>

                    <!-- Kecamatan -->
                    <div class="col-span-1">
                        <x-input-label for="district" :value="__('Kecamatan')" />
                        <select id="district" class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" x-model="selectedDistrictId" @change="fetchVillages()" :disabled="!selectedRegencyId">
                            <option value="">-- Pilih Kecamatan --</option>
                            <template x-for="dist in districts" :key="dist.id">
                                <option :value="dist.id" x-text="dist.name"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Desa/Kelurahan -->
                    <div class="col-span-1">
                        <x-input-label for="village" :value="__('Desa/Kelurahan')" />
                        <select id="village" class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" x-model="selectedVillageId" :disabled="!selectedDistrictId">
                            <option value="">-- Pilih Desa/Kelurahan --</option>
                            <template x-for="vil in villages" :key="vil.id">
                                <option :value="vil.id" x-text="vil.name"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Kode Pos -->
                    <div class="col-span-1">
                        <x-input-label for="postal_code" :value="__('Kode Pos')" />
                        <input type="text" id="postal_code" x-model="postalCode" class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: 12345">
                    </div>

                    <!-- Detail Alamat -->
                    <div class="col-span-1 md:col-span-2">
                        <x-input-label for="address_detail" :value="__('Detail Alamat (Jalan, No. Rumah, RT/RW)')" />
                        <textarea id="address_detail" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" x-model="streetAddress" placeholder="Contoh: Jl. Mawar No. 12, RT 01/RW 02"></textarea>
                        
                        <!-- Sync to address field -->
                        <input type="hidden" name="address" :value="getFullAddress()">
                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                    </div>
                </div>
            </div>

            <!-- Existing Location Field Removed (replaced by hidden input above) -->
            <!-- Existing Phone Field Kept -->
            <div class="col-span-1">
                <x-input-label for="phone" :value="__('Nomor Handphone')" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class='bx bx-phone text-gray-400'></i>
                    </div>
                    <x-text-input id="phone" name="phone" type="text" class="pl-10 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" :value="old('phone', $user->phone)" autocomplete="tel" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            </div>

        <!-- Bagian Informasi Pembayaran -->
        <div class="mt-10 pt-6 border-t border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <i class='bx bx-credit-card text-xl text-indigo-600'></i>
                {{ __('Metode Penerimaan Pembayaran') }}
            </h3>
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class='bx bx-info-circle text-blue-500 text-xl'></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Pembeli akan melakukan transfer ke rekening/e-wallet yang Anda masukkan di bawah ini. Pastikan nomor yang Anda masukkan valid dan aktif.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Bank -->
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 hover:border-indigo-300 transition shadow-sm">
                    <div class="flex items-center gap-2 mb-4 text-indigo-700 font-bold border-b border-gray-200 pb-2">
                        <i class='bx bxs-bank text-xl'></i> Rekening Bank
                    </div>
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="bank_provider" :value="__('Bank Provider')" class="text-gray-700 font-medium" />
                            <select id="bank_provider" name="bank_provider" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Bank --</option>
                                @foreach(['BCA','Mandiri','BNI','BRI','BSI','CIMB Niaga'] as $bank)
                                    <option value="{{ $bank }}" @selected(old('bank_provider', $user->bank_provider) === $bank)>{{ $bank }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('bank_provider')" />
                        </div>
                        <div>
                            <x-input-label for="bank_account_number" :value="__('Nomor Rekening')" class="text-gray-700 font-medium" />
                            <x-text-input id="bank_account_number" name="bank_account_number" type="text" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" :value="old('bank_account_number', $user->bank_account_number)" placeholder="Contoh: 1234567890" autocomplete="off" />
                            <x-input-error class="mt-2" :messages="$errors->get('bank_account_number')" />
                        </div>
                    </div>
                </div>

                <!-- Kolom E-Wallet -->
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 hover:border-indigo-300 transition shadow-sm">
                    <div class="flex items-center gap-2 mb-4 text-indigo-700 font-bold border-b border-gray-200 pb-2">
                        <i class='bx bxs-wallet text-xl'></i> E-Wallet
                    </div>
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="ewallet_provider" :value="__('E-Wallet Provider')" class="text-gray-700 font-medium" />
                            <select id="ewallet_provider" name="ewallet_provider" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih E-Wallet --</option>
                                @foreach(['OVO','GoPay','DANA','ShopeePay','LinkAja'] as $ew)
                                    <option value="{{ $ew }}" @selected(old('ewallet_provider', $user->ewallet_provider) === $ew)>{{ $ew }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('ewallet_provider')" />
                        </div>
                        <div>
                            <x-input-label for="ewallet_number" :value="__('Nomor HP / E-Wallet')" class="text-gray-700 font-medium" />
                            <x-text-input id="ewallet_number" name="ewallet_number" type="text" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" :value="old('ewallet_number', $user->ewallet_number)" placeholder="Contoh: 0812xxxxxx" autocomplete="off" />
                            <x-input-error class="mt-2" :messages="$errors->get('ewallet_number')" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metode Tambahan -->
            <div class="mt-8 pt-6 border-t border-gray-100" x-data="{ rows: {{ json_encode(($user->payouts ?? collect())->map(fn($p)=>['type'=>$p->type,'provider'=>$p->provider,'account'=>$p->account_number,'label'=>$p->label])) }} }">
                <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <i class='bx bx-layer-plus text-indigo-600 text-lg'></i>
                        Metode Payout Tambahan (Opsional)
                    </span>
                    <span class="text-xs font-normal text-gray-500 bg-gray-100 px-2 py-1 rounded">Jika Anda memiliki lebih dari satu rekening</span>
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <template x-for="(row,idx) in rows" :key="idx">
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 hover:border-indigo-300 transition shadow-sm relative group">
                            
                            <!-- Tombol Hapus -->
                            <button type="button" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 bg-white rounded-full p-1.5 shadow-sm border border-gray-200 hover:border-red-200 transition z-10" @click="rows.splice(idx,1)" title="Hapus Metode Ini">
                                <i class='bx bx-trash text-lg'></i>
                            </button>
            
                            <!-- Header / Type Selector -->
                            <div class="mb-4 border-b border-gray-200 pb-3">
                                 <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tipe Akun</label>
                                 <div class="flex items-center gap-4">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" :name="'payout_type_radio_'+idx" value="bank" x-model="row.type" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                        <span class="text-sm font-medium text-gray-700 flex items-center gap-1"><i class='bx bxs-bank'></i> Bank</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" :name="'payout_type_radio_'+idx" value="ewallet" x-model="row.type" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                        <span class="text-sm font-medium text-gray-700 flex items-center gap-1"><i class='bx bxs-wallet'></i> E-Wallet</span>
                                    </label>
                                 </div>
                                 <input type="hidden" :name="'payout_type[]'" x-model="row.type">
                            </div>
            
                            <!-- Fields -->
                            <div class="space-y-4">
                                <!-- Bank Fields -->
                                <template x-if="row.type == 'bank'">
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Bank Provider</label>
                                            <select :name="'payout_provider[]'" x-model="row.provider" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="">-- Pilih Bank --</option>
                                                @foreach(['BCA','Mandiri','BNI','BRI','BSI','CIMB Niaga'] as $bank)
                                                    <option value="{{ $bank }}">{{ $bank }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Rekening</label>
                                            <input type="text" :name="'payout_account[]'" x-model="row.account" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Contoh: 1234567890">
                                        </div>
                                    </div>
                                </template>
            
                                <!-- E-Wallet Fields -->
                                <template x-if="row.type == 'ewallet'">
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">E-Wallet Provider</label>
                                            <select :name="'payout_provider[]'" x-model="row.provider" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="">-- Pilih E-Wallet --</option>
                                                @foreach(['OVO','GoPay','DANA','ShopeePay','LinkAja'] as $ew)
                                                    <option value="{{ $ew }}">{{ $ew }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP / E-Wallet</label>
                                            <input type="text" :name="'payout_account[]'" x-model="row.account" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Contoh: 0812xxxxxx">
                                        </div>
                                    </div>
                                </template>
                                
                                <!-- Label Field (Optional) -->
                                <div class="pt-2 border-t border-gray-200 border-dashed">
                                     <label class="block text-xs text-gray-400 mb-1">Label (Opsional)</label>
                                     <input type="text" :name="'payout_label[]'" x-model="row.label" class="block w-full rounded-lg border-gray-200 text-xs focus:border-indigo-500 focus:ring-indigo-500 bg-white placeholder-gray-300" placeholder="Misal: Rekening Tabungan">
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <!-- Tombol Tambah Card -->
                    <button type="button" class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-300 rounded-xl hover:border-indigo-500 hover:bg-indigo-50 transition group min-h-[300px]" @click="rows.push({type:'bank',provider:'',account:'',label:''})">
                        <div class="h-14 w-14 rounded-full bg-gray-100 group-hover:bg-white flex items-center justify-center mb-3 transition shadow-sm">
                            <i class='bx bx-plus text-3xl text-gray-400 group-hover:text-indigo-600 transition'></i>
                        </div>
                        <span class="text-sm font-bold text-gray-500 group-hover:text-indigo-700">Tambah Metode Lain</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-gray-100">
             <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                <div>
                    <x-input-label for="profile_photo" :value="__('Foto Profil')" />
                    <div class="mt-2 flex items-center gap-6">
                        @if($user->profile_photo_path)
                            <div class="relative group">
                                <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="Foto Profil" class="h-20 w-20 rounded-full object-cover ring-4 ring-gray-100 shadow-sm">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 rounded-full transition-all duration-300"></div>
                            </div>
                        @else
                            <div class="h-20 w-20 rounded-full bg-indigo-100 flex items-center justify-center ring-4 ring-gray-100 text-indigo-500 font-bold text-2xl">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <input id="profile_photo" name="profile_photo" type="file" accept="image/*" class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100
                            "/>
                            <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
                </div>
             </div>
        </div>

        <div class="flex items-center gap-4 mt-8 pt-6 border-t border-gray-100 justify-end">
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium flex items-center gap-1"
                >
                    <i class='bx bx-check-circle'></i> {{ __('Berhasil disimpan.') }}
                </p>
            @endif

            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 px-8 py-3 text-base">
                {{ __('Simpan Perubahan') }}
            </x-primary-button>
        </div>
    </form>
</section>
