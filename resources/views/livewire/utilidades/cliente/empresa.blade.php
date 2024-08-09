<div>
    <h2 class="text-lg font-medium ">Datos de empresa</h2>
    <div class="grid grid-cols-1 gap-4 mt-5 text-sm sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

        <x-live-wire-input label="NIT" id="nit" icon="fa-solid fa-address-card" model="nit" placeholder="900000000"
            typeInput="number" disabled='disabled'></x-live-wire-input>

        <x-live-wire-input label="Nombre Legal" id="nombreLegal" icon="fa-solid fa-file-signature" model="nombreLegal"
            placeholder="Nombre Legal" typeInput="text" disabled='disabled'></x-live-wire-input>

        <x-live-wire-input label="Nombre Comercial" id="nombreComercial" icon="fa-solid fa-industry"
            model="nombreComercial" placeholder="Nombre Comercial" typeInput="text" disabled='disabled'>
        </x-live-wire-input>

        <x-live-wire-input label="Dirección" id="direccion" icon="fa-regular fa-map" model="direccion"
            placeholder="XXXXXXXXXXXXX" typeInput="text" disabled='disabled'></x-live-wire-input>

        <x-live-wire-input label="Departamento" id="departamento" icon="fa-solid fa-map-location-dot"
            model="departamento" placeholder="Cundinamarca" typeInput="text" disabled='disabled'></x-live-wire-input>

        <x-live-wire-input label="Ciudad" id="ciudad" icon="fa-solid fa-location-dot" model="ciudad"
            placeholder="Soacha" typeInput="text" disabled='disabled'></x-live-wire-input>

        <x-live-wire-input label="Matrícula" id="matricula" icon="fa-regular fa-id-card" model="matricula"
            placeholder="Matrícula" typeInput="text" disabled='disabled'></x-live-wire-input>
            
    </div>
</div>