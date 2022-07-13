<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EFCourse;
use Illuminate\Pagination\Paginator;

class CoursesController extends Controller
{
    public function index(Request $request){
       
        $page = (int)$request->get("page");
        $courses = EFCourse::where("is_deleted", !EFCourse::IS_DELETED)->paginate(PAGING_DISPLAY);
        if($page > $courses->lastPage()){
            return redirect('/admin/courses?page=' . $courses->lastPage());
        }
        return view('admin.courses.index', compact('courses'));
    }
}