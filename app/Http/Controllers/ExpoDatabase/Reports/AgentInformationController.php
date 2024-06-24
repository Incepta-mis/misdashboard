<?php


namespace App\Http\Controllers\ExpoDatabase\Reports;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class AgentInformationController
{
    public function index(){
        $country = DB::select("
            select distinct country
            from mis.expo_agent_list
            order by country asc
        ");
        return view('expo_database.Reports.expo_agent_list',['country'=>$country]);
    }

    public function getAgentByCountry(Request $request){
        $re = DB::select("
            select *
            from mis.expo_agent_list
            where country = decode('$request->country','All',country,'$request->country')
        ");
        return response()->json($re);
    }
}