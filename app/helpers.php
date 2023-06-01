<?php

if (!function_exists('file_cache')) {
    function file_cache(string $pathToFile, bool $wrapAssets = true): string
    {
        $parsed = parse_url($pathToFile);
        $path = $parsed['path'];

        if (!file_exists(public_path($path))) {
            return $pathToFile;
        }

        $query = [];
        if (array_key_exists('query', $parsed)) {
            parse_str($parsed['query'], $query);
        }

        $query['v'] = filemtime(public_path($path));

        $result = $path . '?' . http_build_query($query);

        return $wrapAssets ? asset($result) : $result;
    }
}

if (!function_exists('phone_href')) {
    function phone_href(string $phone): string
    {
        return str_replace(['(', ')', ' ', '-'], '', $phone);
    }
}

if (!function_exists('mb_ucfirst')) {
    function mb_ucfirst(string $str): string
    {
        return mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1);
    }
}

if (!function_exists('mb_lcfirst')) {
    function mb_lcfirst(string $str): string
    {
        return mb_strtolower(mb_substr($str, 0, 1)) . mb_substr($str, 1);
    }
}

if (!function_exists('admin_wrap_name')) {
    function admin_wrap_name(
        string $wrap,
        string $name,
        ?int $idx = null,
        bool $multiple = false,
    ): string {
        if (empty($name)) {
            return $wrap . '[]';
        }

        $parts = explode('[', $name, 2);
        $name = $parts[0];
        $ending = count($parts) == 1 ? '' : "[{$parts[1]}";

        $result = $wrap . '[' . $parts[0] . ']' . $ending;
        if ($multiple) {
            $result = substr($result, 0, -1) . ($idx ?? '') . ']';
        }

        return $result;
    }
}

if (!function_exists('htmlprop')) {
    function htmlprop($data): string
    {
        return htmlentities(json_encode($data, JSON_UNESCAPED_UNICODE), ENT_QUOTES);
    }
}

if (!function_exists('dateFormat')) {
    function dateFormat($date, bool $full = false): string
    {
        $date = strtotime($date);

        if ($full) {
            return date('j-m-Y H:i', $date);
        } else {
            return date('j-m-Y', $date);
        }
    }
}

if (!function_exists('filesOnPath')) {
    function filesOnPath(string $path): \Illuminate\Support\Collection
    {
        $data = new \Illuminate\Support\Collection();
        $files = scandir($path);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || $file === 'Admin') {
                continue;
            }
            $filePath = $path . '/' . $file;
            if (is_dir($filePath)) {
                foreach(filesOnPath($filePath) as $fileDir) {
                    $data->add($fileDir);
                }
            } else {
                $data->add($filePath);
            }
        }
        return $data;
    }
}