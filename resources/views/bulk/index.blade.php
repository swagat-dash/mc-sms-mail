@extends('../layout/' .  layout())

@section('subhead')
    <title>@translate(Bulk Export Import Contacts)</title>
@endsection

@section('subcontent')
  <h2 class="intro-y text-lg font-medium mt-10">@translate(Bulk Export Import Contacts)</h2>


    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Import List -->
        <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y">
                <div class="box">
                    <div class="flex flex-col lg:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                        <div class="lg:m-auto lg:m-auto text-center lg:text-left w-full">
                            

                            <img src="{{ asset('bulk/import.jpg') }}" class="m-auto" width="300px" height="300px" alt="">
                            

                            <div class="text-center mt-4">
                                
                                <form action="{{ route('bulk.import') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="csv" required>

                                    

                                    <button type="submit" class="button w-24 bg-theme-1 text-white">Import</button>

                                     @if ($errors->any())

                                        <div class="alert alert-danger-soft show text-center flex items-center mb-2 mt-2">
                                            <ul class="m-auto">
                                                @foreach ($errors->all() as $error)
                                                    <li class="text-theme-6 font-medium leading-none mt-3">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>

                                    @else

                                    <ul class="mt-3 text-theme-1 font-medium leading-none">
                                        <li class="mt-2">File size must be smaller then 20MB</li>
                                        <li  class="mt-2">File type must be csv, xlx, xls</li>
                                    </ul>

                                    @endif

                                </form>

                                


                               


                            </div>


                            <p class="mt-3"><strong>Note: Please upload your containing csv file compitable with CSV(Comma Delimited) unless some field will be truncated.</strong></p>

                        </div>
                    </div>
                </div>
        </div>
        <!-- END: Import List -->
        <!-- BEGIN: Export List -->
        <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y">

                <div class="box">
                    <div class="flex flex-col lg:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                        <div class="llg:m-auto lg:m-auto text-center lg:text-left">
                            
                            <img src="{{ asset('bulk/export.jpg') }}" width="300px" height="300px" alt="">

                            <div class="text-center mt-6">
                                <a href="{{ route('bulk.export') }}" class="button w-24 bg-theme-1 text-white">Export Contacts</a>
                            </div>          

                        </div>

                        <p class="mt-3">
                    <strong>
                        Note: For better import or export experience you may use the sample CSV file providing by {{ org('company_name') }}. click <a href="{{ route('bulk.sample.csv') }}" class="text-lg text-theme-1 leading-none">here</a> to download sample CSV.
                    </strong>
                </p>

                        <p class="mt-3">
                    <strong>
                        Hints: Download the <a href="{{ route('bulk.sample.csv') }}" class="text-lg text-theme-1 leading-none">sample csv</a> file and override the sample data. Make sure each column has data as like the sample csv.
                    </strong>
                </p>

                

                    </div>

                    

                </div>

                


        </div>
        <!-- END: Export List -->
    </div>



@endsection

@section('script')

@endsection