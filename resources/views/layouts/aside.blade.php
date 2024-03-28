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
            <li>
                <a href="#"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <i class="fa-solid fa-cash-register"></i>
                    <span class="ms-3">Caja</span>
                </a>
            </li>
            {{-- Fin Caja --}}

            {{-- Clientes --}}
            <li>
                <a href="#"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <i class="fa-solid fa-user-group"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Clientes</span>
                </a>
            </li>
            {{-- Fin Clientes --}}

            {{-- Proveedores --}}
            <li>
                <a href="#"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <i class="fa-solid fa-users-line"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Proveedores</span>
                </a>
            </li>
            {{-- Fin Proveedores --}}

            {{-- Inventario --}}
            <li>
                <a href="#"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <i class="fa-solid fa-cart-flatbed"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Inventario</span>
                </a>
            </li>
            {{-- Fin Inventario --}}

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
                    <li>
                        <a href="#"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-user-group"></i> <span class="flex-1 ms-3 whitespace-nowrap">Admin
                                Clientes</span> </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-users-line"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Admin Proveedores</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-building"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Empresas</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-industry"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Sucursales</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-piggy-bank"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Cuentas Bancarias</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-cart-flatbed"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Inventario General</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-cart-plus"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Categoría Productos</span>
                        </a>
                    </li>
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

                    <li>
                        <a href="#"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-users-gear"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Usuarios</span>
                        </a>
                    </li>

                    <li>
                        <a href="#"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-regular fa-id-badge"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Perfiles</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <i class="fa-solid fa-puzzle-piece"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Módulos/Perfiles</span>

                        </a>
                    </li>
                </ul>
            </li>
            {{-- Fin Seguridad --}}

        </ul>
    </div>
</aside>