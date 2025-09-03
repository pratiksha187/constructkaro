<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\project;

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
        // Validate form (added rules for arch_drawings + arch_files)
        $validated = $request->validate([
            'full_name'            => 'required|string|max:255',
            'phone_number'         => ['required','string','max:20'],
            'email'                => 'required|email|max:255',
            'password'             => 'required|string|min:6|confirmed', // expects password_confirmation
            'role_id'              => 'required|integer',
            'construction_type_id' => 'required|integer',
            'project_type_id'      => 'required|integer',
            'expected_start'       => 'nullable|date',
            'land_area'            => 'nullable|numeric',

            // NEW: drawings toggle + multi-pdf uploads
            'arch_drawings'        => 'nullable',
            'arch_files'           => 'required_if:arch_drawings,1|array',
            'arch_files.*'         => 'file|mimetypes:application/pdf|max:10240', // 10 MB per file

            'struct_drawings'  => 'nullable',
            'struct_files'     => 'required_if:struct_drawings,1|array',
            'struct_files.*'   => 'file|mimetypes:application/pdf|max:10240', // 10MB per file


            // Optional (if you send as array from UI)
            'sub_categories'       => 'nullable|array',
            'sub_categories.*'     => 'nullable|string'
        ]);

        // Handle optional BOQ upload (existing)
        $boqPath = null;
        if ($request->hasFile('boq_file')) {
            $boqPath = $request->file('boq_file')->store('boq_files', 'public');
        }

        // Handle multiple Architectural Drawing PDFs (NEW)
        $archPaths = [];
        if ($request->boolean('arch_drawings') && $request->hasFile('arch_files')) {
            foreach ($request->file('arch_files') as $file) {
                // stored at storage/app/public/arch_drawings/...
                $archPaths[] = $file->store('arch_drawings', 'public');
            }
        }
        // Handle multiple Structural Drawing PDFs
        $structPaths = [];
        if ($request->boolean('struct_drawings') && $request->hasFile('struct_files')) {
            foreach ($request->file('struct_files') as $file) {
                $structPaths[] = $file->store('struct_drawings', 'public'); // storage/app/public/struct_drawings
            }
        }

        // Sub-categories (array -> CSV if you want to keep old field)
        $subCategoriesCsv = is_array($request->sub_categories)
            ? implode(',', $request->sub_categories)
            : null;

        // Create the project
        $project = Project::create([
            'full_name'            => $request->full_name,
            'phone_number'         => $request->phone_number,
            'email'                => $request->email,
            'password'             => Hash::make($request->password),
            'role_id'              => $request->role_id,
            'construction_type_id' => $request->construction_type_id,
            'project_type_id'      => $request->project_type_id,

            'site_ready'           => $request->has('site_ready'),
            'sub_categories'       => $subCategoriesCsv,      // if your column is a string
            'land_location'        => $request->land_location,
            'survey_number'        => $request->survey_number,
            'land_type'            => $request->land_type,
            'land_area'            => $request->land_area,
            'land_unit'            => $request->land_unit,

            'arch_drawings'        => $request->has('arch_drawings'),
            'struct_drawings'      => $request->has('struct_drawings'),
            'has_boq'              => $request->has('has_boq'),
            'boq_file'             => $boqPath,
            'expected_start'       => $request->expected_start,
            'project_duration'     => $request->project_duration,
            'budget_range'         => $request->budget_range,

            // Save the drawings file paths (JSON recommended)
            'arch_files'           => !empty($archPaths) ? json_encode($archPaths) : null,
        ]);

        session(['current_project_id' => $project->id]);

        return response()->json([
            'success'  => true,
            'redirect' => route('project_details'),
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
           
            'project_description' => $request->project_description,
            'file_path' => !empty($filePaths) ? json_encode($filePaths) : null, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'project_id' => $projectId]);
    }

    public function customer_dashboard(){
        $session = session('current_project_id');
        return view('web.customer_dashboard',compact('session'));
    }
}