<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FrsSubmission;
use App\Models\Nilai;
use Illuminate\Support\Facades\Auth;

class MahasiswaApiController extends Controller
{
    // Get student profile information
    public function profile()
    {
        $user = Auth::user();
        
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'nrp' => $user->nrp,
            'semester' => $user->semester,
            'kelas' => $user->kelas ? [
                'id' => $user->kelas->id,
                'nama' => $user->kelas->nama,
                'program_studi' => $user->kelas->program_studi,
                'dosen_wali' => $user->kelas->dosen ? $user->kelas->dosen->name : null
            ] : null
        ]);
    }
    
    // Get dashboard summary data
    public function dashboard()
    {
        $user = Auth::user();
        
        // Count approved courses
        $approvedCourses = FrsSubmission::where('mahasiswa_id', $user->id)
            ->where('status', 'approved')
            ->count();
            
        // Count pending FRS submissions
        $pendingFrs = FrsSubmission::where('mahasiswa_id', $user->id)
            ->where('status', 'pending')
            ->count();
            
        // Get latest grades
        $latestGrades = Nilai::where('mahasiswa_id', $user->id)
            ->with('matakuliah')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($nilai) {
                return [
                    'mata_kuliah' => $nilai->matakuliah->nama,
                    'nilai_huruf' => $nilai->nilai_huruf,
                    'nilai_angka' => $nilai->nilai_angka
                ];
            });
            
        // Calculate IP
        $ip = $this->calculateIP($user->id);
        
        return response()->json([
            'approved_courses' => $approvedCourses,
            'pending_frs' => $pendingFrs,
            'latest_grades' => $latestGrades,
            'ip' => $ip
        ]);
    }
    
    private function calculateIP($mahasiswaId)
    {
        $nilaiList = Nilai::where('mahasiswa_id', $mahasiswaId)
            ->with('matakuliah')
            ->get();
            
        $totalSks = 0;
        $totalNilai = 0;
        
        foreach ($nilaiList as $nilai) {
            $bobot = 0;
            switch ($nilai->nilai_huruf) {
                case 'A': $bobot = 4; break;
                case 'AB': $bobot = 3.5; break;
                case 'B': $bobot = 3; break;
                case 'BC': $bobot = 2.5; break;
                case 'C': $bobot = 2; break;
                case 'D': $bobot = 1; break;
                case 'E': $bobot = 0; break;
            }
            
            $totalSks += $nilai->matakuliah->sks;
            $totalNilai += ($nilai->matakuliah->sks * $bobot);
        }
        
        return $totalSks > 0 ? round($totalNilai / $totalSks, 2) : 0;
    }
}