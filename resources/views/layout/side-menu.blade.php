@extends('../layout/main')

@section('head')
    @yield('subhead')
@endsection

@section('content')
    @include('../layout/components/mobile-menu')
    <div class="flex">
        <!-- BEGIN: Side Menu -->
        <nav class="side-nav">
            <a href="{{ route('dashboard') }}" class="intro-x flex items-center">

                @if (checkDBConnection() == true && Schema::hasTable('organization_setups'))

                        @if (Schema::hasColumn('organization_setups', 'company_name') && Schema::hasColumn('organization_setups', 'logo'))
                            <img alt="{{ orgName() }}" class="m-auto" src="{{ logo() }}">
                        @else
                            <img alt="#swagmail" class="m-auto" src="{{ logo() }}">
                        @endif

                @else
                    <img alt="{{ swagmail() }}" class="m-auto" src="#swagmail">
                @endif
                        
            </a>
            <div class="side-nav__devider my-6"></div>

            {{-- My Custom nav --}}

            <ul>

            
                {{-- Dashboard --}}
                <li>
                    <a href="{{ route('dashboard') }}" class="side-menu {{ request()->routeIs('dashboard') ? 'side-menu--active' : '' }}">
                        <div class="{{ request()->routeIs('dashboard') ? 'mldl-active-menu' : 'flex items-center' }}">
                            <div class="side-menu__icon">
                            <i data-feather="home"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Dashboard)
                        </div>
                        </div>
                    </a>
                </li>


                 <li>
                    <a href="{{ route('profile.index') }}" class="side-menu {{ request()->routeIs('profile.index') ? 'side-menu--active' : '' }}">
                        <div class="{{ request()->routeIs('profile.index') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="user"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(My Profile)
                        </div>
                        </div>
                    </a>
                </li>

                {{-- Organization Setup --}}
                @can('Admin')
                    <li>
                    <a href="{{ route('org.index') }}" class="side-menu {{ request()->routeIs('org.index') ? 'side-menu--active' : '' }}">
                       <div class="{{ request()->routeIs('org.index') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="tool"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Organization Setup)
                        </div>
                        </div>
                    </a>
                </li>


                {{-- Organization Setup --}}
                 <li>
                    <a href="{{ route('seo.index') }}" class="side-menu {{ request()->routeIs('seo.index') ? 'side-menu--active' : '' }}">
                        <div class="{{ request()->routeIs('seo.index') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="bar-chart"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(SEO)
                        </div>
                        </div>
                    </a>
                </li>

                {{-- Frontend Settings --}}

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('frontend.*') ? 'side-menu--active side-menu--open' : ''
                    }}">
<div class="{{ request()->routeIs('frontend.*') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="sun"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Frontend)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>
                        </div>
                    </a>

                    <ul class="d-none {{
                        request()->routeIs('frontend.setup') ? 'side-menu__sub-open' : ''
                    }}">
                        <li>
                            <a href="{{ route('frontend.setup') }}" target="_blank" class="side-menu {{ request()->routeIs('frontend.setup') ? 'side-menu--active' : '' }}">
                                <div class="{{ request()->routeIs('frontend.setup') ? 'mldl-active-menu' : 'flex items-center' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Setup)
                                </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Language Settings --}}

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('language.index*') ? 'side-menu--active side-menu--open' : ''
                    }}">
<div class="{{ request()->routeIs('language.index') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="type"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Language Settings)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>
                        </div>
                    </a>

                    <ul class="d-none {{
                        request()->routeIs('language.index*') || request()->routeIs('language.translate') ? 'side-menu__sub-open' : ''
                    }}">
                        <li>
                            <a href="{{ route('language.index') }}" class="side-menu {{ request()->routeIs('language.index') ? 'side-menu--active' : '' }}">
                               
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Setup Language)
                                </div>
                         
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Currency Settings --}}

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('currencies.index*') ? 'side-menu--active side-menu--open' : ''
                    }}">
