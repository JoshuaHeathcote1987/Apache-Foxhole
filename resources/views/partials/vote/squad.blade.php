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
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td colspan="2">Larry the Bird</td>
                            <td>@twitter</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="accordion" id="accordionPanelsStayOpenExample">
    @foreach ($data['platoons'] as $platoon)
        @if ($platoon->company_id == $company->id)
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-heading{{ $platoon->id * 2 }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#panelsStayOpen-collapse{{ $platoon->id * 2 }}" aria-expanded="false"
                        aria-controls="panelsStayOpen-collapse{{ $platoon->id * 2 }}">
                        {{ $platoon->name }}
                    </button>
                </h2>
                <div id="panelsStayOpen-collapse{{ $platoon->id * 2 }}" class="accordion-collapse collapse"
                    aria-labelledby="panelsStayOpen-heading{{ $platoon->id * 2 }}">
                    <div class="accordion-body">
                        <div class="accordion" id="accordionExample{{ $platoon->id * 2 }}">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo{{ $platoon->id * 2 }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo{{ $platoon->id * 2 }}" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Squad Leaders
                                    </button>
                                </h2>
                                <div id="collapseTwo{{ $platoon->id * 2 }}" class="accordion-collapse collapse"
                                    aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample{{ $platoon->id * 2 }}">
                                    <div class="accordion-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Game Name</th>
                                                    <th scope="col">Squad</th>
                                                    <th scope="col">Vote</th>
                                                    <th scope="col">Score</th>
                                                </tr>
                                            </thead>
                                            @foreach ($data['squads'] as $squad)
                                                @foreach ($data['squad_highests'] as $squad_highest)
                                                    @if ($squad->platoon_id == $platoon->id)
                                                        @if ($squad_highest['squad_id'] == $squad->id)
                                                            <tbody>
                                                                <td>{{ $squad_highest['game_name'] }}</td>
                                                                <td>{{ $squad->id }}</td>
                                                                <td>
                                                                    <form action="{{ route('vote.store') }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="category" value="1">
                                                                        <input type="hidden" name="voting_soldier_id"
                                                                            value="{{ \Auth::user()->id }}">
                                                                        <input type="hidden" name="voted_soldier_id"
                                                                            value="{{ $squad_highest['soldier_id'] }}">
                                                                        <button type="submit"
                                                                            class="btn btn-success">🗳️</button>
                                                                    </form>
                                                                </td>
                                                                <td>
                                                                    <div class="progress">
                                                                        <div class="progress-bar w-75"
                                                                            role="progressbar" aria-valuenow="75"
                                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </td>
                                                            </tbody>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        @foreach ($data['squads'] as $squad)
                            @if ($squad->platoon_id === $platoon->id)
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
                                                    @foreach ($data['soldiers'] as $key => $soldier)
                                                        @if ($soldier->squad_id == $squad->id)
                                                            <tr>
                                                                <th scope="row">
                                                                    {{ $soldier->id }}
                                                                </th>
                                                                <td>
                                                                    <button class="no-button" type="button"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#readSoldierModal{{ $soldier->id }}">{{ $soldier->game_name }}
                                                                        @if ($soldier->id == $squad->soldier_id)
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
                                                                            value="{{ \Auth::user()->id }}">
                                                                        <input type="hidden" name="voted_soldier_id"
                                                                            value="{{ $soldier->id }}">
                                                                        <button type="submit"
                                                                            class="btn btn-success">🗳️</button>
                                                                    </form>
                                                                </td>
                                                                <td>
                                                                    <div class="progress mt-1" style="height: 20px;">
                                                                        @if ($soldier->id == $data['percentages'][$key]['soldier_id'])
                                                                            <div class="progress-bar"
                                                                                role="progressbar"
                                                                                style="width: {{ $data['percentages'][$key]['percentage'] }}%;"
                                                                                aria-valuenow="70" aria-valuemin="0"
                                                                                aria-valuemax="100">
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </td>
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
                </div>
            </div>
        @endif
    @endforeach
</div>
