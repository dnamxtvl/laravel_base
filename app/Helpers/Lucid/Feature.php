<?php

namespace App\Traits\Lucid;

use Lucid\Testing\MockMe;

abstract class Feature
{
    use MockMe;
    use UnitDispatcher;
}
