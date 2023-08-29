@extends('layout')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Your Sales Persons') }}</div>
  
                <div class="card-body">
                    @if(count($sps) > 0)
                        @foreach($sps as $sp)
                            <span>{{ $sp->name }}</span><br />
                        @endforeach
                    @else
                       <span>No sales person you are leading</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection