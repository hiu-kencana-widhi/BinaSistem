<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Autentikasi Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group Rute berdasarkan Middleware Role
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Utama setelah Login (bisa redirect ke dashboard masing-masing)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 👑 SUPER ADMIN
    Route::middleware(['role:super-admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
        
        // User Management
        Route::post('/users/{user}/toggle-status', [App\Http\Controllers\UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::post('/users/{user}/reset-password', [App\Http\Controllers\UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::resource('users', App\Http\Controllers\UserController::class);
        
        // Master Data
        Route::resource('classrooms', App\Http\Controllers\ClassroomController::class);
        Route::resource('subjects', App\Http\Controllers\SubjectController::class);
        
        // Other Master Data placeholders
        Route::get('/academic-years', function () { return "Academic Years"; })->name('academic_years.index');
        
        // Report
        Route::get('/reports/raport/{student}', [App\Http\Controllers\ReportController::class, 'downloadRaport'])->name('reports.raport');
        
        // Invoices
        Route::get('/invoices', [App\Http\Controllers\AdminInvoiceController::class, 'index'])->name('invoices.index');
        Route::get('/invoices/export', [App\Http\Controllers\AdminInvoiceController::class, 'export'])->name('invoices.export');
    });

    // 👨‍🏫 GURU
    Route::middleware(['role:guru'])->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', function () { return view('guru.dashboard'); })->name('dashboard');
        
        // E-Learning & Evaluasi
        Route::resource('materials', App\Http\Controllers\MaterialController::class);
        
        Route::put('/assignments/{assignment}/mass-grade', [App\Http\Controllers\AssignmentController::class, 'massGrade'])->name('assignments.mass-grade');
        Route::resource('assignments', App\Http\Controllers\AssignmentController::class);
        
        Route::resource('exams', App\Http\Controllers\ExamController::class);
        Route::resource('questions', App\Http\Controllers\QuestionController::class)->except(['index', 'show', 'edit', 'update']);
        Route::get('/grades', function () { return "Grades"; })->name('grades.index');
        
        // Absensi
        Route::get('/attendances', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendances.index');
        Route::post('/attendances', [App\Http\Controllers\AttendanceController::class, 'store'])->name('attendances.store');
    });

    // 🎒 MURID
    Route::middleware(['role:murid'])->prefix('murid')->name('murid.')->group(function () {
        Route::get('/dashboard', function () { return view('murid.dashboard'); })->name('dashboard');
        
        // E-Learning
        Route::get('/materials', [App\Http\Controllers\StudentMaterialController::class, 'index'])->name('materials.index');
        Route::post('/materials/{material}/mark-read', [App\Http\Controllers\StudentMaterialController::class, 'markAsRead'])->name('materials.mark-read');
        
        // Tugas
        Route::get('/assignments', [App\Http\Controllers\StudentAssignmentController::class, 'index'])->name('assignments.index');
        Route::get('/assignments/{assignment}', [App\Http\Controllers\StudentAssignmentController::class, 'show'])->name('assignments.show');
        Route::post('/assignments/{assignment}/store', [App\Http\Controllers\StudentAssignmentController::class, 'storeSubmission'])->name('assignments.store');
        
        // Ujian (CBT)
        Route::get('/exams', [App\Http\Controllers\StudentExamController::class, 'index'])->name('exams.index');
        Route::get('/exams/{exam}', [App\Http\Controllers\StudentExamController::class, 'show'])->name('exams.show');
        Route::post('/exams/{exam}/store', [App\Http\Controllers\StudentExamController::class, 'storeAnswers'])->name('exams.store');
        
        // Keuangan & SPP
        Route::get('/invoices', [App\Http\Controllers\StudentInvoiceController::class, 'index'])->name('invoices.index');
        Route::get('/invoices/{invoice}/pay', [App\Http\Controllers\StudentInvoiceController::class, 'pay'])->name('invoices.pay');
    });
});

// Webhooks & Callbacks
Route::post('/api/midtrans/callback', [App\Http\Controllers\WebhookController::class, 'midtransCallback'])->name('api.midtrans.callback');
Route::post('/api/pseudo/callback', [App\Http\Controllers\WebhookController::class, 'pseudoCallback'])->name('api.pseudo.callback');

