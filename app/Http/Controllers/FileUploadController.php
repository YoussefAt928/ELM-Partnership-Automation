<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCSVFile;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function showForm()
    {
        return view('upload');
    }

    public function handleUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:40480', 
        ]);
    
        $originalName = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
        $uniqueName = $originalName . '_' . now()->timestamp . '.' . $request->file('file')->getClientOriginalExtension();
    
        $path = $request->file('file')->storeAs('CSV', $uniqueName);
    
        ProcessCSVFile::dispatch($path);
    
        return back()->with('success', 'تم رفع الملف وسوف يتم معالجته.');
    }
    
}
