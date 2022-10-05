<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Conducting\Kka\KkaSampleDetail;
use App\Models\Master\Ict\IctObject;
use App\Models\Preparation\Assignment\Assignment;
use App\Models\Rkia\Summary;
use App\Models\Master\Org\Struct;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $module =  'dashboard';
    protected $routes =  'dashboard';
    protected $views =  'dashboard';

    public function __construct()
    {
        $this->prepare([
            'module' => $this->module,
            'routes' => $this->routes,
            'views' => $this->views,
            'title' => 'Dashboard',
        ]);
    }

    public function index()
    {
        $user = auth()->user();
        if ($user->status != 'active') {
            return $this->render($this->views.'.nonactive');
        }
        if (!$user->checkPerms('dashboard.view') || !$user->roles()->exists()) {
            return abort(403);
        }
        return $this->render($this->views.'.index');
    }

    public function setLang($lang)
    {
        if (\Cache::has('userLocale')) {
            \Cache::forget('userLocale');
        }
        \Cache::forever('userLocale', $lang);
        return redirect()->back();
    }

    public function progress(Request $request)
    {
        // Progress 1
        $total = rand(5,10);
        $compl = rand(0,5);
        $percent = ($compl > 0 && $total > 0) ? round(($compl/$total*100), 0) : 0;
        $cards[] = [
            'name' => 'progress1',
            'total' => $total,
            'completed' => $compl,
            'percent' => $percent,
        ];
        // Progress 2
        $total = rand(5,10);
        $compl = rand(0,5);
        $percent = ($compl > 0 && $total > 0) ? round(($compl/$total*100), 0) : 0;
        $cards[] = [
            'name' => 'progress2',
            'total' => $total,
            'completed' => $compl,
            'percent' => $percent,
        ];
        // Progress 3
        $total = rand(5,10);
        $compl = rand(0,5);
        $percent = ($compl > 0 && $total > 0) ? round(($compl/$total*100), 0) : 0;
        $cards[] = [
            'name' => 'progress3',
            'total' => $total,
            'completed' => $compl,
            'percent' => $percent,
        ];
        // Progress 4
        $total = rand(5,10);
        $compl = rand(0,5);
        $percent = ($compl > 0 && $total > 0) ? round(($compl/$total*100), 0) : 0;
        $cards[] = [
            'name' => 'progress4',
            'total' => $total,
            'completed' => $compl,
            'percent' => $percent,
        ];

        return response()->json([
            'data' => $cards
        ]);
    }

    public function chartUser(Request $request)
    {
        $request->merge(['year_start' => $request->user_start ?? date('Y') - 10]);
        $request->merge(['year_end' => $request->user_end ?? date('Y')]);

        $years = range($request->year_start, $request->year_end);
        $struct = Struct::find($request->user_struct);
        $title = 'User '.($struct->name ?? '').' '.$request->year_start.'/'.$request->year_end;
        $data = [];
        $statuses = ['active','nonactive'];
        foreach ($statuses as $status) {
            foreach ($years as $i => $year) {
                $count = User::where('status', $status)
                            ->whereYear('created_at', $year)
                            ->when($struct, function ($q) use ($struct) {
                                $q->whereHasLocationId($struct->id);
                            })
                            ->count();

                $data[$status][$i] = $count;
                if (empty($data['total'][$i])) {
                    $data['total'][$i] = 0;
                }
                $data['total'][$i] = $data['total'][$i] + $count;
            }
        }

        return [
            'title' => ['text' => $title],
            'series' => [
                [
                    'name' => 'Total',
                    'type' => 'area',
                    'data' => $data['total']
                ],[
                    'name' => 'Aktif',
                    'type' => 'column',
                    'data' => $data['active']
                ],[
                    'name' => 'Nonaktif',
                    'type' => 'column',
                    'data' => $data['nonactive']
                ],
            ],
            'xaxis' => ['categories' => $years]
        ];
    }
}
