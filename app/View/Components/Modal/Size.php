<?php

declare(strict_types=1);

namespace App\View\Components\Modal;

enum Size: string
{
    case MODAL_SM = 'modal-sm';

    case MODAL_LG = 'modal-lg';

    case MODAL_XL = 'modal-xl';

    case MODAL_FULLSCREEN = 'modal-fullscreen';

    case MODAL_FULLSCREEN_SM_DOWN = 'modal-fullscreen-sm-down';

    case MODAL_FULLSCREEN_MD_DOWN = 'modal-fullscreen-md-down';

    case MODAL_FULLSCREEN_LG_DOWN = 'modal-fullscreen-lg-down';

    case MODAL_FULLSCREEN_XL_DOWN = 'modal-fullscreen-xl-down';

    case MODAL_FULLSCREEN_XXL_DOWN = 'modal-fullscreen-xxl-down';
}
