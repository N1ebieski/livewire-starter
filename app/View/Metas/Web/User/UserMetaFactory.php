<?php

declare(strict_types=1);

namespace App\View\Metas\Web\User;

use App\View\Metas\Meta;
use Illuminate\Http\Request;
use App\View\Metas\MetaInterface;
use App\View\Metas\OpenGraphInterface;
use Illuminate\Support\Collection as Collect;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Translation\Translator as Trans;

class UserMetaFactory
{
    public function __construct(
        protected Config $config,
        protected Trans $trans,
        protected Collect $collect,
        protected Request $request
    ) {
    }

    public function make(
        ?string $title = null,
        ?int $page = null,
        ?string $description = null,
        ?string $keywords = null,
        ?string $url = null,
        ?OpenGraphInterface $openGraph = null
    ): MetaInterface {
        return new Meta(
            title: $this->collect->make([
                $title,
                $page > 1 ? $this->trans->get('pagination.page', ['page' => $page]) : '',
                $this->trans->get('user.title'),
                $this->trans->get('app.title')
            ])->filter()->implode(' - '),
            description: $this->collect->make([
                $description,
                $page > 1 ? $this->trans->get('pagination.page', ['page' => $page]) : '',
                $this->trans->get('user.title'),
                $this->trans->get('app.description')
            ])->filter()->implode('. '),
            keywords: mb_strtolower($this->collect->make([
                $keywords,
                $this->trans->get('user.title'),
                $this->trans->get('app.keywords')
            ])->filter()->implode(', ')),
            url: $url ?? $this->config->get('app.url') . $this->request->getRequestUri(),
            openGraph: $openGraph
        );
    }
}
