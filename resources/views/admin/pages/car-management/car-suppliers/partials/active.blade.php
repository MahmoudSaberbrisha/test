<label for="active{{$id}}" class="switch">
    <input type="checkbox" id="active{{$id}}" {{$active==1?'checked':''}} onchange="changeSwitch(this, '{{$id}}', '{{route(auth()->getDefaultDriver().'.car-suppliers-active')}}');">
    <span class="slider round"></span>
</label>
