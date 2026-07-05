<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Donation extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'order_id',
        'donor_name',
        'donor_email',
        'donor_phone',
        'amount',
        'status',
        'snap_token',
        'campaign_id',
        'payment_type',
    ];
 
    public function campaign()
    {
        return $this->belongsTo(Content::class, 'campaign_id');
    }
}
