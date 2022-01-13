<?php

namespace App\View\Components;

use Illuminate\View\Component;



class Test extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $people;
    public $players;

    public function __construct($people, $players)
    {
        $this->people = $people;
        $this->players = $players;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.test');
    }
}
