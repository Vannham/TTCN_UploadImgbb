<?php

namespace App\Repositories;

use App\Models\File;

class FileRepository implements FileRepositoryInterface {
    protected $model;

    public function __construct(File $file) {
        $this->model = $file;
    }

    public function all() {
        return $this->model::orderBy('id', 'desc')->get();
    }

    public function find($id) {
        return $this->model::find($id);
    }

    public function find_name($name) {
        return $this->model::where('file_name', $name)->first();
    }

    public function create($data) {
        return $this->model::create($data);
    }
}
