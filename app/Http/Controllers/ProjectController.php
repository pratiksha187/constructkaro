<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ProjectController extends Controller
{
    public function project(){
        $construction_types = DB::table('categories')->orderBy('id')->get();
        $expected_timeline =DB::table('expected_timeline')->orderBy('id')->get();
        $budgets = DB::table('budget_range')->orderBy('id')->get();
        $role_types = DB::table('role')->get();
        return view('web.project',compact('construction_types','role_types','expected_timeline','budgets'));
    }

    public function getSubCategories(Request $request)
    {
        $project_type_id = $request->project_type_id;
        $category_id = $request->construction_type_id;

        $results = DB::table('project_cat_type')
            ->join('construction_sub_categories', 'project_cat_type.const_sub_cat_id', '=', 'construction_sub_categories.id')
            ->where('project_cat_type.project_types_id', $project_type_id)
            ->where('project_cat_type.categories_id', $category_id)
            ->select('construction_sub_categories.id as const_sub_cat_id', 'construction_sub_categories.name as sub_category_name')
            ->get();

        return response()->json($results);
    }

    public function getProjectTypes(Request $request)
    {
        $category_id = $request->construction_type_id;

        $types = DB::table('project_cat_type')
            ->join('project_types', 'project_cat_type.project_types_id', '=', 'project_types.id')
            ->where('project_cat_type.categories_id', $category_id)
            ->select('project_types.id', 'project_types.name')
            ->distinct()
            ->get();

        return response()->json($types);
    }

    public function storeproject(Request $request)
    {
        // Validate form
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
            'role_id' => 'required|integer',
            'construction_type_id' => 'required|integer',
            'project_type_id' => 'required|integer',
            'expected_start' => 'nullable|date',
            'land_area' => 'nullable|numeric',
        ]);

        // Handle optional file upload
        $filePath = null;
        if ($request->hasFile('boq_file')) {
            $filePath = $request->file('boq_file')->store('boq_files', 'public');
        }
        $subCategories = is_array($request->sub_categories) ? implode(',', $request->sub_categories) : null;

        // Create the project
        $project = Project::create([
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'construction_type_id' => $request->construction_type_id,
            'project_type_id' => $request->project_type_id,
            'site_ready' => $request->has('site_ready'),
            'sub_categories' =>$subCategories,
            'land_location' => $request->land_location,
            'survey_number' => $request->survey_number,
            'land_type' => $request->land_type,
            'land_area' => $request->land_area,
            'land_unit' => $request->land_unit,
            'arch_drawings' => $request->has('arch_drawings'),
            'struct_drawings' => $request->has('struct_drawings'),
            'has_boq' => $request->has('has_boq'),
            'boq_file' => $filePath,
            'expected_start' => $request->expected_start,
            'project_duration' => $request->project_duration,
            'budget_range' => $request->budget_range,
        ]);

         session(['current_project_id' => $project->id]);

        // return redirect()->back()->with('success', 'Project saved successfully!');
        return response()->json([
            'success' => true,
            'redirect' => route('project_details') // we will define this route
            ]);
    }

    public function project_details(){
        $projectId = session('current_project_id');
        if (!$projectId) {
            return redirect('/')->with('error', 'No project found in session.');
        }

        $project = Project::findOrFail($projectId);

        return view('web.project_details', compact('project'));
    }

  
    public function project_details_save(Request $request)
    {
        $projectId = session('current_project_id');
        $request->validate([
            'project_name' => 'required|string',
            'project_location' => 'required|string',
            'budget_range' => 'nullable|string',
            'expected_timeline' => 'nullable|string',
            'project_description' => 'nullable|string',
            'file_path.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        $filePaths = [];

        // Handle file upload first
        if ($request->hasFile('file_path')) {
            foreach ($request->file('file_path') as $file) {
                $path = $file->store('file_path', 'public'); // store in storage/app/public/project_files
                $filePaths[] = $path;
            }
        }

        // $submission_id = 'PI'.'/'.$projectId;
        $submission_id = 'PI/' . date('Y') . '/' . str_pad($projectId, 6, '0', STR_PAD_LEFT);

        // Insert project into DB
        $projectId = DB::table('projects_details')->insertGetId([
            'project_id' => $projectId,
             'submission_id' =>$submission_id ,
            'project_name' => $request->project_name,
            'project_location' => $request->project_location,
            'budget_range' => $request->budget_range,
            'expected_timeline' => $request->expected_timeline,
            'project_description' => $request->project_description,
            'file_path' => !empty($filePaths) ? json_encode($filePaths) : null, // store as JSON
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'project_id' => $projectId]);
    }

    public function customer_dashboard(){
        return view('web.customer_dashboard');
    }
}