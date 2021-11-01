<?php


namespace App\Modules\Site\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\Site\Enums\ErrorImageEnum;
use App\Modules\Site\Factories\ImagePreviewMethodFactory;
use App\Modules\Site\Models\Objects\ImagePreviewConfig;
use App\Modules\Site\Services\FileService;
use App\Modules\Site\Services\ImageService;
use App\Modules\Site\Services\Interfaces\FileServiceInterface;
use App\Modules\Site\Services\Interfaces\ImageServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

/**
 * Class ImageController
 * @package App\Modules\Site\Controllers
 *
 * @property FileService $fileService
 * @property ImageService $imageService
 */
class ImageController extends Controller
{

    private FileServiceInterface $fileService;
    private ImageServiceInterface $imageService;

    public function __construct(FileService $fileService, ImageServiceInterface $imageService)
    {
        $this->fileService = $fileService;
        $this->imageService = $imageService;
    }

    /**
     * @param Request $request
     * @param string $type
     * @param string $size
     * @param string $path
     * @return BinaryFileResponse
     * @throws Throwable
     */
    public function getImage(Request $request, string $type, string $size, string $path): BinaryFileResponse
    {
        try {
            $file = $this->fileService->getPathInfo($path);

            if ($file->fileExist === false) {
                throw new NotFoundException(ErrorImageEnum::ORIGINAL_IMAGE_NOT_FOUND);
            }

            if ($this->imageService->validate($file)) {

                $size = $this->imageService->getSize($size);
                $image = $this->imageService->createObject($file, new ImagePreviewConfig([
                    'width' => $size->width,
                    'height' => $size->height,
                    'method' => ImagePreviewMethodFactory::getMethod($type),
                ]));

                $previewPath = $this->imageService->getPreviewPath($image);

                if ($previewPath === null) {
                   return response()->file($this->imageService->createPreview($image));
                }

                return response()->file($previewPath);
            }
        } catch (Throwable $e) {
            throw $e;
        }
    }

}
