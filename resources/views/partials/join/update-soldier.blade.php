{{-- Modal --}}
{{-- Join Update Soldier --}}
@foreach ($data['soldiers'] as $soldier)
    <form action="/join/{{ $soldier->id }}" method="post">
        @method('put')
        @csrf
        <div class="modal fade" id="readSoldierModal{{ $soldier->id }}" tabindex="-1" data-bs-backdrop="static"
            data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $soldier->game_name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input name="steam_id" type="text" class="form-control" id="floatingInput"
                                value="{{ $soldier->steam_id }}">
                            <label for="floatingInput">Steam ID</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="instagram" type="text" class="form-control" id="floatingInput"
                                value="{{ $soldier->instagram }}">
                            <label for="floatingInput">Instagram</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="twitter" type="text" class="form-control" id="floatingInput"
                                value="{{ $soldier->twitter }}">
                            <label for="floatingInput">Twitter</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="facebook" type="text" class="form-control" id="floatingInput"
                                value="{{ $soldier->facebook }}">
                            <label for="floatingInput">Facebook</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="twitch" type="text" class="form-control" id="floatingInput"
                                value="{{ $soldier->twitch }}">
                            <label for="floatingInput">Twitch</label>
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
