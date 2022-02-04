{{-- Quick orders list, don't delete --}}

<div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white" style="width: 380px;">
    <a href="/" class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none border-bottom">
        <span class="fs-5 fw-semibold">Orders Quick List |</span>
    </a>
    <div class="list-group list-group-flush border-bottom scrollarea">
        @for ($i = 0; $i < sizeof($ordered_orders); $i++)
            <a href="#" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
                <div class="d-flex w-100 align-items-center justify-content-between">
                    <strong class="mb-1">{{ $ordered_orders[$i]['company'] }} {{ $ordered_orders[$i]['platoon'] }}</strong>
                    <small>{{ $ordered_orders[$i]['date'] }}</small>
                </div>
                <div class="col-10 mb-1 small">{{ $ordered_orders[$i]['body'] }}</div>
            </a> 
        @endfor
    </div>
</div>
