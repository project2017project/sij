<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $fillable = ['user_id','group_order_id','withdrawal_amount', 'method', 'acc_email', 'iban', 'country', 'acc_name', 'address', 'swift', 'reference', 'amount', 'sgst', 'cgst', 'igst', 'tcs', 'fee','comment', 'created_at', 'updated_at', 'status', 'settle', 'note', 'debit_note_id', 'credit_note_id','total_debit_amount', 'total_credit_amount', 'settle_amount', 'screen_shot'];

    public function user()
    {
        return $this->belongsTo('App\Models\User')->withDefault(function ($data) {
			foreach($data->getFillable() as $dt){
				$data[$dt] = __('Deleted');
			}
		});
    }
}
