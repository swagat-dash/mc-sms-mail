<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\SmtpServer;
use App\Models\User;
use App\Models\EmailService;
use Auth;
use Mail;
use Swift_SmtpTransport;
use Swift_Mailer;

class SmtpController extends Controller
{

    public function index()
    {
        $gmail = EmailService::where('owner_id', Auth::user()->id)->where('provider_name', 'gmail')->first();
        $yahoo = EmailService::where('owner_id', Auth::user()->id)->where('provider_name', 'yahoo')->first();
        $webmail = EmailService::where('owner_id', Auth::user()->id)->where('provider_name', 'webmail')->first();
        $mailgun = EmailService::where('owner_id', Auth::user()->id)->where('provider_name', 'mailgun')->first();
        $zoho = EmailService::where('owner_id', Auth::user()->id)->where('provider_name', 'zoho')->first();
        $elastic = EmailService::where('owner_id', Auth::user()->id)->where('provider_name', 'elastic')->first();
        return view('smtp.index', compact('gmail', 'yahoo', 'webmail', 'mailgun', 'zoho', 'elastic'));
    }

    /**
     * configure
     */
    public function configure($mail)
    {
        $e_server = EmailService::where('provider_name', $mail)
                                ->where('owner_id', Auth::user()->id)
                                ->first();
        return view('smtp.configure', compact('mail','e_server'));
    }

    /**
     * store
     */
    public function store(Request $request, $mail)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

