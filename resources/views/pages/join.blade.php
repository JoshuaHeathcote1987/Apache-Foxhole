@extends('layouts.app')
@section('content')
    <div class="w-75 central-content pb-5 px-0 mx-0 mb-5">
        <div class="mx-3">
            <h2 class="mt-4">Join |</h2>
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
            <div class="alert alert-warning" role="alert">
                When joining a squad the accordian window will close, just reopen to find your entry was successful.
            </div>
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
                                        @include('partials.join.accordian')
                                    @break
                                    @case(2)
                                        @include('partials.join.accordian')
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

    {{-- Modals --}}
    @include('partials.join.update-soldier')
@endsection
