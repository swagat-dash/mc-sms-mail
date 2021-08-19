<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrganizationSetup;

class OrgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $org = new OrganizationSetup();
        $org->name = 'company_name';
        $org->value = 'Swagmail';
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'logo';
        $org->value = 'uploads/logo/swagmail.png';
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'favIcon';
        $org->value = 'uploads/logo/favicon.ico';
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'footer_logo';
        $org->value = 'uploads/logo/footer_logo.png';
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'color';
        $org->value = null;
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'company_email';
        $org->value = null;
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'company_phone_number';
        $org->value = null;
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'company_tel_number';
        $org->value = null;
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'company_address';
        $org->value = null;
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'facebook';
        $org->value = null;
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'linkedin';
        $org->value = null;
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'skype';
        $org->value = null;
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'twitter';
        $org->value = null;
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'test_connection_email';
        $org->value = 'demo.softtechit@gmail.com';
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'test_connection_sms';
        $org->value = '+8801685755707';
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'dev_mode';
        $org->value = 1;
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'default_currencies';
        $org->value = 1;
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'theme';
        $org->value = 'neon';
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'layout';
        $org->value = 'classic';
        $org->save();

        $org = new OrganizationSetup();
        $org->name = 'default_language';
        $org->value = 'en';
        $org->save();

    }
}
