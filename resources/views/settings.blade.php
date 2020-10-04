<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SMS Settings</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>

    </head>
    <body>
        <div class="p-4">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            
            SMS Gateway: 
            <select name="gateway" onchange="@foreach($gateways as $gateway) $('#{{ str_replace('.', '', $gateway) }}').hide(); @endforeach $('#' + $(this).find(':selected').attr('key')).show()">
                <option></option>
                @foreach($gateways as $gateway)
                    <option value="{{ $gateway }}" key="{{ str_replace('.', '', $gateway) }}" @if($userGateway == $gateway) selected @endif>{{ $gateway }}</option>
                @endforeach
            </select>

            @foreach ($gateways as $gateway)
                <div id="{{ str_replace('.', '', $gateway) }}" class="row"  @if($userGateway != $gateway) style="display: none" @endif>
                    <form action="{{ url('sms/settings') }}" method="POST" class="col">
                        @csrf
                        @foreach($parameters[$gateway] as $parameter => $value)
                        <div class="row py-2">
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6"><strong>{{ $parameter }}</strong></div>
                            <div class="col-lg-10 col-md-9 col-sm-8 col-6"><input type="text" name="paramters[{{ $parameter }}]" value="{{ $value }}" /></div>
                        </div>
                        @endforeach
                        <div class="row">
                            <input type="hidden" name="gateway" value="{{ $gateway }}" />
                            <button type="submit" class="btn btn-primary m-1">Save</button>
                            <button type="reset" class="btn btn-secondary m-1">Cancel</button>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    </body>
</html>