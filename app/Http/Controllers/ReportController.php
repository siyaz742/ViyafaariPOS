<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesReportExport;
use App\Exports\SalesByProductReportExport;


class ReportController extends Controller
{
    public function index()
    {
        if ($this->isAuthorized('R1')) {
            return view('reports.index');
        }

        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }

    public function sales(Request $request)
    {
        if (!$this->isAuthorized('R1')) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }

        // Initialize query with optional filters
        $query = \App\Models\Order::query();

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('invoice_date', [$request->start_date, $request->end_date]);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Fetch filtered sales data
        $salesData = $query->with(['customer', 'employee'])->get();

        return view('reports.sales', compact('salesData'));
    }
    public function exportSales(Request $request)
    {
        return Excel::download(new SalesReportExport(
            $request->start_date,
            $request->end_date,
            $request->payment_method,
            $request->customer_id,
            $request->employee_id
        ), 'sales_report.xlsx');
    }

    public function salesByProduct(Request $request)
    {
        if (!$this->isAuthorized('R1')) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }

        // Initialize query with optional filters for product, date, and discount
        $query = \App\Models\OrderItem::query()
            ->with(['product', 'order']) // Load related product and order data
            ->select('id', 'order_id', 'product_id', 'quantity', 'item_total','item_sale_price', 'discount');

        // Filter by product if selected
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Filter by date range, based on the parent order's invoice_date
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereHas('order', function ($orderQuery) use ($request) {
                $orderQuery->whereBetween('invoice_date', [$request->start_date, $request->end_date]);
            });
        }

        // Filter by discount threshold
        if ($request->filled('discount_threshold') && $request->filled('discount_type')) {
            $operator = $request->discount_type === 'above' ? '>' : '<';
            $query->where('discount', $operator, $request->discount_threshold);
        }

        $salesDataByProduct = $query->get();

        return view('reports.sales_by_product', compact('salesDataByProduct'));
    }
    public function exportSalesByProduct(Request $request)
    {
        return Excel::download(new SalesByProductReportExport(
            $request->start_date,
            $request->end_date,
            $request->product_id,
            $request->discount_threshold,
            $request->discount_type
        ), 'sales_by_product_report.xlsx');
    }


}

