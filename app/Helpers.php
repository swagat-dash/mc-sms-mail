<?php


use App\Helpers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\OrganizationSetup;
use App\Models\EmailContact;
use App\Models\TemplateBuilder;
use App\Models\SmsBuilder;
use App\Models\EmailGroup;
use App\Models\EmailListGroup;
use App\Models\Campaign;
use App\Models\Job;
use App\Models\QueueMonitor;
use App\Models\Seo;
use App\Models\Sms;
use App\Models\MailLog;
use App\Models\SmsLog;
use App\Models\SmtpServer;
use App\Models\BouncedEmail;
use App\Models\UserSentLimitPlan;
use App\Models\UserSentRecord;
use App\Models\SubscriptionPlan;
use App\Models\PlanPurchased;
use App\Models\EmailSMSLimitRate;
use App\Models\ImportantNotice;
use App\Models\Language;
use App\Models\UserNotification;
use App\Models\CampaignLog;
use App\Models\CampaignEmail;
use App\Models\Frontend;
use App\Models\FrontendModule;
use App\Models\FrontendFeature;
use App\Models\Currency;
use App\Models\Country;
use App\Models\Queue;
use App\Models\FailedJob;
use App\Models\EmailService;

function formatCode($code)
{
    return str_replace('>', 'HTMLCloseTag', str_replace('<', 'HTMLOpenTag', $code));
}

/** User Type */

function admin()
{
    if (Auth::user()->user_type == 'Admin') {
        return true;
    }else{
        return false;
    }
}

function customer()
{
    if (Auth::user()->user_type == 'Customer') {
        return true;
    }else{
        return false;
    }
}



// layout
function layout()
{
    return 'side-menu';
}

// layout
function defaultMail($mail)
{
    if (env('DEFAULT_MAIL') == $mail) {
        return 'border border-theme-1';
    }else{
        return NULL;
    }

}

// layout
function defaultSMS($sms)
{
    if (env('DEFAULT_SMS') == $sms) {
        return 'border border-theme-1';
    }else{
        return NULL;
    }

}

/**
 * SmtpServer
 */

 function SmtpServer()
 {
     return SmtpServer::count();
 }

// username
function username()
{
    return Auth::user()->name;
}

// userId
function userId()
{
    return Auth::user()->id;
}

// userInfo
function userInfo()
{
    return User::where('id', Auth::user()->id)->with('personal')->first();
}

// avatar
function avatar()
{
    if (Auth::user()->photo != null) {
        return filePath(Auth::user()->photo);
    }else{
        return Avatar::create( Str::upper(username()) )->toBase64();
    }
}

// avatar
function emailAvatar($email)
{
    return Avatar::create( Str::upper($email) )->toBase64();
}

// avatar
function namevatar($name)
{
    return Avatar::create( Str::upper($name) )->toBase64();
}

// commonAvatar
function commonAvatar($name)
{
    return Avatar::create( Str::upper($name) )->toBase64();
}

// emailCount
function emailCount()
{
    return EmailContact::Active()->where('owner_id', Auth::user()->id)->whereNotNull('email')->count();
}

// emailCount
function phoneCount()
{
    return EmailContact::Active()->where('owner_id', Auth::user()->id)->whereNotNull('phone')->count();
}

// favCount
function favCount()
{
    return EmailContact::Favourite()->count();
}

// trashedCount
function trashedCount()
{
    return EmailContact::TrashedBin()->count();
}

// blockedCount
function blockedCount()
{
    return EmailContact::Blocked()->count();
}

// campaignCount
function campaignCount()
{
    return Campaign::Active()->where('owner_id', Auth::user()->id)->where('type', 'email')->count();
}

// SMScampaignCount
function SMScampaignCount()
{
    return Campaign::Active()->where('owner_id', Auth::user()->id)->where('type', 'sms')->count();
}

// emailGroupCount
function emailGroupCount()
{
    return EmailGroup::Active()->where('owner_id', Auth::user()->id)->where('type', 'email')->count();
}

// SMSGroupCount
function SMSGroupCount()
{
    return EmailGroup::Active()->where('owner_id', Auth::user()->id)->where('type', 'sms')->count();
}

// emailGroupCount
function templateCount()
{
    return TemplateBuilder::where('owner_id', Auth::user()->id)->count();
}


// emailGroupCount
function smsTemplateCount()
{
    return SmsBuilder::where('user_id', Auth::user()->id)->count();
}

// totalSentMail
function totalSentMail()
{
    return UserSentRecord::User()->count();
}

// totalSentMail
function totalSMSSent()
{
    return SmsLog::where('user_id', Auth::user()->id)->count();
}

// emailGroupCount
function queueCount()
{
    return Job::count();
}

// mailReach
function mailReach()
{
    return MailLog::where('opens', 1)->count();
}

// mailReach
function mailNoReach()
{
    return MailLog::where('opens', 0)->count();
}

// SmsLog
function smsLog($campaign_id, $number, $message, $gateway)
{
    $smsLog = new SmsLog();
    $smsLog->user_id = Auth::user()->id;
    $smsLog->campaign_id = $campaign_id;
    $smsLog->number = $number;
    $smsLog->message_id = Str::random(20);
    $smsLog->message = $message;
    $smsLog->gateway = $gateway;
    $smsLog->save();

    return $smsLog;
}

// QueueMonitor

function QueueMonitor($name)
{
    return QueueMonitor::where($name, 1)->count();
}

// failedJobs

function failedJobs()
{
    return DB::table('failed_jobs')->count();
}

// mailBounced

function mailBounced()
{
    return BouncedEmail::where('bounce', 0)->where('owner_id', Auth::user()->id)->count();
}

// totalTasks

function totalTasks()
{
    return 1;
}

