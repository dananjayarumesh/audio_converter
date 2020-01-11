<?php
namespace App\Plugins;

use \CloudConvert\Laravel\Facades\CloudConvert;
use \CloudConvert\Models\Job;
use \CloudConvert\Models\Task;
use App\ConvertLog;
class CloudConvertRepository
{
	protected $export_format;
	function __construct()
	{
		$this->export_format = 'mp3';
	}

	public function jobCreate($tag_no,$file_path)
	{
		try {

			CloudConvert::jobs()->create(
				(new Job())
				->setTag($tag_no)
				->addTask(
					(new Task('import/url', 'import-my-file'))
					// ->set('url','https://file-examples.com/wp-content/uploads/2017/11/file_example_WAV_1MG.wav')
					->set('url',$file_path)
				)
				->addTask(
					(new Task('convert', 'convert-my-file'))
					->set('input', 'import-my-file')
					->set('output_format', $this->export_format)
				// ->set('some_other_option', 'value')
				)
				->addTask(
					(new Task('export/url', 'export-my-file'))
					->set('input', 'convert-my-file')
				)
			);

			return true;
			
		} catch (Exception $e) {
			// $e->getMessage();
			return false;
		}


		
	}

	public function download($url,$file_name)
	{
		$cloudconvert = new CloudConvert();

		$source = $cloudconvert->getHttpTransport()->download($request->url)->detach();
		$dest = fopen('output/' . $file_name, 'w');

		stream_copy_to_stream($source, $dest);
	}
}