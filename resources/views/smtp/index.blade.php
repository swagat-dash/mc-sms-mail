@extends('../layout/' . layout())

@section('subhead')
<title>@translate(SMTP Settings)</title>
@endsection

@section('subcontent')
<h2 class="intro-y text-lg font-medium mt-10">@translate(Mail Servers)</h2>
<div class="grid grid-cols-12 gap-6 mt-5">


    {{-- GMAIL --}}

    <div class="intro-y col-span-12 md:col-span-6 lg:col-span-6">
        <div class="box {{ defaultMail('gmail') }}">
            <div class="flex items-start px-5 pt-5">
                <div class="w-full flex flex-col lg:flex-row items-center">
                    <div class="w-16 h-16 image-fit">
                        <img alt="Swagmail" class="rounded-md" src="{{ mailLogo('gmail') }}">
                    </div>
                    <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                        @translate(Gmail)
                    </div>
                </div>
            </div>
            <form action="{{ route('smtp.configure.default', 'gmail') }}" method="GET">
                <div class="text-center lg:text-left p-5">
                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-5">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        MAIL_MAILER={{ $gmail->driver ?? NULL }}
                        <input type="hidden" name="GMAIL_MAIL_MAILER" class="input w-full border mt-2"
                            placeholder="MAIL MAILER" value="{{ $gmail->driver ?? NULL }}">
                    </div>
                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        MAIL_HOST={{ $gmail->host ?? NULL }}
                        <input type="hidden" name="GMAIL_MAIL_HOST" class="input w-full border mt-2"
                            placeholder="MAIL HOST" value="{{ $gmail->host ?? NULL }}">

                    </div>
                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        MAIL_PORT={{ $gmail->port ?? NULL }}
                        <input type="hidden" placeholder="MAIL PORT" class="input w-full border mt-2"
                            name="GMAIL_MAIL_PORT" value="{{ $gmail->port ?? NULL }}">

                    </div>
                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        MAIL_USERNAME={{ $gmail->username ?? NULL }}
                        <input type="hidden" placeholder="MAIL USERNAME" class="input w-full border mt-2"
                            name="GMAIL_MAIL_USERNAME" value="{{ $gmail->username ?? NULL }}">

                    </div>
                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        MAIL_PASSWORD={{ $gmail->password ?? NULL }}
                        <input type="hidden" name="GMAIL_MAIL_PASSWORD" class="input w-full border mt-2"
                            placeholder="MAIL PASSWORD" value="{{ $gmail->password ?? NULL  }}">

                    </div>
                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        MAIL_ENCRYPTION={{ $gmail->encryption ?? NULL }}
                        <input type="hidden" name="GMAIL_MAIL_ENCRYPTION" class="input w-full border mt-2"
                            placeholder="MAIL ENCRYPTION" value="{{ $gmail->encryption ?? NULL  }}">

                    </div>
                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        MAIL_FROM_ADDRESS={{ $gmail->from ?? NULL }}
                        <input type="hidden" class="input w-full border mt-2" placeholder="MAIL FROM ADDRESS"
                            name="GMAIL_MAIL_FROM_ADDRESS" value="{{ $gmail->from ?? NULL  }}">

                    </div>
                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        MAIL_FROM_NAME={{ $gmail->from_name ?? NULL }}
                        <input type="hidden" class="input w-full border mt-2" placeholder="MAIL FROM NAME"
                            name="GMAIL_MAIL_FROM_NAME" value="{{ $gmail->from_name ?? NULL  }}">
                    </div>
                </div>
                <div class="text-center lg:text-right p-5 border-t border-gray-200 dark:border-dark-5">

                    <a href="{{ route('smtp.configure', 'gmail') }}"
                        class="button button--sm text-white bg-theme-6 mr-2">
                        @translate(Configure Now)
                    </a>

                    
                        @can('Admin')
                    @if ($gmail != null)
                        @if (env('DEFAULT_MAIL') == 'gmail')

                        <span
                            class="button button--sm w-30 inline-block mr-1 mb-2 bg-theme-4 text-white inline-flex items-center tooltip cursor-default"
                            title="Selected as system default">
                            @translate(App Default) <i data-loading-icon="puff" data-color="white" class="w-4 h-4 ml-auto"></i>
                        </span>

                        @else
                         <a href="{{ route('system.smtp.setup', 'gmail') }}"
                                class="button button--sm text-white bg-theme-4 mr-2 tooltip" title="Make as system default">
                                @translate(Choose as app default)
                            </a>
                        @endif
                    @endif
                @endcan


                        @if (activeEmailService() == 'gmail')

                        <a href="{{ route('smtp.connection.test') }}"
                            class="button button--sm text-white bg-theme-7 mr-2">@translate(Test Connection)</a>

                        <span
                            class="button button--sm w-30 inline-block mr-1 mb-2 bg-theme-9 text-white inline-flex items-center  cursor-default">
                            @translate(Active) <i data-loading-icon="puff" data-color="white" class="w-4 h-4 ml-auto"></i>
                        </span>

                        
                        @else

                            @if ($gmail != null)
                            <button type="submit" 
                                class="button button--sm text-white bg-theme-1 mr-2">
                                @translate(Choose Choose as campaign default)
                            </button>
                            @endif

                        @endif


            </form>
        </div>
    </div>