// logo
function logo()
{
    $logo = OrganizationSetup::where('name', 'logo')->first();
    $company_name = OrganizationSetup::where('name', 'company_name')->first();

    if ($logo->value != null) {
        return filePath($logo->value);
    }else{
        return Avatar::create( Str::upper($company_name->value) )->toBase64();
    }
}

// favIcon
function favIcon()
{
    $favIcon = OrganizationSetup::where('name', 'favIcon')->first();
    $company_name = OrganizationSetup::where('name', 'company_name')->first();

    if ($favIcon->value != null) {
        return filePath($favIcon->value);
    }else{
        return Avatar::create( Str::upper($company_name->value) )->toBase64();
    }
}

// footerLogo
function footerLogo()
{
    $footerLogo = OrganizationSetup::where('name', 'footer_logo')->first();
    $company_name = OrganizationSetup::where('name', 'company_name')->first();

    if ($footerLogo->value != null) {
        return filePath($footerLogo->value);
    }else{
        return Avatar::create( Str::upper($company_name->value) )->toBase64();
    }
}

function swagmail()
{
    return asset('swagmail.png');
}

function swagmailLogo()
{
    return asset('icon.png');
}


/**
 * DB connection check
 */
function checkDBConnection()
{
   if(DB::connection()->getDatabaseName())
    {
        return true;
    }else{
        return false;
    }
}

// mailLogo
function mailLogo($name)
{
    return filePath('mail/' . $name . '.png');
}

// mailLogo
function smsLogo($name)
{
    return filePath('sms/' . $name . '.png');
}

function checkColor()
{
    return OrganizationSetup::where('name', 'color')->first();
}

// mailLogo
function color()
{

    $org = OrganizationSetup::where('name', 'color')->first();
    
    if ($org->value != null) {
        return $org->value;
    }else{
        return null;
    }
    
}

//org
function org($name)
{
    $org = OrganizationSetup::where('name', $name)->first();
    return $org->value;
}

//org
function active_lang($code)
{
    $org = OrganizationSetup::where('name', $code)->first();
    return $org->value;
}

/**
 * DEVELOPER MODE
 */

 function devtool()
 {
     $dev = OrganizationSetup::where('name','dev_mode')->first();

     if ($dev->value ==1) {
         return true;
        }else{
         return false;
     }
 }

//org
function seo($name)
{
    $seo = Seo::where('name', $name)->first();
    return $seo->value;
}

//orgName
function orgName()
{
    $orgName = OrganizationSetup::where('name', 'company_name')->first();
    return $orgName->value ?? 'Swagmail';
}

//orgEmail
function orgEmail()
{
    $orgName = OrganizationSetup::where('name', 'company_email')->first();
    return $orgName->value;
}

//orgPhone
function orgPhone()
{
    $orgName = OrganizationSetup::where('name', 'company_phone_number')->first();
    return $orgName->value;
}

//orgTel
function orgTel()
{
    $orgName = OrganizationSetup::where('name', 'company_tel_number')->first();
    return $orgName->value;
}

//orgName
function orgAddress()
{
    $orgName = OrganizationSetup::where('name', 'company_address')->first();
    return $orgName->value;
}

// flag
function flag($flag)
{
    return asset('assets/lang/'.$flag);
}

// country flag
function countryFlag()
{
    $flag = OrganizationSetup::where('name', 'default_language')->first()->value;
    return Language::where('code', $flag)->first()->image;
}

//this function for open Json file to read language json file
function openJSONFile($code)
{
    $jsonString = [];
    if (File::exists(base_path('resources/lang/' . $code . '.json'))) {
        $jsonString = file_get_contents(base_path('resources/lang/' . $code . '.json'));
        $jsonString = json_decode($jsonString, true);
    }
    return $jsonString;
}

//save the new language json file
function saveJSONFile($code, $data)
{
    ksort($data);
    $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents(base_path('resources/lang/' . $code . '.json'), stripslashes($jsonData));
}

//translate the key with json
function translate($key)
{
    $key = ucfirst(str_replace('_', ' ', $key));
    if (File::exists(base_path('resources/lang/en.json'))) {
        $jsonString = file_get_contents(base_path('resources/lang/en.json'));
        $jsonString = json_decode($jsonString, true);
        if (!isset($jsonString[$key])) {
            $jsonString[$key] = $key;
            saveJSONFile('en', $jsonString);
        }
    }
    return __($key);
}


//scan directory for load flag
function readFlag()
{
    $dir = base_path('public/assets/lang');
    $file = scandir($dir);
    return $file;
}


//auto Rename Flag
function flagRenameAuto($name)
{
    $nameSubStr = substr($name, 8);
    $nameReplace = ucfirst(str_replace('_', ' ', $nameSubStr));
    $nameReplace2 = ucfirst(str_replace('.png', '', $nameReplace));
    return $nameReplace2;
}


function defaultCurrency()
{

    $sc = session('currency');
    if ($sc != null) {
        $id = $sc;
    } else {
        $id = (int)getSystemSetting('default_currencies')->value;
    }

    $currency = Currency::find($id);
    return $currency->code;
}

//format the Price
function formatPrice($price)
{
    $sc = session('currency');
    if ($sc != null) {
        $id = $sc;
    } else {
        $id = (int)getSystemSetting('default_currencies')->value;
    }

    $currency = Currency::find($id);
    $p =$price * $currency->rate;
    return $currency->align == 0 ? number_format($p, 0) . $currency->symbol :  $currency->symbol . number_format($p, 0);
}

//format the Price
function noFormatPrice($huh)
{
    $x = session('currency');
    if($x != null){
        $ids = $x;
    }else{
        $ids = (int)getSystemSetting('default_currencies')->value;
    }

    $currency = Currency::find($ids);
    $p =$huh * $currency->rate;

    return $p;
}

//format the Price Code
function formatPriceCode()
{
    $priceCode = session('currency');
    $currency = Currency::find($priceCode);
    return $currency->code;
}

