<?php

namespace App\Exports;

use App\Models\OrderItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesByProductReportExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;
    protected $productId;
    protected $discountThreshold;
    protected $discountType;

    public function __construct($startDate, $endDate, $productId, $discountThreshold, $discountType)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->productId = $productId;
        $this->discountThreshold = $discountThreshold;
        $this->discountType = $discountType;
    }

    public function collection()
    {
        $query = OrderItem::query()->with(['product', 'order'])
            ->select('id', 'order_id', 'product_id', 'quantity', 'item_total', 'item_sale_price', 'discount');

        // Apply filters
        if ($this->productId) {
            $query->where('product_id', $this->productId);
        }

        if ($this->startDate && $this->endDate) {
            $query->whereHas('order', function ($orderQuery) {
                $orderQuery->whereBetween('invoice_date', [$this->startDate, $this->endDate]);
            });
        }

        if ($this->discountThreshold && $this->discountType) {
            $operator = $this->discountType === 'above' ? '>' : '<';
            $query->where('discount', $operator, $this->discountThreshold);
        }

        $salesDataByProduct = $query->get();

        return $salesDataByProduct->map(function ($item) {
            return [
                'Order ID' => $item->order->id,
                'Product' => $item->product->name ?? 'N/A',
                'Quantity' => $item->quantity,
                'Sale Price' => $item->item_sale_price,
                'Total' => $item->item_total,
                'Discount' => $item->discount,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Product',
            'Quantity',
            'Sale Price',
            'Total',
            'Discount',
        ];
    }
}
