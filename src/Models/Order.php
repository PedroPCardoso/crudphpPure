<?php

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['user_id', 'description', 'quantity', 'price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
