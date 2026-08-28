<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Manajemen User/Petugas khusus admin. Petugas biasa tidak boleh
    // melihat/menambah/mengubah/menghapus akun pegawai lain (rawan disalahgunakan).
    public function index(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Hanya admin yang bisa mengakses Manajemen User/Petugas.');

        $cari = trim((string) $request->query('cari', ''));

        $users = User::withCount('pengaduansDitangani')
            ->when($cari !== '', function ($q) use ($cari) {
                $q->where(function ($sub) use ($cari) {
                    $sub->where('name', 'like', "%{$cari}%")
                        ->orWhere('nipp', 'like', "%{$cari}%")
                        ->orWhere('email', 'like', "%{$cari}%");
                });
            })
            ->orderBy('name')
            ->get();

        return view('dashboard.user.index', [
            'users' => $users,
            'cari' => $cari,
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Hanya admin yang bisa menambah akun.');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'nipp' => ['required', 'string', 'max:25', 'regex:/^[0-9A-Za-z]+$/', 'unique:users,nipp'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', Rule::in(['admin', 'petugas'])],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], $this->pesanValidasi());

        User::create([
            'name' => $validated['name'],
            'nipp' => $validated['nipp'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Akun "' . $validated['name'] . '" berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Hanya admin yang bisa mengubah akun.');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'nipp' => ['required', 'string', 'max:25', 'regex:/^[0-9A-Za-z]+$/', Rule::unique('users', 'nipp')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', Rule::in(['admin', 'petugas'])],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], $this->pesanValidasi());

        // Jangan biarkan admin menurunkan role dirinya sendiri jadi petugas lewat
        // sini -- bisa bikin dia kekunci dari fitur admin tanpa sengaja.
        if ($user->id === auth()->id() && $validated['role'] !== 'admin') {
            return back()->with('error', 'Anda tidak bisa mengubah role akun Anda sendiri menjadi petugas.')->withInput();
        }

        $data = [
            'name' => $validated['name'],
            'nipp' => $validated['nipp'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role' => $validated['role'],
        ];

        if (! empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return back()->with('success', 'Akun "' . $user->name . '" berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Hanya admin yang bisa menghapus akun.');

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri yang sedang login.');
        }

        // Jangan biarkan admin terakhir terhapus, nanti gak ada yang bisa
        // kelola akun pegawai lagi.
        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Tidak bisa menghapus admin terakhir. Minimal harus ada 1 akun admin.');
        }

        $jumlahDitangani = $user->pengaduansDitangani()->count();
        if ($jumlahDitangani > 0) {
            return back()->with('error', 'Akun "' . $user->name . '" tidak bisa dihapus karena masih tercatat menangani ' . $jumlahDitangani . ' pengaduan.');
        }

        $nama = $user->name;
        $user->delete();

        return back()->with('success', 'Akun "' . $nama . '" berhasil dihapus.');
    }

    private function pesanValidasi(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 150 karakter.',
            'nipp.required' => 'NIPP wajib diisi.',
            'nipp.regex' => 'NIPP hanya boleh berisi huruf dan angka, tanpa spasi atau simbol.',
            'nipp.unique' => 'NIPP ini sudah dipakai akun lain.',
            'nipp.max' => 'NIPP maksimal 25 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah dipakai akun lain.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}
