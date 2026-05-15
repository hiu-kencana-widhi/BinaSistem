<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Subject;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with(['subject', 'classroom'])
            ->where('teacher_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('guru.materials.index', compact('materials'));
    }

    public function create()
    {
        $subjects = Subject::all();
        $classrooms = Auth::user()->classroomsAsTeacher;
        
        return view('guru.materials.create', compact('subjects', 'classrooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,mp4,mkv|max:51200', // 50MB max
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('materials', 'public');
        }

        Material::create([
            'teacher_id' => Auth::id(),
            'subject_id' => $request->subject_id,
            'classroom_id' => $request->classroom_id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
        ]);

        Alert::success('Berhasil', 'Materi berhasil diunggah');
        return redirect()->route('guru.materials.index');
    }

    public function destroy(Material $material)
    {
        if ($material->teacher_id !== Auth::id()) {
            abort(403);
        }

        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        Alert::success('Berhasil', 'Materi berhasil dihapus');
        return back();
    }
}
