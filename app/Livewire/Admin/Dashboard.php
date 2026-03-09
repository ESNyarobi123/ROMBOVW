<?php

namespace App\Livewire\Admin;

use App\Models\Payment;
use App\Models\Voucher;
use App\Services\MikrotikService;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public function render(\App\Services\MikrotikService $mikrotik)
    {
        // Fetch Real Database Stats
        $revenueToday = Payment::where('status', 'completed')
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');

        $totalVouchers = Voucher::count();
        $expiredToday = Voucher::where('status', 'expired')
            ->whereDate('updated_at', Carbon::today())
            ->count();

        // Check MikroTik real users (fallback to 0 if router disconnected)
        $activeUsers = [];
        try {
            $activeUsers = $mikrotik->getConnectedUsers();
        } catch (\Exception $e) {
            // Log or ignore
        }

        // Calculate 7-day revenue chart
        $chartData = [];
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dailySum = Payment::where('status', 'completed')
                ->whereDate('created_at', $date)
                ->sum('amount');
            
            $chartData[] = $dailySum;
            // Short day name in Swahili approximation mapping
            $swahiliDays = ['J2', 'J3', 'J4', 'J5', 'AL', 'IJ', 'JM'];
            $chartLabels[] = $swahiliDays[$date->dayOfWeek]; // 0 is Sunday
        }

        // Normalize chart data for CSS heights
        $maxDaily = max($chartData) > 0 ? max($chartData) : 1;
        $chartHeights = array_map(function($val) use ($maxDaily) {
            return ($val / $maxDaily) * 100; // Percentage
        }, $chartData);

        return view('livewire.admin.dashboard', [
            'stats' => [
                'revenue_today' => $revenueToday,
                'active_users' => is_array($activeUsers) ? count($activeUsers) : 0,
                'total_vouchers' => $totalVouchers,
                'expired_today' => $expiredToday,
            ],
            'chartHeights' => $chartHeights,
            'chartData' => $chartData,
            'chartLabels' => $chartLabels,
            'recentUsers' => is_array($activeUsers) ? array_slice($activeUsers, 0, 5) : []
        ])->layout('layouts.app', ['header' => 'Overview Dashboard']);
    }
}
