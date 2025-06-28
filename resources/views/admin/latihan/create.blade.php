{{-- Ganti dengan layout admin Anda --}}
<x-app-layout>
<div class="container mx-auto p-8">
    <h1 class="text-2xl font-bold mb-4">Buat Latihan Baru</h1>

    {{-- Tampilkan error validasi jika ada --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">Ada beberapa kesalahan pada input Anda.</span>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.latihan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Bagian Informasi Latihan --}}
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <div class="mb-4">
                <label for="judul" class="block text-gray-700 font-medium mb-2">Judul Latihan</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="modul_id" class="block text-gray-700 font-medium mb-2">Pilih Modul</label>
                <select name="modul_id" id="modul_id" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="">-- Pilih Modul --</option>
                    @foreach ($moduls as $modul)
                        <option value="{{ $modul->id }}" {{ old('modul_id') == $modul->id ? 'selected' : '' }}>{{ $modul->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="deskripsi" class="block text-gray-700 font-medium mb-2">Deskripsi (Opsional)</label>
                <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full px-4 py-2 border rounded-lg">{{ old('deskripsi') }}</textarea>
            </div>
        </div>

        {{-- Bagian Soal Dinamis dengan Alpine.js --}}
        <div x-data="{ 
            soals: [{ pertanyaan: '', pilihan: ['', '', '', ''], jawaban_benar: '' }] 
        }" x-cloak x-init="$watch('soals', () => {})">
            <h2 class="text-xl font-bold mb-4">Soal-soal Latihan</h2>

            <template x-for="(soal, index) in soals" :key="index">
                <div class="bg-white p-6 rounded-lg shadow-md mb-6 relative">
                    {{-- Tombol Hapus Soal --}}
                    <button type="button" @click="soals.splice(index, 1)" x-show="soals.length > 1" class="absolute top-4 right-4 text-red-500 hover:text-red-700">
                        Hapus Soal
                    </button>

                    <h3 class="font-semibold text-lg mb-4" x-text="'Soal #' + (index + 1)"></h3>
                    
                    {{-- Pertanyaan --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Pertanyaan</label>
                        <textarea :name="'soal[' + index + '][pertanyaan]'" x-model="soal.pertanyaan" rows="3" class="w-full px-4 py-2 border rounded-lg" required></textarea>
                    </div>

                    {{-- Upload Media --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Media (Video/Audio - Opsional)</label>
                        <input type="file" :name="'soal[' + index + '][media]'" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    {{-- Pilihan Jawaban --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Pilihan Jawaban (Pilih satu yang benar)</label>
                        <template x-for="(pilihan, p_index) in soal.pilihan" :key="p_index">
                            <div class="flex items-center mb-2">
                                <input type="radio" 
                                       :name="'soal[' + index + '][jawaban_benar]'" 
                                       :value="p_index" 
                                       x-model="soal.jawaban_benar" 
                                       class="mr-2" required>
                                <input type="text" 
                                       :name="'soal[' + index + '][pilihan][' + p_index + ']'" 
                                       x-model="soal.pilihan[p_index]" 
                                       class="w-full px-3 py-2 border rounded-lg" 
                                       :placeholder="'Pilihan ' + String.fromCharCode(65 + p_index)" 
                                       required>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            {{-- Tombol Tambah Soal --}}
            <button type="button" @click="soals.push({ pertanyaan: '', pilihan: ['', '', '', ''], jawaban_benar: '' })" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600">
                + Tambah Soal
            </button>
        </div>

        {{-- Tombol Submit Utama --}}
        <div class="mt-8">
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 text-lg">
                Simpan Latihan
            </button>
        </div>
    </form>
</div>
</x-app-layout>
