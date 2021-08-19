@extends('../layout/side-menu')

@section('head')
    <title>Swagmail - Email & SMS Marketing Application</title>
@endsection

@section('content')
    <div class="container">
        <!-- BEGIN: Congratulations Page -->
        <div class="page flex flex-col lg:flex-row items-center justify-center h-screen text-center lg:text-left">
            <div class="-intro-x lg:mr-20 mb-4">
                <img alt="#swagmail" class="w-full" src="{{ asset('congo.png') }}">
            </div>
            <div class="text-white mt-10 lg:mt-0">
                <div class="intro-x text-4xl font-medium">Swagmail - Email & SMS Marketing Application</div>                
	
                 <a href="{{route('frontend.index')}}" class="button w-full inline-block text-xl px-5 py-4 mr-1 mb-2 border text-white-700 dark:bg-dark-5 dark:text-white-300">Lets Start Swagmail</a>
					<h2>SwagatDash.com</h2>
            </div>
        </div>
        <!-- END: Congratulations Page -->
    </div>
@endsection
