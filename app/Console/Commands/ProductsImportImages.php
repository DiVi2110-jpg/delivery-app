<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsImportImages extends Command
{
    protected $signature = 'products:import-images {--force : Перезаписать локальные файлы, даже если уже есть}';
    protected $description = 'Скачивает внешние картинки товаров в storage/public/products и сохраняет путь в image_url';

    public function handle(): int
    {
        $disk = Storage::disk('public');
        $dir = 'products';

        $products = Product::query()
            ->whereNotNull('image_url')
            ->get();

        if ($products->isEmpty()) {
            $this->info('Нет товаров с image_url');
            return self::SUCCESS;
        }

        $ok = 0;
        $skip = 0;
        $fail = 0;

        foreach ($products as $p) {
            $url = trim((string) $p->image_url);

            // Уже локально — пропускаем
            if (!Str::startsWith($url, ['http://', 'https://'])) {
                $skip++;
                continue;
            }

            // Dropbox: пытаемся максимально "прямую" выдачу
            $url = $this->normalizeDropboxUrl($url);

            // Имя файла
            $ext = $this->guessExtensionFromUrl($url) ?? 'jpg';
            $base = Str::slug($p->title ?: 'product');
            $filename = $base . '-' . $p->id . '.' . $ext;
            $path = $dir . '/' . $filename;

            if ($disk->exists($path) && !$this->option('force')) {
                // файл уже есть — просто перепривязываем
                $p->image_url = $path;
                $p->save();
                $ok++;
                continue;
            }

            try {
                $resp = Http::timeout(25)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0',
                        'Accept' => 'image/*,*/*;q=0.8',
                    ])
                    ->get($url);

                if (!$resp->ok()) {
                    $this->warn("FAIL {$p->id} {$p->title}: HTTP {$resp->status()}");
                    $fail++;
                    continue;
                }

                $contentType = (string) $resp->header('Content-Type');
                $body = $resp->body();

                // Частая проблема Dropbox: вместо картинки прилетает HTML (страница)
                if (Str::contains($contentType, 'text/html') || Str::startsWith(ltrim($body), '<')) {
                    $this->warn("FAIL {$p->id} {$p->title}: получен HTML вместо картинки (плохой хотлинк)");
                    $fail++;
                    continue;
                }

                // Если удаётся — уточняем расширение по Content-Type
                $extFromCt = $this->extFromContentType($contentType);
                if ($extFromCt) {
                    $ext = $extFromCt;
                    $filename = $base . '-' . $p->id . '.' . $ext;
                    $path = $dir . '/' . $filename;
                }

                $disk->put($path, $body);

                $p->image_url = $path; // ВАЖНО: теперь локальный путь
                $p->save();

                $this->info("OK {$p->id} {$p->title} -> {$path}");
                $ok++;
            } catch (\Throwable $e) {
                $this->warn("FAIL {$p->id} {$p->title}: {$e->getMessage()}");
                $fail++;
            }
        }

        $this->line("Готово: OK={$ok}, SKIP={$skip}, FAIL={$fail}");
        return self::SUCCESS;
    }

    private function normalizeDropboxUrl(string $url): string
    {
        // Варианты:
        // - www.dropbox.com/... ?raw=1
        // - dl.dropboxusercontent.com/... ?raw=1
        // Приводим к dl.dropboxusercontent.com и raw=1
        if (Str::contains($url, 'dropbox.com')) {
            $url = str_replace('www.dropbox.com', 'dl.dropboxusercontent.com', $url);
            $url = preg_replace('/\?dl=0$/', '', $url);
            if (!Str::contains($url, 'raw=1')) {
                $url .= (Str::contains($url, '?') ? '&' : '?') . 'raw=1';
            }
        }
        return $url;
    }

    private function guessExtensionFromUrl(string $url): ?string
    {
        $path = parse_url($url, PHP_URL_PATH);
        if (!$path) return null;

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','webp','gif'], true)) {
            return $ext === 'jpeg' ? 'jpg' : $ext;
        }
        return null;
    }

    private function extFromContentType(string $ct): ?string
    {
        $ct = strtolower($ct);
        return match (true) {
            str_contains($ct, 'image/jpeg') => 'jpg',
            str_contains($ct, 'image/png')  => 'png',
            str_contains($ct, 'image/webp') => 'webp',
            str_contains($ct, 'image/gif')  => 'gif',
            default => null,
        };
    }
}
