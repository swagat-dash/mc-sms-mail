@extends('layout.' .  layout())

@section('subhead')
    <title>@translate(Campaign) - {{ $edit_campaign->name }}</title>
@endsection

@section('subcontent')
  <div class="flex items-center mt-8">
        <h2 class="intro-y text-lg font-medium mr-auto">{{ Str::upper($edit_campaign->name) }}</h2>
    </div>
    <!-- BEGIN: Wizard Layout -->
    <div class="intro-y box py-10 sm:py-20 mt-5">
        <div class="wizard flex lg:flex-row justify-center px-5 sm:px-20">
            <div class="intro-x lg:text-center flex items-center lg:block flex-1 z-10">
                <button class="w-10 h-10 rounded-full button text-gray-600 bg-gray-200 dark:bg-dark-1">1</button>
                <div class="lg:w-32 font-medium text-base lg:mt-3 ml-3 lg:mx-auto">@translate(Campaign Information)</div>
            </div>
            <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                <button class="w-10 h-10 rounded-full button text-gray-600 bg-gray-200 dark:bg-dark-1">2</button>
                <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-gray-700 dark:text-gray-600">@translate(Choose Template)</div>
            </div>
            <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                <button class="w-10 h-10 rounded-full button text-gray-600 bg-gray-200 dark:bg-dark-1">3</button>
                <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-gray-700 dark:text-gray-600">@translate(Update Audiance)</div>
            </div>
          
            <div class="wizard__line hidden lg:block w-2/3 bg-gray-200 dark:bg-dark-1 absolute mt-5"></div>
        </div>
        <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200 dark:border-dark-5">
            <!-- BEGIN: Form Layout -->
            <form action="{{ route('campaign.emails.update', $edit_campaign->id) }}" method="POST">
                @csrf
                <div class="intro-y box p-5">
                    <div>
                        <label>@translate(Campaign Name)</label>
                        <input type="text" class="input w-full border mt-2" name="name" value="{{ $edit_campaign->name }}" placeholder="Campaign Name">
                    </div>

                    
                    <div class="mt-3">
                        <label>@translate(Description)</label>
                        <div class="mt-2">
                            <textarea data-simple-toolbar="true" class="editor" name="description">
                                {{ $edit_campaign->description }}
                            </textarea>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label>Active Status</label>
                        <div class="mt-2">
                            <input type="checkbox" value="1" class="input input--switch border" name="status" {{ $edit_campaign->status == 1 ? 'checked' : '' }}>
                        </div>
                    </div>


                     <div class="text-right mt-5">
                        <button type="submit" class="button w-40 bg-theme-1 text-white">@translate(Update Information)</button>
                    </div>


                    {{-- TEMPLATE --}}

                    <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200 dark:border-dark-5">
            <!-- BEGIN: Form Layout -->

                    <div class="grid grid-cols-12 gap-6 mt-5">
                        @foreach (smsTemplates() as $templates)
                        <div class="intro-y col-span-12 md:col-span-6 lg:col-span-6">
                            <div class="box">
                                <div class="flex items-start px-5 pt-5">
                                    <div class="w-full flex flex-col lg:flex-row items-center">

                                        <div class="section over-hide z-bigger">
                                            <div class="section over-hide z-bigger">
                                                    <div class="container pb-5">
                                                        <div class="row justify-content-center pb-5">
                                                            <div class="col-12 pb-5">
                                                                <input class="checkbox-tools" type="radio" value="{{ $templates->id }}" name="sms_template_id" id="tool-{{ $templates->id }}" {{ $edit_campaign->sms_template_id ==  $templates->id ? 'checked' : '' }}>
                                                                <label class="for-checkbox-tools w-full" for="tool-{{ $templates->id }}">
                                                                    <div class="">
                                                                        <div class="h-80 xxl:h-56 image-fit">
                                                                            <div class="rounded-md w-1/2 m-auto preview-template ">
                                                                                <span class="text-lg font-medium leading-none">
                                                                                    {{  $templates->name }}
                                                                                </span>
                                                                                <hr>
                                                                                {{ strip_tags($templates->body) }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>	
                                                </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="text-right mt-5">
                        <button type="submit" class="button w-40 bg-theme-1 text-white">@translate(Update Template)</button>
                    </div>
            <!-- END: Form Layout -->
        </div>

                    {{-- TEMPLATE::END --}}


                    {{-- AUDIANCE --}}
                    <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200 dark:border-dark-5">
            <!-- BEGIN: Form Layout -->
           

                {{-- EMAILS OR GROUPS --}}
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 md:col-span-12 lg:col-span-12">
                        <a href="#emailsSection" onclick="emailsList()" id="">
                            <div class="box shadow bg-theme-1 text-white">
                                <div class="flex items-start px-5 pt-5">
                                    <div class="w-full flex flex-col lg:flex-row items-center">

                                        
                                        <div class="lg:ml-4 text-center flex items-center lg:text-left mt-3 mb-3 lg:mt-0">
                                            <i data-feather="phone" class="mr-2"></i> @translate(CLICK TO GET PHONE NUMBERS)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                {{-- EMAILS OR GROUPS::END --}}
                

                    {{-- emails --}}
                    <div id="emails_list" class="hidden">
            
            <div id="emailsSection"></div>
            <!-- BEGIN: Inbox Content -->
            <div class="intro-y inbox box mt-5">
                <div class="p-5 flex flex-col-reverse sm:flex-row text-gray-600 border-b border-gray-200 dark:border-dark-1">
                    <div class="flex items-center sm:mt-0 border-t sm:border-0 border-gray-200 pt-5 sm:pt-0 mt-5 sm:mt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                        <input class="input border border-gray-500 checkAll" id="check_all" type="checkbox">

                        <label for="check_all" class="ml-5 tooltip" title="@translate(Select all email)">
                            @translate(Select All)
                        </label>
                       
                    
                    </div>
                    <div class="flex items-center sm:ml-auto">

                        <div class="dark:text-gray-300 ml-5">@translate(Total) {{ number_format(phoneCount()) }} @translate(phone number)</div>
                       
                    </div>
                </div>
                <div class="overflow-x-auto sm:overflow-x-visible myTable">
                    @forelse (campaingSMS() as $email)
                        <div class="intro-y">
                            <div class="inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">
                                <div class="flex px-5 py-3">
                                    <div class="w-56 flex-none flex items-center mr-10">


                                        <input class="input flex-none border border-gray-500 checking" 
                                        @foreach ($edit_campaign->campaign_emails as $campaign_email)
                                            {{ $campaign_email->email_id == $email->id ? 'checked' : '' }}
                                          @endforeach
                                        data-id="{{ $email->id }}"  data-email="{{ $email->phone }}" name="emails[]" value="{{ $email->id }}" type="checkbox">

                                        
                                        <a href="javascript:;" class="w-5 h-5 flex-none ml-4 flex items-center justify-center text-gray-500">
                                            <x-feathericon-star class="{{ $email->favourites == 1 ? 'text-blue-300' : null }}"/>
                                        </a>
                                        
                                        <div class="w-6 h-6 flex-none image-fit relative ml-5 email">
                                            <img alt="{{ $email->phone }}" class="rounded-full" src="{{ emailAvatar($email->phone) }}">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-3 w-full gap-4">
                                        <div class="w-64 sm:w-auto truncate mr-10">
                                        <span class="inbox__item--highlight">+{{ $email->country_code }}{{ $email->phone }}</span>
                                    </div>

                                    <div class="w-64 sm:w-auto truncate mr-10">
                                        <span class="inbox__item--highlight">{{ $email->name ?? 'No name' }}</span>
                                    </div>

                                    </div>

                                    
                                    <div class="inbox__item--time whitespace-no-wrap ml-auto pl-10">{{ $email->created_at->format('H:i a') }}</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center">@translate(No Number Found)</div>
                    @endforelse

                </div>
                <div class="p-5 flex flex-col sm:flex-row items-center text-center sm:text-left text-gray-600">
                    <div class="dark:text-gray-300">@translate(Total) {{ number_format(phoneCount()) }} @translate(phone number)</div>
                </div>
            </div>
            <!-- END: Inbox Content -->
                      
                    </div>
                    {{-- emails:END --}}

                </div>
           
            <!-- END: Form Layout -->
        </div>
                    {{-- AUDIANCE::END --}}

                    <div class="text-right mt-5">
                        <button type="submit" class="button w-40 bg-theme-1 text-white">@translate(Update Numbers)</button>
                    </div>
                   
                </div>
            </form>
            <!-- END: Form Layout -->
        </div>
    </div>
    <!-- END: Wizard Layout -->

@endsection

@section('script')

<script src="{{ filePath('bladejs/campaigns/sms/edit.js') }}"></script>
   
@endsection