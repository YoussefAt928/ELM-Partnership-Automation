<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .text-error {
            color: #dc3545;
        }

        .text-warning {
            color: #ffc107;
        }

        .text-info {
            color: #17a2b8;
        }

        .text-general {
            color: #6c757d;
        }

        .table-container {
            margin-top: 20px;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table th {
            background-color: #343a40;
            color: white;
        }

        .table td {
            vertical-align: middle;
        }

        .log-message {
            white-space: pre-wrap;
            /* يحافظ على الأسطر الجديدة */
            word-wrap: break-word;
            /* يضمن أن النص يتجزأ داخل الخلايا */
            max-width: 350px;
            /* تحديد أقصى عرض للرسالة */
            overflow: hidden;
            text-overflow: ellipsis;
            /* إخفاء النصوص الزائدة مع نقاط (...) */
            font-family: monospace;
            /* استخدام خط يتيح تنسيق أكثر وضوحًا */
        }
    </style>
</head>

<body>

    <div class="container table-container">
        <h3 class="text-center mb-4">سجل اللوجات في لارفيل</h3>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>التاريخ والوقت</th>
                        <th>الرسالة</th>
                        <th>نوع اللوج</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formattedLogs as $log)
                        <tr>
                            <td>{{ $log['date'] }}</td>
                            <td class="log-message">{!! nl2br(e($log['message'])) !!}</td> 
                            <td class="text-{{ $log['level'] }}">
                                {{ ucfirst($log['level']) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>