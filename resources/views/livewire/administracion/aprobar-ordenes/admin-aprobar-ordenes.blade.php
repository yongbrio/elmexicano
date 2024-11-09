<div>
    <h1 class="pt-2">Aprobar Ordenes</h1>

    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
            data-tabs-toggle="#tab-aprobar-orden" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="lista-aprobar-orden-tab"
                    data-tabs-target="#lista-aprobar-orden" type="button" role="tab" aria-controls="lista-aprobar-orden"
                    aria-selected="false">Listado de ordenes por validar</button>
            </li>
        </ul>
    </div>
    <div id="tab-aprobar-orden" x-data="previewModalComponent">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="lista-aprobar-orden" role="tabpanel"
            aria-labelledby="lista-aprobar-orden-tab">
            <livewire:administracion.aprobar-ordenes.lista-aprobar-ordenes>
        </div>
    </div>

    <div id="modal-preview-soporte" tabindex="-1" aria-hidden="true" data-modal-backdrop="static" wire:ignore.self
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Vista previa Comprobante
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg cerrarModal hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modal-preview-soporte">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="flex justify-center" id="bodyPreview">
                </div>
                <!-- Modal footer -->
                <div
                    class="flex items-center justify-end p-4 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">
                    <button data-modal-hide="modal-preview-soporte" type="button"
                        class="cerrarModal py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
        Alpine.data("previewModalComponent", () => ({
            modalPreview(id, tipo) {
                
                const button = document.querySelector(`#btnPreview_${tipo}${id}[data-file-url][data-file-type]`);
                console.log(`btnPreview_${tipo}${id}`);
                if (!button) return;
                
                const fileURL = button.getAttribute('data-file-url');
                const fileType = button.getAttribute('data-file-type');
                const modalBody = document.getElementById('bodyPreview');
                modalBody.innerHTML = ''; // Limpia el contenido actual

                if (fileType === 'application/pdf') {
                    
                    modalBody.appendChild(this.showLoadingIndicator());

                    const iframe = document.createElement('iframe');
                    iframe.src = fileURL;
                    iframe.width = '100%';
                    iframe.height = '500px';
                    iframe.style.border = 'none';

                    iframe.addEventListener('load', () => {
                        const loader = modalBody.querySelector('#cargaArchivoContainer');
                        if (loader) loader.remove();
                    });

                    modalBody.appendChild(iframe);
                    
                } else if (fileType.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = fileURL;
                    img.className = 'h-full w-full p-2';
                    modalBody.appendChild(img);
                }

                this.initializeModal().show();
            },

            initializeModal() {
                const $targetEl2 = document.getElementById('modal-preview-soporte');   
                const instanceOptions2 = { id: 'modal-preview-soporte', override: true };
                const modal2 = new Modal($targetEl2, instanceOptions2);

                document.querySelectorAll('.cerrarModal').forEach(btn => {
                    btn.addEventListener('click', () => {
                        modal2.hide();
                        setTimeout(() => {
                            const backdrop = document.querySelector('[modal-backdrop]');
                            if (backdrop) backdrop.remove();
                        }, 300);
                    });
                });

                return modal2;
            },

            showLoadingIndicator() {
            // Crear el contenedor principal
            const container = document.createElement('div');
            container.className = 'absolute inset-0 flex items-center justify-center bg-gray-400 bg-opacity-50';
            container.id = 'cargaArchivoContainer';

            // Crear el contenido de carga
            const content = document.createElement('div');
            content.className = 'text-center p-4 space-y-4 md:p-5';

            // Crear el ícono de carga
            const icon = document.createElement('i');
            icon.className = 'text-red-600 fa-xl fa-solid fa-file-pdf fa-bounce';

            // Crear el título
            const title = document.createElement('h2');
            title.className = 'mt-4 text-zinc-50';
            title.textContent = 'Cargando vista del archivo';

            // Añadir el ícono y el título al contenido
            content.appendChild(icon);
            content.appendChild(title);

            // Añadir el contenido al contenedor
            container.appendChild(content);

            // Devolver el contenedor completo
            return container;
        }
        }));
    });
    </script>

    @script
    <script>
        $wire.on('mensajes', (e) => {
            
            const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
            });
            Toast.fire({
            icon: e.icon,
            title: e.message
            });

            if(e.state){
                modal.hide();
            }
        });
    </script>
    @endscript

</div>