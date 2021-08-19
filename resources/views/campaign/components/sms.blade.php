            <button type="submit" class="button w-50 ml-8 mt-5 mr-2 mb-3 flex items-center justify-center bg-theme-1 text-white campaign-email"> 
                           <i data-feather="activity" class="w-4 h-4 mr-2"></i> @translate(Save Campaign) </button>
            
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

                        <div class="dark:text-gray-300 ml-5">@translate(Total) {{ number_format(phoneCount()) }} @translate(email)</div>
                       
                    </div>
                </div>
                <div class="overflow-x-auto sm:overflow-x-visible myTable">
                    @forelse (campaingSMS() as $email)
                        <div class="intro-y">
                            <div class="inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">
                                <div class="flex px-5 py-3">
                                    <div class="w-56 flex-none flex items-center mr-10">
                                        <input class="input flex-none border border-gray-500 checking" 
                                        data-id="{{ $email->id }}"  
                                        data-email="{{ $email->phone }}" 
                                        name="check" 
                                        type="checkbox">

                                        

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
                                        <span class="inbox__item--highlight">{{ $email->name ?? 'No name'}}</span>
                                    </div>

                                    </div>

                                    
                                    <div class="inbox__item--time whitespace-no-wrap ml-auto pl-10">{{ $email->created_at->format('H:i a') }}</div>
                                </div>
                            </div>
                        </div>
                    @empty
                         <div class="text-center">
                            <img src="{{ notFound('mail-not-found.png') }}" class="m-auto" alt="#email-not-found">
                        </div>
                    @endforelse

                </div>
                <div class="p-5 flex flex-col sm:flex-row items-center text-center sm:text-left text-gray-600">
                    <div class="dark:text-gray-300">@translate(Total) {{ number_format(phoneCount()) }} @translate(email)</div>
                </div>
            </div>
            <!-- END: Inbox Content -->



            {{-- Groups --}}


            <div class="grid grid-cols-12 gap-6 mt-5" id="groupsSection">
                @foreach (emailGroups('sms') as $group)
                <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4">
                    <div class="box">
                        <div class="flex items-start px-5 pt-5">
                            <div class="w-full flex flex-col lg:flex-row items-center">
                                <div class="">
                                    <img alt="#{{ $group->name }}" class="rounded-md" src="{{ commonAvatar($group->name) }}">
                                </div>

                                <div class="lg:ml-4 text-center lg:text-left mt-3 mb-3 lg:mt-0">
                                    <input type="checkbox" value="{{ $group->id }}" id="{{ $group->id }}" data-group-id="{{ $group->id }}" class="input mt-3 group_id input--switch border" name="group_id">
                                    <label for="{{ $group->id }}">
                                        {{ $group->name }}
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {{-- Groups:END --}}

            <button type="submit" class="button w-50 ml-8 mt-5 mr-2 mb-3 flex items-center justify-center bg-theme-1 text-white campaign-email"> 
                           <i data-feather="activity" class="w-4 h-4 mr-2"></i> @translate(Save Campaign) </button>



            <input type="hidden" value="{{ route('campaign.emails.store') }}" id="campaign_email_url">
            <input type="hidden" value="{{ route('campaign.index') }}" id="campaign_list_url">
           


            <script src="{{ filePath('assets/js/jquery.js') }}"></script>
            <script src="{{ filePath('bladejs/campaigns/components/sms.js') }}"></script>
