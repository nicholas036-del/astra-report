@csrf

<div class="mb-3">
    <label class="block text-sm font-medium">Nama</label>
    <input type="text" name="name" value="{{ old('name', $area->name ?? '') }}" class="w-full rounded border p-2">
    @error('name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label class="block text-sm font-medium">Deskripsi</label>
    <input type="text" name="description" value="{{ old('description', $area->description ?? '') }}" class="w-full rounded border p-2">
    @error('description') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="flex gap-2">
    <button class="rounded bg-blue-600 px-4 py-2 text-white">Simpan</button>
    <a href="{{ route('areas.index') }}" class="rounded border px-4 py-2">Batal</a>
</div>