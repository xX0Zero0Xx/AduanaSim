
<div class="space-y-6">

    <div>
        <h3 class="text-xl font-semibold text-slate-800">
            Validación asistida por IA
        </h3>

        <p class="mt-2 text-sm text-slate-600">
            Revisa tus documentos antes de enviarlos al Agente.
            La IA identificará posibles errores y proporcionará
            recomendaciones para mejorar tu captura.
        </p>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-5 space-y-4">

        <div>
            <label class="block text-sm font-medium text-slate-700">
                Tipo de documento
            </label>

            <select
                name="tipo_documento"
                class="mt-2 w-full rounded-lg border-slate-300"
            >
                <option value="">Selecciona un documento</option>
                <option value="pedimento">Pedimento</option>
                <option value="cove">COVE</option>
                <option value="doda">DODA</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">
                Folio del documento
            </label>

            <input
                type="text"
                name="folio"
                placeholder="Introduce el folio interno"
                class="mt-2 w-full rounded-lg border-slate-300"
            >
        </div>

        <div class="rounded-lg bg-slate-50 p-4">
            <p class="text-sm text-slate-600">
                La IA analizará la información registrada,
                detectará inconsistencias y mostrará sugerencias.
            </p>
        </div>

        <button
            type="button"
            disabled
            class="rounded-lg bg-slate-300 px-5 py-2 text-sm
                font-medium text-slate-600 cursor-not-allowed"
        >
            Validar documento con IA
        </button>

        <p class="text-xs text-slate-500">
            Módulo visual. La conexión con el servicio de IA
            se implementará posteriormente.
        </p>

    </div>

</div>
<?php /**PATH /home/lozada/Documentos/VS_Code/AduanaSim/resources/views/dashboard/partials/modulo-ia/index.blade.php ENDPATH**/ ?>