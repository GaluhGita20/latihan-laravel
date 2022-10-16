@extends('layouts.form')
@inject('permission', '\App\Models\Auth\Permission')

@section('action', route($routes . '.grant', $record->id))

@section('card-title')
    Assign Permission :
    <span class="ml-3 label label-lg label-inline label-danger text-nowrap text-bold">{{ $record->name }}</span>
@endsection

@section('card-body')
    @method('PATCH')
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="text-center">Menu</th>
                    <th class="text-center ">View</th>
                    <th class="text-center ">Add</th>
                    <th class="text-center ">Edit</th>
                    <th class="text-center ">Delete</th>
                    <th class="text-center ">Approve</th>
                    <th class="text-center "></th>
                </tr>
            </thead>
            <tbody>
                @foreach (config('backendmenu') as $menu)
                    @if (empty($menu['section']))
                        @if (in_array($record->id, [0]) && in_array($menu['name'], ['setting', 'master']))
                            @continue
                        @endif
                        @php
                            $menu['perms'] = $menu['perms'] ?? '';
                            $perms = $permission
                                ->when(!empty($menu['perms']), function ($q) use ($menu) {
                                    $q->where('name', 'like', $menu['perms'] . '%');
                                })
                                ->when(empty($menu['perms']), function ($q) use ($menu) {
                                    $q->whereNull('id');
                                })
                                ->get();
                        @endphp
                        <thead>
                            <tr>
                                <th>
                                    <h6 class="font-weight-bold">{!! $menu['title'] !!}</h6>
                                </th>
                                <th class="text-center ">
                                    @if (!empty($menu['submenu']) && !in_array($menu['name'], ['setting', 'master']))
                                        <button type="button" class="btn btn-light-primary font-weight-bold mr-2 check all"
                                            data-check="view">
                                            <i class="far fa-check-circle fa-fw mr-1"></i>View All
                                        </button>
                                    @elseif($p = $perms->where('name', $menu['perms'] . '.view')->first())
                                        <div class="d-inline-block">
                                            <label
                                                class="checkbox checkbox-lg checkbox-light-primary checkbox-single flex-shrink-0">
                                                <input type="checkbox" class="view check" name="check[]"
                                                    value="{{ $p->id }}"
                                                    @if ($record->hasPermissionTo($menu['perms'] . '.view')) checked @endif><span></span>
                                            </label>
                                        </div>
                                    @endif
                                </th>
                                <th class="text-center ">
                                    @if (!empty($menu['submenu']) && !in_array($menu['name'], ['setting', 'master']))
                                        <button type="button" class="btn btn-light-primary font-weight-bold mr-2 check all"
                                            data-check="create">
                                            <i class="far fa-check-circle fa-fw mr-1"></i>Create All
                                        </button>
                                    @elseif($p = $perms->where('name', $menu['perms'] . '.create')->first())
                                        @if (!in_array($record->id, [0]))
                                            <div class="d-inline-block">
                                                <label
                                                    class="checkbox checkbox-lg checkbox-light-primary checkbox-single flex-shrink-0">
                                                    <input type="checkbox" class="create check" name="check[]"
                                                        value="{{ $p->id }}"
                                                        @if ($record->hasPermissionTo($menu['perms'] . '.create')) checked @endif><span></span>
                                                </label>
                                            </div>
                                        @endif
                                    @endif
                                </th>
                                <th class="text-center ">
                                    @if (!empty($menu['submenu']) && !in_array($menu['name'], ['setting', 'master']))
                                        <button type="button" class="btn btn-light-primary font-weight-bold mr-2 check all"
                                            data-check="edit">
                                            <i class="far fa-check-circle fa-fw mr-1"></i>Edit All
                                        </button>
                                    @elseif($p = $perms->where('name', $menu['perms'] . '.edit')->first())
                                        @if (!in_array($record->id, [0]))
                                            <div class="d-inline-block">
                                                <label
                                                    class="checkbox checkbox-lg checkbox-light-primary checkbox-single flex-shrink-0">
                                                    <input type="checkbox" class="edit check" name="check[]"
                                                        value="{{ $p->id }}"
                                                        @if ($record->hasPermissionTo($menu['perms'] . '.edit')) checked @endif><span></span>
                                                </label>
                                            </div>
                                        @endif
                                    @endif
                                </th>
                                <th class="text-center ">
                                    @if (!empty($menu['submenu']) && !in_array($menu['name'], ['setting', 'master']))
                                        <button type="button" class="btn btn-light-primary font-weight-bold mr-2 check all"
                                            data-check="delete">
                                            <i class="far fa-check-circle fa-fw mr-1"></i>Delete All
                                        </button>
                                    @elseif($p = $perms->where('name', $menu['perms'] . '.delete')->first())
                                        @if (!in_array($record->id, [0]))
                                            <div class="d-inline-block">
                                                <label
                                                    class="checkbox checkbox-lg checkbox-light-primary checkbox-single flex-shrink-0">
                                                    <input type="checkbox" class="delete check" name="check[]"
                                                        value="{{ $p->id }}"
                                                        @if ($record->hasPermissionTo($menu['perms'] . '.delete')) checked @endif><span></span>
                                                </label>
                                            </div>
                                        @endif
                                    @endif
                                </th>
                                <th class="text-center ">
                                    @if (!empty($menu['submenu']) && !in_array($menu['name'], ['setting', 'master']))
                                        <button type="button" class="btn btn-light-primary font-weight-bold mr-2 check all"
                                            data-check="approve">
                                            <i class="far fa-check-circle fa-fw mr-1"></i>Approve All
                                        </button>
                                    @elseif($p = $perms->where('name', $menu['perms'] . '.approve')->first())
                                        @if (!in_array($record->id, [0]))
                                            <div class="d-inline-block">
                                                <label
                                                    class="checkbox checkbox-lg checkbox-light-primary checkbox-single flex-shrink-0">
                                                    <input type="checkbox" class="approve check" name="check[]"
                                                        value="{{ $p->id }}"
                                                        @if ($record->hasPermissionTo($menu['perms'] . '.approve')) checked @endif><span></span>
                                                </label>
                                            </div>
                                        @endif
                                    @endif
                                </th>
                                <th class="text-right ">
                                    @if (empty($menu['submenu']) || in_array($menu['name'], ['setting', 'master']))
                                        <button type="button" class="btn btn-light-primary font-weight-bold select all"><i
                                                class="far fa-check-circle fa-fw mr-1"></i>Check All</button>
                                    @endif
                                </th>
                            </tr>
                        </thead>
                        @if (!empty($menu['submenu']) && !in_array($menu['name'], ['setting', 'master']))
            <tbody>
                @foreach ($menu['submenu'] as $child)
                    @if (empty($child['submenu']))
                        @php
                            $child['perms'] = $child['perms'] ?? '';
                            $perms = $permission
                                ->when(!empty($child['perms']), function ($q) use ($child) {
                                    $q->where('name', 'like', $child['perms'] . '%');
                                })
                                ->when(empty($child['perms']), function ($q) use ($child) {
                                    $q->whereNull('id');
                                })
                                ->get();
                        @endphp
                        <tr>
                            <td class="align-middle"><span class="ml-2 font-weight-normal">{!! $child['title'] !!}</span>
                            </td>
                            <td class="text-center ">
                                @if ($p = $perms->where('name', $child['perms'] . '.view')->first())
                                    <div class="d-inline-block">
                                        <label class="checkbox checkbox-lg checkbox-light-primary checkbox-sing">
                                            <input type="checkbox" class="view check" name="check[]"
                                                value="{{ $p->id }}"
                                                @if ($record->hasPermissionTo($child['perms'] . '.view')) checked @endif><span></span>
                                        </label>
                                    </div>
                                @endif
                            </td>
                            <td class="text-center ">
                                @if (!in_array($record->id, [0]))
                                    @if ($p = $perms->where('name', $child['perms'] . '.create')->first())
                                        <div class="d-inline-block">
                                            <label class="checkbox checkbox-lg checkbox-light-primary checkbox-sing">
                                                <input type="checkbox" class="create check" name="check[]"
                                                    value="{{ $p->id }}"
                                                    @if ($record->hasPermissionTo($child['perms'] . '.create')) checked @endif><span></span>
                                            </label>
                                        </div>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center ">
                                @if (!in_array($record->id, [0]))
                                    @if ($p = $perms->where('name', $child['perms'] . '.edit')->first())
                                        <div class="d-inline-block">
                                            <label class="checkbox checkbox-lg checkbox-light-primary checkbox-sing">
                                                <input type="checkbox" class="edit check" name="check[]"
                                                    value="{{ $p->id }}"
                                                    @if ($record->hasPermissionTo($child['perms'] . '.edit')) checked @endif><span></span>
                                            </label>
                                        </div>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center ">
                                @if (!in_array($record->id, [0]))
                                    @if ($p = $perms->where('name', $child['perms'] . '.delete')->first())
                                        <div class="d-inline-block">
                                            <label class="checkbox checkbox-lg checkbox-light-primary checkbox-sing">
                                                <input type="checkbox" class="delete check" name="check[]"
                                                    value="{{ $p->id }}"
                                                    @if ($record->hasPermissionTo($child['perms'] . '.delete')) checked @endif><span></span>
                                            </label>
                                        </div>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center ">
                                @if (!in_array($record->id, [0]))
                                    @if ($p = $perms->where('name', $child['perms'] . '.approve')->first())
                                        <div class="d-inline-block">
                                            <label class="checkbox checkbox-lg checkbox-light-primary checkbox-sing">
                                                <input type="checkbox" class="approve check" name="check[]"
                                                    value="{{ $p->id }}"
                                                    @if ($record->hasPermissionTo($child['perms'] . '.approve')) checked @endif><span></span>
                                            </label>
                                        </div>
                                    @endif
                                @endif
                            </td>
                            <td class="text-right ">
                                <button type="button" class="btn btn-light-primary font-weight-bold select all"><i
                                        class="far fa-check-circle fa-fw mr-1"></i>Check All</button>
                            </td>
                        </tr>
                    @else
                    @endif
                @endforeach
            </tbody>
            @endif
            @endif
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        $('.content-page').on('click', '.select.all', function(e) {
            var container = $(this).closest('tr');
            var check = true;
            if (container.find('.check:checked').length == container.find('.check').length) {
                check = false;
            }
            container.find('.check').prop('checked', check);
        });

        $('.content-page').on('click', '.check.all', function(e) {
            var container = $(this).closest('thead').next('tbody');
            var target = $(this).data('check');
            var check = true;
            if (container.find('.' + target + '.check:checked').length == container.find('.' + target + '.check')
                .length) {
                check = false;
            }
            container.find('.' + target + '.check').prop('checked', check);
            // Check view
            if (target == 'view' && check == false) {
                container.find('.check').prop('checked', false);
            }
            if (target != 'view' && check == true) {
                container.find('.view.check').prop('checked', true);
            }
        });

        $('.content-page').on('change', 'input.check', function(e) {
            var me = $(this);
            var container = me.closest('tr');

            if (me.is(':checked')) container.find('.view').prop('checked', true);
            if (!me.is(':checked') && me.hasClass('view')) {
                container.find('.check').prop('checked', false);
            };
        });
    </script>
@endpush
