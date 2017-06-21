@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Menus"))

@section('content')

    <section class="content-header">
        <a class="btn btn-primary" href="/system/menus/create">
            {{ __("Create Menu") }}
        </a>
        <a class="btn btn-primary" href="/system/menus/reorder">
            {{ __("Reorder Menu") }}
        </a>
        @include('laravel-enso/menumanager::breadcrumbs')
    </section>
    <section class="content">
        <div class="row" v-cloak>
            <div class="col-md-12">
                <data-table source="/system/menus">
                    <span slot="data-table-title">{{ __("Menus") }}</span>
                    @include('laravel-enso/core::partials.modal')
                </data-table>
            </div>
        </div>
    </section>

@endsection

@push('scripts')

    <script>

        let vm = new Vue({
            el: '#app',

            methods: {
                customRender(column, data, type, row, meta) {
                    switch(column) {
                        case 'icon':
                                return '<i class="' + data + '"></i>';
                        default:
                            toastr.warning('render for column ' + column + ' is not defined.' );
                            return data;
                    }
                }
            }
        });

    </script>

@endpush