</div>
{{-- GMAIL::END --}}

{{-- Yahoo --}}

<div class="intro-y col-span-12 md:col-span-6 lg:col-span-6">
    <div class="box {{ defaultMail('yahoo') }}">
        <div class="flex items-start px-5 pt-5">
            <div class="w-full flex flex-col lg:flex-row items-center">
                <div class="w-16 h-16 image-fit">
                    <img alt="Swagmail" class="rounded-md" src="{{ mailLogo('yahoo') }}">
                </div>
                <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                    @translate(Yahoo)
                </div>
            </div>
        </div>
        <form action="{{ route('smtp.configure.default', 'yahoo') }}" method="GET">
            <div class="text-center lg:text-left p-5">
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-5">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_MAILER={{ $yahoo->driver ?? NULL }}
                    <input type="hidden" name="YAHOO_MAIL_MAILER" class="input w-full border mt-2"
                        placeholder="MAIL MAILER" value="{{ $yahoo->driver ?? NULL }}">
                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i> MAIL_HOST={{ $yahoo->host ?? NULL }}
                    <input type="hidden" name="YAHOO_MAIL_HOST" class="input w-full border mt-2" placeholder="MAIL HOST"
                        value="{{ $yahoo->host ?? NULL }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i> MAIL_PORT={{ $yahoo->port ?? NULL }}
                    <input type="hidden" placeholder="MAIL PORT" class="input w-full border mt-2" name="YAHOO_MAIL_PORT"
                        value="{{ $yahoo->port ?? NULL }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_USERNAME={{ $yahoo->username ?? NULL }}
                    <input type="hidden" placeholder="MAIL USERNAME" class="input w-full border mt-2"
                        name="YAHOO_MAIL_USERNAME" value="{{ $yahoo->username ?? NULL }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_PASSWORD={{ $yahoo->password ?? NULL }}
                    <input type="hidden" name="YAHOO_MAIL_PASSWORD" class="input w-full border mt-2"
                        placeholder="MAIL PASSWORD" value="{{ $yahoo->password ?? NULL  }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_ENCRYPTION={{ $yahoo->encryption ?? NULL }}
                    <input type="hidden" name="YAHOO_MAIL_ENCRYPTION" class="input w-full border mt-2"
                        placeholder="MAIL ENCRYPTION" value="{{ $yahoo->encryption ?? NULL  }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_FROM_ADDRESS={{ $yahoo->from ?? NULL }}
                    <input type="hidden" class="input w-full border mt-2" placeholder="MAIL FROM ADDRESS"
                        name="YAHOO_MAIL_FROM_ADDRESS" value="{{ $yahoo->from ?? NULL  }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_FROM_NAME={{ $yahoo->from_name ?? NULL }}
                    <input type="hidden" class="input w-full border mt-2" placeholder="MAIL FROM NAME"
                        name="YAHOO_MAIL_FROM_NAME" value="{{ $yahoo->from_name ?? NULL  }}">
                </div>
            </div>
            <div class="text-center lg:text-right p-5 border-t border-gray-200 dark:border-dark-5">
                <a href="{{ route('smtp.configure', 'yahoo') }}"
                    class="button button--sm text-white bg-theme-6 mr-2">@translate(Configure Now)</a>


                    @can('Admin')
                    @if ($yahoo != null)
                        @if (env('DEFAULT_MAIL') == 'yahoo')

                        <span
                            class="button button--sm w-30 inline-block mr-1 mb-2 bg-theme-4 text-white inline-flex items-center tooltip cursor-default"
                            title="Selected as system default">
                            @translate(App Default) <i data-loading-icon="puff" data-color="white" class="w-4 h-4 ml-auto"></i>
                        </span>

                        @else
                         <a href="{{ route('system.smtp.setup', 'yahoo') }}"
                                class="button button--sm text-white bg-theme-4 mr-2 tooltip" title="Make as system default">
                                @translate(Choose as app default)
                            </a>
                        @endif
                    @endif
                @endcan

                    
                    @if (activeEmailService() == 'yahoo')

                    <a href="{{ route('smtp.connection.test') }}"
                        class="button button--sm text-white bg-theme-7 mr-2">@translate(Test Connection)</a>

                    <span
                        class="button button--sm w-24 inline-block mr-1 mb-2 bg-theme-9 text-white inline-flex items-center cursor-default">
                        @translate(Active) <i data-loading-icon="puff" data-color="white" class="w-4 h-4 ml-auto"></i>
                    </span>
                    
                    @else

                    @if ($yahoo != null)
                        <button type="submit" 
                        class="button button--sm text-white bg-theme-1 mr-2">
                        @translate(Choose Choose as campaign default)
                    </button>
                    @endif

                    @endif

        </form>
    </div>
