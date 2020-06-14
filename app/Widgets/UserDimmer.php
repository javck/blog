<?php

namespace App\Widgets;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Widgets\BaseDimmer;

class UserDimmer extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count  = \App\User::count();
        $string = "共有{$count}個使用者";

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-boat',
            'title'  => "{$count}個用戶",
            'text'   => $string,
            'button' => [
                'text' => '開啟用戶列表',
                'link' => route('voyager.users.index'),
            ],
            'image'  => Voyager::image('team1.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        $cgy = \App\Cgy::first();
        return Auth::user()->can('browse',$cgy);
    }
}
