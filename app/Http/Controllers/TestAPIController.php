<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Exceptions\Exception;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class TestAPIController extends Controller
{

    /*************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function index(Request $request){

//        Log::info($request->all());

       $rs = DB::select("
            select count(*) cnt
            from mis.dashboard_users_info
            where user_id = '$request->email'
            and raw_password = '$request->password'
       ");

//       Log::info($rs[0]->cnt);

       if($rs[0]->cnt > 0){
           return ["token" => 'iamApiuser_909'];
       }else {
           return ["token" => null];
       }


    }


    /*************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function getCanteenUser(){

        DB::setDateFormat('DD-MON-RR');
        $rs = DB::select("
            select emp_id,sur_name,desig_name,meal_type,meal_status,token_status
            from hrms.meal_information@web_to_hrms           
            --where to_date(create_date,'dd-mon-rr') = (select to_date(sysdate,'dd-mon-rr') from dual)
       ");

        return response()->json($rs);

    }

    /*************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function onCanteenSnacksUpdate(Request  $request){
//        DB::setDateFormat('YYYY-MM-DD HH24:MI:SS');

//        Log::info($request->all());
        $emp_id = $request['emp_id'];
        $snacks = $request['snacks'];

//        Log::info($emp_id);
//        Log::info($snacks);
        if($snacks == 'true'){
            try {
                $rs = DB::update("
                    update hrms.meal_information@web_to_hrms
                    set meal_status = 'YES'
                    where emp_id = '$emp_id'
                    and meal_type = 'SNACKS'
                ");
            }catch (Oci8Exception $exception){

            }
        }else{
            try {
                $rs = DB::update("
                    update hrms.meal_information@web_to_hrms
                    set meal_status = 'NO'
                    where emp_id = '$emp_id'
                    and meal_type = 'SNACKS'
                ");
            }catch (Oci8Exception $exception){

            }
        }

    }



    /*************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function onCanteenSnacksTokensUpdate(Request  $request){
        $emp_id = $request['emp_id'];
        $snacksToken = $request['snacksToken'];

        if($snacksToken == 'true'){
            try {
                $rs = DB::update("
                    update hrms.meal_information@web_to_hrms
                    set token_status = 'YES'
                    where emp_id = '$emp_id'
                    and meal_type = 'SNACKS'
                ");
            }catch (Oci8Exception $exception){

            }
        }else{
            try {
                $rs = DB::update("
                    update hrms.meal_information@web_to_hrms
                    set token_status = 'NO'
                    where emp_id = '$emp_id'
                    and meal_type = 'SNACKS'
                ");
            }catch (Oci8Exception $exception){

            }
        }
    }


    /*************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function onCanteenLunchUpdate(Request  $request){
        $emp_id = $request['emp_id'];
        $lunch = $request['lunch'];
        if($lunch == 'true'){
            try {
                $rs = DB::update("
                    update hrms.meal_information@web_to_hrms
                    set meal_status = 'YES'
                    where emp_id = '$emp_id'
                    and meal_type = 'LUNCH'
                ");
            }catch (Oci8Exception $exception){

            }
        }else{
            try {
                $rs = DB::update("
                    update hrms.meal_information@web_to_hrms
                    set meal_status = 'NO'
                    where emp_id = '$emp_id'
                    and meal_type = 'LUNCH'
                ");
            }catch (Oci8Exception $exception){

            }
        }
    }


    /*************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function onCanteenLunchTokensUpdate(Request  $request){
        $emp_id = $request['emp_id'];
        $lunchToken = $request['lunchToken'];
        if($lunchToken == 'true'){
            try {
                $rs = DB::update("
                    update hrms.meal_information@web_to_hrms
                    set token_status = 'YES'
                    where emp_id = '$emp_id'
                    and meal_type = 'LUNCH'
                ");
            }catch (Oci8Exception $exception){

            }
        }else{
            try {
                $rs = DB::update("
                    update hrms.meal_information@web_to_hrms
                    set token_status = 'NO'
                    where emp_id = '$emp_id'
                    and meal_type = 'LUNCH'
                ");
            }catch (Oci8Exception $exception){

            }
        }
    }

    /*************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function onCanteenBreakFastUpdate(Request  $request){
        $emp_id = $request['emp_id'];
        $breakfast = $request['breakfast'];

        if($breakfast == 'true'){
            try {
                $rs = DB::update("
                    update hrms.meal_information@web_to_hrms
                    set meal_status = 'YES'
                    where emp_id = '$emp_id'
                    and meal_type = 'BREAKFAST'
                ");
            }catch (Oci8Exception $exception){

            }
        }else{
            try {
                $rs = DB::update("
                    update hrms.meal_information@web_to_hrms
                    set meal_status = 'NO'
                    where emp_id = '$emp_id'
                    and meal_type = 'BREAKFAST'
                ");
            }catch (Oci8Exception $exception){

            }
        }
    }


    /*************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function onCanteenBreakFastTokensUpdate(Request  $request){
        $emp_id = $request['emp_id'];
        $breakFastToken = $request['breakfastToken'];

        if($breakFastToken == 'true'){
            try {
                 DB::update("
                    update hrms.meal_information@web_to_hrms
                    set token_status = 'YES'
                    where emp_id = '$emp_id'
                    and meal_type = 'BREAKFAST'
                ");

            }catch (Oci8Exception $exception){

            }
        }else{
            try {
                DB::update("
                    update hrms.meal_information@web_to_hrms
                    set token_status = 'NO'
                    where emp_id = '$emp_id'
                    and meal_type = 'BREAKFAST'
                ");

            }catch (Oci8Exception $exception){

            }
        }
    }

    /*************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function onCanteenMidNightSnacksUpdate(Request  $request){
        $emp_id = $request['emp_id'];
        $midnightSnacks = $request['midnightSnacks'];

        if($midnightSnacks == 'true'){
            try {
                $rs = DB::update("
                    update hrms.meal_information@web_to_hrms
                    set meal_status = 'YES'
                    where emp_id = '$emp_id'
                    and meal_type = 'MIDNIGHT SNACKS'
                ");
            }catch (Oci8Exception $exception){

            }
        }else{
            try {
                $rs = DB::update("
                    update hrms.meal_information@web_to_hrms
                    set meal_status = 'NO'
                    where emp_id = '$emp_id'
                    and meal_type = 'MIDNIGHT SNACKS'
                ");
            }catch (Oci8Exception $exception){

            }
        }
    }


    /*************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function onCanteenMidNightSnacksTokenUpdate(Request  $request){
        $emp_id = $request['emp_id'];
        $midnightSnacksToken = $request['midnightToken'];

        if($midnightSnacksToken == 'true'){
            try {
                DB::update("
                    update hrms.meal_information@web_to_hrms
                    set token_status = 'YES'
                    where emp_id = '$emp_id'
                    and meal_type = 'MIDNIGHT SNACKS'
                ");

            }catch (Oci8Exception $exception){

            }
        }else{
            try {
                DB::update("
                    update hrms.meal_information@web_to_hrms
                    set token_status = 'NO'
                    where emp_id = '$emp_id'
                    and meal_type = 'MIDNIGHT SNACKS'
                ");

            }catch (Oci8Exception $exception){

            }
        }
    }

    /*************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function onCanteenDinnerUpdate(Request  $request){
        $emp_id = $request['emp_id'];
        $dinner = $request['dinner'];

        if($dinner == 'true'){
            try {
                $rs = DB::update("
                    update hrms.meal_information@web_to_hrms
                    set meal_status = 'YES'
                    where emp_id = '$emp_id'
                    and meal_type = 'DINNER'
                ");
            }catch (Oci8Exception $exception){

            }
        }else{
            try {
                $rs = DB::update("
                    update hrms.meal_information@web_to_hrms
                    set meal_status = 'NO'
                    where emp_id = '$emp_id'
                    and meal_type = 'DINNER'
                ");
            }catch (Oci8Exception $exception){

            }
        }
    }

    /*************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function onCanteenDinnerTokenUpdate(Request  $request){
        $emp_id = $request['emp_id'];
        $dinnerToken = $request['dinnerToken'];

        if($dinnerToken == 'true'){
            try {
                DB::update("
                    update hrms.meal_information@web_to_hrms
                    set token_status = 'YES'
                    where emp_id = '$emp_id'
                    and meal_type = 'DINNER'
                ");

            }catch (Oci8Exception $exception){

            }
        }else{
            try {
                DB::update("
                    update hrms.meal_information@web_to_hrms
                    set token_status = 'NO'
                    where emp_id = '$emp_id'
                    and meal_type = 'DINNER'
                ");

            }catch (Oci8Exception $exception){

            }
        }
    }




    /*************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function onCanteenEveningSnacksUpdate(Request  $request){
        $emp_id = $request['emp_id'];
        $eveningSnacks = $request['eveningSnacks'];

        if($eveningSnacks == 'true'){
            try {
                $rs = DB::update("
                    update hrms.meal_information@web_to_hrms
                    set meal_status = 'YES'
                    where emp_id = '$emp_id'
                    and meal_type = 'EVENING SNACKS'
                ");
            }catch (Oci8Exception $exception){

            }
        }else{
            try {
                $rs = DB::update("
                    update hrms.meal_information@web_to_hrms
                    set meal_status = 'NO'
                    where emp_id = '$emp_id'
                    and meal_type = 'EVENING SNACKS'
                ");
            }catch (Oci8Exception $exception){

            }
        }
    }

    /*************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function onCanteenEveningSnacksTokenUpdate(Request  $request){
        $emp_id = $request['emp_id'];
        $eveningSnacksToken = $request['eveningSnacksToken'];

        if($eveningSnacksToken == 'true'){
            try {
                DB::update("
                    update hrms.meal_information@web_to_hrms
                    set token_status = 'YES'
                    where emp_id = '$emp_id'
                    and meal_type = 'EVENING SNACKS'
                ");

            }catch (Oci8Exception $exception){

            }
        }else{
            try {
                DB::update("
                    update hrms.meal_information@web_to_hrms
                    set token_status = 'NO'
                    where emp_id = '$emp_id'
                    and meal_type = 'EVENING SNACKS'
                ");

            }catch (Oci8Exception $exception){

            }
        }
    }




}