</div>
</div>
{{-- Yahoo::END --}}

{{-- Webmail --}}

<div class="intro-y col-span-12 md:col-span-6 lg:col-span-6">
    <div class="box {{ defaultMail('webmail') }}">
        <div class="flex items-start px-5 pt-5">
            <div class="w-full flex flex-col lg:flex-row items-center">
                <div class="w-16 h-16 image-fit">
                    <img alt="Swagmail" class="rounded-md" src="{{ mailLogo('webmail') }}">
                </div>
                <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                    @translate(Webmail)
                </div>
            </div>
        </div>
        <form action="{{ route('smtp.configure.default', 'webmail') }}" method="GET">
            <div class="text-center lg:text-left p-5">
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-5">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_MAILER={{ $webmail->driver ?? NULL }}
                    <input type="hidden" name="WEBMAIL_MAIL_MAILER" class="input w-full border mt-2"
                        placeholder="MAIL MAILER" value="{{ $webmail->driver ?? NULL }}">
                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i> MAIL_HOST={{ $webmail->host ?? NULL }}
                    <input type="hidden" name="WEBMAIL_MAIL_HOST" class="input w-full border mt-2"
                        placeholder="MAIL HOST" value="{{ $webmail->host ?? NULL }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i> MAIL_PORT={{ $webmail->port ?? NULL }}
                    <input type="hidden" placeholder="MAIL PORT" class="input w-full border mt-2"
                        name="WEBMAIL_MAIL_PORT" value="{{ $webmail->port ?? NULL }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_USERNAME={{ $webmail->username ?? NULL }}
                    <input type="hidden" placeholder="MAIL USERNAME" class="input w-full border mt-2"
                        name="WEBMAIL_MAIL_USERNAME" value="{{ $webmail->username ?? NULL }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_PASSWORD={{ $webmail->password ?? NULL }}
                    <input type="hidden" name="WEBMAIL_MAIL_PASSWORD" class="input w-full border mt-2"
                        placeholder="MAIL PASSWORD" value="{{ $webmail->password ?? NULL  }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_ENCRYPTION={{ $webmail->encryption ?? NULL }}
                    <input type="hidden" name="WEBMAIL_MAIL_ENCRYPTION" class="input w-full border mt-2"
                        placeholder="MAIL ENCRYPTION" value="{{ $webmail->encryption ?? NULL  }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_FROM_ADDRESS={{ $webmail->from ?? NULL }}
                    <input type="hidden" class="input w-full border mt-2" placeholder="MAIL FROM ADDRESS"
                        name="WEBMAIL_MAIL_FROM_ADDRESS" value="{{ $webmail->from ?? NULL  }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_FROM_NAME={{ $webmail->from_name ?? NULL }}
                    <input type="hidden" class="input w-full border mt-2" placeholder="MAIL FROM NAME"
                        name="WEBMAIL_MAIL_FROM_NAME" value="{{ $webmail->from_name ?? NULL  }}">
                </div>
            </div>
            <div class="text-center lg:text-right p-5 border-t border-gray-200 dark:border-dark-5">
                <a href="{{ route('smtp.configure', 'webmail') }}"
                    class="button button--sm text-white bg-theme-6 mr-2">@translate(Configure Now)</a>


                @if (activeEmailService() == 'webmail')
                <a href="{{ route('smtp.connection.test') }}"
                class="button button--sm text-white bg-theme-7 mr-2">@translate(Test Connection)</a>

                @can('Admin')
                    @if ($webmail != null)
                        @if (env('DEFAULT_MAIL') == 'webmail')

                        <span
                            class="button button--sm w-30 inline-block mr-1 mb-2 bg-theme-4 text-white inline-flex items-center tooltip cursor-default"
                            title="Selected as system default">
                            @translate(App Default) <i data-loading-icon="puff" data-color="white" class="w-4 h-4 ml-auto"></i>
                        </span>

                        @else
                         <a href="{{ route('system.smtp.setup', 'webmail') }}"
                                class="button button--sm text-white bg-theme-4 mr-2 tooltip" title="Make as system default">
                                @translate(Choose as app default)
                            </a>
                        @endif
                    @endif
                @endcan
                
                <span
                    class="button button--sm w-24 inline-block mr-1 mb-2 bg-theme-9 text-white inline-flex items-center  cursor-default">
                    @translate(Active) <i data-loading-icon="puff" data-color="white" class="w-4 h-4 ml-auto"></i>
                </span>

                @else
                @if ($webmail != null)
                <button type="submit" class="button button--sm text-white bg-theme-1 mr-2">@translate(Choose as campaign default)</button>
                @endif
                @endif
        </form>
    </div>
