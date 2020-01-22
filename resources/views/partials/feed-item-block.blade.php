<div class="card col-12 p-3">
    <div class="card-body">
        <h5 class="card-title">
            <a href=" {{ $item->get_link() }}"> {!! $item->get_title() !!}</a>
        </h5>
        {!! $item->get_description() !!}

            <a href="{{ $item->get_link() }}" target="_blank">{{ __('Read article') }}</a>

    </div>


</div>
