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
      {id:'bill_status', icon:'bi-file-earmark-text', label:'Bill Status'},
      {id:'my_bids', icon:'bi-file-earmark-text', label:'My Bids'},

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

  @if(count($projects_with_details) > 0)
    <div class="grid md:grid-cols-3 gap-6">
      @foreach($projects_with_details as $index => $item)
        @php
          $project = $item['project'];
          $details = $item['details'];

          // ✅ Use the first details record to show top-level info
          $mainDetail = $details->first();

          // ✅ Fallback if some fields are missing
          $projectName = $mainDetail->project_name ?? 'Unnamed Project';
          $projectDescription = $mainDetail->project_description ?? 'No description available.';
          $submissionId = $mainDetail->submission_id ?? '-';
          $created_at = $mainDetail->created_at ?? '-';
          $confirm = $mainDetail->confirm ?? 0;
          $filePaths = json_decode($mainDetail->file_path ?? '[]', true);

          // ✅ Status colors
          $status = $confirm == 1 ? 'Confirmed' : 'Pending';
          $statusColor = $confirm == 1 ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700';
        @endphp

        <!-- Each project card -->
        <div 
          x-show="{{ $index }} < visibleCount" 
          class="bg-white rounded-xl border-l-4 border-orange shadow-md hover:shadow-lg transition p-6">

          <div class="flex justify-between items-center mb-2">
            <h3 class="font-semibold text-navy">
              {{ $projectName }}
            </h3>
            <span class="{{ $statusColor }} text-sm px-3 py-1 rounded-full">
              {{ $status == 'Confirmed' ? '✔ Confirmed' : '⏳ Pending' }}
            </span>
          </div>

          <p class="text-gray-600 text-sm mb-4">
            {{ $projectDescription }}
          </p>

          <p class="text-sm text-gray-500 mb-1">
            Submission ID: 
            <span class="font-semibold text-navy">{{ $submissionId }}</span>
          </p>

          <p class="text-sm text-gray-500 mb-4 flex items-center gap-1">
              <i class="bi bi-calendar"></i>
              {{ \Carbon\Carbon::parse($created_at)->format('d M Y') }}
          </p>


          <!-- ✅ Show all detail entries -->
          @if(count($details) > 0)
            <div class="mt-3 border-t pt-3">
              <h4 class="font-semibold text-navy mb-2 text-sm">Project Submissions:</h4>
              <ul class="text-sm text-gray-600 list-disc list-inside space-y-1">
                @foreach($details as $detail)
                  <li>
                    <span class="font-semibold text-navy">
                      {{ $detail->project_name }}
                    </span> — {{ $detail->project_description }}
                    <br>
                    <span class="text-xs text-gray-500">
                      Submission: {{ $detail->submission_id }} • 
                      {{ \Carbon\Carbon::parse($detail->created_at)->format('d/m/Y') }}
                    </span>
                  </li>
                @endforeach
              </ul>
            </div>
          @endif

          <a href="{{ route('customer.project.view', encrypt($project->id)) }}" 
            class="w-full inline-flex justify-center items-center bg-navy hover:bg-orange text-white py-2 rounded-lg mt-4 transition gap-2">
            View Details <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      @endforeach
    </div>

    <!-- Load More Button -->
    <div class="text-center mt-8" x-show="visibleCount < {{ count($projects_with_details) }}">
      <button 
        @click="visibleCount += 6"
        class="bg-orange hover:bg-[#d84d03] text-white px-6 py-2 rounded-full font-medium shadow-md transition">
        Load More <i class="bi bi-chevron-down ml-2"></i>
      </button>
    </div>

    <!-- All projects loaded message -->
    <div class="text-center mt-4 text-gray-500" x-show="visibleCount >= {{ count($projects_with_details) }}">
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
  <h2 class="text-2xl font-semibold text-navy mb-6 flex items-center gap-2">
    <i class="bi bi-person-circle text-orange text-2xl"></i> Your Profile
  </h2>

  <div class="bg-white p-8 rounded-2xl shadow-md border-l-4 border-orange max-w-8xl mx-auto">

    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="project_id" value="{{ $cust_details->id ?? '' }}">

      <!-- ================= PROFILE PHOTO ================= -->
      <div class="flex flex-col sm:flex-row items-center gap-6 border-b pb-6 mb-8">
        <div class="relative">
          <img 
            id="photoPreview" 
            src="{{ asset('storage/'.($cust_details->profile_photo ?? 'images/default-avatar.png')) }}" 
            class="w-28 h-28 rounded-full object-cover border-4 border-orange shadow-sm" 
            alt="Profile Photo">
          <label 
            for="profile_photo"
            class="absolute bottom-0 right-0 bg-orange text-white text-xs px-3 py-1 rounded-full cursor-pointer hover:bg-[#d84f03]">
            Change
          </label>
          <input type="file" name="profile_photo" id="profile_photo" class="hidden" accept="image/*" onchange="previewImage(event)">
        </div>
        <div>
          <h3 class="text-lg font-semibold text-navy mb-1">{{ $cust_details->full_name ?? '' }}</h3>
          <p class="text-gray-500 text-sm"><i class="bi bi-envelope me-2"></i>{{ $cust_details->email ?? '' }}</p>
          <p class="text-gray-500 text-sm"><i class="bi bi-telephone me-2"></i>{{ $cust_details->phone_number ?? '' }}</p>
        </div>
      </div>

      <!-- ================= BASIC DETAILS ================= -->
      <h3 class="text-lg font-semibold text-navy mb-3 flex items-center gap-2">
        <i class="bi bi-info-circle text-orange"></i> Basic Information
      </h3> 

      <div class="grid md:grid-cols-2 gap-4 mb-8">
        <div>
          <label class="text-sm text-gray-500">Full Name</label>
          <input type="text" name="full_name" value="{{ $cust_details->full_name }}" class="w-full border border-gray-300 rounded-lg p-2 focus:border-orange outline-none bg-gray-50" readonly>
        </div>

        <div>
          <label class="text-sm text-gray-500">Email</label>
          <input type="email" name="email" value="{{ $cust_details->email }}" class="w-full border border-gray-300 rounded-lg p-2 focus:border-orange outline-none bg-gray-50" readonly>
        </div>

        <div>
          <label class="text-sm text-gray-500">Phone</label>
          <input type="text" name="phone_number" value="{{ $cust_details->phone_number }}" class="w-full border border-gray-300 rounded-lg p-2 focus:border-orange outline-none">
        </div>

        <div>
          <label class="text-sm text-gray-500">Occupation</label>
          <select required id="role_id" name="role_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-custom-blue focus:border-custom-blue transition-all">
            <option value="">Select your role</option>
            @foreach($role_types as $role)
              <option value="{{ $role->id }}" {{ ($cust_details->role_id ?? '') == $role->id ? 'selected' : '' }}>
                {{ $role->role }}
              </option>
            @endforeach
          </select>
        </div>


        <div>
          <label class="text-sm text-gray-500">Gender</label>
          <select name="gender" class="w-full border border-gray-300 rounded-lg p-2 focus:border-orange outline-none">
            <option value="">Select Gender</option>
            <option value="Male" {{ $cust_details->gender == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ $cust_details->gender == 'Female' ? 'selected' : '' }}>Female</option>
            <option value="Other" {{ $cust_details->gender == 'Other' ? 'selected' : '' }}>Other</option>
          </select>
        </div>
      </div>

      <!-- ================= DOCUMENT SECTION ================= -->
      <h3 class="text-lg font-semibold text-navy mb-3 flex items-center gap-2">
        <i class="bi bi-file-earmark-text text-orange"></i> Business Documents
      </h3>

      <div class="grid md:grid-cols-2 gap-4 mb-8">
        <div>
          <label class="text-sm text-gray-500">GST Number</label>
          <input type="text" name="gst_no" value="{{ $cust_details->gst_no ?? '' }}" placeholder="Enter GST No" class="w-full border border-gray-300 rounded-lg p-2 focus:border-orange outline-none">
        </div>

        <div>
          <label class="text-sm text-gray-500">GST Certificate</label>
          <input type="file" name="gst_certificate" class="w-full border border-gray-300 rounded-lg p-2 focus:border-orange outline-none bg-gray-50">
          @if(!empty($cust_details->gst_certificate))
            <a href="{{ asset('storage/'.$cust_details->gst_certificate) }}" target="_blank" class="text-sm text-blue-600 hover:underline mt-1 inline-block">View Uploaded File</a>
          @endif
        </div>

        <div>
          <label class="text-sm text-gray-500">TDS Certificate</label>
          <input type="file" name="tds_certificate" class="w-full border border-gray-300 rounded-lg p-2 focus:border-orange outline-none bg-gray-50">
          @if(!empty($cust_details->tds_certificate))
            <a href="{{ asset('storage/'.$cust_details->tds_certificate) }}" target="_blank" class="text-sm text-blue-600 hover:underline mt-1 inline-block">View Uploaded File</a>
          @endif
        </div>
      </div>

      <!-- ================= LOCATION SECTION ================= -->
      <h3 class="text-lg font-semibold text-navy mb-3 flex items-center gap-2">
        <i class="bi bi-geo-alt text-orange"></i> Location Details
      </h3>

      <div class="grid md:grid-cols-3 gap-4 mb-8">
        <div>
          <label class="text-sm text-gray-500">Select State</label>
          <select name="state" id="state" class="w-full border border-gray-300 rounded-lg p-2 focus:border-orange outline-none">
            <option value="">Select State</option>
            @foreach($states as $state)
              <option value="{{ $state->id }}" {{ ($cust_details->state ?? '') == $state->id ? 'selected' : '' }}>
                {{ $state->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="text-sm text-gray-500">Select Region</label>
          <select name="region" id="region" class="form-control w-full border border-gray-300 rounded-lg p-2 focus:border-orange outline-none">
            <option value="">-- Select Region --</option>
          </select>
        </div>

        <div>
          <label class="text-sm text-gray-500">Select City</label>
          <select name="city" id="city" class="form-control w-full border border-gray-300 rounded-lg p-2 focus:border-orange outline-none">
            <option value="">-- Select City --</option>
          </select>
        </div>
      </div>

      <!-- ================= SUBMIT BUTTON ================= -->
      <div class="text-center">
        <button type="submit" class="bg-navy hover:bg-orange text-white px-8 py-3 rounded-lg text-sm font-medium transition shadow-md hover:shadow-lg">
          <i class="bi bi-save me-2"></i> Update Profile
        </button>
      </div>

    </form>
    
    <!-- ================= COMPANY SOCIAL LINKS (AFTER SUBMIT BUTTON) ================= -->
    <div class="mt-10 text-center">
      <h3 class="text-lg font-semibold text-navy mb-3 flex items-center justify-center gap-2">
        <i class="bi bi-hand-thumbs-up-fill text-orange"></i>
        Like & Follow Us
      </h3>

      <p class="text-gray-600 text-sm mb-4">Stay connected with us on social media for updates, news, and offers.</p>

      <div class="flex flex-wrap justify-center gap-6 mt-4">
        @if(!empty($company_socials['facebook']))
          <a href="{{ $company_socials['facebook'] }}" target="_blank" 
             class="flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium transition">
            <i class="bi bi-facebook text-2xl"></i> Facebook
          </a>
        @endif

        @if(!empty($company_socials['linkedin']))
          <a href="{{ $company_socials['linkedin'] }}" target="_blank" 
             class="flex items-center gap-2 text-blue-700 hover:text-blue-900 font-medium transition">
            <i class="bi bi-linkedin text-2xl"></i> LinkedIn
          </a>
        @endif

        @if(!empty($company_socials['instagram']))
          <a href="{{ $company_socials['instagram'] }}" target="_blank" 
             class="flex items-center gap-2 text-pink-600 hover:text-pink-800 font-medium transition">
            <i class="bi bi-instagram text-2xl"></i> Instagram
          </a>
        @endif

        @if(!empty($company_socials['twitter']))
          <a href="{{ $company_socials['twitter'] }}" target="_blank" 
             class="flex items-center gap-2 text-sky-500 hover:text-sky-700 font-medium transition">
            <i class="bi bi-twitter text-2xl"></i> Twitter
          </a>
        @endif
      </div>
    </div>
  </div>
</div>


  <!-- ======================== DOCUMENTS TAB ======================== -->
<div class="mt-10" x-show="tab === 'documents'" x-transition>
    <h2 class="text-xl font-semibold text-navy mb-4">Uploaded Documents</h2>

    <div class="bg-white rounded-xl border-l-4 border-orange shadow-md p-6 max-w-6xl mx-auto">

        <!-- -------------------------- -->
        <!-- ARCHITECTURAL DRAWINGS     -->
        <!-- -------------------------- -->
        @php 
            $archFiles = $project->arch_files ? json_decode($project->arch_files, true) : []; 
        @endphp

        <div class="border-b pb-3 mb-5">
            <h3 class="font-semibold text-navy mb-3">Architectural Drawings</h3>

            @if(count($archFiles))
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($archFiles as $file)
                        <div class="flex justify-between items-center bg-gray-100 p-3 rounded-lg shadow-sm">
                            <span class="text-sm text-gray-700 truncate">{{ basename($file) }}</span>

                            <div class="flex gap-2">
                                <a href="{{ asset('storage/'.$file) }}" target="_blank"
                                   class="bg-navy hover:bg-orange text-white px-3 py-1 text-xs rounded-md">
                                    View
                                </a>
                                <a href="{{ asset('storage/'.$file) }}" download
                                   class="bg-orange hover:bg-navy text-white px-3 py-1 text-xs rounded-md">
                                    Download
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <form action="{{ route('project.upload.document', $project->id) }}" 
                      method="POST" enctype="multipart/form-data" 
                      class="flex items-center space-x-2">
                    @csrf
                    <input type="hidden" name="type" value="arch">
                    <input type="file" name="file" class="text-sm" required>
                    <button class="bg-orange hover:bg-navy text-white px-3 py-1 text-sm rounded-lg">Upload</button>
                </form>
            @endif
        </div>

        <!-- -------------------------- -->
        <!-- STRUCTURAL DRAWINGS        -->
        <!-- -------------------------- -->
        @php 
            $structFiles = $project->struct_files ? json_decode($project->struct_files, true) : []; 
        @endphp

        <div class="border-b pb-3 mb-5">
            <h3 class="font-semibold text-navy mb-3">Structural Drawings</h3>

            @if(count($structFiles))
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($structFiles as $file)
                        <div class="flex justify-between items-center bg-gray-100 p-3 rounded-lg shadow-sm">
                            <span class="text-sm text-gray-700 truncate">{{ basename($file) }}</span>

                            <div class="flex gap-2">
                                <a href="{{ asset('storage/'.$file) }}" target="_blank"
                                   class="bg-navy hover:bg-orange text-white px-3 py-1 text-xs rounded-md">
                                    View
                                </a>
                                <a href="{{ asset('storage/'.$file) }}" download
                                   class="bg-orange hover:bg-navy text-white px-3 py-1 text-xs rounded-md">
                                    Download
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <form action="{{ route('project.upload.document', $project->id) }}" 
                      method="POST" enctype="multipart/form-data" 
                      class="flex items-center space-x-2">
                    @csrf
                    <input type="hidden" name="type" value="struct">
                    <input type="file" name="file" class="text-sm" required>
                    <button class="bg-orange hover:bg-navy text-white px-3 py-1 text-sm rounded-lg">Upload</button>
                </form>
            @endif
        </div>

        <!-- -------------------------- -->
        <!-- CUSTOMER BOQ               -->
        <!-- -------------------------- -->
        <div class="border-b pb-3 mb-5">
            <h3 class="font-semibold text-navy mb-3">Customer BOQ File</h3>

            @if($project->boq_file)
                <a href="{{ asset('storage/'.$project->boq_file) }}" download
                   class="bg-navy hover:bg-orange text-white px-4 py-1 rounded-lg text-sm">
                    Download BOQ
                </a>
            @else
                <form action="{{ route('project.upload.document', $project->id) }}" 
                      method="POST" enctype="multipart/form-data" 
                      class="flex items-center space-x-2">
                    @csrf
                    <input type="hidden" name="type" value="boq">
                    <input type="file" name="file" class="text-sm" required>
                    <button class="bg-orange hover:bg-navy text-white px-3 py-1 text-sm rounded-lg">Upload</button>
                </form>
            @endif
        </div>

        <!-- -------------------------- -->
        <!-- ENGINEER BOQ               -->
        <!-- -------------------------- -->
        <div>
            <h3 class="font-semibold text-navy mb-3">Engineer BOQ File</h3>

            @if($project->engg_boq_file_uploaded)
                <a href="{{ asset('storage/'.$project->engg_boq_file_uploaded) }}" download
                   class="bg-navy hover:bg-orange text-white px-4 py-1 rounded-lg text-sm">
                    Download Engineer BOQ
                </a>
            @else
                <p class="text-gray-500 text-sm">Engineer BOQ not uploaded yet.</p>
            @endif
        </div>

    </div>
</div>

<div class="mt-10" x-show="tab === 'bill_status'" x-transition>
  <div class="bg-white rounded-2xl shadow-md border-l-4 border-orange p-8 max-w-8xl mx-auto">
    
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-2xl font-semibold text-navy">Customer View - Bill Status</h2>
        <p class="text-gray-500 text-sm">Track your monthly bill submissions and approval status</p>
      </div>
    </div>

    <!-- ✅ Top Summary Counts -->
    @php
      $approvedCount = $bills->where('status', 'Approved')->count();
      $revisedCount  = $bills->where('status', 'Revised')->count();
      $rejectedCount = $bills->where('status', 'Rejected')->count();
      $pendingCount  = $bills->where('status', 'Pending')->count();
    @endphp

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
      <div class="bg-green-50 border-l-4 border-green-600 p-4 rounded-xl flex justify-between items-center shadow-sm">
        <div>
          <h4 class="font-semibold text-green-700">Approved</h4>
          <p class="text-2xl font-bold text-green-800">{{ $approvedCount }}</p>
        </div>
        <i class="bi bi-check-circle-fill text-green-600 text-3xl"></i>
      </div>

      <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-xl flex justify-between items-center shadow-sm">
        <div>
          <h4 class="font-semibold text-yellow-700">Revised</h4>
          <p class="text-2xl font-bold text-yellow-800">{{ $revisedCount }}</p>
        </div>
        <i class="bi bi-exclamation-triangle-fill text-yellow-500 text-3xl"></i>
      </div>

      <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded-xl flex justify-between items-center shadow-sm">
        <div>
          <h4 class="font-semibold text-red-700">Rejected</h4>
          <p class="text-2xl font-bold text-red-800">{{ $rejectedCount }}</p>
        </div>
        <i class="bi bi-x-circle-fill text-red-600 text-3xl"></i>
      </div>

      <div class="bg-gray-50 border-l-4 border-gray-500 p-4 rounded-xl flex justify-between items-center shadow-sm">
        <div>
          <h4 class="font-semibold text-gray-700">Pending</h4>
          <p class="text-2xl font-bold text-gray-800">{{ $pendingCount }}</p>
        </div>
        <i class="bi bi-clock-history text-gray-600 text-3xl"></i>
      </div>
    </div>

    <!-- ✅ Bill Data Table -->
    <div class="overflow-x-auto rounded-xl border border-gray-200">
      <table class="min-w-full text-sm text-left">
        <thead class="bg-gray-100 text-gray-700 font-semibold">
          <tr>
            <th class="py-3 px-6">Month</th>
            <th class="py-3 px-6">Project ID</th>
            <th class="py-3 px-6">Amount Claimed (₹)</th>
            <th class="py-3 px-6">Work Description</th>
            <th class="py-3 px-6">Status</th>
            <th class="py-3 px-6">Engineer Remarks</th>
            <th class="py-3 px-6 text-center">Attachments</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
          @forelse($bills as $bill)
            <tr class="hover:bg-gray-50">
              <td class="py-3 px-6 font-medium text-gray-700">
                {{ \Carbon\Carbon::parse($bill->bill_month)->format('F Y') }}
              </td>

              <td class="py-3 px-6 text-navy font-semibold">
                {{ $bill->project_id }}
              </td>

              <td class="py-3 px-6 text-gray-700">
                ₹{{ number_format($bill->amount, 2) }}
              </td>

              <td class="py-3 px-6 text-gray-600">
                {{ $bill->work_description }}
              </td>

              <td class="py-3 px-6">
                @php
                  $statusColors = [
                    'Approved' => 'bg-green-100 text-green-700',
                    'Revised'  => 'bg-yellow-100 text-yellow-700',
                    'Rejected' => 'bg-red-100 text-red-700',
                    'Pending'  => 'bg-gray-100 text-gray-700',
                  ];
                  $badge = $statusColors[$bill->status] ?? 'bg-gray-100 text-gray-700';
                @endphp
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                  {{ $bill->status }}
                </span>
              </td>

              <td class="py-3 px-6 text-gray-600">
                {{ $bill->engineer_remarks ?? '-' }}
              </td>

              <td class="py-3 px-6 text-center">
                <div class="flex flex-col items-center gap-2">
                  @if(!empty($bill->invoice_path))
                    <a href="{{ asset($bill->invoice_path) }}" target="_blank"
                      class="bg-blue-50 text-blue-700 hover:bg-blue-100 font-medium px-4 py-1.5 rounded-lg text-sm flex items-center justify-center gap-2 transition">
                      <i class="bi bi-paperclip"></i> Invoice
                    </a>
                  @endif

                  @if(!empty($bill->quantity_sheet))
                    <a href="{{ asset($bill->quantity_sheet) }}" target="_blank"
                      class="bg-green-50 text-green-700 hover:bg-green-100 font-medium px-4 py-1.5 rounded-lg text-sm flex items-center justify-center gap-2 transition">
                      <i class="bi bi-file-earmark-excel"></i> Qty Sheet
                    </a>
                  @endif

                  @if(!empty($bill->site_photos))
                    @php
                      $photos = json_decode($bill->site_photos, true);
                    @endphp
                    @if(is_array($photos))
                      <div class="flex flex-wrap justify-center gap-1 mt-1">
                        @foreach($photos as $photo)
                          <a href="{{ asset($photo) }}" target="_blank" class="block">
                            <img src="{{ asset($photo) }}" alt="Site Photo"
                              class="w-10 h-10 rounded-lg object-cover border hover:scale-110 transition-transform">
                          </a>
                        @endforeach
                      </div>
                    @endif
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-6 text-gray-500">
                No bills found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>


<!-- ======================== MY BIDS TAB ======================== -->
<!-- <div class="mt-10" x-show="tab === 'my_bids'" x-transition>
    <h2 class="text-xl font-semibold text-navy mb-4">My Bid Submissions</h2>

    @if(count($my_bids) > 0)
        <div class="grid md:grid-cols-3 gap-6">

            @foreach($my_bids as $bid)
                <div class="bg-white rounded-xl border-l-4 border-orange shadow-md p-6 hover:shadow-lg transition">

                    <h3 class="font-semibold text-navy mb-2">
                        Project ID: {{ $bid->project_id }}
                    </h3>

                    <p class="text-gray-600 text-sm mb-2">
                        <strong>Bid Amount:</strong> ₹{{ number_format($bid->bid_amount) }}
                    </p>

                    <p class="text-gray-600 text-sm mb-4 flex items-center gap-2">
                        <i class="bi bi-calendar"></i>
                        {{ \Carbon\Carbon::parse($bid->created_at)->format('d M Y') }}
                    </p>

                    
                    <div class="bg-gray-100 rounded-lg p-3 flex justify-between items-center">
                        <span class="text-sm text-gray-700 truncate">
                            {{ basename($bid->boq_file) }}
                        </span>

                        <a href="{{ asset('storage/'.$bid->boq_file) }}" 
                           target="_blank"
                           class="bg-navy hover:bg-orange text-white px-3 py-1 text-xs rounded-md">
                            View
                        </a>
                    </div>

                </div>
            @endforeach

        </div>

    @else
        <div class="text-center text-gray-600 bg-white rounded-xl p-10 shadow-sm">
            <i class="bi bi-cash-stack text-4xl text-orange mb-3"></i>
            <p>No bids found.</p>
        </div>
    @endif
</div> -->
<div class="mt-10" x-show="tab === 'my_bids'" x-transition>
    <h2 class="text-xl font-semibold text-navy mb-4">My Bid Submissions</h2>

    @if(count($my_bids) > 0)

        <div class="space-y-4">

            @foreach($my_bids as $bid)

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-lg transition p-5">

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">

                        <!-- LEFT BLOCK -->
                        <div class="flex-1">

                            <h3 class="font-semibold text-navy text-lg mb-1">
                                Project ID: {{ $bid->project_id }}
                            </h3>

                            <!-- Vendor Info -->
                            <div class="bg-gray-100 rounded-lg px-3 py-2 border w-fit mb-3">
                                <p class="text-sm text-gray-700">
                                    <strong class="text-navy">Vendor ID:</strong> 
                                    {{ $bid->vendor_code ?? $bid->vendor_id }}
                                </p>
                            </div>

                            <div class="space-y-1 text-sm text-gray-700">

                                <p>
                                    <strong class="text-navy">Bid Amount:</strong>
                                    ₹{{ number_format($bid->bid_amount) }}
                                </p>

                                <p class="flex items-center gap-1">
                                    <i class="bi bi-calendar text-gray-500"></i>
                                    Submitted on: {{ \Carbon\Carbon::parse($bid->created_at)->format('d M Y') }}
                                </p>
                            </div>
                        </div>

                        <!-- MIDDLE BLOCK: BOQ FILE -->
                        <div class="min-w-[220px] bg-gray-50 border rounded-xl p-4 shadow-sm">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">
                                BOQ File
                            </p>

                            <div class="flex items-center gap-2 text-sm text-gray-800 font-medium">
                                <i class="bi bi-file-earmark-spreadsheet text-xl text-orange"></i>
                                <span class="truncate">{{ basename($bid->boq_file) }}</span>
                            </div>

                            <a href="{{ asset('storage/'.$bid->boq_file) }}"
                               target="_blank"
                               class="block bg-navy hover:bg-orange text-white text-center mt-3 py-1.5 text-xs rounded-lg transition">
                                View File
                            </a>
                        </div>

                        <!-- RIGHT BLOCK: ACTION BUTTONS -->
                        <div class="flex flex-col md:flex-row gap-2 w-full md:w-fit">

                            <!-- ACCEPT -->
                            <button onclick="acceptBid({{ $bid->id }})"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 shadow-sm transition">
                                <i class="bi bi-check-circle"></i> Accept
                            </button>

                            <!-- REJECT -->
                            <button onclick="rejectBid({{ $bid->id }})"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 shadow-sm transition">
                                <i class="bi bi-x-circle"></i> Reject
                            </button>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else
        <div class="text-center text-gray-600 bg-white rounded-xl p-10 shadow-sm">
            <i class="bi bi-cash-stack text-4xl text-orange mb-3"></i>
            <p>No bids found.</p>
        </div>
    @endif
</div>



</div>

</div>

</body>
</html>
<!-- ✅ Load jQuery before using $ -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
function previewImage(event) {
  const reader = new FileReader();
  reader.onload = function(){
    const output = document.getElementById('photoPreview');
    output.src = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
}


</script>
<script>
$(document).ready(function() {

    let selectedState = "{{ $cust_details->state ?? '' }}";
    let selectedRegion = "{{ $cust_details->region ?? '' }}";
    let selectedCity = "{{ $cust_details->city ?? '' }}";

    // 🔹 When state changes
    $('#state').on('change', function() {
        let state_id = $(this).val();
        $('#region').empty().append('<option value="">-- Select Region --</option>');
        $('#city').empty().append('<option value="">-- Select City --</option>');

        if (state_id) {
            $.get('/get-regions/' + state_id, function(data) {
                $.each(data, function(key, value) {
                    $('#region').append('<option value="'+ key +'">'+ value +'</option>');
                });

                // ✅ Auto-select saved region if state matches
                if (selectedRegion && selectedState == state_id) {
                    $('#region').val(selectedRegion).trigger('change');
                }
            });
        }
    });

    // 🔹 When region changes
    $('#region').on('change', function() {
        let region_id = $(this).val();
        $('#city').empty().append('<option value="">-- Select City --</option>');

        if (region_id) {
            $.get('/get-cities/' + region_id, function(data) {
                $.each(data, function(key, value) {
                    $('#city').append('<option value="'+ key +'">'+ value +'</option>');
                });

                // ✅ Auto-select saved city if region matches
                if (selectedCity && selectedRegion == region_id) {
                    $('#city').val(selectedCity);
                }
            });
        }
    });

    // 🔹 Auto-load saved state’s regions and cities on page load
    if (selectedState) {
        $('#state').trigger('change');
    }
});
</script>
<script>
function acceptBid(id) {
    if(!confirm("Accept this bid?")) return;

    $.post("/customer/bid/accept", {
        _token: "{{ csrf_token() }}",
        bid_id: id
    }, res => { alert(res.message); location.reload(); });
}

function rejectBid(id) {
    if(!confirm("Reject this bid?")) return;

    $.post("/customer/bid/reject", {
        _token: "{{ csrf_token() }}",
        bid_id: id
    }, res => { alert(res.message); location.reload(); });
}
</script>


@endsection
