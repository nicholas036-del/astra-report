@csrf

<div class="mb-3">
    <label class="block text-sm font-medium">Isi laporan</label>
    <textarea name="content" rows="6" class="w-full rounded border p-2">{{ old('content', $submission->content ?? '') }}</textarea>
    @error('content') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label class="block text-sm font-medium">Lampiran (pdf, jpg, png, xlsx, docx, maks 5 MB)</label>
    <input type="file" name="file" class="w-full rounded border p-2">
    @if (isset($submission) && $submission->file_path)
        <p class="mt-1 text-sm">
            File saat ini:
            <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="text-blue-600">Lihat</a>
            (kosongkan kalau tidak ingin mengganti)
        </p>
    @endif
    @error('file') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="flex gap-2">
    <button class="rounded bg-blue-600 px-4 py-2 text-white">Kirim</button>
    <a href="{{ route('submissions.index') }}" class="rounded border px-4 py-2">Batal</a>
</div>