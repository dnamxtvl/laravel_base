<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Lucid\Bus\Marshal;
use Lucid\Events\FeatureStarted;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, Marshal, DispatchesJobs;

    public function serve($feature, $arguments = [])
    {
        event(new FeatureStarted($feature, $arguments));

        return $this->dispatchSync($this->marshal($feature, new Collection(), $arguments));
    }
}
