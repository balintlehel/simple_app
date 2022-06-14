<?php

namespace Chatter\Middleware;

class FileFilter
{

    protected $allowedFiles = [
        'image/jpeg',
        'image/png'
    ];
    public function __invoke($request, $response, $next)
    {
        $files = $request->getUploadedFiles();
        $newFile = $files['file'];
        $newFile_type = $newFile->getClientMediaType();

        if (!in_array($newFile_type, $this->allowedFiles)) {
            return $response->withStatus(415);
        }

        $response = $next($request, $response);

        return $response;
    }
}