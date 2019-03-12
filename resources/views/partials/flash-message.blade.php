@if(Session::has('flash_message_ok'))
    <div class="alert alert-success"><span
                class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message_ok') !!}</em></div>
@endif

@if(Session::has('flash_message_error'))
    <div class="alert alert-success"><span
                class="glyphicon glyphicon-times"></span><em> {!! session('flash_message_error') !!}</em></div>
@endif