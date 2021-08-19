@extends('../layout/side-menu')

@section('head')
    <title>Swagmail</title>
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
                
                <form action="{{route('db.setup')}}" method="GET">
                 

                    <div class="mt-4">
                        <label>Database Host</label>
                        <input type="hidden" name="types[]" value="DB_HOST">
                        <input type="text" class="input text-black w-full border mt-2" name="DB_HOST" placeholder="Database Host" value="localhost" required>
                    </div>

                    <div class="mt-4">
                        <label>Database Port</label>
                        <input type="hidden" name="types[]" value="DB_PORT">
                        <input type="text" class="input text-black w-full border mt-2" name="DB_PORT" placeholder="Database Port" value="3306" required>
                    </div>

                    <div class="mt-4">
                        <label>Database Name</label>
                        <input type="hidden" name="types[]" value="DB_DATABASE">
                        <input type="text" class="input text-black w-full border mt-2" name="DB_DATABASE" placeholder="Database Name" value="" required>
                    </div>

                    <div class="mt-4">
                        <label>Database Username</label>
                        <input type="hidden" name="types[]" value="DB_USERNAME">
                        <input type="text" class="input text-black w-full border mt-2" name="DB_USERNAME" placeholder="Database Username" value="" required>
                    </div>

                    <div class="mt-4">
                        <label>Database Password</label>
                        <input type="hidden" name="types[]" value="DB_PASSWORD">
                        <input type="text" class="input text-black w-full border mt-2" name="DB_PASSWORD" placeholder="Database Password">
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="button w-full bg-theme-5 text-theme-3 ml-auto">Save The Configuration</button>
                    </div>

                </form>
                 

            </div>
        </div>
        <!-- END: Error Page -->
    </div>
@endsection
