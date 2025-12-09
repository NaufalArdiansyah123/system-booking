@extends('admin.layouts.app')

@section('title', 'Manage Bookings')
@section('page_title', 'Bookings')

@section('content')
<div class="flex items-center justify-between mb-6 pr-6">
    <div>
        <h3 class="text-xl font-bold text-gray-900">Manage Bookings</h3>
        <p class="text-sm text-gray-500 mt-1">Filter dan kelola semua booking dari sini</p>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden mr-6">
            <div class="p-4">
                <form method="GET" action="{{ route('admin.bookings.index') }}" class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-3">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode, user, service..." class="px-3 py-2 border rounded-md" />
                    <select name="status" class="px-3 py-2 border rounded-md">
                        <option value="">Semua status</option>
                        <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status')=='confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-md">Filter</button>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($bookings as $booking)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $booking->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($booking->service)->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ optional($booking->user)->name ?? 'Guest' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($booking->date ?? $booking->created_at)->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">Rp {{ number_format(optional($booking->payment)->amount ?? (optional($booking->service)->price ?? 0), 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($booking->status === 'pending')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">Menunggu</span>
                                        @elseif($booking->status === 'confirmed')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">Terkonfirmasi</span>
                                        @elseif($booking->status === 'cancelled')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">Dibatalkan</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('booking.details', $booking->id) }}" class="inline-flex items-center px-3 py-1 bg-white border border-gray-200 rounded-md text-sm text-gray-700 hover:shadow">Detail</a>
                                            @if($booking->status === 'pending')
                                                <form method="POST" action="{{ route('admin.bookings.confirm', $booking->id) }}" onsubmit="return confirm('Konfirmasi booking ini?')">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded-md text-sm">Konfirmasi</button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.bookings.reject', $booking->id) }}" onsubmit="return confirm('Tolak booking ini?')">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-50 border border-red-200 text-red-600 rounded-md text-sm">Tolak</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada booking</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4">
                    {{ $bookings->appends(request()->all())->links() }}
                </div>
            </div>
    </div>
@endsection