</div>
</div>
{{-- Webmail::END --}}



{{-- Mailgun --}}

<div class="intro-y col-span-12 md:col-span-6 lg:col-span-6">
    <div class="box {{ defaultMail('mailgun') }}">
        <div class="flex items-start px-5 pt-5">
            <div class="w-full flex flex-col lg:flex-row items-center">
                <div class="w-16 h-16 image-fit">
                    <img alt="Swagmail" class="rounded-md" src="{{ mailLogo('mailgun') }}">
                </div>
                <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                    @translate(Mailgun)
                </div>
            </div>
        </div>
        <form action="{{ route('smtp.configure.default', 'mailgun') }}" method="GET">
            <div class="text-center lg:text-left p-5">
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-5">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_MAILER={{ $mailgun->driver ?? NULL }}
                    <input type="hidden" name="MAILGUN_MAIL_MAILER" class="input w-full border mt-2"
                        placeholder="MAIL MAILER" value="{{ $mailgun->driver ?? NULL }}">
                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i> MAIL_HOST={{ $mailgun->host ?? NULL }}
                    <input type="hidden" name="MAILGUN_MAIL_HOST" class="input w-full border mt-2"
                        placeholder="MAIL HOST" value="{{ $mailgun->host ?? NULL }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i> MAIL_PORT={{ $mailgun->port ?? NULL }}
                    <input type="hidden" placeholder="MAIL PORT" class="input w-full border mt-2"
                        name="MAILGUN_MAIL_PORT" value="{{ $mailgun->port ?? NULL }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_USERNAME={{ Str::limit($mailgun->username ?? NULL, 40) ?? NULL }}
                    <input type="hidden" placeholder="MAIL USERNAME" class="input w-full border mt-2"
                        name="MAILGUN_MAIL_USERNAME" value="{{ $mailgun->username ?? NULL }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_PASSWORD={{ Str::limit($mailgun->password ?? null, 40) ?? NULL }}
                    <input type="hidden" name="MAILGUN_MAIL_PASSWORD" class="input w-full border mt-2"
                        placeholder="MAIL PASSWORD" value="{{ $mailgun->password ?? NULL  }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_ENCRYPTION={{ $mailgun->encryption ?? NULL }}
                    <input type="hidden" name="MAILGUN_MAIL_ENCRYPTION" class="input w-full border mt-2"
                        placeholder="MAIL ENCRYPTION" value="{{ $mailgun->encryption ?? NULL  }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_FROM_ADDRESS={{ $mailgun->from ?? NULL }}
                    <input type="hidden" class="input w-full border mt-2" placeholder="MAIL FROM ADDRESS"
                        name="MAILGUN_MAIL_FROM_ADDRESS" value="{{ $mailgun->from ?? NULL  }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_FROM_NAME={{ $mailgun->from_name ?? NULL }}
                    <input type="hidden" class="input w-full border mt-2" placeholder="MAIL FROM NAME"
                        name="MAILGUN_MAIL_FROM_NAME" value="{{ $mailgun->from_name ?? NULL  }}">
                </div>
            </div>
            <div class="text-center lg:text-right p-5 border-t border-gray-200 dark:border-dark-5">
                <a href="{{ route('smtp.configure', 'mailgun') }}"
                    class="button button--sm text-white bg-theme-6 mr-2">@translate(Configure Now)</a>

                @can('Admin')
                    @if ($mailgun != null)
                        @if (env('DEFAULT_MAIL') == 'mailgun')

                        <span
                            class="button button--sm w-30 inline-block mr-1 mb-2 bg-theme-4 text-white inline-flex items-center tooltip cursor-default"
                            title="Selected as system default">
                            @translate(App Default) <i data-loading-icon="puff" data-color="white" class="w-4 h-4 ml-auto"></i>
                        </span>

                        @else
                         <a href="{{ route('system.smtp.setup', 'mailgun') }}"
                                class="button button--sm text-white bg-theme-4 mr-2 tooltip" title="Make as system default">
                                @translate(Choose as app default)
                            </a>
                        @endif
                    @endif
                @endcan

                        
                @if (activeEmailService() == 'mailgun')
                <a href="{{ route('smtp.connection.test') }}"
                    class="button button--sm text-white bg-theme-7 mr-2">@translate(Test Connection)</a>

                <span
                    class="button button--sm w-24 inline-block mr-1 mb-2 bg-theme-9 text-white inline-flex items-center  cursor-default">
                    @translate(Active) <i data-loading-icon="puff" data-color="white" class="w-4 h-4 ml-auto"></i>
                </span>
                
                @else
                @if ($mailgun != null)
                <button type="submit" class="button button--sm text-white bg-theme-1 mr-2">@translate(Choose as campaign default)</button>
                @endif
                @endif
        </form>
    </div>
