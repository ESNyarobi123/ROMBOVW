use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Kila dakika moja (1), mfumo unaangalia kama kuna voucher imeisha na kuikata internet MikroTik
Schedule::command('vouchers:cleanup')->everyMinute();
