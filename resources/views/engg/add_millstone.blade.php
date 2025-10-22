@extends('layouts.engineer.app')

@section('title', 'Project Milestone Plan')

@section('content')
<div class="container mt-4">
  <h4 class="mb-3">Project Milestone Plan</h4>

  {{-- Add Form for Saving --}}
  <form id="milestoneForm" method="POST" action="{{ route('engineer.milestones.store') }}">
    @csrf

    {{-- Select Project --}}
    <div class="row mb-4">
      <div class="col-md-6">
        <label for="project_id" class="form-label">Select Project</label>
        <select id="project_id" name="project_id" class="form-select" required>
          <option value="">-- Select Project --</option>
          @foreach ($projects as $project)
            <option value="{{ $project->id }}">{{ $project->project_name }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <table class="table table-bordered align-middle" id="milestoneTable">
      <thead class="table-dark">
        <tr>
          <th>Type of Work</th>
          <th>Work to be Done</th>
          <th>Milestone (Main)</th>
          <th>Description</th>
          <th>Timeframe (Days)</th>
          <th>Payment (%)</th>
          <th>Verification Point</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <select name="type_of_work[]" class="form-select type-of-work" required>
              <option value="">Select</option>
              <option value="civil">Civil</option>
              <option value="electrical">Electrical</option>
              <option value="plumbing">Plumbing</option>
              <option value="finishing">Finishing</option>
            </select>
          </td>
          <td>
            <select name="work_to_be_done[]" class="form-select work-to-be-done" required>
              <option value="">Select</option>
            </select>
          </td>
          <td><input type="text" name="milestone_title[]" class="form-control" placeholder="Milestone title" required></td>
          <td><input type="text" name="milestone_description[]" class="form-control" placeholder="Milestone description"></td>
          <td><input type="number" name="timeframe_days[]" class="form-control" min="1" placeholder="Days" required></td>
          <td><input type="number" name="payment_percentage[]" class="form-control milestone-percentage" value="0" min="0" max="100" required></td>
          <td><input type="text" name="verification_point[]" class="form-control" placeholder="Verification point"></td>
          <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
        </tr>
      </tbody>
    </table>

    <button type="button" class="btn btn-success" id="addRow">+ Add Milestone</button>

    <div class="mt-3">
      <strong>Total Payment: <span id="totalPercentage">0</span>%</strong>
    </div>

    {{-- Save Button --}}
    <div class="mt-4">
      <button type="submit" class="btn btn-primary">💾 Save Milestones</button>
    </div>

  </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  // Dropdown data (Type of Work → Work to be done)
  const workOptions = {
    civil: ['Excavation', 'Foundation', 'Slab', 'Brickwork', 'Plaster'],
    electrical: ['Wiring', 'Switchboards', 'Lighting', 'DB Installation'],
    plumbing: ['Water Lines', 'Drainage', 'Fittings', 'Testing'],
    finishing: ['Painting', 'Tiling', 'Carpentry', 'Final Touchup']
  };

  // Add new row
  $("#addRow").click(function() {
    let row = `
      <tr>
        <td>
          <select name="type_of_work[]" class="form-select type-of-work" required>
            <option value="">Select</option>
            <option value="civil">Civil</option>
            <option value="electrical">Electrical</option>
            <option value="plumbing">Plumbing</option>
            <option value="finishing">Finishing</option>
          </select>
        </td>
        <td>
          <select name="work_to_be_done[]" class="form-select work-to-be-done" required>
            <option value="">Select</option>
          </select>
        </td>
        <td><input type="text" name="milestone_title[]" class="form-control" placeholder="Milestone title" required></td>
        <td><input type="text" name="milestone_description[]" class="form-control" placeholder="Milestone description"></td>
        <td><input type="number" name="timeframe_days[]" class="form-control" min="1" placeholder="Days" required></td>
        <td><input type="number" name="payment_percentage[]" class="form-control milestone-percentage" value="0" min="0" max="100" required></td>
        <td><input type="text" name="verification_point[]" class="form-control" placeholder="Verification point"></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
      </tr>
    `;
    $("#milestoneTable tbody").append(row);
  });

  // Remove row
  $(document).on("click", ".removeRow", function() {
    $(this).closest("tr").remove();
    updateTotal();
  });

  // Update "Work to be Done" based on Type of Work
  $(document).on("change", ".type-of-work", function() {
    const selectedType = $(this).val();
    const $workDropdown = $(this).closest("tr").find(".work-to-be-done");
    $workDropdown.empty().append('<option value="">Select</option>');

    if (workOptions[selectedType]) {
      workOptions[selectedType].forEach(function(work) {
        $workDropdown.append(`<option value="${work}">${work}</option>`);
      });
    }
  });

  // Update total payment percentage
  $(document).on("input", ".milestone-percentage", function() {
    updateTotal();
  });

  // Calculate total percentage
  function updateTotal() {
    let total = 0;
    $(".milestone-percentage").each(function() {
      total += parseFloat($(this).val()) || 0;
    });

    $("#totalPercentage").text(total);

    if (total > 100) {
      $("#totalPercentage").css("color", "red");
    } else if (total === 100) {
      $("#totalPercentage").css("color", "green");
    } else {
      $("#totalPercentage").css("color", "orange");
    }
  }
});
</script>
@endsection
