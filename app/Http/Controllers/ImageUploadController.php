<?php
namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Services\SystemLogger;
use Aws\S3\S3Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImageUploadController extends BaseController
{
    protected array $models = [
        'about'                => \App\Models\About::class,
        'events'               => \App\Models\Event::class,
        'blogs'                => \App\Models\Blog::class,
        'banners'              => \App\Models\Banner::class,
        'book-recommendations' => \App\Models\BookRecommendation::class,
        'donations'            => \App\Models\Donation::class,
        'media-types'          => \App\Models\MediaType::class,
        'gallery-images'       => \App\Models\GalleryImage::class,
        'collaborators'        => \App\Models\Collaborator::class,
        'collaborator-images'  => \App\Models\CollaboratorImage::class,
        'partners'             => \App\Models\Partner::class,
        'positions'            => \App\Models\Position::class,
        'products'             => \App\Models\Product::class,
        'projects'             => \App\Models\Project::class,
        'project-images'       => \App\Models\ProjectImage::class,
        'sections'             => \App\Models\Section::class,
        'stores'               => \App\Models\Store::class,
        'testimonials'         => \App\Models\Testimonial::class,
        'teams'                => \App\Models\Team::class,
        'pages'                => \App\Models\Page::class,
        'resources'            => \App\Models\Resource::class,
        'services'             => \App\Models\Service::class,
        'settings'             => \App\Models\Setting::class,

        // add more models here
    ];

    /**
     * Preview image from S3
     */
    public function preview(string $model, int $id)
    {
        $instance = $this->resolveModel($model, $id);

        abort_if(! $instance->image_url, 404);

        $client = new S3Client([
            'version'     => 'latest',
            'region'      => config('filesystems.disks.s3.region'),
            'credentials' => [
                'key'    => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret'),
            ],
        ]);

        $cmd = $client->getCommand('GetObject', [
            'Bucket' => config('filesystems.disks.s3.bucket'),
            'Key'    => $instance->image_url,
        ]);

        $request = $client->createPresignedRequest($cmd, '+10 minutes');

        return redirect((string) $request->getUri());
    }

    public function edit(string $model, int $id)
    {
        $instance = $this->resolveModel($model, $id);

        return view('admin.images.edit', [
            'modelKey' => $model,
            'model'    => $instance,
            'image'    => $instance->image_url,
        ]);
    }

    public function update(Request $request, string $model, int $id)
    {

      //   dd($request->file('image')?->getError(), $request->file('image')?->getErrorMessage());

        $request->validate([
            'image' => 'required|image|max:5120',
        ]);
        try {

            $instance = $this->resolveModel($model, $id);

            DB::transaction(function () use ($request, $instance, $model) {

                // Delete old image if exists
                if (! empty($instance->image_url)) {
                    S3::delete($instance->image_url);
                }

                // Upload new image (converted to WebP)
                $path = S3::uploadImageAsWebp(
                    $request->file('image'),
                    "{$model}/images"
                );

                $instance->update([
                    'image_url' => $path,
                ]);
            });

            return redirect()
                ->route("{$model}.index")
                ->with('success', 'Image uploaded successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'Image upload failed',
                'error',
                'images.update.failed',
                [
                    'model'     => $model,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to upload image. Please try again.');
        }
    }

    protected function resolveModel(string $model, int $id): Model
    {
        abort_unless(isset($this->models[$model]), 404);

        return $this->models[$model]::findOrFail($id);
    }
}
