@persist('toast')
<div 
    x-data="toast"
    x-on:create-toast.window="createToast(event.detail)"
    class="toast-container position-fixed p-3 bottom-0 start-0"
    wire:ignore
>
    <template 
        x-for="(toast, index) in $store.toasts.collection"
    >
        <template x-if="toast">
            <div 
                class="toast" 
                :role="toast.action.getRole()" 
                :aria-live="toast.action.getAriaLive()" 
                aria-atomic="true" 
                :data-bs-autohide="toast.autohide"
                :data-bs-delay="toast.delay"
                :key="index"
                :id="`toast-${index}`"
                x-effect="$nextTick(() => initToast(index))"
            >
                <template x-if="toast.header">
                    <div 
                        class="toast-header m-0"
                        :class="toast.action.getClass()"                       
                    >
                        <strong class="me-auto" x-text="toast.header"></strong>
                        <button 
                            type="button" 
                            class="btn-close" 
                            data-bs-dismiss="toast" 
                            aria-label="{{ trans('default.close') }}"
                        ></button>
                    </div>
                </template>
                <div 
                    class="d-flex m-0 p-0"
                    :class="toast.action.getClass()"                
                >
                    <div 
                        class="toast-body m-0"  
                        x-text="toast.body"               
                    ></div>
                    <template x-if="toast.header === null">
                        <button 
                            type="button" 
                            class="btn-close me-2 m-auto" 
                            data-bs-dismiss="toast" 
                            aria-label="{{ trans('default.close') }}"
                        ></button>
                    </template>
                </div>                
            </div>
        </template>
    </template>
</div>
@endpersist