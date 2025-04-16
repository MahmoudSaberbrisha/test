<label for="rtl{{$id}}" class="switch">
    <input type="checkbox" id="rtl{{$id}}" {{$rtl==1?'checked':''}} onchange="changeSwitch(this, '{{$id}}', '{{route(auth()->getDefaultDriver().'.language-rtl')}}');">
    <span class="slider round"></span>
</label>
