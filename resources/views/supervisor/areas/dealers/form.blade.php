@csrf

<div class="mb-3">
    <label class="block text-sm font-medium">Kode</label>
    <input type="text" name="code" value="{{ old('code', $dealer->code ?? '') }}" class="w-full rounded border p-2">
    @error('code') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label class="block text-sm font-medium">Nama</label>
    <input type="text" name="name" value="{{ old('name', $dealer->name ?? '') }}" class="w-full rounded border p-2">
    @error('name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label class="block text-sm font-medium">Alamat</label>
    <input type="text" name="address" value="{{ old('address', $dealer->address ?? '') }}" class="w-full rounded border p-2">
    @error('address') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label class="block text-sm font-medium">Telepon</label>
    <input type="text" name="phone" value="{{ old('phone', $dealer->phone ?? '') }}" class="w-full rounded border p-2">
    @error('phone') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="flex gap-2">
    <button class="rounded bg-blue-600 px-4 py-2 text-white">Simpan</button>
    <a href="{{ route('dealers.index') }}" class="rounded border px-4 py-2">Batal</a>
</div>