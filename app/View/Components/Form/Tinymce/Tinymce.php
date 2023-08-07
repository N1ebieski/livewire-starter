<?php

declare(strict_types=1);

namespace App\View\Components\Form\Tinymce;

final class Tinymce
{
    public function __construct(
        public readonly string $skin = 'tinymce-5',
        public readonly string $content_css = 'default',
        public readonly string $language = 'pl',
        public readonly string $entity_encoding = 'raw',
        public readonly string $plugins = 'fullscreen image link table lists code autoresize',
        public readonly string $toolbar = 'code | undo redo | styles | bold italic | numlist bullist | link image hr | fullscreen',
        public readonly Mobile $mobile = new Mobile()   
    ) {
    }
}