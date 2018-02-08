<?php

namespace Modules\Backend\Jobs;

use Exception;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Modules\Backend\Models\Apply;

class SendData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels, Queueable;

    protected $params;

    /**
     * Create a new job instance.
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Apply::applyAdd($this->params);
    }

//    /**
//     * 处理失败任务。
//     *
//     * @param  Exception $exception
//     * @return void
//     */
    public function failed()
    {
        DB::beginTransaction();
        $data = Apply::applyAdd($this->params);
        if ($data) {
            DB::rollback();
            return true;
        }
    }
}
