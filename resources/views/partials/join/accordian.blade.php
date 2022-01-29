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
                                            <ul class="nav">
                                                <li class="nav-item">
                                                    <a class="nav-link active" aria-current="page" href="#">
                                                        <form action="/join" method="post">
                                                            @csrf
                                                            <input type="hidden" name="squad_id"
                                                                value="{{ $squad->id }}">
                                                            <button class="no-button" type="submit">🤺 Join
                                                                Squad</button>
                                                        </form>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#">
                                                        <button class="no-button">
                                                            🤙 Join Discord
                                                        </button>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#">
                                                        <button class="no-button">
                                                            👍 Commend Squad?
                                                        </button>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#">
                                                        <button class="no-button">
                                                            👎 Criticize Squad?
                                                        </button>
                                                    </a>
                                                </li>
                                            </ul>
                                            <hr>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Game Name</th>
                                                        <th scope="col">Service Time</th>
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
                                                                    {{ App\Http\Controllers\Controller::time_elapsed_string($soldier->created_at) }}
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
