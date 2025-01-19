<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class LogController extends Controller
{
    public function showLogs()
{
    $logPath = storage_path('logs/laravel.log');

    // قراءة محتويات اللوج
    if (File::exists($logPath)) {
        $logs = file($logPath); // قراءة كل سطر في الملف كـ array
    } else {
        $logs = [];
    }

    // تنظيم وتحسين محتويات الـ logs
    $formattedLogs = [];

    foreach ($logs as $log) {
        // تقسيم السطر إلى التاريخ والنص
        preg_match('/\[(.*?)\]\s(.*)/', $log, $matches);
        
        if (isset($matches[1]) && isset($matches[2])) {
            $formattedLogs[] = [
                'date' => $matches[1], // التاريخ
                'message' => $matches[2], // الرسالة
                'level' => $this->getLogLevel($matches[2]), // تحديد نوع اللوج (معلومات، خطأ، تحذير)
            ];
        }
    }

    // إرجاع الـ logs إلى الـ view مع التنسيق
    return view('logs.index', compact('formattedLogs'));
}

// وظيفة لتحديد نوع اللوج
private function getLogLevel($message)
{
    if (stripos($message, 'error') !== false) {
        return 'error';
    } elseif (stripos($message, 'warning') !== false) {
        return 'warning';
    } elseif (stripos($message, 'info') !== false) {
        return 'info';
    }
    return 'general'; // الافتراضي
}
}
