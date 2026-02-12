<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use App\Models\CollaboratorImage;
use Illuminate\Http\Request;
use App\Helpers\S3;
use App\Services\SystemLogger;
use Exception;

class CollaboratorImageController extends BaseController
{
  /**
   * Display the gallery for a collaborator.
   */
  public function index(Collaborator $collaborator)
  {
    $collaborator->load('images');

    return view('admin.collaborators.images.index', compact('collaborator'));
  }

  /**
   * Store a newly uploaded collaborator image.
   */
  public function store(Request $request, Collaborator $collaborator)
  {
     $request->validate([
      'image' => ['required', 'image', 'max:5120'], // 5MB
    ]);

    try {
      $path = S3::uploadImageAsWebp(
        $request->file('image'),
        'collaborators/images'
      );

      $position = $collaborator->images()->max('position') + 1;

      $image = $collaborator->images()->create([
        'image_url' => $path,
        'position' => $position,
      ]);

      SystemLogger::log(
        'Collaborator image uploaded',
        'info',
        'collaborators.images.store',
        [
          'collaborator_id' => $collaborator->id,
          'image_id' => $image->id,
        ]
      );

      return back()->with('success', 'Image uploaded successfully.');

    } catch (Exception $e) {
      SystemLogger::log(
        'Collaborator image upload failed',
        'error',
        'collaborators.images.store',
        [
          'collaborator_id' => $collaborator->id,
          'exception' => $e->getMessage(),
        ]
      );

      return back()->with('error', 'Failed to upload image.');
    }
  }
  
  

  /**
   * Remove a project image.
   */
  public function destroy(Collaborator $collaborator, CollaboratorImage $image)
  {
    abort_unless($image->collaborator_id === $collaborator->id, 403);

    try {
      if ($image->image_url) {
        S3::delete($image->image_url);
      }

      $image->delete();

      SystemLogger::log(
        'Collaborator image deleted',
        'warning',
        'collaborators.images.delete',
        [
          'collaborator_id' => $collaborator->id,
          'image_id' => $image->id,
        ]
      );

      return back()->with('success', 'Image deleted successfully.');

    } catch (Exception $e) {
      SystemLogger::log(
        'Collaborator image deletion failed',
        'error',
        'collaborators.images.delete',
        [
          'collaborator_id' => $collaborator->id,
          'exception' => $e->getMessage(),
        ]
      );

      return back()->with('error', 'Failed to delete image.');
    }
  }
}
