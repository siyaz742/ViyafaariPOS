<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function getSalesData(Request $request)
    {
        $filter = $request->get('filter', 'day');
        $salesData = [];
        $labels = [];
        $data = [];

        switch ($filter) {
            case 'day':
                $labels = range(0, 23);
                $sales = Order::selectRaw('HOUR(invoice_time) as hour, COUNT(*) as sales')
                    ->whereDate('invoice_date', today())
                    ->groupBy('hour')
                    ->pluck('sales', 'hour');

                foreach ($labels as $hour) {
                    $data[] = [
                        'label' => sprintf('%02d:00', $hour),
                        'sales' => $sales[$hour] ?? 0
                    ];
                }
                break;

            case 'month':
                $labels = [];
                $sales = Order::selectRaw('DAY(invoice_date) as day, COUNT(*) as sales')
                    ->whereMonth('invoice_date', now()->month)
                    ->groupBy('day')
                    ->pluck('sales', 'day');


                $monthName = now()->format('F');

                foreach (range(1, now()->daysInMonth) as $day) {

                    $labels[] = sprintf('%s %d', substr($monthName, 0, 3), $day);

                    $data[] = [
                        'label' => sprintf('%s %d', substr($monthName, 0, 3), $day),
                        'sales' => $sales[$day] ?? 0
                    ];
                }
                break;


            case 'year':
                $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                $sales = Order::selectRaw('MONTH(invoice_date) as month, COUNT(*) as sales')
                    ->whereYear('invoice_date', now()->year)
                    ->groupBy('month')
                    ->pluck('sales', 'month');

                foreach (range(1, 12) as $monthIndex) {
                    $data[] = [
                        'label' => $labels[$monthIndex - 1],
                        'sales' => $sales[$monthIndex] ?? 0
                    ];
                }
                break;
        }

        return response()->json($data);
    }

    public function getRevenueData(Request $request)
    {
        $filter = $request->get('filter', 'day');
        $data = [];

        switch ($filter) {
            case 'day':
                $labels = range(0, 23);
                $revenues = Order::selectRaw('HOUR(invoice_time) as hour, SUM(total) as revenue')
                    ->whereDate('invoice_date', today())
                    ->groupBy('hour')
                    ->pluck('revenue', 'hour');

                foreach ($labels as $hour) {
                    $data[] = [
                        'label' => sprintf('%02d:00', $hour),
                        'revenue' => $revenues[$hour] ?? 0
                    ];
                }
                break;

            case 'month':
                $labels = [];
                $revenues = Order::selectRaw('DAY(invoice_date) as day, SUM(total) as revenue')
                    ->whereMonth('invoice_date', now()->month)
                    ->groupBy('day')
                    ->pluck('revenue', 'day');


                $monthName = now()->format('F');

                foreach (range(1, now()->daysInMonth) as $day) {

                    $labels[] = sprintf('%s %d', substr($monthName, 0, 3), $day);

                    $data[] = [
                        'label' => sprintf('%s %d', substr($monthName, 0, 3), $day),
                        'revenue' => $revenues[$day] ?? 0
                    ];
                }
                break;


            case 'year':
                $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                $revenues = Order::selectRaw('MONTH(invoice_date) as month, SUM(total) as revenue')
                    ->whereYear('invoice_date', now()->year)
                    ->groupBy('month')
                    ->pluck('revenue', 'month');

                foreach (range(1, 12) as $monthIndex) {
                    $data[] = [
                        'label' => $labels[$monthIndex - 1],
                        'revenue' => $revenues[$monthIndex] ?? 0
                    ];
                }
                break;
        }

        return response()->json($data);
    }



}
