<?php

use Illuminate\Support\Facades\Route;

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

/**** DEVELOPER ROUTES  ****/

Route::get('/optimize-clear', function() {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return "Cache is cleared";
});

Route::get('/storage-link', function() {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return "Linked";
});


Route::get('/clear-cache', function() {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::get('/clear-route', function() {
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    return "Route is cleared";
});

Route::get('/clear-config', function() {
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    return "Config is cleared";
});

Route::get('/clear-view', function() {
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    return "View is cleared";
});

Route::get('/down-mode', function() {
    \Illuminate\Support\Facades\Artisan::call('down --message="Site is in maintenance mode." --retry=60 --allow=103.136.63.0/24');
    return "Site is under maintenance.";
});


/**** Developer ROUTE  ****/

use Illuminate\Support\Facades\Auth;
/******************************************Admin panel starts***************************************/
Auth::routes();
Route::get('/sitemap.xml','Backend\SeoController@sitemapXml');
Route::get('/robots.txt','Backend\SeoController@robotsTxt');

Route::group(['middleware'=>['auth','adminAccessAllow'],'prefix'=>'backend'],function (){
    Route::group(['name'=>'ajax','as'=>'ajax.'],function (){
        Route::get('/ajax/batch-of-a-course/{id}','Backend\AjaxController@batchOfACourse')->name('batch-of-a-course');
        Route::post('/ajax/change-transaction-status','Backend\AjaxController@changeTransactionStatus')->name('change-transaction-status');
        Route::get('/ajax/get-post-categories','Backend\AjaxController@getPostCategories')->name('get-post-categories');
        Route::get('/ajax/get-slug/{name}','Backend\AjaxController@generateSlug')->name('get-a-slug');
        Route::get('/ajax/topics-of-subject','Backend\AjaxController@getTopOnSubject')->name('topics-of-subject');
        Route::get('/ajax/batch-with-students','Backend\AjaxController@batchStudents')->name('batch-students');
        Route::get('/ajax/exam-participants','Backend\AjaxController@examParticipants')->name('exam-participants');
        Route::get('/ajax/exam-result','Backend\AjaxController@examResultList')->name('exam-result');
        Route::get('/ajax/question-suggestion','Backend\AjaxController@getQuestionSuggestion')->name('question-suggestion');
        Route::post('/ajax/cert-preview-process','Backend\AjaxController@previewCertificateProcess');
        Route::get('/ajax/cert-preview/{name}','Backend\AjaxController@generateCertificatePreview')->name('cert-preview');
    });
    Route::get('/dashboard', 'Backend\DashBoardController@index')->name('dashboard');

    Route::group(['name'=>'web-setting','as'=>'web-setting.'],function(){
        Route::get('/appearance','Backend\WebSettingController@appearance')->name('appearance-setup');
        Route::post('/appearance/storeUpdate', 'Backend\WebSettingController@appearanceStoreUpdate')->name('appearance-store-update');
    });

    Route::group(['name'=>'seo','as'=>'seo.'],function (){
        Route::get('/seo-global','Backend\SeoController@globalUI')->name('global-seo');
        Route::post('/upload-sitemap','Backend\SeoController@uploadSitemap')->name('upload-sitemap');
        Route::post('/upload-robots','Backend\SeoController@uploadRobots')->name('upload-robots');
    });

    Route::group(['name'=>'course-type-setup','as'=>'course-type-setup.'],function(){
        Route::get('/course-type-setup','Backend\CourseTypeController@index')->name('index');
        Route::post('/course-type-setup','Backend\CourseTypeController@store')->name('store');
        Route::get('/course-type-setup/{id}','Backend\CourseTypeController@edit')->name('edit');
        Route::put('/course-type-setup/{id}','Backend\CourseTypeController@update')->name('update');
        Route::delete('/course-type-setup/{id}','Backend\CourseTypeController@delete')->name('delete');
    });

    Route::group(['name'=>'course-setup','as'=>'course-setup.'],function(){
        Route::get('/course-setup','Backend\CourseController@index')->name('index');
        Route::post('/course-setup','Backend\CourseController@store')->name('store');
        Route::get('/course-setup/{id}','Backend\CourseController@edit')->name('edit');
        Route::put('/course-setup/{id}','Backend\CourseController@update')->name('update');
        Route::delete('/course-setup/{id}','Backend\CourseController@delete')->name('delete');
        Route::post('/course-setup-datalist','Backend\CourseController@dataList')->name('datalist');
        Route::delete('/course-setup-file/{id}/{code?}','Backend\CourseController@fileDelete')->name('file-delete');
        Route::get('/course-setup-download/{id}/{fileCode?}','Backend\CourseController@download')->name('file-download');
    });
    
    Route::group(['name'=>'course-trainers-map','as'=>'course-trainers-map.'],function(){
        Route::get('/course-trainers-map','Backend\CourseTrainersMapController@index')->name('index');
        Route::post('/course-trainers-map','Backend\CourseTrainersMapController@store')->name('store');
        Route::get('/course-trainers-map/{id}','Backend\CourseTrainersMapController@edit')->name('edit');
        Route::put('/course-trainers-map/{id}','Backend\CourseTrainersMapController@update')->name('update');
        Route::post('/course-trainers-map-datalist','Backend\CourseTrainersMapController@dataList')->name('datalist');
    });

    Route::group(['name'=>'course-ui', 'as'=>'course-ui.'],function (){
        Route::get('/course-master-setup','Backend\CourseUiController@index')->name('index');
        Route::post('/course-list','Backend\CourseUiController@dataList')->name('course-list');
        Route::post('/course-check-uncheck','Backend\CourseUiController@checkUnCheck')->name('course-check-uncheck');
    });

    Route::group(['name'=>'service-ui', 'as'=>'service-ui.'],function (){
        Route::get('/service-master-setup','Backend\ServiceUiController@index')->name('index');
        Route::post('/service-list','Backend\ServiceUiController@dataList')->name('service-list');
        Route::post('/service-check-uncheck','Backend\ServiceUiController@checkUnCheck')->name('service-check-uncheck');
    });

    Route::group(['name'=>'batch-setup','as'=>'batch-setup.'],function(){
        Route::get('/batch-setup','Backend\BatchController@index')->name('index');
        Route::post('/batch-setup','Backend\BatchController@store')->name('store');
        Route::get('/batch-setup/{id}','Backend\BatchController@edit')->name('edit');
        Route::put('/batch-setup/{id}','Backend\BatchController@update')->name('update');
        Route::delete('/batch-setup-file/{id}','Backend\BatchController@fileDelete')->name('file-delete');
        Route::delete('/batch-setup/{id}','Backend\BatchController@delete')->name('delete');
        Route::post('/batch-setup-datalist','Backend\BatchController@dataList')->name('datalist');
        Route::get('/batch-setup-download/{id}/{type?}','Backend\BatchController@download')->name('file-download');
    });

    Route::group(['name'=>'batch-schedule','as'=>'batch-schedule.'],function(){
        Route::get('/batch-schedule','Backend\BatchScheduleController@index')->name('index');
        Route::post('/batch-schedule','Backend\BatchScheduleController@store')->name('store');
        Route::get('/batch-schedule/{id}','Backend\BatchScheduleController@edit')->name('edit');
        Route::put('/batch-schedule/{id}','Backend\BatchScheduleController@update')->name('update');
        Route::delete('/batch-schedule/{id}','Backend\BatchScheduleController@delete')->name('delete');
        Route::post('/batch-schedule-datalist','Backend\BatchScheduleController@dataList')->name('datalist');
    });

    Route::group(['name'=>'student','as'=>'student.'],function(){
        Route::get('/student','Backend\StudentController@index')->name('index');
        Route::get('/student/{id}','Backend\StudentController@detailView')->name('detail');
        Route::post('/student-datalist','Backend\StudentController@dataList')->name('datalist');
        Route::get('/student-file-download/{id}','Backend\StudentController@download')->name('file-download');
    });

    Route::group(['name'=>'student-transaction','as'=>'student-transaction.', 'namespace'=>'Backend'],function(){
        Route::get('/student-transaction','StudentTransactionController@index')->name('index');
        Route::get('/student-transaction/{id}','StudentTransactionController@detailView')->name('detail');
        Route::post('/student-transaction-datalist','StudentTransactionController@dataList')->name('datalist');
        Route::get('/send-confirmation-email/{id}','StudentTransactionController@sendConfirmEmail')->name('confirmation-email');
    });

    Route::group(['name'=>'post-category-setup','as'=>'post-category-setup.'],function(){
        Route::get('/post-category-setup','Backend\PostCategoryController@index')->name('index');
        Route::post('/post-category-setup','Backend\PostCategoryController@store')->name('store');
        Route::get('/post-category-setup/{id}','Backend\PostCategoryController@edit')->name('edit');
        Route::put('/post-category-setup/{id}','Backend\PostCategoryController@update')->name('update');
        Route::delete('/post-category-setup/{id}','Backend\PostCategoryController@delete')->name('delete');
    });

    Route::group(['name'=>'post-write','as'=>'post-write.'],function(){
        Route::get('/post-write','Backend\PostController@index')->name('index');
        Route::post('/post-write','Backend\PostController@store')->name('store');
        Route::get('/post-write/{id}','Backend\PostController@edit')->name('edit');
        Route::put('/post-write/{id}','Backend\PostController@update')->name('update');
        Route::delete('/post-write-file/{id}','Backend\PostController@fileDelete')->name('file-delete');
        Route::delete('/post-write/{id}','Backend\PostController@delete')->name('delete');
        Route::post('/post-write-datalist','Backend\PostController@dataList')->name('datalist');
        Route::get('/post-write-download/{id}','Backend\PostController@download')->name('file-download');
    });
    
    Route::group(['name'=>'circular-setup','as'=>'circular-setup.'],function(){
        Route::get('/circular-setup','Backend\CircularSetupController@index')->name('index');
        Route::post('/circular-setup','Backend\CircularSetupController@store')->name('store');
        Route::get('/circular-setup/{id}','Backend\CircularSetupController@edit')->name('edit');
        Route::put('/circular-setup/{id}','Backend\CircularSetupController@update')->name('update');
        Route::post('/circular-setup-datalist','Backend\CircularSetupController@dataList')->name('datalist');
        Route::delete('/circular-setup/{id}','Backend\CircularSetupController@delete')->name('delete');
    });
    
    Route::group(['name'=>'trainer-setup','as'=>'trainer-setup.'],function(){
        Route::get('/trainer-setup','Backend\TrainerSetupController@index')->name('index');
        Route::post('/trainer-setup','Backend\TrainerSetupController@store')->name('store');
        Route::get('/trainer-setup/{id}','Backend\TrainerSetupController@edit')->name('edit');
        Route::put('/trainer-setup/{id}','Backend\TrainerSetupController@update')->name('update');
        Route::post('/trainer-setup-datalist','Backend\TrainerSetupController@dataList')->name('datalist');
        Route::delete('/trainer-setup/{id}','Backend\TrainerSetupController@delete')->name('delete');
    });

    Route::group(['name'=>'message','as'=>'message.'],function(){
        Route::get('/message-list','Backend\MessageController@messageList')->name('message-list');
        Route::post('/new-message-datalist','Backend\MessageController@dataList')->name('new-message-datalist');
        Route::post('/delete_message','Backend\MessageController@deleteMessage')->name('delete_message');
    });
    
    Route::group(['name'=>'page-setup','as'=>'page-setup.'],function(){
        Route::get('/page-setup','Backend\PageSetupController@index')->name('index');
        Route::post('/page-setup','Backend\PageSetupController@store')->name('store');
        Route::get('/page-setup/{id}','Backend\PageSetupController@edit')->name('edit');
        Route::put('/page-setup/{id}','Backend\PageSetupController@update')->name('update');
        Route::delete('/page-setup/{id}','Backend\PageSetupController@delete')->name('delete');
        Route::post('/page-setup-datalist','Backend\PageSetupController@dataList')->name('page-setup-datalist');
        Route::get('/get-page-content', 'Backend\PageSetupController@getContent')->name('get-page-content');
        Route::get('/page-setup-download/{id}/{fileCode?}','Backend\PageSetupController@download')->name('file-download');
        Route::delete('/setup-file/{id}','Backend\PageSetupController@fileDelete')->name('delete-file');
        Route::get('/image-dimension-chk', 'Backend\PageSetupController@getDimension')->name('image-dimension-chk');
        Route::get('/image-dimension-chk-msg', 'Backend\PageSetupController@getDimensionMsg')->name('image-dimension-chk-msg');
        Route::get('/field-require-chk', 'Backend\PageSetupController@fieldRequired')->name('field-require-chk');
    });
    
    // Exam System Start
    Route::group(['name'=>'setup','as'=>'setup.','namespace'=>'Backend\Examination'],function(){
        Route::get('/topic-setup','TopicController@index')->name('topic-index');
		Route::get('/topic-setup/{id}','TopicController@editTopic')->name('topic-edit');
        Route::post('/topic-setup','TopicController@topicStore')->name('topic-store');
        Route::put('/topic-setup/{id}','TopicController@update')->name('topic-update');

        /*******Subject******/
        Route::get('/subject-setup','SubjectController@index')->name('subject-index');
        Route::get('/subject-setup/{id}','SubjectController@editSubject')->name('subject-edit');
        Route::post('/subject-setup','SubjectController@subjectStore')->name('subject-store');
        Route::put('/subject-setup/{id}','SubjectController@update')->name('subject-update');

    });
    
    Route::group(['name'=>'question','as'=>'question.'],function (){
        Route::get('/question','Backend\Examination\QuestionController@index')->name('index');
        Route::get('/question-list','Backend\Examination\QuestionController@list')->name('list');
        Route::post('/question-create/{id?}','Backend\Examination\QuestionController@create')->name('store');
        Route::get('/question-edit/{id}','Backend\Examination\QuestionController@edit')->name('edit');
        Route::get('/question-remove','Backend\Examination\QuestionController@remove')->name('remove');
    });
    
    Route::group(['name'=>'exam','as'=>'exam.','namespace'=>'Backend\Examination'],function (){
        Route::get('/exam','ExamController@index')->name('index');
        Route::post('/exam','ExamController@create')->name('create');
        Route::get('/exam/{id}','ExamController@edit')->name('edit');
        Route::put('/exam/{id}','ExamController@update')->name('update');
        Route::get('/exam-download/{id}/{ce_image}/{type?}','ExamController@download')->name('file-download');

        Route::get('/exam-list','ExamController@list')->name('list');
        Route::post('/exam-list','ExamController@listDataTable')->name('lists');
        Route::get('/questions/{exam_id}','ExamController@taggedQuestionsList')->name('questions');
        Route::get('/question-add/{exam_id}','ExamController@tagQuestionView')->name('question-add');
        Route::get('/status-update','ExamController@statusUpdate')->name('status-update');
        Route::post('/question-tag','ExamController@tagQuestion')->name('question-tag');
        Route::get('exam-distribute/{exam_id}', 'ExamController@examDistribute')->name('distribute');

        /*Exam Result*/
        Route::get('/result','ExamResultController@index')->name('result');
        Route::get('/student-list/{exam}','ExamResultController@studentList')->name('student-list');
        Route::get('/judge-answer/{exam}/{transId}','ExamResultController@getAnswers')->name('get-answer-questions');
        Route::post('/judge-answer','ExamResultController@submitMarks')->name('store-judgement');
        Route::get('/student-result','ExamResultController@studentResult')->name('student-result');
        Route::post('/publish-result','ExamResultController@resultPublish')->name('result-publish');
        Route::get('/exam-result-export/{examId}', 'ExamResultController@examResultExport')->name('exam-result-export');
    });
});
/*Admin panel end*/

/**********************************************Student panel start************************************/
Route::group(['middleware'=>'auth'],function (){
    Route::get('/user-home', 'Frontend\StudentController@index')->name('user-home');

    Route::group(['name'=>'login-user','as'=>'login-user.','namespace'=>'Frontend'],function(){
        Route::get('/login-user-profile','StudentController@loginUserProfile')->name('login-user-profile');
        Route::put('/login-user-profile/{id}', 'StudentController@loginUserProfileUpdate')->name('login-user-profile-update');

        Route::get('/login-user-courses','StudentController@loginUserCourses')->name('login-user-courses');
        Route::post('/login-user-course-datalist','StudentController@courseDataList')->name('login-user-course-datalist');

        Route::get('/login-user-payable-courses','StudentController@loginUserPayableCourses')->name('login-user-payable-courses');
        Route::post('/login-user-payable-course-datalist','StudentController@payableCourseDataList')->name('payable-course-datalist');
        Route::get('/login-user-course-pay/{id}','StudentController@loginUserCoursePay')->name('login-user-course-pay');
        Route::post('/login-user-course-pay/{id}','StudentController@loginUserCoursePayStore')->name('login-user-course-pay');

        Route::get('/login-user-profile-picture/download/{id}', 'DownloaderController@profilePictureAttachment')->name('profile-picture-download');
        Route::get('/login-user-certificate/download/{id}', 'DownloaderController@certificateAttachment')->name('certificate-download');

        Route::get('/login-user-exams','StudentController@exams')->name('login-user-exams');
        Route::get('/login-user-events','StudentController@events')->name('login-user-events');
        Route::get('/login-user-skills','StudentController@skills')->name('login-user-skills');

        Route::get('/make-payment','StudentController@paymentPage')->name('pay-for-event');
        Route::post('/make-payment','StudentController@paymentMake')->name('make-payment');
    });
    
    Route::group(['prefix'=> 'assessment','as'=>'assessment.','namespace'=>'Backend\Examination'],function (){
        Route::get('/assessment-rules/{exam}/{trans}','AssessmentController@detail')->name('assessment-participate')->middleware('assessmentAllow');
        Route::get('/assessment-start/{exam}/{trans}','AssessmentController@start')->name('assessment-start')->middleware('assessmentAllow');
        Route::post('/assessment-push-content/{exam}/{trans}','AssessmentController@postAnswer')->name('assessment-push-content');
    });

    Route::get('/assessment-result','Frontend\StudentController@resultView')->name('assessment-result');
    Route::get('/assessment-certificate/{e}/{t}','Frontend\StudentController@certificateDownload')->name('assessment-cert');
});


/*Student panel end*/

/**********************************************Frontend start*****************************************/

Route::get('/', 'Frontend\HomeController@index')->name('/home');
/*Route::get('/home', 'HomeController@index')->name('home');*/

Route::group(['prefix' => 'registration', 'as' => 'registration.'], function () {
    Route::get('/registration', 'Frontend\RegistrationController@index')->name('index');
    Route::post('/registration', 'Frontend\RegistrationController@store')->name('store');
});

Route::group(['prefix'=>'event','as'=>'event.','namespace'=>'Frontend'],function (){
    Route::get('/event-list','StudentController@eventList')->name('event-list');
    Route::get('/event-detail/{event}','StudentController@eventView')->name('event-detail');
});

/*
Route::group(['prefix'=>'login','as'=>'login.'],function (){
    Route::get('/login','Frontend\LoginController@index')->name('index');
    Route::post('/login-user','Frontend\LoginController@loginUser')->name('login-user');
    Route::get('/login-user-details', 'Frontend\LoginController@loginUserDetails')->name('login-user-details');
    Route::post('/login-user-course-datalist', 'Frontend\LoginController@courseDataList')->name('datalist');
    Route::get('/login-user-course-pay/{id}', 'Frontend\LoginController@loginUserCoursePay')->name('login-user-course-pay');
});

Route::group(['name' => 'student-login', 'as' => 'student-login.'], function () {
    Route::post('/login-user', 'Frontend\LoginController@loginUser')->name('login-user');
    Route::get('/login-user-details', 'Frontend\LoginController@loginUserDetails')->name('login-user-details');
    Route::post('/login-user-course-datalist', 'Frontend\LoginController@courseDataList')->name('datalist');
    Route::get('/login-user-course-pay/{id}', 'Frontend\LoginController@loginUserCoursePay')->name('login-user-course-pay');
});*/

Route::group(['prefix' => 'course', 'as' => 'course.'], function () {
    Route::get('/course-list-all', 'Frontend\CourseController@index')->name('index');
    Route::get('/course-list/{id}', 'Frontend\CourseController@courseList')->name('list');
    Route::get('/course-detail/{slug}', 'Frontend\CourseController@courseDetail')->name('detail');
});

Route::group(['prefix' => 'trainers', 'as' => 'trainers.'], function () {
    Route::get('/', 'Frontend\TrainersController@index')->name('index');
    //Route::get('/trainers', 'Frontend\TrainersController@index')->name('index');
});

Route::group(['prefix' => 'student-feedback', 'as' => 'student-feedback.'], function () {
    Route::get('/', 'Frontend\StudentFeedBackController@index')->name('index');
    //Route::get('/student-feedback', 'Frontend\StudentFeedBackController@index')->name('index');
});

Route::group(['prefix' => 'contact-us', 'as' => 'contact-us.'], function () {
    Route::get('/', 'Frontend\ContactController@index')->name('index');
    //Route::get('/contact-us', 'Frontend\ContactController@index')->name('index');
    Route::post('/contact-us', 'Frontend\ContactController@store')->name('store');
});

Route::group(['prefix' => 'about-us', 'as' => 'about-us.'], function () {
    Route::get('/', 'Frontend\AboutController@index')->name('index');
    //Route::get('/about-us', 'Frontend\AboutController@index')->name('index');
});

Route::group(['prefix' => 'web-post', 'as' => 'web-post.'], function () {
    Route::get('/web-post-list-all', 'Frontend\WebPostController@index')->name('index');
    Route::get('/web-post-detail/{slug}', 'Frontend\WebPostController@postDetail')->name('detail');
    Route::get('/web-post-category-wise/{id}', 'Frontend\WebPostController@categoryWisePosts')->name('category-wise-posts');
});

Route::group(['prefix' => 'service', 'as' => 'service.'], function () {
    Route::get('/service-list-all', 'Frontend\ServiceController@index')->name('index');
    Route::get('/service-list/{id}', 'Frontend\ServiceController@serviceList')->name('list');
    Route::get('/service-detail/{slug}', 'Frontend\ServiceController@serviceDetail')->name('detail');
});

Route::group(['prefix'=> 'skills','as'=>'skills.'],function (){
   Route::get('/online-tests','Frontend\SkillController@availableTests')->name('test-exams');
   Route::get('/online-test-participate/{e}','Frontend\SkillController@testDetail')->name('test-participate');
   Route::get('/online-test-start/{examId}/{trans?}','Frontend\SkillController@testStart')->name('test-start');
   Route::post('/next-content','Frontend\SkillController@nextQuestion')->name('next-content');
   Route::post('/push-content','Frontend\SkillController@postAnswer')->name('push-content');
   Route::get('/result-page/{e}/{i}','Frontend\SkillController@resultGenerate')->name('result-content');
});

Route::get('/assessment-cert-view/{cert}','Frontend\SkillController@viewCert')->name('view-certificate');

Route::get('/page-not-allowed/{message}/{requested_url?}', 'HomeController@pageNotAllowed')->name('page-not-allowed');
Route::get('/parking-page/{message}/{departure}/{requested_url?}', 'HomeController@parkForAMoment')->name('parking-page');


Route::group(['prefix' => 'circular', 'as' => 'circular.'], function () {
    Route::get('/circular-list-all', 'Frontend\CircularController@index')->name('index');
    Route::get('/circular-detail/{id}', 'Frontend\CircularController@circularDetail')->name('detail');
});

Route::group(['prefix' => 'privacy-policy', 'as' => 'privacy-policy.'], function () {
    Route::get('/', 'Frontend\PrivacyPolicyController@index')->name('index');
});

/*Route::get('/home', 'HomeController@index')->name('home');*/
/*Frontend end*/
