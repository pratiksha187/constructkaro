@extends('layouts.app')

@section('title', 'Join as Service Provider | ConstructKaro')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white p-8 max-w-7xl mx-auto shadow-md rounded-lg mt-10">
    <h2 class="text-3xl font-bold mb-2 bg-gradient-to-r from-orange-500 to-blue-500 bg-clip-text text-transparent">
        Select Your Service Type
    </h2>

    <p class="text-gray-600 mb-6">
        Choose the category that best describes your agency. Then select the services you provide.
    </p>

    <form id="serviceForm" method="POST" action="{{ route('save.agency.services') }}">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Work Type -->
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-2">Find Your Construction Vendor *</label>
                <select id="work_type" name="work_type"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all select2">
                    <option value="">Select Construction Type</option>
                    @foreach($workTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->work_type }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Project Types as Checkboxes -->
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Project Type *</label>
                <div id="workSubtypeCheckboxes" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <!-- Dynamically generated project type checkboxes -->
                </div>
            </div>

            <!-- Project Type Groups with Vendors/Sub Vendors -->
            <div class="col-span-2" id="projectGroups">
                <!-- Each Project Type with its vendors will be appended here -->
            </div>
        </div>

        <div class="flex justify-between mt-6">
            <button type="reset" id="resetBtn"
                class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition">Back</button>
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Continue</button>
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

    // Load Project Types (checkboxes) when Work Type selected
    $('#work_type').on('change', function () {
        var workTypeId = $(this).val();
        $('#workSubtypeCheckboxes').html('<span class="text-sm text-gray-500">Loading...</span>');
        $('#projectGroups').empty();

        if (workTypeId) {
            $.ajax({
                url: '/get-subtypes/' + workTypeId,
                type: 'GET',
                success: function (res) {
                    let html = '';
                    if (res.length > 0) {
                        res.forEach(function (subtype) {
                            html += `
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="work_subtype[]" value="${subtype.id}" 
                                           class="work-subtype-checkbox text-blue-600 focus:ring-blue-500"
                                           data-subtype-name="${subtype.work_subtype}">
                                    <span>${subtype.work_subtype}</span>
                                </label>`;
                        });
                    } else {
                        html = '<span class="text-red-500">No Project Types Found</span>';
                    }
                    $('#workSubtypeCheckboxes').html(html);
                },
                error: function () {
                    $('#workSubtypeCheckboxes').html('<span class="text-red-500">Failed to load project types</span>');
                }
            });
        } else {
            $('#workSubtypeCheckboxes').empty();
        }
    });

    // When Project Type is checked/unchecked
    $(document).on('change', '.work-subtype-checkbox', function () {
        const subtypeId = $(this).val();
        const subtypeName = $(this).data('subtype-name');
        const isChecked = $(this).is(':checked');

        if (isChecked) {
            // Add project section
            if ($(`#project-${subtypeId}`).length === 0) {
                $('#projectGroups').append(`
                    <div id="project-${subtypeId}" class="mt-4 p-4 border rounded-lg bg-gray-50">
                        <div class="font-semibold text-blue-800 mb-2">${subtypeName}</div>
                        <div class="vendor-list text-sm text-gray-700">Loading...</div>
                        <div class="sub-vendors"></div>
                    </div>
                `);
            }

            // Fetch vendors for this project type
            $.ajax({
                url: '/get-vendors',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    subtype_ids: [subtypeId]
                },
                success: function (vendors) {
                    let html = '';
                    if (vendors.length > 0) {
                        vendors.forEach(function (vendor) {
                            html += `
                                <label class="flex items-center space-x-3 mb-1">
                                    <input type="checkbox" name="vendor_type[${subtypeId}][]" value="${vendor.id}" 
                                           class="vendor-checkbox text-blue-600 focus:ring-blue-500"
                                           data-vendor-name="${vendor.vendor_type}"
                                           data-project-id="${subtypeId}">
                                    <span>${vendor.vendor_type}</span>
                                </label>`;
                        });
                    } else {
                        html = '<span class="text-red-500">No Work/Service Models found</span>';
                    }
                    $(`#project-${subtypeId} .vendor-list`).html(html);
                }
            });
        } else {
            // Remove project group
            $(`#project-${subtypeId}`).remove();
        }
    });

    // When Vendor is checked/unchecked
    $(document).on('change', '.vendor-checkbox', function () {
        const vendorId = $(this).val();
        const vendorName = $(this).data('vendor-name');
        const projectId = $(this).data('project-id');
        const isChecked = $(this).is(':checked');

        if (isChecked) {
            $.ajax({
                url: '/get-sub-vendors/' + vendorId,
                type: 'GET',
                success: function (subcategories) {
                    let html = `
                        <div class="mt-2 p-2 border border-blue-200 rounded bg-blue-50" id="subgroup-${vendorId}">
                            <div class="text-sm font-semibold text-blue-700 mb-1">${vendorName} - Categories</div>`;
                    if (subcategories.length > 0) {
                        subcategories.forEach(function (sub) {
                            html += `
                                <label class="flex items-center space-x-3 mb-1">
                                    <input type="checkbox" name="sub_vendor_types[${vendorId}][]" value="${sub.id}">
                                    <span>${sub.vendor_subcategory}</span>
                                </label>`;
                        });
                    } else {
                        html += '<p class="text-xs text-gray-500 italic">No subcategories found.</p>';
                    }
                    html += '</div>';
                    $(`#project-${projectId} .sub-vendors`).append(html);
                }
            });
        } else {
            $(`#subgroup-${vendorId}`).remove();
        }
    });

    // Reset form
    $('#resetBtn').on('click', function () {
        $('#work_type').val(null).trigger('change');
        $('#workSubtypeCheckboxes').empty();
        $('#projectGroups').empty();
    });

    // Submit form
    $('#serviceForm').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: "{{ route('save.agency.services') }}",
            type: 'POST',
            data: formData,
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
