<?php

namespace App\View\Components\Admin;

use App\Services\Admin\SidebarService;
use Illuminate\View\Component;

class Sidebar extends Component
{
    private SidebarService $service;

    function __construct(SidebarService $service)
    {
        $this->service = $service;
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $structure = $this->service->getStructure();

        return view('admin.elements.sidebar', compact('structure'));
    }
}
