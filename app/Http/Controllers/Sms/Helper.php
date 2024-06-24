<?php
/**
 * Created by PhpStorm.
 * User: raqib
 * Date: 7/4/2018
 * Time: 9:51 AM
 */

namespace App\Http\Controllers\Sms;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Helper
{

    /**
     * @param $file
     * @return string
     */
    public static function save_data_from_xl($file)
    {
        $status = '';
        Log::info($file);
        if ($file) {
            //fetching data from excel
            try {
                $data = \Excel::load($file, function ($reader) {
                })->get();
                
                $rdata = [];
                if(!isset($data[0]->grp_name)){
                   // Log::info('1');
                    $rdata = $data[0];
                }else{
                  //  Log::info('2');
                    $rdata = $data;
                }
 

                if (!empty($rdata) && $rdata->count()) {
                    $insertData = [];

                    $grp_name = '';
                    $max_grp_id = self::get_max_id();
                    foreach ($rdata as $key => $value) {

                        // Log::info($grp_name.'|'.$value->grp_name);
                        if($grp_name !== strtoupper($value->grp_name)){
                              if($key !== 0){
                                $max_grp_id++;
                            }
                        }

                        $check = DB::select('Select emp_code as cnt 
                                             from mis.sms_contact_info 
                                             where emp_code = ?
                                             and upper(GRP_NAME) = ?', [(int)$value->emp_code,strtoupper($value->grp_name)]);
                        if (count($check) > 0) {
                            //Log::info('updating' . $value->emp_code);
                            DB::update('update mis.sms_contact_info
                                        set  contact_no = ?,
                                            emp_name = ?,
                                            update_date = ?,
                                            update_user = ?
                                         where emp_code = ?',
                                [
                                    '880' . (int)$value->contact_no,
                                    strtoupper($value->emp_name),
                                    Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                                    Auth::user()->user_id,
                                    $value->emp_code
                                ]);
                        } else {
                            $insertData[] = [
                                'grp_id' => $max_grp_id,
                                'grp_name' => strtoupper($value->grp_name),
                                'contact_no' => '880' . (int)$value->contact_no,
                                'emp_code' => (int)$value->emp_code,
                                'emp_name' => strtoupper($value->emp_name),
                                'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'), 
                                'create_user' => Auth::user()->user_id
                            ];
                        }

                        $grp_name = strtoupper($value->grp_name);

                    }
                    if (!empty($insertData)) {
                        DB::table('mis.sms_contact_info')
                            ->insert($insertData);
                    }

                    $status = 'OK';
                }
            } catch (\Exception $ex) {
                $status = $ex->getMessage();
            }

        }
        return $status;
    }

