<?php


namespace App\Http\Controllers\SCM;


use App\Http\Controllers\Controller;
use App\Model\SCM\BLkFilesUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BlockListFilesUploadController extends Controller
{
    public function index(){
        $galleries = BLkFilesUpload::all();
        $rs_data = DB::select("select plant,company_full_name ||' ('|| company_short_name ||')' company
                              from mis.scm_company_info order by  company_full_name");

        return view('scm_portal.BlockListFiles.blkList_Upload', compact('galleries','rs_data'));
    }

    public function store(Request $request)
    {

       $company = DB::select("
        select company_full_name 
        from mis.scm_company_info
        where plant = '$request->cmp'
       ");

        if($request->hasFile('blFiles')) {
            foreach($request->file('blFiles') as $bfile) {
                $filename = $bfile->getClientOriginalName();
                $filenameExt = $bfile->getClientOriginalExtension();

                try{
                    $rs = DB::select("
                    select count(*) cnt
                    from mis.scm_blocklist_files_table
                    where filename = '$filename'
                ");

                    if($rs[0]->cnt > 0){
                        $file = public_path('SCM/BlockListFiles/'.  $filename);
                        unlink($file);
                        DB::select("
                        DELETE FROM mis.scm_blocklist_files_table WHERE filename = '$filename'
                    ");
                    }
                }catch (\Exception $e){
                    Log::info("Error SCM Block List File $e");
                }


                $bfile->move(public_path('SCM\BlockListFiles'), $filename);



                $bLkFilesUpload = new BLkFilesUpload;
                $bLkFilesUpload->id = $bLkFilesUpload::max('id')+1;
                $bLkFilesUpload->plant = $request->cmp;
                $bLkFilesUpload->company_full_name = $company[0]->company_full_name;
                $bLkFilesUpload->filename = $filename;
                $bLkFilesUpload->filelocation = 'public\SCM\BlockListFiles'."\\".$filename;
                $bLkFilesUpload->create_user = Auth::user()->user_id;
                $bLkFilesUpload->save();
            }
        }
        return back()->with('status', 'The Files was uploaded.');
    }

    public function destroy($id)
    {
        $gallery = BLkFilesUpload::find($id);
        $file = public_path('SCM/BlockListFiles/'. $gallery->filename);
        unlink($file);
        $gallery->delete();
        return back()->with('status', 'The File was deleted.');
    }

    /*public function download($id)
    {

        Log::info($id);

        $gallery = BLkFilesUpload::find($id);
        Log::info($gallery);
        //        Log::info('public/SCM/BlockListFiles/' . $gallery->filename);

        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        $file= public_path('SCM/BlockListFiles/').  $gallery->filename;
        Log::info($file);
        return response()->download($file);

    }*/
}