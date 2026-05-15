<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
        }

        $subjects = $query->paginate(10)->withQueryString();

        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('admin.subjects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:subjects,code',
            'name' => 'required|string|max:255',
            'type' => 'required|in:wajib,peminatan,lintas_minat',
        ]);

        Subject::create($request->all());

        Alert::success('Berhasil', 'Mata Pelajaran berhasil ditambahkan');
        return redirect()->route('admin.subjects.index');
    }

    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:subjects,code,' . $subject->id,
            'name' => 'required|string|max:255',
            'type' => 'required|in:wajib,peminatan,lintas_minat',
        ]);

        $subject->update($request->all());

        Alert::success('Berhasil', 'Mata Pelajaran berhasil diperbarui');
        return redirect()->route('admin.subjects.index');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        Alert::success('Berhasil', 'Mata Pelajaran berhasil dihapus');
        return redirect()->route('admin.subjects.index');
    }
}
