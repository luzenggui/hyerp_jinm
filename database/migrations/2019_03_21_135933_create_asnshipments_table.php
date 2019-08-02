<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsnshipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asnshipments', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('asn_id')->unsigned();
//            $table->integer('hierarchical_id_number');
//            $table->integer('hierarchical_parent_id_number');
//            $table->string('hierarchical_level_code');      // 'S': Shipment
//            $table->string('packaging_code');
//            $table->integer('lading_quantity');             // Overall Total
//            $table->string('weight_qualifier');             // 'G': Gross
            $table->decimal('gross_weight', 18, 3)->nullable();
            $table->string('gross_unit')->nullable();                         // 'LB': Pound; 'KG': Kilogram; LT: 2 or 3 digits; TAL: 2 digits
            $table->string('transportation_type_code');     // A: Air; S: Sea; L: Land
            $table->string('ref_bm_identification')->nullable();               // for REF 'BM'
//            $table->string('ref_v3_identification');
            $table->string('ref_va_identification')->nullable();
            $table->string('ship_mode');                    // ‘CONSOLIDATION WAREHOUSE’ or  ‘DIRECT SHIPMENT’
            $table->date('ship_date');
            $table->date('delivery_date');
            $table->date('estimated_arrival_date');
            $table->string('shipper_name')->nullable();
//            $table->string('shipper_code');
//            $table->string('shipper_address1');
//            $table->string('shipper_address2');
            $table->string('country_of_origin')->nullable();        // Country of Origin, ISO Country Code. LTG : 2 digits ISO code; TAL : 3 digits ISO code
            $table->string('country_of_destination')->nullable();        // Country of Origin, ISO Country Code. LTG : 2 digits ISO code; TAL : 3 digits ISO code

            $table->timestamps();

            $table->foreign('asn_id')->references('id')->on('asns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asnshipments');
    }
}
