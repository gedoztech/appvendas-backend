<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['seller_id', 'price'];

    /**
     * Get the seller for the sale.
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Get commission for the sale (8.5%)
     */
    public function getComission($total) {
        return $total * 0.085;
    }
}