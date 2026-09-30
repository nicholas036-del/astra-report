@csrf

<div class="mb-3">
    <label class="block text-sm font-medium">Judul</label>
    <input type="text" name="title" value="{{ old('title', $task->title ?? '') }}" class="w-full rounded border p-2">
    @error('title') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label class="block text-sm font-medium">Deskripsi</label>
    <textarea name="description" rows="4" class="w-full rounded border p-2">{{ old('description', $task->description ?? '') }}</textarea>
    @error('description') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label class="block text-sm font-medium">Department</label>
    <select name="department_id" class="w-full rounded border p-2">
        <option value="">- Pilih -</option>
        @foreach ($departments as $department)
            <option value="{{ $department->id }}" @selected(old('department_id', $task->department_id ?? '') == $department->id)>
                {{ $department->name }}
            </option>
        @endforeach
    </select>
    @error('department_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label class="block text-sm font-medium">Area</label>
    <select name="area_id" class="w-full rounded border p-2">
        <option value="">- Pilih -</option>
        @foreach ($areas as $area)
            <option value="{{ $area->id }}" @selected(old('area_id', $task->area_id ?? '') == $area->id)>
                {{ $area->name }}
            </option>
        @endforeach
    </select>
    @error('area_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label class="block text-sm font-medium">Deadline</label>
    <input type="date" name="due_date"
           value="{{ old('due_date', isset($task) && $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"
           class="w-full rounded border p-2">
    @error('due_date') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label class="inline-flex items-center gap-2">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $task->is_active ?? true))>
        <span class="text-sm">Aktif</span>
    </label>
</div>

<div class="flex gap-2">
    <button class="rounded bg-blue-600 px-4 py-2 text-white">Simpan</button>
    <a href="{{ route('tasks.index') }}" class="rounded border px-4 py-2">Batal</a>
</div>