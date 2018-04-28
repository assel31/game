@extends('index')

@section('content')

<div id="app">
    <div class="container">
         <sheepfold :sheepfolds="sheepfolds" :day="day"></sheepfold>
         <form method="post" action="{{route('history')}}">
              {{ csrf_field() }}
             <div class="row">
                 <div class="col-md-9">
                     <input class="form-control" name="day">
                 </div>
                 <div class="col-md-3">
                     <button class="form-control">get history</button>
                 </div>
             </div>
         </form>
    </div>
</div>

@endsection
