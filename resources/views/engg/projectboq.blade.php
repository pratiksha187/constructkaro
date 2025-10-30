@extends('layouts.engineer.app')

@section('title', 'Dashboard')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Tailwind (CDN) -->
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>
  :root{
    --ck-orange:#FF6600;
    --ck-navy:#0B2240;
    --ck-blue:#2949E9;
    --ck-border:#e8eef7;
  }

  /* card chrome */
  .ck-card{
    border:1px solid var(--ck-border);
    border-radius:16px;
    box-shadow:0 10px 24px rgba(12,33,72,.06);
    background:linear-gradient(180deg, rgba(255,102,0,.06), rgba(41,73,233,.04));
  }
  .ck-card > .inner{ background:#fff; border-radius:14px; }

  /* table */
  .ck-table thead th{
    position:sticky; top:0; z-index:1;
    background:#f9fbff;
    color:#4a5673;
    font-weight:700;
    letter-spacing:.02em;
  }
  .ck-table tbody tr:hover{ background:#fafcff; }

  /* buttons */
  .btn-ck{ background:var(--ck-orange); color:#fff; }
  .btn-ck:hover{ background:#e65c00; }
  .btn-soft{
    color:var(--ck-blue);
    background:rgba(41,73,233,.12);
    border:1px solid rgba(41,73,233,.18);
  }
  .btn-soft:hover{ background:rgba(41,73,233,.18); }

  /* modals (pretty) */
  .ck-backdrop{
    position:fixed; inset:0; display:none; align-items:center; justify-content:center;
    background: radial-gradient(1000px 600px at 10% 0, rgba(41,73,233,.25), transparent 60%),
                radial-gradient(1000px 600px at 90% 100%, rgba(255,102,0,.22), transparent 60%),
                rgba(11,34,64,.60);
    backdrop-filter: blur(6px);
  }
  .ck-backdrop.flex{ display:flex; }
  .ck-modal{
    width:100%; max-width:1000px; background:#fff; border-radius:18px; overflow:hidden;
    border:1px solid var(--ck-border); box-shadow:0 28px 60px rgba(12,33,72,.28);
    transform: translateY(6px); animation: pop .18s ease-out forwards;
  }
  @keyframes pop{ to{ transform: translateY(0);} }

  .ck-mhdr{
    display:flex; align-items:center; justify-content:space-between; gap:.75rem;
    padding:14px 18px;
    background:linear-gradient(90deg, rgba(255,102,0,.08), rgba(41,73,233,.08));
    border-bottom:1px solid var(--ck-border); position:sticky; top:0; z-index:2;
  }
  .ck-mtitle{ display:flex; align-items:center; gap:.6rem; font-weight:800; color:var(--ck-navy); }
  .ck-mtitle .material-icons{ color:var(--ck-orange); }
  .ck-mbody{ padding:22px; max-height: calc(90vh - 130px); overflow:auto; background:#fff; }
  .ck-mfooter{
    padding:12px 18px; display:flex; gap:.5rem; justify-content:flex-end;
    background:#fafcff; border-top:1px solid var(--ck-border); position:sticky; bottom:0; z-index:2;
  }
  .ck-close{ border-radius:10px; border:1px solid var(--ck-border); background:#fff; padding:.35rem .55rem; }
  .ck-close .material-icons{ font-size:20px; color:#8a94a7; }
  .ck-close:hover .material-icons{ color:#000; }

  .ck-label{ color:#6b7a90; font-weight:600; font-size:.9rem; }
  .ck-chip{ display:inline-block; font-size:.75rem; font-weight:700; padding:.25rem .6rem;
            color:var(--ck-navy); background:rgba(11,34,64,.06); border-radius:999px; }

  .animate-fade-in{ animation:fadeIn .25s ease-out }
  @keyframes fadeIn{ from{opacity:0; transform:scale(.98)} to{opacity:1; transform:scale(1)} }
</style>

<div class="max-w-7xl mx-auto px-6 py-8">
  <!-- header -->
  <div class="mb-6 flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-extrabold" style="color:var(--ck-navy)">Projects List</h1>
      <p class="text-sm text-slate-500">Manage all assigned projects at a glance.</p>
    </div>
   
  </div>

  <!-- table card -->
  <div class="ck-card">
    <div class="inner p-5">
      <div class="overflow-x-auto rounded-lg border border-[var(--ck-border)]">
        <table class="ck-table min-w-full text-sm">
          <thead>
            <tr>
              <th class="px-4 py-3 text-left">Id</th>
              <th class="px-4 py-3 text-left">Project Name</th>
              <th class="px-4 py-3 text-left">Address</th>
              <th class="px-4 py-3 text-left">Description</th>
              <th class="px-4 py-3 text-left">Action</th>
            </tr>
          </thead>
          <tbody id="projectBody" class="[&_td]:border-t [&_td]:border-[var(--ck-border)] [&_td]:px-4 [&_td]:py-3 text-slate-700"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- ========= Project Modal ========= -->
<div id="projectModal" class="ck-backdrop z-50">
  <div class="ck-modal animate-fade-in">
    <div class="ck-mhdr">
      <div class="ck-mtitle">
        <span class="material-icons">assignment</span>
        <h2 id="modalTitle">Project</h2>
      </div>
      <button class="ck-close" onclick="closeModal()" title="Close">
        <span class="material-icons">close</span>
      </button>
    </div>

    <div class="ck-mbody">
      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <div class="ck-label mb-1">🧾 Submission ID</div>
          <div id="modalSubmissionId" class="font-medium"></div>
        </div>
        <div>
          <div class="ck-label mb-1">📝 Description</div>
          <div id="modalDescription" class="text-slate-700"></div>
        </div>
      </div>

      <div class="mt-5">
        <div class="ck-label mb-2">📁 Project Files</div>
        <ul id="modalFiles" class="list-disc list-inside text-[var(--ck-blue)]"></ul>
      </div>

      <div class="mt-4">
        <div class="ck-label mb-2">📁 BOQ File</div>
        <ul id="modalBoqFile" class="list-disc list-inside text-[var(--ck-blue)]"></ul>
      </div>

      <div class="mt-6 p-4 border border-[var(--ck-border)] rounded-lg bg-[#fafcff]">
        <div class="flex flex-wrap items-center gap-3">
          <button onclick="document.getElementById('boqInput').click()" class="btn-soft px-4 py-2 rounded-lg flex items-center gap-2">
            <span class="material-icons" style="font-size:18px;">upload_file</span> Upload BOQ
          </button>
          <button onclick="toggleTenderModal(true)" class="btn-ck px-4 py-2 rounded-lg flex items-center gap-2">
            <span class="material-icons" style="font-size:18px;">playlist_add</span> Add Tender
          </button>
        </div>

        <input type="file" id="boqInput" class="hidden"
               accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
        <ul id="boqFileList" class="list-disc list-inside text-sm text-gray-600 mt-3"></ul>
        <button id="submitBoqBtn" onclick="submitBOQFiles()" class="btn-ck px-4 py-2 rounded-lg mt-2 hidden">
          Submit BOQ
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ========= Tender Modal ========= -->
<div id="tenderModal" class="ck-backdrop z-[60]">
  <div class="ck-modal animate-fade-in" style="max-width:760px;">
    <div class="ck-mhdr">
      <div class="ck-mtitle">
        <span class="material-icons">note_add</span>
        <h3>Add Tender Details</h3>
      </div>
      <button class="ck-close" onclick="toggleTenderModal(false)" title="Close">
        <span class="material-icons">close</span>
      </button>
    </div>

    <div class="ck-mbody">
      <div id="tenderFormFields" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
    </div>

    <div class="ck-mfooter">
      <button onclick="submitTender()" class="btn-ck px-6 py-2 rounded-lg">Submit Tender</button>
    </div>
  </div>
</div>

<script>
  const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const projectList = @json($projects);

  let activeProject = null;
  let boqFiles = [];
  const tenderForm = {
    tender_value: '',
    product_category: '',
    sub_category: '',
    contract_type: '',
    bid_validity_days: '',
    period_of_work_days: '',
    location: '',
    pincode: '',
    published_date: '',
    bid_opening_date: '',
    bid_submission_start: '',
    bid_submission_end: ''
  };

  renderProjects();

  function renderProjects() {
    const tbody = document.getElementById('projectBody');
    tbody.innerHTML = '';
    projectList.forEach((proj, idx) => {
      tbody.innerHTML += `
        <tr class="transition-colors">
          <td>${idx + 1}</td>
          <td class="font-semibold text-[var(--ck-navy)]">${proj.project_name}</td>
          <td>${proj.land_location}</td>
          <td class="text-slate-600">${proj.project_description}</td>
          <td>
            <button onclick='openModal(${JSON.stringify(proj)})'
                    class="inline-flex items-center gap-1 text-[var(--ck-blue)] hover:underline">
              <span class="material-icons" style="font-size:18px;">visibility</span> View
            </button>
          </td>
        </tr>`;
    });
    if (!projectList.length){
      tbody.innerHTML = `<tr><td colspan="5" class="text-center text-slate-500 py-8">No projects found.</td></tr>`;
    }
  }

  // function openModal(project) {
  //   activeProject = project;
  //   document.getElementById('modalTitle').textContent = project.project_name || 'Project';
  //   document.getElementById('modalSubmissionId').textContent = project.submission_id || '-';
  //   document.getElementById('modalDescription').textContent = project.project_description || '-';

  //   const files = JSON.parse(project.file_path || '[]');
  //   const filesList = document.getElementById('modalFiles');
  //   filesList.innerHTML = files.map(file => `<li><a class="hover:underline" href="/${file}" target="_blank">${file.split('/').pop()}</a></li>`).join('');

  //   const boqFileList = document.getElementById('modalBoqFile');
  //   boqFileList.innerHTML = project.boqFile
  //     ? `<li><a class="hover:underline" href="/storage/boq_files/${project.boqFile.split('/').pop()}" target="_blank">Download BOQ File</a></li>`
  //     : '';

  //   const m = document.getElementById('projectModal');
  //   m.classList.remove('hidden'); m.classList.add('flex');
  // }

function openModal(project) {
  activeProject = project;

  // Basic info
  document.getElementById('modalTitle').textContent = project.project_name || 'Project';
  document.getElementById('modalSubmissionId').textContent = project.submission_id || '-';
  document.getElementById('modalDescription').textContent = project.project_description || '-';

  // Prepare file sections
  const filesList = document.getElementById('modalFiles');
  const boqFileList = document.getElementById('modalBoqFile');

  filesList.innerHTML = '';
  boqFileList.innerHTML = '';

  // Parse JSON safely
  const parseJSON = (str) => {
    try { return JSON.parse(str || '[]'); } catch { return []; }
  };

  // 🔹 Architectural Files
  const archFiles = parseJSON(project.arch_files);
  if (archFiles.length) {
    filesList.innerHTML += `
      <li class="font-semibold text-gray-800 mb-1">🏗 Architectural Drawings</li>
      ${archFiles.map(file => renderFileItem(file)).join('')}
    `;
  }

  // 🔹 Structural Files
  const structFiles = parseJSON(project.struct_files);
  if (structFiles.length) {
    filesList.innerHTML += `
      <li class="font-semibold text-gray-800 mt-3 mb-1">🧱 Structural Drawings</li>
      ${structFiles.map(file => renderFileItem(file)).join('')}
    `;
  }

  // 🔹 General Project Files
  const otherFiles = parseJSON(project.file_path);
  if (otherFiles.length) {
    filesList.innerHTML += `
      <li class="font-semibold text-gray-800 mt-3 mb-1">📁 Uploaded Files</li>
      ${otherFiles.map(file => renderFileItem(file)).join('')}
    `;
  }

  // 🔹 BOQ File (single)
  if (project.boq_file) {
    boqFileList.innerHTML = renderFileItem(project.boq_file);
  } else {
    boqFileList.innerHTML = `<li class="text-slate-400">No BOQ uploaded.</li>`;
  }

  // Show modal
  const m = document.getElementById('projectModal');
  m.classList.remove('hidden');
  m.classList.add('flex');
}

// Helper function to render a file item with View + Download
function renderFileItem(file) {
  const cleanPath = file.replace(/^["']|["']$/g, ''); // remove quotes if any
  const filename = cleanPath.split('/').pop();
  const fileUrl = `/storage/${cleanPath}`;
  return `
    <li class="flex items-center justify-between gap-2 bg-[#f9fbff] border border-[var(--ck-border)] rounded-lg px-3 py-2 mt-1">
      <span class="truncate text-[var(--ck-blue)] text-sm">${filename}</span>
      <div class="flex gap-2">
        <a href="${fileUrl}" target="_blank" class="text-blue-600 text-sm hover:underline flex items-center gap-1">
          <span class="material-icons text-[18px]">visibility</span> View
        </a>
        <a href="${fileUrl}" download="${filename}" class="text-green-600 text-sm hover:underline flex items-center gap-1">
          <span class="material-icons text-[18px]">download</span> Download
        </a>
      </div>
    </li>`;
}


  function closeModal() {
    const m = document.getElementById('projectModal');
    m.classList.add('hidden'); m.classList.remove('flex');
    boqFiles = [];
    document.getElementById('boqFileList').innerHTML = '';
    document.getElementById('submitBoqBtn').classList.add('hidden');
  }

  document.getElementById('boqInput').addEventListener('change', function (e) {
    boqFiles = Array.from(e.target.files || []);
    const list = document.getElementById('boqFileList');
    list.innerHTML = boqFiles.map(f => `<li>${f.name}</li>`).join('');
    if (boqFiles.length) document.getElementById('submitBoqBtn').classList.remove('hidden');
  });

  function submitBOQFiles() {
    if (!activeProject?.id) return alert('Invalid project.');
    if (!boqFiles.length) return alert('Please select a file.');

    const formData = new FormData();
    formData.append('_token', CSRF_TOKEN);
    formData.append('project_id', activeProject.id);
    formData.append('files[]', boqFiles[0]);

    fetch('/engineer/project/upload-boq', { method:'POST', body: formData })
      .then(res => res.json())
      .then(() => { alert('BOQ uploaded successfully!'); location.reload(); })
      .catch(() => alert('Upload failed!'));
  }

  function toggleTenderModal(show) {
    const modal = document.getElementById('tenderModal');
    modal.classList.toggle('hidden', !show);
    modal.classList.toggle('flex', show);

    if (show) {
      const fieldsContainer = document.getElementById('tenderFormFields');
      fieldsContainer.innerHTML = '';
      for (const key in tenderForm) {
        const isDate = ['published_date','bid_opening_date','bid_submission_start','bid_submission_end'].includes(key);
        fieldsContainer.innerHTML += `
          <div>
            <label class="ck-label mb-1 capitalize">${key.replace(/_/g,' ')}</label>
            <input type="${isDate ? 'date' : 'text'}" id="tender-${key}"
                   class="w-full border border-[var(--ck-border)] rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--ck-blue)]/30"
                   value="${tenderForm[key] ?? ''}">
          </div>`;
      }
    }
  }

  function submitTender() {
  if (!activeProject?.id) return alert('Invalid project');

  for (const key in tenderForm) {
    tenderForm[key] = document.getElementById(`tender-${key}`).value;
  }

  const payload = { ...tenderForm, project_id: activeProject.id };

  fetch('/engineer/project/tender', {
    method: 'POST',
    credentials: 'same-origin',                         // <-- send session cookie
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': CSRF_TOKEN                        // <-- explicit CSRF header
    },
    body: JSON.stringify(payload)
  })
  .then(async (res) => {
    const data = await res.json().catch(() => ({}));
    if (!res.ok) throw new Error(data.message || 'Failed to save tender');
    alert(data.message || 'Tender submitted!');
    toggleTenderModal(false);
  })
  .catch((err) => {
    console.error(err);
    alert(err.message || 'Tender submission failed.');
  });
}

</script>
@endsection
