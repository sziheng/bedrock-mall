@if (session('error'))
    <input type="hidden" name="errormsg" value="{{session('error')}}">
@else(session('success'))
    <input type="hidden" name="successmsg" value="{{session('success')}}">
@endif

