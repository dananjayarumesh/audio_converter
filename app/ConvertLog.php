<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConvertLog extends Model
{
	protected $fillable = [
		'user_id', 'tag_no', 'raw_file_path','file_name','gateway_response','status'
	];

	public function generateTagNo()
	{
		$this->update(['tag_no' => ("REF" . sprintf("%06d", (1000 + $this->id)))]);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
