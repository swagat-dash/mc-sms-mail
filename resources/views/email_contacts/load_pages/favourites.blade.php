            <!-- BEGIN: Inbox Filter -->
            <div class="intro-y flex flex-col-reverse sm:flex-row items-center">
                <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                    <input type="text" onkeyup="search(this)" class="input w-full sm:w-64 box px-10 text-gray-700 dark:text-gray-300 placeholder-theme-13" placeholder="Search mail">
                </div>
                
            </div>
            <!-- END: Inbox Filter -->
            <!-- BEGIN: Inbox Content -->
            <div class="intro-y inbox box mt-5">
                <div class="p-5 flex flex-col-reverse sm:flex-row text-gray-600 border-b border-gray-200 dark:border-dark-1">
                    <div class="flex items-center mt-3 sm:mt-0 border-t sm:border-0 border-gray-200 pt-5 sm:pt-0 mt-5 sm:mt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                        <input class="input border border-gray-500 checkAll" id="check_all" type="checkbox">
                        <a href="javascript:;" onclick="pageLoad()" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300" title="@translate(Reload)">
                            <x-feathericon-refresh-cw/>
                        </a>
                         <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300 dislike-all" title="@translate(Removed from favourite)">
                            <x-feathericon-rotate-ccw/>
                        </a>
                         <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300 block-all" title="@translate(Blacklist email)">
                            <x-feathericon-x-octagon/>
                        </a>
                        <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300 delete-all" title="@translate(Delete selected email)">
                            <x-feathericon-trash/>
                        </a>
                    </div>
                    <div class="flex items-center sm:ml-auto">

                        <div class="dark:text-gray-300 ml-5">@translate(Total) {{ number_format(favCount()) }} @translate(email)</div>
                       
                    </div>
                </div>
                <div class="overflow-x-auto sm:overflow-x-visible myTable">
                    @forelse ($favourites as $favourite)
                        <div class="intro-y">
                            <div class="cursor-pointer inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">
                                <div class="flex px-5 py-3">
                                    <div class="w-56 flex-none flex items-center mr-10">
                                        <input class="input flex-none border border-gray-500 checking" data-id="{{ $favourite->id }}" name="check" type="checkbox">
                                        <a href="javascript:;" id="markAsFav" data-id="{{ $favourite->id }}" class="w-5 h-5 flex-none ml-4 flex items-center justify-center text-gray-500">
                                            <x-feathericon-star  class="{{ $favourite->favourites == 1 ? 'text-blue-300' : null }}"/>
                                        </a>

                                        <a href="{{ route('email.contact.show', $favourite->id) }}" class="w-5 h-5 flex-none ml-4 flex items-center justify-center text-gray-500">
                                            <x-feathericon-edit/>
                                        </a>
                                     
                                        <div class="w-6 h-6 flex-none image-fit relative ml-5">
                                            <img alt="{{ $favourite->email }}" class="rounded-full" src="{{ emailAvatar($favourite->email) }}">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-3 w-full gap-4">
                                        <div class="w-64 sm:w-auto truncate mr-10">
                                        <span class="inbox__item--highlight">{{ $favourite->email }}</span>
                                    </div>

                                    <div class="w-64 sm:w-auto truncate mr-10">
                                        <span class="inbox__item--highlight">{{ $favourite->name }}</span>
                                    </div>

                                    <div class="w-64 sm:w-auto truncate mr-10">
                                        <span class="inbox__item--highlight">{{ $favourite->phone }}</span>
                                    </div>
                                    </div>

                                    
                                    <div class="inbox__item--time whitespace-no-wrap ml-auto pl-10">{{ $favourite->created_at->format('H:i a') }}</div>
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
                    <div class="dark:text-gray-300">@translate(Total) {{ number_format(favCount()) }} @translate(email)</div>
                </div>
            </div>
            <!-- END: Inbox Content -->

            <script src="{{ filePath('bladejs/email_contacts/load_pages/favourites.js') }}"></script>