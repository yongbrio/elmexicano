<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">

            {{-- Tablero --}}
            <li>
                <a href="{{route('dashboard')}}"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <i class="fa-solid fa-gauge-high"></i>
                    <span class="ms-3">Tablero</span>
                </a>
            </li>
            {{-- Fin Tablero --}}

            {{-- Caja --}}
            @can('caja')
            <li>
                <div class="flex">
                    <a href="{{route('caja-general')}}"
                        class="flex items-center w-full p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="fa-solid fa-cash-register"></i>
                        <span class="ms-3">Caja</span>
                    </a>

                    <div class="z-50 flex justify-end">
                        <button type="button" data-modal-target="modal-ordenes" data-modal-toggle="modal-ordenes"
                            class="px-3 font-medium text-center text-white bg-green-700 rounded-full text-md hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>

            </li>

            @endcan
            {{-- Fin Caja --}}

            {{-- Clientes --}}
            @can('clientes')
            <li>
                <a href="{{route('clientes-general')}}"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <i class="fa-solid fa-user-group"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Clientes</span>
                </a>
            </li>
            @endcan
            {{-- Fin Clientes --}}

            {{-- Proveedores --}}
            @can('proveedores')
            <li>
                <a href="{{route('proveedores-general')}}"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <i class="fa-solid fa-users-line"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Proveedores</span>
                </a>
            </li>
            @endcan
            {{-- Fin Proveedores --}}

            {{-- Inventario --}}
            @can('inventario')
            <li>
                <a href="{{route('inventario-general')}}"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <i class="fa-solid fa-cart-flatbed"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Inventario</span>
                </a>
            </li>
            @endcan
            {{-- Fin Inventario --}}
            {{-- Egresos --}}
            @can('egresos')
            <li>
                <a href="{{route('egresos-general')}}"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Egresos</span>
                </a>
            </li>
            @endcan
            {{-- Fin Egresos --}}

            {{-- Administración --}}
            <li>
                <button type="button"
                    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                    aria-controls="dropdown-administration" data-collapse-toggle="dropdown-administration">
                    <i class="fa-solid fa-gear"></i>
                    <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Administración</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="dropdown-administration" class="hidden py-2 space-y-2">
                    @can('admin.clientes')
                    <li>
                        <a href="{{route('admin-clientes')}}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-user-group"></i> <span class="flex-1 ms-3 whitespace-nowrap">Admin
                                Clientes</span> </a>
                    </li>
                    @endcan
                    @can('admin.proveedores')
                    <li>
                        <a href="{{route('admin-proveedores')}}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-users-line"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Admin Proveedores</span>
                        </a>
                    </li>
                    @endcan
                    @can('admin.empresas')
                    <li>
                        <a href="{{route('admin-empresas')}}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-building"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Empresas</span>
                        </a>
                    </li>
                    @endcan
                    @can('admin.sucursales')
                    <li>
                        <a href="{{route('admin-sucursales')}}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-industry"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Sucursales</span>
                        </a>
                    </li>
                    @endcan
                    @can('admin.cuentas_bancarias')
                    <li>
                        <a href="{{route('admin-cuentas-bancarias')}}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-piggy-bank"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Cuentas Bancarias</span>
                        </a>
                    </li>
                    @endcan
                    @can('admin.inventario')
                    <li>
                        <a href="{{route('admin-inventario')}}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-cart-flatbed"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Admin Inventario</span>
                        </a>
                    </li>
                    @endcan
                    @can('admin.categoria.productos')
                    <li>
                        <a href="{{route('admin-categorias')}}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-cart-plus"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Categoría Productos</span>
                        </a>
                    </li>
                    @endcan
                    @can('admin.egresos')
                    <li>
                        <a href="{{route('admin-egresos')}}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-hand-holding-dollar"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Admin Egresos</span>
                        </a>
                    </li>
                    @endcan
                    @can('admin.ordenes')
                    <li>
                        <a href="{{route('admin-ordenes')}}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-cart-arrow-down"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Admin Ordenes</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            {{-- Fin Administración --}}

            {{-- Seguridad --}}
            <li>
                <button type="button"
                    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                    aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Seguridad</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="dropdown-example" class="hidden py-2 space-y-2">
                    @can('seguridad.usuarios')
                    <li>
                        <a href="{{route('admin-usuarios')}}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-users-gear"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Usuarios</span>
                        </a>
                    </li>
                    @endcan
                    @can('seguridad.perfiles')
                    <li>
                        <a href="{{route('admin-perfiles')}}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-regular fa-id-badge"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Perfiles</span>
                        </a>
                    </li>
                    @endcan
                    @can('seguridad.log')
                    <li>
                        <a href="{{route('admin-log')}}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-arrows-rotate"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Log</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            {{-- Fin Seguridad --}}

        </ul>
    </div>
</aside>