</div>
</div>
{{-- Mailgun::END --}}


{{-- Zoho --}}

<div class="intro-y col-span-12 md:col-span-6 lg:col-span-6">
    <div class="box {{ defaultMail('zoho') }}">
        <div class="flex items-start px-5 pt-5">
            <div class="w-full flex flex-col lg:flex-row items-center">
                <div class="w-16 h-16 image-fit">
                    <img alt="zoho" class="rounded-md" src="{{ mailLogo('zoho') }}">
                </div>
                <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                    @translate(Zoho)
                </div>
            </div>
        </div>
        <form action="{{ route('smtp.configure.default', 'zoho') }}" method="GET">
            <div class="text-center lg:text-left p-5">
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-5">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_MAILER={{ $zoho->driver ?? NULL }}
                    <input type="hidden" name="ZOHO_MAIL_MAILER" class="input w-full border mt-2"
                        placeholder="MAIL MAILER" value="{{ $zoho->driver ?? NULL }}">
                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i> MAIL_HOST={{ $zoho->host ?? NULL }}
                    <input type="hidden" name="ZOHO_MAIL_HOST" class="input w-full border mt-2" placeholder="MAIL HOST"
                        value="{{ $zoho->host ?? NULL }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i> MAIL_PORT={{ $zoho->port ?? NULL }}
                    <input type="hidden" placeholder="MAIL PORT" class="input w-full border mt-2" name="ZOHO_MAIL_PORT"
                        value="{{ $zoho->port ?? NULL }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_USERNAME={{ Str::limit($zoho->username ?? NULL, 40) ?? NULL }}
                    <input type="hidden" placeholder="MAIL USERNAME" class="input w-full border mt-2"
                        name="ZOHO_MAIL_USERNAME" value="{{ $zoho->username ?? NULL }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_PASSWORD={{ Str::limit($zoho->password ?? NULL, 40) ?? NULL }}
                    <input type="hidden" name="ZOHO_MAIL_PASSWORD" class="input w-full border mt-2"
                        placeholder="MAIL PASSWORD" value="{{ $zoho->password ?? NULL  }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_ENCRYPTION={{ $zoho->encryption ?? NULL }}
                    <input type="hidden" name="ZOHO_MAIL_ENCRYPTION" class="input w-full border mt-2"
                        placeholder="MAIL ENCRYPTION" value="{{ $zoho->encryption ?? NULL  }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_FROM_ADDRESS={{ $zoho->from ?? NULL }}
                    <input type="hidden" class="input w-full border mt-2" placeholder="MAIL FROM ADDRESS"
                        name="ZOHO_MAIL_FROM_ADDRESS" value="{{ $zoho->from ?? NULL  }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_FROM_NAME={{ $zoho->from_name ?? NULL }}
                    <input type="hidden" class="input w-full border mt-2" placeholder="MAIL FROM NAME"
                        name="ZOHO_MAIL_FROM_NAME" value="{{ $zoho->from_name ?? NULL  }}">
                </div>
            </div>
            <div class="text-center lg:text-right p-5 border-t border-gray-200 dark:border-dark-5">
                <a href="{{ route('smtp.configure', 'zoho') }}"
                    class="button button--sm text-white bg-theme-6 mr-2">@translate(Configure Now)</a>

                @can('Admin')
                    @if ($zoho != null)
                        @if (env('DEFAULT_MAIL') == 'zoho')

                        <span
                            class="button button--sm w-30 inline-block mr-1 mb-2 bg-theme-4 text-white inline-flex items-center tooltip cursor-default"
                            title="Selected as system default">
                            @translate(App Default) <i data-loading-icon="puff" data-color="white" class="w-4 h-4 ml-auto"></i>
                        </span>

                        @else
                         <a href="{{ route('system.smtp.setup', 'zoho') }}"
                                class="button button--sm text-white bg-theme-4 mr-2 tooltip" title="Make as system default">
                                @translate(Choose as app default)
                            </a>
                        @endif
                    @endif
                @endcan

                        
                @if (activeEmailService() == 'zoho')

                <a href="{{ route('smtp.connection.test') }}"
                    class="button button--sm text-white bg-theme-7 mr-2">@translate(Test Connection)</a>

                <span
                    class="button button--sm w-24 inline-block mr-1 mb-2 bg-theme-9 text-white inline-flex items-center  cursor-default">
                    @translate(Active) <i data-loading-icon="puff" data-color="white" class="w-4 h-4 ml-auto"></i>
                </span>
                
                @else
                @if ($zoho != null)
                <button type="submit" class="button button--sm text-white bg-theme-1 mr-2">@translate(Choose as campaign default)</button>
