<?php

namespace App\Http\Controllers;

use App\Models\CampaignLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampaignLogController extends Controller
{
    /**
     * LOG LIST
     */

    public function index()
    {
        return view('campaign_logs.index');
    }

    /**
     * EMAILS
     */

     public function getEmails($id)
     {
        return view('campaign_logs.campaign_emails', compact('id'));
     }

}
