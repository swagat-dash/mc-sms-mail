@extends('layout.' .  layout())

@section('subhead')
    <title>@translate(SMS Settings) - {{ $sms }}</title>
@endsection

@section('subcontent')

<div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
        <a href="{{ route('sms.index') }}" class="button text-white bg-theme-1 shadow-md mr-2" >
            @translate(SMS List)
        </a>
        
        </div>

  <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">{{ Str::upper( $sms ) }}</h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
      
        <div class="col-span-12 lg:col-span-12 xxl:col-span-12">
         
       
        

            <!-- BEGIN: Social Information -->
            <div class="intro-y box lg:mt-5" id="#social">
                <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">@translate(Sms Gateway Information)</h2>
                </div>
                <div class="p-5">
                    <form method="POST" action="{{ route('sms.configure.store', $sms) }}">
                        @csrf
                    <div class="grid grid-cols-12 gap-5">
                        <div class="col-span-12 xl:col-span-6">
                            <div class="mt-3">
                                <label class="tooltip" title="@translate(Not allowd to write)">@translate(SMS NAME)</label>
                                <input disabled type="text" name="sms_name" class="input w-full border mt-2 disabled:opacity-50 cursor-not-allowed tooltip" title="@translate(Not allowd to write)" placeholder="SMS NAME" 
                                value="{{ $sms }}"
                                >
                            </div>
                            <div class="mt-3">
                                <label>@translate(TOKEN/SECRET)</label>
                                <input type="text" name="sms_token" class="input w-full border mt-2" placeholder="TOKEN/SECRET" value="{{ $sms_config->sms_token ?? null }}">
                            </div>
                        </div>
                        <div class="col-span-12 xl:col-span-6">
                            <div class="mt-3">
                                <label>@translate(ID/KEY)</label>
                                <input type="text" placeholder="ID/KEY" class="input w-full border mt-2" name="sms_id" value="{{ $sms_config->sms_id ?? null }}">
                            </div>
                            <div class="mt-3">
                                <label>@translate(SMS FROM)</label>
                                <input type="text" placeholder="SMS FROM" class="input w-full border mt-2" name="sms_from" value="{{ $sms_config->sms_from ?? null }}">
                            </div>
                            <div class="mt-3">
                                <label>@translate(SMS NUMBER) </label>
                                <input type="text" placeholder="SMS NUMBER" class="input w-full border mt-2" name="sms_number" value="{{ $sms_config->sms_number ?? null }}">
                                <small>Ex: +8801825731327</small>
                            </div>
                        </div>
                       
                        
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="button w-20 bg-theme-1 text-white ml-auto">@translate(Save)</button>
                    </div>
                    </form>
                </div>
            </div>
            <!-- END: Social Information -->


        </div>
    </div>
@endsection

@section('script')
   
@endsection