function getPriceRate($code)
{
    $getPriceCode = Currency::where('code', $code)->first();
    return $getPriceCode->rate;
}

/*only price for payment*/
function onlyPrice($price)
{
    $sc = session('currency');
    if ($sc != null) {
        $id = $sc;
    } else {
        $id = (int)getSystemSetting('default_currencies')->value;
    }

    $currency = Currency::find($id);
    $p = $price * $currency->rate;
    return $p;

}


function PaytmPrice($price)
{

    switch (activeCurrency()) {
        case 'USD':
            return noFormatPrice($price) * getPriceRate('INR');
            break;

        case 'BDT':
            return noFormatPrice($price) / getPriceRate(activeCurrency()) * getPriceRate('INR');
            break;
        case 'INR':
            return noFormatPrice($price) / getPriceRate(activeCurrency()) * getPriceRate('INR');
            break;
        case 'LKR':
            return noFormatPrice($price) / getPriceRate(activeCurrency()) * getPriceRate('INR');
            break;
        case 'PKR':
            return noFormatPrice($price) / getPriceRate(activeCurrency()) * getPriceRate('INR');
            break;
        case 'NPR':
            return noFormatPrice($price) / getPriceRate(activeCurrency()) * getPriceRate('INR');
            break;
        case 'ZAR':
            return noFormatPrice($price) / getPriceRate(activeCurrency()) * getPriceRate('INR');
            break;
        case 'JPY':
            return noFormatPrice($price) / getPriceRate(activeCurrency()) * getPriceRate('INR');
            break;
        case 'KRW':
            return noFormatPrice($price) / getPriceRate(activeCurrency()) * getPriceRate('INR');
            break;
        case 'IDR':
            return noFormatPrice($price) / getPriceRate(activeCurrency()) * getPriceRate('INR');
            break;
        case 'AED':
            return noFormatPrice($price) / getPriceRate(activeCurrency()) * getPriceRate('INR');
            break;
        case 'TRY':
            return noFormatPrice($price) / getPriceRate(activeCurrency()) * getPriceRate('INR');
            break;

        default:
            # code...
            break;
    }
}

function StripePrice($stripePrice)
{

    switch (activeCurrency()) {
        case 'USD':
            return noFormatPrice($stripePrice);
            break;
        case 'BDT':
            return noFormatPrice($stripePrice) / getPriceRate(activeCurrency());
            break;
        case 'INR':
            return noFormatPrice($stripePrice) / getPriceRate(activeCurrency());
            break;
        case 'LKR':
            return noFormatPrice($stripePrice) / getPriceRate(activeCurrency());
            break;
        case 'PKR':
            return noFormatPrice($stripePrice) / getPriceRate(activeCurrency());
            break;
        case 'NPR':
            return noFormatPrice($stripePrice) / getPriceRate(activeCurrency());
            break;
        case 'ZAR':
            return noFormatPrice($stripePrice) / getPriceRate(activeCurrency());
            break;
        case 'JPY':
            return noFormatPrice($stripePrice) / getPriceRate(activeCurrency());
            break;
        case 'KRW':
            return noFormatPrice($stripePrice) / getPriceRate(activeCurrency());
            break;
        case 'IDR':
            return noFormatPrice($stripePrice) / getPriceRate(activeCurrency());
            break;
        case 'AED':
            return noFormatPrice($stripePrice) / getPriceRate(activeCurrency());
            break;
        case 'TRY':
            return noFormatPrice($stripePrice) / getPriceRate(activeCurrency());
            break;

        default:
            # code...
            break;
    }
}

function PaypalPrice($PaypalPrice)
{
    switch (activeCurrency()) {
        case 'USD':
            return noFormatPrice($PaypalPrice);
            break;
        case 'BDT':
            return noFormatPrice($PaypalPrice) / getPriceRate(activeCurrency());
            break;
        case 'INR':
            return noFormatPrice($PaypalPrice) / getPriceRate(activeCurrency());
            break;
        case 'LKR':
            return noFormatPrice($PaypalPrice) / getPriceRate(activeCurrency());
            break;
        case 'PKR':
            return noFormatPrice($PaypalPrice) / getPriceRate(activeCurrency());
            break;
        case 'NPR':
            return noFormatPrice($PaypalPrice) / getPriceRate(activeCurrency());
            break;
        case 'ZAR':
            return noFormatPrice($PaypalPrice) / getPriceRate(activeCurrency());
            break;
        case 'JPY':
            return noFormatPrice($PaypalPrice) / getPriceRate(activeCurrency());
            break;
        case 'KRW':
            return noFormatPrice($PaypalPrice) / getPriceRate(activeCurrency());
            break;
        case 'AED':
            return noFormatPrice($PaypalPrice) / getPriceRate(activeCurrency());
            break;
        case 'IDR':
            return noFormatPrice($PaypalPrice) / getPriceRate(activeCurrency());
            break;
        case 'TRY':
            return noFormatPrice($PaypalPrice) / getPriceRate(activeCurrency());
            break;

        default:
            # code...
            break;
    }
}

/*Active Currency*/
function activeCurrency()
{
    $sc = session('currency');
    if ($sc != null) {
        $id = $sc;
    } else {
        $id = (int)getSystemSetting('default_currencies')->value;
    }

    $currency = Currency::find($id);
    return $currency->code;
}

/*Active Currency*/
function activeCurrencySymbol()
{
    $sc = session('currency');
    if ($sc != null) {
        $id = $sc;
    } else {
        $id = (int)getSystemSetting('default_currencies')->value;
    }

    $currency = Currency::find($id);
    return $currency->symbol;
}

//override or add env file or key
function overWriteEnvFile($type, $val)
{
    $path = base_path('.env');
    if (file_exists($path)) {
        $val = '"' . trim($val) . '"';
        if (is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0) {
            file_put_contents($path, str_replace($type . '="' . env($type) . '"', $type . '=' . $val, file_get_contents($path)));
        } else {
            file_put_contents($path, file_get_contents($path) . "\r\n" . $type . '=' . $val);
        }
    }
}


