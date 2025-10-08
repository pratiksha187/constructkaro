@extends('layouts.cust_dash.app')

@section('title', 'Customer Dashboard | ConstructKaro')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Customer Dashboard</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            navy: '#1c2c3e',
            orange: '#f25c05',
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
        },
      },
    };
  </script>
</head>

<body class="bg-gray-50 min-h-screen">

<!-- ✅ Alpine state for tabs & project pagination -->
<div class="py-10 px-6" 
     x-data="{ tab: 'projects', visibleCount: 6 }">

  <!-- Header -->
  <div class="bg-navy text-white rounded-2xl p-8 flex flex-col md:flex-row justify-between items-start md:items-center shadow-lg">
    <div>
      <h1 class="text-3xl font-semibold mb-2 flex items-center gap-2">
        Welcome back, <span class="text-orange">{{ $cust_details->full_name }}</span> 👋
      </h1>
      <p class="text-gray-300">Manage your projects, vendors, and account information easily.</p>
    </div>
    <div class="mt-4 md:mt-0">
      <p class="flex items-center gap-2"><i class="bi bi-envelope"></i> {{ $cust_details->email }}</p>
      <p class="flex items-center gap-2"><i class="bi bi-telephone"></i> {{ $cust_details->phone_number }}</p>
    </div>
  </div>

  <!-- Tabs -->
  <div class="flex flex-wrap justify-center mt-8 gap-3">
    <template x-for="item in [
      {id:'projects', icon:'bi-folder2-open', label:'Projects'},
      {id:'packages', icon:'bi-box-seam', label:'Packages'},
      {id:'profile', icon:'bi-person-circle', label:'Profile'},
      {id:'documents', icon:'bi-file-earmark-text', label:'Documents'},
    ]" :key="item.id">
      <button 
        @click="tab = item.id"
        :class="tab === item.id ? 'bg-orange text-white' : 'border border-gray-300 text-gray-700 hover:border-orange hover:text-orange'"
        class="px-6 py-2 rounded-full font-medium shadow-md transition flex items-center gap-2">
        <i :class="item.icon"></i> <span x-text="item.label"></span>
      </button>
    </template>
  </div>

  <!-- ======================== PROJECTS TAB ======================== -->
  <div class="mt-10" x-show="tab === 'projects'" x-transition>
    <h2 class="text-xl font-semibold text-navy mb-4">Your Projects</h2>

    @if($projects->count() > 0)
      <div class="grid md:grid-cols-3 gap-6">
        @foreach($projects as $index => $project)
          @php
            $status = $project->confirm == 1 ? 'Confirmed' : 'Pending';
            $statusColor = $project->confirm == 1 ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700';
            $filePaths = json_decode($project->file_path, true);
           
          @endphp

          <!-- Each project card -->
          <div 
            x-show="{{ $index }} < visibleCount" 
            class="bg-white rounded-xl border-l-4 border-orange shadow-md hover:shadow-lg transition p-6">

            <div class="flex justify-between items-center mb-2">
              <h3 class="font-semibold text-navy">{{ $project->project_name ?? 'Unnamed Project' }}</h3>
              <span class="{{ $statusColor }} text-sm px-3 py-1 rounded-full">
                {{ $status == 'Confirmed' ? '✔ Confirmed' : '⏳ Pending' }}
              </span>
            </div>

         

            <p class="text-gray-600 text-sm mb-4">{{ $project->project_description ?? 'No description available.' }}</p>

            <p class="text-sm text-gray-500 mb-1">Submission ID: 
              <span class="font-semibold text-navy">{{ $project->submission_id }}</span>
            </p>
            <p class="text-sm text-gray-500 mb-4 flex items-center gap-1">
              <i class="bi bi-calendar"></i> 
              {{ \Carbon\Carbon::parse($project->created_at)->format('d/m/Y') }}
            </p>

            <a href="{{ route('customer.project.view', $project->id) }}" 
                class="w-full inline-flex justify-center items-center bg-navy hover:bg-orange text-white py-2 rounded-lg mt-2 transition gap-2">
                View Details <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        @endforeach
      </div>

      <!-- Load More Button -->
      <div class="text-center mt-8" x-show="visibleCount < {{ $projects->count() }}">
        <button 
          @click="visibleCount += 6"
          class="bg-orange hover:bg-[#d84d03] text-white px-6 py-2 rounded-full font-medium shadow-md transition">
          Load More <i class="bi bi-chevron-down ml-2"></i>
        </button>
      </div>

      <!-- All projects loaded message -->
      <div class="text-center mt-4 text-gray-500" x-show="visibleCount >= {{ $projects->count() }}">
        <p>All projects loaded.</p>
      </div>

    @else
      <div class="text-center text-gray-600 bg-white rounded-xl p-10 shadow-sm">
        <i class="bi bi-folder2-open text-4xl text-orange mb-3"></i>
        <p>No projects found.</p>
      </div>
    @endif
  </div>

  <!-- ======================== PACKAGES TAB ======================== -->
  <div class="mt-10" x-show="tab === 'packages'" x-transition>
    <h2 class="text-xl font-semibold text-navy mb-4">Available Packages</h2>
    <div class="grid md:grid-cols-3 gap-6">
      @foreach(['Basic' => 999, 'Pro' => 1999, 'Premium' => 4999] as $plan => $price)
      <div class="bg-white p-6 rounded-xl border-l-4 border-orange shadow-md hover:shadow-lg transition">
        <h3 class="font-semibold text-navy mb-2">{{ $plan }} Plan</h3>
        <p class="text-gray-600 text-sm mb-3">
          @if($plan == 'Basic')
            Ideal for small renovation projects.
          @elseif($plan == 'Pro')
            Best for frequent project owners.
          @else
            For large-scale construction firms.
          @endif
        </p>
        <ul class="text-sm text-gray-600 mb-4 list-disc ml-5">
          @if($plan == 'Basic')
            <li>2 Vendor Connections</li><li>Basic Support</li><li>Email Notifications</li>
          @elseif($plan == 'Pro')
            <li>5 Vendor Connections</li><li>Priority Support</li><li>Project Analytics</li>
          @else
            <li>Unlimited Vendor Access</li><li>Dedicated Manager</li><li>Priority Tenders</li>
          @endif
        </ul>
        <button class="w-full bg-navy hover:bg-orange text-white py-2 rounded-lg transition flex justify-center items-center gap-2">
          Subscribe ₹{{ $price }} <i class="bi bi-arrow-right"></i>
        </button>
      </div>
      @endforeach
    </div>
  </div>

  <!-- ======================== PROFILE TAB ======================== -->
  <div class="mt-10" x-show="tab === 'profile'" x-transition>
    <h2 class="text-xl font-semibold text-navy mb-4">Your Profile</h2>
    <div class="bg-white p-6 rounded-xl border-l-4 border-orange shadow-md max-w-8xl mx-auto">
      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <label class="text-sm text-gray-500">Full Name</label>
          <input type="text" value="{{ $cust_details->full_name }}" class="w-full border border-gray-300 rounded-lg p-2 focus:border-orange outline-none" readonly>
        </div>
        <div>
          <label class="text-sm text-gray-500">Email</label>
          <input type="email" value="{{ $cust_details->email }}" class="w-full border border-gray-300 rounded-lg p-2 focus:border-orange outline-none" readonly>
        </div>
        <div>
          <label class="text-sm text-gray-500">Phone</label>
          <input type="text" value="{{ $cust_details->phone_number }}" class="w-full border border-gray-300 rounded-lg p-2 focus:border-orange outline-none" readonly>
        </div>
        <div>
          <label class="text-sm text-gray-500">Location</label>
          <input type="text" value="{{ Auth::user()->location ?? '' }}" class="w-full border border-gray-300 rounded-lg p-2 focus:border-orange outline-none">
        </div>
      </div>
      <div class="text-center mt-6">
        <button class="bg-navy hover:bg-orange text-white px-6 py-2 rounded-lg">Update Profile</button>
      </div>
    </div>
  </div>

  <!-- ======================== DOCUMENTS TAB ======================== -->
  <div class="mt-10" x-show="tab === 'documents'" x-transition>
    <h2 class="text-xl font-semibold text-navy mb-4">Uploaded Documents</h2>
    <div class="bg-white rounded-xl border-l-4 border-orange shadow-md p-6 max-w-6xl mx-auto">
      <div class="flex justify-between items-center border-b pb-3 mb-3">
        <h3 class="font-semibold text-navy">PAN Card</h3>
        <button class="bg-navy hover:bg-orange text-white px-4 py-1 rounded-lg text-sm">View</button>
      </div>
      <div class="flex justify-between items-center border-b pb-3 mb-3">
        <h3 class="font-semibold text-navy">Aadhar Card</h3>
        <button class="bg-navy hover:bg-orange text-white px-4 py-1 rounded-lg text-sm">View</button>
      </div>
      <div class="flex justify-between items-center">
        <h3 class="font-semibold text-navy">Work Contract</h3>
        <button class="bg-navy hover:bg-orange text-white px-4 py-1 rounded-lg text-sm">Download</button>
      </div>
    </div>
  </div>

</div>

</body>
</html>
@endsection
