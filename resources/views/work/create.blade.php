@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Work Selection</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('work.store') }}">
        @csrf
        <div class="mb-3">
            <label>Work Type</label>
            <select name="work_type" id="work_type" class="form-control">
                <option value="">Select Work Type</option>
                @foreach($workTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Work Subtype</label>
            <select name="work_subtype" id="work_subtype" class="form-control">
                <option value="">Select Subtype</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Vendor</label>
            <select name="vendor" id="vendor" class="form-control">
                <option value="">Select Vendor</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#work_type').change(function() {
        var typeId = $(this).val();
        $('#work_subtype').html('<option value="">Loading...</option>');
        $.get('/get-subtypes/' + typeId, function(data) {
            var options = '<option value="">Select Subtype</option>';
            data.forEach(function(subtype) {
                options += '<option value="'+subtype.id+'">'+subtype.name+'</option>';
            });
            $('#work_subtype').html(options);
            $('#vendor').html('<option value="">Select Vendor</option>');
        });
    });

    $('#work_subtype').change(function() {
        var subtypeId = $(this).val();
        $('#vendor').html('<option value="">Loading...</option>');
        $.get('/get-vendors/' + subtypeId, function(data) {
            var options = '<option value="">Select Vendor</option>';
            data.forEach(function(vendor) {
                options += '<option value="'+vendor.id+'">'+vendor.type+' ('+vendor.sub_categories+')</option>';
            });
            $('#vendor').html(options);
        });
    });
});
</script>
@endsection
