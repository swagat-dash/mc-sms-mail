@extends('layout.' .  layout())

@section('subhead')
    <title>@translate(SMTP Settings) - {{ $mail }}</title>
@endsection

@section('subcontent')

<div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
        <a href="{{ route('smtp.index') }}" class="button text-white bg-theme-1 shadow-md mr-2" >
            @translate(SMTP List)
        </a>
        
        </div>

  <div class="intro-y flex items-center mt-8">
      
        <h2 class="text-lg font-medium mr-auto">{{ Str::upper( $mail ) }}</h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
      
        <div class="col-span-12 lg:col-span-12 xxl:col-span-12">
         
       
        

            <!-- BEGIN: Social Information -->
            <div class="intro-y box lg:mt-5" id="#social">
                <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">@translate(Server Information)</h2>
                </div>
                <div class="p-5">
                    <form method="POST" action="{{ route('smtp.configure.store', $mail) }}">
                        @csrf
                    <div class="grid grid-cols-12 gap-5">
                        <div class="col-span-12 xl:col-span-6">
                            <div class="mt-3">
                                <label>@translate(MAIL MAILER)</label>

                                <select data-search="true" class="tail-select w-full" name="MAIL_MAILER">
                                    <option value="smtp" {{ $e_server->driver ?? null == 'smtp' ? 'selected' : null }}>SMTP</option>
                                    <option value="sendmail" {{ $e_server->driver ?? null == 'sendmail' ? 'selected' : null }}>SENDMAIL</option>
                                    @if ($mail == 'mailgun')
                                    <option value="mailgun" {{ $e_server->driver ?? null == 'mailgun' ? 'selected' : null }}>MAILGUN</option>
                                    @endif
                                </select> 

                            </div>
                            <div class="mt-3">
                                <label>@translate(MAIL HOST)</label>
                                <input type="text" name="MAIL_HOST" class="input w-full border mt-2" placeholder="MAIL HOST" value="{{ $e_server->host ?? NULL }}">
                            </div>
                        </div>
                        <div class="col-span-12 xl:col-span-6">
                            <div class="mt-3">
                                <label>@translate(MAIL PORT)</label>
                                <input type="text" placeholder="MAIL PORT" class="input w-full border mt-2" name="MAIL_PORT" value="{{ $e_server->port ?? NULL }}">
                            </div>
                            <div class="mt-3">
                                <label>@translate(MAIL USERNAME)</label>
                                <input type="text" placeholder="MAIL USERNAME" class="input w-full border mt-2" name="MAIL_USERNAME" value="{{ $e_server->username ?? NULL }}">
                            </div>
                        </div>
                        <div class="col-span-12 xl:col-span-6">
                            <div class="mt-3">
                                <label>@translate(MAIL PASSWORD)</label>
                                <input type="text" name="MAIL_PASSWORD" class="input w-full border mt-2" placeholder="MAIL PASSWORD" value="{{ $e_server->password ?? NULL  }}">
                            </div>
                            <div class="mt-3">
                                <label>@translate(MAIL ENCRYPTION)</label>
                                <input type="text" name="MAIL_ENCRYPTION" class="input w-full border mt-2" placeholder="MAIL ENCRYPTION" value="{{ $e_server->encryption ?? NULL  }}">
                            </div>
                        </div>
                        <div class="col-span-12 xl:col-span-6">
                            <div class="mt-3">
                                <label>@translate(MAIL FROM ADDRESS)</label>
                                <input type="text" class="input w-full border mt-2" placeholder="MAIL FROM ADDRESS" name="MAIL_FROM_ADDRESS" value="{{ $e_server->from ?? NULL  }}">
                            </div>
                            <div class="mt-3">
                                <label>@translate(MAIL FROM NAME)</label>
                                <input type="text" class="input w-full border mt-2" placeholder="MAIL FROM NAME" name="MAIL_FROM_NAME" value="{{ $e_server->from_name ?? NULL  }}">
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