<option value="">&mdash; Pilih &mdash;</option>
@foreach($kabupatens as $kabupaten)
<option value="{{$kabupaten['id']}}">{{strtoupper($kabupaten['name'])}}</option>
@endforeach