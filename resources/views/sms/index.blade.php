@extends('../layout/' . layout())

@section('subhead')
<title>@translate(SMS Settings)</title>
@endsection

@section('subcontent')
<h2 class="intro-y text-lg font-medium mt-10">@translate(SMS Gateways)</h2>


<div class="grid grid-cols-12 gap-6 mt-5">


    {{-- twilio --}}

    <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4">
        <div class="box">
            <div class="flex items-start px-5 pt-5">
                <div class="w-full flex flex-col lg:flex-row items-center">
                    <div class="w-64 h-16 image-fit">
                        <img alt="@translate(Twilio)" class="rounded-md" src="{{ smsLogo('twilio') }}">
                    </div>
                    <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                        @translate(Twilio)
                    </div>
                </div>
            </div>
            <form action="{{ route('sms.configure.default', 'twilio') }}" method="POST">
                @csrf
                <div class="text-center lg:text-left p-5">
                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-5">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        TWILIO_ID={{ $twilio->sms_id ?? NULL }}
                        <input type="hidden" name="TWILIO_SID" class="input w-full border mt-2"
                            placeholder="TWILIO SID" value="{{ $twilio->sms_id ?? NULL }}">
                    </div>
                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        TWILIO_TOKEN={{ $twilio->sms_token ?? NULL }}
                        <input type="hidden" name="TWILIO_TOKEN" class="input w-full border mt-2"
                            placeholder="TWILIO TOKEN" value="{{ $twilio->sms_token ?? NULL }}">

                    </div>
                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        TWILIO_FROM={{ $twilio->sms_from ?? NULL }}
                        <input type="hidden" placeholder="TWILIO FROM" class="input w-full border mt-2"
                            name="TWILIO_FROM" value="{{ $twilio->sms_from ?? NULL }}">

                    </div>

                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        TWILIO_NUMBER={{ $twilio->sms_number ?? NULL }}
                        <input type="hidden" name="TWILIO_NUMBER" class="input w-full border mt-2"
                            placeholder="TWILIO NUMBER" value="{{ $twilio->sms_number ?? NULL }}">
                    </div>
                  
                </div>
                <div class="text-center lg:text-right p-5 border-t border-gray-200 dark:border-dark-5">

                    <a href="{{ route('sms.configure', 'twilio') }}"
                        class="button button--sm text-white bg-theme-6 mr-2">@translate(Configure Now)</a>

                        @if (getSmsInfo('twilio'))
                        <a href="{{ route('sms.connection.test', 'twilio') }}"
                        class="button button--sm text-white bg-theme-7 mr-2">@translate(Test Connection)</a>
                        @endif

            </form>
        </div>
    </div>