@endif
                @endif
        </form>
    </div>
</div>
</div>
{{-- Zoho::END --}}





{{-- Elastic --}}

<div class="intro-y col-span-12 md:col-span-6 lg:col-span-6">
    <div class="box {{ defaultMail('elastic') }}">
        <div class="flex items-start px-5 pt-5">
            <div class="w-full flex flex-col lg:flex-row items-center">
                <div class="w-16 h-16 image-fit">
                    <img alt="zoho" class="rounded-md" src="{{ mailLogo('elastic') }}">
                </div>
                <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                    @translate(Elastic)
                </div>
            </div>
        </div>
        <form action="{{ route('smtp.configure.default', 'elastic') }}" method="GET">
            <div class="text-center lg:text-left p-5">
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-5">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_MAILER={{ $elastic->driver ?? NULL }}
                    <input type="hidden" name="ELASTIC_MAIL_MAILER" class="input w-full border mt-2"
                        placeholder="MAIL MAILER" value="{{ $elastic->driver ?? NULL }}">
                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i> MAIL_HOST={{ $elastic->host ?? NULL }}
                    <input type="hidden" name="ELASTIC_MAIL_HOST" class="input w-full border mt-2"
                        placeholder="MAIL HOST" value="{{ $elastic->host ?? NULL }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i> MAIL_PORT={{ $elastic->port ?? NULL }}
                    <input type="hidden" placeholder="MAIL PORT" class="input w-full border mt-2"
                        name="ELASTIC_MAIL_PORT" value="{{ $elastic->port ?? NULL }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_USERNAME={{ Str::limit($elastic->username ?? NULL, 40) ?? NULL }}
                    <input type="hidden" placeholder="MAIL USERNAME" class="input w-full border mt-2"
                        name="ELASTIC_MAIL_USERNAME" value="{{ $elastic->username ?? NULL }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_PASSWORD={{ Str::limit($elastic->password ?? NULL, 40) ?? NULL }}
                    <input type="hidden" name="ELASTIC_MAIL_PASSWORD" class="input w-full border mt-2"
                        placeholder="MAIL PASSWORD" value="{{ $elastic->password ?? NULL  }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_ENCRYPTION={{ $elastic->encryption ?? NULL }}
                    <input type="hidden" name="ELASTIC_MAIL_ENCRYPTION" class="input w-full border mt-2"
                        placeholder="MAIL ENCRYPTION" value="{{ $elastic->encryption ?? NULL  }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_FROM_ADDRESS={{ $elastic->from ?? NULL }}
                    <input type="hidden" class="input w-full border mt-2" placeholder="MAIL FROM ADDRESS"
                        name="ELASTIC_MAIL_FROM_ADDRESS" value="{{ $elastic->from ?? NULL  }}">

                </div>
                <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                    <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                    MAIL_FROM_NAME={{ $elastic->from_name ?? NULL }}
                    <input type="hidden" class="input w-full border mt-2" placeholder="MAIL FROM NAME"
                        name="ELASTIC_MAIL_FROM_NAME" value="{{ $elastic->from_name ?? NULL  }}">
                </div>
            </div>
            <div class="text-center lg:text-right p-5 border-t border-gray-200 dark:border-dark-5">
                <a href="{{ route('smtp.configure', 'elastic') }}"
                    class="button button--sm text-white bg-theme-6 mr-2">@translate(Configure Now)</a>

                    @can('Admin')
                    @if ($elastic != null)
                        @if (env('DEFAULT_MAIL') == 'elastic')

                        <span
                            class="button button--sm w-30 inline-block mr-1 mb-2 bg-theme-4 text-white inline-flex items-center tooltip cursor-default"
                            title="Selected as system default">
                            @translate(App Default) <i data-loading-icon="puff" data-color="white" class="w-4 h-4 ml-auto"></i>
                        </span>

                        @else
                         <a href="{{ route('system.smtp.setup', 'elastic') }}"
                                class="button button--sm text-white bg-theme-4 mr-2 tooltip" title="Make as system default">
                                @translate(Choose as app default)
                            </a>
                        @endif
                @endif
                        @endcan
                        
                @if (activeEmailService() == 'elastic')

                <a href="{{ route('smtp.connection.test') }}"
                    class="button button--sm text-white bg-theme-7 mr-2">@translate(Test Connection)</a>

                <span
                    class="button button--sm w-24 inline-block mr-1 mb-2 bg-theme-9 text-white inline-flex items-center  cursor-default">
                    @translate(Active) <i data-loading-icon="puff" data-color="white" class="w-4 h-4 ml-auto"></i>
                </span>

                @else
                    @if ($elastic != null)
                    <button type="submit" class="button button--sm text-white bg-theme-1 mr-2">@translate(Choose as campaign default)</button>
                    @endif
                @endif

        </form>
    </div>
</div>
</div>
{{-- Elastic::END --}}


</div>
@endsection

@section('script')

@endsection
