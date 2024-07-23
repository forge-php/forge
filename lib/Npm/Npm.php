<?php

namespace Forge\Npm;

use Illuminate\Support\Collection;

class Npm
{
    protected $json = [];
    protected $lock = [];
    protected $lockExists = false;
    protected $jsonExists = false;

    public function __construct() {
        $jsonPath = sprintf('%s/package.json', getcwd());
        $lockPath = sprintf('%s/package-lock.json', getcwd());

        if (file_exists($jsonPath)) {
            $this->jsonExists = true;
            $this->json = $this->decodeJson($jsonPath);
        }

        if (file_exists($lockPath)) {
            $this->lockExists = true;
            $this->lock = $this->decodeJson($lockPath);
        }
    }

    private function decodeJson(string $path): array
    {
        return json_decode(file_get_contents($path), true);
    }

    public function isComposerProject(): bool
    {
        return $this->jsonExists;
    }

    public function getPackageDetails(string $package): ?array
    {

        if ($this->lockExists) {
            return $this->getPackageDetailsFromLockFile($package);
        }
        if (isset( $this->json['dependencies'][$package] )) {
            return [
                'name' =>  $package,
                'version' => $this->json['dependencies'][$package]
            ];
        }
        return null;

    }

    private function getPackageDetailsFromLockFile(string $package): ?array
    {
        $packages = new Collection($this->lock['packages']);
        return $packages->filter(fn($pack) => $pack['name'] === sprintf('node_modules/%s', $package), null)->first();
    }

    public function packageExists(string $name): bool
    {
        if ($this->lockExists) {
            $name = 'node_modules/' . $name;
            $packages = new Collection($this->lock['packages']);
            $package = $packages->filter(fn($p) => $p['name'] === $name, false)->first();
            return (bool) $package;
        }

        if ($this->jsonExists) {
            $packages = new Collection($this->json['require']);
            $package = $packages->filter(fn($p) => $p['name'] === $name, false)->first();
            return (bool) $package;
        }

        return false;
    }
}
