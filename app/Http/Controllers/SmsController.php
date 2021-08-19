<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Twilio\Rest\Client;
use Plivo\RestClient;
use App\Models\SmsLog;
use App\Models\Sms;
use App\Models\Campaign;
use App\Models\CampaignEmail;
use App\Models\SmsBuilder;
use Auth;
use Alert;

class SmsController extends Controller
{

    /**
     * BUILDER
     */

    public function builder()
    {
        return view('sms.builder');
    }

    public function builder_store(Request $request)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

      $request->validate([
            'name' => 'required',
            'body' => 'required'
    ]);

        try {
                $sms_builder = new SmsBuilder();
                $sms_builder->name = $request->name;
                $sms_builder->body = $request->body;

                if ($request->status == 1) {
                    $sms_builder->status = true;
                }else{
                    $sms_builder->status = false;
                }

                $sms_builder->user_id = Auth::user()->id;

                $sms_builder->save();

                telling(route('builder.sms.templates'), translate('New SMS Body Created'));

                notify()->success(translate('SMS Template Built Successfully'));
                return back();
            } catch (\Throwable $th) {
                Alert::error(translate('Whoops'), translate('Something went wrong'));
                return back();
            }
        
    }

    /**
     * templates
     */

    public function templates()
    {

        try {
            $templates = SmsBuilder::where('user_id', Auth::user()->id)->paginate(20);
            return view('sms.templates', compact('templates'));
        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return back();
        }
    }

    /**
     * INDEX
     */

    public function index()
    {
        try {
            $twilio = Sms::where('owner_id', Auth::user()->id)->where('sms_name', 'twilio')->first();
            $nexmo = Sms::where('owner_id', Auth::user()->id)->where('sms_name', 'nexmo')->first();
            $plivo = Sms::where('owner_id', Auth::user()->id)->where('sms_name', 'plivo')->first();
    
            return view('sms.index', compact('twilio', 'nexmo','plivo'));
        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return back();
        }
    }

    /**
     * configure
     */
    public function configure($sms)
    {
        try {
            $sms_config = Sms::firstOrNew(['sms_name' =>  $sms, 'owner_id' => Auth::user()->id]);
            return view('sms.configure', compact('sms', 'sms_config'));
        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return back();
        }
    }

    /**
     * store
     */

    public function store(Request $request, $sms)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

        try {
            switch ($sms) {
            case 'twilio':
                
                $twilio = Sms::firstOrNew(['sms_name' =>  $sms, 'owner_id' => Auth::user()->id]);
                $twilio->sms_name      = $sms;
                $twilio->sms_id        = $request->sms_id;
                $twilio->sms_token     = $request->sms_token;
                $twilio->sms_from      = $request->sms_from;
                $twilio->sms_number    = $request->sms_number;
                $twilio->owner_id      = Auth::user()->id;
                $twilio->save();
                
                notify()->success( Str::ucfirst($sms). ' ' . translate('Configured'));
                return back();

                break;

            case 'nexmo':
                
                $nexmo = Sms::firstOrNew(['sms_name' =>  $sms, 'owner_id' => Auth::user()->id]);
                $nexmo->sms_name     = $sms;
                $nexmo->sms_id        = $request->sms_id;
                $nexmo->sms_token     = $request->sms_token;
                $nexmo->sms_from      = $request->sms_from;
                $nexmo->sms_number      = $request->sms_number;
                $nexmo->owner_id      = Auth::user()->id;
                $nexmo->save();
                
                notify()->success( Str::ucfirst($sms). ' ' . translate('Configured'));
                return back();

                break;

            case 'plivo':
                
                $plivo = Sms::firstOrNew(['sms_name' =>  $sms, 'owner_id' => Auth::user()->id]);
                $plivo->sms_name     = $sms;
                $plivo->sms_id        = $request->sms_id;
                $plivo->sms_token     = $request->sms_token;
                $plivo->sms_from      = $request->sms_from;
                $plivo->sms_number      = $request->sms_number;
                $plivo->owner_id      = Auth::user()->id;
                $plivo->save();
                
                notify()->success( Str::ucfirst($sms). ' ' . translate('Configured'));
                return back();

                break;
            
            default:
                notify()->success(translate('Failed Configured SMS'));
                return back();
                break;
            }
        } catch (\Throwable $th) {
            notify()->error(translate('Something went wrong'));
            return back();
        }
        
    }

    /**
    * test
    */

     public function test(Request $request, $sms)
     {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

        try {
            switch ($sms) {
            case 'twilio':

                $twilio = Sms::where('sms_name', 'twilio')->where('owner_id', Auth::user()->id)->first();

                $sid    = $twilio->sms_id;
                $token  = $twilio->sms_token;
                $client = new Client( $sid, $token );
                $client->messages->create(
                    env('TEST_CONNECTION_SMS'),
                    [
                        'from' => $twilio->sms_from,
                        'body' => 'Hello from Swagmail, Twilio is perfectly configured.',
                    ]
                );

                notify()->success(translate('Connection Secure'));
                smsLog(null, env('TEST_CONNECTION_SMS'), 'Test Message', $sms);

                return back();

                break;


            case 'nexmo':

                $nexmo = Sms::where('sms_name', 'nexmo')->where('owner_id', Auth::user()->id)->first();

                $basic  = new \Nexmo\Client\Credentials\Basic($nexmo->sms_id , $nexmo->sms_token);
                $client = new \Nexmo\Client($basic);

                $message = $client->message()->send([
                    'to' => env('TEST_CONNECTION_SMS'),
                    'from' => $nexmo->sms_number,
                    'text' => 'Hello from Swagmail, Nexmo is perfectly configured.'
                ]);

                notify()->success(translate('Connection Secure'));

                smsLog(null, env('TEST_CONNECTION_SMS'), 'Test Message', $sms);
                return back();

                break;


            case 'plivo':

                    $plivo = Sms::where('sms_name', 'plivo')->where('owner_id', Auth::user()->id)->first();

                    $client = new RestClient($plivo->sms_id, $plivo->sms_token);
                    $response = $client->messages->create(
                    '+15671234567', #src
                    [env('TEST_CONNECTION_SMS')], #dst
                    'Hello from '. org('company_name') .', Plivo is perfectly configured.', #text
                    ["url"=>"http://foo.com/sms_status/"],
                );

                notify()->success(translate('Connection Secure'));

                smsLog(null, env('TEST_CONNECTION_SMS'), 'Test Message', $sms);
                return back();

                break;
            
            default:
                notify()->error(translate('Connection Insecure'));
                return back();
                break;
        }
        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return back();
        }

     }


    //  SMSLOG

    public function smsLogs()
    {
        $logs = SmsLog::where('user_id', Auth::user()->id)->latest()->paginate(20);
        return view('sms_logs.index', compact('logs'));
    }


    /**
     * CAMPAIGN SMS
     */

     public function campaignSendSms($campaign_id, $sms_template_id, $gateway)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

        try {
            $campaignSMSs = CampaignEmail::where('campaign_id', $campaign_id)->with('emails')->get();

            $sms_built = SmsBuilder::where('id', $sms_template_id)->first();

        switch ($gateway) {
            case 'twilio':


                $twilio = Sms::where('owner_id', Auth::user()->id)->where('sms_name', 'twilio')->first();

                

                $sid    = $twilio->sms_id;
                $token  = $twilio->sms_token;
                $client = new Client( $sid, $token );

                foreach ($campaignSMSs as $campaignSMS) {
                    $client->messages->create(
                    '+' . $campaignSMS->emails->country_code . $campaignSMS->emails->phone,
                    [
                        'from' => $twilio->sms_from,
                        'body' => strip_tags($sms_built->body),
                    ]
                    );

                    smsLog($campaignSMS->id, $campaignSMS->emails->phone, strip_tags($sms_built->body), $gateway);
                }

                telling(route('log.sms'), translate('New SMS Camapaign With Twilio'));
                
                notify()->success(translate('Message Sent'));
                return back();

                break;


            case 'nexmo':

                $nexmo = Sms::where('owner_id', Auth::user()->id)->where('sms_name', 'nexmo')->first();

                $basic  = new \Nexmo\Client\Credentials\Basic($nexmo->sms_id, $nexmo->sms_token);
                $client = new \Nexmo\Client($basic);

                foreach ($campaignSMSs as $campaignSMS) {
                    $message = $client->message()->send([
                    'to'    => '+' . $campaignSMS->emails->country_code . $campaignSMS->emails->phone, // client number
                    'from'  => $nexmo->sms_from,
                    'text'  => strip_tags($sms_built->body)
                ]);
                    smsLog($campaignSMS->id, $campaignSMS->emails->phone, strip_tags($sms_built->body), $gateway);
                }

                telling(route('log.sms'), translate('New SMS Camapaign With Nexmo'));

                notify()->success(translate('Message Sent'));
                return back();

                break;

            case 'plivo':

                $plivo = Sms::where('owner_id', Auth::user()->id)->where('sms_name', 'plivo')->first();

                    $client = new RestClient($plivo->sms_id, $plivo->sms_token);

                    foreach ($campaignSMSs as $campaignSMS) {

                    $response = $client->messages->create(
                    $plivo->sms_number, #src
                    ['+' . $campaignSMS->emails->country_code . $campaignSMS->emails->phone], #dst
                    strip_tags($sms_built->body), #text
                    ["url"=>"http://foo.com/sms_status/"],
                );

                smsLog($campaignSMS->id, $campaignSMS->emails->phone, strip_tags($sms_built->body), $gateway);
                }

                telling(route('log.sms'), translate('New SMS Camapaign With Plivo'));
                notify()->success(translate('Message Sent'));

                return back();

                break;
            
            default:
                notify()->error(translate('Something went wrong. Check configuration'));
                return back();
                break;
        }
        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong. Check configuration'));
            return back();
        }

        

    }

    /**
     * smsCampaignAjax
     */

    public function smsCampaignAjax(Request $request)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }


        $sms_campaign_temlpate = Campaign::where('id', $request->sms_campaign_id)->first();
        $sms_campaign_temlpate->sms_template_id = $request->sms_template_id;
        $sms_campaign_temlpate->save();

        return response()->json('success', 200);;
    }

    /**
     * SHOW
     */

     function show($id)
     {
         try {
             $show_builder = SmsBuilder::where('id', $id)->first();
             return view('sms.show', compact('show_builder'));
         } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return back();
         }
     }

    /**
     * EDIT
     */

     function edit($id)
     {
         try {
             $edit_builder = SmsBuilder::where('id', $id)->first();
             return view('sms.edit', compact('edit_builder'));
         } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return back();
         }
     }

    /**
     * UPDATE
     */

     function update(Request $request, $id)
     {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

      $request->validate([
            'name' => 'required',
            'body' => 'required'
    ]);

         try {
             $update_builder = SmsBuilder::where('id', $id)->first();
        $update_builder->name = $request->name;
        $update_builder->body = $request->body;
        if ($request->status == 1) {
            $update_builder->status = true;
        }else{
            $update_builder->status = false;
        }

        $update_builder->user_id = Auth::user()->id;
        $update_builder->save();

        notify()->success(translate('SMS Template Updated Successfully'));
        return back();
         } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return back();
         }

        
     }


     
    /**
     * DESTROY
     */

     function destroy($id)
     {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

        try {
            SmsBuilder::where('id', $id)->delete();
            notify()->warning(translate('SMS Template Deleted Successfully'));
            return back();
        } catch (\Throwable $th) {
            Alert::error(translate('Whoops'), translate('Something went wrong'));
            return back();
        }
        
     }

    //END
}
