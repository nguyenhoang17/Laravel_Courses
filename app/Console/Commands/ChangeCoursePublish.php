<?php

namespace App\Console\Commands;

use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ChangeCoursePublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'handle:change-course-publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $now = Carbon::now();
            $courses = Course::where('type', Course::TYPE_LIVE)->where('status',Course::STATUS_PUBLISHED)->get();
            foreach ($courses as $course) {
                $time = Carbon::createFromTimestamp($course->start_time);
                if ($now->diffInDays($time) <= env('DAY_UN_PUBLISH_COURSE')) {
                    $course->status = Course::STATUS_UNPUBLISHED;
                    $course->save();
                }
            }
        } catch (\Exception $e) {
            Log::error('Error change status course publish', [
                'method' => __METHOD__,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
