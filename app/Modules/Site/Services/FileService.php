<?php


namespace App\Modules\Site\Services;


use App\Modules\Site\Models\Objects\FileInfoObject;
use App\Modules\Site\Services\Interfaces\FileServiceInterface;

/**
 * Class FileService
 * @package App\Modules\Site\Services
 */
class FileService implements FileServiceInterface
{

    /**
     * @param string $path
     * @return FileInfoObject
     */
    public function getPathInfo(string $path): FileInfoObject
    {

        if (FileService::fileNotExist($path)) {
            return new FileInfoObject([
                'fileExist' => false
            ]);
        }

        $pathInfo = pathinfo($path);
        return new FileInfoObject([
            'path' => $path,
            'basename' => $pathInfo['basename'],
            'extension' => $pathInfo['extension'],
            'filename' => $pathInfo['filename'],
            'fileExist' => true,
        ]);
    }

    /**
     * @param $path
     * @return bool
     */
    public static function fileNotExist($path): bool
    {
        return !is_file($path);
    }

}
