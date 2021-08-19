<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailService;

class EmailServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gmail = new EmailService();
        $gmail->owner_id     = 1;
        $gmail->provider_name     = 'gmail';
        $gmail->driver     = null;
        $gmail->host       = null;
        $gmail->port       = null;
        $gmail->username       = null;
        $gmail->password       = null;
        $gmail->encryption      = null;
        $gmail->from       = null;
        $gmail->from_name      = null;
        $gmail->sendmail      = '/usr/sbin/sendmail -bs';
        $gmail->pretend      = 0;
        $gmail->active      = 1;
        $gmail->save();

        $yahoo = new EmailService;
        $yahoo->provider_name     = 'yahoo';
        $yahoo->driver     = null;
        $yahoo->host       = null;
        $yahoo->port       = null;
        $yahoo->username       = null;
        $yahoo->password       = null;
        $yahoo->encryption      = null;
        $yahoo->from       = null;
        $yahoo->from_name      = null;
        $yahoo->sendmail      = '/usr/sbin/sendmail -bs';
        $yahoo->pretend      = 0;
        $yahoo->active      = 0;
        $yahoo->save();

        $webmail = new EmailService;
        $webmail->provider_name     = 'webmail';
        $webmail->driver     = null;
        $webmail->host       = null;
        $webmail->port       = null;
        $webmail->username       = null;
        $webmail->password       = null;
        $webmail->encryption      = null;
        $webmail->from       = null;
        $webmail->from_name      = null;
        $webmail->sendmail      = '/usr/sbin/sendmail -bs';
        $webmail->pretend      = 0;
        $webmail->active      = 0;
        $webmail->save();

        $mailgun = new EmailService;
        $mailgun->provider_name     = 'mailgun';
        $mailgun->driver     = null;
        $mailgun->host       = null;
        $mailgun->port       = null;
        $mailgun->username       = null;
        $mailgun->password       = null;
        $mailgun->encryption      = null;
        $mailgun->from       = null;
        $mailgun->from_name      = null;
        $mailgun->sendmail      = '/usr/sbin/sendmail -bs';
        $mailgun->pretend      = 0;
        $mailgun->active      = 0;
        $mailgun->save();

        $zoho = new EmailService;
        $zoho->provider_name     = 'zoho';
        $zoho->driver     = null;
        $zoho->host       = null;
        $zoho->port       = null;
        $zoho->username       = null;
        $zoho->password       = null;
        $zoho->encryption      = null;
        $zoho->from       = null;
        $zoho->from_name      = null;
        $zoho->sendmail      = '/usr/sbin/sendmail -bs';
        $zoho->pretend      = 0;
        $zoho->active      = 0;
        $zoho->save();

        $elastic = new EmailService;
        $elastic->provider_name     = 'elastic';
        $elastic->driver     = null;
        $elastic->host       = null;
        $elastic->port       = null;
        $elastic->username       = null;
        $elastic->password       = null;
        $elastic->encryption      = null;
        $elastic->from       = null;
        $elastic->from_name      = null;
        $elastic->sendmail      = '/usr/sbin/sendmail -bs';
        $elastic->pretend      = 0;
        $elastic->active      = 0;
        $elastic->save();
    }
}
