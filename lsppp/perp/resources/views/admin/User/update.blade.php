@extends('admin.layout')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Update User</h1>
            <p class="text-slate-500 text-sm mt-1">Update user account information and permissions.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <form action="{{ url('users/' . $user->id) }}" method="POST" class="p-6 space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Account Information Section -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-gray-100">Account Information</h3>
                    
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-lg">
                            <div class="flex items-start gap-3">
                                <svg class="h-5 w-5 text-red-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <h3 class="text-sm font-medium text-red-800">Validation Error</h3>
                                    <ul class="mt-1 list-disc list-inside text-sm text-red-700">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Role -->
                        <div class="space-y-1">
                            <label for="role" class="block text-sm font-medium text-slate-700">Role</label>
                            <select name="role" id="role" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:border-slate-800 focus:ring-1 focus:ring-slate-800 outline-none transition-all text-slate-800" onchange="toggleAnggotaFields()">
                                <option value="siswa" {{ (old('role') ?? $user->role->value) == 'siswa' ? 'selected' : '' }}>Member (Siswa)</option>
                                <option value="admin" {{ (old('role') ?? $user->role->value) == 'admin' ? 'selected' : '' }}>Administrator</option>
                            </select>
                        </div>

                        <!-- Username -->
                        <div class="space-y-1">
                            <label for="username" class="block text-sm font-medium text-slate-700">Username</label>
                            <input type="text" name="username" id="username" value="{{ old('username') ?? $user->username }}" placeholder="username123" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:border-slate-800 focus:ring-1 focus:ring-slate-800 outline-none transition-all placeholder:text-gray-400 text-slate-800" required>
                        </div>

                        <!-- Password -->
                        <div class="space-y-1">
                            <label for="password" class="block text-sm font-medium text-slate-700">Password <span class="text-slate-400 font-normal">(Leave blank to keep current)</span></label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:border-slate-800 focus:ring-1 focus:ring-slate-800 outline-none transition-all placeholder:text-gray-400 text-slate-800">
                        </div>
                    </div>
                </div>

                <!-- Member (Anggota) Information Section -->
                <div id="anggota-section" class="transition-all duration-300 ease-in-out">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-gray-100">Member Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama -->
                        <div class="space-y-1">
                            <label for="nama" class="block text-sm font-medium text-slate-700">Full Name</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') ?? $user->anggota?->nama }}" placeholder="e.g. John Doe" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:border-slate-800 focus:ring-1 focus:ring-slate-800 outline-none transition-all placeholder:text-gray-400 text-slate-800 disabled:opacity-50 disabled:bg-gray-100">
                        </div>

                        <!-- NIS -->
                        <div class="space-y-1">
                            <label for="nis" class="block text-sm font-medium text-slate-700">NIS</label>
                            <input type="text" name="nis" id="nis" value="{{ old('nis') ?? $user->anggota?->nis }}" placeholder="Student ID Number" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:border-slate-800 focus:ring-1 focus:ring-slate-800 outline-none transition-all placeholder:text-gray-400 text-slate-800 disabled:opacity-50 disabled:bg-gray-100">
                        </div>

                        <!-- Jurusan -->
                        <div class="space-y-1">
                            <label for="jurusan" class="block text-sm font-medium text-slate-700">Major (Jurusan)</label>
                            <select name="jurusan" id="jurusan" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:border-slate-800 focus:ring-1 focus:ring-slate-800 outline-none transition-all text-slate-800 disabled:opacity-50 disabled:bg-gray-100">
                                <option value="" disabled selected>Select Major</option>
                                <option value="RPL" {{ (old('jurusan') ?? $user->anggota?->jurusan) == 'RPL' ? 'selected' : '' }}>Rekayasa Perangkat Lunak (RPL)</option>
                                <option value="TKJ" {{ (old('jurusan') ?? $user->anggota?->jurusan) == 'TKJ' ? 'selected' : '' }}>Teknik Komputer Jaringan (TKJ)</option>
                                <option value="TR" {{ (old('jurusan') ?? $user->anggota?->jurusan) == 'TR' ? 'selected' : '' }}>Teknik Transmisi Telekomunikasi (TR)</option>
                            </select>
                        </div>

                        <!-- Kelas -->
                        <div class="space-y-1">
                            <label for="kelas" class="block text-sm font-medium text-slate-700">Class</label>
                            <input type="text" name="kelas" id="kelas" value="{{ old('kelas') ?? $user->anggota?->kelas }}" placeholder="e.g. XII Tel 13" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:border-slate-800 focus:ring-1 focus:ring-slate-800 outline-none transition-all placeholder:text-gray-400 text-slate-800 disabled:opacity-50 disabled:bg-gray-100">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-50">
                    <a href="{{ url('/users') }}" class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all">Cancel</a>
                    <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-slate-900 rounded-lg hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 shadow-sm shadow-slate-900/10 transition-all">Update User</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleAnggotaFields() {
            const role = document.getElementById('role').value;
            const anggotaSection = document.getElementById('anggota-section');
            const inputs = anggotaSection.querySelectorAll('input, select');

            if (role === 'admin') {
                anggotaSection.style.opacity = '0.5';
                inputs.forEach(input => {
                    input.disabled = true;
                    input.required = false;
                });
            } else {
                anggotaSection.style.opacity = '1';
                inputs.forEach(input => {
                    input.disabled = false;
                    input.required = true;
                });
            }
        }

        // Run on load to set initial state
        document.addEventListener('DOMContentLoaded', toggleAnggotaFields);
    </script>
@endsection