//get system setting data
function getSystemSetting($key)
{
    return OrganizationSetup::where('name', $key)->first();
}

//Get file path
//path is storage/app/
function filePath($file)
{
    return asset($file);
}

//delete file
function fileDelete($file)
{
    if ($file != null) {
        if (file_exists(public_path($file))) {
            unlink(public_path($file));
        }
    }
}

//uploads file
// uploads/folder
function fileUpload($file, $folder)
{
    return $file->store('uploads/' . $folder);
}

// cookie time day
function cookiesLimit()
{
    $days = (int)getSystemSetting('cookies_limit')->value;
    /*return day*/

    return ($days * 1440);
}

/*default template*/
function emailTemplates()
{
    return TemplateBuilder::where('owner_id', Auth::user()->id)->get();
}

/*default template*/
function smsTemplates()
{
    return SmsBuilder::where('user_id', Auth::user()->id)->get();
}


/*emailGroups*/
function emailGroups($type)
{
    return EmailGroup::where('owner_id', Auth::user()->id)->where('type', $type)->get();
}

/*emailGroupEmails*/
function emailGroupEmails($group_id)
{
    return EmailListGroup::where('email_group_id', $group_id)->get();
}


// EMAILS REPORT :: START ------------------------------------------------------------------------------------------------------------------


/**
 * Get Month Wise Current Year Data
 */

 function sentMailMonthWiseCurrentYearData()
 {
     return UserSentRecord::where('owner_id', Auth::user()->id)->select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTHNAME(created_at) as monthname"))
                                                        ->whereYear('created_at', date('Y'))
                                                        ->orderByRaw('DATE_FORMAT(created_at, "%m-%d")')
                                                        ->groupBy('monthname')
                                                        ->get();
 }

 /**
  * Get Current Month Data
  */

  function sentMailCurrentMonthData()
  {
        return UserSentRecord::where('owner_id', Auth::user()->id)->whereMonth('created_at', date('m'))
                        ->whereYear('created_at', date('Y'))
                        ->count();
  }

 /**
  * Get Last Month records
  */

  function sentMailLastMonthData()
  {
        return UserSentRecord::where('owner_id', Auth::user()->id)->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count();
  }


// EMAILS REPORT :: END -------------------------------------------------------------------------------------------------------------------


// SMS REPORT :: START --------------------------------------------------------------------------------------------------------------------

/**
 * Twilio
 */
 function sentSMSMonthWiseCurrentYearDataTwilio()
 {
     return SmsLog::where('user_id', Auth::user()->id)->select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTHNAME(created_at) as monthname"))
                                                        ->whereYear('created_at', date('Y'))
                                                        ->orderByRaw('DATE_FORMAT(created_at, "%m-%d")')
                                                        ->where('gateway', 'twilio')
                                                        ->groupBy('monthname')
                                                        ->get();
 }

 function sentSMSMonthWiseCurrentYearData()
 {
     return SmsLog::where('user_id', Auth::user()->id)->select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTHNAME(created_at) as monthname"))
                                                        ->whereYear('created_at', date('Y'))
                                                        ->orderByRaw('DATE_FORMAT(created_at, "%m-%d")')
                                                        ->groupBy('monthname')
                                                        ->get();
 }

 /**
  * Nexmo
  */
 function sentSMSMonthWiseCurrentYearDataNexmo()
 {
     return SmsLog::where('user_id', Auth::user()->id)
                    ->select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTHNAME(created_at) as monthname"))
                    ->whereYear('created_at', date('Y'))
                    ->orderByRaw('DATE_FORMAT(created_at, "%m-%d")')
                    ->where('gateway', 'nexmo')
                    ->groupBy('monthname')
                    ->get();
 }

 /**
  * Plivo
  */
 function sentSMSMonthWiseCurrentYearDataPlivo()
 {
     return SmsLog::where('user_id', Auth::user()->id)
                    ->select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTHNAME(created_at) as monthname"))
                    ->whereYear('created_at', date('Y'))
                    ->orderByRaw('DATE_FORMAT(created_at, "%m-%d")')
                    ->where('gateway', 'plivo')
                    ->groupBy('monthname')
                    ->get();
 }

 /**
  * Get Current Month Data
  */

  function sentSMSCurrentMonthData()
  {
        return SmsLog::where('user_id', Auth::user()->id)
                        ->whereMonth('created_at', date('m'))
                        ->whereYear('created_at', date('Y'))
                        ->count();
  }

 /**
  * Get Last Month records
  */

  function sentSMSLastMonthData()
  {
        return SmsLog::where('user_id', Auth::user()->id)->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count();
  }

// SMS REPORT :: END ----------------------------------------------------------------------------------------------------------------------

/**
 * TOTAL EMAILS
 */

 /**
  * Get Current Month Data
  */

  function totalMailCurrentMonthData()
  {
        return EmailContact::whereMonth('created_at', date('m'))
                        ->whereYear('created_at', date('Y'))
                        ->count();
  }

 /**
  * Get Last Month records
  */

  function totalMailLastMonthData()
  {
        return EmailContact::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count();
  }

/**
 * LAST SENT EMAIL
 */

 function lastSentMails($paginate)
 {
     return bouncedEmail::where('owner_id', Auth::user()->id)->latest()->paginate($paginate);
 }

/**
 * LAST SENT SMS
 */

 function lastSentSMS($paginate)
 {
     return SmsLog::where('user_id', Auth::user()->id)->latest()->paginate($paginate);
 }


