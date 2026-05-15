<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\StudentMaterialProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class StudentMaterialController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Eager load progress specific to this student
        $materials = Material::with(['subject', 'teacher'])
            ->whereIn('classroom_id', $user->classroomsAsStudent->pluck('id'))
            ->get()
            ->map(function ($material) use ($user) {
                // Check progress
                $progress = StudentMaterialProgress::where('student_id', $user->id)
                    ->where('material_id', $material->id)
                    ->first();
                    
                $material->is_read = $progress ? $progress->is_read : false;
                return $material;
            });

        return view('murid.materials.index', compact('materials'));
    }

    public function markAsRead(Request $request, Material $material)
    {
        $user = Auth::user();

        // Security check
        if (!$user->classroomsAsStudent->contains('id', $material->classroom_id)) {
            abort(403, 'Unauthorized access to this material.');
        }

        StudentMaterialProgress::updateOrCreate(
            ['student_id' => $user->id, 'material_id' => $material->id],
            ['is_read' => true]
        );

        Alert::success('Berhasil', 'Materi ditandai selesai dibaca.');
        return back();
    }
}
