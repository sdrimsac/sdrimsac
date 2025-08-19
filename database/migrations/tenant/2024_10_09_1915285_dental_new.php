<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//2024_10_09_1915284_add_code_item_color_sizes
class DentalNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id');
            $table->unsignedInteger('medic_id');
            $table->date('date');
            $table->string('time');
            $table->decimal('price', 12, 2);
            $table->string('state');
            $table->string('reason_consultation')->nullable();
            $table->string('observation')->nullable();
            $table->timestamps();
            $table->foreign('patient_id')->references('id')->on('persons');
            $table->foreign('medic_id')->references('id')->on('persons');
        });

        Schema::create('specialties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('state')->default('Activo')->nullable();
            $table->timestamps();
        });

        Schema::create('tariffs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('process');
            $table->unsignedInteger('category_id');
            $table->decimal('price', 12, 2);
            $table->string('measure')->nullable();
            $table->string('type_concept')->nullable();
            $table->string('state')->default(true);
            $table->decimal('discount', 12, 2);
            $table->string('code')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
        });

        Schema::create('diagnoses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cie10');
            $table->string('description');
            $table->string('state');
            $table->timestamps();
        });

        Schema::create('disease_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('active',2);
            $table->timestamps();
        });

        Schema::create('diseases', function (Blueprint $table) {
            $table->increments('id');
            $table->text('consultation_reason');          //motivo consulta 
            $table->text('signs_symptoms');               //signos síntomas
            $table->text('personal_background');          //experiencia personal
            $table->text('family_background');            //trasfondo familiar
            $table->boolean('medicine');
            $table->text('medicine_name'); 
            $table->text('medicine_reason'); 
            $table->text('medicine_dose'); 
            $table->unsignedInteger('disease_type_id');      //relacion tabla tipo enfermedades
            $table->unsignedInteger('patient_id');         //relacion tabla paciente
            $table->timestamps();
        });

        Schema::create('consultations', function (Blueprint $table) {
            $table->increments('id');
            $table->text('orthodontics');          
            $table->text('medicine');              
            $table->text('allergy');         
            $table->text('hospital_surgery');            
            $table->text('disorder');
            $table->text('brush_teeth'); 
            $table->text('high_pressure'); 
            $table->unsignedInteger('disease_type_id');  
            $table->unsignedInteger('patient_id');
            $table->timestamps();
        });

        Schema::create('physical_exploration', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('blood_pressure');          
            $table->integer('pulse');              
            $table->integer('temperature');         
            $table->integer('heart_rate');
            $table->integer('respiratory_rate'); 
            $table->integer('weight'); 
            $table->integer('height'); 
            $table->integer('imc'); 
            $table->text('general_clinical_examination'); 
            $table->text('complementary_examination'); 
            $table->text('odontostomatological'); 
            $table->unsignedInteger('patient_id');
            $table->timestamps();
        });

        Schema::create('allergies_types', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description'); 
            $table->boolean('active'); 
            $table->timestamps();
        });

        Schema::create('allergies', function (Blueprint $table) {
            $table->increments('id');
            $table->text('observation'); 
            $table->unsignedInteger('allergies_types_id');
            $table->unsignedInteger('patient_id');
            $table->timestamps();
        });

        Schema::create('diagnosis_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('CIE10', 5);
            $table->text('description');             
            $table->timestamps();
        });

        Schema::create('diagnosis', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('diagnosis_types_id'); 
            $table->date('date');          
            $table->unsignedInteger('patient_id'); 
            $table->timestamps();
        });

        Schema::create('evolution', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('patient_id');  
            $table->unsignedInteger('medic_id');
            $table->date('date');          
            $table->text('observation');              
            $table->timestamps();
        });

        Schema::create('odontogram', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('patient_id');
            $table->integer('tooth');
            $table->text('data');
            $table->timestamps();
            $table->foreign('patient_id')->references('id')->on('persons');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('odontogram');
        Schema::dropIfExists('evolution');
        Schema::dropIfExists('diagnosis');
        Schema::dropIfExists('diagnosis_types');
        Schema::dropIfExists('allergies');
        Schema::dropIfExists('allergies_types');
        Schema::dropIfExists('physical_exploration');
        Schema::dropIfExists('consultations');
        Schema::dropIfExists('diseases');
        Schema::dropIfExists('disease_types');
        Schema::dropIfExists('tariffs');
        Schema::dropIfExists('specialties');
        Schema::dropIfExists('diagnoses');
        Schema::dropIfExists('quotes');

    }
}
