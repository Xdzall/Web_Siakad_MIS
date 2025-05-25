<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FrsSubmission;
use App\Models\JadwalKuliah;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class FrsApiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's FRS submissions
        $frsSubmissions = FrsSubmission::where('mahasiswa_id', $user->id)
            ->with(['matakuliah.jadwalKuliah.dosen'])
            ->get()
            ->map(function($frs) {
                $jadwal = $frs->matakuliah->jadwalKuliah->first();
                return [
                    'id' => $frs->id,
                    'matakuliah_id' => $frs->matakuliah_id,
                    'nama_matakuliah' => $frs->matakuliah->nama,
                    'kode' => $frs->matakuliah->kode,
                    'sks' => $frs->matakuliah->sks,
                    'status' => $frs->status,
                    'dosen' => $jadwal ? $jadwal->dosen->name : 'Belum ditentukan',
                    'jadwal' => $jadwal ? $jadwal->hari . ', ' . $jadwal->waktu : 'Belum dijadwalkan',
                    'ruang' => $jadwal ? $jadwal->ruang : '-',
                    'created_at' => $frs->created_at->format('d M Y H:i')
                ];
            });
            
        // Get available courses for this semester
        $kelas = $user->kelas;
        $availableCourses = [];
        
        if ($kelas) {
            $jadwalList = JadwalKuliah::where('kelas_id', $kelas->id)
                ->with(['matakuliah', 'dosen'])
                ->get();
                
            foreach ($jadwalList as $jadwal) {
                if (!$frsSubmissions->contains('matakuliah_id', $jadwal->matakuliah_id)) {
                    $availableCourses[] = [
                        'matakuliah_id' => $jadwal->matakuliah_id,
                        'nama_matakuliah' => $jadwal->matakuliah->nama,
                        'kode' => $jadwal->matakuliah->kode,
                        'sks' => $jadwal->matakuliah->sks,
                        'dosen' => $jadwal->dosen->name,
                        'jadwal' => $jadwal->hari . ', ' . $jadwal->waktu,
                        'ruang' => $jadwal->ruang
                    ];
                }
            }
        }
        
        return response()->json([
            'frs_submissions' => $frsSubmissions,
            'available_courses' => $availableCourses
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'matakuliah_id' => 'required|exists:matakuliahs,id',
        ]);
        
        $user = Auth::user();
        
        // Check if already submitted
        $existing = FrsSubmission::where('mahasiswa_id', $user->id)
            ->where('matakuliah_id', $request->matakuliah_id)
            ->first();
            
        if ($existing) {
            return response()->json([
                'message' => 'Matakuliah ini sudah diambil'
            ], 422);
        }
        
        // Create FRS submission
        $frs = FrsSubmission::create([
            'mahasiswa_id' => $user->id,
            'matakuliah_id' => $request->matakuliah_id,
            'kelas_id' => $user->kelas_id,
            'status' => 'pending'
        ]);
        
        return response()->json([
            'message' => 'Pengajuan FRS berhasil',
            'frs' => $frs
        ]);
    }
    
    public function destroy($id)
    {
        $frs = FrsSubmission::where('id', $id)
            ->where('mahasiswa_id', Auth::id())
            ->first();
            
        if (!$frs) {
            return response()->json([
                'message' => 'FRS tidak ditemukan'
            ], 404);
        }
        
        $frs->delete();
        
        return response()->json([
            'message' => 'Pengajuan FRS berhasil dibatalkan'
        ]);
    }
    
    public function dosenFrs()
    {
        $user = Auth::user();
        
        // Get kelas for this dosen wali
        $kelas = Kelas::where('dosen_id', $user->id)
            ->where('active', true)
            ->first();
            
        if (!$kelas) {
            return response()->json([
                'message' => 'Anda tidak menjadi wali untuk kelas manapun'
            ], 404);
        }
        
        // Get FRS submissions for this kelas
        $frsSubmissions = FrsSubmission::where('kelas_id', $kelas->id)
            ->with(['mahasiswa', 'matakuliah.jadwalKuliah.dosen'])
            ->get()
            ->groupBy('matakuliah_id')
            ->map(function($group) {
                return $group->map(function($frs) {
                    $jadwal = $frs->matakuliah->jadwalKuliah->first();
                    return [
                        'id' => $frs->id,
                        'mahasiswa_id' => $frs->mahasiswa_id,
                        'nama_mahasiswa' => $frs->mahasiswa->name,
                        'nrp' => $frs->mahasiswa->nrp,
                        'matakuliah_id' => $frs->matakuliah_id,
                        'nama_matakuliah' => $frs->matakuliah->nama,
                        'status' => $frs->status,
                        'rejection_reason' => $frs->rejection_reason,
                        'dosen' => $jadwal ? $jadwal->dosen->name : 'Belum ditentukan',
                        'created_at' => $frs->created_at->format('d M Y H:i')
                    ];
                });
            });
            
        return response()->json([
            'kelas' => [
                'id' => $kelas->id,
                'nama' => $kelas->nama,
                'total_mahasiswa' => $kelas->mahasiswa->count()
            ],
            'frs_submissions' => $frsSubmissions
        ]);
    }
    
    public function validateFrs(Request $request)
    {
        $request->validate([
            'frs_id' => 'required|exists:frs_submissions,id',
            'status' => 'required|in:approved,rejected',
            'reason' => 'nullable|required_if:status,rejected'
        ]);
        
        $frs = FrsSubmission::findOrFail($request->frs_id);
        
        $frs->status = $request->status;
        
        if ($request->status === 'rejected') {
            $frs->rejection_reason = $request->reason;
        } else {
            $frs->rejection_reason = null;
        }
        
        $frs->save();
        
        return response()->json([
            'message' => 'Status FRS berhasil diperbarui',
            'frs' => $frs
        ]);
    }
}