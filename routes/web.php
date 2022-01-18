<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'share-data'], function () {
    Route::get('/', 'HomeController@index')->middleware('guest');


    Route::resource('/enquiry', 'EnquiryController')->only('store');
    Route::get('/guest/course', 'CourseController@index')->name('guest.course.index')->middleware('guest');
    Route::get('/guest/course/{course}', 'CourseController@show')->name('guest.course.show')->middleware('guest');
    Route::get('/register/instructor', 'Auth\RegisterController@instructorForm')->name('register.instructor.form');
    Route::post('/register/instructor', 'Auth\RegisterController@instructorCreate')->name('register.instructor');
    Route::get('/search-auto-complete', 'HomeController@searchAutoComplete')->name('search.auto.complete');
    Route::get('/search', 'HomeController@search')->name('search');
    Route::get('/contact-us', 'HomeController@contactUs')->name('contact.us');
    Route::get('/category/{category}', 'CategoryController@show')->name('category.show');

    Auth::routes();

    Route::group(['middleware' => 'auth'], function () {
        Route::resource('/course', 'CourseController');
        Route::get('/course/{course}/add-instructor', 'CourseController@addInstructorForm')->name('course.add.instructor');
        Route::put('/course/{course}/add-instructor', 'CourseController@addInstructor')->name('course.instructor.store');
        Route::post('/course/{course}/leave', 'CourseController@leaveCourse')->name('course.instructor.leave');
        Route::get('/course/{course}/image-upload', 'CourseController@imageUploadForm')->name('course.image.form');
        Route::put('/course/{course}/image-upload', 'CourseController@imageUpload')->name('course.image.upload');
        Route::post('/course/{course}/enroll', 'CourseController@enroll')->name('course.enroll');
        Route::post('/course/{course}/un-enroll', 'CourseController@unenroll')->name('course.unenroll');
        Route::get('/course/{course}/rating/', 'CourseController@ratingForm')->name('course.rating');
        Route::post('/course/{course}/rating/', 'CourseController@rating')->name('course.rating.store');
        Route::get('/course/{course}/rating/{rating}', 'CourseController@editRatingForm')->name('course.rating.edit');
        Route::put('/course/{course}/rating/{rating}', 'CourseController@editRating')->name('course.rating.update');
        Route::get('/wishlist', 'WishlistController@index')->name('wishlist.index');
        Route::post('course/{course}/wishlist', 'WishlistController@wishlist')->name('wishlist');
        Route::delete('course/remove-wishlist/{wishlist}', 'WishlistController@remove')->name('wishlist.remove');
        Route::resource('/course/{course}/module', 'ModuleController');
        Route::resource('/course/{course}/module/{module}/content', 'ContentController');
        Route::resource('/course/{course}/module/{module}/assessment', 'AssessmentController');
        Route::post('/course/{course}/module/{module}/assessment/{assessment}', 'AssessmentController@publish')->name('assessment.publish');
        Route::resource('/course/{course}/module/{module}/assessment/{assessment}/question', 'QuestionController');
        Route::resource('/course/{course}/module/{module}/assessment/{assessment}/question/{question}/response', 'ResponseController');
        Route::post('/course/{course}/module/{module}/assessment/{assessment}/question/{question}/response/{response}/grade', 'ResponseController@grade')->name('response.grade');
        Route::resource('/course/{course}/announcement', 'AnnouncementController');
        Route::resource('/course/{course}/discussion-panel/{discussionPanel}/thread', 'ThreadController');
        Route::resource('/course/{course}/discussion-panel/{discussionPanel}/thread/{thread}/reply', 'ReplyController')->only('store', 'update', 'destroy');
        Route::post('/reply/{reply}', 'ReplyController@markSolution')->name('mark.solution');
        Route::get('/course/{course}/discussion-panel/{discussionPanel}/thread/filter/{content}', 'ThreadController@filter')->name('thread.filter');
        Route::resource('/course/{course}/payment', 'PaymentController')->except('index', 'show', 'destroy');
        Route::get('course/{course}/stripe-payment', 'StripeController@create')->name('payment.stripe.create');
        Route::post('course/{course}/stripe-payment', 'StripeController@store')->name('payment.stripe.store');
        Route::get('/course/{course}/students-report', 'CourseController@studentsReport')->name('course.students.report')->middleware('allow:admin,instructor');
        Route::get('/course/{course}/student/{student}/assignments', 'CourseController@studentAssignments')->name('course.students.assignments')->middleware('allow:admin,instructor');
        Route::post('/content/{content}/note', 'NoteController@save')->name('note.save')->middleware('allow:student');
        Route::resource('/instructor', 'InstructorController')->only('edit', 'update');
        Route::resource('/user', 'UserController')->only('edit', 'update');

        Route::get('/notifications', 'HomeController@notifications')->name('notifications');
        Route::get('/unread-notifications', 'HomeController@unreadNotifications')->name('unread.notifications');
        Route::get('/read-notifications', 'HomeController@readNotifications')->name('read.notifications');

        Route::get('/profile', 'HomeController@profile')->name('profile');
        Route::get('/profile/edit', 'HomeController@editProfile')->name('profile.edit');
        Route::post('/profile/update', 'HomeController@updateProfile')->name('profile.update');
        Route::get('user/{user}/upload-photo', 'HomeController@uploadPhotoForm')->name('photo.upload.form');
        Route::post('user/{user}/upload-photo', 'HomeController@uploadPhoto')->name('photo.upload');
        Route::get('user/{user}/password-change', 'HomeController@changePassword')->name('password.change');
        Route::post('user/{user}/password-update', 'HomeController@updatePassword')->name('password.update');
        Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
        Route::resource('/instructor/{instructor}/documents', 'InstructorDocumentController')->except('show', 'edit', 'update')->middleware('allow:admin,instructor');
    });

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'allow:admin'], function () {
        Route::resource('/admin', 'AdminController')->except('show');
        Route::resource('/instructor', 'InstructorController')->except('edit', 'update');
        Route::resource('/user', 'UserController')->except('show', 'edit', 'update');
        Route::post('/instructor/{instructor}/verify', 'InstructorController@verify')->name('instructor.verify');
        Route::resource('/institution', 'InstitutionController')->except('show');
        Route::resource('/category', 'CategoryController')->except('show');
        Route::resource('/payment-info', 'PaymentInfoController')->except('show');
        Route::resource('/payment', 'PaymentController')->only('index', 'destroy');
        Route::resource('/enquiry', 'EnquiryController')->except('create', 'store');
        Route::post('/enquiry/{enquiry}/reply', 'EnquiryController@reply')->name('enquiry.reply');
        Route::post('/course/{course}/payment/{payment}/verify', 'PaymentController@verify')->name('payment.verify');
        Route::get('/course/{course}/assign-institution', 'CourseController@assignInstitutionForm')->name('course.assign.institution');
        Route::post('/course/{course}/assign-institution', 'CourseController@assignInstitution')->name('course.institution.store');
        Route::get('/course/{course}/enroll-students', 'CourseController@enrollStudentsForm')->name('course.enroll.students.form');
        Route::post('/course/{course}/enroll-students', 'CourseController@enrollStudents')->name('course.enroll.students');
    });
});
