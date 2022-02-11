{{-- Company Poll --}}
<div class="accordion" id="accordionExample12345">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo12345">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseTwo12345" aria-expanded="false" aria-controls="collapseTwo">
                Platoon Leaders
            </button>
        </h2>
        <div id="collapseTwo12345" class="accordion-collapse collapse" aria-labelledby="headingTwo"
            data-bs-parent="#accordionExample12345">
            <div class="accordion-body">
                <table class="table table-striped">
                    <thead>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Game Name</th>
                            <th scope="col">Squad</th>
                            <th scope="col">Vote</th>
                            <th scope="col">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                     
                            </td>
                            <td>
                                <div class="progress-bar"
                                    role="progressbar"
                                    style="width: 45%;"
                                    aria-valuenow="70" aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="accordion" id="accordionPanelsStayOpenExample">
    @foreach ($company['platoons'] as $platoon)
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-heading{{ $platoon->id * 5 }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#panelsStayOpen-collapse{{ $platoon->id * 5 }}" aria-expanded="false"
                        aria-controls="panelsStayOpen-collapse{{ $platoon->id * 5 }}">
                        {{ $platoon->name }}
                    </button>
                </h2>
                <div id="panelsStayOpen-collapse{{ $platoon->id * 5 }}" class="accordion-collapse collapse"
                    aria-labelledby="panelsStayOpen-heading{{ $platoon->id * 5 }}">
                    <div class="accordion-body">
                        <div class="accordion" id="accordionExample{{ $platoon->id * 5 }}">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo{{ $platoon->id * 5 }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo{{ $platoon->id * 5 }}" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Squad Leaders
                                    </button>
                                </h2>
                                <div id="collapseTwo{{ $platoon->id * 5 }}" class="accordion-collapse collapse"
                                    aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample{{ $platoon->id * 5 }}">
                                    <div class="accordion-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Game Name</th>
                                                    <th scope="col">Squad</th>
                                                    <th scope="col">Vote</th>
                                                    <th scope="col">Score</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($platoon->squads as $squad)
                                                    @if (isset($squad->leader))
                                                        <tr>
                                                            <td>{{ $squad->leader->id }}</td>
                                                            <td>{{ $squad->leader->game_name }}</td>
                                                            <td>{{ $squad->name}}</td>
                                                            <td>
                                                                <form action="{{ route('vote.store') }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="category" value="1">
                                                                <input type="hidden" name="voting_soldier_id"
                                                                    value="{{ \Auth::id() }}">
                                                                <input type="hidden" name="voted_soldier_id"
                                                                    value="{{ $squad->leader->id }}">
                                                                <button type="submit"
                                                                    class="btn btn-success">🗳️</button>
                                                                </form>
                                                        </td>
                                                            <td>progress bar here</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>   
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        @foreach ($platoon['squads'] as $squad)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-heading{{ $squad->id * 3 }}"
                                        style="border-top: 1px solid #dfdfdf;">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapse{{ $squad->id * 3 }}"
                                            aria-expanded="false"
                                            aria-controls="panelsStayOpen-collapse{{ $squad->id * 3 }}">
                                            {{ $squad->name }}
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapse{{ $squad->id * 3 }}"
                                        class="accordion-collapse collapse"
                                        aria-labelledby="panelsStayOpen-heading{{ $squad->id * 3 }}">
                                        <div class="accordion-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Game Name</th>
                                                        <th scope="col">Vote</th>
                                                        <th scope="col">Score</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($squad['soldiers'] as $soldier)
                                                            <tr>
                                                                <th scope="row">
                                                                    {{ $soldier->id }}
                                                                </th>
                                                                <td>
                                                                    <button class="no-button" type="button"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#readSoldierModal{{ $soldier->id }}">{{ $soldier->game_name }}
                                                                        @if ($soldier->id == $squad->leader_id)
                                                                            🎖️
                                                                        @endif
                                                                    </button>
                                                                </td>
                                                                <td class="pl-3">
                                                                    <form action="{{ route('vote.store') }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="category" value="2">
                                                                        <input type="hidden" name="voting_soldier_id"
                                                                            value="{{ \Auth::id() }}">
                                                                        <input type="hidden" name="voted_soldier_id"
                                                                            value="{{ $soldier->id }}">
                                                                        <button type="submit"
                                                                            class="btn btn-success">🗳️</button>
                                                                    </form>
                                                                </td>
                                                                <td>
                                                                @if (isset($soldier->percentages))
                                                                    @foreach ($soldier->percentages as $percentages)
                                                                        @if ($percentages->category == '3')
                                                                            <div class="progress mt-1" style="height: 20px;">
                                                                                <div class="progress-bar"
                                                                                    role="progressbar"
                                                                                    style="width: {{ $percentages->percentage }}%;"
                                                                                    aria-valuenow="70" aria-valuemin="0"
                                                                                    aria-valuemax="100">
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                                </td>
                                                            </tr>       
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                    </div>
                </div>
            </div>
    @endforeach
</div>