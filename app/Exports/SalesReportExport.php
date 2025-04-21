<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesReportExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;
    protected $paymentMethod;
    protected $customerId;
    protected $employeeId;

    public function __construct($startDate, $endDate, $paymentMethod, $customerId, $employeeId)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->paymentMethod = $paymentMethod;
        $this->customerId = $customerId;
        $this->employeeId = $employeeId;
    }

    public function collection()
    {
        $query = Order::query();

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('invoice_date', [$this->startDate, $this->endDate]);
        }

        if ($this->paymentMethod) {
            $query->where('payment_method', $this->paymentMethod);
        }

        if ($this->customerId) {
            $query->where('customer_id', $this->customerId);
        }

        if ($this->employeeId) {
            $query->where('employee_id', $this->employeeId);
        }

        $salesData = $query->with(['customer', 'employee'])->get();

        // Prepare data for export
        return $salesData->map(function ($sale) {
            return [
                'Order ID' => $sale->id,
                'Date' => $sale->invoice_date,
                'Customer' => $sale->customer->name ?? 'N/A',
                'Employee' => $sale->employee->name ?? 'N/A',
                'Total' => $sale->total,
                'Payment Method' => ucfirst($sale->payment_method),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Date',
            'Customer',
            'Employee',
            'Total',
            'Payment Method',
        ];
    }
}

