<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\UserlistController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BranchstaffController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\BeltController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\KarateClassTemplateController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AttendanceTypeController;
use App\Http\Controllers\StudentAttendanceController;
use App\Http\Controllers\InstructorAttendanceController;
use App\Http\Controllers\GradingExamController;
use App\Http\Controllers\GradingExamResultController;
use App\Http\Controllers\AdmissionCardController;



use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('branches')->group(function () {
    Route::get('/', [BranchController::class, 'index'])->name('branch.index');
    Route::get('/create', [BranchController::class, 'create'])->name('branch.create');
    Route::post('/store', [BranchController::class, 'store'])->name('branch.store');
    Route::get('{id}/show', [BranchController::class, 'show'])->name('branch.show');
    Route::get('{branch}/edit', [BranchController::class, 'edit'])->name('branch.edit');
    Route::put('{branch}/update', [BranchController::class, 'update'])->name('branch.update');
    Route::delete('{branch}/destroy', [BranchController::class, 'destroy'])->name('branch.destroy');

});

Route::middleware('auth')->prefix('userlists')->group(function () {
    Route::get('/', [UserlistController::class, 'index'])->name('userlist.index');
});

Route::middleware('auth')->prefix('admins')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('{id}/show', [AdminController::class, 'show'])->name('admin.show');
    Route::get('{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('{id}/update', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('{id}/destroy', [AdminController::class, 'destroy'])->name('admin.destroy');
});

Route::middleware('auth')->prefix('branchstaffs')->group(function () {
    Route::get('/', [BranchStaffController::class, 'index'])->name('branchstaff.index'); 
    Route::get('/create', [BranchStaffController::class, 'create'])->name('branchstaff.create');
    Route::post('/', [BranchStaffController::class, 'store'])->name('branchstaff.store'); 
    Route::get('/{id}', [BranchStaffController::class, 'show'])->name('branchstaff.show'); 
    Route::get('/{id}/edit', [BranchStaffController::class, 'edit'])->name('branchstaff.edit');
    Route::put('/{id}', [BranchStaffController::class, 'update'])->name('branchstaff.update');
    Route::delete('{id}/destroy', [BranchStaffController::class, 'destroy'])->name('branchstaff.destroy'); 
});

Route::middleware('auth')->prefix('instructors')->group(function () {
    Route::get('/', [InstructorController::class, 'index'])->name('instructor.index'); 
    Route::get('/create', [InstructorController::class, 'create'])->name('instructor.create');
    Route::post('/', [InstructorController::class, 'store'])->name('instructor.store');
    Route::get('/{id}', [InstructorController::class, 'show'])->name('instructor.show');
    Route::get('/{id}/edit', [InstructorController::class, 'edit'])->name('instructor.edit');
    Route::put('/{id}', [InstructorController::class, 'update'])->name('instructor.update');
    Route::delete('{id}/destroy', [InstructorController::class, 'destroy'])->name('instructor.destroy');
});

Route::middleware('auth')->prefix('belts')->group(function () {
    Route::get('/', [BeltController::class, 'index'])->name('belt.index');
    Route::get('/{id}', [BeltController::class, 'show'])->name('belt.show');
    Route::get('{id}/edit', [BeltController::class, 'edit'])->name('belt.edit');
    Route::put('/{id}', [BeltController::class, 'update'])->name('belt.update');
});


Route::middleware('auth')->prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('student.index');
    Route::get('/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/', [StudentController::class, 'store'])->name('student.store');
    Route::get('/{id}', [StudentController::class, 'show'])->name('student.show');
    Route::get('/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::put('/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::delete('/{id}/destroy', [StudentController::class, 'destroy'])->name('student.destroy');
});


//Achievements
Route::middleware(['auth'])->group(function () {
    Route::get('/achievements', [AchievementController::class, 'index'])->name('achievement.index');
    Route::get('/achievement/create/{studentId}', [AchievementController::class, 'create'])->name('achievement.create');
    Route::post('/achievements', [AchievementController::class, 'store'])->name('achievement.store');
    Route::get('/achievements/{studentId}', [AchievementController::class, 'show'])->name('achievement.show');
    Route::get('/student/{studentId}/achievement/{achievementId}/edit', [AchievementController::class, 'edit'])->name('achievement.edit');
    Route::put('/achievements/{id}', [AchievementController::class, 'update'])->name('achievement.update');
    Route::delete('/achievements/{id}', [AchievementController::class, 'destroy'])->name('achievement.destroy');
});

Route::middleware('auth')->prefix('payments')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('payment.index');
    Route::get('/create', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/{id}/edit', [PaymentController::class, 'edit'])->name('payment.edit');
    Route::put('/{id}', [PaymentController::class, 'update'])->name('payment.update');
    Route::get('/{id}', [PaymentController::class, 'show'])->name('payment.show');
    Route::get('/{id}/download-receipt', [PaymentController::class, 'downloadReceipt'])->name('payment.downloadReceipt');
    
});

Route::middleware('auth')->prefix('salaries')->group(function () {
    Route::get('/', [SalaryController::class, 'index'])->name('salary.index');
    
});

Route::middleware('auth')->prefix('events')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('event.index');
    Route::get('/create', [EventController::class, 'create'])->name('event.create');
    Route::post('/', [EventController::class, 'store'])->name('event.store');
    Route::get('/event/{id}', [EventController::class, 'show'])->name('event.show');
    Route::get('/{id}/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::put('/{id}', [EventController::class, 'update'])->name('event.update');
    Route::patch('/{id}/update-status', [EventController::class, 'updateStatus'])->name('event.updateStatus');
    Route::delete('/{id}/destroy', [EventController::class, 'destroy'])->name('event.destroy');
   
});

