<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogosCompletosSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedAduanas();
        $this->seedClavesPedimento();
        $this->seedMediosTransporte();
        $this->seedPaises();
        $this->seedMonedas();
        $this->seedMetodosValoracion();
        $this->seedContribuciones();
        $this->seedFormasPago();
        $this->seedIncoterms();
        $this->seedDestinos();
        $this->seedRegimenes();
        $this->seedTiposTasa();
        $this->seedContenedores();
        $this->seedSustanciasPeligrosas();
        $this->seedIdentificadores();
        $this->seedRestricciones();
    }

    private function insert(string $table, array $rows): void
    {
        $now = now();
        $data = collect($rows)->map(function ($row) use ($now) {
            return array_merge($row, [
                'activo' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        })->toArray();

        // Insertar en chunks para evitar límites de MySQL
        foreach (array_chunk($data, 200) as $chunk) {
            DB::table($table)->insert($chunk);
        }
    }

    // ===================== APÉNDICE 1 =====================
    private function seedAduanas(): void
    {
        $this->insert('cat_aduanas', [
            ['clave' => '010', 'denominacion' => 'Acapulco, Acapulco de Juárez, Guerrero'],
            ['clave' => '012', 'denominacion' => 'Aeropuerto Internacional General Juan N. Alvarez, Acapulco, Guerrero'],
            ['clave' => '020', 'denominacion' => 'Agua Prieta, Agua Prieta, Sonora'],
            ['clave' => '050', 'denominacion' => 'Subteniente López, Subteniente López, Quintana Roo'],
            ['clave' => '051', 'denominacion' => 'Subteniente López II “Chactemal”, Othón P. Blanco, Chetumal, Quintana Roo'],
            ['clave' => '060', 'denominacion' => 'Ciudad del Carmen, Ciudad del Carmen, Campeche'],
            ['clave' => '063', 'denominacion' => 'Seybaplaya, Seybaplaya, Campeche'],
            ['clave' => '070', 'denominacion' => 'Ciudad Juárez, Juárez, Chihuahua'],
            ['clave' => '071', 'denominacion' => 'Puente Internacional Zaragoza Isleta, Juárez, Chihuahua'],
            ['clave' => '072', 'denominacion' => 'San Jerónimo-Santa Teresa, Juárez, Chihuahua'],
            ['clave' => '073', 'denominacion' => 'Aeropuerto Internacional Abraham González, Juárez, Chihuahua'],
            ['clave' => '074', 'denominacion' => 'Guadalupe-Tornillo, Guadalupe, Chihuahua'],
            ['clave' => '080', 'denominacion' => 'Coatzacoalcos, Coatzacoalcos, Veracruz'],
            ['clave' => '110', 'denominacion' => 'Ensenada, Ensenada, Baja California'],
            ['clave' => '120', 'denominacion' => 'Guaymas, Guaymas, Sonora'],
            ['clave' => '121', 'denominacion' => 'Aeropuerto Internacional General Ignacio Pesqueira García, Hermosillo, Sonora'],
            ['clave' => '123', 'denominacion' => 'Ciudad Obregón Adyacente al Aeropuerto de Ciudad Obregón, Cajeme, Sonora'],
            ['clave' => '140', 'denominacion' => 'La Paz, La Paz, Baja California Sur'],
            ['clave' => '142', 'denominacion' => 'San José del Cabo, Los Cabos, Baja California Sur'],
            ['clave' => '143', 'denominacion' => 'Cabo San Lucas, Los Cabos, Baja California Sur'],
            ['clave' => '144', 'denominacion' => 'Santa Rosalía, Mulegé, Baja California Sur'],
            ['clave' => '145', 'denominacion' => 'Loreto, Loreto, Baja California Sur'],
            ['clave' => '147', 'denominacion' => 'Pichilingue, La Paz, Baja California Sur'],
            ['clave' => '160', 'denominacion' => 'Manzanillo, Manzanillo, Colima'],
            ['clave' => '161', 'denominacion' => 'Armería, Armería, Colima'],
            ['clave' => '170', 'denominacion' => 'Matamoros, Matamoros, Tamaulipas'],
            ['clave' => '171', 'denominacion' => 'Lucio Blanco-Los Indios, Matamoros, Tamaulipas'],
            ['clave' => '172', 'denominacion' => 'Ferroviaria de Matamoros, Matamoros, Tamaulipas'],
            ['clave' => '180', 'denominacion' => 'Mazatlán, Mazatlán, Sinaloa'],
            ['clave' => '183', 'denominacion' => 'Topolobampo, Ahome, Sinaloa'],
            ['clave' => '184', 'denominacion' => 'Aeropuerto Internacional de Culiacán, Culiacán, Sinaloa'],
            ['clave' => '190', 'denominacion' => 'Mexicali, Mexicali, Baja California'],
            ['clave' => '192', 'denominacion' => 'Los Algodones, Mexicali, Baja California'],
            ['clave' => '193', 'denominacion' => 'San Felipe, San Felipe, Baja California'],
            ['clave' => '200', 'denominacion' => 'México, Ciudad de México'],
            ['clave' => '202', 'denominacion' => 'Importación y Exportación de Contenedores, Alcaldía Azcapotzalco, Ciudad de México'],
            ['clave' => '220', 'denominacion' => 'Naco, Naco, Sonora'],
            ['clave' => '230', 'denominacion' => 'Nogales, Nogales, Sonora'],
            ['clave' => '231', 'denominacion' => 'Sásabe, Sáric, Sonora'],
            ['clave' => '240', 'denominacion' => 'Nuevo Laredo, Nuevo Laredo, Tamaulipas'],
            ['clave' => '250', 'denominacion' => 'Ojinaga, Ojinaga, Chihuahua'],
            ['clave' => '260', 'denominacion' => 'Puerto Palomas, Puerto Palomas, Chihuahua'],
            ['clave' => '270', 'denominacion' => 'Piedras Negras, Piedras Negras, Coahuila de Zaragoza'],
            ['clave' => '271', 'denominacion' => 'Aeropuerto Internacional Plan de Guadalupe, Ramos Arizpe, Coahuila de Zaragoza'],
            ['clave' => '280', 'denominacion' => 'Progreso, Progreso, Yucatán'],
            ['clave' => '282', 'denominacion' => 'Aeropuerto Internacional Lic. Manuel Crescencio Rejón, Mérida, Yucatán'],
            ['clave' => '300', 'denominacion' => 'Ciudad Reynosa, Reynosa, Tamaulipas'],
            ['clave' => '302', 'denominacion' => 'Las Flores, Río Bravo, Tamaulipas'],
            ['clave' => '304', 'denominacion' => 'Aeropuerto Internacional General Lucio Blanco, Reynosa, Tamaulipas'],
            ['clave' => '305', 'denominacion' => 'Río Bravo-Donna, Río Bravo, Tamaulipas'],
            ['clave' => '306', 'denominacion' => 'Anzaldúas, Reynosa, Tamaulipas'],
            ['clave' => '310', 'denominacion' => 'Salina Cruz, Salina Cruz, Oaxaca'],
            ['clave' => '311', 'denominacion' => 'Aeropuerto Internacional de Oaxaca, Santa Cruz Xoxocotlán, Oaxaca'],
            ['clave' => '330', 'denominacion' => 'San Luis Río Colorado, San Luis Río Colorado, Sonora'],
            ['clave' => '340', 'denominacion' => 'Ciudad Miguel Alemán, Miguel Alemán, Tamaulipas'],
            ['clave' => '342', 'denominacion' => 'Guerrero, Guerrero, Tamaulipas'],
            ['clave' => '370', 'denominacion' => 'Ciudad Hidalgo, Ciudad Hidalgo, Chiapas'],
            ['clave' => '372', 'denominacion' => 'Ciudad Talismán, Tuxtla Chico, Chiapas'],
            ['clave' => '375', 'denominacion' => 'Puerto Chiapas, Tapachula, Chiapas'],
            ['clave' => '376', 'denominacion' => 'Ciudad Cuauhtémoc, Frontera Comalapa, Chiapas'],
            ['clave' => '380', 'denominacion' => 'Tampico, Tampico, Tamaulipas'],
            ['clave' => '390', 'denominacion' => 'Tecate, Tecate, Baja California'],
        ]);
    }

    // ===================== APÉNDICE 2 =====================
    private function seedClavesPedimento(): void
    {
        $this->insert('cat_claves_pedimento', [
            // Definitivos
            ['clave' => 'A1', 'descripcion' => 'Importación o exportación definitiva', 'grupo' => 'Definitivo'],
            ['clave' => 'A3', 'descripcion' => 'Regularización de mercancías (importación definitiva)', 'grupo' => 'Definitivo'],
            ['clave' => 'C1', 'descripcion' => 'Importación definitiva a la franja fronteriza norte y región fronteriza', 'grupo' => 'Definitivo'],
            ['clave' => 'D1', 'descripcion' => 'Retorno por sustitución', 'grupo' => 'Definitivo'],
            ['clave' => 'GC', 'descripcion' => 'Global complementario', 'grupo' => 'Definitivo'],
            ['clave' => 'K1', 'descripcion' => 'Desistimiento de régimen y retorno de mercancías por devolución', 'grupo' => 'Definitivo'],
            ['clave' => 'L1', 'descripcion' => 'Pequeña importación / exportación definitiva', 'grupo' => 'Definitivo'],
            ['clave' => 'P1', 'descripcion' => 'Reexpedición de mercancías de franja fronteriza al interior del país', 'grupo' => 'Definitivo'],
            ['clave' => 'S2', 'descripcion' => 'Importación y exportación de mercancías para retornar en su mismo estado (art. 86)', 'grupo' => 'Definitivo'],
            ['clave' => 'T1', 'descripcion' => 'Importación y exportación por empresas de mensajería y paquetería', 'grupo' => 'Definitivo'],
            ['clave' => 'VF', 'descripcion' => 'Importación definitiva de vehículos usados a la franja o región fronteriza norte', 'grupo' => 'Definitivo'],
            ['clave' => 'VU', 'descripcion' => 'Importación definitiva de vehículos usados', 'grupo' => 'Definitivo'],

            // Virtuales
            ['clave' => 'G9', 'descripcion' => 'Transferencia de mercancías de RFE no colindante (retiro virtual)', 'grupo' => 'Virtual'],
            ['clave' => 'V1', 'descripcion' => 'Transferencias de mercancías (importación temporal virtual, etc.)', 'grupo' => 'Virtual'],
            ['clave' => 'V2', 'descripcion' => 'Transferencias de mercancías importadas con cuenta aduanera', 'grupo' => 'Virtual'],
            ['clave' => 'V5', 'descripcion' => 'Transferencias de mercancías de empresas certificadas', 'grupo' => 'Virtual'],
            ['clave' => 'V6', 'descripcion' => 'Transferencias de mercancías sujetas a cupo', 'grupo' => 'Virtual'],
            ['clave' => 'V7', 'descripcion' => 'Transferencias del sector azucarero', 'grupo' => 'Virtual'],
            ['clave' => 'V9', 'descripcion' => 'Transferencias de mercancías por donación', 'grupo' => 'Virtual'],
            ['clave' => 'VD', 'descripcion' => 'Virtuales diversos', 'grupo' => 'Virtual'],

            // Temporales
            ['clave' => 'AD', 'descripcion' => 'Importación temporal de mercancías destinadas a convenciones y congresos', 'grupo' => 'Temporal'],
            ['clave' => 'AJ', 'descripcion' => 'Importación y exportación temporal de envases', 'grupo' => 'Temporal'],
            ['clave' => 'BA', 'descripcion' => 'Importación y exportación temporal de bienes para retornar en mismo estado', 'grupo' => 'Temporal'],
            ['clave' => 'BB', 'descripcion' => 'Exportación, importación y retornos virtuales', 'grupo' => 'Temporal'],
            ['clave' => 'BC', 'descripcion' => 'Importación y exportación temporal para eventos culturales o deportivos', 'grupo' => 'Temporal'],
            ['clave' => 'BD', 'descripcion' => 'Importación y exportación temporal de equipo para filmación', 'grupo' => 'Temporal'],
            ['clave' => 'BE', 'descripcion' => 'Importación y exportación temporal de vehículos de prueba', 'grupo' => 'Temporal'],
            ['clave' => 'BF', 'descripcion' => 'Exportación temporal de mercancías para exposiciones o eventos', 'grupo' => 'Temporal'],
            ['clave' => 'BH', 'descripcion' => 'Importación temporal de contenedores, aviones, embarcaciones, etc.', 'grupo' => 'Temporal'],
            ['clave' => 'BI', 'descripcion' => 'Importación temporal (art. 106 frac. III inciso e)', 'grupo' => 'Temporal'],
            ['clave' => 'BM', 'descripcion' => 'Exportación temporal para transformación, elaboración o reparación', 'grupo' => 'Temporal'],
            ['clave' => 'BO', 'descripcion' => 'Exportación temporal para reparación o sustitución y retorno', 'grupo' => 'Temporal'],
            ['clave' => 'BP', 'descripcion' => 'Importación y exportación temporal de muestras o muestrarios', 'grupo' => 'Temporal'],
            ['clave' => 'BR', 'descripcion' => 'Exportación temporal y retorno de mercancías fungibles', 'grupo' => 'Temporal'],
            ['clave' => 'H1', 'descripcion' => 'Retorno de mercancías en su mismo estado', 'grupo' => 'Temporal'],
            ['clave' => 'H8', 'descripcion' => 'Retorno de envases', 'grupo' => 'Temporal'],
            ['clave' => 'I1', 'descripcion' => 'Importación, exportación y retorno de mercancías elaboradas/transformadas', 'grupo' => 'Temporal'],
            ['clave' => 'F4', 'descripcion' => 'Cambio de régimen de insumos o mercancía exportada temporalmente', 'grupo' => 'Temporal'],
            ['clave' => 'F5', 'descripcion' => 'Cambio de régimen de mercancías de importación temporal a definitiva', 'grupo' => 'Temporal'],

            // IMMEX
            ['clave' => 'IN', 'descripcion' => 'Importación temporal de bienes sujetos a transformación (IMMEX)', 'grupo' => 'IMMEX'],
            ['clave' => 'AF', 'descripcion' => 'Importación temporal de bienes de activo fijo (IMMEX)', 'grupo' => 'IMMEX'],
            ['clave' => 'RT', 'descripcion' => 'Retorno de mercancías (IMMEX)', 'grupo' => 'IMMEX'],

            // Depósito fiscal AGD
            ['clave' => 'A4', 'descripcion' => 'Introducción para depósito fiscal (AGD)', 'grupo' => 'Depósito Fiscal'],
            ['clave' => 'E1', 'descripcion' => 'Extracción de depósito fiscal de bienes para transformación (AGD)', 'grupo' => 'Depósito Fiscal'],
            ['clave' => 'E2', 'descripcion' => 'Extracción de depósito fiscal de bienes de activo fijo (AGD)', 'grupo' => 'Depósito Fiscal'],
            ['clave' => 'G1', 'descripcion' => 'Extracción de depósito fiscal (AGD)', 'grupo' => 'Depósito Fiscal'],
            ['clave' => 'C3', 'descripcion' => 'Extracción de depósito fiscal de franja o región fronteriza (AGD)', 'grupo' => 'Depósito Fiscal'],
            ['clave' => 'K2', 'descripcion' => 'Extracción de depósito fiscal por desistimiento o transferencias (AGD)', 'grupo' => 'Depósito Fiscal'],

            // Otros
            ['clave' => 'R1', 'descripcion' => 'Rectificación de pedimentos', 'grupo' => 'Otros'],
            ['clave' => 'CT', 'descripcion' => 'Pedimento complementario', 'grupo' => 'Otros'],
            ['clave' => 'T3', 'descripcion' => 'Tránsito interno', 'grupo' => 'Tránsito'],
            ['clave' => 'T6', 'descripcion' => 'Tránsito internacional por territorio extranjero', 'grupo' => 'Tránsito'],
            ['clave' => 'T7', 'descripcion' => 'Tránsito internacional por territorio nacional', 'grupo' => 'Tránsito'],
            ['clave' => 'T9', 'descripcion' => 'Tránsito internacional de transmigrantes', 'grupo' => 'Tránsito'],
        ]);
    }

    // ===================== APÉNDICE 3 =====================
    private function seedMediosTransporte(): void
    {
        $this->insert('cat_medios_transporte', [
            ['clave' => '1',  'descripcion' => 'Marítimo'],
            ['clave' => '2',  'descripcion' => 'Ferroviario de doble estiba'],
            ['clave' => '3',  'descripcion' => 'Carretero-Ferroviario'],
            ['clave' => '4',  'descripcion' => 'Aéreo'],
            ['clave' => '5',  'descripcion' => 'Postal'],
            ['clave' => '6',  'descripcion' => 'Ferroviario'],
            ['clave' => '7',  'descripcion' => 'Carretero'],
            ['clave' => '8',  'descripcion' => 'Tubería'],
            ['clave' => '10', 'descripcion' => 'Cables'],
            ['clave' => '11', 'descripcion' => 'Ductos'],
            ['clave' => '12', 'descripcion' => 'Peatonal'],
            ['clave' => '98', 'descripcion' => 'No se declara medio de transporte por no haber presentación física de mercancías'],
            ['clave' => '99', 'descripcion' => 'Otros'],
        ]);
    }

    // ===================== APÉNDICE 4 (Países - extracto principal) =====================
    private function seedPaises(): void
    {
        $this->insert('cat_paises', [
            ['clave_saai_fiii' => 'A1', 'clave_saai_m3' => 'AFG', 'nombre' => 'Afganistán'],
            ['clave_saai_fiii' => 'A2', 'clave_saai_m3' => 'ALB', 'nombre' => 'Albania'],
            ['clave_saai_fiii' => 'A4', 'clave_saai_m3' => 'DEU', 'nombre' => 'Alemania'],
            ['clave_saai_fiii' => 'B4', 'clave_saai_m3' => 'ARG', 'nombre' => 'Argentina'],
            ['clave_saai_fiii' => 'B5', 'clave_saai_m3' => 'AUS', 'nombre' => 'Australia'],
            ['clave_saai_fiii' => 'B6', 'clave_saai_m3' => 'AUT', 'nombre' => 'Austria'],
            ['clave_saai_fiii' => 'C2', 'clave_saai_m3' => 'BEL', 'nombre' => 'Bélgica'],
            ['clave_saai_fiii' => 'C8', 'clave_saai_m3' => 'BRA', 'nombre' => 'Brasil'],
            ['clave_saai_fiii' => 'D9', 'clave_saai_m3' => 'CAN', 'nombre' => 'Canadá'],
            ['clave_saai_fiii' => 'F6', 'clave_saai_m3' => 'CHL', 'nombre' => 'Chile'],
            ['clave_saai_fiii' => 'Z3', 'clave_saai_m3' => 'CHN', 'nombre' => 'China'],
            ['clave_saai_fiii' => 'E4', 'clave_saai_m3' => 'COL', 'nombre' => 'Colombia'],
            ['clave_saai_fiii' => 'E8', 'clave_saai_m3' => 'KOR', 'nombre' => 'Corea del Sur'],
            ['clave_saai_fiii' => 'F2', 'clave_saai_m3' => 'CRI', 'nombre' => 'Costa Rica'],
            ['clave_saai_fiii' => 'F3', 'clave_saai_m3' => 'CUB', 'nombre' => 'Cuba'],
            ['clave_saai_fiii' => 'G1', 'clave_saai_m3' => 'DNK', 'nombre' => 'Dinamarca'],
            ['clave_saai_fiii' => 'G3', 'clave_saai_m3' => 'ECU', 'nombre' => 'Ecuador'],
            ['clave_saai_fiii' => 'G5', 'clave_saai_m3' => 'SLV', 'nombre' => 'El Salvador'],
            ['clave_saai_fiii' => 'G7', 'clave_saai_m3' => 'ESP', 'nombre' => 'España'],
            ['clave_saai_fiii' => 'G8', 'clave_saai_m3' => 'USA', 'nombre' => 'Estados Unidos de América'],
            ['clave_saai_fiii' => 'H5', 'clave_saai_m3' => 'FRA', 'nombre' => 'Francia'],
            ['clave_saai_fiii' => 'I6', 'clave_saai_m3' => 'GTM', 'nombre' => 'Guatemala'],
            ['clave_saai_fiii' => 'J5', 'clave_saai_m3' => 'HND', 'nombre' => 'Honduras'],
            ['clave_saai_fiii' => 'J8', 'clave_saai_m3' => 'IND', 'nombre' => 'India'],
            ['clave_saai_fiii' => 'K6', 'clave_saai_m3' => 'ITA', 'nombre' => 'Italia'],
            ['clave_saai_fiii' => 'K9', 'clave_saai_m3' => 'JPN', 'nombre' => 'Japón'],
            ['clave_saai_fiii' => 'N3', 'clave_saai_m3' => 'MEX', 'nombre' => 'México'],
            ['clave_saai_fiii' => 'P1', 'clave_saai_m3' => 'NIC', 'nombre' => 'Nicaragua'],
            ['clave_saai_fiii' => 'J4', 'clave_saai_m3' => 'NLD', 'nombre' => 'Países Bajos'],
            ['clave_saai_fiii' => 'Q8', 'clave_saai_m3' => 'PAN', 'nombre' => 'Panamá'],
            ['clave_saai_fiii' => 'R2', 'clave_saai_m3' => 'PER', 'nombre' => 'Perú'],
            ['clave_saai_fiii' => 'R6', 'clave_saai_m3' => 'PRT', 'nombre' => 'Portugal'],
            ['clave_saai_fiii' => 'R9', 'clave_saai_m3' => 'GBR', 'nombre' => 'Reino Unido'],
            ['clave_saai_fiii' => 'S2', 'clave_saai_m3' => 'DOM', 'nombre' => 'República Dominicana'],
            ['clave_saai_fiii' => 'RU', 'clave_saai_m3' => 'RUS', 'nombre' => 'Rusia'],
            ['clave_saai_fiii' => 'U7', 'clave_saai_m3' => 'SWE', 'nombre' => 'Suecia'],
            ['clave_saai_fiii' => 'U8', 'clave_saai_m3' => 'CHE', 'nombre' => 'Suiza'],
            ['clave_saai_fiii' => 'W8', 'clave_saai_m3' => 'VEN', 'nombre' => 'Venezuela'],
        ]);
    }

    // ===================== APÉNDICE 5 =====================
    private function seedMonedas(): void
    {
        $this->insert('cat_monedas', [
            ['clave' => 'USD', 'nombre' => 'Dólar', 'pais' => 'E.U.A.'],
            ['clave' => 'MXP', 'nombre' => 'Peso', 'pais' => 'México'],
            ['clave' => 'EUR', 'nombre' => 'Euro', 'pais' => 'Unión Europea'],
            ['clave' => 'CAD', 'nombre' => 'Dólar', 'pais' => 'Canadá'],
            ['clave' => 'JPY', 'nombre' => 'Yen', 'pais' => 'Japón'],
            ['clave' => 'GBP', 'nombre' => 'Libra Esterlina', 'pais' => 'Gran Bretaña'],
            ['clave' => 'CNY', 'nombre' => 'Yuan continental', 'pais' => 'China'],
            ['clave' => 'CHF', 'nombre' => 'Franco', 'pais' => 'Suiza'],
            ['clave' => 'BRL', 'nombre' => 'Real', 'pais' => 'Brasil'],
            ['clave' => 'ARS', 'nombre' => 'Peso', 'pais' => 'Argentina'],
            ['clave' => 'CLP', 'nombre' => 'Peso', 'pais' => 'Chile'],
            ['clave' => 'COP', 'nombre' => 'Peso', 'pais' => 'Colombia'],
            ['clave' => 'PEN', 'nombre' => 'Nuevo Sol', 'pais' => 'Perú'],
            ['clave' => 'KRW', 'nombre' => 'Won', 'pais' => 'Corea del Sur'],
            ['clave' => 'INR', 'nombre' => 'Rupia', 'pais' => 'India'],
        ]);
    }

    // ===================== APÉNDICE 11 =====================
    private function seedMetodosValoracion(): void
    {
        $this->insert('cat_metodos_valoracion', [
            ['clave' => '0', 'descripcion' => 'Valor comercial (solo exportación)'],
            ['clave' => '1', 'descripcion' => 'Valor de transacción de las mercancías'],
            ['clave' => '2', 'descripcion' => 'Valor de transacción de mercancías idénticas'],
            ['clave' => '3', 'descripcion' => 'Valor de transacción de mercancías similares'],
            ['clave' => '4', 'descripcion' => 'Valor de precio unitario de venta'],
            ['clave' => '5', 'descripcion' => 'Valor reconstruido'],
            ['clave' => '6', 'descripcion' => 'Último recurso'],
        ]);
    }

    // ===================== APÉNDICE 12 =====================
    private function seedContribuciones(): void
    {
        $this->insert('cat_contribuciones', [
            ['clave' => '1',  'descripcion' => 'Derecho de trámite aduanero', 'abreviatura' => 'DTA', 'nivel' => 'G/C'],
            ['clave' => '2',  'descripcion' => 'Cuotas compensatorias', 'abreviatura' => 'C.C', 'nivel' => 'P'],
            ['clave' => '3',  'descripcion' => 'Impuesto al Valor Agregado', 'abreviatura' => 'IVA', 'nivel' => 'P'],
            ['clave' => '4',  'descripcion' => 'Impuesto sobre Automóviles Nuevos', 'abreviatura' => 'ISAN', 'nivel' => 'P'],
            ['clave' => '6',  'descripcion' => 'Impuesto General de Importación/Exportación', 'abreviatura' => 'IGI/IGE', 'nivel' => 'P'],
            ['clave' => '7',  'descripcion' => 'Recargos', 'abreviatura' => 'REC.', 'nivel' => 'G'],
            ['clave' => '9',  'descripcion' => 'Otros', 'abreviatura' => 'OTROS', 'nivel' => 'P/G'],
            ['clave' => '11', 'descripcion' => 'Multas', 'abreviatura' => 'MULT', 'nivel' => 'G'],
            ['clave' => '15', 'descripcion' => 'Prevalidación', 'abreviatura' => 'PRV', 'nivel' => 'G'],
            ['clave' => '20', 'descripcion' => 'Medida de transición', 'abreviatura' => 'MT', 'nivel' => 'P'],
            ['clave' => '22', 'descripcion' => 'IEPS.- gasolina', 'abreviatura' => 'IEPS', 'nivel' => 'P'],
            ['clave' => '23', 'descripcion' => 'IVA.- prevalidación', 'abreviatura' => 'IVA/PRV', 'nivel' => 'G'],
        ]);
    }

    // ===================== APÉNDICE 13 =====================
    private function seedFormasPago(): void
    {
        $this->insert('cat_formas_pago', [
            ['clave' => '0',  'descripcion' => 'Efectivo'],
            ['clave' => '2',  'descripcion' => 'Fianza'],
            ['clave' => '4',  'descripcion' => 'Depósito en cuenta aduanera'],
            ['clave' => '5',  'descripcion' => 'Temporal no sujeta a impuestos'],
            ['clave' => '6',  'descripcion' => 'Pendiente de pago'],
            ['clave' => '7',  'descripcion' => 'Cargo a partida presupuestal Gobierno Federal'],
            ['clave' => '8',  'descripcion' => 'Franquicia'],
            ['clave' => '9',  'descripcion' => 'Exento de pago'],
            ['clave' => '12', 'descripcion' => 'Compensación'],
            ['clave' => '13', 'descripcion' => 'Pago ya efectuado'],
            ['clave' => '15', 'descripcion' => 'Cuentas aduaneras de garantía'],
            ['clave' => '16', 'descripcion' => 'Acreditamiento'],
            ['clave' => '18', 'descripcion' => 'Estímulo fiscal'],
            ['clave' => '19', 'descripcion' => 'Otros medios de garantía'],
            ['clave' => '21', 'descripcion' => 'Crédito en IVA e IEPS'],
            ['clave' => '22', 'descripcion' => 'Garantía en IVA e IEPS'],
        ]);
    }

    // ===================== APÉNDICE 14 =====================
    private function seedIncoterms(): void
    {
        $this->insert('cat_incoterms', [
            ['clave' => 'CFR', 'descripcion' => 'Coste y flete (puerto de destino convenido)', 'grupo' => 'C'],
            ['clave' => 'CIF', 'descripcion' => 'Coste, seguro y flete (puerto de destino convenido)', 'grupo' => 'C'],
            ['clave' => 'CPT', 'descripcion' => 'Transporte pagado hasta (lugar de destino convenido)', 'grupo' => 'C'],
            ['clave' => 'CIP', 'descripcion' => 'Transporte y seguro pagados hasta (lugar de destino convenido)', 'grupo' => 'C'],
            ['clave' => 'DAP', 'descripcion' => 'Entregada en lugar', 'grupo' => 'D'],
            ['clave' => 'DDP', 'descripcion' => 'Entregada derechos pagados', 'grupo' => 'D'],
            ['clave' => 'DPU', 'descripcion' => 'Entregada y descargada en el lugar acordado', 'grupo' => 'D'],
            ['clave' => 'EXW', 'descripcion' => 'En fábrica (lugar convenido)', 'grupo' => 'E'],
            ['clave' => 'FCA', 'descripcion' => 'Franco transportista (lugar designado)', 'grupo' => 'F'],
            ['clave' => 'FAS', 'descripcion' => 'Franco al costado del buque', 'grupo' => 'F'],
            ['clave' => 'FOB', 'descripcion' => 'Franco a bordo (puerto de carga convenido)', 'grupo' => 'F'],
        ]);
    }

    // ===================== APÉNDICE 15 =====================
    private function seedDestinos(): void
    {
        $this->insert('cat_destinos', [
            ['clave' => '1',  'descripcion' => 'Estado de Baja California y parcial de Sonora'],
            ['clave' => '2',  'descripcion' => 'Estado de Baja California Sur'],
            ['clave' => '3',  'descripcion' => 'Estado de Quintana Roo'],
            ['clave' => '5',  'descripcion' => 'Municipio de Salina Cruz, Oaxaca'],
            ['clave' => '6',  'descripcion' => 'Municipio de Cananea, Sonora'],
            ['clave' => '7',  'descripcion' => 'Franja Fronteriza Norte'],
            ['clave' => '8',  'descripcion' => 'Franja Fronteriza Sur, Colindante con Guatemala'],
            ['clave' => '9',  'descripcion' => 'Interior del País'],
            ['clave' => '10', 'descripcion' => 'Municipio de Caborca, Sonora'],
            ['clave' => '11', 'descripcion' => 'Región Fronteriza de Chetumal'],
            ['clave' => '12', 'descripcion' => 'Zona libre de Chetumal'],
        ]);
    }

    // ===================== APÉNDICE 16 =====================
    private function seedRegimenes(): void
    {
        $this->insert('cat_regimenes', [
            ['clave' => 'IMD', 'descripcion' => 'Definitivo de importación'],
            ['clave' => 'EXD', 'descripcion' => 'Definitivo de exportación'],
            ['clave' => 'ITR', 'descripcion' => 'Temporales de importación para retornar al extranjero en el mismo estado'],
            ['clave' => 'ITE', 'descripcion' => 'Temporales de importación para elaboración, transformación o reparación (IMMEX)'],
            ['clave' => 'ETR', 'descripcion' => 'Temporales de exportación para retornar al país en el mismo estado'],
            ['clave' => 'ETE', 'descripcion' => 'Temporales de exportación para elaboración, transformación o reparación'],
            ['clave' => 'DFI', 'descripcion' => 'Depósito fiscal'],
            ['clave' => 'RFE', 'descripcion' => 'Elaboración, transformación o reparación en recinto fiscalizado'],
            ['clave' => 'TRA', 'descripcion' => 'Tránsitos'],
            ['clave' => 'RFS', 'descripcion' => 'Recinto fiscalizado estratégico'],
        ]);
    }

    // ===================== APÉNDICE 18 =====================
    private function seedTiposTasa(): void
    {
        $this->insert('cat_tipos_tasa', [
            ['clave' => '1',  'descripcion' => 'Porcentual'],
            ['clave' => '2',  'descripcion' => 'Específico'],
            ['clave' => '3',  'descripcion' => 'Cuota mínima (DTA)'],
            ['clave' => '4',  'descripcion' => 'Cuota fija'],
            ['clave' => '5',  'descripcion' => 'Tasa de descuento sobre ad valorem'],
            ['clave' => '6',  'descripcion' => 'Factor de aplicación sobre TIGIE'],
            ['clave' => '7',  'descripcion' => 'Al millar (DTA)'],
            ['clave' => '8',  'descripcion' => 'Tasa de descuento sobre el arancel específico'],
            ['clave' => '9',  'descripcion' => 'Tasa específica sobre precios de referencia'],
            ['clave' => '10', 'descripcion' => 'Tasa específica sobre precios de referencia con UM'],
        ]);
    }

    // ===================== APÉNDICE 10 =====================
    private function seedContenedores(): void
    {
        $this->insert('cat_contenedores', [
            ['clave' => '1',  'descripcion' => 'Contenedor estándar 20\''],
            ['clave' => '2',  'descripcion' => 'Contenedor estándar 40\''],
            ['clave' => '3',  'descripcion' => 'Contenedor estándar de cubo alto 40\''],
            ['clave' => '15', 'descripcion' => 'Contenedor refrigerante 20\''],
            ['clave' => '16', 'descripcion' => 'Contenedor refrigerante 40\''],
            ['clave' => '17', 'descripcion' => 'Contenedor refrigerante cubo alto 40\''],
            ['clave' => '19', 'descripcion' => 'Contenedor tipo tanque 20\''],
            ['clave' => '60', 'descripcion' => 'Otros'],
            ['clave' => '65', 'descripcion' => 'Automóvil'],
            ['clave' => '69', 'descripcion' => 'Tractocamión'],
        ]);
    }

    // ===================== APÉNDICE 19 =====================
    private function seedSustanciasPeligrosas(): void
    {
        $this->insert('cat_sustancias_peligrosas', [
            ['clave' => '1', 'descripcion' => 'Explosivos'],
            ['clave' => '2', 'descripcion' => 'Gases comprimidos, refrigerados, licuados o disueltos a presión'],
            ['clave' => '3', 'descripcion' => 'Líquidos inflamables'],
            ['clave' => '4', 'descripcion' => 'Sólidos inflamables'],
            ['clave' => '5', 'descripcion' => 'Oxidantes y peróxidos orgánicos'],
            ['clave' => '6', 'descripcion' => 'Tóxicos agudos (venenos) y agentes infecciosos'],
            ['clave' => '7', 'descripcion' => 'Radiactivos'],
            ['clave' => '8', 'descripcion' => 'Corrosivos'],
            ['clave' => '9', 'descripcion' => 'Varios'],
        ]);
    }

    // ===================== APÉNDICE 8 (Identificadores - extracto principal) =====================
    private function seedIdentificadores(): void
    {
        $this->insert('cat_identificadores', [
            ['clave' => 'AC', 'descripcion' => 'Autorización de la Secretaría de Economía', 'nivel' => 'P'],
            ['clave' => 'AF', 'descripcion' => 'Importación temporal de activo fijo (IMMEX)', 'nivel' => 'P'],
            ['clave' => 'CF', 'descripcion' => 'Número de CFDI o documento equivalente', 'nivel' => 'G'],
            ['clave' => 'IM', 'descripcion' => 'Programa IMMEX', 'nivel' => 'G'],
            ['clave' => 'IN', 'descripcion' => 'Importación temporal de insumos (IMMEX)', 'nivel' => 'P'],
            ['clave' => 'TL', 'descripcion' => 'Mercancía originaria al amparo de Tratados de Libre Comercio', 'nivel' => 'P'],
            ['clave' => 'XP', 'descripcion' => 'Excepción al cumplimiento de regulaciones y restricciones no arancelarias', 'nivel' => 'P'],
        ]);
    }

    // ===================== APÉNDICE 9 (Restricciones - extracto) =====================
    private function seedRestricciones(): void
    {
        $this->insert('cat_restricciones', [
            ['secretaria' => 'Secretaría de Economía', 'clave' => 'CP', 'descripcion' => 'Certificado de cupo'],
            ['secretaria' => 'Secretaría de Economía', 'clave' => 'C1', 'descripcion' => 'Permiso previo o automático para importación'],
            ['secretaria' => 'Secretaría de Economía', 'clave' => 'NM', 'descripcion' => 'Número de certificado NOM'],
            ['secretaria' => 'Secretaría de Salud', 'clave' => 'S1', 'descripcion' => 'Autorización sanitaria previa de importación'],
            ['secretaria' => 'Secretaría de Salud', 'clave' => 'S2', 'descripcion' => 'Aviso sanitario de importación'],
            ['secretaria' => 'SEMARNAT', 'clave' => 'T1', 'descripcion' => 'Certificado CITES o autorización de importación'],
            ['secretaria' => 'SEDENA', 'clave' => 'D1', 'descripcion' => 'Autorización para importación/exportación de armas y explosivos'],
        ]);
    }
}
