<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;
use App\Facades\TenantVoyager;
use TCG\Voyager\Http\Controllers\Controller;

class VoyagerController extends Controller
{
    public function index()
    {
        return TenantVoyager::view('tenant-voyager::index');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('tenant-voyager.login');
    }

    public function upload(Request $request)
    {
        $fullFilename = null;
        $resizeWidth = 1800;
        $resizeHeight = null;
        $slug = $request->input('type_slug');
        $file = $request->file('image');

        $dataType = TenantVoyager::model('DataType')->where('slug', '=', $slug)->firstOrFail();

        if ($this->userCannotUploadImageIn($dataType, 'add') && $this->userCannotUploadImageIn($dataType, 'edit')) {
            abort(403);
        }

        $path = $slug.'/'.date('FY').'/';

        $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
        $filename_counter = 1;

        // Make sure the filename does not exist, if it does make sure to add a number to the end 1, 2, 3, etc...
        while (Storage::disk(config('tenant-voyager.storage.disk'))->exists($path.$filename.'.'.$file->getClientOriginalExtension())) {
            $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension()).(string) ($filename_counter++);
        }

        $fullPath = $path.$filename.'.'.$file->getClientOriginalExtension();

        $ext = $file->guessClientExtension();

        if (in_array($ext, ['jpeg', 'jpg', 'png', 'gif'])) {
            $image = Image::make($file)
                ->resize($resizeWidth, $resizeHeight, function (Constraint $constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            if ($ext !== 'gif') {
                $image->orientate();
            }
            $image->encode($file->getClientOriginalExtension(), 75);

            // move uploaded file from temp to uploads directory
            if (Storage::disk(config('tenant-voyager.storage.disk'))->put($fullPath, (string) $image, 'public')) {
                $status = __('voyager::media.success_uploading');
                $fullFilename = $fullPath;
            } else {
                $status = __('voyager::media.error_uploading');
            }
        } else {
            $status = __('voyager::media.uploading_wrong_type');
        }

        // Return URL for TinyMCE
        return TenantVoyager::image($fullFilename);
    }

    public function assets(Request $request)
    {
        try {
            app('debugbar')->disable();

            if (class_exists(\League\Flysystem\Util::class)) {
                // Flysystem 1.x
                $path = dirname(__DIR__, 4).'/resources/assets/'.\League\Flysystem\Util::normalizeRelativePath(urldecode($request->path));
                // dd($path, dirname(__DIR__, 4));
            } elseif (class_exists(\League\Flysystem\WhitespacePathNormalizer::class)) {
                // Flysystem >= 2.x
                $normalizer = new \League\Flysystem\WhitespacePathNormalizer();
                $path = dirname(__DIR__, 4).'/resources/assets/'. $normalizer->normalizePath(urldecode($request->path));
                // dd($path, dirname(__DIR__, 4));
            }
            
        } catch (\LogicException $e) {
            abort(404);
        }

        if (File::exists($path)) {
            $mime = '';
            if (Str::endsWith($path, '.js')) {
                $mime = 'text/javascript';
            } elseif (Str::endsWith($path, '.css')) {
                $mime = 'text/css';
            } else {
                $mime = File::mimeType($path);
            }
            $response = response(File::get($path), 200, ['Content-Type' => $mime]);
            $response->setSharedMaxAge(31536000);
            $response->setMaxAge(31536000);
            $response->setExpires(new \DateTime('+1 year'));

            return $response;
        }

        return response('', 404);
    }

    protected function userCannotUploadImageIn($dataType, $action)
    {
        return auth()->user()->cannot($action, app($dataType->model_name))
                || $dataType->{$action.'Rows'}->where('type', 'rich_text_box')->count() === 0;
    }
}
