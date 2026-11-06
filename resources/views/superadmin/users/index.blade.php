@extends('layouts.app')
@section('title', 'Kelola Akun')
@section('content')
<div class="container" style="padding: 30px 0;">
    <h2>Kelola Akun Pengguna & Admin</h2>
    <p class="text-muted">Ubah role atau hapus akun pengguna di sini.</p>

    @if(session('success'))
        <div class="alert" style="background: #e6fffa; color: #007777; padding: 10px; border-radius: 6px; margin-bottom: 15px;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert" style="background: #fed7d7; color: #c53030; padding: 10px; border-radius: 6px; margin-bottom: 15px;">{{ session('error') }}</div>
    @endif

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid #e2e8f0; background: #f7fafc;">
                    <th style="padding: 12px;">Nama</th>
                    <th style="padding: 12px;">Email</th>
                    <th style="padding: 12px;">Role Saat Ini</th>
                    <th style="padding: 12px;">Ubah Role</th>
                    <th style="padding: 12px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px; font-weight: 500;">{{ $u->name }}</td>
                        <td style="padding: 12px; color: #4a5568;">{{ $u->email }}</td>
                        <td style="padding: 12px;">
                            <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold; background: {{ $u->role === 'super_admin' ? '#feebc8' : ($u->role === 'admin' ? '#c6f6d5' : '#edf2f7') }}; color: {{ $u->role === 'super_admin' ? '#9c4221' : ($u->role === 'admin' ? '#22543d' : '#2d3748') }}">
                                {{ ucfirst($u->role) }}
                            </span>
                        </td>
                        <td style="padding: 12px;">
                            <form action="{{ route('superadmin.users.updateRole', $u->id) }}" method="POST" style="display: flex; gap: 8px; align-items: center;">
                                @csrf
                                @method('PATCH')
                                <select name="role" style="padding: 6px; border-radius: 4px; border: 1px solid #cbd5e0;">
                                    <option value="user" {{ $u->role === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="super_admin" {{ $u->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                </select>
                                <button type="submit" style="background: #007777; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 0.85rem;">Simpan</button>
                            </form>
                        </td>
                        <td style="padding: 12px;">
                            @if($u->id !== auth()->id())
                                <form action="{{ route('superadmin.users.destroy', $u->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #e53e3e; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer; font-size: 0.85rem;" onclick="return confirm('Yakin ingin menghapus akun ini?')">Hapus</button>
                                </form>
                            @else
                                <span style="color: #a0aec0; font-size: 0.85rem;">(Akun Anda)</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection