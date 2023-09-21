<x-web.layouts.app.slot-component :sidebarAlias="'web.user.sidebar.sidebar-component'">
    <div class="container-lg">
        <x-web.user.breadcrumb.breadcrumb-component>
            <x-breadcrumb.item-component :active="true">
                {{ trans('account.pages.show.title') }}
            </x-breadcrumb.item-component>
        </x-web.user.breadcrumb.breadcrumb-component>
    </div>    
</x-web.layouts.app.slot-component>