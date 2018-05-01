@extends('index')

@section('content')

<div id="app">
    <div class="container">
         <sheepfold
            v-on:selectsheep="selectSheep"
            :sheepfolds="sheepfolds"
            :day="day"
         ></sheepfold>
         <div class="row">
             <div class="col-md-6">
                 <button class="form-control" @click="startAgain">refresh</button>
             </div>
             <div class="col-md-6">
                 <button class="form-control" @click="killSelected">kill</button>
             </div>
         </div>
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
