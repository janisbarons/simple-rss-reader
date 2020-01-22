@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Stats') }}</div>
                <div class="card-body">
                    <div class="d-flex align-content-around flex-wrap">
                        @foreach($stats as $word => $count)
                            @include('partials.word-count-block')
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Rss Feed') }}</div>
                <div class="card-body">

                        @foreach($items as $item)
                            <div class="row">
                                @include('partials.feed-item-block')
                            </div>

                        @endforeach
                     <hr>
                    <div class="center-block">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