<div class="{{ request()->routeIs('currencies.index') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="dollar-sign"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Currency Settings)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>
                        </div>
                    </a>

                    <ul class="d-none {{
                        request()->routeIs('currencies.index*') ? 'side-menu__sub-open' : ''
                    }}">
                        <li>
                            <a href="{{ route('currencies.index') }}" class="side-menu {{ request()->routeIs('currencies.index') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Setup Currency)
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                @endcan
                

                {{-- SMTP Management --}}

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('smtp.index*') ? 'side-menu--active side-menu--open' : ''
                    }}">
<div class="{{ request()->routeIs('smtp.index') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="mail"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(SMTP Settings)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>
                        </div>
                    </a>

                    <ul class="d-none {{
                        request()->routeIs('smtp.*') ? 'side-menu__sub-open' : ''
                    }}">
                        <li>
                            <a href="{{ route('smtp.index') }}" class="side-menu {{ request()->routeIs('smtp.index') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Configure Email)
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- SMS Management --}}

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('sms.*') ? 'side-menu--active side-menu--open' : ''
                    }}">
<div class="{{ request()->routeIs('sms.*') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="smartphone"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(SMS Settings)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>
                        </div>
                    </a>

                    <ul class="d-none {{
                        request()->routeIs('sms.*') ? 'side-menu__sub-open' : ''
                    }}">
                        <li>
                            <a href="{{ route('sms.index') }}" class="side-menu {{ request()->routeIs('sms.index') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Configure SMS)
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>

                

                
                {{-- Template builder --}}

                <li>
                    
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('templates.*') || request()->routeIs('template.builder.*') ? 'side-menu--active side-menu--open' : ''
                    }}">
<div class="{{ request()->routeIs('templates.*') ? 'mldl-active-menu' : 'flex items-center' }}">

                        <div class="side-menu__icon">
                            <i data-feather="git-pull-request"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Template Builder)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>

                        </div>
                    </a>

                    <ul class="d-none {{
                        request()->routeIs('templates.*') || request()->routeIs('template.builder.*') ? 'side-menu__sub-open' : ''
                    }}">
                        <li>

                            <a href="{{ route('template.builder.originate') }}" class="side-menu {{ request()->routeIs('template.builder.originate') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Create Template)
                                </div>
                            </a>

                            <a href="{{ route('templates.index') }}" class="side-menu {{ request()->routeIs('templates.index') || request()->routeIs('template.builder.edit.thumbnail') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="book"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Template List)
                                </div>
                            </a>

                        </li>
                    </ul>
                </li>

                {{-- Sms builder --}}

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('builder.sms.*') ? 'side-menu--active side-menu--open' : ''
                    }}">
<div class="{{ request()->routeIs('builder.sms.*') ? 'mldl-active-menu' : 'flex items-center' }}">

                        <div class="side-menu__icon">
                            <i data-feather="git-merge"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(SMS Builder)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>
</div>

                    </a>

                    <ul class="d-none {{
                        request()->routeIs('builder.sms.*') ? 'side-menu__sub-open' : ''
                    }}">
                        <li>
                            <a href="{{ route('builder.sms.create') }}" class="side-menu {{ request()->routeIs('builder.sms.create') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Create Body)
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('builder.sms.templates') }}" class="side-menu {{ request()->routeIs('builder.sms.templates') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(SMS Templates)
                                </div>
                            </a>

                        </li>

                    </ul>
                </li>

                {{-- Contacts --}}

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('email.contacts*') || request()->routeIs('email.contacts.list') || request()->routeIs('phone.contacts.list') ? 'side-menu--active side-menu--open' : ''
                    }}">

<div class="{{ request()->routeIs('email.contacts*') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="send"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Contacts)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>
</div>

                    </a>

                    <ul class="d-none {{
                        request()->routeIs('email.contacts*') || request()->routeIs('email.contact.show') || request()->routeIs('email.contacts.list') || request()->routeIs('phone.contacts.list') ? 'side-menu__sub-open' : ''
                    }}">
                        <li>
                            <a href="{{ route('email.contacts.index') }}" class="side-menu {{ request()->routeIs('email.contacts.index') || request()->routeIs('email.contact.show') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Contact List)
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('email.contacts.list') }}" 
                            class="side-menu {{ request()->routeIs('email.contacts.list') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Email List)
                                </div>
                            </a>
                        </li>


                        <li>
                            <a href="{{ route('phone.contacts.list') }}" 
                            class="side-menu {{ request()->routeIs('phone.contacts.list') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Phone List)
                                </div>
                            </a>
                        </li>

                        
                        <li>
                            <a href="{{ route('email.contacts.bulk.csv') }}" 
                            class="side-menu {{ request()->routeIs('email.contacts.bulk.csv') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Bulk Import Export)
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- Groups --}}

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('group.*') ? 'side-menu--active side-menu--open' : ''
                    }}">

