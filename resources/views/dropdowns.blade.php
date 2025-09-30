<!DOCTYPE html>
<html>
<head>
    <title>Dependent Dropdowns with Search and Checkboxes</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Optional: Some Styling -->
    <style>
        .select2-container {
            width: 300px !important;
        }
        label {
            display: block;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<h2>Dependent Dropdown Example - Laravel</h2>

<!-- Work Type Dropdown -->
<div>
    <label for="work_type">Work Type:</label>
    <select id="work_type" class="select2">
        <option value="">Select Work Type</option>
        @foreach($workTypes as $type)
            <option value="{{ $type->id }}">{{ $type->work_type }}</option>
        @endforeach
    </select>
</div>

<!-- Work Subtype Dropdown -->
<div>
    <label for="work_subtype">Work Subtype:</label>
    <select id="work_subtype" class="select2">
        <option value="">Select Work Subtype</option>
    </select>
</div>

<!-- Vendor Type Dropdown -->
<div>
    <label for="vendor_type">Suggested Vendor Types:</label>
    <select id="vendor_type" class="select2">
        <option value="">Select Vendor</option>
    </select>
</div>

<!-- Sub Vendor Types as Checkboxes -->
<div>
    <label>Suggested Sub Vendor Types:</label>
    <div id="sub_vendor_type_checkbox">
        <!-- Checkboxes will appear here -->
    </div>
</div>

<!-- JavaScript Section -->
<script>
    $(document).ready(function () {
        // Initialize Select2
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true,
            width: '100%'
        });

        // On Work Type change → Load Subtypes
        $('#work_type').on('change', function () {
            var workTypeId = this.value;

            $('#work_subtype').html('<option value="">Loading...</option>').trigger('change');
            $('#vendor_type').html('<option value="">Select Vendor</option>').trigger('change');
            $('#sub_vendor_type_checkbox').html('');

            if (workTypeId) {
                $.ajax({
                    url: '/get-subtypes/' + workTypeId,
                    type: 'GET',
                    success: function (res) {
                        $('#work_subtype').html('<option value="">Select Work Subtype</option>');
                        $.each(res, function (key, value) {
                            $('#work_subtype').append('<option value="' + value.id + '">' + value.work_subtype + '</option>');
                        });
                        $('#work_subtype').select2({
                            placeholder: "Select Work Subtype",
                            allowClear: true,
                            width: '100%'
                        });
                    }
                });
            }
        });

        // On Subtype change → Load Vendor Types
        $('#work_subtype').on('change', function () {
            var subtypeId = this.value;

            $('#vendor_type').html('<option value="">Loading...</option>').trigger('change');
            $('#sub_vendor_type_checkbox').html('');

            if (subtypeId) {
                $.ajax({
                    url: '/get-vendors/' + subtypeId,
                    type: 'GET',
                    success: function (res) {
                        $('#vendor_type').html('<option value="">Select Vendor</option>');
                        $.each(res, function (key, value) {
                            $('#vendor_type').append('<option value="' + value.id + '">' + value.vendor_type + '</option>');
                        });
                        $('#vendor_type').select2({
                            placeholder: "Select Vendor",
                            allowClear: true,
                            width: '100%'
                        });
                    }
                });
            }
        });

        // On Vendor Type change → Load Sub Vendor Types as Checkboxes
        $('#vendor_type').on('change', function () {
            var vendorId = this.value;

            $('#sub_vendor_type_checkbox').html('Loading...');

            if (vendorId) {
                $.ajax({
                    url: '/get-sub-vendors/' + vendorId,
                    type: 'GET',
                    success: function (res) {
                        let html = '';
                        if (res.length > 0) {
                            res.forEach(function (item) {
                                html += `
                                    <div>
                                        <label>
                                            <input type="checkbox" name="sub_vendor_types[]" value="${item.id}">
                                            ${item.vendor_subcategory}
                                        </label>
                                    </div>
                                `;
                            });
                        } else {
                            html = 'No Sub Vendor Types Found';
                        }
                        $('#sub_vendor_type_checkbox').html(html);
                    }
                });
            } else {
                $('#sub_vendor_type_checkbox').html('');
            }
        });
    });
</script>

</body>
</html>