Route::middleware('auth')->prefix('announcements')->group(function () {
    Route::get('/', [AnnouncementController::class, 'index'])->name('announcement.index');
    Route::get('/create', [AnnouncementController::class, 'create'])->name('announcement.create');
    Route::post('/', [AnnouncementController::class, 'store'])->name('announcement.store');
    Route::get('/{id}/edit', [AnnouncementController::class, 'edit'])->name('announcement.edit');
    Route::put('/{id}', [AnnouncementController::class, 'update'])->name('announcement.update');
    Route::get('/{id}', [AnnouncementController::class, 'show'])->name('announcement.show');
    Route::delete('/{id}/destroy', [AnnouncementController::class, 'destroy'])->name('announcement.destroy');
    
   
});

Route::middleware('auth')->prefix('schedules')->group(function () {
    Route::get('/', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/create', [ScheduleController::class, 'create'])->name('schedule.create');
    Route::post('/', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::get('/{id}/edit', [ScheduleController::class, 'edit'])->name('schedule.edit');
    Route::put('/{id}', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/{id}/destroy', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
});

Route::middleware('auth')->prefix('class_templates')->group(function () {
    Route::get('/', [KarateClassTemplateController::class, 'index'])->name('class_template.index');
    Route::get('/create', [KarateClassTemplateController::class, 'create'])->name('class_template.create');
    Route::post('/', [KarateClassTemplateController::class, 'store'])->name('class_template.store');
    Route::get('/{id}/edit', [KarateClassTemplateController::class, 'edit'])->name('class_template.edit');
    Route::put('/{id}', [KarateClassTemplateController::class, 'update'])->name('class_template.update');
    Route::delete('/{id}/destroy', [KarateClassTemplateController::class, 'destroy'])->name('class_template.destroy');
    
});

Route::middleware('auth')->prefix('classes')->group(function () {
    Route::get('/', [ClassController::class, 'index'])->name('class.index');
   
    
});


Route::middleware('auth')->prefix('attendances')->group(function () {
    Route::get('/', [AttendanceTypeController::class, 'index'])->name('attendance.index');

    Route::get('/student', [StudentAttendanceController::class, 'index'])->name('student_attendance.index');
    Route::get('/student-attendance/create', [StudentAttendanceController::class, 'create'])->name('student_attendance.create');
    Route::post('/student-attendance', [StudentAttendanceController::class, 'store'])->name('student_attendance.store');
    Route::get('/student-attendance/{id}/edit', [StudentAttendanceController::class, 'edit'])->name('student_attendance.edit');
    Route::put('/student-attendance/{id}', [StudentAttendanceController::class, 'update'])->name('student_attendance.update');
    Route::delete('/student_attendance/{id}/destroy', [StudentAttendanceController::class, 'destroy'])->name('student_attendance.destroy');
    Route::get('/student-attendance/download', [StudentAttendanceController::class, 'download'])->name('student_attendance.download');


    // AJAX: for class and event attendance for students
    Route::get('/get-schedules/{classId}', [StudentAttendanceController::class, 'getSchedules']);
    Route::get('/get-students/{scheduleId}', [StudentAttendanceController::class, 'getStudents']);
    Route::get('/get-all-students-for-event/{eventId}', [StudentAttendanceController::class, 'getAllStudentsForEvent']);

    Route::get('/instructor', [InstructorAttendanceController::class, 'index'])->name('instructor_attendance.index');
    Route::get('/instructor-attendance/create', [InstructorAttendanceController::class, 'create'])->name('instructor_attendance.create');
    Route::post('/instructor-attendance', [InstructorAttendanceController::class, 'store'])->name('instructor_attendance.store');
    Route::get('/instructor-attendance/download', [InstructorAttendanceController::class, 'download'])->name('instructor_attendance.download');    

    // AJAX: Only for class attendance for Instructors
    Route::get('/get-instructor-schedules/{classId}', [InstructorAttendanceController::class, 'getSchedules']);
    Route::get('/get-instructors/{scheduleId}', [InstructorAttendanceController::class, 'getInstructors']);
    
    
});

Route::prefix('grading-exams')->group(function () {
    Route::get('/', [GradingExamController::class, 'index'])->name('grading_exam.index');
    Route::get('/admissions', [GradingExamController::class, 'admission'])->name('grading_exam.admission');

    Route::get('/admission-card/{exam}/{student}', [GradingExamController::class, 'viewAdmissionCard'])->name('grading_exam.admission_card.view');
    Route::get('/admission-card/download/{exam}/{student}', [GradingExamController::class, 'downloadAdmissionCard'])->name('grading_exam.admission_card.download');

    Route::get('/exam-detail', [GradingExamController::class, 'examdetail'])->name('grading_exam.detail');

    // Results routes
    Route::get('/results', [GradingExamResultController::class, 'index'])->name('grading_exam_result.index');
    Route::get('/create', [GradingExamResultController::class, 'create'])->name('grading_exam_result.create');
    Route::post('/store', [GradingExamResultController::class, 'store'])->name('grading_exam_result.store');
    Route::get('/results/{result}/edit', [GradingExamResultController::class, 'edit'])->name('grading_exam_result.edit');
    Route::put('/results/{result}', [GradingExamResultController::class, 'update'])->name('grading_exam_result.update');
    Route::delete('/results/{result}', [GradingExamResultController::class, 'destroy'])->name('grading_exam_result.destroy');
});




















require __DIR__.'/auth.php';
