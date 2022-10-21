<?php

namespace Application\Lib;

class FileSystem
{
    private const PATH = 'uploads/';

    private static string $message;

    private static string $fileLog;

    private function checkDirectory(): void
    {
        if (!file_exists(self::PATH)) {
            @mkdir(self::PATH); //This symbol '@' hides all errors in this line only
        }
    }

    private function checkDiskFreeSpace(string $fileSize): bool
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
                $metadata = "$key.$name: $value ";
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

    public function getFiles(): array
    {
        $fileArray = [];
        $uploadsFiles = scandir(self::PATH);
        $j = 1;
        for ($i = 0; $i < count($uploadsFiles); $i++) {
            if ($uploadsFiles[$i] != '.' and $uploadsFiles[$i] != '..') {
                $fileArray[] = [
                    'id' => $j++,
                    'filename' => $uploadsFiles[$i],
                ];
            }
        }
        return $fileArray;
    }

    public static function uploadFile(): array
    {
        (new FileSystem)->checkDirectory();
        (new FileSystem)->createLogFile();

        $fileType = (new FileSystem)->checkFileType($_FILES['filename']['type']);
        $freeSpace = (new FileSystem)->checkDiskFreeSpace($_FILES['filename']['size']);
        $fileExist = (new FileSystem)->fileExist($_FILES['filename']['name']);

        if ($fileType and $freeSpace and $fileExist) {
            if (move_uploaded_file($_FILES['filename']['tmp_name'], self::PATH . $_FILES['filename']['name'])) {
                self::$message = "Success, files upload";
            } else {
                self::$message = "Failed, files not upload";
            }
        }

        $data = [
            "dataArray" => [
                "message" => self::$message,
                "name" => $_FILES['filename']['name'],
                "size" => $_FILES['filename']['size'],
                "metadata" => (new FileSystem)->hasMetadata(self::PATH . $_FILES['filename']['name']),
            ],
        ];
        (new FileSystem)->writeLogFile($data);
        return $data;
    }
}
