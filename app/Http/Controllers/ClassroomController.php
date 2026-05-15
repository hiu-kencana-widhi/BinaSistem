<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Major;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ClassroomController extends Controller
{
    public function index(Request $request)
    {
        $query = Classroom::with(['major', 'teacher']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('level', 'like', "%{$search}%");
        }

        $classrooms = $query->paginate(10)->withQueryString();

        return view('admin.classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        $majors = Major::all();
        $teachers = User::role('guru')->get();
        return view('admin.classrooms.create', compact('majors', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:50',
            'major_id' => 'required|exists:majors,id',
            'teacher_id_walikelas' => 'required|exists:users,id',
        ]);

        Classroom::create($request->all());

        Alert::success('Berhasil', 'Kelas berhasil ditambahkan');
        return redirect()->route('admin.classrooms.index');
    }

    public function edit(Classroom $classroom)
    {
        $majors = Major::all();
        $teachers = User::role('guru')->get();
        return view('admin.classrooms.edit', compact('classroom', 'majors', 'teachers'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:50',
            'major_id' => 'required|exists:majors,id',
            'teacher_id_walikelas' => 'required|exists:users,id',
        ]);

        $classroom->update($request->all());

        Alert::success('Berhasil', 'Kelas berhasil diperbarui');
        return redirect()->route('admin.classrooms.index');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        Alert::success('Berhasil', 'Kelas berhasil dihapus');
        return redirect()->route('admin.classrooms.index');
    }
}
