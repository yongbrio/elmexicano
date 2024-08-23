<div>
    <h2 class="text-lg font-medium ">Datos del proveedor</h2>

    <div class="grid grid-cols-1 gap-4 mt-5 text-sm sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2">

        <x-live-wire-input label="Teléfono" id="telefono" icon="fa-solid fa-phone" model="telefono"
            placeholder="3000000000" typeInput="text" disabled='disabled'></x-live-wire-input>

        <x-live-wire-input label="NIT" id="nit" icon="fa-solid fa-address-card" model="nit" placeholder="900000000"
            typeInput="text" disabled='disabled'></x-live-wire-input>

    </div>

    <div class="grid grid-cols-1 gap-4 mt-5 text-sm sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2">
        <x-live-wire-input label="Grupo" id="grupo" icon="fa-solid fa-layer-group" model="grupo" placeholder="Grupo"
            typeInput="text" disabled='disabled'></x-live-wire-input>
        <x-live-wire-input label="Nombre Comercial" id="nombreComercial" icon="fa-solid fa-industry"
            model="nombreComercial" placeholder="Nombre Comercial" typeInput="text" disabled='disabled'>
        </x-live-wire-input>
    </div>


    <div class="grid grid-cols-1 gap-4 mt-5 text-sm sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2">

        <x-live-wire-input label="Nombre Legal" id="nombreLegal" icon="fa-solid fa-file-signature" model="nombreLegal"
            placeholder="Nombre Legal" typeInput="text" disabled='disabled'></x-live-wire-input>

        <x-select2 label="Sucursal" id="sucursal" icon="fa-solid fa-ruler-horizontal" model="sucursal"
            optionTextDefault="Seleccione la sucursal asociada" disabled='disabled'>
        </x-select2>

    </div>

    <div class="grid grid-cols-1 gap-4 mt-5 text-sm sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2">

        <x-live-wire-input label="Dirección" id="direccion" icon="fa-regular fa-map" model="direccion"
            placeholder="XXXXXXXXXXXXX" typeInput="text" disabled='disabled'></x-live-wire-input>

        <x-live-wire-input label="Barrio/Localidad" id="barrio_localidad" icon="fa-solid fa-location-dot"
            model="barrio_localidad" placeholder="Barrio/Localidad" typeInput="text" disabled='disabled'>
        </x-live-wire-input>

    </div>

    <div class="grid grid-cols-1 gap-4 mt-5 text-sm sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2">

        <x-live-wire-input label="Ciudad" id="ciudad" icon="fa-solid fa-location-dot" model="ciudad"
            placeholder="Soacha" typeInput="text" disabled='disabled'></x-live-wire-input>

        <x-live-wire-input label="Departamento" id="departamento" icon="fa-solid fa-map-location-dot"
            model="departamento" placeholder="Cundinamarca" typeInput="text" disabled='disabled'></x-live-wire-input>

    </div>

    <div class="grid grid-cols-1 gap-4 mt-5 text-sm sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2">

        <x-live-wire-input label="Correo" id="correo" icon="fa-solid fa-envelope" model="correo"
            placeholder="correo@correo.com" typeInput="text" disabled='disabled'></x-live-wire-input>

        <x-live-wire-input label="Nombre encargado" id="nombreEncargado" icon="fa-solid fa-user" model="nombreEncargado"
            placeholder="Nombre encargado" typeInput="text" disabled='disabled'></x-live-wire-input>

    </div>

    <div class="grid grid-cols-1 gap-4 mt-5 text-sm sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1">
        <x-live-wire-input label="Descripción" id="descripcion" icon="fa-solid fa-comment" model="descripcion"
            placeholder="Descripción" typeInput="text" disabled='disabled'></x-live-wire-input>
    </div>

</div>