<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\SK;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SKSeeder extends Seeder
{
    public function run(): void
    {
        $divisions = Division::all();
        $admin = User::where('role', 'admin')->first();
        $anggotaDivisi = User::where('role', 'anggota_divisi')->first();

        // Create dummy PDF content
        $dummyPdfContent = '%PDF-1.4
1 0 obj
<<
/Type /Catalog
/Pages 2 0 R
>>
endobj

2 0 obj
<<
/Type /Pages
/Kids [3 0 R]
/Count 1
>>
endobj

3 0 obj
<<
/Type /Page
/Parent 2 0 R
/MediaBox [0 0 612 792]
/Contents 4 0 R
/Resources <<
/ProcSet [/PDF /Text]
/Font <<
/F1 <<
/Type /Font
/Subtype /Type1
/BaseFont /Helvetica
>>
>>
>>
>>
endobj

4 0 obj
<<
/Length 44
>>
stream
BT
/F1 12 Tf
100 700 Td
(Dummy SK Document) Tj
ET
endstream
endobj

xref
0 5
0000000000 65535 f 
0000000009 00000 n 
0000000058 00000 n 
0000000115 00000 n 
0000000317 00000 n 
trailer
<<
/Size 5
/Root 1 0 R
>>
startxref
411
%%EOF';

        $sampleSKs = [
            [
                'judul' => 'SK Pembentukan Tim Proyek IT',
                'nomor' => 'SK/TI/001/2024',
                'deskripsi' => 'Surat keputusan pembentukan tim proyek pengembangan sistem informasi.',
                'tanggal_terbit' => '2024-01-15',
                'division_id' => $divisions->where('kode', 'TI')->first()->id,
                'dibuat_oleh' => $admin->id,
            ],
            [
                'judul' => 'SK Kenaikan Jabatan',
                'nomor' => 'SK/SDM/002/2024',
                'deskripsi' => 'Surat keputusan kenaikan jabatan karyawan.',
                'tanggal_terbit' => '2024-01-20',
                'division_id' => $divisions->where('kode', 'SDM')->first()->id,
                'dibuat_oleh' => $admin->id,
            ],
            [
                'judul' => 'SK Anggaran Tahunan',
                'nomor' => 'SK/KEU/003/2024',
                'deskripsi' => 'Surat keputusan penetapan anggaran tahunan.',
                'tanggal_terbit' => '2024-01-25',
                'division_id' => $divisions->where('kode', 'KEU')->first()->id,
                'dibuat_oleh' => $admin->id,
            ],
            [
                'judul' => 'SK Pelaksanaan Pelatihan',
                'nomor' => 'SK/TRN/004/2024',
                'deskripsi' => 'Surat keputusan pelaksanaan program pelatihan karyawan.',
                'tanggal_terbit' => '2024-02-01',
                'division_id' => $divisions->where('kode', 'TRN')->first()->id,
                'dibuat_oleh' => $anggotaDivisi->id,
            ],
            [
                'judul' => 'SK Implementasi Sistem Keamanan',
                'nomor' => 'SK/SEC/005/2024',
                'deskripsi' => 'Surat keputusan implementasi sistem keamanan baru.',
                'tanggal_terbit' => '2024-02-05',
                'division_id' => $divisions->where('kode', 'SEC')->first()->id,
                'dibuat_oleh' => $admin->id,
            ],
        ];

        foreach ($sampleSKs as $index => $skData) {
            $fileName = 'sample_sk_' . ($index + 1) . '.pdf';
            $filePath = 'sk/' . $fileName;
            
            // Store dummy PDF file
            Storage::disk('public')->put($filePath, $dummyPdfContent);
            
            SK::create(array_merge($skData, [
                'file_path' => $filePath,
                'file_name' => $fileName,
                'file_size' => strlen($dummyPdfContent),
                'file_type' => 'application/pdf',
            ]));
        }
    }
}