<div class="{{ request()->routeIs('group.*') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="users"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Groups)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>
</div>

                    </a>

                    <ul class="d-none {{
                        request()->routeIs('group.*') ? 'side-menu__sub-open' : ''
                    }}">
                        <li>
                            <a href="{{ route('group.index') }}" class="side-menu {{ request()->routeIs('group.index') || request()->routeIs('group.show') || request()->routeIs('group.edit') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Group List)
                                </div>
                            </a>
                            <a href="{{ route('group.create') }}" class="side-menu {{ request()->routeIs('group.create') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Create Group)
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>
                {{-- Campaign --}}

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('campaign.*') ? 'side-menu--active side-menu--open' : ''
                    }}">

<div class="{{ request()->routeIs('campaign.*') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="columns"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Campaigns)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>

                        </div>
                    </a>

                    <ul class="d-none {{
                        request()->routeIs('campaign.*') ? 'side-menu__sub-open' : ''
                    }}">
                        <li>
                            <a href="{{ route('campaign.type', 'email') }}" class="side-menu {{ request()->is('campaign/type/email') || request()->routeIs('campaign.emails.edit') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Email Campaign)
                                </div>
                            </a>
                            <a href="{{ route('campaign.type', 'sms') }}" class="side-menu {{ request()->is('campaign/type/sms') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(SMS Campaign)
                                </div>
                            </a>

                            <a href="{{ route('campaign.index') }}" class="side-menu {{ request()->routeIs('campaign.index') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Campaign List)
                                </div>
                            </a>

                            <a href="{{ route('campaign.create') }}" class="side-menu {{ request()->routeIs('campaign.create') 
                            || request()->routeIs('campaign.create.type') 
                            || request()->routeIs('campaign.store.step1') 
                            || request()->routeIs('campaign.store.step2')
                            || request()->routeIs('campaign.store.store2')
                            || request()->routeIs('campaign.store.step3') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Create Campaign)
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>



                {{-- Mail Activity --}}

                @can('Admin')

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('mail.activity.*') ? 'side-menu--active side-menu--open' : ''
                    }}">
<div class="{{ request()->routeIs('mail.activity.*') ? 'mldl-active-menu' : 'flex items-center' }}">

                        <div class="side-menu__icon">
                            <i data-feather="list"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Mail Details)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>

                        </div>
                    </a>

                    <ul class="d-none {{
                        request()->routeIs('mail.activity.*') ? 'side-menu__sub-open' : ''
                    }}">

                         <li>
                            <a href="{{ route('mail.activity.index') }}" class="side-menu {{ request()->routeIs('mail.activity.index') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Detail List)
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>
                @endcan

                 {{-- Mail Log --}}

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('mail.log.*') ? 'side-menu--active side-menu--open' : ''
                    }}">
<div class="{{ request()->routeIs('mail.log.*') ? 'mldl-active-menu' : 'flex items-center' }}">

                        <div class="side-menu__icon">
                            <i data-feather="list"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Mail Logs)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>
</div>

                    </a>

                    <ul class="d-none {{
                        request()->routeIs('mail.log.*') ? 'side-menu__sub-open' : ''
                    }}">

                         <li>
                            <a href="{{ route('mail.log.index') }}" class="side-menu {{ request()->routeIs('mail.log.index') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Log List)
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Sms Log --}}

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('log.sms') ? 'side-menu--active side-menu--open' : ''
                    }}">