        try {
            switch ($mail) {
            case 'gmail':
                
                $gmail = EmailService::firstOrNew(['provider_name' =>  $mail, 'owner_id' => Auth::user()->id]);
                $gmail->owner_id = Auth::user()->id;
                $gmail->provider_name = $mail;
                $gmail->driver = $request->MAIL_MAILER;
                $gmail->host = $request->MAIL_HOST;
                $gmail->port = $request->MAIL_PORT;
                $gmail->username = $request->MAIL_USERNAME;
                $gmail->password = $request->MAIL_PASSWORD;
                $gmail->encryption = $request->MAIL_ENCRYPTION;
                $gmail->from = $request->MAIL_FROM_ADDRESS;
                $gmail->from_name = $request->MAIL_FROM_NAME;
                $gmail->save();

                telling(route('smtp.index'), translate('New SMTP Server Created'));
                
                notify()->success( Str::ucfirst($mail). ' ' . translate('Configured'));
                return back();

                break;

            case 'yahoo':

                $yahoo = EmailService::firstOrNew(['provider_name' =>  $mail, 'owner_id' => Auth::user()->id]);
                $yahoo->owner_id = Auth::user()->id;
                $yahoo->provider_name = $mail;
                $yahoo->driver = $request->MAIL_MAILER;
                $yahoo->host = $request->MAIL_HOST;
                $yahoo->port = $request->MAIL_PORT;
                $yahoo->username = $request->MAIL_USERNAME;
                $yahoo->password = $request->MAIL_PASSWORD;
                $yahoo->encryption = $request->MAIL_ENCRYPTION;
                $yahoo->from = $request->MAIL_FROM_ADDRESS;
                $yahoo->from_name = $request->MAIL_FROM_NAME;
                $yahoo->save();
                

                notify()->success( Str::ucfirst($mail). ' ' . translate('Configured'));
                return back();

                break;

            case 'webmail':

                $webmail = EmailService::firstOrNew(['provider_name' =>  $mail, 'owner_id' => Auth::user()->id]);
                $webmail->owner_id = Auth::user()->id;
                $webmail->provider_name = $mail;
                $webmail->driver = $request->MAIL_MAILER;
                $webmail->host = $request->MAIL_HOST;
                $webmail->port = $request->MAIL_PORT;
                $webmail->username = $request->MAIL_USERNAME;
                $webmail->password = $request->MAIL_PASSWORD;
                $webmail->encryption = $request->MAIL_ENCRYPTION;
                $webmail->from = $request->MAIL_FROM_ADDRESS;
                $webmail->from_name = $request->MAIL_FROM_NAME;
                $webmail->save();

                notify()->success( Str::ucfirst($mail). ' ' . translate('Configured'));
                return back();

                break;

            case 'mailgun':

                $mailgun = EmailService::firstOrNew(['provider_name' =>  $mail, 'owner_id' => Auth::user()->id]);
                $mailgun->owner_id = Auth::user()->id;
                $mailgun->provider_name = $mail;
                $mailgun->driver = $request->MAIL_MAILER;
                $mailgun->host = $request->MAIL_HOST;
                $mailgun->port = $request->MAIL_PORT;
                $mailgun->username = $request->MAIL_USERNAME;
                $mailgun->password = $request->MAIL_PASSWORD;
                $mailgun->encryption = $request->MAIL_ENCRYPTION;
                $mailgun->from = $request->MAIL_FROM_ADDRESS;
                $mailgun->from_name = $request->MAIL_FROM_NAME;
                $mailgun->save();

                notify()->success( Str::ucfirst($mail). ' ' . translate('Configured'));
                return back();

                break;

            case 'zoho':

                $zoho = EmailService::firstOrNew(['provider_name' =>  $mail, 'owner_id' => Auth::user()->id]);
                $zoho->owner_id = Auth::user()->id;
                $zoho->provider_name = $mail;
                $zoho->driver = $request->MAIL_MAILER;
                $zoho->host = $request->MAIL_HOST;
                $zoho->port = $request->MAIL_PORT;
                $zoho->username = $request->MAIL_USERNAME;
                $zoho->password = $request->MAIL_PASSWORD;
                $zoho->encryption = $request->MAIL_ENCRYPTION;
                $zoho->from = $request->MAIL_FROM_ADDRESS;
                $zoho->from_name = $request->MAIL_FROM_NAME;
                $zoho->save();

                notify()->success( Str::ucfirst($mail). ' ' . translate('Configured'));
                return back();

                break;

            case 'elastic':

                $elastic = EmailService::firstOrNew(['provider_name' =>  $mail, 'owner_id' => Auth::user()->id]);
                $elastic->owner_id = Auth::user()->id;
                $elastic->provider_name = $mail;
                $elastic->driver = $request->MAIL_MAILER;
                $elastic->host = $request->MAIL_HOST;
                $elastic->port = $request->MAIL_PORT;
                $elastic->username = $request->MAIL_USERNAME;
                $elastic->password = $request->MAIL_PASSWORD;
                $elastic->encryption = $request->MAIL_ENCRYPTION;
                $elastic->from = $request->MAIL_FROM_ADDRESS;
                $elastic->from_name = $request->MAIL_FROM_NAME;
                $elastic->save();

                notify()->success( Str::ucfirst($mail). ' ' . translate('Configured'));
                return back();

                break;
            
            default:
                notify()->success(translate('Failed Configured Mail'));
                return back();
                break;
            }
        } catch (\Throwable $th) {
            notify()->error(translate('Something went wrong'));
            return back();
        }

    }

    /**
     * set_default
     */
    public function set_default(Request $request, $mail)
    {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

        $status = EmailService::where('provider_name', $mail)->where('owner_id', Auth::user()->id)->first();
        $active = false;


        if ($status != null) {
            if ($status->active == 0) {
                $status->active = true;
                $active = true;
            } else {
                $status->active = false;
            }
            $status->save();

            /*deactivate all theme*/
            $providers = EmailService::where('owner_id', Auth::user()->id)->get();

            foreach ($providers as $provider) {
                if ($active) {
                    if ($provider->id != $status->id){
                        $provider->active = false;
                    }
                } else {
                    $provider->active = false;
                }
                $provider->save();
            }

            \Artisan::call('optimize:clear');
            notify()->success( Str::upper($mail). ' ' . translate('selected as default'));
            return back();
        } else {
            notify()->error( 'Whoops' . translate('Please Configure First'));
            return back();
        }
    }

    /**
    * test
    */

     public function test(Request $request)
     {

        if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

         try {

            // backup mailing configuration
            $backup = Mail::getSwiftMailer();

            // set mailing configuration
            $transport = new Swift_SmtpTransport(
                                        getUserActiveEmailDetails()->host, 
                                        getUserActiveEmailDetails()->port, 
                                        getUserActiveEmailDetails()->encryption
                                    );

            $transport->setUsername(getUserActiveEmailDetails()->username);
            $transport->setPassword(getUserActiveEmailDetails()->password);

            $swagmail = new Swift_Mailer($transport);

            // set mailtrap mailer
            Mail::setSwiftMailer($swagmail);

            Mail::send('testing.mail', [], function($message)
            {
                $message->from(getUserActiveEmailDetails()->from)
                        ->to(org('test_connection_email'), Str::ucfirst(activeEmailService()) . ' Test Connection')
                        ->subject(Str::ucfirst(activeEmailService()) . ' Test Connection');
            });

            // reset to default configuration
            Mail::setSwiftMailer($backup);

            notify()->success(translate('Connection Secure'));
            return back();
         } catch (\Throwable $th) {
            notify()->error(translate('Connection Insecure'));
            return back();
         }

     }

     /**
      * SystemSmtp
      */
      public function setAsSystemSmtp($mail)
      {
            if (env('DEMO_MODE') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

      $getAdmin = User::where('id', Auth::user()->id)->where('user_type', 'Admin')->select('id')->first();

        try {
            switch ($mail) {
            case 'gmail':

                $getAdminEmail = EmailService::where('owner_id', $getAdmin->id)->where('provider_name', 'gmail')->first();
                
                $gmail = SmtpServer::firstOrNew(['mail_name' =>  $mail]);
                $gmail->mail_name     = $mail;
                $gmail->mail_mailer     = $getAdminEmail->driver;
                $gmail->mail_host       = $getAdminEmail->host;
                $gmail->mail_port       = $getAdminEmail->port;
                $gmail->mail_username       = $getAdminEmail->username;
                $gmail->mail_password       = $getAdminEmail->password;
                $gmail->mail_encryption      = $getAdminEmail->encryption;
                $gmail->mail_from_address       = $getAdminEmail->from;
                $gmail->mail_from_name      = $getAdminEmail->from_name;
                

                if ($gmail->save()) {
                    overWriteEnvFile('DEFAULT_MAIL', $mail);
                    overWriteEnvFile('MAIL_MAILER', $gmail->mail_mailer);
                    overWriteEnvFile('MAIL_HOST', $gmail->mail_host);
                    overWriteEnvFile('MAIL_PORT', $gmail->mail_port);
                    overWriteEnvFile('MAIL_USERNAME', $gmail->mail_username);
                    overWriteEnvFile('MAIL_PASSWORD', $gmail->mail_password);
                    overWriteEnvFile('MAIL_ENCRYPTION', $gmail->mail_encryption);
                    overWriteEnvFile('MAIL_FROM_ADDRESS', $gmail->mail_from_address);
                    overWriteEnvFile('MAIL_FROM_NAME', $gmail->mail_from_name);

                    telling(route('smtp.index'), translate($mail . ' System SMTP Server Selected'));
                    notify()->success( Str::upper($mail). ' ' . translate('System Default Selected'));
                }
                
                return back();

                break;

            case 'yahoo':

                $getAdminEmail = EmailService::where('owner_id', $getAdmin->id)->where('provider_name', 'yahoo')->first();
                
                $yahoo = SmtpServer::firstOrNew(['mail_name' =>  $mail]);
                $yahoo->mail_name     = $mail;
                $yahoo->mail_mailer     = $getAdminEmail->driver;
                $yahoo->mail_host       = $getAdminEmail->host;
                $yahoo->mail_port       = $getAdminEmail->port;
                $yahoo->mail_username       = $getAdminEmail->username;
                $yahoo->mail_password       = $getAdminEmail->password;
                $yahoo->mail_encryption      = $getAdminEmail->encryption;
                $yahoo->mail_from_address   = $getAdminEmail->from;
                $yahoo->mail_from_name      = $getAdminEmail->from_name;

                if ($yahoo->save()) {
                    overWriteEnvFile('DEFAULT_MAIL', $mail);
                    overWriteEnvFile('MAIL_MAILER', $yahoo->mail_mailer);
                    overWriteEnvFile('MAIL_HOST', $yahoo->mail_host);
                    overWriteEnvFile('MAIL_PORT', $yahoo->mail_port);
                    overWriteEnvFile('MAIL_USERNAME', $yahoo->mail_username);
                    overWriteEnvFile('MAIL_PASSWORD', $yahoo->mail_password);
                    overWriteEnvFile('MAIL_ENCRYPTION', $yahoo->mail_encryption);
                    overWriteEnvFile('MAIL_FROM_ADDRESS', $yahoo->mail_from_address);
                    overWriteEnvFile('MAIL_FROM_NAME', $yahoo->mail_from_name);

                    telling(route('smtp.index'), translate($mail . ' System SMTP Server Selected'));
                    notify()->success( Str::upper($mail). ' ' . translate('System Default Selected'));
                }
                
                return back();

                break;

            case 'webmail':

                $getAdminEmail = EmailService::where('owner_id', $getAdmin->id)->where('provider_name', 'webmail')->first();
                
                $webmail = SmtpServer::firstOrNew(['mail_name' =>  $mail]);
                $webmail->mail_name     = $mail;
                $webmail->mail_mailer     = $getAdminEmail->driver;
                $webmail->mail_host       = $getAdminEmail->host;
                $webmail->mail_port       = $getAdminEmail->port;
                $webmail->mail_username       = $getAdminEmail->username;
                $webmail->mail_password       = $getAdminEmail->password;
                $webmail->mail_encryption      = $getAdminEmail->encryption;
                $webmail->mail_from_address   = $getAdminEmail->from;
                $webmail->mail_from_name      = $getAdminEmail->from_name;

                if ($webmail->save()) {
                    overWriteEnvFile('DEFAULT_MAIL', $mail);
                    overWriteEnvFile('MAIL_MAILER', $webmail->mail_mailer);
                    overWriteEnvFile('MAIL_HOST', $webmail->mail_host);
                    overWriteEnvFile('MAIL_PORT', $webmail->mail_port);
                    overWriteEnvFile('MAIL_USERNAME', $webmail->mail_username);
                    overWriteEnvFile('MAIL_PASSWORD', $webmail->mail_password);
                    overWriteEnvFile('MAIL_ENCRYPTION', $webmail->mail_encryption);
                    overWriteEnvFile('MAIL_FROM_ADDRESS', $webmail->mail_from_address);
                    overWriteEnvFile('MAIL_FROM_NAME', $webmail->mail_from_name);

                    telling(route('smtp.index'), translate($mail . ' System SMTP Server Selected'));
                    notify()->success( Str::upper($mail). ' ' . translate('System Default Selected'));
                }
                return back();

                break;

            case 'mailgun':

                $getAdminEmail = EmailService::where('owner_id', $getAdmin->id)->where('provider_name', 'mailgun')->first();
                
                $mailgun = SmtpServer::firstOrNew(['mail_name' =>  $mail]);
                $mailgun->mail_name     = $mail;
                $mailgun->mail_mailer     = $getAdminEmail->driver;
                $mailgun->mail_host       = $getAdminEmail->host;
                $mailgun->mail_port       = $getAdminEmail->port;
                $mailgun->mail_username       = $getAdminEmail->username;
                $mailgun->mail_password       = $getAdminEmail->password;
                $mailgun->mail_encryption      = $getAdminEmail->encryption;
                $mailgun->mail_from_address   = $getAdminEmail->from;
                $mailgun->mail_from_name      = $getAdminEmail->from_name;

                if ($webmail->save()) {
                    overWriteEnvFile('DEFAULT_MAIL', $mail);
                    overWriteEnvFile('MAIL_MAILER', $mailgun->mail_mailer);
                    overWriteEnvFile('MAIL_HOST', $mailgun->mail_host);
                    overWriteEnvFile('MAIL_PORT', $mailgun->mail_port);
                    overWriteEnvFile('MAIL_USERNAME', $mailgun->mail_username);
                    overWriteEnvFile('MAIL_PASSWORD', $mailgun->mail_password);
                    overWriteEnvFile('MAIL_ENCRYPTION', $mailgun->mail_encryption);
                    overWriteEnvFile('MAIL_FROM_ADDRESS', $mailgun->mail_from_address);
                    overWriteEnvFile('MAIL_FROM_NAME', $mailgun->mail_from_name);

                    telling(route('smtp.index'), translate($mail . ' System SMTP Server Selected'));
                    notify()->success( Str::upper($mail). ' ' . translate('System Default Selected'));
                }
                return back();

                break;

            case 'zoho':

                $getAdminEmail = EmailService::where('owner_id', $getAdmin->id)->where('provider_name', 'zoho')->first();
                
                $zoho = SmtpServer::firstOrNew(['mail_name' =>  $mail]);
                $zoho->mail_name     = $mail;
                $zoho->mail_mailer     = $getAdminEmail->driver;
                $zoho->mail_host       = $getAdminEmail->host;
                $zoho->mail_port       = $getAdminEmail->port;
                $zoho->mail_username       = $getAdminEmail->username;
                $zoho->mail_password       = $getAdminEmail->password;
                $zoho->mail_encryption      = $getAdminEmail->encryption;
                $zoho->mail_from_address   = $getAdminEmail->from;
                $zoho->mail_from_name      = $getAdminEmail->from_name;

                if ($zoho->save()) {
                    overWriteEnvFile('DEFAULT_MAIL', $mail);
                    overWriteEnvFile('MAIL_MAILER', $zoho->mail_mailer);
                    overWriteEnvFile('MAIL_HOST', $zoho->mail_host);
                    overWriteEnvFile('MAIL_PORT', $zoho->mail_port);
                    overWriteEnvFile('MAIL_USERNAME', $zoho->mail_username);
                    overWriteEnvFile('MAIL_PASSWORD', $zoho->mail_password);
                    overWriteEnvFile('MAIL_ENCRYPTION', $zoho->mail_encryption);
                    overWriteEnvFile('MAIL_FROM_ADDRESS', $zoho->mail_from_address);
                    overWriteEnvFile('MAIL_FROM_NAME', $zoho->mail_from_name);

                    telling(route('smtp.index'), translate($mail . ' System SMTP Server Selected'));
                    notify()->success( Str::upper($mail). ' ' . translate('System Default Selected'));
                }
                return back();

                break;

            case 'elastic':

                $getAdminEmail = EmailService::where('owner_id', $getAdmin->id)->where('provider_name', 'zoho')->first();
                
                $elastic = SmtpServer::firstOrNew(['mail_name' =>  $mail]);
                $elastic->mail_name     = $mail;
                $elastic->mail_mailer     = $getAdminEmail->driver;
                $elastic->mail_host       = $getAdminEmail->host;
                $elastic->mail_port       = $getAdminEmail->port;
                $elastic->mail_username       = $getAdminEmail->username;
                $elastic->mail_password       = $getAdminEmail->password;
                $elastic->mail_encryption      = $getAdminEmail->encryption;
                $elastic->mail_from_address   = $getAdminEmail->from;
                $elastic->mail_from_name      = $getAdminEmail->from_name;

                if ($elastic->save()) {
                    overWriteEnvFile('DEFAULT_MAIL', $mail);
                    overWriteEnvFile('MAIL_MAILER', $elastic->mail_mailer);
                    overWriteEnvFile('MAIL_HOST', $elastic->mail_host);
                    overWriteEnvFile('MAIL_PORT', $elastic->mail_port);
                    overWriteEnvFile('MAIL_USERNAME', $elastic->mail_username);
                    overWriteEnvFile('MAIL_PASSWORD', $elastic->mail_password);
                    overWriteEnvFile('MAIL_ENCRYPTION', $elastic->mail_encryption);
                    overWriteEnvFile('MAIL_FROM_ADDRESS', $elastic->mail_from_address);
                    overWriteEnvFile('MAIL_FROM_NAME', $elastic->mail_from_name);

                    telling(route('smtp.index'), translate($mail . ' System SMTP Server Selected'));
                    notify()->success( Str::upper($mail). ' ' . translate('System Default Selected'));
                }
                return back();

                break;
            
            default:
                notify()->success(translate('Failed Configured Mail'));
                return back();
                break;
            }
        } catch (\Throwable $th) {
            notify()->error(translate('Something went wrong'));
            return back();
        }
      }

    //END
}






