@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Menus"))

@section('content')

    <page v-cloak>
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
            <vue-form :data="form">
                <template slot="icon" scope="props">
                    <input class="form-control"
                        @keydown="props.errors.clear(props.element.column)"
                        v-model="props.element.value"
                        :name="props.element.column"
                        type="text">
                </template>
            </vue-form>
        </div>
    </page>

@endsection

@push('scripts')

    <script>

        const vm = new Vue({
            el: '#app',

            data: {
                form: {!! $form !!}
            }
        });

    </script>

@endpush