<?php


namespace App\Model\Travel;


use Illuminate\Database\Eloquent\Model;

class TravelInternationalReq extends Model
{
    protected $table = 'MIS.TRAVEL_INTL_REQ';
    protected $fillable = [
        'document_no',
        'id',
        'emp_id',
        'emp_name',
        'grade',
        'desig_name',
        'dept_name',
        'purpose',
        'passport_no',
        'date_of_issue',
        'date_of_expiry',
        'travel_type',
        'cost_center_id',
        'cost_center_name',
        'gl_code',
        'from_loc',
        'to_loc',
        'from_time',
        'to_time',
        'days',
        'hotel_company',
        'hotel_vendor',
        'hotel_others',
        'meal_company',
        'meal_vendor',
        'meal_others',
        'transport_company',
        'transport_vendor',
        'transport_others',
        'mrp_no',
        'mrp_date',
        'sap_pr_no',
        'sap_pr_date',
        'lc_no',
        'lc_date',
        'po_no',
        'po_date',
        'cwip_asset_no',
        'cwip_asset_name',
        'created_at',
        'create_user',
        'updated_at',
        'update_user'
    ];
}