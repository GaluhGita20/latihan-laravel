<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\ItemPemeliharaanRequest;
use App\Models\Master\ItemPemeliharaan;
use Illuminate\Http\Request;

class ItemPemeliharaanController extends Controller
{
    protected $module   = 'master.item-pemeliharaan';
    protected $routes   = 'master.item-pemeliharaan';
    protected $views    = 'master.item-pemeliharaan';
    protected $perms    = 'master';

    public function __construct()
    {
        $this->prepare(
            [
                'module' => $this->module,
                'routes' => $this->routes,
                'views' => $this->views,
                'perms' => $this->perms,
                'permission' => $this->perms . '.view',
                'title' => 'Item Pemeliharaan',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Item Pemeliharaan' => route($this->routes . '.index'),
                ]
            ]
        );
    }

    public function index()
    {
        $this->prepare(
            [
                'tableStruct' => [
                    'datatable_1' => [
                        $this->makeColumn('name:num'),
                        $this->makeColumn('name:name|label:Item Pemeliharaan|className:text-left'),
                        $this->makeColumn('name:tipe_pemeliharaan|label:Tipe Pemeliharaan|className:text-center'),
                        $this->makeColumn('name:description|label:Deskripsi|className:text-center'),
                        $this->makeColumn('name:updated_by'),
                        $this->makeColumn('name:action'),
                    ],
                ],
            ]
        );
        return $this->render($this->views . '.index');
    }

    public function grid()
    {
        $user = auth()->user();
        $records = ItemPemeliharaan::grid()->filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($record) {
                    return request()->start;
                }
            )
            ->addColumn(
                'tipe_pemeliharaan',
                function ($record) {
                    if(!empty($record->tipe_pemeliharaan_id)){
                        return '<span>'. $record->tipePemeliharaan->name .'</span>';
                    }
                    return '';
                }
            )
            ->addColumn(
                'description',
                function ($record) {
                    $totalWords = str_word_count($record->description);
                    return '<span>'. $totalWords .' Words</span>';
                }
            )
            ->addColumn(
                'updated_by',
                function ($record) {
                    return $record->createdByRaw();
                }
            )
            ->addColumn(
                'action',
                function ($record) use ($user) {
                    $actions = [
                        'type:show|id:' . $record->id,
                        'type:edit|id:' . $record->id,
                    ];
                    if ($record->canDeleted()) {
                        $actions[] = [
                            'type' => 'delete',
                            'id' => $record->id,
                            'attrs' => 'data-confirm-text="' . __('Hapus') . ' ' . $record->name . '?"',
                        ];
                    }
                    return $this->makeButtonDropdown($actions);
                }
            )
            ->rawColumns(['action', 'updated_by', 'description', 'tipe_pemeliharaan'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(ItemPemeliharaanRequest $request)
    {
        $record = new ItemPemeliharaan;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(ItemPemeliharaan $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(ItemPemeliharaan $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(ItemPemeliharaanRequest $request, ItemPemeliharaan $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(ItemPemeliharaan $record)
    {
        return $record->handleDestroy();
    }

    public function import()
    {
        if (request()->get('download') == 'template') {
            return $this->template();
        }
        return $this->render($this->views . '.import');
    }

    public function template()
    {
        $fileName = date('Y-m-d') . ' Template Import Data ' . $this->prepared('title') . '.xlsx';
        $view = $this->views . '.template';
        $data = [];
        return \Excel::download(new GenerateExport($view, $data), $fileName);
    }

    public function importSave(Request $request)
    {
        $request->validate(
            [
                'uploads.uploaded' => 'required',
                'uploads.temp_files_ids.*' => 'required',
            ],
            [],
            [
                'uploads.uploaded' => 'File',
                'uploads.temp_files_ids.*' => 'File',
            ]
        );

        $record = new Example;
        return $record->handleImport($request);
    }
}

