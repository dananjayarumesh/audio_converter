<?php

namespace App\Listeners;

use CloudConvert\Models\WebhookEvent;
use CloudConvert\Models\Job;
use CloudConvert\Models\Task;
use Illuminate\Support\Facades\Log;
use App\ConvertLog;

class CloudConvertEventListener
{
    public function onJobFinished(WebhookEvent $event) {

        $job = $event->getJob();
        
        $job->getTag(); // can be used to store an ID
        
        $exportTask = $job->getTasks()
            ->status(Task::STATUS_FINISHED) // get the task with 'finished' status ...
            ->name('my-export-task')[0];    // ... and with the name 'my-export-task'

        // $exportTask->getResult() ...

            ConvertLog::create(['user_id'=>1,'file_name'=>'test','gateway_response'=>json_encode($exportTask->getResult())]);

        }

        public function onJobFailed(WebhookEvent $event) {

            $job = $event->getJob();

        $job->getTag(); // can be used to store an ID
        
        $failingTask =  $job->getTasks()->status(Task::STATUS_ERROR)[0];

        ConvertLog::create(['user_id'=>1,'file_name'=>'test','gateway_response'=> json_encode($failingTask)]);
        
        Log::error('CloudConvert task failed: ' . $failingTask->getId());
        
    }

    public function subscribe($events)
    {
        $events->listen(
            'cloudconvert-webhooks::job.finished',
            'App\Listeners\CloudConvertEventListener@onJobFinished'
        );

        $events->listen(
            'cloudconvert-webhooks::job.failed',
            'App\Listeners\CloudConvertEventListener@onJobFailed'
        );
    }
}
