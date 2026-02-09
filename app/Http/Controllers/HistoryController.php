<?php

namespace App\Http\Controllers;

use App\Models\Hand;
use Illuminate\Http\Request;
use Throwable;

class HistoryController extends Controller
{
    /**
     * @throws Throwable
     */
    public function index(Request $request)
    {
        $sort_direction = $request->session()->has('history_sort')
            ? $request->session()->get('history_sort')
            : 'desc';

        return view('history.index', [
            'hands' => Hand::getHistory($sort_direction),
            'sort' => $sort_direction,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function sort(Request $request, $sort_direction)
    {
        if (!in_array($sort_direction, ['asc', 'desc'])) {
            return response(status: 406);
        }

        $request->session()->put('history_sort', $sort_direction);

        return response()->json([
            'view' => view('history.list', [
                    'hands' => Hand::getHistory($sort_direction),
                    'sort' => $sort_direction,
                ])
                ->render()
        ]);
    }

    public function add()
    {

    }
}
