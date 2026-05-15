<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classroom;
use App\Models\AcademicYear;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('role') && $request->role != '') {
            $query->role($request->role);
        }

        $users = $query->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $classrooms = Classroom::all();
        return view('admin.users.create', compact('classrooms'));
    }

    public function store(UserRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // 1. Buat User
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'is_active' => true,
                ]);

                // 2. Assign Role
                $user->assignRole($request->role);

                // 3. Jika murid, relasikan ke Classroom
                if ($request->role === 'murid' && $request->classroom_id) {
                    $activeYear = AcademicYear::where('is_active', true)->first();
                    if ($activeYear) {
                        $user->classroomsAsStudent()->attach($request->classroom_id, [
                            'academic_year_id' => $activeYear->id
                        ]);
                    }
                }
            });

            Alert::success('Berhasil', 'Data User berhasil ditambahkan');
            return redirect()->route('admin.users.index');

        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function edit(User $user)
    {
        $classrooms = Classroom::all();
        return view('admin.users.edit', compact('user', 'classrooms'));
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            DB::transaction(function () use ($request, $user) {
                $data = $request->only(['name', 'email', 'phone', 'address']);
                
                if ($request->filled('password')) {
                    $data['password'] = Hash::make($request->password);
                }

                $user->update($data);
                $user->syncRoles($request->role);

                if ($request->role === 'murid' && $request->classroom_id) {
                    $activeYear = AcademicYear::where('is_active', true)->first();
                    if ($activeYear) {
                        $user->classroomsAsStudent()->syncWithPivotValues([$request->classroom_id], ['academic_year_id' => $activeYear->id]);
                    }
                } else {
                    // Jika bukan murid lagi, lepas relasi kelas
                    $user->classroomsAsStudent()->detach();
                }
            });

            Alert::success('Berhasil', 'Data User berhasil diupdate');
            return redirect()->route('admin.users.index');

        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        Alert::success('Berhasil', 'Status akun berhasil diubah');
        return back();
    }

    public function resetPassword(Request $request, User $user)
    {
        $user->password = Hash::make('password123'); // Default password
        $user->save();

        Alert::success('Berhasil', 'Password direset menjadi "password123"');
        return back();
    }
}