<div class="{{ request()->routeIs('log.sms') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="message-square"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(SMS Logs)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>
</div>

                    </a>

                    <ul class="d-none {{
                        request()->routeIs('log.sms') ? 'side-menu__sub-open' : ''
                    }}">

                         <li>
                            <a href="{{ route('log.sms') }}" class="side-menu {{ request()->routeIs('log.sms') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Log List)
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- Campaign Log --}}

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('logs.campaign.*') ? 'side-menu--active side-menu--open' : ''
                    }}">

<div class="{{ request()->routeIs('logs.campaign.*') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Campaign Logs)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>
</div>

                    </a>

                    <ul class="d-none {{
                        request()->routeIs('logs.campaign.*') ? 'side-menu__sub-open' : ''
                    }}">

                         <li>
                            <a href="{{ route('logs.campaign.index') }}" class="side-menu {{ request()->routeIs('logs.campaign.index') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Log List)
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- Task Manager --}}

                {{-- Subscription --}}

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('subscription.*') ? 'side-menu--active side-menu--open' : ''
                    }}">

<div class="{{ request()->routeIs('subscription.*') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="grid"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Subscription Plans)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>

                        </div>
                    </a>

                    <ul class="d-none {{
                        request()->routeIs('subscription.*') ? 'side-menu__sub-open' : ''
                    }}">

                         <li>
                            <a href="{{ route('subscription.index') }}" class="side-menu {{ request()->routeIs('subscription.index') || request()->routeIs('subscription.edit') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Plans)
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- Subscription --}}

                <li>
                    <a href="{{ route('purchased.plan') }}" class="side-menu {{ request()->routeIs('purchased.plan') ? 'side-menu--active' : '' }}">
                        <div class="{{ request()->routeIs('purchased.plan') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="shopping-bag"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Purchased Plans)
                        </div>
                        </div>
                    </a>
                </li>

                {{-- Limit Manager --}}
                @can('Admin')

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('limit.*') ? 'side-menu--active side-menu--open' : ''
                    }}">

<div class="{{ request()->routeIs('limit.*') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="bar-chart-2"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Limit Manager)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>

                        </div>
                    </a>

                    <ul class="d-none {{
                        request()->routeIs('limit.*') ? 'side-menu__sub-open' : ''
                    }}">

                        <li>
                            <a href="{{ route('limit.index') }}" class="side-menu {{ request()->routeIs('limit.index') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Users Limit)
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- Notes --}}

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('notes.*') ? 'side-menu--active side-menu--open' : ''
                    }}">
<div class="{{ request()->routeIs('notes.*') ? 'mldl-active-menu' : 'flex items-center' }}">

                        <div class="side-menu__icon">
                            <i data-feather="book"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Important Notes)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>
</div>

                    </a>

                    <ul class="d-none {{
                        request()->routeIs('notes.*') ? 'side-menu__sub-open' : ''
                    }}">

                        <li>
                            <a href="{{ route('notes.index') }}" class="side-menu {{ request()->routeIs('notes.index') || request()->routeIs('notes.show') || request()->routeIs('notes.edit') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Note Lists)
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('notes.create') }}" class="side-menu {{ request()->routeIs('notes.create') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Create Note)
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- Payment Setup --}}

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('payment.setup.*') ? 'side-menu--active side-menu--open' : ''
                    }}">
<div class="{{ request()->routeIs('payment.setup.*') ? 'mldl-active-menu' : 'flex items-center' }}">

                        <div class="side-menu__icon">
                            <i data-feather="credit-card"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Payment Setup)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>
</div>

                    </a>

                    <ul class="d-none {{
                        request()->routeIs('payment.setup.*') ? 'side-menu__sub-open' : ''
                    }}">

                        <li>
                            <a href="{{ route('payment.setup.paypal') }}" class="side-menu {{ request()->routeIs('payment.setup.paypal') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Paypal)
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('payment.setup.stripe') }}" class="side-menu {{ request()->routeIs('payment.setup.stripe') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Stripe)
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>

                @endcan

                {{-- Bounced Email --}}

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('bounce.emails') ? 'side-menu--active side-menu--open' : ''
                    }}">
<div class="{{ request()->routeIs('bounce.emails') ? 'mldl-active-menu' : 'flex items-center' }}">

                        <div class="side-menu__icon">
                            <i data-feather="alert-circle"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Bounce Checker)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>