/**
 * PERCENTAGE MATH ------------------------------------------------------------------------------------------------------------------------
 */

 function getPercentageChange($newNumber, $oldNumber){

        if($oldNumber != 0){
            $decreaseValue = $oldNumber - $newNumber;
            return ($decreaseValue / $oldNumber) * 100;
        }else{
            return $oldNumber = 0;
        }
}

/**
 * CHECK HIGHER LOWER THAN
 */

 function checkHigherLowerThan($newNumber, $oldNumber)
 {
     if ($oldNumber < $newNumber) {
         return translate('Higher than last month');
        }else{
         return translate('Lower than last month');
     }
 }

 /**
  * CHECK HIGHER LOWER THAN ADD CLASS
  */

 function checkHigherLowerThanAddClass($newNumber, $oldNumber)
 {
     if ($oldNumber < $newNumber) {
         return 'bg-theme-6';
        }else{
         return 'bg-theme-9';
     }
 }

 function checkHigherLowerThanAddIcon($newNumber, $oldNumber)
 {
     if ($oldNumber < $newNumber) {
         return 'chevron-up';
        }else{
         return 'chevron-down';
     }
 }


 /**
  * countSubscriptionPlan
  */

  function countSubscriptionPlan()
  {
      return SubscriptionPlan::where('status', 1)->count();
  }

  function displaySubscriptionPlan()
  {
      return SubscriptionPlan::where('status', 1)->where('display', 1)->count();
  }


