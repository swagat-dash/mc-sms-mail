<?php

namespace App\Http\Controllers;

use App\Models\EmailContact;
use App\Models\CampaignEmail;
use App\Models\Demo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\EmailContactExport;
use Maatwebsite\Excel\Facades\Excel;
Use Alert;
Use Auth;
Use Carbon\Carbon;
Use File;

class EmailContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('email_contacts.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

      $request->validate([
            'name' => 'required'
        ]);



        try {
            $email = new EmailContact();
            $email->owner_id = userId();
            $email->name = $request->name;
            $email->email = $request->email;
            $email->country_code = $request->country_code;
            $email->phone = $request->phone;
            $email->save();

            Alert::success(translate('Success'), translate('New Email Contact Stored'));
            return back();

        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return back();
        }
        
    }


    /**
     * SHOW
     */

    public function show($id)
    {

        try {
            $email = EmailContact::where('id', $id)->first();

            if ($email != null) {
                return view('email_contacts.show', compact('email'));
            } else{
                Alert::error(translate('Whoops'), translate('No Email Found'));
                return back();
            }
        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return back();
        }
        
    }

    /**
     * UPDATE
     */

     public function update(Request $request, $id)
     {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }
      
      $request->validate([
            'name' => 'required'
        ]);

         try {
            
         
        $email_update = EmailContact::where('id', $id)->first();

        if ($email_update != null) {
            $email_update->owner_id = userId();
            $email_update->name = $request->name;
            $email_update->email = $request->email;
            $email_update->country_code = $request->country_code;
            $email_update->phone = $request->phone;
            $email_update->save();
            Alert::success(translate('Success'), translate('Information Updated'));
            return back();
        } else{
            Alert::error(translate('Whoops'), translate('Something went wrong. Check user exist first.'));
            return back();
        }

        } catch (\Throwable $th) {
             Alert::error(translate('Whoops'), translate('Something went wrong'));
            return back();
         }

     }

    /**
     * EMAILS
     */

    public function emails()
    {
       
            $emails = EmailContact::where('owner_id', Auth::user()->id)->Active()->latest()->get();
            return view('email_contacts.load_pages.emails', compact('emails'));
        
    }

    /**
     * EMAIL LIST
     */

    public function emailList()
    {
       
        return view('email_contacts.list.email');
        
    }

    /**
     * PHONE LIST
     */

    public function phoneLIst()
    {
       
        return view('email_contacts.list.phone');
        
    }

    /**
     * favourites
     */

    public function favourite ()
    {
     
            $favourites = EmailContact::where('owner_id', Auth::user()->id)->Favourite()->latest()->get();
            return view('email_contacts.load_pages.favourites', compact('favourites'));
      
    }

    /**
     * blocked
     */

    public function blocked ()
    {
       
            $blocks = EmailContact::where('owner_id', Auth::user()->id)->Blocked()->latest()->get();
            return view('email_contacts.load_pages.blocked', compact('blocks'));
      
    }

    /**
     * unblockAll
     */

    public function unblockAll (Request $request)
    {
       
            
            $ids = $request->ids;
            $trashing = EmailContact::whereIn('id',explode(",",$ids))->update(['blocked' => 0]);
            return response()->json(['status'=>true,'message'=> translate("Email contact unblocked successfully.")]);
     
    }

    /**
     * trashed
     */

    public function trashedBin()
    {
   
            
            $trashes = EmailContact::where('owner_id', Auth::user()->id)->TrashedBin()->latest()->get();
            return view('email_contacts.load_pages.trashed', compact('trashes'));
      
    }

    /**
     * destroyAll
     */

     public function destroyAll(Request $request)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }
      
            
            $ids = $request->ids;
            $trashing = EmailContact::whereIn('id',explode(",",$ids))->update(['trashed' => 1]);
            EmailContact::whereIn('id',explode(",",$ids))->delete();
            return response()->json(['status'=>true,'message'=> translate("Email contact deleted successfully.")]);
      
    }

    /**
     * destroy
     */

     public function destroy($id)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }
      
            
            EmailContact::where('id',$id)->delete();

            $checkID = CampaignEmail::where('email_id', $id)->first();

            if ($checkID != null) {
                CampaignEmail::where('email_id', $id)->delete();
            }

            Alert::success(translate('Deleted'), translate('Contact Deleted'));
            return back();
      
    }

    /**
     * restoreAll
     */

     public function restoreAll(Request $request)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }
   
            
            $ids = $request->ids;
            EmailContact::whereIn('id',explode(",",$ids))->restore();
            $trashing = EmailContact::whereIn('id',explode(",",$ids))->update(['trashed' => 0]);
            return response()->json(['status'=>true,'message'=> translate("Email contact restored successfully.")]);
       
    }

    /**
     * destroy
     */

     public function permanentDestroyAll(Request $request)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }
      
    
            $ids = $request->ids;
            EmailContact::whereIn('id',explode(",",$ids))->forceDelete();
            return response()->json(['status'=>true,'message'=> translate("Email contact destroyed successfully.")]);
     
    }

    /**
     * blacklistAll
     */

     public function blacklistAll(Request $request)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

    
            
            $ids = $request->ids;
            $trashing = EmailContact::whereIn('id',explode(",",$ids))->update(['blocked' => 1]);
            return response()->json(['status'=>true,'message'=> translate("Email contact blacklisted successfully.")]);
      
    }

    /**
     * favouriteAll
     */

     public function favouriteAll(Request $request)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }
      
        
            $ids = $request->ids;
            $trashing = EmailContact::whereIn('id',explode(",",$ids))->update(['favourites' => 1]);
            return response()->json(['status'=>true,'message'=> translate("Email contact added to favourites successfully.")]);
       
    }

    /**
     * dislikeAll
     */

     public function dislikeAll(Request $request)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }
       
    
            $ids = $request->ids;
            $trashing = EmailContact::whereIn('id',explode(",",$ids))->update(['favourites' => 0]);
            return response()->json(['status'=>true,'message'=> translate("Email contact removed from favourites successfully.")]);
      
    }

    /**
     * mailSearch
     */

     public function mailSearch(Request $request)
    {
        $emails = EmailContact::where('email', 'LIKE' , '%' . $request->value . '%')->get();
        $sendSearch = '';

        foreach ($emails as $email)
        {
            $sendSearch = '<div class="intro-y">
                            <div class="inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">
                                <div class="flex px-5 py-3">
                                    <div class="w-56 flex-none flex items-center mr-10">
                                        <input class="input flex-none border border-gray-500 checking" data-id="'.$email->id.'" name="check" type="checkbox">
                                        <a href="javascript:;" class="w-5 h-5 flex-none ml-4 flex items-center justify-center text-gray-500">
                                            <x-feathericon-star/>
                                        </a>
                                        <a href="javascript:;" class="w-5 h-5 flex-none ml-2 flex items-center justify-center text-gray-500">
                                            <x-feathericon-trash/>
                                        </a>
                                        <div class="w-6 h-6 flex-none image-fit relative ml-5 email">
                                            <img alt="'. $email->email .'" class="rounded-full" src="'. emailAvatar($email->email) .'">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-3 w-full gap-4">
                                        <div class="w-64 sm:w-auto truncate mr-10">
                                        <span class="inbox__item--highlight">'. $email->email .'</span>
                                    </div>

                                    <div class="w-64 sm:w-auto truncate mr-10">
                                        <span class="inbox__item--highlight">'. $email->name .'</span>
                                    </div>

                                    <div class="w-64 sm:w-auto truncate mr-10">
                                        <span class="inbox__item--highlight">'. $email->phone .'</span>
                                    </div>
                                    </div>


                                    <div class="inbox__item--time whitespace-no-wrap ml-auto pl-10">'. $email->created_at .'</div>
                                </div>
                            </div>
                        </div>';
        }

        return $sendSearch;
    }


    /**
     * sendEmail
     */

    public function sendEmail(Request $request)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

     
            $ids = $request->ids;
            $emails = EmailContact::whereIn('email',explode(",",$ids))
                        ->get()
                        ->pluck('email')
                        ->toArray();
            
            foreach($emails as $email)
            {
                \Artisan::call('mail:send-test SendTestMail ' . $email ); // test mail
            }
            return response()->json(['status'=>true,'message'=> translate("Test mail sent successfully.")]);
      
        
    }


    /**
     * EXPORT
     */

    public function emailExport()
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

        try {
            return Excel::download(new EmailContactExport, 'users.csv');
        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return back();
        }
    }

    /**
     * markAsRead
     */

     function markAsRead(Request $request)
     {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

         $markAsRead = EmailContact::where('id', $request->id)->first();

            if ($markAsRead->favourites == 1) {
                $markAsRead->favourites = 0;
            }else{
                $markAsRead->favourites = 1;
            }
            
            $markAsRead->save();
         
            return response()->json('success', 200);
     }

     /**
      * bulk csv
      */

      public function bulkCsv()
      {
         return view('bulk.index');
      }

      public function importCsv(Request $request)
      {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

      try {
           $request->validate([
            'csv' => 'required|max:20000'
        ],[
            'csv.required' => 'Upload file is required',
            'csv.max' => 'File size must be smaller then 20MB',
            // 'csv.mimes' => 'File type must be csv',
        ]);

        if (File::exists(public_path('uploads/csv/' . Auth::user()->id . '.csv'))) {
            File::delete(public_path('uploads/csv/' . Auth::user()->id . '.csv'));
        }

        if ($request->hasFile('csv')) {
            $imageName = Auth::user()->id.'.'.$request->csv->getClientOriginalExtension();
            $request->csv->move(public_path('/uploads/csv'), $imageName);

            $file = asset('uploads/csv/' . Auth::user()->id . '.csv');
            $contacts = convert_csv_to_json($file);

            foreach (json_decode($contacts) as $value) {
                $email = new EmailContact;
                $email->owner_id = Auth::user()->id;
                $email->name = $value->name ?? null;
                $email->email = $value->email ?? null;
                $email->country_code = $value->country_code ?? null;
                $email->phone = $value->phone ?? null;
                $email->favourites = $value->favourites ?? 0;
                $email->blocked = $value->blocked ?? 0;
                $email->trashed = $value->trashed ?? 0;
                $email->is_subscribed = $value->is_subscribed ?? 0;
                $email->save();
            }
        }

        Alert::success(translate('Success'), translate('CSV Imported'));
        return back();
      } catch (\Throwable $th) {
          Alert::error(translate('Whoops'), translate('Something went wrong'));
            return back();
      }

       

        }


        /**
         * EXPORT
         */

         public function exportCsv()
         {

            if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

            

            try {
            $connect = mysqli_connect("localhost", "root", "", "dash_swagmail");  
            header('Content-Type: text/csv; charset=utf-8');  
            header('Content-Disposition: attachment; filename=data.csv');  
            $output = fopen("php://output", "w");  
            fputcsv($output, array('id', 'owner_id', 'name', 'email', 'country_code', 'phone', 'favourites', 'blocked', 'trashed', 'is_subscribed', 'deleted_at', 'created_at', 'updated_at.'));  
            $query = "SELECT * from email_contacts ORDER BY id DESC";  
            $result = mysqli_query($connect, $query);  
            while($row = mysqli_fetch_assoc($result))  
            {  
                fputcsv($output, $row);  
            }  
            fclose($output);

            Alert::success(translate('Success'), translate('CSV Exported'));
            return back();
        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return back();
        }


         }

    /**
     * DOWNLOAD CSV
     */
    public function sampleCsv()
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }


        try {
            return response()->download(csv_path());
        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Invoice Not Found'));
            return back();
        }
    }

    //END
}
