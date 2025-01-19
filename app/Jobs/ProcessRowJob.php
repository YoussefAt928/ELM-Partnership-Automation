<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProcessRowJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rowData;

    /**
     * Create a new job instance.
     */
    public function __construct(array $rowData)
    {
        $this->rowData = $rowData;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $endpoint = "https://services.servicesmart.co/rest/3/34zn7ucf6g4fr8ha/crm.item.add.json";

        $payload = [
            "entityTypeId" => 1128,
            "fields" => [
                "TITLE" => $this->rowData['اسم المنفذ ضده'] ?? null,
                "ufCrm32_1736770034545" => $this->rowData['نوع السند'] ?? null,
                "ufCrm32_1736688416" => $this->rowData['رقم السجل'] ?? null,
                "ufCrm32_1736688431" => $this->rowData['رقم العقد'] ?? null,
                "ufCrm32_1736847914229" => $this->rowData['رقم السند'] ?? null,
                "ufCrm32_1736688493" => $this->rowData['هوية المنفذ ضده'] ?? null,
                "ufCrm32_1736773763803" => $this->rowData['الجنسية'] ?? null,
                "ufCrm32_1736773643529" => isset($this->rowData['المبلغ المدفوع']) ? (float) str_replace(",", "", $this->rowData['المبلغ المدفوع']) : null,
                "ufCrm32_1736688680" => $this->rowData['الوكيل'] ?? null,
                "ufCrm32_1736688720" => $this->rowData['رقم التواصل'] ?? null,
                "ufCrm32_1736688738" => $this->rowData['هوية الوكيل'] ?? null,
                "ufCrm32_1736688749" => $this->rowData['رقم الوكالة'] ?? null,
                "ufCrm32_1736688762" => $this->rowData['الايميل'] ?? null,
                "ufCrm32_1736688774" => $this->rowData['الايبان'] ?? null,
                "ufCrm32_1736770067677" => $this->rowData['نوع المنفذ ضده'] ?? null,
                "ufCrm32_1736770094074" => $this->rowData['صفة المنفذ ضده'] ?? null,
                "ufCrm32_1736770119840" => $this->rowData['مكان الوفاء'] ?? null,
                "ufCrm32_1736770134381" => $this->rowData['المبلغ المطلوب تنفيذه'] ?? null,
                "ufCrm32_1736770152250" => $this->rowData['الصفة'] ?? null,
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(120)->post($endpoint, $payload);

            if ($response->successful()) {
                // تسجيل النجاح
                logger()->info('Successfully processed row', [
                    'data' => $this->rowData,
                    'response' => $response->json(),
                ]);
            } else {
                throw new \Exception('Failed to send data to endpoint.');
            }
        } catch (\Exception $e) {
            // تسجيل الخطأ
            logger()->error('Error processing row', [
                'error' => $e->getMessage(),
                'data' => $this->rowData,
            ]);
        }
    }
}