</div>

                    </a>

                    <ul class="d-none {{
                        request()->routeIs('bounce.*') ? 'side-menu__sub-open' : ''
                    }}">

                        <li>
                            <a href="{{ route('bounce.emails') }}" class="side-menu {{ request()->routeIs('bounce.emails') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Email Lists)
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('bounce.check') }}" class="side-menu {{ request()->routeIs('bounce.check') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Check Bounce)
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- Task Manager --}}

                @can('Admin')

                @if (devtool())

                
                {{-- Queue Tracker --}}

                <li>
                    <a href="javascript:;"
                    class="side-menu {{
                        request()->routeIs('queue.*') ? 'side-menu--active side-menu--open' : ''
                    }}">

<div class="{{ request()->routeIs('queue.*') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="truck"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Queue Tracker)
                            <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                        </div>
</div>

                    </a>

                    <ul class="d-none {{
                        request()->routeIs('queue.*') ? 'side-menu__sub-open' : ''
                    }}">

                         <li>
                            <a href="{{ route('queue.proccessed') }}" class="side-menu {{ request()->routeIs('queue.proccessed') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Queue Proccessed)
                                </div>
                            </a>
                        </li>


                        <li>
                            <a href="{{ route('queue.failed') }}" class="side-menu {{ request()->routeIs('queue.failed') ? 'side-menu--active' : '' }}">
                                <div class="side-menu__icon">
                                    <i data-feather="align-left"></i>
                                </div>
                                <div class="side-menu__title">
                                    @translate(Queue Failed)
                                </div>
                            </a>
                        </li>


                    </ul>
                </li>
                    
                {{-- Terminal CLI --}}

                <li class="hidden">

                    @if (env('DEMO_MODE') != "YES")

                    <a href="{{ url('/terminal') }}" class="side-menu {{ request()->is('/terminal') ? 'side-menu--active' : '' }}" target="_blank">
                        <div class="side-menu__icon">
                            <i data-feather="terminal"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Terminal CLI)
                        </div>
                    </a>

                    @else

                    <a href="javascript:;" class="side-menu tooltip {{ request()->is('/terminal') ? 'side-menu--active' : '' }}" title="This is for demo purpose only">
                        <div class="side-menu__icon">
                            <i data-feather="terminal"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Terminal CLI)
                        </div>
                    </a>
                        
                    @endif
                    
                </li>
                    
                {{-- Terminal CLI --}}

                <li>
                    <a href="{{ route('server.status') }}" class="side-menu {{ request()->routeIs('server.status') ? 'side-menu--active' : '' }}">
                        
                        <div class="{{ request()->routeIs('server.status') ? 'mldl-active-menu' : 'flex items-center' }}">
                        <div class="side-menu__icon">
                            <i data-feather="server"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Server Status)
                        </div>
                        </div>
                    </a>
                </li>

                {{-- Artisan GUI --}}

                @if (env('DEMO_MODE') != "YES")

                <li>
                    <a href="{{ url('/~artisan') }}" class="side-menu {{ request()->is('/~artisan') ? 'side-menu--active' : '' }}" target="_blank">
                        <div class="side-menu__icon">
                            <i data-feather="git-branch"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Artisan GUI)
                        </div>
                    </a>
                </li>

                @else

                <li>
                    <a href="javascript:;" class="side-menu tooltip {{ request()->is('/~artisan') ? 'side-menu--active' : '' }}" title="This is for demo purpose only">
                        <div class="side-menu__icon">
                            <i data-feather="git-branch"></i>
                        </div>
                        <div class="side-menu__title">
                            @translate(Artisan GUI)
                        </div>
                    </a>
                </li>

                @endif

                @endif

                @endcan


                <li>
                    <div id="google_translate_element"></div>
                </li>

            </ul>

        </nav>
        <!-- END: Side Menu -->
        <!-- BEGIN: Content -->
        <div class="content">
            @include('../layout/components/top-bar')
            @yield('subcontent')
        </div>
        <!-- END: Content -->
    </div>

    


@endsection
