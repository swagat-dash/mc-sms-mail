@extends('../layout/side-menu')

@section('head')
    <title>Swagmail - Email & SMS Marketing Application</title>
@endsection

@section('content')
    <div class="container">
        <!-- BEGIN: Error Page -->
        <div class="page flex flex-col lg:flex-row items-center justify-center h-screen text-center lg:text-left w-9/12 m-auto">
            <div class="-intro-x lg:mr-20 mb-4">

                @if (checkDBConnection() == true && Schema::hasTable('organization_setups'))
                    <img alt="{{ orgName() }}" class="w-40" src="{{ logo() }}">
                    @else
                    <img alt="#swagmail" class="w-40" src="{{ swagmail() }}">
                @endif

            </div>
            <div class="text-white mt-10 lg:mt-0">
                <div class="intro-x text-4xl font-medium">Swagmail - Email & SMS Marketing Application</div>
                <div class="intro-x text-xl lg:text-3xl font-medium">Checking files & folder permissions.</div>
                <div class="intro-x text-xl lg:text-3xl font-medium">We ran diagnosis on your server. Review the items that have a red mark on it. If everything is green, you are good to go to the next step.</div>
                
                <br>

                 <div class="rounded-md flex items-center px-5 py-4 mb-2 border text-xl {{ versionOfPhp() >= 7.40 ? 'bg-theme-18 text-theme-1' : 'bg-theme-31 text-theme-6' }} text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <i data-feather="{{ versionOfPhp() >= 7.40 ? 'check' : 'c' }}" class="w-6 h-6 mr-2"></i> 
                     php version 7.4 +
                </div>

                 

                @if ($permission['curl_enabled'])
                    <div class="rounded-md flex items-center px-5 py-4 mb-2 border bg-theme-18 text-theme-1 text-xl text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <i data-feather="check" class="w-6 h-6 mr-2"></i> 
                     curl enabled
                    </div>
                @else
                    <div class="rounded-md flex items-center px-5 py-4 mb-2 border bg-theme-31 text-theme-6 text-xl text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <i data-feather="x-octagon" class="w-6 h-6 mr-2"></i> 
                     curl enabled
                    </div>
                @endif


                 @if ($permission['db_file_write_perm'])
                    <div class="rounded-md flex items-center px-5 py-4 mb-2 border bg-theme-18 text-theme-1 text-xl text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <i data-feather="check" class="w-6 h-6 mr-2"></i> 
                     .env
                    </div>
                @else
                    <div class="rounded-md flex items-center px-5 py-4 mb-2 border bg-theme-31 text-theme-6 text-xl text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <i data-feather="x-octagon" class="w-6 h-6 mr-2"></i> 
                     .env
                    </div>
                @endif


                 @if ($permission['storage'])
                    <div class="rounded-md flex items-center px-5 py-4 mb-2 border bg-theme-18 text-theme-1 text-xl text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <i data-feather="check" class="w-6 h-6 mr-2"></i> 
                     storage
                    </div>
                @else
                    <div class="rounded-md flex items-center px-5 py-4 mb-2 border bg-theme-31 text-theme-6 text-xl text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <i data-feather="x-octagon" class="w-6 h-6 mr-2"></i> 
                     storage
                    </div>
                @endif

                 @if ($permission['bootstrap'])
                    <div class="rounded-md flex items-center px-5 py-4 mb-2 border bg-theme-18 text-theme-1 text-xl text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <i data-feather="check" class="w-6 h-6 mr-2"></i> 
                     bootstrap/cache
                    </div>
                @else
                    <div class="rounded-md flex items-center px-5 py-4 mb-2 border bg-theme-31 text-theme-6 text-xl text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <i data-feather="x-octagon" class="w-6 h-6 mr-2"></i> 
                     bootstrap/cache
                    </div>
                @endif

                 @if ($permission['public'])
                    <div class="rounded-md flex items-center px-5 py-4 mb-2 border bg-theme-18 text-theme-1 text-xl text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <i data-feather="check" class="w-6 h-6 mr-2"></i> 
                     public
                    </div>
                @else
                    <div class="rounded-md flex items-center px-5 py-4 mb-2 border bg-theme-31 text-theme-6 text-xl text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <i data-feather="x-octagon" class="w-6 h-6 mr-2"></i> 
                     public
                    </div>
                @endif

                 @if ($permission['htaccess'])
                    <div class="rounded-md flex items-center px-5 py-4 mb-2 border bg-theme-18 text-theme-1 text-xl text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <i data-feather="check" class="w-6 h-6 mr-2"></i> 
                     .htaccess
                    </div>
                @else
                    <div class="rounded-md flex items-center px-5 py-4 mb-2 border bg-theme-31 text-theme-6 text-xl text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <i data-feather="x-octagon" class="w-6 h-6 mr-2"></i> 
                     .htaccess
                    </div>
                @endif


                @if ($permission['curl_enabled'] == 1 && 
                    $permission['db_file_write_perm'] == 1 && 
                    $permission['storage'] && 
                    $permission['bootstrap'] && 
                    $permission['public'] && 
                    $permission['htaccess'] && 
                    versionOfPhp() >= 7.40)
                    <a href="{{route('create')}}" 
                    class="button w-full inline-block text-xl px-5 py-4 mr-1 mb-2 border text-white-700 dark:bg-dark-5 dark:text-white-300">
                    Go To Next Step
                    </a>
                    @else
                    <a href="javascript:;" 
                    class="button w-full cursor-not-allowed inline-block text-xl px-5 py-4 mr-1 mb-2 border text-white-700 dark:bg-dark-5 dark:text-white-300">
                    Permissions Error. Please check folder or file permissions
                    </a>
                @endif

                 

            </div>
        </div>
        <!-- END: Error Page -->
    </div>
@endsection
