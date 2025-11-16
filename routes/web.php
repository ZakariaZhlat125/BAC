<?php

use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SuperVisorController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ContentReportController;
use App\Http\Controllers\ContentSummaryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboradController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\UpgradeRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'show'])->name('home');
    Route::get('/home/cources/{id}', [HomeController::class, 'speciCources'])->name('home.specialization.cources');
    Route::get('/home/cources/chapter/{id}', [HomeController::class, 'showChapter'])->name('home.specialization.cources.chapters');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/evaluations', [EvaluationController::class, 'store'])->name('evaluations.store');
    Route::get('/home/videoContent/{id}', [HomeController::class, 'showVideoContent'])->name('home.showVideoContent');
    Route::get('/home/showSummaryContent/{id}', [HomeController::class, 'showSummaryContent'])->name('home.showSummaryContent');
    Route::get('/comments', function (Request $request) {
        return \App\Models\Comment::where('content_id', $request->content_id)->with('user')->get();
    });
    Route::get('/evaluations/{contentId}', [EvaluationController::class, 'getEvaluations']);

    Route::get('/getMyData', [DashboradController::class, 'getMyData'])->name('getMyData');
    Route::post('/notifications/read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['status' => 'success']);
    })->name('notifications.read');

    // Specialization page
    Route::get('/specialization', [SpecializationController::class, 'getSpecializationPage']);



    Route::prefix('dashborad')->middleware(['auth'])->group(function () {
        Route::get('/', [DashboradController::class, 'show'])->name('dashboard.show');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.show');
        Route::get('/notification', [NotificationsController::class, 'show'])->name('notification.show');
        // Profile update & delete
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        // ========================
        // Dashboard للمشرفين
        // ========================

        Route::middleware(['role:admin'])->name('admin.')->group(function () {
            Route::resource('supervisors', SuperVisorController::class)->only(['index', 'destroy']);
            Route::resource('students', StudentController::class)->only(['index', 'destroy']);
        });

        // ========================
        // Dashboard للمشرفين
        // ========================
        Route::middleware(['role:supervisor'])->name('supervisor.')->group(function () {
            // طلبات الترقية
            Route::get('upgrade-requests', [UpgradeRequestController::class, 'index'])->name('upgrade-requests.index');
            Route::get('upgrade-requests/pending', [UpgradeRequestController::class, 'pending'])->name('upgrade-requests.pending');
            Route::put('upgrade-requests/{upgradeRequest}/status', [UpgradeRequestController::class, 'updateStatus'])->name('upgrade-requests.update-status');
            Route::delete('upgrade-requests/{upgradeRequest}', [UpgradeRequestController::class, 'destroy'])->name('upgrade-requests.destroy');
            Route::get('/content', [ContentController::class, 'showPage'])->name('content.show');
            Route::get('/content/approved', [ContentController::class, 'approvedContent'])->name('content.approvedContent');
            Route::post('/content-reports', [ContentReportController::class, 'storeReport'])->name('content-reports.store');
            Route::post('/content-summaries', [ContentSummaryController::class, 'storeSummary'])->name('content-summaries.store');

            // الفعاليات
            Route::resource('events', EventController::class);
            Route::post('/events/{event}/update-status', [EventController::class, 'updateStatus'])
                ->name('events.updateStatus');
            Route::patch(
                '/participations/{participation}/attendance',
                [EventController::class, 'updateAttendance']
            )
                ->name('participations.updateAttendance');

            // courses
            Route::resource('courses', CourseController::class);
            //chapter
            Route::resource('chapters', ChapterController::class);
            // content
            Route::put('contents/{content}/status', [ContentController::class, 'updateStatus'])->name('contents.updateStatus');
        });

        // ========================
        // Dashboard للطلاب
        // ========================
        Route::middleware(['role:student'])->name('user.')->group(function () {
            // إرسال طلب ترقية الحساب
            Route::post('upgrade-profile', [UpgradeRequestController::class, 'upgradeProfile'])->name('upgrade-profile');
            // كورساتي
            Route::get('my-cources', [CourseController::class, 'getMyCources'])->name('getMyCources');
            Route::get('show-cources/{id}', [CourseController::class, 'showCourceById'])->name('show-cources');
            Route::get('my-chapter/{id}', [ChapterController::class, 'myChapter'])->name('getMyChapter');
            // content
            Route::get('contents', [ContentController::class, 'index'])->name('contents.index');
            Route::get('contents/approved', [ContentController::class, 'approved'])->name('contents.approved');
            Route::post('contents', [ContentController::class, 'store'])->name('contents.store');
            Route::put('contents/{content}', [ContentController::class, 'update'])->name('contents.update');
            Route::delete('contents/{content}', [ContentController::class, 'destroy'])->name('contents.destroy');
            // الفعاليات
            Route::post('events/{event}/participate', [EventController::class, 'participate'])->name('events.participate')->middleware('auth');
            // عرض طلب الترقية الخاص بالطالب
            Route::get('upgrade-requests/my-request', [UpgradeRequestController::class, 'myRequest'])->name('upgrade-requests.my');
            Route::get('upgrade-requests/my-status', [UpgradeRequestController::class, 'Status'])->name('upgrade-requests.my');
            Route::get('upgrade-requests/my-status', [UpgradeRequestController::class, 'checkStatus'])->name('upgrade-requests.Status');
            Route::prefix('certifications')->name('certifications.')->group(function () {
                Route::get('/show', [CertificationController::class, 'show'])->name('show');
                Route::post('/issue/{student}', [CertificationController::class, 'issueCertificate'])->name('issue');
                Route::get('/print/{certification}', [CertificationController::class, 'printCertification'])->name('print');
            });
        });
    });
});
require __DIR__ . '/auth.php';
