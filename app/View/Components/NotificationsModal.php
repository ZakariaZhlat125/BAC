<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NotificationsModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // جلب إشعارات المستخدم الحالي
        $notifications = auth()->user()?->notifications()->latest()->get() ?? collect();

        return view('components.notifications-modal', compact('notifications'));
    }
}
