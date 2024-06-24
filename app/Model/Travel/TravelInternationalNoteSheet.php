<?php


namespace App\Model\Travel;


use Illuminate\Database\Eloquent\Model;

class TravelInternationalNoteSheet extends Model
{
    protected $table = 'MIS.TRAVEL_INTL_NOTE_SHEET';
    protected $fillable = [
        'document_no',
        'id',
        'group_no',     
        'from_loc',     
        'to_loc',       
        'from_loc_text',
        'to_loc_text',  
        'from_date',    
        'to_date',      
        'bd_from_time', 
        'bd_to_time',   
        'fg_from_time', 
        'fg_to_time',   
        'created_at',
        'create_user',
        'updated_at',
        'update_user'
    ];
}