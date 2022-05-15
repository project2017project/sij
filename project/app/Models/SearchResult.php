<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchResult extends Model
{
	protected $table = 'search_result';
	protected $fillable = ['search_name'];
	public $timestamps = false;
    public function search()
    {
        return $this->belongsTo('App\Models\SearchResult')->withDefault(function ($data) {
			foreach($data->getFillable() as $dt){
				$data[$dt] = __('Deleted');
			}
		});
    }
}
