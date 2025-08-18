@extends('layouts.app')

@section('title', 'Join as Service Provider | ConstructKaro')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white p-8 max-w-7xl mx-auto shadow-md rounded-lg mt-10">
    <!-- <h2 class="text-3xl font-bold text-gray-900 mb-2">Select Your Service Type</h2> -->
     <h2 class="text-3xl font-bold mb-2 bg-gradient-to-r from-orange-500 to-blue-500 bg-clip-text text-transparent">
    Select Your Service Type
</h2>

    <p class="text-gray-600 mb-6">Choose the category that best describes your agency. Then select the services you provide.</p>

    <form id="serviceForm" method="POST" action="#">
        @csrf
        <!-- Agency Type -->
        <div class="mb-6">
            <label for="agencyType" class="block text-sm font-semibold text-gray-800 mb-2">Type of Agency</label>
            <select id="agencyType" name="agencyType" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white shadow-sm">
                <option value="">-- Select Agency Type --</option>
                @foreach ($agencyTypes as $agency)
                    <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                @endforeach
            </select>
            <p id="agencyError" class="text-red-500 text-sm mt-2 hidden">You can select only one agency type.</p>
        </div>

        <!-- Services Section -->
        <div id="servicesContainer" class="mb-6 hidden">
            <label class="block text-sm font-semibold text-gray-800 mb-2">Select Services</label>
            <div id="checkboxList" class="grid grid-cols-1 md:grid-cols-2 gap-4 pl-1">
                <!-- Checkboxes injected here -->
            </div>
        </div>

        <!-- Other Service Textbox -->
        <div id="othersTextboxContainer" class="hidden mt-2">
            <input type="text" name="other_service" id="other_service" placeholder="Please specify your service" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-300">
        </div>

        <!-- Buttons -->
        <div class="flex justify-between mt-6">
            <button type="button" id="resetBtn" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition">Back</button>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Continue</button>
        </div>
    </form>
</div>
<script>
    document.getElementById('agencyType').addEventListener('change', function () {
        const agencyId = this.value;
        if (!agencyId) return;

        const servicesContainer = document.getElementById('servicesContainer');
        const checkboxList = document.getElementById('checkboxList');
        const errorBox = document.getElementById('agencyError');

        // Always hide error box (since we're allowing changes)
        errorBox.classList.add('hidden');

        // Clear previous checkboxes
        checkboxList.innerHTML = "";
        document.getElementById('othersTextboxContainer').classList.add('hidden');

        fetch(`/get-services/${agencyId}`)
            .then(response => response.json())
            .then(data => {
                if (Object.keys(data).length > 0) {
                    servicesContainer.classList.remove('hidden');

                    for (const [id, name] of Object.entries(data)) {
                        const checkboxId = `service_${id}`;
                        const isOthers = name.trim().toLowerCase() === 'others';

                        const checkboxWrapper = document.createElement('div');
                        checkboxWrapper.className = 'flex items-center space-x-2';

                        checkboxWrapper.innerHTML = `
                            <input type="checkbox" id="${checkboxId}" name="services[]" value="${id}" class="service-checkbox text-blue-600 focus:ring-blue-500 rounded">
                            <label for="${checkboxId}" class="text-gray-700">${name}</label>
                        `;

                        checkboxList.appendChild(checkboxWrapper);

                        if (isOthers) {
                            const othersCheckbox = () => document.getElementById(checkboxId);
                            setTimeout(() => {
                                othersCheckbox().addEventListener('change', function () {
                                    document.getElementById('othersTextboxContainer').classList.toggle('hidden', !this.checked);
                                });
                            }, 0);
                        }
                    }

                    // ✅ Add listener to limit checkbox selection
                    setTimeout(() => {
                        const checkboxes = document.querySelectorAll('.service-checkbox');

                        checkboxes.forEach(checkbox => {
                            checkbox.addEventListener('change', function () {
                                const selected = Array.from(checkboxes).filter(cb => cb.checked);
                                if (selected.length >= 3) {
                                    checkboxes.forEach(cb => {
                                        if (!cb.checked) cb.disabled = true;
                                    });
                                } else {
                                    checkboxes.forEach(cb => cb.disabled = false);
                                }
                            });
                        });
                    }, 0);
                } else {
                    servicesContainer.classList.add('hidden');
                }
            });
    });

    document.getElementById('serviceForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const agencyType = document.getElementById('agencyType').value;
        const selectedServices = Array.from(document.querySelectorAll('input[name="services[]"]:checked')).map(cb => cb.value);
        const otherServiceInput = document.getElementById('other_service');
        const otherService = otherServiceInput ? otherServiceInput.value.trim() : null;

        fetch("{{ route('save.agency.services') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                agency_type: agencyType,
                services: selectedServices,
                other_service: otherService
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // alert(data.message || 'Saved successfully');
                window.location.href = '{{ route("about_business") }}';
            } else {
                alert(data.message || 'Save failed');
            }
        })
        .catch(() => {
            alert('Something went wrong!');
        });
    });

    document.getElementById('resetBtn').addEventListener('click', function () {
        document.getElementById('agencyType').value = "";
        document.getElementById('agencyError').classList.add('hidden');
        document.getElementById('checkboxList').innerHTML = "";
        document.getElementById('servicesContainer').classList.add('hidden');
        document.getElementById('othersTextboxContainer').classList.add('hidden');
    });
</script>

@endsection
