<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<p>Hi {{$convert_log->user->name}}, <br><br>Your audio file ({{$convert_log->file_name}}.mp3) has been converted successfully ({{$convert_log->tag_no}}). <br><a href="{{url('/download/'.$convert_log->tag_no)}}">Click this link to download</a> </p>
	<br>
	<br>
</body>
</html>