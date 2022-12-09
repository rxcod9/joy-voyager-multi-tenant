@extends('tenant-voyager::master')

@section('page_title', __('voyager::generic.media'))

@section('content')
    <div class="page-content container-fluid">
        @include('tenant-voyager::alerts')
        <div class="row">
            <div class="col-md-12">

                <div class="admin-section-title">
                    <h3><i class="voyager-images"></i> {{ __('voyager::generic.media') }}</h3>
                </div>
                <div class="clear"></div>
                <div id="filemanager">
                    <media-manager
                        base-path="{{ config('tenant-voyager.media.path', '/') }}"
                        :show-folders="{{ config('tenant-voyager.media.show_folders', true) ? 'true' : 'false' }}"
                        :allow-upload="{{ config('tenant-voyager.media.allow_upload', true) ? 'true' : 'false' }}"
                        :allow-move="{{ config('tenant-voyager.media.allow_move', true) ? 'true' : 'false' }}"
                        :allow-delete="{{ config('tenant-voyager.media.allow_delete', true) ? 'true' : 'false' }}"
                        :allow-create-folder="{{ config('tenant-voyager.media.allow_create_folder', true) ? 'true' : 'false' }}"
                        :allow-rename="{{ config('tenant-voyager.media.allow_rename', true) ? 'true' : 'false' }}"
                        :allow-crop="{{ config('tenant-voyager.media.allow_crop', true) ? 'true' : 'false' }}"
                        :details="{{ json_encode(['thumbnails' => config('tenant-voyager.media.thumbnails', []), 'watermark' => config('tenant-voyager.media.watermark', (object)[])]) }}"
                        ></media-manager>
                </div>
            </div><!-- .row -->
        </div><!-- .col-md-12 -->
    </div><!-- .page-content container-fluid -->
@stop

@section('javascript')
<script>
new Vue({
    el: '#filemanager'
});
</script>
@endsection
