<?php
namespace App\Plugins;

use \CloudConvert\Laravel\Facades\CloudConvert;
use \CloudConvert\Models\Job;
use \CloudConvert\Models\Task;
use App\ConvertLog;
class CloudConvertRepository
{
	
	function __construct()
	{
		
	}

	public function jobCreate()
	{
		 ConvertLog::create(
		 	['user_id'=>Auth::user()->id,'file_name'=>'test','gateway_response'=>json_encode($exportTask->getResult())]);

		$c = CloudConvert::jobs()->create(
			(new Job())
			->setTag('myjob-123')
			->addTask(
				(new Task('import/url', 'import-my-file'))
				->set('url','https://file-examples.com/wp-content/uploads/2017/11/file_example_WAV_1MG.wav')
			)
			->addTask(
				(new Task('convert', 'convert-my-file'))
				->set('input', 'import-my-file')
				->set('output_format', 'mp3')
				// ->set('some_other_option', 'value')
			)
			->addTask(
				(new Task('export/url', 'export-my-file'))
				->set('input', 'convert-my-file')
			)
		);

		dd($c);
	}
}