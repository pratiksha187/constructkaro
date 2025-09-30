@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>Laravel Dependent Dropdown (State → Region → City)</h3>
    <form>
        <div class="mb-3">
            <label for="state" class="form-label">Select State</label>
            <select name="state" id="state" class="form-control">
                <option value="">-- Select State --</option>
                @foreach ($states as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="region" class="form-label">Select Region</label>
            <select name="region" id="region" class="form-control">
                <option value="">-- Select Region --</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">Select City</label>
            <select name="city" id="city" class="form-control">
                <option value="">-- Select City --</option>
            </select>
        </div>
    </form>
</div>

{{-- jQuery Ajax --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // State → Region
    $('#state').on('change', function() {
        let state_id = $(this).val();
        $('#region').empty().append('<option value="">-- Select Region --</option>');
        $('#city').empty().append('<option value="">-- Select City --</option>');

        if (state_id) {
            $.get('/get-regions/' + state_id, function(data) {
                $.each(data, function(key, value) {
                    $('#region').append('<option value="'+ key +'">'+ value +'</option>');
                });
            });
        }
    });

    // Region → City
    $('#region').on('change', function() {
        let region_id = $(this).val();
        $('#city').empty().append('<option value="">-- Select City --</option>');

        if (region_id) {
            $.get('/get-cities/' + region_id, function(data) {
                $.each(data, function(key, value) {
                    $('#city').append('<option value="'+ key +'">'+ value +'</option>');
                });
            });
        }
    });
</script>
@endsection
