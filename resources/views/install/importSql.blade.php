@extends('../layout/side-menu')

@section('head')
    <title>Swagmail</title>
@endsection

@section('content')
    <div class="container">
        <!-- BEGIN: Error Page -->
        <div class="page flex flex-col lg:flex-row items-center justify-center h-screen text-center lg:text-left">
            <div class="-intro-x lg:mr-20 mb-4">

                @if (Schema::hasTable('organization_setups'))
                        @if (Schema::hasColumn('organization_setups', 'company_name') || Schema::hasColumn('organization_setups', 'logo'))
                            <img alt="{{ orgName() }}" class="w-40" src="{{ logo() }}">
                        @else
                            <img alt="#swagmail" class="w-40" src="{{ swagmail() }}">
                        @endif
                    @else
                    <img alt="#swagmail" class="w-40" src="{{ swagmail() }}">
                @endif

            </div>
            <div class="text-white mt-10 lg:mt-0">
                <div class="intro-x text-4xl font-medium">Swagmail - Email & SMS Marketing Application</div>


                @if($message = Session::get('success'))

                <div class="flex justify-end mt-4">
                    <a href="{{ route('import.fresh.data') }}" class="button w-full bg-theme-5 text-theme-3 ml-auto">Fresh Content</a>
                </div>


                <div class="flex justify-end mt-4">
                        <a href="{{ route('import.dummy.data') }}" class="button w-full bg-theme-5 text-theme-3 ml-auto">Dummy Content</a>
                </div>

                <div class="alert alert-outline-secondary alert-dismissible show flex items-center mt-5 mb-2" role="alert"> 
                     <i data-feather="alert-octagon" class="w-6 h-6 mr-2"></i> 
                     <p>
                         For dummy content, your email will be admin@mail.com and password is 12345678. Make sure you remember these credentials.
                     </p>
                </div>


                @endif

                @if($message = Session::get('wrong'))

                    <p>@translate(Check the Database connection)</p>
                    <div class="flex justify-end mt-4">
                        <a href="{{route('create')}}" class="button w-full bg-theme-5 text-theme-3 ml-auto">Go to the Database Setup</a>
                    </div>

                @endif
                 

            </div>
        </div>
        <!-- END: Error Page -->
    </div>
@endsection

