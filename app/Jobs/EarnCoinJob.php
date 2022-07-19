<?php

namespace App\Jobs;

use App\Models\EFCourse;
use App\Models\EFScore;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use GuzzleHttp\Client;

class EarnCoinJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 600; // 10 minutes

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;
    /**
     * Create a new job instance.
     *
     * @return void
     */


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user_id = $this->data['user_id'];
        if (!$user = User::query()->find($user_id))
            abort(404, "Không tìm thấy user.");

        $course_id = $this->data['course_id'];
        if (!$ef_course = EFCourse::query()->find($course_id))
            abort(404, "Không tìm thấy khóa học.");

        $score = $this->data['score'];

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
    }
}
