<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Alert;
use Mail;
use MultiMail;
use Swift_SmtpTransport;
use Swift_Mailer;
use Artisan;
use Config;
use App\Models\Campaign;
use App\Models\MailLog;
use App\Models\EmailContact;
use App\Models\CampaignEmail;
use App\Models\EmailListGroup;
use App\Models\BouncedEmail;
use App\Models\SmsBuilder;
use App\Models\UserSentLimitPlan;
use App\Models\UserSentRecord;
use App\Models\EmailSMSLimitRate;
use App\Mail\CampaignMail;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\DB;
use Aman\EmailVerifier\EmailChecker;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            if (templateCount() > 0 && smsTemplateCount() > 0) {
                $campaigns = Campaign::where('owner_id', Auth::user()->id)->latest()->paginate(10);
                return view('campaign.index', compact('campaigns'));
            }else{
                Alert::warning(translate('Warning'), translate('You have no email template & SMS body.'));
                return redirect()->route('dashboard');
            }

        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return back();
        }
        
    }

    public function type($type)
    {

        if ($type == 'email') {
            $campaigns = Campaign::where('owner_id', Auth::user()->id)->where('type', 'email')->latest()->paginate(10);
            return view('campaign.email', compact('campaigns'));
        }else{
            $campaigns = Campaign::where('owner_id', Auth::user()->id)->where('type', 'sms')->latest()->paginate(10);
            $sms_templates = SmsBuilder::Active()->get();
            return view('campaign.sms', compact('campaigns', 'sms_templates'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (templateCount() > 0 && smsTemplateCount() > 0) {
                return view('campaign.set_campaign');
            }else{
                Alert::warning(translate('Warning'), translate('You have no email template & SMS body. Please Create An Email Template & SMS Body First.'));
                return redirect()->route('dashboard');
            }

    }

    /**
     * createType
     */

     public function createType($type)
     {
        if (templateCount() > 0) {
            if ($type == 'email') {
                return view('campaign.email.create.step1');
            }else{
                return view('campaign.sms.create.step1');
            }
        }else{
            Alert::warning(translate('Warning'), translate('You have No Email Template. Please Create An Email Template First.'));
            return back();
        }
     }

    /**
     * step1
     */

     public function step1Store(Request $request)
     {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }


        $type = $request->type;

        $step1 = new Campaign();
        $step1->owner_id = Auth::user()->id;
        $step1->name = $request->name;
        $step1->description = $request->description ?? null;

        if($request->status = 1)
        {
            $step1->status = true;
        }else{
            $step1->status = false;
        }

        notify()->success(translate('Campaign Saved'));

        return $this->createStep2($step1, $type);
     }

    /**
     * step2
     */

     public function createStep2($step1, $type)
     {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }


        try {
            if ($type == 'email') {
                return view('campaign.email.create.step2', compact('step1'));
            }else{
                $sms_templates = SmsBuilder::Active()->get();
                return view('campaign.sms.create.step2', compact('step1', 'sms_templates'));
            }
        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return redirect()->route('dashboard');
        }
        
     }

    /**
     * step2Store
     */

     public function step2Store(Request $request)
     {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

        $type = $request->type;

        try {


            if ($type == 'email') {
                $step2 = new Campaign();
                $step2->template_id = $request->template_id;
                $step2->owner_id = Auth::user()->id;
                $step2->name = $request->name;
                $step2->description = $request->description ?? null;
                $step2->status = true;
                $step2->type = 'email';
                $step2->save();
                notify()->success(translate('Templated Saved'));
                return $this->step3($step2, $type);
            }else{
                $step2 = new Campaign();
                $step2->sms_template_id = $request->sms_template_id;
                $step2->owner_id = Auth::user()->id;
                $step2->name = $request->name;
                $step2->description = $request->description ?? null;
                $step2->status = true;
                $step2->type = 'sms';
                $step2->save();
                notify()->success(translate('Templated Saved'));
                return $this->step3($step2, $type);

            }

            
        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return redirect()->route('dashboard');
        }
        
     }

    /**
     * step3
     */

     public function step3($step2, $type)
     {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

         try {
             if ($type == 'email') {
                telling(route('campaign.index'), translate('New Email Campaign Created'));
                $campaign_id = $step2->id;
                return view('campaign.email.create.step3', compact('campaign_id'));
             }else{
                telling(route('campaign.index'), translate('New SMS Campaign Created'));
                $campaign_id = $step2->id;
                return view('campaign.sms.create.step3', compact('campaign_id'));
             }
             
         } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return redirect()->route('dashboard');
         }
     }

    /**
     * emails
     */

     public function emails()
     {
         try {
             return view('campaign.components.emails');
         } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return redirect()->route('dashboard');
         }
     }

    /**
     * emailsStore
     */

     public function emailsStore(Request $request)
     {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

        $ids = $request->ids;
        $campaign_id = $request->campaign_id;
        $group_id = $request->groupIds;
        $emails = explode(",", $ids);

        if ($ids != null) {
            foreach($emails as $email)
            {
                $checkMmails  = CampaignEmail::where('campaign_id',$campaign_id)->where('email_id',$email)->first();
                if ($checkMmails == null) {
                    $campaign_email = new CampaignEmail();
                    $campaign_email->campaign_id = $campaign_id;
                    $campaign_email->email_id = $email;
                    $campaign_email->save();
                }
            }
        }

        

        $groups = Campaign::where('id', $campaign_id)->first();
        $groups->group_id = json_encode($request->groupIds);
        $groups->save();

        $groups_id = explode(",", $group_id);
        
        $emails_from_groups = EmailListGroup::whereIn('email_group_id', $groups_id)->with('emails')->get();

        foreach($emails_from_groups as $emails_from_group)
        {
            if ($emails_from_group->email_id != null) {
                $campaign_emails  = CampaignEmail::where('campaign_id',$campaign_id)->where('email_id',$emails_from_group->email_id)->first();

                if ($campaign_emails == null) {
                    $campaign_email = new CampaignEmail();
                    $campaign_email->campaign_id = $campaign_id;
                    $campaign_email->email_id = $emails_from_group->email_id;
                    $campaign_email->save();
                }
             
            }
        }

        return response()->json(['status'=>true,'message'=> translate('Campaign Stored Successfully')]);
     }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $checkType = Campaign::where('id', $id)->first();
        try {

            if ($checkType->type == 'email') {
                $edit_campaign = Campaign::where('id', $id)->with('campaign_emails')->first();
                return view('campaign.email.edit', compact('edit_campaign'));
            }else{
                $edit_campaign = Campaign::where('id', $id)->with('campaign_emails')->first();
                return view('campaign.sms.edit', compact('edit_campaign'));
            }


            
        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return back();
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }


        try {
            $update_campaign = Campaign::where('id', $id)->first();
        $update_campaign->owner_id = Auth::user()->id;
        $update_campaign->name = $request->name;
        $update_campaign->template_id = $request->template_id ?? null;
        $update_campaign->sms_template_id = $request->sms_template_id ?? null;
        $update_campaign->description = $request->description ?? null;

        if($request->status = 1)
        {
            $update_campaign->status = true;
        }else{
            $update_campaign->status = false;
        }

        $update_campaign->save();


        $emails = collect($request->emails);


        $delete_email = CampaignEmail::where('campaign_id', $id)->delete();

        foreach($emails as $email)
        {

          $check_email = CampaignEmail::where('campaign_id', $id)->where('email_id', $email)->first();

          if ($check_email == null) {
            $update_campaign_email = new CampaignEmail();
            $update_campaign_email->campaign_id =$id;
            $update_campaign_email->email_id = $email;
            $update_campaign_email->save();
          }

        }


        Alert::success(translate('Success'), translate('Campaign Updated'));
        return back();
        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return redirect()->route('dashboard');
        }
        


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

        try {
            Campaign::findOrFail($id)->delete();
            CampaignEmail::where('campaign_id', $id)->delete();
            Alert::success(translate('Success'), translate('Campaign Deleted'));

            return back();
        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return redirect()->route('dashboard');
        }
    }


    /** SEND EMAIL */

    public function campaignSendEmail($campaign_id, $template_id)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

        try {

            $campaignEmails = CampaignEmail::where('campaign_id', $campaign_id)
                                            ->with('emails')
                                            ->get();

            if (emailLimitCheck(Auth::user()->id)) {
                foreach ($campaignEmails as $campaignEmail) {
                    \MultiMail::to($campaignEmail->emails->email)
                            ->from('mail@no-reply')
                            ->queue(new CampaignMail($template_id, $campaign_id));
                }

            return $this->emailBounce($campaignEmails, $campaign_id);

            }else{
                Alert::error(translate('Whoops'), translate('Subscription Expired'));
                return back();
            }

        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong try again'));
            return back();
        }

        
    }

    /**
     * EMAIL BOUNCER
     */

    public function emailBounce($campaignEmails, $campaign_id)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

        try {
            foreach($campaignEmails as $campaignEmail)
            {
            
                /**
                 * Check bounce
                 */
                $bounced = app(EmailChecker::class)
                            ->checkEmail($campaignEmail->emails->email,'boolean');
                $bounce = new BouncedEmail();
                $bounce->bounce = $bounced['success'];
                $bounce->owner_id = Auth::user()->id;
                $bounce->email = $campaignEmail->emails->email;
                $bounce->camapaign_id = $campaign_id;
                $bounce->save();
                /**
                 * Email sent record
                 */
                $user_sent_mail_record = new UserSentRecord();
                $user_sent_mail_record->owner_id = Auth::user()->id;
                $user_sent_mail_record->type = 'email';
                $user_sent_mail_record->save();
                
            }
                /**
                 * Email Limit 
                 */            
                $email_limit = EmailSMSLimitRate::where('owner_id', Auth::user()->id)
                                                ->first();
                /**
                 * Decreament from limit
                 */
                if($email_limit->email > 0) {
                    EmailSMSLimitRate::where('owner_id', Auth::user()->id)
                                    ->decrement('email', count($campaignEmails));
                }
                /**
                 * Check Current Limit
                 */
                $current_email_limit = EmailSMSLimitRate::where('owner_id', Auth::user()->id)
                                                        ->first();
                /**
                 * Updating Due limit into Zero
                 */
                if ($current_email_limit->email <= 0) {
                    $current_email_limit->email = 0;
                    $current_email_limit->save();
                
            }


                /**
                 * CAMPAIGN LOG
                 */

                 campaignLog($campaign_id ,getCampaignName($campaign_id)->name, translate(' campaign has been compeleted'));

                /**
                 * notify
                 */
                Alert::success(translate('Queue is running'), translate('Mailer Engine checked bounce emails'));
                return back();
            
        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Mailer Engine Crashed. Try Again'));
            return back();
        }

    }

    //END

}
