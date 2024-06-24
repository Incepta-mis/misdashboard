<?php

namespace App\Http\Controllers;

use App\FcmService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuizApiController extends Controller
{

    /***********************************
     * Programmer: Md. Raqib Hasan
     * Created On: 10/03/2019
     */

    /******************************************************
     * QuizApiController constructor.
     */

    public function __construct()
    {
        DB::setDateFormat('DD-MON-RR');
    }

    /****************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    /* Initial login credential check */
    public function quser_credential(Request $request)
    {

        // Log::info($request->all());
        
        DB::setDateFormat('YYYY-MM-DD HH24:MI:SS');

        $responseData = DB::select('select emp_id,sur_name,desig,emp_type type 
                                   from msfa.emp_info@web_to_imsfa 
                                   where emp_id = ? and password = ?', [$request->ecode, $request->pass]);
        $userInfo = [];
        if ($responseData) {

            $checkData = DB::select('select * from mis.msd_user_fcm_id where emp_code = ?', [$request->ecode]);

            if ($checkData) {

                DB::table('mis.msd_user_fcm_id')
                    ->where('emp_code', '=', $request->ecode)
                    ->update(['fcm_id' => $request->fcmToken === '' ? $checkData[0]->fcm_id : $request->fcmToken,
                              'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')]);

            } else {
                $rowData = [
                    'emp_code' => $request->ecode,
                    'device_type' => 'Android',
                    'fcm_id' => $request->fcmToken
                ];

                DB::table('mis.msd_user_fcm_id')->insert($rowData);
            }

            $userInfo = ['user' => $responseData];
        } else {
            $userInfo = ['user' => 'invalid'];
        }

        return response()->json($userInfo);

    }

    /*************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    /* Quiz Availablitiy check */
    public function qnotification(Request $request)
    {
        // Log::info($request->all());
        $new_date = null;
        if(strpos($request->cdate,'.')){
            $new_date = str_replace('.','',$request->cdate);
        }else{
            $new_date = $request->cdate;
        }

        $responseData = DB::select("select gi.group_id,emp_id,emp_name,terr_id,
                                          to_char(start_date_time,'DD-MON-RR') qdate,
                                          to_char(start_date_time,'HH:MI AM') stime,
                                          to_char(end_date_time,'HH:MI AM') etime,exam_duration,
                                          case when to_date(start_date_time,'DD-MON-RR') > to_date(sysdate,'DD-MON-RR') then 'later' 
                                               when to_date(start_date_time,'DD-MON-RR') = to_date(sysdate,'DD-MON-RR') then 'today' else '' 
                                          end etype,
                                          ED.EXAM_DOCUMENT_DESC topic
                                    from mis.msd_group_info gi,mis.msd_exam_date_time edt,mis.msd_exam_document ed
                                    where emp_id = ?
                                    and gi.group_id = edt.group_id
                                    and gi.group_id = ed.group_id
                                    and to_date(end_date_time,'DD-MON-RR') >= to_date(?,'DD-MON-RR')
                                    and edt.valid = 'YES'
                                    and gi.exam_given is null
                                    ",
            [$request->ecode, $new_date]);

        $examInfo = [];
        if ($responseData) {
            $examInfo = ['qinfo' => $responseData];
        } else {
            $examInfo = ['qinfo' => 'nq'];
        }

        return response()->json($examInfo);
    }

    /*********************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    /* Quiz Materials */
    public function qmaterials(Request $request)
    {
            //        Log::info($request->all());

        if($request->gid){

                //Log::info('first '.$request->gid);

                $quizMaterial = DB::select('select group_id gid,exam_document_desc e_doc,
                                               exam_document_name doc_name,?||doc_file_path path
                                          from mis.msd_exam_document 
                                          where group_id = ?',
                    [url('') . '/', $request->gid]);

                //Log::info($quizMaterial);
                if ($quizMaterial) {
                    return response()->json(['material' => $quizMaterial, 'mcount' => count($quizMaterial)]);
                } else {
                    return response()->json(['material' => 'nf']);
                }

        }else{

            //Log::info('second');


            $quizVerify = DB::select('select gi.group_id gid,emp_id,emp_name,terr_id                             
                                from mis.msd_group_info gi,mis.msd_exam_date_time edt
                                where emp_id = ?
                                and gi.group_id = edt.group_id
                                and gi.exam_given is null
                                order by gi.group_id desc',
                [$request->ecode]);

            if ($quizVerify) {
                $quizMaterial = DB::select('select group_id gid,exam_document_desc e_doc,
                                               exam_document_name doc_name,?||doc_file_path path
                                          from mis.msd_exam_document 
                                          where group_id = ?',
                    [url('') . '/', $quizVerify[0]->gid]);

                //Log::info($quizMaterial);
                if ($quizMaterial) {
                    return response()->json(['material' => $quizMaterial, 'mcount' => count($quizMaterial)]);
                } else {
                    return response()->json(['material' => 'nf']);
                }

            } else {
                return response()->json(['material' => 'nf']);
            }
        }


    }

    /***************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    /* Quiz Questions */
    public function qquestions(Request $request)
    {
        // Log::info('Masroor');
        // Log::info($request->all());

        $quizVerify = DB::select("select gi.group_id gid,emp_id,emp_name,terr_id,
                                      to_char(start_date_time,'DD-MON-RR HH:MI:SS AM') stime,
                                      to_char(end_date_time,'DD-MON-RR HH:MI:SS AM') etime,
                                      exam_duration,exam_given
                                from mis.msd_group_info gi,mis.msd_exam_date_time edt
                                where emp_id = ?
                                and gi.group_id = edt.group_id
                                and to_date(start_date_time,'DD-MON-RR') = to_date(?,'DD-MON-RR')
                                and edt.valid = 'YES'",
            [$request->ecode, $request->cdate]);

        $response = [];
        if ($quizVerify) {

            $startTime = Carbon::parse($quizVerify[0]->stime)->format('Y-m-d H:i:s');
            $endTime = Carbon::parse($quizVerify[0]->etime)->format('Y-m-d H:i:s');
            $appTime = Carbon::parse($request->cDateTime)->format('Y-m-d H:i:s');

            //Log::info('stime: ' . $startTime . '| etime: ' . $endTime . '| apptime: ' . $appTime);

            if ($appTime >= $startTime && $appTime <= $endTime) {
//                Log::info($appTime);

                $questions = DB::select("select ques_id qid,ques_text qtext,
                                               case when ques_a is not null then 'A.'||' '||ques_a else null end ques_a,
                                               case when ques_b is not null then 'B.'||' '||ques_b else null end ques_b,
                                               case when ques_c is not null then 'C.'||' '||ques_c else null end ques_c,
                                               case when ques_d is not null then 'D.'||' '||ques_d else null end ques_d,
                                               ques_true,ques_false,ques_answer,
                                               case when ques_a is null then 'R' else 'C' end type,quiz_mark qmark
                                        from MIS.MSD_QUESTION_PAPER  
                                        where valid = 'YES'
                                        and group_id = ? 
                                        order by ques_id asc
                                        ", [$quizVerify[0]->gid]);

                if ($questions) {
                    $response = [
                        'rdata' => $questions,
                        'qtime' => $quizVerify[0]->exam_duration,
                        'gid' => $quizVerify[0]->gid,
                        'qstatus' => $quizVerify[0]->exam_given === 'YES' ? 'Y' : 'N',
                        'tmarks' => $questions[0]->qmark
                    ];

                    //added on 28.09.2019

                    if($response['qstatus'] === 'N'){
                        //Log::info('user already entered in exam');
                        DB::table('mis.msd_group_info')
                            ->where([['group_id', $quizVerify[0]->gid], ['emp_id', $quizVerify[0]->emp_id]])
                            ->update(['exam_given' => 'YES']);
                    }

                } else {
                    $response = ['rdata' => 'qns']; //question not set
                }

            } else {
                $response = ['rdata' => 'tover'];   //time over
            }
            //Log::info($response);  
            return response()->json($response);
        } else {
            return response()->json(['rdata' => 'invalid']);
        }

    }

    /****************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    /* Submitted Quiz Result */
    public function submittedAnswer(Request $request)
    {

        foreach ($request->all() as $data) {
            //Log::info($data['qid'].'| '.$data['question']);
            $ans = [array_key_exists('ans1', $data) ? $data['ans1'] : 0,
                array_key_exists('ans2', $data) ? $data['ans2'] : 0,
                array_key_exists('ans3', $data) ? $data['ans3'] : 0,
                array_key_exists('ans4', $data) ? $data['ans4'] : 0];

            $ans = array_filter($ans, function ($a) {
                return $a !== 0;
            });

            $ans = array_filter($ans, function ($a) {
                return $a !== null;
            });

//            Log::info($ans);

            $rowData = [
                'group_id' => $data['gid'],
                'ecode' => $data['uid'],
                'ques_id' => $data['qid'],
                'ques_text' => $data['question'],
                'gans_a_no' => array_key_exists('ans1', $data) ? $data['ans1'] : 0,
                'gans_a' => array_key_exists('ans1text', $data) ? $data['ans1text'] : '',
                'gans_b_no' => array_key_exists('ans2', $data) ? $data['ans2'] : 0,
                'gans_b' => array_key_exists('ans2text', $data) ? $data['ans2text'] : '',
                'gans_c_no' => array_key_exists('ans3', $data) ? $data['ans3'] : 0,
                'gans_c' => array_key_exists('ans3text', $data) ? $data['ans3text'] : '',
                'gans_d_no' => array_key_exists('ans4', $data) ? $data['ans4'] : 0,
                'gans_d' => array_key_exists('ans4text', $data) ? $data['ans4text'] : '',
                'given_answer' => implode(',', $ans)
            ];

            DB::table('mis.msd_submitted_quiz')->insert($rowData);

        }

        $firstRow = $request->all()[0];
        if ($firstRow) {
            //Log::info($firstRow);
            DB::table('mis.msd_group_info')
                ->where([['group_id', $firstRow['gid']], ['emp_id', $firstRow['uid']]])
                ->update(['exam_given' => 'YES']);
        }

        return response()->json(['response' => 'success']);
    }

    /*****************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

   public function currentResult(Request $request)
    {
        Log::info($request->all());

        $quizVerify = DB::select("select gi.group_id gid,emp_id,emp_name,terr_id,
                                          to_char(start_date_time,'DD-MON-RR HH:MI:SS AM') stime,
                                          to_char(end_date_time,'DD-MON-RR HH:MI:SS AM') etime,
                                          exam_duration,exam_given
                                    from mis.msd_group_info gi,mis.msd_exam_date_time edt,(select max(group_id) gid
                                                                                           from mis.msd_group_info
                                                                                           where emp_id = ?
                                                                                           and exam_given = 'YES'
                                                                                           ) mg
                                    where emp_id = ?
                                    and mg.gid = edt.group_id
                                    and mg.gid = GI.GROUP_ID
                                    and ? between to_date(start_date_time,'DD-MON-RR') and to_date(end_date_time+3,'DD-MON-RR')
                                    and edt.valid = 'YES'",
            [$request->ecode, $request->ecode, $request->cdate]);

        $type = '';
        $av_time = '';
        if ($quizVerify) {

            $startTime = Carbon::parse($quizVerify[0]->stime)->format('Y-m-d H:i:s');
            $endTime = Carbon::parse($quizVerify[0]->etime)->addMinutes(30)->format('Y-m-d H:i:s');
            $appTime = Carbon::parse($request->cDateTime)->format('Y-m-d H:i:s');

            $av_time = $endTime;
            //Log::info('stime: ' . $startTime . '| etime: ' . $endTime . '| apptime: ' . $appTime);

            if ($appTime >= $startTime && $appTime <= $endTime) {
                $type = 'np';
            } else {
                $type = 'rp';
                $resultData = DB::select("Select Sq.Group_Id gid,Sq.Ecode ecode,Sq.Ques_Id qid,Sq.Ques_Text qtext,Sq.Given_Answer ga,Qp.Ques_Answer qa,
                                           case when Qp.Ques_A is not null then 'A.'||' '||Qp.Ques_A else null end a,
                                           case when Qp.Ques_B is not null then 'B.'||' '||Qp.Ques_B else null end b,
                                           case when Qp.Ques_C is not null then 'C.'||' '||Qp.Ques_C else null end c,
                                           case when Qp.Ques_D is not null then 'D.'||' '||Qp.Ques_D else null end d,
                                           Qp.Ques_True t,Qp.Ques_False f,
                                           Case When Sq.Given_Answer = Qp.Ques_Answer Then 'T' when Sq.Given_Answer is null then 'NG' else 'F' End Status,
                                           Case When Qp.Ques_A Is Null Then 'R' Else 'C' End Ctype 
                                    From Mis.Msd_Exam_Date_Time Edt,Mis.Msd_Group_Info Gi,Mis.Msd_Submitted_Quiz Sq,Mis.Msd_Question_Paper Qp
                                    Where Edt.Group_Id = Gi.Group_Id
                                    And Edt.Group_Id = Sq.Group_Id
                                    And Edt.Group_Id = Qp.Group_Id
                                    And Qp.Ques_Id = Sq.Ques_Id
                                    And ? between To_Date(Edt.Start_Date_Time,'DD-MON-RR') and To_Date(Edt.End_Date_Time+3,'DD-MON-RR')
                                    And sq.Ecode = ?
                                    and gi.emp_id = ?                                    
                                    And Gi.Exam_Given = 'YES'
                                    and gi.group_id = (Select max(group_id) from Mis.Msd_Submitted_Quiz where ecode = ? )
                                    order by sq.ques_id asc
                                    ", [$request->cdate, $request->ecode, $request->ecode,$request->ecode]);
            }
        }

        $currentResultSummary = DB::select("select sq.gid gid,sq.ecode ecode,sq.correct_ans*(qm.quiz_mark/sq.total_ques) omark,
                                                 qm.quiz_mark qmark,qd.topic topic,sq.edate edate
                                            from
                                            (select gid,ecode,edate,sum(tq) total_ques,sum(ca) correct_ans
                                            from(
                                            select sq.group_id gid,sq.ecode ecode,1 tq,
                                                   case when sq.given_answer = qp.ques_answer then 1 when sq.given_answer is null then 0 else 0 end ca,
                                                   to_char(sq.create_date,'DD-MON-RR') edate
                                            from mis.msd_submitted_quiz sq,mis.msd_question_paper qp
                                            where qp.ques_id = sq.ques_id
                                            and sq.ecode = ?
                                            and sq.group_id = qp.group_id
                                            and ? between to_date(sq.create_date,'DD-MON-RR') and to_date(sq.create_date+3,'DD-MON-RR')
                                            order by sq.ques_id
                                            )group by gid,ecode,edate) sq,
                                                              (select distinct group_id,quiz_mark
                                                                      from mis.msd_question_paper
                                                                      where group_id in 
                                                                      (select distinct group_id from mis.msd_submitted_quiz
                                                                                         where ecode = ?
                                                                                          and ? between to_date(create_date,'DD-MON-RR') and to_date(create_date+3,'DD-MON-RR'))) qm,                                                                               
                                                              (select distinct group_id,exam_document_desc topic
                                                               from mis.msd_exam_document
                                                               where group_id in (select distinct max(group_id) group_id from mis.msd_submitted_quiz
                                                                                 where ecode = ?
                                                                                  and ? between to_date(create_date,'DD-MON-RR') and to_date(create_date+3,'DD-MON-RR'))) qd
                                            where sq.gid = qm.group_id       
                                            and sq.gid = qd.group_id
                                            ", [$request->ecode, $request->cdate, $request->ecode, $request->cdate, $request->ecode, $request->cdate]);

        if (strlen($type) > 0) {
            //Log::info($type);
            if ($type === 'np') {
                return response()->json(['results' => [], 'summary' => isset($currentResultSummary[0]) ? $currentResultSummary[0] : [], 'type' => $type, 'av_time' => Carbon::parse($av_time)->format('g:i A l jS F Y')]);
            } else {
                return response()->json(['results' => $resultData, 'summary' => $currentResultSummary[0], 'type' => $type, 'av_time' => Carbon::parse($av_time)->format('g:i A l jS F Y')]);
            }

        } else {
            return response()->json(['results' => 'nf']);
        }
    }

    /****************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function previousResult(Request $request)
    {
        $resultData = DB::select("Select * from(
                                    select sq.gid gid,sq.ecode ecode,sq.correct_ans*(qm.quiz_mark/sq.total_ques) omark,
                                         qm.quiz_mark qmark,qd.topic topic,sq.edate edate
                                    from
                                    (select gid,ecode,edate,sum(tq) total_ques,sum(ca) correct_ans
                                    from(
                                    select sq.group_id gid,sq.ecode ecode,1 tq,
                                           case when sq.given_answer = qp.ques_answer then 1 when sq.given_answer is null then 0 else 0 end ca,to_char(sq.create_date,'DD-MON-RR') edate
                                    from mis.msd_submitted_quiz sq,mis.msd_question_paper qp
                                    where qp.ques_id = sq.ques_id
                                    and sq.ecode = ?
                                    and sq.group_id = qp.group_id
                                    order by sq.ques_id
                                    )group by gid,ecode,edate) sq,
                                    (select distinct group_id,quiz_mark
                                                              from mis.msd_question_paper
                                                              where group_id in (select distinct group_id from mis.msd_submitted_quiz
                                                                                 where ecode = ?)) qm,
                                     (select distinct group_id,exam_document_desc topic
                                                                 from mis.msd_exam_document
                                                                 where group_id in (select distinct group_id from mis.msd_submitted_quiz
                                                                                     where ecode = ?)) qd
                                    where sq.gid = qm.group_id       
                                    and sq.gid = qd.group_id
                                    order by sq.gid desc)
                                    where rownum < 5
                                    order by gid desc", [$request->ecode, $request->ecode, $request->ecode]);
        if ($resultData) {
            return response()->json(['results' => $resultData]);
        } else {
            return response()->json(['results' => 'nf']);
        }
    }

    /****************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function getNotificationList(Request $request)
    {

        $notificationData = DB::select("
                                select *
                                from(
                                select group_id gid,group_name gname,ntf_title title,ntf_message message,
                                       to_char(create_date,'DD-MON-RR HH:MI:SS AM') ndate
                                from MIS.MSD_GROUP_NOTIFICATION
                                where group_id in (select *
                                                    from(
                                                    select group_id
                                                    from MIS.MSD_GROUP_INFO
                                                    where emp_id = ?
                                                    --and exam_given is null
                                                    order by group_id asc
                                                    ) )
                                order by create_date desc)
                                where rownum < 7       
                            ", [$request->ecode]);

        if ($notificationData) {
            return response()->json(['response' => $notificationData]);
        } else {
            return response()->json(['response' => 'nf']);
        }
    }

    /***************************************************
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function view_notification()
    {
        return view('quiz_portal.notification_view');
    }

    /***************************************************
     * @return \Illuminate\Http\JsonResponse
     */

    public function get_group_list()
    {
        $groupData = DB::select('select *
                                from (
                                Select group_id grp_id,group_name grp_name,count(emp_id) t_count
                                from MIS.MSD_GROUP_INFO
                                group by group_id,group_name
                                order by group_id desc
                                ) where rownum < 60');

        return response()->json($groupData);
    }

    /*****************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function save_notifications(Request $request)
    {

        //Log::info($request->all());
        if ($request['groups']) {
            foreach ($request['groups'] as $group) {
                $rowData = [
                    'group_id' => $group['grp_id'],
                    'group_name' => $group['grp_name'],
                    'ntf_title' => $request['title'],
                    'ntf_message' => $request['message'],
                    'create_user' => Auth::user()->user_id
                ];

                DB::table('mis.msd_group_notification')->insert($rowData);
            }
        }

        $ntf_logs = DB::select("Select group_id id,group_name name,ntf_title title,ntf_message message,
                                       to_char(create_date,'DD-MON-RR HH:MI:SS AM') send_at
                                from mis.msd_group_notification
                                order by create_date desc");

        return response()->json(['status' => 'saved', 'logs' => $ntf_logs]);
    }

    /*************************************************
     * @return \Illuminate\Http\JsonResponse
     */

    public function get_logs()
    {
        $ntf_logs = DB::select("select *
                                from (
                                Select group_id id,group_name name,ntf_title title,ntf_message message,
                                       to_char(create_date,'DD-MON-RR HH:MI:SS AM') send_at
                                from mis.msd_group_notification
                                order by create_date desc
                                ) where rownum < 61");

        return response()->json($ntf_logs);
    }

    /****************************************************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function send_notification_to_groups(Request $request)
    {
        foreach ($request->groups as $grp){
            $tokens = [];

            $fcm_ids = DB::select('select distinct fi.emp_code ecode,fi.fcm_id token
                                    from MIS.MSD_GROUP_INFO gi,MIS.MSD_USER_FCM_ID fi
                                    where GI.EMP_ID = FI.EMP_CODE
                                    and fi.fcm_id is not null
                                    and GI.GROUP_ID = ?',[$grp['grp_id']]);

            foreach ($fcm_ids as $fcm){
                $tokens[] = $fcm->token;
            }

            $fcmService = new FcmService($request->title,$request->message,$tokens);
            $responseFcm = $fcmService->send_notice();
            //Log::info($responseFcm);
        }

        return response()->json(['status'=>'success']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_grp_list(Request $request){

        $grpList = DB::select('select *
                                from(
                                select distinct group_id,group_name
                                from mis.msd_group_info
                                order by group_id desc
                                )where rownum < 12');

        if($grpList){
            return response()->json(['groups'=>$grpList]);
        }else{
            return response()->json(['groups'=>'nf']);
        }

    }

     /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_questions_paper(Request $request)
    {


        $questions = DB::select("select ques_id qid,ques_text qtext,
                                               case when ques_a is not null then 'A.'||' '||ques_a else null end ques_a,
                                               case when ques_b is not null then 'B.'||' '||ques_b else null end ques_b,
                                               case when ques_c is not null then 'C.'||' '||ques_c else null end ques_c,
                                               case when ques_d is not null then 'D.'||' '||ques_d else null end ques_d,
                                               ques_true,ques_false,ques_answer,
                                               case when ques_a is null then 'R' else 'C' end type,quiz_mark qmark
                                        from MIS.MSD_QUESTION_PAPER  
                                        where valid = 'YES'
                                        and group_id = ? 
                                        order by ques_id asc
                                        ", [$request->gid]);
        $response = [];
        if ($questions) {

            $time = DB::select('Select exam_duration 
                                        from MIS.MSD_EXAM_DATE_TIME
                                        where group_id = ? ', [$request->gid]);

            $response = [
                'rdata' => $questions,
                'qtime' => $time[0]->exam_duration,
                'gid' => $request->gid,
                'tmarks' => $questions[0]->qmark
            ];

        } else {
            $response = ['rdata' => 'nf'];
        }

        //Log::info($response);
        return response()->json($response);
    }


}
