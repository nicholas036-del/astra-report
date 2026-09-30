@extends('layouts.app') <!-- Sesuaikan dengan nama file layout utama Anda, misal layouts.app atau komponen layout Anda -->

@section('title', 'Daftar Dealer')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold">Daftar Dealer</h1>
    <a href="{{ route('dealers.create') }}" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Tambah Dealer</a>
</div>

<div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Kode</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nama</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Alamat</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Telepon</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($dealers as $dealer)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $dealer->code }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $dealer->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $dealer->address ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $dealer->phone ?? '-' }}</td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <a href="{{ route('dealers.edit', $dealer) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                        <form action="{{ route('dealers.destroy', $dealer) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus dealer ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data dealer.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $dealers->links() }}
</div>
@endsection