/**
 * PERCENTAGE MATH:END --------------------------------------------------------------------------------------------------------------------
 */

 /**
  * userSubscriptionPlan
  */

  function userSubscriptionPlan()
  {
      UserSentLimitPlan::User()->Active()->first();
  }

 /**
  * EMAIL LIMIT
  */

  function userSubscriptionLimit($user)
  {
      return EmailSMSLimitRate::where('status', 1)->where('owner_id', $user)->first();
  }

 /**
  * EMAIL LIMIT EXPIRED
  */

  function expiredCheck()
  {
      return EmailSMSLimitRate::ExpiredCheck()->first();
  }

 /**
  * Check Status
  */

  function LimitStatus()
  {

        $statusFalse = EmailSMSLimitRate::UserCheck()->first()->status;

        if ($statusFalse == 1) {
            return true;
        }else{
            return false;
        }

  }

  /**
   * DATE LIMIT
   */

   function dateLimitCheck()
   {
        $dateCheck = EmailSMSLimitRate::Active()->whereDate('to', '>', Carbon::now())->first();
        if ($dateCheck) {
            return true;
        }else{
            return false;
        }
   }

 /**
  * LIMIT CHECK
  */

  function emailLimitCheck($user)
  {
    try {
        if (userSubscriptionLimit($user)->email > 0 && dateLimitCheck() && LimitStatus()) {
            return true;
        }else{
            return false;
        }
    } catch (\Throwable $th) {
        return redirect()->route('dashboard');
    }
  }

  function SMSLimitCheck($user)
  {
    try {
        if (userSubscriptionLimit($user)->sms > 0 && dateLimitCheck()) {
            return true;
        }else{
            return false;
        }
      } catch (\Throwable $th) {
        return redirect()->route('dashboard');
    }
  }

  /**
   * FREE DATE LIMIT
   */

    function freeDateLimitCheck($plan_name)
    {
        $freeDateLimitCheck = UserSentLimitPlan::where('owner_id', Auth::user()->id)->where('plan_name', $plan_name)->where('status', 1)->first();

        if ($freeDateLimitCheck != null) {
            return true;
        }else{
            return false;
        }
    }



   function availableEmailPerUser($user_id)
   {
       return  EmailSMSLimitRate::where('status', 1)->where('owner_id', $user_id)->first()->email;
   }


    function usedEmailPerUser($user_id)
   {
        $plan_from = EmailSMSLimitRate::where('status', 1)->where('owner_id', $user_id)->first()->from;
        $cost_email = UserSentRecord::where('owner_id', $user_id)
                                    ->where('created_at', '>=' ,$plan_from)->count();
        return $cost_email;
   }

  /**
  * EMAAIL LIMIT PERCENTAGE
  */

  function emailLimitCheckPercentage($user)
  {
    $limit = userSubscriptionLimit($user) ?? null;

    if ($limit != null) {

        if (userSubscriptionLimit($user)->email <= 0) {
           return 0;
        }else{
            $substract = availableEmailPerUser($user) - usedEmailPerUser($user);
            $divide = $substract / availableEmailPerUser($user);
            $emailLeft = $divide * 100;
            return $emailLeft;
        }

    }else{
        return 1;
    }

  }

  /**
  * SMS LIMIT PERCENTAGE
  */



   function availableSMSPerUser($user_id)
   {
       return  EmailSMSLimitRate::where('status', 1)->where('owner_id', $user_id)->first()->sms;
   }


    function usedSMSPerUser($user_id)
   {
        $plan_from = EmailSMSLimitRate::where('status', 1)->where('owner_id', $user_id)->first()->from;
        $cost_email = UserSentRecord::where('owner_id', $user_id)
                                    ->where('created_at', '>=' ,$plan_from)->count();
        return $cost_email;
   }


  function smsLimitCheckPercentage($user)
  {
    $limit = userSubscriptionLimit($user) ?? null;

    if ($limit != null) {

        if (userSubscriptionLimit($user)->sms <= 0) {
           return 0;
        }else{
            $substract = availableSMSPerUser($user) - usedSMSPerUser($user);
            $divide = $substract / availableSMSPerUser($user);
            $smsLeft = $divide * 100;
            return $smsLeft;
        }

    }else{
        return 1;
    }

  }

  /**
   * SMS LIMIT PROGRESSBAR
   */



      function smsLimitProgressBar($user)
      {

          $eLimit = smsLimitCheckPercentage($user);

          switch ($eLimit) {
              case $eLimit >= 100:
                  return 'w-full bg-theme-9';
                  break;
              case $eLimit >= 90:
                  return 'w-11/12 bg-theme-9';
                  break;
              case $eLimit >= 80:
                  return 'w-4/5 bg-theme-9';
                  break;
              case $eLimit >= 70:
                  return 'w-3/4 bg-theme-9';
                  break;
              case $eLimit >= 60:
                  return 'w-2/3 bg-theme-1';
                  break;
              case $eLimit >= 50:
                  return 'w-1/2 bg-theme-1';
                  break;
              case $eLimit >= 30:
                  return 'w-1/3 bg-theme-12';
                  break;
              case $eLimit >= 25:
                  return 'w-1/4 bg-theme-12';
                  break;
              case $eLimit >= 10:
                  return 'w-1/12 bg-theme-6';
                  break;
              case $eLimit <= 10:
                  return 'w-0 bg-theme-6';
                  break;

              default:
                  # code...
                  break;
          }
      }

  /**
   * EMAIL LEFT
   */

   function availableEmail()
   {
       $availableEmail = EmailSMSLimitRate::Active()->first()->email;
       return $availableEmail;
   }


   function usedEmail()
   {
        $plan_from = EmailSMSLimitRate::Active()->first()->from;
        $cast_email = UserSentRecord::where('owner_id', Auth::user()->id)
                                    ->where('created_at', '>=' ,$plan_from)->count();
        return $cast_email;
   }



   function emailLeftCount()
   {
       return $emailLeft = availableEmail();
   }

   function emailLeft()
   {
       if (totalSentMail() <= 0) {
           return availableEmail() ;
       }else{
           return $emailsLeft = totalSentMail() / totalSentMail() ;
       }
   }

  /**
   * SMS LEFT
   */

   function availableSMS()
   {
       $availableSMS = EmailSMSLimitRate::Active()->first()->sms;
       return $availableSMS;
   }

   function usedSMS()
   {
        $plan_from_sms = EmailSMSLimitRate::Active()->first()->from;
        $cast_sms = SmsLog::where('user_id', Auth::user()->id)
                                    ->where('created_at', '>=' ,$plan_from_sms)->count();
        return $cast_sms;
   }

   function smsLeftCount()
   {
       return $smsLeft = availableSMS();
   }

    function smslLeft()
    {
        if (totalSMSSent() <= 0) {
                return availableSMS();
        }else{
            $left = EmailSMSLimitRate::Active()->first()->sms;
                return $emaislLeft = availableSMS() / totalSMSSent() ;
        }
    }


  /**
   * SUBSCRIPTION
   */

   function displaySubscriptions()
   {
        return SubscriptionPlan::where('status', 1)
                                ->where('display', 1)
                                ->get();
   }

   function subscriptions($name)
   {
       if (Auth::user()->user_type == 'Admin') {
           return SubscriptionPlan::where('name', $name)->get();
        }else{
           return SubscriptionPlan::where('name', $name)->Active()->get();
       }
   }

  /**
   * SUBSCRIPTION NAME
   */

   function subscriptionName($id)
   {
           return SubscriptionPlan::where('id', $id)->first()->name;
   }

   /**
    * CHECK SUBSCRIPTION
    */

    function checkSubscription($plan_id)
    {
        $checkSubscription = PlanPurchased::where('user_id', Auth::user()->id)->where('plan_id', $plan_id)->first();

        if ($checkSubscription != null) {
            return translate('Renew This Plan With PayPal');
        }else{
            return translate('Purchase With PayPal');
        }
    }


    /**
     * CheckPlanExist
     */

    function CheckPlanExist()
    {
        return UserSentLimitPlan::Active()->whereDate('to', '>', Carbon::now())->first();
    }

    /**
     * DEFAULT TEMPLATE
     */

     function defaultTemplate()
     {
         return TemplateBuilder::where('id', 1)->first();
     }

     /**
      * PROGRESS BAR
      */

      function emailLimitProgressBar($user)
      {

          $eLimit = emailLimitCheckPercentage($user);

          switch ($eLimit) {
              case $eLimit >= 100:
                  return 'w-full bg-theme-9';
                  break;
              case $eLimit >= 90:
                  return 'w-11/12 bg-theme-9';
                  break;
              case $eLimit >= 80:
                  return 'w-4/5 bg-theme-9';
                  break;
              case $eLimit >= 70:
                  return 'w-3/4 bg-theme-9';
                  break;
              case $eLimit >= 60:
                  return 'w-2/3 bg-theme-1';
                  break;
              case $eLimit >= 50:
                  return 'w-1/2 bg-theme-1';
                  break;
              case $eLimit >= 30:
                  return 'w-1/3 bg-theme-12';
                  break;
              case $eLimit >= 25:
                  return 'w-1/4 bg-theme-12';
                  break;
              case $eLimit >= 10:
                  return 'w-1/12 bg-theme-6';
                  break;
              case $eLimit <= 10:
                  return 'w-0 bg-theme-6';
                  break;

              default:
                  # code...
                  break;
          }

      }


      /**
       * NOTES
       */

       function notes()
       {
           $notes = ImportantNotice::Active()->latest()->get();
           return $notes;
       }


       /**
        * CAMPAIGNS
        */

        function campaingEmails()
        {
            return EmailContact::Active()->where('owner_id', Auth::user()->id)->whereNotNull('email')->latest()->get();
        }

        function campaingSMS()
        {
            return EmailContact::Active()->where('owner_id', Auth::user()->id)->whereNotNull('phone')->latest()->get();
        }

        /**
         * SERVER ERROR
         */

         function serverError()
         {
             return app('Illuminate\Http\Response')->status();
         }

         /**
          * MEMORY UEAGE
          */

        function convert($size)
        {
            $unit=array('b','kb','mb','gb','tb','pb');
            return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
        }

        /**
         * Language
         */

         function languages()
         {
             return Language::all();
         }

        /**
         * Bounced
         */

         function bounced()
         {
             return BouncedEmail::Bounced()->where('owner_id', Auth::user()->id)->latest()->paginate(20);
         }


         /**
          * INVOICE NUMBER
          */

          function invoiceNumber()
          {
            return date('Y').rand(1000, 10000);
          }

          /**
           * GET USER
           */

           function getUser($id)
           {
               return User::where('id', $id)->first();
           }
          /**
           * CHECK USER
           */

           function checkUser($email)
           {
               return User::where('email', $email)->first();
           }

           /**
            * PLAN ID
            */

            function planPurchase($id)
            {
                return PlanPurchased::where('id', $id)->first();
            }

           /**
            * GET PLAN DETAILS
            */

            function planDetails($id)
            {
                return SubscriptionPlan::where('id', $id)->first();
            }


            /**
             * USER NOTIFICATIONS
             */

            function telling($link, $message)
            {
                $tell = new UserNotification();
                $tell->owner_id = Auth::user()->id;
                $tell->link = $link ?? null;
                $tell->message = $message ?? null;
                $tell->save();
            }

            /**
             * NOTIFICATIONS
             */

            function notifications()
            {
               if (Auth::check()) {
                   return UserNotification::where('owner_id', Auth::user()->id)->latest()->paginate(10);
               }else{
                   return 0;
               }
            }

            /**
             * CAMPAIGN LOG
             */

             function campaignLog($campaign_id, $campaign_name, $message)
             {
                $campaignLog = new CampaignLog();
                $campaignLog->owner_id = Auth::user()->id;
                $campaignLog->campaign_id = $campaign_id;
                $campaignLog->campaign_name = $campaign_name;
                $campaignLog->message = $message ?? null;
                $campaignLog->save();
             }

             function campaignlogs()
             {
                return CampaignLog::where('owner_id', Auth::user()->id)->latest()->paginate(30);
             }

            function getCampaignName($id)
             {
                 return Campaign::where('id', $id)->first();
             }

            function getCampaignEmails($campaign_id)
             {
                 return CampaignEmail::where('campaign_id', $campaign_id)->count();
             }

            function listCampaignEmails($campaign_id)
             {
                 return CampaignEmail::where('campaign_id', $campaign_id)->get();
             }

             function invoice_path($file)
             {
                 return public_path('invoice_pdf/' . $file .'.pdf');
             }

             /**
              * PURCHASED PLANS
              */

              function purchased($page)
              {
                  if (Auth::user()->user_type == 'Admin') {
                      return PlanPurchased::latest()->paginate($page);
                  }else{
                      return PlanPurchased::where('user_id', Auth::user()->id)->latest()->paginate($page);
                  }
              }

              /**
               * MOST USED PAYMENT
               */

               function mostUsedGateway($gateway)
               {
                   if (Auth::user()->user_type == 'Admin') {
                      return PlanPurchased::where('gateway', $gateway)->where('status', 1)->count();
                  }else{
                      return PlanPurchased::where('user_id', Auth::user()->id)->where('gateway', $gateway)->where('status', 1)->count();
                  }
               }

