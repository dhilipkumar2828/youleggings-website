<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminController extends Controller
{
    use AuthenticatesUsers {
        logout as performLogout;
    }

    protected $userid;
    protected $username;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userid = Auth::id();
            $this->username = Auth::user()->name;
            return $next($request);
        });
    }

    /**
     * Display admin dashboard.
     */
    public function admin()
    {
        $user = Auth::user();

        if ($user && $user->status === 'active') {
            $orders = Order::orderBy('id', 'DESC')->limit(5)->get();

            // Monthly sales data for chart (Last 6 months with padding)
            $sales_data = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = date('Y-m', strtotime("-$i months"));
                $sales_data[$month] = 0;
            }

            $monthly_sales_query = Order::where('status', 'Delivered')
                ->select(
                    DB::raw('sum(total) as total'),
                    DB::raw("DATE_FORMAT(created_at,'%Y-%m') as month")
                )
                ->where('created_at', '>=', date('Y-m-d', strtotime('-6 months')))
                ->groupBy('month')
                ->get();

            foreach ($monthly_sales_query as $sale) {
                $sales_data[$sale->month] = (float)$sale->total;
            }

            $monthly_sales = [];
            foreach ($sales_data as $month => $total) {
                $monthly_sales[] = ['month' => $month, 'total' => $total];
            }

            // Order status distribution
            $status_counts = Order::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->map(function($item) {
                    return ['label' => $item->status, 'value' => $item->count];
                });

            return view('backend.index', compact('orders', 'user', 'monthly_sales', 'status_counts'));
        }

        Auth::logout();
        return redirect()->route('login')->with('error', 'Your account is inactive.');
    }
}
