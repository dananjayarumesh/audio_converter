<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plugins\CloudConvertRepository;
use App\Http\Requests\ConvertRequest;
use App\ConvertLog;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('auth', ['only' => ['submitConvert']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function submitConvert(ConvertRequest $request)
    {

        $path = $request->file->store('public/uploads/raw_audio_files');
        $file_path = str_replace("public", "storage", $path);

        $clog = ConvertLog::create([
            'file_name'=>$request->file_name,
            'user_id'=>Auth::user()->id,
            'raw_file_path'=> $file_path
        ]);

        $clog->generateTagNo();

        $cc = new CloudConvertRepository();

        if($cc->jobCreate($clog->tag_no , asset($file_path))){
            return response()->json(['status' => 'success', 'tag_no' => $clog->tag_no], 200);
        }else{
            return response()->json(['status' => 'error', 'message' => 'Something went wrong!'], 500);
        }
    }

    public function getConvertLogStatus($tag)
    {
        $clog = ConvertLog::whereTagNo($tag)->first();
        if($clog){
            return response()->json(['status' => 'success', 'convert_status' => $clog->status], 200);
        }else{
            return response()->json(['status' => 'error', 'message' => 'Invalid tag no'], 422);
        }
        
    }

    public function downloadConverted($tag)
    {
        $cc = new CloudConvertRepository();
        $clog = ConvertLog::whereTagNo($tag)->first();

        if($clog->status == 1){
            $url = json_decode($clog->gateway_response)[0]->url;

            $filename = $clog->file_name.'.mp3';
            $tempFile = tempnam(sys_get_temp_dir(), $filename);
            copy($url, $tempFile);

            return response()->download($tempFile, $filename);
        }else{
            return response()->json(['status' => 'error', 'message' => 'No link found'], 500);
        }
        
    }

    public function getConvertHistory()
    {
        $clogs = ConvertLog::whereUserId(Auth::user()->id)->orderBy('id','desc')->get();
        return response()->json(['status' => 'success', 'data' => $clogs], 200);
    }
}
