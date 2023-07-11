<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property string $title
 * @property float $size
 * @property string $extension
 * @property string $path
 * @property string $preview_path
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class File extends Model
{
    use HasFactory;

    protected $table = 'files';
    protected $fillable = [
        'title',
        'size',
        'extension',
        'preview_path',
        'path',
        'created_at'
    ];
}
