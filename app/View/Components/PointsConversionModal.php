<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PointsConversionModal extends Component
{
    public $points;
    public $supervisorName;

    public function __construct($points, $supervisorName = 'مشرفك الحالي')
    {
        $this->points = $points;
        $this->supervisorName = $supervisorName;
    }

    public function render()
    {
        return view('components.points-conversion-modal');
    }
}
