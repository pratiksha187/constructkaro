@extends('layouts.app')

@section('title', 'Join as Service Provider | ConstructKaro')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white p-8 max-w-7xl mx-auto shadow-md rounded-lg mt-10">
    <h2 class="text-3xl font-bold mb-2 bg-gradient-to-r from-orange-500 to-blue-500 bg-clip-text text-transparent">
        Select Your Service Type
    </h2>

    <p class="text-gray-600 mb-6">Choose the category that best describes your agency. Then select the services you provide.</p>

    <form id="serviceForm" method="POST" action="{{ route('save.agency.services') }}">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Work Type -->
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-2">Find Your Construction Vendor *</label>
                <select id="work_type" name="work_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all select2">
                    <option value="">Select Construction Type</option>
                    @foreach($workTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->work_type }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Work Subtype -->
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-2">Project Type *</label>
                <select id="work_subtype" name="work_subtype" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all select2">
                    <option value="">Select Work Subtype</option>
                </select>
            </div>

            <!-- Work/Service Model as Checkboxes -->
            <div class="col-span-2">
                <label class="block text-xl font-semibold text-gray-900 mb-3 border-b pb-1">
                    Work/Service Model *
                </label>

                <div id="vendorCheckboxes" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Dynamically generated checkboxes will appear here -->
                </div>
            </div>

            <!-- Sub Vendor Types Groups -->
            <div class="col-span-2" id="subVendorGroups">
                <!-- Dynamically generated subcategory groups will appear here -->
            </div>
        </div>

        <div class="flex justify-between mt-6">
            <button type="reset" id="resetBtn" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition">Back</button>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Continue</button>
        </div>
    </form>
</div>

<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {
    // Initialize Select2
    $('.select2').select2({
        placeholder: "Select an option",
        allowClear: true,
        width: '100%'
    });

    // When Work Type changes, load Work Subtypes
    $('#work_type').on('change', function () {
        var workTypeId = $(this).val();
        $('#work_subtype').html('<option>Loading...</option>').trigger('change');
        $('#vendorCheckboxes').empty();
        $('#subVendorGroups').empty();

        if (workTypeId) {
            $.ajax({
                url: '/get-subtypes/' + workTypeId,
                type: 'GET',
                success: function (res) {
                    let options = '<option value="">Select Work Subtype</option>';
                    $.each(res, function (_, subtype) {
                        options += `<option value="${subtype.id}">${subtype.work_subtype}</option>`;
                    });
                    $('#work_subtype').html(options).trigger('change');
                },
                error: function() {
                    $('#work_subtype').html('<option value="">Failed to load subtypes</option>').trigger('change');
                }
            });
        } else {
            $('#work_subtype').html('<option value="">Select Work Subtype</option>').trigger('change');
        }
    });

    // When Work Subtype changes, load Vendor Types (Models) as checkboxes
    $('#work_subtype').on('change', function () {
        var subtypeId = $(this).val();
        $('#vendorCheckboxes').html('<span class="text-sm text-gray-500">Loading...</span>');
        $('#subVendorGroups').empty();

        if (subtypeId) {
            $.ajax({
                url: '/get-vendors/' + subtypeId,
                type: 'GET',
                success: function (vendors) {
                    let html = '';
                    if (vendors.length > 0) {
                        vendors.forEach(function (vendor) {
                            html += `
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="vendor_type[]" value="${vendor.id}" class="vendor-checkbox text-blue-600 focus:ring-blue-500" data-vendor-name="${vendor.vendor_type}">
                                    <span class="text-gray-800">${vendor.vendor_type}</span>
                                </label>
                            `;
                        });
                    } else {
                        html = '<span class="text-red-500">No Vendor Types Found</span>';
                    }
                    $('#vendorCheckboxes').html(html);
                },
                error: function() {
                    $('#vendorCheckboxes').html('<span class="text-red-500">Failed to load vendor types</span>');
                }
            });
        } else {
            $('#vendorCheckboxes').empty();
            $('#subVendorGroups').empty();
        }
    });

    // Show/hide Sub Vendor Types groups when Vendor checkbox changes
    $(document).on('change', '.vendor-checkbox', function () {
        const vendorId = $(this).val();
        const vendorName = $(this).data('vendor-name');
        const isChecked = $(this).is(':checked');

        if (isChecked) {
            // Fetch subcategories for this vendor
            $.ajax({
                url: '/get-sub-vendors/' + vendorId,
                type: 'GET',
                success: function (subcategories) {
                    let html = `
                        <div class="mt-4 p-4 border border-blue-300 rounded-lg bg-blue-50" id="subgroup-${vendorId}">
                            <div class="text-md font-semibold text-blue-800 mb-2">${vendorName} - Work/Service Categories</div>
                    `;
                    if (subcategories.length > 0) {
                        subcategories.forEach(function(sub) {
                            html += `
                                <label class="flex items-center space-x-3 mb-1">
                                    <input type="checkbox" name="sub_vendor_types[${vendorId}][]" value="${sub.id}" class="text-blue-500 focus:ring-blue-500">
                                    <span>${sub.vendor_subcategory}</span>
                                </label>
                            `;
                        });
                    } else {
                        html += '<p class="text-sm text-gray-500 italic">No subcategories found.</p>';
                    }
                    html += '</div>';

                    // Append and slide down animation
                    let $box = $(html).hide();
                    $('#subVendorGroups').append($box);
                    $box.slideDown(200);
                },
                error: function () {
                    alert('Failed to load subcategories.');
                }
            });
        } else {
            // Remove the subcategory group with slide up animation
            $(`#subgroup-${vendorId}`).slideUp(200, function () {
                $(this).remove();
            });
        }
    });

    // Reset button clears selections and dynamic content
    $('#resetBtn').on('click', function () {
        // Clear selects (using select2)
        $('#work_type').val(null).trigger('change');
        $('#work_subtype').val(null).trigger('change');

        // Clear checkboxes and dynamic groups
        $('#vendorCheckboxes').empty();
        $('#subVendorGroups').empty();
    });

    // Submit form with AJAX
    $('#serviceForm').on('submit', function (e) {
        e.preventDefault();

        const workType = $('#work_type').val();
        const workSubtype = $('#work_subtype').val();

        // Get selected vendor types
        const vendorTypes = $('.vendor-checkbox:checked').map(function () {
            return $(this).val();
        }).get();

        // Get selected sub vendor types (flatten all checked in subVendorGroups)
        const subVendorTypes = [];
        $('#subVendorGroups input[type="checkbox"]:checked').each(function() {
            subVendorTypes.push($(this).val());
        });

        $.ajax({
            url: "{{ route('save.agency.services') }}",
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                work_type: workType,
                work_subtype: workSubtype,
                vendor_type: vendorTypes,
                sub_vendor_types: subVendorTypes
            },
            success: function (res) {
                if (res.status === 'success') {
                    window.location.href = '{{ route("about_business") }}';
                } else {
                    alert(res.message || 'Save failed');
                }
            },
            error: function () {
                alert('Something went wrong!');
            }
        });
    });
});
</script>
@endsection