/**
 * EARNING
 */

 /**
 * Get Month Wise Current Year Data
 */

 function monthWiseEarnings()
 {
     return PlanPurchased::where('status', 1)->select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTHNAME(created_at) as monthname"),DB::raw('SUM(price) as total_amount'))
                                                        ->whereYear('created_at', date('Y'))
                                                        ->orderByRaw('DATE_FORMAT(created_at, "%m-%d")')
                                                        ->groupBy('monthname')
                                                        ->get();
 }

 /**
 * Total Earned
 */

 function totalEarned()
 {
     return PlanPurchased::where('status', 1)
                            ->sum('price');
 }

 /**
  * weeklyTopSenders
  */

  function weeklyTopSenders()
  {

    $last7days = Carbon::now();
    $last7days->subDays(7);

    return BouncedEmail::select('owner_id')
            ->groupBy('owner_id')
            ->orderByRaw('COUNT(*) DESC')
            ->whereDate('created_at', '>=', $last7days)
            ->take(10)
            ->get();
  }

 /**
  * weeklyTopSendersRecord
  */

  function weeklyTopSendersRecord($id)
  {

    return BouncedEmail::where('owner_id', $id)->count();
  }

  /**
   * THEME
   */

   function theme()
   {
        $theme = env('ACTIVE_THEME');

        if ($theme != null) {
            return $theme;
        }else{
            return 'neon';
        }
   }


   /**
    * FRONTEND
    */

    function frontend($data)
    {
        return Frontend::where('label', $data)->first()->value;
    }
    /**
     * MODULE
     */
    function frontendModule($module)
    {
        return FrontendModule::where('label', $module)->first();
    }
    /**
     * FEATURES
     */
    function frontendFeatures($features)
    {
        return FrontendFeature::where('label', $features)->first();
    }

