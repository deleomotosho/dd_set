
<h3>Load Files </h3>
<hr/>

We've found the following files:

{!! Form::open(['route' => 'stats.store']) !!}
<ol>
    @foreach($file_paths as $file => $path)
        <input type="hidden" name="{{$file}}" value="{{$path}}"/>
        <li> {{$file}} - {{$path}}</li>
    @endforeach

</ol>
<input type="submit" value="Yup! Import Files" />
{!!  Form::close() !!}