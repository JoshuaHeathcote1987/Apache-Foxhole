@extends('layouts.app')
@section('content')
    <div class="w-75 central-content pb-5 px-0 mx-0 mb-5">
        <div class="mx-3">
            <h2 class="mt-4">Orders |</h2>
            <hr>
            <p class="text-justify">
                Wizard ipsum dolor amet wizard Ipsum is how wizards working with non-magical folk and slip a little magic
                into their workday—without breaching any secrecy laws. It’s the original text of Lorum Ipsum.
                Many know lorum ipsum as the kind of Latin-looking filler copy used on website and print material mock ups.
                What isn’t widely known is that Lorum Ipsum isn’t the jumbled Latin created by Cicero. Well, it was created
                by Cicero, but Cicero was a wizard.
                It's only now, thanks to wizarding authors like JK Rowling and JRR Tolkien, who have hidden the wizarding
                work in plain sight.
                We hope you enjoy using and sharing Wizard Ipsum for all your creative projects, the magical and
                non-magical.
            </p>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="accordion big-margin-bottom" id="accordionPanelsStayOpenExample">
                @foreach ($data['companies'] as $company)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-heading{{ $company->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapse{{ $company->id }}" aria-expanded="false"
                                aria-controls="panelsStayOpen-collapse{{ $company->id }}">
                                {{ $company->name }}
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapse{{ $company->id }}" class="accordion-collapse collapse"
                            aria-labelledby="panelsStayOpen-heading{{ $company->id }}">
                            <div class="accordion-body">

                                @switch($company->id)
                                    @case(1)
                                        <div class="accordion" id="accordionPanelsStayOpenExample">
                                            @foreach ($data['platoons'] as $platoon)
                                                @if ($platoon->company_id === $company->id)
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header"
                                                            id="panelsStayOpen-heading{{ $platoon->id * 3 }}">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#panelsStayOpen-collapse{{ $platoon->id * 3 }}"
                                                                aria-expanded="false"
                                                                aria-controls="panelsStayOpen-collapse{{ $platoon->id * 3 }}">
                                                                {{ $platoon->name }}
                                                            </button>
                                                        </h2>
                                                        <div id="panelsStayOpen-collapse{{ $platoon->id * 3 }}"
                                                            class="accordion-collapse collapse"
                                                            aria-labelledby="panelsStayOpen-heading{{ $platoon->id * 3 }}">
                                                            <div class="accordion-body">
                                                                <ul class="nav">
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" type="button"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#createOrderModal{{ $platoon->id }}">
                                                                            ✍🏻 Create Order
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="nav-link" type="button"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#viewOrdersModal">
                                                                            📒 View Orders
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">#</th>
                                                                            <th scope="col">Date</th>
                                                                            <th scope="col">Head</th>
                                                                            <th scope="col">Body</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($data['orders'] as $order)
                                                                            @if ($order->platoon_id == $platoon->id)
                                                                                <tr>
                                                                                    <th scope="row">{{ $order->id }}</th>
                                                                                    <td>{{ $order->created_at }}</td>
                                                                                    <td>{{ $order->head }}</td>
                                                                                    <td>{{ $order->body }}</td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @break
                                    @case(2)
                                        <div class="accordion" id="accordionPanelsStayOpenExample">
                                            @foreach ($data['platoons'] as $platoon)
                                                @if ($platoon->company_id === $company->id)
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header"
                                                            id="panelsStayOpen-heading{{ $platoon->id * 4 }}">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#panelsStayOpen-collapse{{ $platoon->id * 4 }}"
                                                                aria-expanded="false"
                                                                aria-controls="panelsStayOpen-collapse{{ $platoon->id * 4 }}">
                                                                {{ $platoon->name }}
                                                            </button>
                                                        </h2>
                                                        <div id="panelsStayOpen-collapse{{ $platoon->id * 4 }}"
                                                            class="accordion-collapse collapse"
                                                            aria-labelledby="panelsStayOpen-heading{{ $platoon->id * 4 }}">
                                                            <div class="accordion-body">
                                                                <ul class="nav">
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" type="button"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#createOrderModal{{ $platoon->id }}">
                                                                            ✍🏻 Create Order
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="nav-link" type="button"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#viewOrdersModal">
                                                                            📒 View Orders
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">#</th>
                                                                            <th scope="col">Date</th>
                                                                            <th scope="col">Head</th>
                                                                            <th scope="col">Body</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($data['orders'] as $order)
                                                                            @if ($order->platoon_id == $platoon->id)
                                                                                <tr>
                                                                                    <th scope="row">{{ $order->id }}</th>
                                                                                    <td>{{ $order->created_at }}</td>
                                                                                    <td>{{ $order->head }}</td>
                                                                                    <td>{{ $order->body }}</td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @break
                                    @default
                                @endswitch
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @foreach ($data['platoons'] as $platoon)
        <form action="/orders" method="post">
            @csrf
            <input type="hidden" name="platoon_id" value="{{ $platoon->id }}">
            <div class="modal fade" id="createOrderModal{{ $platoon->id }}" tabindex="-1" data-bs-backdrop="static"
                data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ $platoon->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input name="head" type="text" class="form-control" id="floatingInput">
                                <label for="floatingInput">Head</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea name="body" class="form-control" id="exampleFormControlTextarea1"
                                    rows="8"></textarea>
                                <label for="floatingInput">Body</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach

    <div class="modal fade" id="viewOrdersModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">All Orders</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Platoon</th>
                                <th scope="col">Head</th>
                                <th scope="col">Body</th>
                                <th scope="col">Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['orders'] as $order)
                                <tr>
                                    <td>{{ $order->platoon_id }}</td>
                                    <td>{{ $order->head }}</td>
                                    <td>{{ $order->body }}</td>
                                    <td>{{ $order->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
