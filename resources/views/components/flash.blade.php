@if (session('status'))
<div x-data="{ show: true }"
     x-init="setTimeout(() => show = false, 2500)"
     x-show="show"
     x-transition
     class="fixed top-4 left-1/2 -translate-x-1/2 z-50">
    <div class="px-4 py-2 rounded-lg bg-emerald-600 text-white shadow">
        {{ session('status') }}
    </div>
</div>
@endif

