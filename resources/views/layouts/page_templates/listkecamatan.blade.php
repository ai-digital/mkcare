<option value="">&mdash; Pilih &mdash;</option>
@foreach($camats as $camat)
<option value="{{$camat['id']}}">{{strtoupper($camat['name'])}}</option>
@endforeach