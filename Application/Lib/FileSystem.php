<?php

namespace Application\Lib;

class FileSystem
{
    private const PATH = 'uploads/';

    private const MAX_FILE_SIZE = 2000000;

    private const EXCEPTION_FILES = ['.', '..', '.gitignore'];

    private static string $message;

    private static string $fileLog;

    public static function getFiles(): array
    {
        $fileArray = [];
        $uploadsFiles = scandir(self::PATH);
        $j = 1;
        foreach ($uploadsFiles as $value) {
            if (!in_array($value, self::EXCEPTION_FILES)) {
                $fileArray[] = [
                    'id' => $j++,
                    'filename' => $value,
                ];
            }
        }
        return $fileArray;
    }

    public static function uploadFile(): array
    {
        $fileSystem = new FileSystem;
        $fileSystem->checkDirectory();
        $fileSystem->createLogFile();

        $fileType = $fileSystem->checkFileType($_FILES['filename']['type']);
        $freeSpace = $fileSystem->checkDiskFreeSpace($_FILES['filename']['size']);
        $fileExist = $fileSystem->fileExist($_FILES['filename']['name']);
        $fileSize = $fileSystem->checkFileSize($_FILES['filename']['size']);

        if ($fileType and $freeSpace and $fileExist and $fileSize) {
            $fileSystem->moveUploadedFile();
        }

        $data = [
            "dataArray" => [
                "message" => self::$message,
                "name" => $_FILES['filename']['name'],
                "size" => round($_FILES['filename']['size'] / 1024 / 1024, 2) . 'mb',
                "metadata" => $fileSystem->hasMetadata(self::PATH . $_FILES['filename']['name']),
            ],
        ];
        $fileSystem->writeLogFile($data);

        return $data;
    }

    private function moveUploadedFile(): void
    {
        $isMoved = move_uploaded_file($_FILES['filename']['tmp_name'], self::PATH . $_FILES['filename']['name']);
        self::$message = $isMoved ? "Success, files upload" : "Failed, files not upload";
    }

    private function checkDirectory(): void
    {
        if (!file_exists(self::PATH)) {
            @mkdir(self::PATH); //This symbol '@' hides all errors in this line only
        }
    }

    private function checkDiskFreeSpace(int $fileSize): bool
    {
        if ($fileSize > disk_free_space(self::PATH)) {
            self::$message = "File size is larger than disk space!";
            return false;
        }
        return true;
    }

    private function checkFileType(string $fileType): bool
    {
        $message = match ($fileType) {
            "text/plain", "image/png", "image/jpeg" => null,
            default => "File type is not text and not image",
        };
        if ($message != null) {
            self::$message = $message;
            return false;
        }
        return true;
    }

    private function hasMetadata(string $path): string
    {
        $exif = @exif_read_data($path, 0, true);
        if ($exif === false) {
            return self::$message = "Not found metadata";
        }
        $metadata = "";
        foreach ($exif as $key => $section) {
            foreach ($section as $name => $value) {
                $metadata .= "$key.$name: $value\n";
            }
        }
        return $metadata;
    }

    private function createLogFile(): void
    {
        $date = date('dmy');
        $dir = "logs/";
        $fileName = "upload_" . $date . ".log";
        self::$fileLog = $dir . $fileName;
        if (!file_exists(self::$fileLog)) {
            fopen($dir . $fileName, "w+");
        }
    }

    private function writeLogFile(array $data = []): void
    {
        $messageLog = $this->convertArrayToString($data);
        file_put_contents(self::$fileLog, $messageLog, FILE_APPEND);
    }

    private function convertArrayToString(array $dataArray = []): string
    {
        $dateTime = date("d-m-y H:i");
        $messageLog = $dateTime . "; ";
        foreach ($dataArray as $item) {
            foreach ($item as $value) {
                $messageLog .= $value . "; ";
            }
        }
        return $messageLog . "\n";
    }

    private function fileExist(string $filename): bool
    {
        $fileArray = $this->getFiles();
        foreach ($fileArray as $item) {
            foreach ($item as $value) {
                if ($value == $filename) {
                    self::$message = "File with this name exist";
                    return false;
                }
            }
        }
        return true;
    }

    private function checkFileSize(int $fileSize): bool
    {
        if ($fileSize > self::MAX_FILE_SIZE) {
            self::$message = "File size too large";
            return false;
        }
        return true;
    }
}
