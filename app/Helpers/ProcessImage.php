<?php


namespace App\Helpers;


use Illuminate\Http\Request;

class ProcessImage
{
    public $image;
    public string $byteCode;
    public string $fileExt;
    public string $fileName;

    public function process()
    {
        $this->byteCode = base64_encode(file_get_contents($this->image->getRealPath()));
        $this->fileExt = $this->image->getMimeType();
        $this->fileName = $this->image->getClientOriginalName();
    }
}