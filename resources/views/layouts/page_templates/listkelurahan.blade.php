<option value="">&mdash; Pilih &mdash;</option>
@foreach($lurahs as $lurah)
<option value="{{$lurah['id']}}">{{strtoupper($lurah['name'])}}</option>
@endforeach