<div class="accordion" id="accordionPanelsStayOpenExample">
    @foreach ($data['platoons'] as $platoon)
        @if ($platoon->company_id === $company->id)
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
                        @foreach ($data['squads'] as $squad)
                            @if ($squad->platoon_id === $platoon->id)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-heading{{ $squad->id * 3 }}">
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
                                                    @foreach ($data['soldiers'] as $soldier)
                                                        @if ($soldier->squad_id == $squad->id)
                                                            <tr>
                                                                <th scope="row">
                                                                    {{ $soldier->id }}
                                                                </th>
                                                                <td>
                                                                    <button class="no-button" type="button"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#readSoldierModal{{ $soldier->id }}">{{ $soldier->game_name }}
                                                                        @if ($soldier->id == $platoon->soldier_id)
                                                                            🎖️
                                                                        @endif
                                                                    </button>
                                                                </td>
                                                                <td class="pl-3">
                                                                    <button type="button" class="btn btn-success">🗳️</button>
                                                                </td>
                                                                <td>
                                                                    <div class="progress mt-1" style="height: 20px;">
                                                                        <div class="progress-bar" role="progressbar"
                                                                            style="width: 50%;" aria-valuenow="70"
                                                                            aria-valuemin="0" aria-valuemax="100"></div>
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
