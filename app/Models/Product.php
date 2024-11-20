<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'sku',
        'kategori',
        'ukuran',
        'stok_minimum',
        'stok_maximum',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relationship with stock history
    public function stockHistories()
    {
        return $this->hasMany(StockHistory::class);
    }

    // Restocking method
    public function restock(int $quantity, $supplier, $notes)
    {
        // Add quantity to stock
        $this->increment('stok', $quantity);

        $source = "Restock";

        if ($quantity < 0) {
            $source = "Removal";
        }

        // Log the restock action
        $this->stockHistories()->create([
            'quantity' => $quantity,
            'source' => $source,
            'supplier' => $supplier,
            'notes' => $notes,
        ]);
    }

    // Method to deduct stock for orders
    public function deductStock(int $quantity)
    {
        // Deduct quantity from stock
        $this->decrement('stok', $quantity);

        // Log the order deduction
        $this->stockHistories()->create([
            'quantity' => -$quantity,
            'source' => 'Order',
        ]);
    }

    public function getStockStatus()
    {
        // Check if stock is greater than stock_maximum
        if ($this->stok > $this->stok_maximum) {
            return 'Overstock';
        }

        // Check if stock is less than stock_minimum and return a suggestion name
        if ($this->stok < $this->stok_minimum) {
            return 'Low Stock';
        }

        // Return 'normal stock' if stock is within the acceptable range
        return 'Normal Stock';
    }
}