<?php


namespace App\Model\Travel;


use Illuminate\Database\Eloquent\Model;

class TravelInternationalNoteSheetApproved extends Model
{
    protected $table = 'MIS.TRAVEL_INTL_NOTE_SHEET_APPR';
    protected $fillable = [
        'id',
        'document_no',
        'group_no',
        'checked_id',
        'checked_accept',
        'checked_date',
        'recommended_id',
        'recommended_accept',
        'recommended_date',
        'chairman_madam_id',
        'chairman_madam_accept',
        'chairman_madam_date',
        'created_at',
        'create_user',
        'updated_at',
        'update_user'
    ];
}