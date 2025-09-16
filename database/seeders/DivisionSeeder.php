<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        $divisions = [
            ['nama' => 'Divisi Teknologi Informasi', 'kode' => 'TI', 'deskripsi' => 'Mengelola sistem informasi dan teknologi'],
            ['nama' => 'Divisi Sumber Daya Manusia', 'kode' => 'SDM', 'deskripsi' => 'Mengelola kepegawaian dan pengembangan SDM'],
            ['nama' => 'Divisi Keuangan', 'kode' => 'KEU', 'deskripsi' => 'Mengelola keuangan dan akuntansi'],
            ['nama' => 'Divisi Pemasaran', 'kode' => 'PMR', 'deskripsi' => 'Mengelola pemasaran dan promosi'],
            ['nama' => 'Divisi Operasional', 'kode' => 'OPS', 'deskripsi' => 'Mengelola operasional harian'],
            ['nama' => 'Divisi Penelitian & Pengembangan', 'kode' => 'RND', 'deskripsi' => 'Mengelola penelitian dan pengembangan'],
            ['nama' => 'Divisi Hukum', 'kode' => 'HKM', 'deskripsi' => 'Mengelola aspek hukum dan legal'],
            ['nama' => 'Divisi Hubungan Masyarakat', 'kode' => 'HUMAS', 'deskripsi' => 'Mengelola hubungan dengan masyarakat'],
            ['nama' => 'Divisi Logistik', 'kode' => 'LOG', 'deskripsi' => 'Mengelola logistik dan pengadaan'],
            ['nama' => 'Divisi Keamanan', 'kode' => 'SEC', 'deskripsi' => 'Mengelola keamanan dan keselamatan'],
            ['nama' => 'Divisi Administrasi', 'kode' => 'ADM', 'deskripsi' => 'Mengelola administrasi umum'],
            ['nama' => 'Divisi Produksi', 'kode' => 'PROD', 'deskripsi' => 'Mengelola proses produksi'],
            ['nama' => 'Divisi Quality Control', 'kode' => 'QC', 'deskripsi' => 'Mengelola kontrol kualitas'],
            ['nama' => 'Divisi Maintenance', 'kode' => 'MTC', 'deskripsi' => 'Mengelola pemeliharaan peralatan'],
            ['nama' => 'Divisi Lingkungan', 'kode' => 'ENV', 'deskripsi' => 'Mengelola aspek lingkungan'],
            ['nama' => 'Divisi Training', 'kode' => 'TRN', 'deskripsi' => 'Mengelola pelatihan dan pengembangan'],
            ['nama' => 'Divisi Audit Internal', 'kode' => 'AI', 'deskripsi' => 'Mengelola audit internal'],
            ['nama' => 'Divisi Strategi Bisnis', 'kode' => 'SB', 'deskripsi' => 'Mengelola strategi dan perencanaan bisnis'],
        ];

        foreach ($divisions as $division) {
            Division::updateOrCreate(['kode' => $division['kode']], $division);
        }
    }
}