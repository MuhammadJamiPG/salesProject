@extends('layout')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
 @if(auth()->user()->role == 'sales_head')
    <div class="card-header">{{ __('Your Sales Persons') }}</div>
@else
    <div class="card-header">{{ __('Your Customers') }}</div>                  
@endif
                <div class="card-body">
                    @if(auth()->user()->role == 'sales_head')
                        @if(count($sps) > 0)
                            @foreach($sps as $sp)
                                <span>{{ $sp->name }}</span><br />
                            @endforeach
                        @else
                           <span>No sales person you are leading</span>
                        @endif
                    @else
                       @if(count($sps) > 0)
                           @foreach($sps as $sp)
                               <span>{{ $sp->name }}</span><br />
                           @endforeach
                       @else
                          <span>No customers signup yet</span>
                       @endif     
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection