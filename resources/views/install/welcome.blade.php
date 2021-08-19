@extends('../layout/side-menu')

@section('head')
    <title>Swagmail - Email & SMS Marketing Application</title>
@endsection

@section('content')
    <div class="container">
        <!-- BEGIN: Error Page -->
        <div class="page flex flex-col lg:flex-row items-center justify-center h-screen text-center lg:text-left w-9/12 m-auto">
            <div class="-intro-x lg:mr-20 mb-4">
                <img alt="#swagmail" class="w-40" src="{{ swagmail() }}">
            </div>
			<h2>This is SwagatDash.com</h2>
            <div class="text-white mt-10 lg:mt-0">
                <div class="intro-x text-4xl font-medium">Swagmail - Email & SMS Marketing Application</div>
                <div class="intro-x text-xl lg:text-3xl font-medium">You will need to know the following items before proceeding</div>
                
                <br>

                 <div class="rounded-md flex items-center px-5 py-4 mb-2 border text-xl text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <i data-feather="check" class="w-6 h-6 mr-2"></i> 
                     Database Host Name
                </div>

                 <div class="rounded-md flex items-center px-5 py-4 mb-2 border text-xl text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <i data-feather="check" class="w-6 h-6 mr-2"></i> 
                     Database Name
                </div>

                 <div class="rounded-md flex items-center px-5 py-4 mb-2 border text-xl text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <i data-feather="check" class="w-6 h-6 mr-2"></i> 
                     Database Username
                </div>

                 <div class="rounded-md flex items-center px-5 py-4 mb-2 border text-xl text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <i data-feather="check" class="w-6 h-6 mr-2"></i> 
                     Database Password
                </div>

                <div class="rounded-md flex items-center px-5 py-4 mb-2 border text-xl text-white-700 dark:text-white-300 dark:border-dark-5"> 
                     <p>During the installation process. we will check if the files there needed to be written (<strong>.env file</strong>)
                        have <strong>write permission</strong>. 
                        <br> We Will also check if <strong>curl</strong> are enabled on your server or not.
                        Gather the information mentioned above before hitting the start installation button. if you are ready...</p>
                </div>

                 <a href="{{route('permission')}}" class="button w-full inline-block text-xl px-5 py-4 mr-1 mb-2 border text-white-700 dark:bg-dark-5 dark:text-white-300">Start Installation Proccess</a>

            </div>
        </div>
        <!-- END: Error Page -->
    </div>
@endsection
