@csrf

<div class="mb-3">
    <label class="block text-sm font-medium">Nama</label>
    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="w-full rounded border p-2">
    @error('name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label class="block text-sm font-medium">Email</label>
    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="w-full rounded border p-2">
    @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label class="block text-sm font-medium">
        Password @isset($user) (kosongkan kalau tidak diganti) @endisset
    </label>
    <input type="password" name="password" class="w-full rounded border p-2" autocomplete="new-password">
    @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-3">
    <label class="block text-sm font-medium">Role</label>
    <select name="role" id="role" class="w-full rounded border p-2">
        @foreach (['admin', 'supervisor', 'dealer'] as $role)
            <option value="{{ $role }}" @selected(old('role', $user->role ?? 'dealer') === $role)>{{ ucfirst($role) }}</option>
        @endforeach
    </select>
    @error('role') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-3" id="dealer-field">
    <label class="block text-sm font-medium">Dealer (khusus role dealer)</label>
    <select name="dealer_id" class="w-full rounded border p-2">
        <option value="">- Pilih -</option>
        @foreach ($dealers as $dealer)
            <option value="{{ $dealer->id }}" @selected(old('dealer_id', $user->dealer_id ?? '') == $dealer->id)>
                {{ $dealer->code }} - {{ $dealer->name }}
            </option>
        @endforeach
    </select>
    @error('dealer_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="flex gap-2">
    <button class="rounded bg-blue-600 px-4 py-2 text-white">Simpan</button>
    <a href="{{ route('users.index') }}" class="rounded border px-4 py-2">Batal</a>
</div>

<script>
    const roleSelect = document.getElementById('role');
    const dealerField = document.getElementById('dealer-field');

    function toggleDealerField() {
        dealerField.style.display = roleSelect.value === 'dealer' ? 'block' : 'none';
    }

    roleSelect.addEventListener('change', toggleDealerField);
    toggleDealerField();
</script>