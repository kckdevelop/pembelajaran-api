<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar data siswa.
     * Mendukung search (?search=nama/nis), filter (?jurusan=...&kelas=...&jenis_kelamin=...),
     * serta pagination atau (?all=true) untuk mengambil seluruh data.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Siswa::query();

        // Fitur Pencarian berdasarkan nama atau NIS
        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan Jurusan
        if ($request->filled('jurusan')) {
            $query->where('jurusan', 'like', "%{$request->query('jurusan')}%");
        }

        // Filter berdasarkan Kelas
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->query('kelas'));
        }

        // Filter berdasarkan Jenis Kelamin (L / P)
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', strtoupper($request->query('jenis_kelamin')));
        }

        // Filter berdasarkan Status
        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        // Opsi urutkan
        $sortBy = $request->query('sort_by', 'id');
        $sortOrder = strtolower($request->query('sort_order', 'asc')) === 'desc' ? 'desc' : 'asc';
        $allowedSorts = ['id', 'nis', 'nama', 'kelas', 'tahun_masuk'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Ambil semua data sekaligus jika ?all=true
        if ($request->boolean('all')) {
            $siswas = $query->get();

            return response()->json([
                'success' => true,
                'message' => 'Daftar semua data siswa berhasil diambil',
                'total'   => $siswas->count(),
                'data'    => $siswas,
            ], 200);
        }

        // Default: Menggunakan pagination (misal 10 per halaman)
        $perPage = (int) $request->query('per_page', 10);
        $siswas = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Daftar data siswa berhasil diambil',
            'data'    => $siswas->items(),
            'pagination' => [
                'current_page' => $siswas->currentPage(),
                'last_page'    => $siswas->lastPage(),
                'per_page'     => $siswas->perPage(),
                'total'        => $siswas->total(),
                'has_more'     => $siswas->hasMorePages(),
            ],
        ], 200);
    }

    /**
     * Menyimpan data siswa baru (POST).
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nis'           => 'required|string|max:10|unique:siswas,nis',
            'nama'          => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama'         => 'required|string|max:30',
            'alamat'        => 'required|string',
            'no_telp'       => 'nullable|string|max:15',
            'email'         => 'nullable|email|max:100',
            'kelas'         => 'required|string|max:10',
            'jurusan'       => 'required|string|max:100',
            'tahun_masuk'   => 'required|digits:4',
            'status'        => 'nullable|in:aktif,tidak_aktif,lulus,keluar',
            'foto'          => 'nullable|url|max:255',
        ], [
            'nis.required'           => 'NIS wajib diisi',
            'nis.unique'             => 'NIS sudah terdaftar dalam sistem',
            'nama.required'          => 'Nama lengkap siswa wajib diisi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih (L atau P)',
            'jenis_kelamin.in'       => 'Jenis kelamin hanya boleh L (Laki-laki) atau P (Perempuan)',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi (format: YYYY-MM-DD)',
            'alamat.required'        => 'Alamat siswa wajib diisi',
            'kelas.required'         => 'Kelas wajib diisi',
            'jurusan.required'       => 'Jurusan wajib diisi',
            'tahun_masuk.required'   => 'Tahun masuk wajib diisi (4 digit)',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi data gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Berikan foto default avatar jika tidak diisi
        $data = $validator->validated();
        if (empty($data['foto'])) {
            $initials = urlencode($data['nama']);
            $data['foto'] = "https://ui-avatars.com/api/?name={$initials}&background=4f46e5&color=fff&size=256";
        }

        $siswa = Siswa::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil ditambahkan',
            'data'    => $siswa,
        ], 201);
    }

    /**
     * Menampilkan detail satu siswa berdasarkan ID atau NIS (GET).
     */
    public function show(string $id): JsonResponse
    {
        // Cari berdasarkan ID numerik atau NIS
        $siswa = Siswa::where('id', $id)->orWhere('nis', $id)->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail data siswa berhasil ditemukan',
            'data'    => $siswa,
        ], 200);
    }

    /**
     * Mengubah data siswa (PUT/PATCH).
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $siswa = Siswa::where('id', $id)->orWhere('nis', $id)->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nis'           => 'sometimes|required|string|max:10|unique:siswas,nis,' . $siswa->id,
            'nama'          => 'sometimes|required|string|max:100',
            'jenis_kelamin' => 'sometimes|required|in:L,P',
            'tempat_lahir'  => 'sometimes|required|string|max:100',
            'tanggal_lahir' => 'sometimes|required|date',
            'agama'         => 'sometimes|required|string|max:30',
            'alamat'        => 'sometimes|required|string',
            'no_telp'       => 'nullable|string|max:15',
            'email'         => 'nullable|email|max:100',
            'kelas'         => 'sometimes|required|string|max:10',
            'jurusan'       => 'sometimes|required|string|max:100',
            'tahun_masuk'   => 'sometimes|required|digits:4',
            'status'        => 'nullable|in:aktif,tidak_aktif,lulus,keluar',
            'foto'          => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi data gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $siswa->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil diperbarui',
            'data'    => $siswa,
        ], 200);
    }

    /**
     * Menghapus data siswa (DELETE).
     */
    public function destroy(string $id): JsonResponse
    {
        $siswa = Siswa::where('id', $id)->orWhere('nis', $id)->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan',
            ], 404);
        }

        $siswa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil dihapus',
        ], 200);
    }

    /**
     * Statistik ringkas data siswa untuk dashboard pembelajaran (GET).
     */
    public function statistik(): JsonResponse
    {
        $totalSiswa = Siswa::count();
        $totalLaki  = Siswa::where('jenis_kelamin', 'L')->count();
        $totalPerempuan = Siswa::where('jenis_kelamin', 'P')->count();

        $perJurusan = Siswa::selectRaw('jurusan, COUNT(*) as total')
            ->groupBy('jurusan')
            ->get();

        $perKelas = Siswa::selectRaw('kelas, COUNT(*) as total')
            ->groupBy('kelas')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Statistik data siswa berhasil dihitung',
            'data'    => [
                'total_siswa'     => $totalSiswa,
                'jenis_kelamin'   => [
                    'laki_laki' => $totalLaki,
                    'perempuan' => $totalPerempuan,
                ],
                'per_jurusan'     => $perJurusan,
                'per_kelas'       => $perKelas,
            ],
        ], 200);
    }
}
