@extends('layouts.app')

@section('title', 'Pilih Lapangan - FutsalKu')

@section('content')

<!-- Hero (same style as homepage) -->
<section class="relative bg-gradient-to-br from-green-600 via-green-700 to-green-900 text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-white text-sm font-semibold">Pilih Lapangan</span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mt-4">Pilih Lapangan Futsal Favoritmu</h1>
                <p class="text-lg text-green-100 mt-4 max-w-xl">Lihat detail lapangan, harga, dan ketersediaan jadwal. Pesan langsung dari halaman ini.</p>

                <div class="flex gap-4 mt-6">
                    <a href="#lapangan" class="inline-flex items-center gap-3 border border-white/30 px-5 py-3 rounded-lg text-white">Lihat Lapangan</a>
                </div>
            </div>

            <div class="hidden md:block">
                <div class="bg-white/10 rounded-3xl p-6">
                    <svg class="w-full h-56" viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="10" y="10" width="380" height="280" rx="20" fill="#10B981"/>
                        <rect x="40" y="40" width="320" height="220" rx="10" fill="#059669"/>
                        <line x1="200" y1="40" x2="200" y2="260" stroke="#fff" stroke-width="3"/>
                        <circle cx="200" cy="150" r="30" stroke="#fff" stroke-width="3" fill="none"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Grid (cards styled like homepage) -->
<section id="lapangan" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">Pilihan Lapangan</span>
            <h2 class="text-3xl font-bold text-gray-900 mt-4">Lapangan Futsal Kami</h2>
            <p class="text-gray-600 mt-2">Pilih lapangan sesuai kebutuhanmu dengan fasilitas terbaik</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @forelse($services as $service)
                <div class="group bg-gradient-to-br from-gray-50 to-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100 hover:border-green-500 transform hover:-translate-y-2">
                    <div class="relative h-56 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center overflow-hidden">
                            <div class="absolute inset-0 opacity-20">
                                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"40\" height=\"40\" viewBox=\"0 0 40 40\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.18\" fill-rule=\"evenodd\"%3E%3Cpath d=\"M0 40L40 0H20L0 20M40 40V20L20 40\"/%3E%3C/g%3E%3C/svg%3E');"></div>
                            </div>
                            <svg class="w-40 h-36 relative z-10" viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="30" y="30" width="340" height="220" rx="12" fill="#10B981" stroke="#ffffff" stroke-opacity="0.9" stroke-width="3"/>
                                <line x1="200" y1="30" x2="200" y2="250" stroke="#fff" stroke-width="2" stroke-opacity="0.9"/>
                                <circle cx="200" cy="140" r="28" stroke="#fff" stroke-width="3" fill="none"/>
                                <circle cx="200" cy="140" r="3" fill="#fff"/>
                            </svg>
                            @if($loop->index === 2)
                                <div class="absolute top-4 right-4 bg-yellow-400 text-gray-900 px-3 py-1 rounded-full text-xs font-bold z-20">VIP</div>
                            @endif
                        </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $service->name }}</h3>
                        <p class="text-sm text-gray-600 mb-4">{{ $service->description }}</p>
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-2xl font-bold text-green-600">Rp {{ number_format($service->price,0,',','.') }}</div>
                            <div class="text-sm text-gray-500">{{ $service->duration }} menit</div>
                        </div>
                        <a href="{{ route('service.detail', $service->id) }}" class="block w-full text-center bg-green-600 text-white py-3 rounded-xl font-bold">Lihat Detail & Booking</a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-gray-600">Belum ada lapangan tersedia.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- CTA Footer like homepage -->
{{-- <section class="bg-gradient-to-r from-green-600 to-green-800 text-white py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h3 class="text-2xl font-bold mb-4">Butuh Bantuan?</h3>
        <p class="text-green-100 mb-6">Hubungi admin atau cek halaman Dashboard untuk detail pemesanan.</p>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 bg-yellow-400 text-gray-900 px-6 py-3 rounded-lg font-semibold">Kembali ke Beranda</a>
    </div>
</section> --}}

@endsection

@push('scripts')
<script>
function searchBooking() {
    return {
        serviceId: '',
        date: '',
        slots: [],
        loading: false,
        searched: false,
        async searchSlots() {
            if (!this.serviceId || !this.date) return;
            this.loading = true; this.searched = false;
            try {
                const res = await fetch('{{ route("search.slots") }}', {
                    method: 'POST', headers: {'Content-Type':'application/json','X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
                    body: JSON.stringify({service_id: this.serviceId, date: this.date})
                });
                const data = await res.json();
                if (data.success) this.slots = data.slots; else this.slots = [];
                this.searched = true;
            } catch(e){ console.error(e); alert('Terjadi kesalahan'); }
            finally{ this.loading = false; }
        }
    }
}
</script>
@endpush
