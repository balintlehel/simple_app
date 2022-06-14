<?php

namespace Chatter\Middleware;

class ImageRemoveExif
{
    public function __invoke($request, $response, $next)
    {
        $files = $request->getUploadedFiles();
        $newFile = $files['file'];
        $newFile_type = $newFile->getClientMediaType();
        $uploadFilename = $newFile->getClientFilename();
        $newFile->moveTo('assets/images/raw/' . $uploadFilename);
        $pngFile = 'assets/images/' . substr($uploadFilename, 0, -4) . ".png";

        if ('image/jpeg' == $newFile_type) {
            $_img = imagecreatefromjpeg('assets/images/raw/' . $uploadFilename);
            imagepng($_img, $pngFile);
        }

        $request->withAttribute('png_filename', $pngFile);
        $response = $next($request, $response);

        return $response;
    }
}