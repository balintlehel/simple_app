<?php

namespace Chatter\Middleware;

//use Aws\S3\S3Client;

class FileMove
{
    public function __invoke($request, $response, $next)
    {
        //$s3 = new S3Client(['version' => '', 'region' => '']);

        $files = $request->getUploadedFiles();
        $newFile = $files['file'];
        $uploadedFileName = $newFile->getClientFileName();
        $png = 'assets/images/' . substr($uploadedFileName, 0, -4) . '.png';

        //use fake s3 in local
        copy($png, 'assets/images/fakes3/' . substr($uploadedFileName, 0, -4) . '.png');
        ///////////////////

//    ***** If use s3 *****
//        try {
//            $s3->putObject([
//                'Bucket' => 'my-bucket',
//                'Key' => 'my-object',
//                'Body' => fopen($pngFile, 'w'),
//                'ACL' => 'public-read'
//            ]);
//        } catch (\Exception $exc) {
//            $response->withStatus(400);
//        }

        $response = $next($request, $response);

        return $response;
    }
}