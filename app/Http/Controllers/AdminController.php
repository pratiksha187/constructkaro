<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessRegistration;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function admin_dashboard(){
        return view('admin.admin_dashboard');
    }

    public function vender_approve_data(){
        $vendors = BusinessRegistration::where('approved', 1)->get(); 
        return view('admin.vender_approve_data', compact('vendors'));
    }

    public function vender_reject_data(){
        $vendors = BusinessRegistration::where('approved', 2)->get(); 
        return view('admin.vender_reject_data', compact('vendors'));
    }

    public function vender_approve_form()
    {
        $vendors = BusinessRegistration::where('approved', 0)->get(); 
        return view('admin.vender_approve_form', compact('vendors'));
    }

    public function construction_type() {
        $categories = DB::table('categories')->orderBy('id', 'asc')->get();
        return view('admin.construction_type', compact('categories'));
    }

    public function addrole(){
        $role = DB::table('role')->orderBy('id', 'desc')->paginate(5);;
        return view('masters.role',compact('role'));

    }

    public function rolestore(Request $request){
        $request->validate([
            'role' => 'required|string|max:255'
        ]);

        $role = $request->input('role');
        $roleId = DB::table('role')->insertGetId([
            'role' => $role,
            'created_at' => now()
            
        ]);
        $newrole = DB::table('role')->find($roleId);

        return response()->json([
            'success' => true,
            'message' => 'Category added successfully!',
            'role' => [
                'id' => $newrole->id,
                'role' => $newrole->role,
            ]
        ]);
    }

    public function categorystore(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255'
        ]);

        $categoryName = $request->input('category');
        $categoryId = DB::table('categories')->insertGetId([
            'name' => $categoryName,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $newCategory = DB::table('categories')->find($categoryId);

        return response()->json([
            'success' => true,
            'message' => 'Category added successfully!',
            'category' => [
                'id' => $newCategory->id,
                'name' => $newCategory->name,
            ]
        ]);
    }

    public function deletecategory($id)
    {
        DB::table('categories')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.'
        ]);
    }

    public function deleterole($id)
    {
        DB::table('role')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully.'
        ]);
    }

   
    public function project_type() {
       
        $projecttypes = DB::table('project_types')
       
            ->select('project_types.*')
            ->orderBy('project_types.id', 'asc')
            ->get();
        return view('admin.project_type', compact( 'projecttypes'));
    }

    public function storeProjectType(Request $request)
    {
        $request->validate([
            'projecttype' => 'required|string|max:255'
        ]);

       $id = DB::table('project_types')->insertGetId([
            'name' => $request->projecttype,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Project type added successfully.',
            'id' => $id
        ]);

    }

    public function deleteProjectType($id)
    {
        DB::table('project_types')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project type deleted successfully.'
        ]);
    }

    public function const_sub_cat() {
        $subcategories = DB::table('construction_sub_categories')
            ->select('construction_sub_categories.*')
            ->orderBy('construction_sub_categories.id', 'asc')
            ->paginate(10); // Enable pagination (10 items per page)

        return view('admin.const_sub_cat', compact('subcategories'));
    }

    public function storeSubCategory(Request $request)
    {
        $request->validate([
            'project_type' => 'required|exists:project_types,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
        ]);

        $id = DB::table('construction_sub_categories')->insertGetId([
            'project_type_id' => $request->project_type,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $projectType = DB::table('project_types')->find($request->project_type);
        $category = DB::table('categories')->find($request->category_id);

        return response()->json([
            'success' => true,
            'message' => 'Sub Category added successfully.',
            'id' => $id,
            'category' => $category->name,
            'project_type' => $projectType->name,
            'name' => $request->name
        ]);
    }

    public function deleteSubCategory($id)
    {
        DB::table('construction_sub_categories')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subcategory deleted successfully.'
        ]);
    }

    public function storeProjectCatType(Request $request)
    {
        $request->validate([
            'categories_id' => 'required',
            'project_types_id' => 'required',
            'const_sub_cat_id' => 'required',
        ]);

        DB::table('project_cat_type')->insert([
            'categories_id' => $request->categories_id,
            'project_types_id' => $request->project_types_id,
            'const_sub_cat_id' => $request->const_sub_cat_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Project Category Type saved successfully!',
        ]);
    }

    public function proj_const_sub_cat()
    {
        $categories = DB::table('categories')->orderBy('name')->get(); 
        $project_types = DB::table('project_types')->orderBy('name')->get(); 
        $construction_sub_categories = DB::table('construction_sub_categories')->orderBy('name')->get(); 

        $entries = DB::table('project_cat_type')
            ->join('categories', 'project_cat_type.categories_id', '=', 'categories.id')
            ->join('project_types', 'project_cat_type.project_types_id', '=', 'project_types.id')
            ->join('construction_sub_categories', 'project_cat_type.const_sub_cat_id', '=', 'construction_sub_categories.id')
            ->select(
                'project_cat_type.id',
                'categories.name as category',
                'project_types.name as project_type',
                'construction_sub_categories.name as sub_category'
            )
            ->paginate(10);
            // ->get();
        return view('admin.proj_const_sub_cat', compact(
            'categories',
            'project_types',
            'construction_sub_categories',
            'entries'
        ));
    }

}
