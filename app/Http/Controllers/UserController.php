<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);
        
        $users = User::with('division')->latest()->paginate(10);
        
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create', User::class);
        
        $divisions = Division::orderBy('nama')->get();
        
        return view('users.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        // Parse role
        $parsedRole = $this->parseRole($request->role);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role harus dipilih.',
        ]);

        // Additional validation for division
        if ($parsedRole['role'] === 'anggota_divisi' && !$parsedRole['division_id']) {
            return back()->withErrors(['role' => 'Divisi tidak valid untuk role ini.'])->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $parsedRole['role'],
            'division_id' => $parsedRole['division_id'],
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);
        
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        
        $divisions = Division::orderBy('nama')->get();
        
        return view('users.edit', compact('user', 'divisions'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        // Parse role
        $parsedRole = $this->parseRole($request->role);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string',
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role harus dipilih.',
        ]);

        // Additional validation for division
        if ($parsedRole['role'] === 'anggota_divisi' && !$parsedRole['division_id']) {
            return back()->withErrors(['role' => 'Divisi tidak valid untuk role ini.'])->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $parsedRole['role'],
            'division_id' => $parsedRole['division_id'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus!');
    }

    private function parseRole($roleValue)
    {
        if ($roleValue === 'admin') {
            return ['role' => 'admin', 'division_id' => null];
        } elseif ($roleValue === 'tamu') {
            return ['role' => 'tamu', 'division_id' => null];
        } elseif (str_starts_with($roleValue, 'anggota_divisi_')) {
            $kode = str_replace('anggota_divisi_', '', $roleValue);
            $division = Division::where('kode', $kode)->first();
            if ($division) {
                return ['role' => 'anggota_divisi', 'division_id' => $division->id];
            }
        }
        return ['role' => null, 'division_id' => null]; // Invalid
    }
}