/**
 * IMAGES FOR AUTH
 */

   function ImageForAuth($folder)
  {
    $path = public_path('auth/' . $folder);
    $files = File::files($path);
    return $randomFile = $files[rand(0, count($files) - 1)]->getRelativePathname();
  }

  /**
   * GET IMAGE
   */

   function getImageForAuth($path)
   {
       return asset( 'auth/' . $path . '/' . ImageForAuth($path));
   }

   /**
    * NOT FOUND
    */

    function notFound($image)
    {
        return asset('not_found/'. $image);
    }

    /**
     * INSTALLER
     */

     function versionOfPhp()
     {
         return number_format((float)phpversion(), 2, '.', '');
     }


     /**
      * totalExpense
      */

      function totalExpense()
      {
          return PlanPurchased::where('user_id', Auth::user()->id)->where('status', 1)->sum('price');
      }

     /**
      * lastPurchasedPlan
      */

      function lastPurchasedPlan()
      {
          return PlanPurchased::where('user_id', Auth::user()->id)->where('status', 1)->latest()->first();
      }

     /**
      * totalCustomer
      */

      function totalCustomer()
      {
          return User::where('user_type', 'Customer')->count();
      }

     /**
      * totalPurchased
      */

      function totalPurchased()
      {
          return PlanPurchased::where('status', 1)->count();
      }


    // totalSentMail
    function totalSystemSentMail()
    {
        return UserSentRecord::count();
    }

    // totalSentMail
    function totalSystemSMSSent()
    {
        return SmsLog::count();
    }

    /**
     * TOTAL SUBSCRIBED
     */

     function totalSubscribed()
     {
         return EmailContact::where('is_subscribed', 1)->count();
     }


     /**
      * Email List
      */

      function emailList()
      {
          return EmailContact::where('owner_id', Auth::user()->id)->Active()->whereNotNull('email')->latest()->paginate(30);
      }


     /**
      * phone List
      */

      function phoneList()
      {
          return EmailContact::where('owner_id', Auth::user()->id)->Active()->whereNotNull('phone')->latest()->paginate(30);
      }


      /**
       * Country
       */

       function country_codes()
       {
           return Country::get();
       }

       /**
        * SERVER STATUS
        */

       function server_cache_clear()
       {
            Artisan::call('cache:clear');
            return back();
       }

       function server_optimize()
       {
            Artisan::call('optimize:clear');
            return back();
       }

       function server_memory_get_usage()
       {
            return convert(memory_get_usage(true)); // memory in use
       }

       function server_max_execution_time()
       {
            $normalTimeLimit = ini_get('max_execution_time');
            ini_set('max_execution_time', 6000);
            return ini_set('max_execution_time', $normalTimeLimit);
       }

       function server_max_input_time()
       {
            return ini_get('max_input_time');
       }

       function server_memory_limit()
       {
            $normalTimeLimit = ini_get('memory_limit');
            ini_set('memory_limit', '10000M');
            return ini_set('memory_limit', $normalTimeLimit);
       }

       function server_upload_max_filesize()
       {
            return ini_get('upload_max_filesize');
       }

       function server_max_file_uploads()
       {
            return ini_get('max_file_uploads');
       }

       function server_default_socket_timeout($time)
       {
            $normalTimeLimit = ini_get('default_socket_timeout');
            ini_set('default_socket_timeout', $time);
            return ini_set('default_socket_timeout', $normalTimeLimit);
       }

       function server_php_version()
       {
            return $_SERVER['PHP_SELF'];
       }

       function application_version()
       {
            return app()->version();
       }

       function server_db_port()
       {
            return env('DB_PORT');
       }

       function server_remote_port()
       {
            return $_SERVER['REMOTE_PORT'];
       }

       function server_request_time()
       {
            return $_SERVER['REQUEST_TIME'];
       }

       function server_post_max_size()
       {
            return ini_get('post_max_size');
       }

       function server_realpath_cache_size()
       {
            return ini_get('realpath_cache_size');
       }

       function software_version()
       {
            return env('VERSION');
       }

       function server_MariaDB()
       {
            $con = mysqli_connect(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'));

                if (mysqli_connect_errno()) {
                return  "MySQL: " . mysqli_connect_error();
                exit();
                }

                return mysqli_get_server_info($con);
       }


       function CheckQueue()
       {
           $jobs = Queue::count();

        if ($jobs > 0) {
            return 'btn-animated';
        }else{
            return '';
        }

       }

       function CheckFailedJob()
       {
           $failed = FailedJob::count();

        if ($failed > 0) {
            return 'btn-animated';
        }else{
            return '';
        }

       }

       function demo_mode()
       {
           if (env('DEMO_MODE') === "YES") {
                Alert::warning('warning', 'This is demo purpose only');
                return back();
            }
       }

       /**
        * EMAIL SERVICE
        */

        function activeEmailService()
        {
            return EmailService::Active()->first()->provider_name ?? null;
        }

        function sendEmailFrom()
        {
            return EmailService::Active()->first()->from;
        }

        function getEmailInfo()
        {
            return EmailService::Active()->first();
        }

        function getUserActiveEmailDetails()
        {
            return EmailService::Active()
                                ->select(
                                    'driver', 
                                    'host', 
                                    'port', 
                                    'username', 
                                    'password', 
                                    'encryption', 
                                    'from', 
                                    'from_name')
                                ->first();
        }

        /**
         * SMS Provider
         */

         function getSmsInfo($sms)
        {
            $hasSms = Sms::where('sms_name', $sms)->where('owner_id', Auth::user()->id)->exists();

            if ($hasSms) {
                return true;
            } else {
                return false;
            }
        }


    // takes a string of CSV data and returns a JSON representing an array of objects (one object per row)
    function convert_csv_to_json($csv_data){
            if (($handle = fopen($csv_data, "r")) !== FALSE) {
            $csvs = [];
            while(! feof($handle)) {
            $csvs[] = fgetcsv($handle);
            }
            $datas = [];
            $column_names = [];
            foreach ($csvs[0] as $single_csv) {
                $column_names[] = $single_csv;
            }
            foreach ($csvs as $key => $csv) {
                if ($key === 0) {
                    continue;
                }
                foreach ($column_names as $column_key => $column_name) {
                    $datas[$key-1][$column_name] = $csv[$column_key];
                }
            }
            
        return $json = json_encode($datas);
        
        }
    }

    /**
     * DOWNLOAD CSV
     */

    function csv_path()
    {
        return public_path('sample_data.csv');
    }

    /**
     * Layout
     */

     
    function checkthemeLayout()
    {
        return OrganizationSetup::where('name', 'layout')->first();
    }

    function themeLayout()
    {
        $layout = OrganizationSetup::where('name', 'layout')->first();
    
        if ($layout->value != null) {
            return $layout->value;
        }else{
            return 'classic';
        }
    }



       