    /**
     * @return mixed
     */
    public static function get_groups_list(){
        return DB::select("Select distinct grp_id,grp_name,count(*) t_count,
                                   case when ? = create_user then 'Y' else 'N' end create_user 
                            from mis.sms_contact_info
                            group by grp_id,grp_name,create_user
                            order by grp_id",[Auth::user()->user_id]);
    }

    /**
     * @param $contact
     * @return string
     */
    public static function create_contact_with_group($contact){
        $status = '';
        if($contact){

            $exist = DB::select('select grp_name 
                                 from mis.sms_contact_info 
                                 where grp_name = ?',[strtoupper($contact['ngname'])]);

            if(count($exist) > 0){
               $status = 'Group Name Already exist';
            }else{
               $max_id = self::get_max_id();

               $emp_exist = DB::select('select * 
                                    from mis.sms_contact_info 
                                    where emp_code = ?
                                    ',[$contact['emp_id']]);

               if(count($emp_exist) > 0){
                   $status = 'Employee Already exist';
               }
               else{
                   DB::table('mis.sms_contact_info')->insert(
                       [
                           'grp_id' => $max_id,
                           'grp_name' => strtoupper($contact['ngname']),
                           'contact_no' => '88' . $contact['c_no'],
                           'emp_code' => $contact['emp_id'],
                           'emp_name' => strtoupper($contact['emp_name']),
                           'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                           'create_user' => Auth::user()->user_id
                       ]
                   );

                   $grp_list = DB::select('select distinct grp_id,grp_name 
                                from mis.sms_contact_info');

                   $status = $grp_list;
               }

            }
        }
        return $status;
    }

    /**
     * @param $contact
     * @return string
     */
    public static function create_contact($contact){
        $status = '';
        if($contact){

            $emp_exist = DB::select('select * 
                                    from mis.sms_contact_info 
                                    where emp_code = ?
                                    and grp_id = ?
                                    ',[$contact['emp_id'],$contact['grp']]);

            if(count($emp_exist) > 0){
                $status = 'Employee Already exist';
            }
            else{

                $existing_grp_name = DB::select('select grp_name 
                                               from mis.sms_contact_info 
                                               where grp_id = ?',[$contact['grp']]);

                if(count($existing_grp_name)>0){
                    DB::table('mis.sms_contact_info')->insert(
                        [
                            'grp_id' => $contact['grp'],
                            'grp_name' => strtoupper($existing_grp_name[0]->grp_name),
                            'contact_no' => '88' . $contact['c_no'],
                            'emp_code' => $contact['emp_id'],
                            'emp_name' => strtoupper($contact['emp_name']),
                            'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                            'create_user' => Auth::user()->user_id
                        ]
                    );
                    $status = 'Contact created successfully!';
                }

            }
        }
        return $status;
    }

    /**
     * @return mixed
     */
    protected static function get_max_id(){
        $maxid = DB::select('select nvl(max(grp_id)+1,1) mid 
                             from mis.sms_contact_info');
        return $maxid[0]->mid;
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function get_contacts($params){
        return DB::select('select grp_id,grp_name,emp_code,emp_name,contact_no,create_user,0 h,0 d 
                           from mis.sms_contact_info
                           where grp_id = ?
                           order by emp_code,emp_name',[$params['grp_id']]);
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function update_contact($params){
        //Log::info($params);
       $rows_updated = DB::update('Update mis.sms_contact_info
                                   set emp_name = ?,
                                       contact_no = ?,
                                       update_date = ?,
                                       update_user = ?
                                   where grp_id = ? 
                                   and emp_code = ?',
                                  [strtoupper($params['emp_name']),
                                      $params['contact_no'],
                                      Carbon::now()->format('Y-m-d H:i:s'),
                                      Auth::user()->user_id,
                                      $params['grp_id'],
                                      $params['emp_code']
                                  ]);
       return $rows_updated;
    }

    public static function delete_contact($params){

        $backup_data = DB::select('Select * 
                                   from mis.SMS_CONTACT_INFO 
                                   where grp_id = ? and emp_code = ?',[$params['grp_id'],$params['emp_code']]);

        foreach ($backup_data as $d){
            $insert[] = [
                'grp_id' => $d->grp_id,
                'grp_name' => $d->grp_name,
                'contact_no' => $d->contact_no,
                'emp_code' => $d->emp_code,
                'emp_name' => $d->emp_name,
                'delete_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                'delete_user' => Auth::user()->user_id
            ];
        }

        if(!empty($insert)){
            DB::table('mis.sms_contacts_deleted')->insert($insert);
        }

       $rows_deleted = DB::delete('Delete from mis.sms_contact_info
                                  where grp_id = ? and emp_code = ?',
                                  [$params['grp_id'],$params['emp_code']]);
       return $rows_deleted;
    }

    public static function delete_group($params){
        Log::info($params);

        $backup_data = DB::select('Select * 
                                   from mis.SMS_CONTACT_INFO 
                                   where GRP_ID = ?',[$params['grp_id']]);

        foreach ($backup_data as $d){
            $insert[] = [
                'grp_id' => $d->grp_id,
                'grp_name' => $d->grp_name,
                'contact_no' => $d->contact_no,
                'emp_code' => $d->emp_code,
                'emp_name' => $d->emp_name,
                'delete_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                'delete_user' => Auth::user()->user_id
            ];
        }

        if(!empty($insert)){
            DB::table('mis.sms_contacts_deleted')->insert($insert);
        }

        $rows_deleted = DB::delete('Delete from mis.sms_contact_info
                                    where grp_id = ?',[$params['grp_id']]);
        return $rows_deleted;
    }

    public static function prepare_contacts($params){
       Log::info($params);
       $contacts = [];
       $contactsCarrier = [];
       foreach ($params as $param){
           $data = DB::select('select contact_no 
                               from mis.SMS_CONTACT_INFO 
                               where GRP_ID = ?',[$param['grp_id']]);
           if(count($data)> 0){
               foreach ($data as $d){
                   $contacts[] = $d->contact_no;
               }
           }
       }
       $contactsCarrier = array_chunk($contacts,160);
       return $contactsCarrier;
    }

     /**
     * @return mixed
     */
    public static function sms_text(){
        $data = DB::select('select max(WORKING_DATE),SMS_TEXT
                                   from MIS.DAILY_REPORT_SMS
                                   group by SMS_TEXT
                                   order by max(WORKING_DATE) desc');
        return $data[0]->sms_text;
    }
}