<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit SK') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <form method="POST" action="{{ route('sks.update', $sk) }}" enctype="multipart/form-data" x-data="{ uploading: false, progress: 0 }">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <!-- Current File Info -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-900 mb-2">File Saat Ini</h4>
                                <div class="flex items-center space-x-3">
                                    @if($sk->isPdf())
                                        <div class="h-8 w-8 rounded bg-red-100 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @else
                                        <div class="h-8 w-8 rounded bg-blue-100 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $sk->file_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $sk->file_size_formatted }}</div>
                                    </div>
                                    <div class="flex space-x-2">
                                        @if($sk->isPdf())
                                            <a href="{{ route('sks.preview', $sk) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Preview</a>
                                        @endif
                                        <a href="{{ route('sks.download', $sk) }}" class="text-green-600 hover:text-green-900 text-sm">Unduh</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Judul -->
                            <div>
                                <label for="judul" class="block text-sm font-medium text-gray-700">Judul SK <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       id="judul" 
                                       name="judul" 
                                       value="{{ old('judul', $sk->judul) }}" 
                                       required 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('judul') border-red-300 @enderror">
                                @error('judul')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor -->
                            <div>
                                <label for="nomor" class="block text-sm font-medium text-gray-700">Nomor SK <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       id="nomor" 
                                       name="nomor" 
                                       value="{{ old('nomor', $sk->nomor) }}" 
                                       required 
                                       placeholder="Contoh: SK/TI/001/2024"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('nomor') border-red-300 @enderror">
                                @error('nomor')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Divisi -->
                            <div>
                                <label for="division_id" class="block text-sm font-medium text-gray-700">Divisi <span class="text-red-500">*</span></label>
                                <select id="division_id" 
                                        name="division_id" 
                                        required 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('division_id') border-red-300 @enderror">
                                    <option value="">Pilih Divisi</option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}" {{ old('division_id', $sk->division_id) == $division->id ? 'selected' : '' }}>
                                            {{ $division->nama }} ({{ $division->kode }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('division_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Terbit -->
                            <div>
                                <label for="tanggal_terbit" class="block text-sm font-medium text-gray-700">Tanggal Terbit <span class="text-red-500">*</span></label>
                                <input type="date" 
                                       id="tanggal_terbit" 
                                       name="tanggal_terbit" 
                                       value="{{ old('tanggal_terbit', $sk->tanggal_terbit->format('Y-m-d')) }}" 
                                       required 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('tanggal_terbit') border-red-300 @enderror">
                                @error('tanggal_terbit')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea id="deskripsi" 
                                          name="deskripsi" 
                                          rows="3" 
                                          placeholder="Deskripsi singkat tentang SK ini..."
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('deskripsi') border-red-300 @enderror">{{ old('deskripsi', $sk->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- File Upload -->
                            <div>
                                <label for="file" class="block text-sm font-medium text-gray-700">Ganti File SK (opsional)</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md @error('file') border-red-300 @enderror">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                                <span>Upload file SK baru</span>
                                                <input id="file" 
                                                       name="file" 
                                                       type="file" 
                                                       accept=".pdf,.doc,.docx"
                                                       class="sr-only"
                                                       @change="uploading = true">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PDF, DOC, DOCX hingga 10MB. Kosongkan jika tidak ingin mengganti file.</p>
                                    </div>
                                </div>
                                @error('file')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('sks.index') }}" 
                               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Batal
                            </a>
                            <button type="submit" 
                                    :disabled="uploading"
                                    class="bg-primary-600 hover:bg-primary-700 disabled:bg-primary-400 text-white py-2 px-4 rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <span x-show="!uploading">Simpan Perubahan</span>
                                <span x-show="uploading" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Mengupload...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const fileName = file.name;
                const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
                
                // Create a preview element
                const preview = document.createElement('div');
                preview.className = 'mt-2 text-sm text-gray-600';
                preview.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                        </svg>
                        <span>${fileName} (${fileSize} MB)</span>
                        <span class="text-yellow-600">[File baru akan mengganti file lama]</span>
                    </div>
                `;
                
                // Remove existing preview
                const existingPreview = e.target.closest('.border-dashed').querySelector('.mt-2');
                if (existingPreview) {
                    existingPreview.remove();
                }
                
                // Add new preview
                e.target.closest('.border-dashed').appendChild(preview);
            }
        });

        // Drag and drop functionality
        const dropZone = document.querySelector('.border-dashed');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('border-primary-500', 'bg-primary-50');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-primary-500', 'bg-primary-50');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length > 0) {
                document.getElementById('file').files = files;
                document.getElementById('file').dispatchEvent(new Event('change'));
            }
        }
    </script>
    @endpush
</x-app-layout>