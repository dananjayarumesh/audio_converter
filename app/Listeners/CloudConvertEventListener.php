<?php

namespace App\Listeners;

use CloudConvert\Models\WebhookEvent;
use CloudConvert\Models\Job;
use CloudConvert\Models\Task;
use Illuminate\Support\Facades\Log;
use App\ConvertLog;
use Mail;
use Auth;
use App\Mail\FileConverted;
class CloudConvertEventListener
{
    public function onJobFinished(WebhookEvent $event) {

        $job = $event->getJob();
        
        $job->getTag(); // can be used to store an ID
        
        //$exportTask = $job->getTasks()
            //->status(Task::STATUS_FINISHED) // get the task with 'finished' status ...
            //->name('my-export-task')[0];    // ... and with the name 'my-export-task'

        // $exportTask->getResult() ...

        $file = $job->getExportUrls();

        $convert_log = ConvertLog::whereTagNo($job->getTag())->update(['gateway_response'=>json_encode($file),'status'=>1]);

        Mail::to(Auth::user()->email)->send(new FileConverted($convert_log));

    }

    public function onJobFailed(WebhookEvent $event) {

        $job = $event->getJob();

        $job->getTag(); // can be used to store an ID
        
        $failingTask =  $job->getTasks()->status(Task::STATUS_ERROR)[0];

        ConvertLog::whereTagNo($job->getTag())->update(['status'=>2]);
        
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
