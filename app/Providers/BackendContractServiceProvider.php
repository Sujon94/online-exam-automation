<?php
/**
 *Created by PhpStorm
 *Created at ২৭/৯/২১ ২:৪৫ PM
 */

namespace App\Providers;


use App\Contract\backend\AssessmentContract;
use App\Contract\backend\BatchContract;
use App\Contract\backend\BatchScheduleContract;
use App\Contract\backend\CircularContract;
use App\Contract\backend\CommonContract;
use App\Contract\backend\CourseContract;
use App\Contract\backend\CourseTypeContract;
use App\Contract\backend\EQuestionContract;
use App\Contract\backend\EXamContract;
use App\Contract\backend\ExamResultContract;
use App\Contract\backend\MessageContract;
use App\Contract\backend\PageSetupContract;
use App\Contract\backend\PostCategoryContract;
use App\Contract\backend\PostContract;
use App\Contract\backend\SkillTestContract;
use App\Contract\backend\StudentContract;
use App\Contract\backend\StudentTransactionContract;
use App\Contract\backend\TrainerContract;
use App\Contract\backend\WebSettingsContract;
use App\Manager\backend\AssessmentManager;
use App\Manager\backend\BatchManager;
use App\Manager\backend\BatchScheduleManager;
use App\Manager\backend\CircularManager;
use App\Manager\backend\CommonManager;
use App\Manager\backend\CourseManager;
use App\Manager\backend\CourseTypeManager;
use App\Manager\backend\EQuestionManager;
use App\Manager\backend\EXamManager;
use App\Manager\backend\ExamResultManager;
use App\Manager\backend\MessageManager;
use App\Manager\backend\PageSetupManager;
use App\Manager\backend\PostCategoryManager;
use App\Manager\backend\PostManager;
use App\Manager\backend\SkillTestManager;
use App\Manager\backend\StudentManager;
use App\Manager\backend\StudentTransactionManager;
use App\Manager\backend\TrainerManager;
use App\Manager\backend\WebSettingsManager;
use Illuminate\Support\ServiceProvider;

class BackendContractServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CourseTypeContract::class, CourseTypeManager::class);
        $this->app->bind(CourseContract::class, CourseManager::class);
        $this->app->bind(BatchContract::class, BatchManager::class);
        $this->app->bind(BatchScheduleContract::class, BatchScheduleManager::class);
        $this->app->bind(StudentTransactionContract::class, StudentTransactionManager::class);
        $this->app->bind(StudentContract::class, StudentManager::class);
        $this->app->bind(CommonContract::class, CommonManager::class);
        $this->app->bind(PostContract::class, PostManager::class);
        $this->app->bind(PostCategoryContract::class, PostCategoryManager::class);
        $this->app->bind(WebSettingsContract::class, WebSettingsManager::class);
        $this->app->bind(MessageContract::class, MessageManager::class);
        $this->app->bind(EQuestionContract::class, EQuestionManager::class);
        $this->app->bind(EXamContract::class, EXamManager::class);
        $this->app->bind(ExamResultContract::class, ExamResultManager::class);
        $this->app->bind(SkillTestContract::class,SkillTestManager::class);
        $this->app->bind(AssessmentContract::class, AssessmentManager::class);
        $this->app->bind(PageSetupContract::class, PageSetupManager::class);
        $this->app->bind(CircularContract::class, CircularManager::class);
        $this->app->bind(TrainerContract::class, TrainerManager::class);

    }
}