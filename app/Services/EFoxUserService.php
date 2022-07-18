<?php

namespace App\Services;

use App\Models\EFCourse;
use App\Models\EFScore;
use App\Models\User;
use GuzzleHttp\Client;

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
    public function getListCourse($request)
    {
        // $page = (int)$request->get("page");
        // if()
        $data = EFCourse::paginate(config('constants.paging_display'));
        return $data;
    }

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
    public function scoreCourse($request)
    {
        $user_id = $request->input('user_id');
        if (!$user = User::query()->find($user_id))
            abort(404, "Không tìm thấy user.");

        $course_id = $request->input('course_id');
        if (!$ef_course = EFCourse::query()->find($course_id))
            abort(404, "Không tìm thấy khóa học.");

        $score = $request->input('score');

        $input = [
            'ef_course_id' => $course_id,
            'user_id' => $user_id,
            'score' => $score
        ];

        // $ef_course->user()->attach($user_id, ['score'=> $score ]);
        $ef_score = EFScore::query()->updateOrCreate(
            [
                'ef_course_id' => $course_id,
                'user_id' => $user_id,
            ],
            $input
        );

        // Call dApp
        if ($user->address_vallet && $user->pen_id && $ef_score->earn_status == EFScore::PENDING_EARN) {
            // Call check using which pen
            $pens = new Client();
            $uri_get_pens = config('lr.api_url') . "/token/" . $user->address_vallet . "?page=1";
            $res_pens = $pens->request('GET', $uri_get_pens, [
                'headers' => [
                    'Accept'     => 'application/json',
                    'Authorization'      => config('lr.token')
                ]
            ]);
            $stt_pens = $res_pens->getStatusCode(); // 200
            $body_pens = json_decode($res_pens->getBody());
            $pen_list = $body_pens->data->docs;
            $pen_used = false;
            foreach ($pen_list as $p) {
                if ($p->index == $user->pen_id) {
                    $pen_used = true;
                    break;
                }
            }

            // Call earn coin
            if ($stt_pens == 200 && $pen_used) {
                $earning = new Client();
                $res_earning = $earning->request('POST', config('lr.api_url') . '/earn/token/quiz', [
                    'headers' => [
                        'Accept'     => 'application/json',
                        'Authorization'      => config('lr.token')
                    ],
                    'json' => [
                        "received_address" => $user->address_vallet,
                        "point" => $score / 100,
                        "pen_index" => $user->pen_id,
                        "total_time_of_course" => ($ef_course->total_time_learning) * 60
                    ]
                ]);
                $stt_earning = $res_earning->getStatusCode(); // 200
                if ($stt_earning == 200) {
                    $ef_score->update(['earn_status' => EFScore::APPROVED_EARN]);
                }
            }
        }

        return true;
    }
}