</div>
{{-- twilio::END --}}


    {{-- nexmo --}}

    <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4">
        <div class="box">
            <div class="flex items-start px-5 pt-5">
                <div class="w-full flex flex-col lg:flex-row items-center">
                    <div class="w-64 h-16 image-fit">
                        <img alt="@translate(Nexmo)" class="rounded-md" src="{{ smsLogo('nexmo') }}">
                    </div>
                    <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                        @translate(Nexmo/Vonage)
                    </div>
                </div>
            </div>
            <form action="{{ route('sms.configure.default', 'nexmo') }}" method="POST">
                @csrf
                <div class="text-center lg:text-left p-5">
                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-5">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        NEXMO_KEY={{ $nexmo->sms_id ?? NULL }}
                        <input type="hidden" name="NEXMO_KEY" class="input w-full border mt-2"
                            placeholder="NEXMO KEY" value="{{ $nexmo->sms_id ?? NULL }}">
                    </div>
                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        NEXMO_SECRET={{ $nexmo->sms_token ?? NULL }}
                        <input type="hidden" name="NEXMO_SECRET" class="input w-full border mt-2"
                            placeholder="NEXMO SECRET" value="{{ $nexmo->sms_token ?? NULL }}">
                    </div>
                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        NEXMO_FROM={{ $nexmo->sms_from ?? NULL }}
                        <input type="hidden" name="NEXMO_FROM" class="input w-full border mt-2"
                            placeholder="NEXMO FROM" value="{{ $nexmo->sms_from ?? NULL }}">
                    </div>

                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        NEXMO_NUMBER={{ $plivo->sms_number ?? NULL }}
                        <input type="hidden" name="NEXMO_NUMBER" class="input w-full border mt-2"
                            placeholder="NEXMO NUMBER" value="{{ $nexmo->sms_number ?? NULL }}">
                    </div>
                  
                </div>
                <div class="text-center lg:text-right p-5 border-t border-gray-200 dark:border-dark-5">

                    <a href="{{ route('sms.configure', 'nexmo') }}"
                        class="button button--sm text-white bg-theme-6 mr-2">@translate(Configure Now)</a>
                    
                    @if (getSmsInfo('nexmo'))
                    <a href="{{ route('sms.connection.test', 'nexmo') }}"
                        class="button button--sm text-white bg-theme-7 mr-2">@translate(Test Connection)</a>
                    @endif

            </form>
        </div>
    </div>

     </div>

{{-- nexmo::END --}}




    {{-- PLIVO --}}

    <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4">
        <div class="box">
            <div class="flex items-start px-5 pt-5">
                <div class="w-full flex flex-col lg:flex-row items-center">
                    <div class="w-64 h-16 image-fit">
                        <img alt="@translate(PLIVO)" class="rounded-md" src="{{ smsLogo('plivo') }}">
                    </div>
                    <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                        @translate(PLIVO)
                    </div>
                </div>
            </div>
            <form action="{{ route('sms.configure.default', 'plivo') }}" method="POST">
                @csrf
                <div class="text-center lg:text-left p-5">
                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-5">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        PLIVO_KEY={{ $plivo->sms_id ?? NULL }}
                        <input type="hidden" name="PLIVO_KEY" class="input w-full border mt-2"
                            placeholder="PLIVO KEY" value="{{ $plivo->sms_id ?? NULL }}">
                    </div>
                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        PLIVO_TOKEN={{ $plivo->sms_token ?? NULL }}
                        <input type="hidden" name="PLIVO_TOKEN" class="input w-full border mt-2"
                            placeholder="PLIVO TOKEN" value="{{ $plivo->sms_token ?? NULL }}">
                    </div>
                    
                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        PLIVO_FROM={{ $plivo->sms_from ?? NULL }}
                        <input type="hidden" name="PLIVO_FROM" class="input w-full border mt-2"
                            placeholder="PLIVO FROM" value="{{ $plivo->sms_from ?? NULL }}">
                    </div>

                    <div class="flex items-center justify-center lg:justify-start text-gray-600 mt-1">
                        <i data-feather="at-sign" class="w-3 h-3 mr-2"></i>
                        PLIVO_NUMBER={{ $plivo->sms_number ?? NULL }}
                        <input type="hidden" name="PLIVO_NUMBER" class="input w-full border mt-2"
                            placeholder="PLIVO NUMBER" value="{{ $plivo->sms_number ?? NULL }}">
                    </div>
                  
                </div>
                <div class="text-center lg:text-right p-5 border-t border-gray-200 dark:border-dark-5">

                    <a href="{{ route('sms.configure', 'plivo') }}"
                        class="button button--sm text-white bg-theme-6 mr-2">@translate(Configure Now)</a>
                    
                    @if (getSmsInfo('plivo'))
                    <a href="{{ route('sms.connection.test', 'plivo') }}"
                        class="button button--sm text-white bg-theme-7 mr-2">@translate(Test Connection)</a>
                    @endif
            </form>
        </div>
    </div>

{{-- PLIVO::END --}}

</div>

  
</div>

@endsection

@section('script')

@endsection
