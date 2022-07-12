<?php

namespace App\Services;

use App\Models\EFCourse;
use App\Models\User;

class EFoxUserService extends BaseService
{
    public function store($request)
    {
        if (User::find($request->u_id)) abort(422, "ID user đã tồn tại.");
        $input = [
            "id" => $request->u_id,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            // "address" => $request->address,
            // "phone" => $request->phone,
            // "address_vallet" => $request->address_vallet,
        ];
        $user = User::create($input);
        $user->roles()->attach([1]);
        return $input;
    }
    public function update($id, $request)
    {
        $id = (int) $id;
        $user = User::find($id);
        if ($user) {
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            // $user->address = $request->address;
            // $user->phone = $request->phone;
            // $user->address_vallet = $request->address_vallet;
            // $user->u_id = $request->u_id;
            $user->save();
        } else {
            abort(404, "Không tìm thấy user.");
        }
        return $request->all();
    }
    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->is_active = 0;
            $user->save();
            $user->roles()->detach([1]);
        } else {
            abort(404, "Không tìm thấy user.");
        }

        return $id;
    }

    // Courses
    public function storeCourse($request)
    {
        if (EFCourse::find($request->u_id)) abort(422, "ID khóa học đã tồn tại.");
        $input = [
            "id" => $request->u_id,
            "name" => $request->name,
            "total_time_learning" => $request->total_time_learning,
            "total_question" => $request->total_question
        ];
        EFCourse::create($input);

        return $input;
    }
    public function updateCourse($id, $request)
    {
        $id = (int) $id;
        $course = EFCourse::find($id);
        if ($course) {
            $course->name = $request->name;
            $course->total_time_learning = $request->total_time_learning;
            $course->total_question = $request->total_question;
            $course->save();
        } else {
            abort(404, "Không tìm thấy khóa học.");
        }
        return $request->all();
    }
    public function deleteCourse($id)
    {
        $course = EFCourse::find($id);
        if ($course) {
            $course->is_deleted = EFCourse::IS_DELETED;
            $course->save();
        } else {
            abort(404, "Không tìm thấy khóa học.");
        }

        return $id;
    }
}
